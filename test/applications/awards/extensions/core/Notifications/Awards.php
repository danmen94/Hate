<?php
/**
 * @package        iAwards
 * @author        <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

namespace IPS\awards\extensions\core\Notifications;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
    header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
    exit;
}

/**
 * Class _Awards
 * @package IPS\awards\extensions\core\Notifications
 */
class _Awards
{
    /**
     * @param $member
     * @return array
     */
    public function getConfiguration( $member )
    {
        return array(
            'award_member' => array( 'default' => array( 'inline' ), 'disabled' => array() ),
        );
    }

    /**
     * @param \IPS\Notification\Inline $notification
     * @return array
     */
    public function parse_award_member( \IPS\Notification\Inline $notification )
    {
        $item = $notification->item;

        $member = \IPS\Member::load( $item->member );
        $giver  = \IPS\Member::load( $notification->extra['giver'] );

        return array(
            'title'  => \IPS\Member::loggedIn()->language()->addToStack( 'award_title_default', FALSE, array( 'sprintf' => array( $giver->name, $notification->extra['award'] ) ) ),
            'url'    => $member->url()->setQueryString( "tab", 'node_awards_Awards' ),
            'author' => \IPS\Member::load( $notification->extra['giver'] ),
        );
    }
}