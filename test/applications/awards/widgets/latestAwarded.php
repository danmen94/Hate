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
 * latestAwarded Widget
 */
class _latestAwarded extends \IPS\Widget
{
    /**
     * @brief    Widget Key
     */
    public $key = 'latestAwarded';

    /**
     * @brief    App
     */
    public $app = 'awards';

    /**
     * @brief    Plugin
     */
    public $plugin = '';

    protected static $containerNodeClass = 'IPS\awards\Awards';

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

        $form->add( new \IPS\Helpers\Form\Number( 'latest_awarded_to_show', isset( $this->configuration['latest_awarded_to_show'] ) ? $this->configuration['latest_awarded_to_show'] : 5, TRUE, array( 'max' => 25 ) ) );

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
        $limit = isset( $this->configuration['latest_awarded_to_show'] ) ? $this->configuration['latest_awarded_to_show'] : 5;

        $member  = \IPS\Member::load( \IPS\Member::loggedIn()->member_id );
        $awarded = \IPS\awards\Awarded::getItemsWithPermission( array(), "awarded_date desc", $limit, NULL, NULL, 0, $member, TRUE, FALSE, FALSE, FALSE, NULL, FALSE, TRUE, TRUE, TRUE, FALSE );

        return $this->output( $awarded );
        //return '';
    }
}