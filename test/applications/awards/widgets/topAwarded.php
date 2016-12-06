<?php
/**
 * @package        iAwards
 * @author        <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

namespace IPS\awards\widgets;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
    header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
    exit;
}

/**
 * topAwarded Widget
 */
class _topAwarded extends \IPS\Widget\PermissionCache
{
    /**
     * @brief    Widget Key
     */
    public $key = 'topAwarded';

    /**
     * @brief    App
     */
    public $app = 'awards';

    /**
     * @brief    Plugin
     */
    public $plugin = '';

    /**
     * Initialise this widget
     * @return void
     */
    public function init()
    {

        parent::init();
    }

    /**
     * Specify widget configuration
     * @param    null|\IPS\Helpers\Form $form Form object
     * @return    null|\IPS\Helpers\Form
     */
    public function configuration( &$form = NULL )
    {
        if ( $form === NULL )
        {
            $form = new \IPS\Helpers\Form;
        }

        $form->add( new \IPS\Helpers\Form\Number( 'awarded_number_to_show', isset( $this->configuration['awarded_number_to_show'] ) ? $this->configuration['awarded_number_to_show'] : 5, TRUE, array( 'max' => 25 ) ) );

        return $form;
    }

    /**
     * Ran before saving widget configuration
     * @param    array $values Values from form
     * @return    array
     */
    public function preConfig( $values )
    {
        return $values;
    }

    /**
     * Render a widget
     * @return    string
     */
    public function render()
    {
        /* How many? */
        $limit = isset( $this->configuration['awarded_number_to_show'] ) ? $this->configuration['awarded_number_to_show'] : 5;

        $where[]            = array( 'awarded_date>?', \IPS\DateTime::create()->sub( new \DateInterval( 'P1W' ) )->getTimestamp() );
        $topAwardedThisWeek = iterator_to_array( \IPS\Db::i()->select( 'awards_awarded.awarded_member as member, COUNT(awarded_id) as awarded', 'awards_awarded', $where, 'awarded DESC', $limit, 'member' )->setKeyField( 'member' )->setValueField( 'awarded' ) );

        arsort( $topAwardedThisWeek );
        $topAwardedThisWeek = array_slice( $topAwardedThisWeek, 0, $limit, TRUE );

        /* Load their data */
        foreach ( \IPS\Db::i()->select( '*', 'core_members', \IPS\Db::i()->in( 'member_id', array_keys( $topAwardedThisWeek ) ) ) as $member )
        {
            \IPS\Member::constructFromData( $member );
        }

        /* Display */
        if ( \IPS\Member::loggedIn()->canAccessModule( \IPS\Application\Module::get( 'awards', 'awards' ) ) )
        {
            return $this->output( $topAwardedThisWeek, $limit );
        } else
        {
            return '';
        }
    }
}