<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

namespace IPS\awards;

/**
 * Class _Awarded
 * @package IPS\awards
 */
class _Awarded extends \IPS\Content\Item implements
    \IPS\Content\Permissions
{
    /**
     * @var string
     */
    public static $application = 'awards';

    /**
     * @var string
     */
    public static $module = 'awards';

    /**
     * @var string
     */
    public static $databaseTable = 'awards_awarded';

    /**
     * @var string
     */
    public static $databasePrefix = 'awarded_';

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
    public static $containerNodeClass = 'IPS\awards\Awards';


    /**
     * @var string
     */
    public static $databaseColumnId = 'id';

    /**
     * @var array
     */
    public static $databaseColumnMap = array(
        'container' => 'award',
        'member'    => 'member',
        'date'      => 'date',
        'data'      => 'award_data',
        'show'      => 'show',
        'giver'     => 'giver',
        'options'   => 'options',
        'reason'    => 'reason',
        'cat'       => 'cat',
        'title'     => 'title'

    );

    /**
     * @var string
     */
    public static $title = 'Members';

    /**
     * @var string
     */
    public static $icon = 'users';

    public function remove( $reason = '', $member = NULL )
    {
        /* Log the removal */
        $removed                 = new \IPS\awards\Removed;
        $removed->reason         = $reason;
        $removed->title          = $this->title;
        $removed->date           = time();
        $removed->awarded_date   = $this->date;
        $removed->award          = $this->award;
        $removed->member         = $this->member;
        $removed->giver          = $this->giver;
        $removed->by             = $member ? $member->member_id : NULL;
        $removed->awarded_reason = $this->reason;
        $removed->save();

        /* Update the award */
        $award        = \IPS\awards\Awards::load( $this->award );
        $award->count = $award->count - 1;
        $award->save();

        /* Delete via IPS4 core */
        $this->delete();

    }
}