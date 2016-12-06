<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2016 Invisionizer
 */

namespace IPS\awards\extensions\core\EditorLocations;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
    header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
    exit;
}

/**
 * Class _Awards
 * @package IPS\awards\extensions\core\EditorLocations
 */
class _Awards
{
    /**
     * @param $member
     * @return null
     */
    public function canUseHtml( $member )
    {
        return NULL;
    }

    /**
     * @param $member
     * @param $field
     * @return null
     */
    public function canAttach( $member, $field )
    {
        return NULL;
    }

    /**
     * @param $member
     * @param $id1
     * @param $id2
     * @param $id3
     * @param $attachment
     * @return bool
     */
    public function attachmentPermissionCheck( $member, $id1, $id2, $id3, $attachment )
    {
        return TRUE;
    }

    /**
     * @param $id1
     * @param $id2
     * @param $id3
     */
    public function attachmentLookup( $id1, $id2, $id3 )
    {
        return \IPS\awards\Cats::load( $id1 );
    }
}