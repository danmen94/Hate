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
 * Class _logs
 *
 * @package IPS\awards\modules\admin\awards
 */
class _logs extends \IPS\Dispatcher\Controller
{
    /**
     * Execute
     *
     * @return    void
     */
    public function execute()
    {
        \IPS\Dispatcher::i()->checkAcpPermission( 'logs_manage' );

        $this->activeTab = \IPS\Request::i()->tab ?: 'Removed';

        parent::execute();
    }

    /**
     * Manage
     *
     * @return    void
     */
    protected function manage()
    {
        \IPS\Output::i()->title = \IPS\Member::loggedIn()->language()->addToStack( 'award_title_logs' );

        $activeTabContents = call_user_func( [ $this, '_logs' . ucfirst( $this->activeTab ) ] );

        if ( \IPS\Request::i()->isAjax() )
        {
            \IPS\Output::i()->output = $activeTabContents;

            return;
        }

        # Tabs
        $tabs             = [ ];
        $tabs['Removed']  = 'Удаление';
        $tabs['Restored'] = 'Восстановление';

        \IPS\Output::i()->output = \IPS\Theme::i()->getTemplate( 'global', 'core' )->tabs(
            $tabs, $this->activeTab, $activeTabContents,
            \IPS\Http\Url::internal( 'app=awards&module=awards&controller=logs' )
        );

    }

    /**
     * Removed logs
     */
    protected function _logsRemoved()
    {
        $table = new \IPS\Helpers\Table\Db(
            'awards_removed', \IPS\Http\Url::internal( 'app=awards&module=awards&controller=logs' )
        );

        $table->include    = [ 'photo', 'name', 'title', 'awarded_date', 'by', 'date' ];
        $table->mainColumn = 'name';

        $table->langPrefix = 'award_removed_';

        $table->joins = array(
            array(
                'select' => 'm.*',
                'from'   => [ 'core_members', 'm' ],
                'where'  => 'm.member_id=awards_removed.award_removed_member' ),
            array(
                'select' => 'b.member_id',
                'from'   => [ 'core_members', 'b' ],
                'where'  => 'b.member_id=awards_removed.award_removed_by' ),
        );

        $table->parsers = [
            'photo'        => function ( $val, $row )
            {
                return \IPS\Theme::i()->getTemplate( 'global' )->rowPhoto( \IPS\Member::load( $row['award_removed_member'] ) );
            },
            'name'  => function ( $val, $row ) {
                return "<a href='" . \IPS\Http\Url::internal( 'app=core&module=members&controller=members&do=edit&id=' ) . $row['award_removed_member'] . "'>" . htmlentities( $val, \IPS\HTMLENTITIES, 'UTF-8', FALSE ) . "</a>";
            },
            'title'        => function ( $val, $row )
            {
                return $row['award_removed_title'];
            },
            'awarded_date' => function ( $val, $row )
            {
                $date = \IPS\DateTime::ts( $row['award_removed_awarded_date'] );

                return $date->localeDate() . ' ' . $date->localeTime( FALSE );
            },
            'by'           => function ( $val, $row )
            {
                return \IPS\Theme::i()->getTemplate( 'global', 'core' )->userLink(  \IPS\Member::load( $row['award_removed_by'] ) );
            },
            'date'         => function ( $val, $row )
            {
                $date = \IPS\DateTime::ts( $row['award_removed_date'] );

                return $date->localeDate() . ' ' . $date->localeTime( FALSE );
            },
        ];

        $table->rowButtons = function ( $row )
        {
            $return['reason'] = [
                'icon'  => 'search-plus',
                'title' => 'award_view_reason',
                'link'  => \IPS\Http\Url::internal(
                    'app=awards&module=awards&controller=logs&do=reason&subnode=1&data=remove' . '&id=' .
                    $row['award_removed_id']
                ),
                'data'  => [
                    'ipsDialog'       => '',
                    'ipsDialog-title' => \IPS\Member::loggedIn()->language()->addToStack( 'award_view_reason' )
                ]

            ];

            $return['restore'] = [
                'icon'  => 'plus-circle',
                'title' => 'award_member_restore',
                'link'  => \IPS\Http\Url::internal(
                    'app=awards&module=awards&controller=logs&do=restore&subnode=1' . '&id=' .
                    $row['award_removed_id']
                ),
                'data'  => [
                    'ipsDialog'       => '',
                    'ipsDialog-title' => \IPS\Member::loggedIn()->language()->addToStack( 'award_member_restore' )
                ]

            ];

            $return['delete'] = array(
                'icon'  => 'times-circle',
                'title' => 'award_member_delete_log',
                'link'  => \IPS\Http\Url::internal( 'app=awards&module=awards&controller=logs&do=delete&subnode=1' . '&id=' . $row['award_removed_id'] ),
                'data'  => array( 'delete' => '' ),
            );

            return $return;
        };

        return \IPS\Theme::i()->getTemplate( 'global', 'core' )->block( 'title', (string) $table );
    }

