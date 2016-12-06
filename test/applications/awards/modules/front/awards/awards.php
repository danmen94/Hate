<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

namespace IPS\awards\modules\front\awards;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
    header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
    exit;
}

/**
 * Class _awards
 * @package IPS\awards\modules\front\awards
 */
class _awards extends \IPS\Dispatcher\Controller
{
    public function execute()
    {
        parent::execute();
    }

    protected function manage()
    {
        try
        {
            $cat = \IPS\awards\Cats::load( \IPS\Request::i()->id );

        } catch ( \OutOfRangeException $e ) {}

        $where[] = array( 'award_cat_id = ?', $cat->id );

        $table = new \IPS\Helpers\Table\Db( 'awards_awards', \IPS\Http\Url::internal( "app=awards&module=awards&controller=awards&id=" . $cat->id ), $where );

        $table->include    = array(
            'award_id',
            'award_title',
            'award_desc',
            'award_date',
            'award_enabled',
            'award_icon',
            'award_obtainable',
            'award_obtainable_enabled',
            'award_obtainable_yes_message',
            'award_obtainable_no_message',
            'award_count'
        );

        $table->mainColumn = 'award_title';

        $table->tableTemplate = array( \IPS\Theme::i()->getTemplate( 'awards', 'awards', 'front' ), 'table' );
        $table->rowsTemplate  = array( \IPS\Theme::i()->getTemplate( 'awards', 'awards', 'front' ), 'rows' );

        $table->sortBy        = 'award_date';
        $table->sortDirection = 'desc';

        $table->parsers = array(
            'award_title'			=> function( $val, $row )
            {
                return $row['award_title'];
            },
            'award_desc'			=> function( $val, $row )
            {
                return $row['award_desc'];
            }
        );

        \IPS\Output::i()->title = $cat->title;

        \IPS\Output::i()->output = \IPS\Theme::i()->getTemplate( 'awards' )->awards( (string) $table, $cat );
    }

    protected function award()
    {
        $where = array( array( 'awarded_id =' . \IPS\Request::i()->id ) );

        try
        {
            $award = \IPS\awards\Awarded::constructFromData( \IPS\Db::i()->select( '*', 'awards_awarded', $where )->first() );
        } catch ( \UnderflowException $e ) {}

        \IPS\Output::i()->output = \IPS\Theme::i()->getTemplate( 'awards' )->award( $award );
    }

    protected function awarded()
    {
        $table = new \IPS\Helpers\Table\Db( 'awards_awarded', \IPS\Http\Url::internal( 'app=awards&module=awards&controller=awards&do=awarded&id=' . \IPS\Request::i()->id ), array( array( 'awarded_award=?', \IPS\Request::i()->id ) ) );

        $table->joins = array(
            array( 'select' => 'm.*', 'from' => array( 'core_members', 'm' ), 'where' => "m.member_id=awards_awarded.awarded_member" )
        );

        $table->sortBy        = 'awarded_date';
        $table->sortDirection = 'desc';

        $table->tableTemplate = array( \IPS\Theme::i()->getTemplate( 'awarded' ), 'table' );
        $table->rowsTemplate  = array( \IPS\Theme::i()->getTemplate( 'awarded' ), 'rows' );
        $table->limit         = 15;

        \IPS\Output::i()->output = \IPS\Theme::i()->getTemplate( 'awarded' )->awarded( (string) $table );
    }

    protected function edit()
    {
        try
        {
            $awarded = \IPS\awards\Awarded::load( \IPS\Request::i()->id );
        } catch ( \UnderflowException $e ){}

        $form = new \IPS\Helpers\Form;
        $form->class .= 'ipsForm_vertical';

        $form->add( new \IPS\Helpers\Form\Editor( 'awarded_reason', $awarded->reason, FALSE, array( 'app' => 'awards', 'key' => 'Awards', 'autoSaveKey' => 'awards-new-reason', 'attachIds' => array() ), NULL, NULL, NULL, 'reason_show' ) );

        if ( $values = $form->values() )
        {
            $awarded->reason = $values['awarded_reason'];
            $awarded->save();

            \IPS\Output::i()->redirect( isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : \IPS\Http\Url::internal( '' ) );
        }

        \IPS\Output::i()->output = \IPS\Theme::i()->getTemplate( 'forms' )->edit( $form );

    }

    protected function remove()
    {
        try
        {
            $remove = \IPS\awards\Awarded::load( \IPS\Request::i()->id );
        } catch ( \UnderflowException $e ){}


        $form = new \IPS\Helpers\Form;
        $form->class .= 'ipsForm_vertical';

        $form->add( new \IPS\Helpers\Form\TextArea( 'award_removed_reason', NULL, TRUE, array() ) );

        if ( $values = $form->values() )
        {
            $remove->remove( $values['award_removed_reason'], \IPS\Member::loggedIn() );

            \IPS\Output::i()->redirect( isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : \IPS\Http\Url::internal( '' ) );
        }

        \IPS\Output::i()->output = \IPS\Theme::i()->getTemplate( 'awarded' )->reason( $form );

    }

    protected function reason()
    {
        try
        {
            $reason = \IPS\awards\Awarded::load( \IPS\Request::i()->id );

        } catch ( \UnderflowException $e ){}

        $row = $reason->reason;

        \IPS\Output::i()->output = \IPS\Theme::i()->getTemplate( 'forms' )->edit( (string) $row );

    }
}
