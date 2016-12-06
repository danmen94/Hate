<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2016 Invisionizer
 */

namespace IPS\awards;

/**
 * Class _Awards
 *
 * @package IPS\awards
 */
class _Awards extends \IPS\Node\Model implements \IPS\Node\Permissions
{
    /**
     * @var
     */
    protected static $multitons;

    /**
     * @var null
     */
    protected static $defaultValues = NULL;

    /**
     * @var string
     */
    public static $databaseTable = 'awards_awards';

    /**
     * @var string
     */
    public static $databasePrefix = 'award_';

    /**
     * @var string
     */
    public static $databaseColumnOrder = 'position';

    /**
     * @var string
     */
    public static $nodeTitle = 'awards';

    /**
     * @var string
     */
    public static $parentNodeColumnId = 'cat_id';

    /**
     * @return mixed
     */
    protected function get__title()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    protected function get__enabled()
    {
        return $this->enabled;
    }

    /**
     * @param $enabled
     */
    protected function set__enabled( $enabled )
    {
        $this->enabled = $enabled;
    }

    /**
     * @return null
     */
    protected function get__description()
    {
        return NULL;
    }

    /**
     * @var array
     */
    protected static $restrictions = array(
        'app'		=> 'awards',
        'module'	=> 'awards',
        'prefix' 	=> 'awards_'
    );

    /**
     * @var string
     */
    public static $permApp = 'awards';

    /**
     * @var string
     */
    public static $permType = 'awards';

    /**
     * @var array
     */
    public static $permissionMap = array(
        'view'     => 'view',
        'add'      => 2,
        'receive'  => 3,
        'self'     => 4,
        'restrict' => 5,
        'manage'   => 6,
        'awarded'  => 7
    );

    /**
     * @var string
     */
    public static $permissionLangPrefix = 'award_perm_';

    /**
     * @param $form
     */
    public function form( &$form )
    {
        $form->addTab( 'award_tab_main' );
        $form->add( new \IPS\Helpers\Form\YesNo( 'award_enabled', isset( $this->enabled ) ? $this->enabled : TRUE, FALSE, array() ) );
        $form->add( new \IPS\Helpers\Form\Text( 'award_title', $this->title, TRUE, array() ) );
        $form->add( new \IPS\Helpers\Form\Editor( 'award_desc', $this->id ? $this->desc : NULL, TRUE, array( 'app' => 'awards', 'key' => 'Awards', 'autoSaveKey' => 'awards-new-award', 'attachIds' => ( $this->id === NULL ? NULL : array( $this->id ) ) ) ) );
        $form->add( new \IPS\Helpers\Form\Upload( 'award_icon', $this->icon ? \IPS\File::get( 'awards_Awards', $this->icon ) : NULL, TRUE, array( 'storageExtension' => 'awards_Awards', 'storageContainer' => 'awards', 'image' => TRUE, 'allowedFileTypes' => array( 'png', 'jpg', 'gif', 'svg' ), 'obscure' => true ), NULL, NULL, NULL, 'type_url' ) );

        if ( \IPS\Request::i()->id )
        {
            $form->add( new \IPS\Helpers\Form\Node( 'award_cat_id', ( $this->id and $this->cat_id != '*' ) ? $this->cat_id : 0, TRUE, array(
                'class'    => 'IPS\awards\Cats',
                'multiple' => FALSE,
                'subnodes' => FALSE,
            ), NULL, NULL, NULL, NULL ) );
        }

        $form->addTab( 'award_tab_reason' );
        $form->add( new \IPS\Helpers\Form\Editor( 'award_reason', $this->id ? $this->reason : NULL, TRUE, array( 'app' => 'awards', 'key' => 'Awards', 'autoSaveKey' => 'awards-new-reason', 'attachIds' => ( $this->id === NULL ? NULL : array( $this->id ) ) ), NULL, NULL, NULL, 'reason_show' ) );

        $form->addTab( 'award_tab_options' );
        $form->add( new \IPS\Helpers\Form\YesNo( 'award_notification', isset( $this->notification ) ? $this->notification : 0, FALSE, array( 'togglesOn' => array( 'not_title_show', 'not_reason' ) ) ) );
        $form->add( new \IPS\Helpers\Form\YesNo( 'award_obtainable_enabled', isset( $this->obtainable_enabled ) ? $this->obtainable_enabled : 0, FALSE, array( 'togglesOn' => array( 'award_obtainable_show', 'award_obtainable_yes_message_show', 'award_obtainable_no_message_show' ) ) ) );
        $form->add( new \IPS\Helpers\Form\YesNo( 'award_obtainable', isset( $this->obtainable ) ? $this->obtainable : 0, FALSE, array( 'togglesOn' => array() ), null, null, null, 'award_obtainable_show' ) );
        $form->add( new \IPS\Helpers\Form\Text( 'award_obtainable_yes_message', $this->obtainable_yes_message, true, array(), null, null, null, 'award_obtainable_yes_message_show' ) );
        $form->add( new \IPS\Helpers\Form\Text( 'award_obtainable_no_message', $this->obtainable_no_message, true, array(), null, null, null, 'award_obtainable_no_message_show' ) );
    }

