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


class _ajaxcreate extends \IPS\Dispatcher\Controller
{
    public function execute()
    {
        parent::execute();
    }

    protected function manage()
    {

        if ( \IPS\awards\Cats::canOnAny( 'add' ) )
        {
            $form = new \IPS\Helpers\Form;
            $form->add( new \IPS\Helpers\Form\Member( 'awarded_member', NULL, TRUE, array() ) );

            $form->add( new \IPS\Helpers\Form\Node( 'award_id', null, FALSE, array(
                'class'           => 'IPS\awards\Cats',
                'subnodes'        => TRUE,
            ), NULL, NULL, NULL, NULL ) );

            $form->add( new \IPS\Helpers\Form\Editor( 'awarded_reason', null, FALSE, array( 'app' => 'awards', 'key' => 'Awards', 'autoSaveKey' => 'awards-new-reason', 'attachIds' => array() ), NULL, NULL, NULL, 'reason_show' ) );

            if ( $values = $form->values() )
            {
                $member = \IPS\Member::load( $values['awarded_member']->member_id );
                $giver  = \IPS\Member::load( \IPS\Member::loggedIn()->member_id );
                $reason = $values['awarded_reason'];

                try
                {
                    $award = \IPS\awards\Awards::load( $values['award_id']->id );

                } catch ( \UnderflowException $e ){}

                if ( $award->can( 'self', $member ) AND !$award->can( 'add', $member ) AND $giver->member_id != $member->member_id )
                {
                    throw new \Exception(  \IPS\Member::loggedIn()->language()->get( 'awards_others_err' ) );
                }

                if ( $award->can( 'add', $member ) AND !$award->can( 'self', $member ) AND $giver->member_id == $member->member_id )
                {
                    throw new \Exception(  \IPS\Member::loggedIn()->language()->get( 'awards_self_err' ) );
                }

                if( $award->obtainable_enabled AND $award->obtainable )
                {
                    throw new \Exception( \IPS\Member::loggedIn()->language()->get( 'awards_obtainable_err' ) );
                }

                try
                {
                    $award->awardTo( $member, $award, $giver, $reason );
                } catch ( \Exception $e )
                {
                    \IPS\Output::i()->error( $e->getMessage(), '1A19/1', 403, '' );
                }

            }
        }

        \IPS\Output::i()->output = \IPS\Theme::i()->getTemplate( 'forms', 'awards' )->addAward( $form );

    }

}