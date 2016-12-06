<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

namespace IPS\awards;

/**
 * iAwards Application Class
 */
class _Application extends \IPS\Application
{
    public function init()
    {

    }

    public function defaultFrontNavigation()
    {
        return array(
            'rootTabs'      => array(),
            'browseTabs'    => array( array( 'key' => 'Awards' ) ),
            'browseTabsEnd' => array(),
            'activityTabs'  => array()
        );
    }
}
