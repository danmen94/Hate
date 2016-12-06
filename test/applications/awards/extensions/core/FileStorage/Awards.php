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

class _Awards
{
    /**
     * @return mixed
     */
    public function count()
    {
        return \IPS\Db::i()->select( 'COUNT(*)', 'awards_awards' )->first();
    }

    /**
     * @param $offset
     * @param $storageConfiguration
     * @param null $oldConfiguration
     */
    public function move( $offset, $storageConfiguration, $oldConfiguration = NULL )
    {
        $record = \IPS\Db::i()->select( '*', 'awards_awards', array(), 'award_id', array( $offset, 1 ) )->first();

        try
        {
            $file = \IPS\File::get( $oldConfiguration ?: 'awards_Awards', $record['award_icon'] )->move( $storageConfiguration );

            if ( (string) $file != $record['award_icon'] )
            {
                \IPS\Db::i()->update( 'awards_awards', array( 'award_icon' => (string) $file ), array( 'award_id=?', $record['award_id'] ) );
            }
        }
        catch( \Exception $e ) {}
    }

    /**
     * @param $offset
     */
    public function fixUrls( $offset )
    {
        $record = \IPS\Db::i()->select( '*', 'awards_awards', array(), 'award_id', array( $offset, 1 ) )->first();

        if ( $new = \IPS\File::repairUrl( $record['award_icon'] ) )
        {
            \IPS\Db::i()->update( 'awards_awards', array( 'record_location' => $new ), array( 'award_id=?', $record['award_id'] ) );
        }
    }

    /**
     * @param $file
     * @return bool
     */
    public function isValidFile( $file )
    {
        try
        {
            $record	= \IPS\Db::i()->select( '*', 'awards_awards', array( 'award_icon = ?', (string) $file ) )->first();

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
        foreach( \IPS\Db::i()->select( '*', 'awards_awards' ) as $file )
        {
            try
            {
                \IPS\File::get( 'awards_Awards', $file['award_icon'] )->delete();
            }
            catch( \Exception $e ){}
        }
    }
}