    /**
     * Restore logs
     */
    protected function _logsRestored()
    {
        $table = new \IPS\Helpers\Table\Db(
            'awards_restored', \IPS\Http\Url::internal( 'app=awards&module=awards&controller=logs&tab=Restored' )
        );

        $table->include    = [ 'photo', 'name', 'title', 'awarded_date', 'by', 'date' ];
        $table->mainColumn = 'name';

        $table->langPrefix = 'award_restored_';

        $table->joins = [
            [
                'select' => 'm.*',
                'from'   => [ 'core_members', 'm' ],
                'where'  => 'm.member_id=awards_restored.award_restored_member'
            ],
            [
                'select' => 'b.member_id',
                'from'   => [ 'core_members', 'b' ],
                'where'  => 'b.member_id=awards_restored.award_restored_by'
            ],
        ];

        $table->parsers = [
            'photo'        => function ( $val, $row )
            {
                return \IPS\Theme::i()->getTemplate( 'global' )->rowPhoto( \IPS\Member::load( $row['award_restored_member'] ) );
            },
            'name'  => function ( $val, $row )
            {
                return "<a href='" . \IPS\Http\Url::internal( 'app=core&module=members&controller=members&do=edit&id=' ) . $row['award_restored_member'] . "'>" . htmlentities( $val, \IPS\HTMLENTITIES, 'UTF-8', FALSE ) . "</a>";
            },
            'title'        => function ( $val, $row )
            {
                return $row['award_restored_title'];
            },
            'awarded_date' => function ( $val, $row )
            {
                $date = \IPS\DateTime::ts( $row['award_restored_awarded_date'] );

                return $date->localeDate() . ' ' . $date->localeTime( FALSE );
            },
            'by'           => function ( $val, $row )
            {
                return \IPS\Theme::i()->getTemplate( 'global', 'core' )->userLink( \IPS\Member::load( $row['award_restored_by'] ) );
            },
            'date'         => function ( $val, $row )
            {
                $date = \IPS\DateTime::ts( $row['award_restored_date'] );

                return $date->localeDate() . ' ' . $date->localeTime( FALSE );
            },
        ];

        $table->rowButtons = function ( $row )
        {
            $return['reason'] = [
                'icon'  => 'search-plus',
                'title' => 'award_view_reason',
                'link'  => \IPS\Http\Url::internal( 'app=awards&module=awards&controller=logs&do=reason&subnode=1&data=restore' . '&id=' . $row['award_restored_id'] ),
                'data'  => [
                    'ipsDialog'       => '',
                    'ipsDialog-title' => \IPS\Member::loggedIn()->language()->addToStack( 'award_view_reason' )
                ]

            ];

            return $return;
        };

        return \IPS\Theme::i()->getTemplate( 'global', 'core' )->block( 'title', (string) $table );
    }

    /**
     * Restore award
     */
    protected function restore()
    {
        \IPS\Output::i()->title = \IPS\Member::loggedIn()->language()->addToStack( 'award_title_restore' );

        $form = new \IPS\Helpers\Form;

        $form->add( new \IPS\Helpers\Form\TextArea( 'award_restored_reason', NULL, TRUE, [ ] ) );

        if ( $values = $form->values() )
        {
            try
            {
                $restore = \IPS\awards\Removed::load( \IPS\Request::i()->id );
                $restore->restore( $values['award_restored_reason'], \IPS\Member::loggedIn() );
            } catch ( \UnderflowException $e ){}

            \IPS\Output::i()->redirect( \IPS\Http\Url::internal( 'app=awards&module=awards&controller=logs&tab=Restored' ), 'awarded_restored' );
        }

        \IPS\Output::i()->output = $form;
    }

    /**
     * Reason
     */
    protected function reason()
    {
        if ( \IPS\Request::i()->data == 'restore' )
        {
            $data = \IPS\awards\Restored::load( \IPS\Request::i()->id );
        } else
        {
            $data = \IPS\awards\Removed::load( \IPS\Request::i()->id );
        }

        \IPS\Output::i()->output = \IPS\Theme::i()->getTemplate( 'global', 'awards' )->reason( $data->reason );
    }

    protected function delete()
    {
        try{
            $removed = \IPS\awards\Removed::load( \IPS\Request::i()->id );
            $removed->delete();
        } catch ( \UnderflowException $e ){}

        \IPS\Output::i()->redirect( \IPS\Http\Url::internal( 'app=awards&module=awards&controller=logs' ), 'removed_deleted' );

    }
}
