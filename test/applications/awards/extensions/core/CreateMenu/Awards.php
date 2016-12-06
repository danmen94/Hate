<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2016 Invisionizer
 */

namespace IPS\awards\extensions\core\CreateMenu;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
    header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
    exit;
}

/**
 * Class _Awards
 * @package IPS\awards\extensions\core\CreateMenu
 */
class _Awards
{
    /**
     * @return array
     */
    public function getItems()
    {
        if ( \IPS\awards\Cats::canOnAny( 'add' ) )
        {
            return array(
                'award_add' => array(
                    'link'         => \IPS\Http\Url::internal( 'app=awards&module=awards&controller=ajaxcreate', 'front' ),
                    'title'        => 'award_add',
                    'flashMessage' => 'saved',
                    'extraData'    => array( 'data-ipsdialog-remotesubmit' => TRUE, 'data-ipsDialog' => TRUE )
                )
            );
        } else
        {
            return array();
        }

    }
}