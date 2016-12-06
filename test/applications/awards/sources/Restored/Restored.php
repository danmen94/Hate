<?php
/**
 * @package        iAwards
 * @author        <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

namespace IPS\awards;

/**
 * Class _Restored
 * @package IPS\awards
 */
class _Restored extends \IPS\Content\Item implements
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
    public static $databaseTable = 'awards_restored';

    /**
     * @brief       Database Prefix
     */
    public static $databasePrefix = 'award_restored_';

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
        'container'      => 'award',
        'author'         => 'member',
        'giver'          => 'giver',
        'remover'        => 'by',
        'date'           => 'date',
        'title'          => 'title',
        'awarded_date'   => 'awarded_date',
        'awarded_reason' => 'awarded_reason'

    );

    /**
     * @brief       Title
     */
    public static $title = 'Restored';

    /**
     * @brief       Form Lang Prefix
     */
    public static $formLangPrefix = 'award_restored_';
}