    /**
     * @param $values
     */
    public function saveForm( $values )
    {
        /* Claim attachments */
        if ( !$this->id )
        {
            $this->save();
        }

        foreach ( array() as $fieldKey => $langKey )
        {
            \IPS\Lang::saveCustom( '', $langKey, $values[$fieldKey] );
            unset( $values[$fieldKey] );
        }

        foreach ( array() as $k )
        {
            $this->bitoptions[$k] = $values[$k];
            unset( $values[$k] );
        }

        if ( isset( $values['award_cat_id'] ) )
        {
            $values['award_cat_id'] = $values['award_cat_id'] ? intval( $values['award_cat_id']->id ) : 0;
        }

        if ( $values['award_show'] != $this->show )
        {
            $awarded = \IPS\Db::i()->select( 'awards_awarded.awarded_id, awards_awarded.awarded_award, awards_awarded.awarded_show', 'awards_awarded', array( 'awarded_award = ?', $this->id ), NULL, NULL, NULL, \IPS\Db::SELECT_SQL_CALC_FOUND_ROWS )->setKeyField( 'awarded_id' );

            $awards = iterator_to_array( $awarded );

            foreach ( $awards as $row )
            {
                \IPS\Db::i()->update( 'awards_awarded', array( 'awarded_show' => (string) $values['award_show'] ), array( 'awarded_id=?', $row['awarded_id'] ) );

            }
        }

        if ( isset( $values['award_restrictions'] ) )
        {
            $values['award_restrictions'] = $values['award_restrictions'] ? intval( $values['award_restrictions'] ) : 0;
        }

        if ( isset( $values['award_notification'] ) )
        {
            $values['award_notification'] = $values['award_notification'] ? intval( $values['award_notification'] ) : 0;
        }

        parent::saveForm( $values );
    }

    /**
     * @param $column
     * @param $query
     * @param null $order
     * @param array $where
     *
     * @return mixed
     */
    public static function search( $column, $query, $order = NULL, $where = array() )
    {
        if ( $column === '_title' )
        {
            $column = 'award_title';
        }

        if ( $order == '_title' )
        {
            $order = 'award_title';
        }

        return parent::search( $column, $query, $order, $where );
    }

    /**
     * @param $url
     * @param bool|FALSE $subnode
     *
     * @return array
     */
    public function getButtons( $url, $subnode = FALSE )
    {
        $buttons = array();

        $buttons = array_merge( $buttons, parent::getButtons( $url, $subnode ) );

        if ( $this->canAwarded() )
        {
            $buttons['awarded_manage_members'] = array(
                'icon'  => 'cogs',
                'title' => 'awarded_manage_members',
                'link'  => \IPS\Http\Url::internal( "app=awards&module=awards&controller=manage&do=manageMembers&subnode=1" . "&id=" . $this->id ),
            );
        }

        return $buttons;
    }

    /**
     * @return mixed
     */
    public function delete()
    {
        \IPS\Db::i()->delete( 'awards_awarded', array( 'awarded_award=?', $this->id ) );

        return parent::delete();
    }

