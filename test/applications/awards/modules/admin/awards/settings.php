<?php
/**
 * @package      iAwards
 * @author       <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2016 Invisionizer
 */

namespace IPS\awards\modules\admin\awards;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
    header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
    exit;
}

class _settings extends \IPS\Dispatcher\Controller
{
    public function execute()
    {
        \IPS\Dispatcher::i()->checkAcpPermission( 'settings_manage' );

        parent::execute();
    }

    protected function manage()
    {
        \IPS\Output::i()->title = \IPS\Member::loggedIn()->language()->addToStack( 'award_title_settings' );

        $form = new \IPS\Helpers\Form;

        $form->addTab( 'award_settings_tab_main' );
        $form->addHeader( 'award_settings_header_main' );
        $form->add( new \IPS\Helpers\Form\Member( 'award_settings_bot', ( \IPS\Settings::i()->award_settings_bot ) ? \IPS\Member::load( \IPS\Settings::i()->award_settings_bot ) : \IPS\Member::loggedIn(), TRUE, array() ) );

        $form->addTab( 'award_settings_tab_display' );
        $form->addHeader( 'award_settings_header_display_cats' );
        $cat = ( isset( \IPS\Settings::i()->cat_settings_front_size ) ) ? explode( 'x', \IPS\Settings::i()->cat_settings_front_size ) : array( 40, 40 );
        $form->add( new \IPS\Helpers\Form\WidthHeight( 'cat_settings_front_size', $cat, TRUE, array( 'resizableDiv' => true ), NULL, NULL, NULL, 'award_settings_cats_icon_size' ) );

        $form->addHeader( 'award_settings_header_display_front' );
        $profile = ( isset( \IPS\Settings::i()->award_settings_front_size ) ) ? explode( 'x', \IPS\Settings::i()->award_settings_front_size ) : array( 64, 64 );
        $form->add( new \IPS\Helpers\Form\WidthHeight( 'award_settings_front_size', $profile, TRUE, array( 'resizableDiv' => TRUE ), NULL, NULL, NULL, 'award_settings_front_icon_size' ) );

        $form->addHeader( 'award_settings_header_display_awardhover' );
        $awardHover = ( isset( \IPS\Settings::i()->award_settings_awardhover_size ) ) ? explode( 'x', \IPS\Settings::i()->award_settings_awardhover_size ) : array( 64, 64 );
        $form->add( new \IPS\Helpers\Form\WidthHeight( 'award_settings_awardhover_size', $awardHover, TRUE, array( 'resizableDiv' => TRUE ), NULL, NULL, NULL, 'award_settings_awardhover_icon_size' ) );

        $form->addHeader( 'award_settings_header_display_profile' );
        $profile = ( isset( \IPS\Settings::i()->award_settings_profile_size ) ) ? explode( 'x', \IPS\Settings::i()->award_settings_profile_size ) : array( 52, 52 );
        $form->add( new \IPS\Helpers\Form\WidthHeight( 'award_settings_profile_size', $profile, TRUE, array( 'resizableDiv' => TRUE ), NULL, NULL, NULL, 'award_settings_profile_icon_size' ) );

        $form->addHeader( 'award_settings_header_display_pane' );
        $form->add( new \IPS\Helpers\Form\YesNo( 'award_settings_pane_enable', ( \IPS\Settings::i()->award_settings_pane_enable ) ? \IPS\Settings::i()->award_settings_pane_enable : 0, FALSE, array( 'togglesOn' => array( 'award_settings_pane_cat_show_cat_show_show', 'award_settings_pane_cat_show', 'award_settings_pane_total_show', 'award_settings_pane_style_show', 'award_settings_pane_icon_size_show', 'award_settings_pane_title_show', 'award_settings_pane_alignment_show' ) ), NULL, NULL, NULL, 'award_settings_pane_enable_show' ) );

        $form->add( new \IPS\Helpers\Form\Select( 'award_settings_pane_cat_show_show', ( \IPS\Settings::i()->award_settings_pane_cat_show_show ) ? \IPS\Settings::i()->award_settings_pane_cat_show_show : 'all', FALSE, array( 'options' => array( 'all' => 'award_settings_cat_show_all', 'category' => 'award_settings_cat_show_cat' ), 'toggles' => array( 'category' => array( 'award_settings_pane_cat_show' ) ) ), NULL, NULL, NULL, 'award_settings_pane_cat_show_cat_show_show' ) );

        $form->add( new \IPS\Helpers\Form\Text( 'award_settings_pane_title', ( \IPS\Settings::i()->award_settings_pane_title ) ? \IPS\Settings::i()->award_settings_pane_title : NULL, FALSE, array(), NULL, NULL, NULL, 'award_settings_pane_title_show' ) );
        $form->add( new \IPS\Helpers\Form\Node( 'award_settings_pane_cat', explode( ',', \IPS\Settings::i()->award_settings_pane_cat ), FALSE, array(
            'class'         => 'IPS\awards\Cats',
            'multiple'      => TRUE,
            'subnodes'      => FALSE,
            'noParentNodes' => 'Custom'
        ), NULL, NULL, NULL, 'award_settings_pane_cat_show' ) );

        $form->add( new \IPS\Helpers\Form\Number( 'award_settings_pane_total', ( \IPS\Settings::i()->award_settings_pane_total ) ? \IPS\Settings::i()->award_settings_pane_total : 16, FALSE, array(), NULL, NULL, NULL, 'award_settings_pane_total_show' ) );
        $form->add( new \IPS\Helpers\Form\Radio( 'award_settings_pane_style', ( \IPS\Settings::i()->award_settings_pane_style ) ? \IPS\Settings::i()->award_settings_pane_style : 0, FALSE, array(
            'options' => array(
                0 => 'award_settings_hovercard',
                1 => 'award_settings_tooltips',

            ),

        ), NULL, NULL, NULL, 'award_settings_pane_style_show' ) );

        $pane = ( isset( \IPS\Settings::i()->award_settings_pane_size ) ) ? explode( 'x', \IPS\Settings::i()->award_settings_pane_size ) : array( 23, 23 );
        $form->add( new \IPS\Helpers\Form\WidthHeight( 'award_settings_pane_size', $pane, TRUE, array( 'resizableDiv' => TRUE ), NULL, NULL, NULL, 'award_settings_pane_icon_size_show' ) );

        $form->add( new \IPS\Helpers\Form\Select( 'award_settings_pane_alignment', ( \IPS\Settings::i()->award_settings_pane_alignment ) ? \IPS\Settings::i()->award_settings_pane_alignment : 0, FALSE, array( 'options' => array( 0 => 'awards_alignment_center', 1 => 'awards_alignment_left', 2 => 'awards_alignment_right' ) ), NULL, NULL, NULL, 'award_settings_pane_alignment_show' ) );

        $form->addHeader( 'award_settings_header_display_posts' );
        $form->add( new \IPS\Helpers\Form\YesNo( 'award_settings_posts_enable', ( \IPS\Settings::i()->award_settings_posts_enable ) ? \IPS\Settings::i()->award_settings_posts_enable : 0, FALSE, array( 'togglesOn' => array( 'award_settings_posts_cat_show', 'award_settings_posts_total_show', 'award_settings_posts_style_show', 'award_settings_posts_icon_size_show', 'award_settings_posts_title_show', 'award_settings_posts_style_show', 'award_settings_posts_cat_show_cat_show_show', 'award_settings_posts_alignment_show' ) ), NULL, NULL, NULL, 'award_settings_posts_enable_show' ) );

        $form->add( new \IPS\Helpers\Form\Select( 'award_settings_posts_cat_show_show', ( \IPS\Settings::i()->award_settings_posts_cat_show_show ) ? \IPS\Settings::i()->award_settings_posts_cat_show_show : 'all', FALSE, array( 'options' => array( 'all' => 'award_settings_cat_show_all', 'category' => 'award_settings_cat_show_cat' ), 'toggles' => array( 'category' => array( 'award_settings_posts_cat_show' ) ) ), NULL, NULL, NULL, 'award_settings_posts_cat_show_cat_show_show' ) );

        $form->add( new \IPS\Helpers\Form\Text( 'award_settings_posts_title', ( \IPS\Settings::i()->award_settings_posts_title ) ? \IPS\Settings::i()->award_settings_posts_title : NULL, FALSE, array(), NULL, NULL, NULL, 'award_settings_posts_title_show' ) );
        $form->add( new \IPS\Helpers\Form\Node( 'award_settings_posts_cat', explode( ',', \IPS\Settings::i()->award_settings_posts_cat ), FALSE, array(
            'class'         => 'IPS\awards\Cats',
            'multiple'      => TRUE,
            'subnodes'      => FALSE,
            'noParentNodes' => 'Custom'
        ), NULL, NULL, NULL, 'award_settings_posts_cat_show' ) );

        $form->add( new \IPS\Helpers\Form\Number( 'award_settings_posts_total', ( \IPS\Settings::i()->award_settings_posts_total ) ? \IPS\Settings::i()->award_settings_posts_total : 16, FALSE, array(), NULL, NULL, NULL, 'award_settings_posts_total_show' ) );
        $form->add( new \IPS\Helpers\Form\Radio( 'award_settings_posts_style', ( \IPS\Settings::i()->award_settings_posts_style ) ? \IPS\Settings::i()->award_settings_posts_style : 0, FALSE, array(
            'options' => array(
                0 => 'award_settings_hovercard',
                1 => 'award_settings_tooltips',

            ),

        ), NULL, NULL, NULL, 'award_settings_posts_style_show' ) );


        $posts = ( isset( \IPS\Settings::i()->award_settings_posts_size ) ) ? explode( 'x', \IPS\Settings::i()->award_settings_posts_size ) : array( 28, 28 );
        $form->add( new \IPS\Helpers\Form\WidthHeight( 'award_settings_posts_size', $posts, TRUE, array( 'resizableDiv' => TRUE ), NULL, NULL, NULL, 'award_settings_posts_icon_size_show' ) );

        $form->add( new \IPS\Helpers\Form\Select( 'award_settings_posts_alignment', ( \IPS\Settings::i()->award_settings_posts_alignment ) ? \IPS\Settings::i()->award_settings_posts_alignment : 0, FALSE, array( 'options' => array( 0 => 'awards_alignment_center', 1 => 'awards_alignment_left', 2 => 'awards_alignment_right' ) ), NULL, NULL, NULL, 'award_settings_posts_alignment_show' ) );

        $form->addHeader( 'award_settings_header_display_hover' );
        $form->add( new \IPS\Helpers\Form\YesNo( 'award_settings_hover_enable', ( \IPS\Settings::i()->award_settings_hover_enable ) ? \IPS\Settings::i()->award_settings_hover_enable : 0, FALSE, array( 'togglesOn' => array( 'award_settings_hover_cat_show_show', 'award_settings_hover_title_show', 'award_settings_hover_total_show', 'award_settings_hover_style_show', 'award_settings_hover_icon_size_show', 'award_settings_hover_alignment_show' ) ), NULL, NULL, NULL, 'award_settings_hover_enable_show' ) );

        $form->add( new \IPS\Helpers\Form\Select( 'award_settings_hover_cat_show_show', ( \IPS\Settings::i()->award_settings_hover_cat_show_show ) ? \IPS\Settings::i()->award_settings_hover_cat_show_show : 'all', FALSE, array( 'options' => array( 'all' => 'award_settings_cat_show_all', 'category' => 'award_settings_cat_show_cat' ), 'toggles' => array( 'category' => array( 'award_settings_hover_cat_show' ) ) ), NULL, NULL, NULL, 'award_settings_hover_cat_show_show' ) );

        $form->add( new \IPS\Helpers\Form\Text( 'award_settings_hover_title', ( \IPS\Settings::i()->award_settings_hover_title ) ? \IPS\Settings::i()->award_settings_hover_title : NULL, FALSE, array(), NULL, NULL, NULL, 'award_settings_hover_title_show' ) );
        $form->add( new \IPS\Helpers\Form\Node( 'award_settings_hover_cat', explode( ',', \IPS\Settings::i()->award_settings_hover_cat ), FALSE, array(
            'class'         => 'IPS\awards\Cats',
            'multiple'      => TRUE,
            'subnodes'      => FALSE,
            'noParentNodes' => 'Custom'
        ), NULL, NULL, NULL, 'award_settings_hover_cat_show' ) );

        $form->add( new \IPS\Helpers\Form\Number( 'award_settings_hover_total', ( \IPS\Settings::i()->award_settings_hover_total ) ? \IPS\Settings::i()->award_settings_hover_total : 8, FALSE, array(), NULL, NULL, NULL, 'award_settings_hover_total_show' ) );
        $form->add( new \IPS\Helpers\Form\Radio( 'award_settings_hover_style', ( \IPS\Settings::i()->award_settings_hover_style ) ? \IPS\Settings::i()->award_settings_hover_style : 0, FALSE, array(
            'options' => array(
                0 => 'award_settings_hovercard',
                1 => 'award_settings_tooltips',

            ),

        ), NULL, NULL, NULL, 'award_settings_hover_style_show' ) );

        $hover = ( isset( \IPS\Settings::i()->award_settings_hover_size ) ) ? explode( 'x', \IPS\Settings::i()->award_settings_hover_size ) : array( 20, 20 );
        $form->add( new \IPS\Helpers\Form\WidthHeight( 'award_settings_hover_size', $hover, TRUE, array( 'resizableDiv' => TRUE ), NULL, NULL, NULL, 'award_settings_hover_icon_size_show' ) );

        $form->add( new \IPS\Helpers\Form\Select( 'award_settings_hover_alignment', ( \IPS\Settings::i()->award_settings_hover_alignment ) ? \IPS\Settings::i()->award_settings_hover_alignment : 0, FALSE, array( 'options' => array( 0 => 'awards_alignment_center', 1 => 'awards_alignment_left', 2 => 'awards_alignment_right' ) ), NULL, NULL, NULL, 'award_settings_hover_alignment_show' ) );

        if ( $values = $form->values() )
        {

            $values['award_settings_bot']             = $values['award_settings_bot']->member_id;
            $values['award_settings_pane_size']       = implode( 'x', $values['award_settings_pane_size'] );
            $values['award_settings_hover_size']      = implode( 'x', $values['award_settings_hover_size'] );
            $values['award_settings_profile_size']    = implode( 'x', $values['award_settings_profile_size'] );
            $values['award_settings_front_size']      = implode( 'x', $values['award_settings_front_size'] );
            $values['award_settings_posts_size']      = implode( 'x', $values['award_settings_posts_size'] );
            $values['cat_settings_front_size']      = implode( 'x', $values['cat_settings_front_size'] );
            $values['award_settings_awardhover_size'] = implode( 'x', $values['award_settings_awardhover_size'] );

            if ( isset( $values['award_settings_pane_cat'] ) )
            {
                $values['award_settings_pane_cat'] = is_array( $values['award_settings_pane_cat'] ) ? implode( ',', array_keys( $values['award_settings_pane_cat'] ) ) : NULL;
            }

            if ( isset( $values['award_settings_posts_cat'] ) )
            {
                $values['award_settings_posts_cat'] = is_array( $values['award_settings_posts_cat'] ) ? implode( ',', array_keys( $values['award_settings_posts_cat'] ) ) : NULL;
            }

            if ( isset( $values['award_settings_hover_cat'] ) )
            {
                $values['award_settings_hover_cat'] = is_array( $values['award_settings_hover_cat'] ) ? implode( ',', array_keys( $values['award_settings_hover_cat'] ) ) : NULL;
            }

            $form->saveAsSettings( $values );
        }

        \IPS\Output::i()->output = $form;
    }

}