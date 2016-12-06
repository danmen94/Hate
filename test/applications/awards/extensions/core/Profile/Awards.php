<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2016 Invisionizer
 */

namespace IPS\awards\extensions\core\Profile;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
    header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
    exit;
}

/**
 * Class _Awards
 * @package IPS\awards\extensions\core\Profile
 */
class _Awards
{

    /**
     * @var string
     */
    protected static $containerNodeClass = 'IPS\awards\Awards';

    /**
     * @var \IPS\Member
     */
    protected $member;

    /**
     * @param \IPS\Member $member
     */
    public function __construct( \IPS\Member $member )
    {
        $this->member = $member;
    }

    /**
     * @return bool
     */
    public function showTab()
    {
        if ( !\IPS\Application::appIsEnabled( 'awards' ) )
        {
            return FALSE;
        }

        if ( !\IPS\Member::loggedIn()->canAccessModule( \IPS\Application\Module::get( 'awards', 'awards' ) ) )
        {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * @return mixed
     */
    public function render()
    {
        if( $this->member->award_member_show != null )
        {
            $where[] = array( 'awarded_member = ? AND awarded_award NOT IN (?)', $this->member->member_id, $this->member->award_member_show  );
        }
        else
        {
            $where[] = array( 'awarded_member = ?', $this->member->member_id  );
        }

        $table = new \IPS\Helpers\Table\Content( 'IPS\awards\Awarded', \IPS\Http\Url::internal( "app=core&module=members&controller=profile&id={$this->member->member_id}&tab=node_awards_Awards", null, 'profile', $this->member->members_seo_name ), $where, null, NULL, 'view' );

        $table->tableTemplate = array( \IPS\Theme::i()->getTemplate( 'profile', 'awards', 'front' ), 'table' );
        $table->rowsTemplate  = array( \IPS\Theme::i()->getTemplate( 'profile', 'awards', 'front' ), 'rows' );

        $table->sortBy        = $this->member->award_sort;
        $table->sortDirection = $this->member->award_order;

        return \IPS\Theme::i()->getTemplate( 'profile', 'awards', 'front' )->awards( (string) $table, $this->member );

    }
}