    /**
     * @param \IPS\Member|NULL $member
     * @param bool|TRUE $checkPerms
     * @param \IPS\Member|NULL $giver
     * @param null $reason
     *
     * @throws \Exception
     */
    public function awardTo( \IPS\Member $member = NULL, $checkPerms = TRUE, \IPS\Member $giver = NULL, $reason = NULL )
    {
        $member = $member ?: \IPS\Member::loggedIn();
        $giver  = $giver ?: \IPS\Member::loggedIn();

        if ( $checkPerms and !$this->can( 'receive', $member ) )
        {
            throw new \Exception( 'This member is not permitted to receive this award.' );
        }

        if ( !$this->can( 'restrict', $member ) )
        {
            $awarded          = new \IPS\awards\Awarded;
            $awarded->date    = time();
            $awarded->award   = $this->id;
            $awarded->member  = $member->member_id;
            $awarded->options = $this->options;
            $awarded->giver   = $giver->member_id;
            $awarded->show    = $this->show;
            $awarded->title   = $this->title;
            $awarded->cat     = $this->cat_id;
            $awarded->reason  = $reason;
            $awarded->save();

            $total       = $this->recount( $awarded->award );
            $this->count = $total;
            $this->save();


            if ( $this->notification )
            {
                $this->sendNotifications( $awarded );
            }
        }

        if ( $this->can( 'restrict', $member ) AND $this->hasAward( $member ) )
        {
            throw new \Exception( 'This member already has this award.' );
        } elseif ( $this->can( 'restrict', $member ) AND !$this->hasAward( $member ) )
        {
            $awarded          = new \IPS\awards\Awarded;
            $awarded->date    = time();
            $awarded->award   = $this->id;
            $awarded->member  = $member->member_id;
            $awarded->options = $this->options;
            $awarded->giver   = $giver->member_id;
            $awarded->show    = $this->show;
            $awarded->title   = $this->title;
            $awarded->cat     = $this->cat_id;
            $awarded->reason  = $reason;
            $awarded->save();

            $total       = $this->recount( $awarded->award );
            $this->count = $total;
            $this->save();


            if ( $this->notification )
            {
                $this->sendNotifications( $awarded );
            }
        }
    }


    /**
     * @param \IPS\Member|NULL $member
     *
     * @return bool
     */
    public function hasAward( \IPS\Member $member = NULL )
    {
        $member = $member ?: \IPS\Member::loggedIn();

        return (bool) \IPS\Db::i()->select( 'COUNT(*)', 'awards_awarded', array( 'awarded_member=? AND awarded_award=?', $member->member_id, $this->id ) )->first();
    }

    /**
     * @param \IPS\Member|NULL $member
     *
     * @return mixed
     */
    public function countAwards( \IPS\Member $member = NULL )
    {
        $member = $member ?: \IPS\Member::loggedIn();

        if ( $member->member_id )
        {
            $total = \IPS\Db::i()->select( 'COUNT(*)', 'awards_awarded', array( 'awarded_member = ?', $member->member_id ) )->first();

        }

        return $total;
    }

    /**
     * @param $award
     */
    public function sendNotifications( $award )
    {
        $member = \IPS\Member::load( $award->member );

        $this->url = "<a href='" . $member->url()->setQueryString( 'tab', 'node_awards_Awards' ) . "'" . $this->title . "'</a>'";

        $this->board = \IPS\Settings::i()->board_name;

        $data          = array();
        $data['award'] = $this->title;
        $data['giver'] = \IPS\Member::loggedIn()->member_id;

        $notification = new \IPS\Notification( \IPS\Application::load( 'awards' ), 'award_member', $award, array( $this, $member ), $data );
        $notification->recipients->attach( \IPS\Member::load( $member->member_id ) );
        $notification->send();
    }

    /**
     * @param $award
     *
     * @return mixed
     */
    public function recount( $award )
    {
        $total = \IPS\Db::i()->select( 'COUNT(*)', 'awards_awarded', array( 'awarded_award=?', $award ) )->first();

        return $total;
    }

    /**
     * @param null $member
     * @return bool
     */
    public function canManage( $member=NULL )
    {
        return FALSE;
    }

    /**
     * Clone
     */
    public function __clone()
    {
        if ( $this->skipCloneDuplication === TRUE )
        {
            return;
        }

        $oldIcon = $this->icon;

        parent::__clone();

        if ( $oldIcon )
        {
            try
            {
                $icon = \IPS\File::get( 'awards_Awards', $oldIcon );
                $newIcon = \IPS\File::create( 'awards_Awards', $icon->originalFilename, $icon->contents() );
                $this->icon = (string) $newIcon;
            }
            catch ( \Exception $e )
            {
                $this->icon = NULL;
            }

            $this->save();
        }
    }

    /**
     * @return mixed
     */
    public function canAwarded()
    {
        return static::restrictionCheck( 'awarded' );
    }
}