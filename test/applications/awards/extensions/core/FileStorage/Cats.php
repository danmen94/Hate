<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2016 Invisionizer
 */

namespace IPS\awards\extensions\core\FileStorage;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * File Storage Extension: Cats
 */
class _Cats
{
	/**
	 * @return mixed
	 */
	public function count()
	{
		return \IPS\Db::i()->select( 'COUNT(*)', 'awards_cats' )->first();
	}

	/**
	 * @param $offset
	 * @param $storageConfiguration
	 * @param null $oldConfiguration
	 */
	public function move( $offset, $storageConfiguration, $oldConfiguration=NULL )
	{
		$record = \IPS\Db::i()->select( '*', 'awards_cats', array(), 'cat_id', array( $offset, 1 ) )->first();

		try
		{
			$file = \IPS\File::get( $oldConfiguration ?: 'awards_Cats', $record['cat_icon'] )->move( $storageConfiguration );

			if ( (string) $file != $record['cat_icon'] )
			{
				\IPS\Db::i()->update( 'awards_cats', array( 'cat_icon' => (string) $file ), array( 'cat_id=?', $record['cat_id'] ) );
			}
		}
		catch( \Exception $e ) {}
	}

	/**
	 * @param $file
	 *
	 * @return bool
	 */
	public function isValidFile( $file )
	{
		try
		{
			$record	= \IPS\Db::i()->select( '*', 'awards_cats', array( 'cat_icon = ?', (string) $file ) )->first();

			return TRUE;
		}
		catch ( \UnderflowException $e )
		{
			return FALSE;
		}
	}

	/**
	 * Delete
	 */
	public function delete()
	{
		foreach( \IPS\Db::i()->select( '*', 'awards_cats' ) as $file )
		{
			try
			{
				\IPS\File::get( 'awards_Cats', $file['cat_icon'] )->delete();
			}
			catch( \Exception $e ){}
		}
	}
}