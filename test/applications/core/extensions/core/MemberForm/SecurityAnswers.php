<?php
/**
 * @brief		Admin CP Member Form
 * @author		<a href='http://www.invisionpower.com'>Invision Power Services, Inc.</a>
 * @copyright	(c) 2001 - 2016 Invision Power Services, Inc.
 * @license		http://www.invisionpower.com/legal/standards/
 * @package		IPS Community Suite
 * @since		28 Sep 2016
 * @version		SVN_VERSION_NUMBER
 */

namespace IPS\core\extensions\core\MemberForm;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * Admin CP Member Form
 */
class _SecurityAnswers
{
	/**
	 * Process Form
	 *
	 * @param	\IPS\Helpers\Form		$form	The form
	 * @param	\IPS\Member				$member	Existing Member
	 * @return	void
	 */
	public function process( &$form, $member )
	{		
		if ( \IPS\Settings::i()->security_questions_enabled and \IPS\Member::loggedIn()->hasAcpRestriction( 'core', 'members', 'member_security_answers' ) )
		{
			if ( \IPS\Settings::i()->security_questions_can_opt_out )
			{
				$form->add( new \IPS\Helpers\Form\YesNo( 'security_questions_opt_out_admin', $member->members_bitoptions['security_questions_opt_out'], FALSE, array( 'togglesOff' => array( 'security_answers' ) ) ) );
			}
			
			$securityQuestions = array();
			foreach ( \IPS\MFA\SecurityQuestions\Question::roots() as $question )
			{
				$securityQuestions[ $question->id ] = $question->_title;
			}
			
			$matrix = new \IPS\Helpers\Form\Matrix('security_question_matrix');
			$matrix->columns = array(
				'security_question_q'	=> function( $key, $value, $data ) use ( $securityQuestions )
				{
					return new \IPS\Helpers\Form\Select( $key, $value, FALSE, array( 'options' => $securityQuestions ) );
				},
				'security_question_a'	=> function( $key, $value, $data )
				{
					return new \IPS\Helpers\Form\Text( $key, $value );
				},
			);
			
			foreach ( $member->securityAnswers() as $questionId => $answer )
			{
				$matrix->rows[] = array(
					'security_question_q'	=> $questionId,
					'security_question_a'	=> \IPS\Text\Encrypt::fromTag( $answer )->decrypt()
				);
			}
			
			$form->addMatrix( 'security_answers', $matrix );
		}
	}
	
	/**
	 * Save
	 *
	 * @param	array				$values	Values from form
	 * @param	\IPS\Member			$member	The member
	 * @return	void
	 */
	public function save( $values, &$member )
	{
		if ( \IPS\Settings::i()->security_questions_enabled and \IPS\Member::loggedIn()->hasAcpRestriction( 'core', 'members', 'member_security_answers' ) )
		{
			$member->failed_security_answers = 0;
			\IPS\Db::i()->delete( 'core_security_answers', array( 'answer_member_id=?', $member->member_id ) );
			if ( \IPS\Settings::i()->security_questions_can_opt_out and $values['security_questions_opt_out_admin'] )
			{
				$member->members_bitoptions['security_questions_opt_out'] = TRUE;
				$member->members_bitoptions['has_security_answers'] = FALSE;
			}
			else
			{
				$member->members_bitoptions['security_questions_opt_out'] = FALSE;
				
				$toInsert = array();
				foreach ( $values['security_answers'] as $row )
				{
					if ( $row['security_question_a'] )
					{
						$toInsert[ $row['security_question_q'] ] = array(
							'answer_question_id'	=> $row['security_question_q'],
							'answer_member_id'		=> $member->member_id,
							'answer_answer'			=> (string) \IPS\Text\Encrypt::fromPlaintext( $row['security_question_a'] )->tag()
						);
					}
				}
				
				if ( count( $toInsert ) )
				{
					\IPS\Db::i()->insert( 'core_security_answers', $toInsert );
				}
				
				if ( count( $toInsert ) >= \IPS\Settings::i()->security_questions_number )
				{
					$member->members_bitoptions['has_security_answers'] = TRUE;
				}
				else
				{
					$member->members_bitoptions['has_security_answers'] = FALSE;
				}
			}
		}
	}
}