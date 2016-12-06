<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

namespace IPS\awards\modules\admin\awards;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
    header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
    exit;
}

/**
 * Class _manage
 * @package IPS\awards\modules\admin\awards
 */
class _manage extends \IPS\Node\Controller
{
    /**
     * Node Class
     */
    protected $nodeClass = 'IPS\awards\Cats';

    /**
     * Execute
     * @return    void
     */
    public function execute()
    {
        //\IPS\Dispatcher::i()->checkAcpPermission( 'cats_manage' );

        parent::execute();
    }

    /**
     * Manage member awards
     */
    protected function manageMembers()
    {
        $item = \IPS\awards\Awards::load( \IPS\Request::i()->id );

        \IPS\Output::i()->title = \IPS\Member::loggedIn()->language()->addToStack( 'award_title_manage', FALSE, array( 'sprintf' => array( $item->title ) ) );

        $url = \IPS\Http\Url::internal( 'app=awards&module=awards&controller=manage&do=manageMembers&subnode=1&id=' . $item->id );

        $where = array( 'awarded_award = ?', $item->id );

        $table = new \IPS\Helpers\Table\Db( 'awards_awarded', $url, $where );

        $table->include       = array( 'photo', 'name', 'date' );
        $table->mainColumn    = 'name';
        $table->sortBy        = ( \IPS\Request::i()->sortby ) ? \IPS\Request::i()->sortby: 'date';
        $table->sortDirection = 'DESC';
        $table->langPrefix    = 'awarded_';

        $table->parsers = array(
            'photo' => function ( $val, $row )
            {
                return \IPS\Theme::i()->getTemplate( 'global', 'core' )->userPhoto( \IPS\Member::constructFromData( $row ), 'mini' );
            },
            'name'  => function ( $val, $row )
            {
                return "<a href='" . \IPS\Http\Url::internal( 'app=core&module=members&controller=members&do=edit&id=' ) . $row['member_id'] . "'>" . htmlentities( $val, \IPS\HTMLENTITIES, 'UTF-8', FALSE ) . "</a>";
            },
            'date'  => function ( $val, $row )
            {
                $date = \IPS\DateTime::ts( $row['awarded_date'] );

                return $date->localeDate() . ' ' . $date->localeTime( FALSE );
            },
        );

        $table->joins = array(
            array(
                'select' => 'core_members.*',
                'from'   => 'core_members',
                'where'  => 'core_members.member_id=awards_awarded.awarded_member'
            ),
        );

        $table->rowButtons = function ( $row )
        {
            $return['edit'] = array(
                'icon'  => 'pencil',
                'title' => 'award_member_edit',
                'link'  => \IPS\Http\Url::internal( 'app=awards&module=awards&controller=manage&do=edit&subnode=1' . '&id=' . $row['awarded_id'] . '&award=' . $row['awarded_award'] ),
            );

            $return['delete'] = array(
                'icon'  => 'times-circle',
                'title' => 'award_member_delete',
                'link'  => \IPS\Http\Url::internal( 'app=awards&module=awards&controller=manage&do=remove&subnode=1' . '&id=' . $row['awarded_id'] . '&award=' . $row['awarded_award'] ),
            );

            return $return;
        };

        $table->rootButtons = array(
            'add' => array(
                'icon'  => 'plus',
                'title' => 'award_member',
                'link'  => \IPS\Http\Url::internal( 'app=awards&module=awards&controller=manage&do=addAward&subnode=1' . '&id=' . $item->id ),
                'data'  => array( 'ipsDialog' => '', 'ipsDialog-title' => \IPS\Member::loggedIn()->language()->addToStack( 'award_member' ) )
            ),
        );

        \IPS\Output::i()->output .= \IPS\Theme::i()->getTemplate( 'global' )->block( 'groups', (string) $table );
    }

