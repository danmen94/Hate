//<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

class awards_hook_awardsPosts extends _HOOK_CLASS_
{

    /* !Hook Data - DO NOT REMOVE */
    public static function hookData()
    {
        return array_merge_recursive( array(
                                          'post'          =>
                                              array(
                                                  0 =>
                                                      array(
                                                          'selector' => 'div[data-controller=\'core.front.core.comment\']',
                                                          'type'     => 'add_inside_end',
                                                          'content'  => '{template="posts" group="global" location="front" app="awards" params="$comment->author()"}',
                                                      ),
                                              ),
                                          'postContainer' =>
                                              array(
                                                  0 =>
                                                      array(
                                                          'selector' => 'article[itemtype=\'http://schema.org/Answer\'] > aside.ipsComment_author.cAuthorPane.ipsColumn.ipsColumn_medium > ul.cAuthorPane_info.ipsList_reset',
                                                          'type'     => 'add_inside_end',
                                                          'content'  => '{template="pane" group="global" location="front" app="awards" params="$comment->author()"}',
                                                      ),
                                              ),
                                      ), parent::hookData() );
    }
    /* End Hook Data */


}