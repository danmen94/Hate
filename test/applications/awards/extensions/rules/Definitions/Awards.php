<?php
/**
 * @package        iAwards
 * @author        <a href='http://www.invisionizer.com'>Invisionizer</a>
 * @copyright    (c) 2015 Invisionizer
 */

namespace IPS\awards\extensions\rules\Definitions;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
    header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
    exit;
}

/**
 * @brief    Rules definitions extension: Awards
 */
class _Awards
{

    /**
     * @brief    The default option group title to list events, conditions, and actions from this class
     */
    public $defaultGroup = 'Awards';

    /**
     * Triggerable Events
     * Define the events that can be triggered by your application
     * Trigger events in your application code like this:
     * if ( \IPS\Application::appIsEnabled( 'rules' ) )
     * {
     *    \IPS\rules\Event::load( 'iawards', 'Awards', 'event_key' )->trigger( $arg1, $arg2, etc... );
     * }
     * @return    array        Array of event definitions
     */
    public function events()
    {
        $events = array
        ();

        return $events;
    }

    /**
     * Conditional Operations
     * You can define your own conditional operations which can be
     * added to rules as conditions.
     * @return    array        Array of conditions definitions
     */
    public function conditions()
    {
        $conditions = array
        (
            'has_award' => array
            (
                'callback'  => array( $this, 'hasAward' ),

                'arguments' => array
                (
                    'member' => array
                    (
                        'argtypes'      => \IPS\rules\Application::argPreset( 'member' ),
                        'configuration' => \IPS\rules\Application::configPreset( 'member', 'rules_choose_member' ),
                        'required'      => TRUE,
                    ),
                    'award'  => array
                    (
                        'argtypes'      => array
                        (
                            'object' => array
                            (
                                'class'       => 'IPS\awards\Awards',
                                'description' => 'An iAwards object',
                            ),
                        ),
                        'configuration' => \IPS\rules\Application::configPreset( 'node', 'awards_choose_award', TRUE, array( 'class' => 'IPS\awards\Awards' ) ),
                        'required'      => TRUE,
                    ),
                ),
            ),
        );

        return $conditions;
    }

    /**
     * Triggerable Actions
     * @return    array        Array of action definitions
     */
    public function actions()
    {
        $actions = array
        (
            'give_award'   => array
            (
                'callback'      => array( $this, 'awardTo' ),

                'configuration' => array
                (
                    'form' => function ( $form, $values, $action )
                    {
                        $form->add( new \IPS\Helpers\Form\YesNo( 'awards_respect_permissions', $values['awards_respect_permissions'], FALSE ) );
                    },
                ),

                'arguments'     => array
                (
                    'member' => array
                    (
                        'argtypes'      => \IPS\rules\Application::argPreset( 'member' ),
                        'configuration' => \IPS\rules\Application::configPreset( 'member', 'rules_choose_member' ),
                        'required'      => TRUE,
                    ),
                    'award'  => array
                    (
                        'argtypes'      => array
                        (
                            'object' => array
                            (
                                'class'       => 'IPS\awards\Awards',
                                'description' => 'An iAwards object',
                            ),
                        ),
                        'configuration' => \IPS\rules\Application::configPreset( 'node', 'awards_choose_award', TRUE, array( 'class' => 'IPS\awards\Awards' ) ),
                        'required'      => TRUE,
                    ),
                    'giver'  => array
                    (
                        'argtypes'      => \IPS\rules\Application::argPreset( 'member' ),
                        'configuration' => \IPS\rules\Application::configPreset( 'member', 'rules_choose_member2' ),
                        'required'      => TRUE,
                    ),
                ),
            ),
            'remove_award' => array
            (
                'callback'  => array( $this, 'removeAward' ),
                'arguments' => array
                (
                    'member'  => array
                    (
                        'argtypes'      => \IPS\rules\Application::argPreset( 'member' ),
                        'configuration' => \IPS\rules\Application::configPreset( 'member', 'rules_choose_member' ),
                        'required'      => TRUE,
                    ),
                    'award'   => array
                    (
                        'argtypes'      => array
                        (
                            'object' => array
                            (
                                'class'       => 'IPS\awards\Awards',
                                'description' => 'An iAwards object',
                            ),
                        ),
                        'configuration' => \IPS\rules\Application::configPreset( 'node', 'awards_choose_award', TRUE, array( 'class' => 'IPS\awards\Awards' ) ),
                        'required'      => TRUE,
                    ),
                    'remover' => array
                    (
                        'argtypes'      => \IPS\rules\Application::argPreset( 'member' ),
                        'configuration' => \IPS\rules\Application::configPreset( 'member', 'rules_choose_member2', FALSE ),
                        'required'      => FALSE,
                    ),
                    'reason'  => array
                    (
                        'argtypes'      => array( 'string' ),
                        'configuration' => array
                        (
                            'form'   => function ( $form, $values )
                            {
                                $form->add( new \IPS\Helpers\Form\Text( 'iawards_rules_remove_message', $values['iawards_rules_remove_message'], FALSE, array(), NULL, NULL, NULL, 'iawards_rules_remove_message' ) );

                                return array( 'iawards_rules_remove_message' );
                            },
                            'getArg' => function ( $values )
                            {
                                return $values['iawards_rules_remove_message'];
                            },
                        ),
                        'required'      => FALSE,
                        'default'       => 'manual',
                    ),
                ),
            ),
        );

        return $actions;
    }

