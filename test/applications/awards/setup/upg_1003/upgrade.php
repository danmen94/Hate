<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

namespace IPS\awards\setup\upg_1003;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
    header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
    exit;
}

/**
 * 1.0.3 Upgrade Code
 */
class _Upgrade
{
    /**
     * ...
     * @return    array    If returns TRUE, upgrader will proceed to next step. If it returns any other value, it will set this as the value of the 'extra' GET parameter and rerun this step (useful for loops)
     */
    public function step1()
    {
        $rows = \IPS\Db::i()->select( 'awards_awarded.awarded_id,awards_awarded.awarded_award,awards_awarded.awarded_show,awards_awarded.awarded_cat,awards_awarded.awarded_title', 'awards_awarded', array(), NULL, NULL, NULL, NULL, \IPS\Db::SELECT_SQL_CALC_FOUND_ROWS )->setKeyField( 'awarded_id' );

        $awards = iterator_to_array( $rows );

        foreach ( $awards as $rows )
        {

            $award = \IPS\awards\Awards::load( $rows['awarded_award'] );

            if ( $award['pane'] )
            {
                \IPS\Db::i()->update( 'awards_awarded', array( 'awarded_show' => "awards", 'awarded_title' => $award['title'], 'awarded_cat' => $award['cat'] ), array( 'awarded_id=?', $rows['award_id'] ) );

            } else
            {
                \IPS\Db::i()->update( 'awards_awarded', array( 'awarded_show' => "achievements", 'awarded_title' => $award['title'], 'awarded_cat' => $award['cat'] ), array( 'awarded_id=?', $rows['awarded_id'] ) );
            }

        }

        \IPS\Db::i()->delete( 'core_sys_conf_settings', array( 'conf_key=?', "award_settings_total" ) );
        \IPS\Db::i()->delete( 'core_sys_conf_settings', array( 'conf_key=?', "award_settings_style" ) );

        return TRUE;
    }
}