    /**
     * Add award
     */
    protected function addAward()
    {
        \IPS\Output::i()->title = \IPS\Member::loggedIn()->language()->addToStack( 'award_title_add' );

        try
        {
            $award = \IPS\awards\Awards::load( \IPS\Request::i()->id );
        }
        catch( \OutOfRangeException $e ){ }

        $form = new \IPS\Helpers\Form;

        $form->add( new \IPS\Helpers\Form\Member( 'awarded_member', NULL, FALSE, array(), NULL, NULL, NULL, 'awarded_member_add' ) );

        if ( $award->options == "manual" )
        {
            $form->add( new \IPS\Helpers\Form\Editor( 'awarded_reason', $this->id ? $award->reason : NULL, FALSE, array( 'app' => 'awards', 'key' => 'Awards', 'autoSaveKey' => 'awards-new-reason', 'attachIds' => ( $this->id === NULL ? NULL : array( $this->id ) ) ), NULL, NULL, NULL, 'reason_show' ) );
        }

        if ( $values = $form->values() )
        {
            $member = \IPS\Member::load( $values['awarded_member']->member_id );
            $giver  = \IPS\Member::load( \IPS\Member::loggedIn()->member_id );
            $reason = $values['awarded_reason'];

            if ( $award->can( 'self', $member ) AND !$award->can( 'add', $member ) AND $giver->member_id != $member->member_id )
            {
                throw new \Exception(  \IPS\Member::loggedIn()->language()->get( 'awards_others_err' ) );
            }

            if ( $award->can( 'add', $member ) AND !$award->can( 'self', $member ) AND $giver->member_id == $member->member_id )
            {
                throw new \Exception(  \IPS\Member::loggedIn()->language()->get( 'awards_self_err' ) );
            }

            if( $award->obtainable_enabled AND $award->obtainable )
            {
                throw new \Exception( \IPS\Member::loggedIn()->language()->get( 'awards_obtainable_err' ) );
            }

            try
            {
                $award->awardTo( $member, $award, $giver, $reason );
            } catch ( \Exception $e )
            {
                \IPS\Output::i()->error( $e->getMessage(), '1A19/1', 403, '' );
            }

            \IPS\Output::i()->redirect( \IPS\Http\Url::internal( 'app=awards&module=awards&controller=manage&do=manageMembers&subnode=1' . '&id=' . \IPS\Request::i()->id ), 'awarded_added' );

        }

        \IPS\Output::i()->output = $form;
    }


    /**
     * Edit awarded member
     */
    protected function edit()
    {
        \IPS\Output::i()->title = \IPS\Member::loggedIn()->language()->addToStack( 'award_title_edit_awarded' );

        try
        {
            $awarded = \IPS\awards\Awarded::load( \IPS\Request::i()->id );

        } catch ( \UnderflowException $e ){}

        $form = new \IPS\Helpers\Form;

        $form->add( new \IPS\Helpers\Form\Editor( 'awarded_reason', $awarded->reason ? $awarded->reason : NULL, FALSE, array( 'app' => 'awards', 'key' => 'Awards', 'autoSaveKey' => 'awards-new-reason', 'attachIds' => ( $this->id === NULL ? NULL : array( $this->id ) ) ), NULL, NULL, NULL, 'reason_show' ) );

        if ( $values = $form->values() )
        {

            $awarded->reason = $values['awarded_reason'];
            $awarded->save();

            \IPS\Output::i()->redirect( \IPS\Http\Url::internal( 'app=awards&module=awards&controller=manage&do=manageMembers&subnode=1' . '&id=' . \IPS\Request::i()->award ), 'awarded_updated' );

        }

        \IPS\Output::i()->output = $form;

    }

    /**
     * Remove award from member
     */
    protected function remove()
    {
        \IPS\Output::i()->title = \IPS\Member::loggedIn()->language()->addToStack( 'award_title_remove' );

        $form = new \IPS\Helpers\Form;

        $form->add( new \IPS\Helpers\Form\TextArea( 'award_removed_reason', NULL, TRUE, array() ) );

        if ( $values = $form->values() )
        {
            try{
                $remove = \IPS\awards\Awarded::load( \IPS\Request::i()->id );
                $remove->remove( $values['award_removed_reason'], \IPS\Member::loggedIn() );

            } catch ( \UnderflowException $e ){}

            \IPS\Output::i()->redirect( \IPS\Http\Url::internal( 'app=awards&module=awards&controller=manage&do=manageMembers&subnode=1' . '&id=' . \IPS\Request::i()->award ), 'awarded_removed' );
        }

        \IPS\Output::i()->output = $form;
    }
}
