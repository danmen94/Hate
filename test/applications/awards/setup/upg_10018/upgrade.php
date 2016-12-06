<?php


namespace IPS\awards\setup\upg_10018;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * {version_human} Upgrade Code
 */
class _Upgrade
{
	/**
	 * ...
	 *
	 * @return	array	If returns TRUE, upgrader will proceed to next step. If it returns any other value, it will set this as the value of the 'extra' GET parameter and rerun this step (useful for loops)
	 */
	public function step1()
	{
		if( !\IPS\Db::i()->checkForColumn( 'awards_cats', 'cat_name_seo' ) )
		{
			\IPS\Db::i()->addColumn( 'cat_name_seo', array(
				'name'			=> 'awards_cats',
				'type'			=> 'varchar',
				'length'		=> 255,
				'allow_null'	=> true,
				'default'		=> ''
			) );
		}

		if( !\IPS\Db::i()->checkForColumn( 'awards_cats', 'cat_desc' ) )
		{
			\IPS\Db::i()->addColumn( 'cat_desc', array(
				'name'			=> 'awards_cats',
				'type'			=> 'text',
				'allow_null'	=> true,
				'default'		=> ''
			) );
		}

		if( !\IPS\Db::i()->checkForColumn( 'awards_cats', 'cat_icon' ) )
		{
			\IPS\Db::i()->addColumn( 'cat_icon', array(
				'name'			=> 'awards_cats',
				'type'			=> 'varchar',
				'length'		=> 255,
				'allow_null'	=> true,
				'default'		=> ''
			) );
		}

		$perCycle	= 10;
		$did		= 0;
		$limit		= intval( \IPS\Request::i()->extra );
		$cutOff		= \IPS\core\Setup\Upgrade::determineCutoff();

		foreach( \IPS\Db::i()->select( '*', 'awards_cats', array(), null, array( $limit, $perCycle ) ) as $cat )
		{
			if( $cutOff !== null AND time() >= $cutOff )
			{
				return ( $limit + $did );
			}
			$did++;

			\IPS\Db::i()->update( 'awards_cats', array( 'cat_name_seo' => \IPS\Http\Url\Friendly::seoTitle( $row['cat_title']  ) ) );
		}

		if( $did )
		{
			return ( $limit + $did );
		}
		else
		{

			return TRUE;
		}


		return TRUE;
	}
	
	// You can create as many additional methods (step2, step3, etc.) as is necessary.
	// Each step will be executed in a new HTTP request
}