    /**
     * Operation Callbacks
     * Your operation callback will recieve all of the arguments defined in your
     * action/condition definition. If an argument is not required, and not provided
     * by the user, then it will be NULL.
     * Your operation callback will also receive three additional arguments at the end of
     * your regularly defined arguments.
     * @extraArg1    array                $values        An array of the existing saved values from the configuration form
     * @extraArg2    array                $arg_map    A keyed array of the arguments from the event
     * @extraArg3    object    \IPS\rules\Action    $operation    The operation object (Action or Condition) which is invoking the callback
     *            \IPS\rules\Condition
     * @return    mixed            If this is a condition callback, you should return either TRUE or FALSE depending on if the condition has passed.
     *                    If it is an action callback, you should return a short message to describe the result of the action for debug purposes.
     * Note: Any value that you return from an operation callback is logged to the debug console when the rule is in debug mode. This way
     * it is possible to see what is happening with each operation as it is being evaluated.
     */

    /**
     * Has award?
     */
    public function hasAward( $member, $award )
    {
        if ( !$member instanceof \IPS\Member )
        {
            throw new \InvalidArgumentException( 'Invalid member' );
        }

        if ( !$award instanceof \IPS\awards\Awards )
        {
            throw new \InvalidArgumentException( 'Invalid award' );
        }

        return $award->hasAward( $member );
    }

    /**
     * Give award
     */
    public function awardTo( $member, $award, $giver, $values )
    {
        if ( !$member instanceof \IPS\Member )
        {
            throw new \InvalidArgumentException( 'Invalid receiving member' );
        }

        if ( !$award instanceof \IPS\awards\Awards )
        {
            throw new \InvalidArgumentException( 'Invalid award' );
        }

        if ( !$giver instanceof \IPS\Member )
        {
            throw new \InvalidArgumentException( 'Invalid giving member' );
        }

        try
        {
            $award->awardTo( $member, (bool) $values['awards_respect_permissions'], $giver );

            return 'Award given to member';
        } catch ( \InvalidArgumentException $e )
        {
            return 'No award given. Member does not have permission to receive it.';
        }
    }

    /**
     * Remove award
     */
    public function removeAward( $member, $award, $remover, $reason, $values )
    {
        if ( !$member instanceof \IPS\Member )
        {
            throw new \InvalidArgumentException( 'Invalid receiving member' );
        }

        if ( !$award instanceof \IPS\awards\Awards )
        {
            throw new \InvalidArgumentException( 'Invalid award' );
        }

        $removedCount = 0;

        foreach ( new \IPS\Patterns\ActiveRecordIterator( \IPS\Db::i()->select( '*', 'awards_awarded', array( 'awarded_member=? AND awarded_award=?', $member->member_id, $award->id ) ), 'IPS\awards\Awarded' ) as $awarded )
        {
            $awarded->remove( $reason, $remover );
            $removedCount ++;
        }

        if ( $removedCount )
        {
            return $removedCount . ' awards removed from member';
        } else
        {
            return 'Member did not have any of the specified award.';
        }
    }

}