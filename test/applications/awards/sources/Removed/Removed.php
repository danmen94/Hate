<?php
/**
 * @package        iAwards
 * @author        <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

namespace IPS\awards;

/**
 * Class _Removed
 * @package IPS\awards
 */
class _Removed extends \IPS\Content\Item implements
    \IPS\Content\Permissions
{
    /**
     * @brief       Application
     */
    public static $application = 'awards';

    /**
     * @brief       Module
     */
    public static $module = 'awards';

    /**
     * @brief       Database Table
     */
    public static $databaseTable = 'awards_removed';

    /**
     * @brief       Database Prefix
     */
    public static $databasePrefix = 'award_removed_';

    /**
     * @brief       Multiton Store
     */
    protected static $multitons;

    /**
     * @var string
     */
    public static $databaseColumnId = 'id';

    /**
     * @brief       Node Class
     */
    public static $containerNodeClass = 'IPS\awards\Awards';

    /**
     * @brief       Database Column Map
     */
    public static $databaseColumnMap = array(
        'id'             => 'id',
        'container'      => 'award',
        'member'         => 'member',
        'giver'          => 'giver',
        'by'             => 'by',
        'date'           => 'date',
        'title'          => 'title',
        'awarded_date'   => 'awarded_date',
        'reason'         => 'reason',
        'awarded_reason' => 'awarded_reason'
    );

    /**
     * @brief       Title
     */
    public static $title = 'Removed';

    /**
     * @brief       Form Lang Prefix
     */
    public static $formLangPrefix = 'award_removed_';

    public function remove( $reason = '', $member = NULL )
    {
        /* Log the restored */
        $restore                 = new \IPS\awards\Restored;
        $restore->reason         = $reason;
        $restore->title          = $this->title;
        $restore->date           = time();
        $restore->awarded_date   = $this->awarded_date;
        $restore->award          = $this->award;
        $restore->member         = $this->member;
        $restore->giver          = $this->giver;
        $restore->by             = $member ? $member->member_id : NULL;
        $restore->awarded_reason = $this->awarded_reason;
        $restore->save();

        /* Update the award */
        $award        = \IPS\awards\Awards::load( $this->award );
        $award->count = $award->count + 1;
        $award->save();

        /* Delete via IPS4 core */
        $this->delete();
    }

    public function restore( $reason = '', $member = NULL )
    {
        /* Log the restored */
        $restore                 = new \IPS\awards\Restored;
        $restore->reason         = $reason;
        $restore->title          = $this->title;
        $restore->date           = time();
        $restore->awarded_date   = $this->awarded_date;
        $restore->award          = $this->award;
        $restore->member         = $this->member;
        $restore->giver          = $this->giver;
        $restore->by             = $member ? $member->member_id : NULL;
        $restore->awarded_reason = $this->awarded_reason;
        $restore->save();

        /* Update the award */
        $award        = \IPS\awards\Awards::load( $this->award );
        $award->count = $award->count + 1;
        $award->save();

        /* Delete via IPS4 core */
        $this->delete();
    }

}