//<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

class awards_hook_awardsProfile extends _HOOK_CLASS_
{

    /* !Hook Data - DO NOT REMOVE */
    public static function hookData()
    {
        return array_merge_recursive( array(
                                          'hovercard' =>
                                              array(
                                                  0 =>
                                                      array(
                                                          'selector' => 'div.ipsPad_half.cUserHovercard > div.cUserHovercard_data > ul.ipsDataList.ipsDataList_reducedSpacing',
                                                          'type'     => 'add_inside_end',
                                                          'content'  => '{template="hover" group="global" location="front" app="awards" params="$member"}',
                                                      ),
                                              ),
                                      ), parent::hookData() );
    }
    /* End Hook Data */


}