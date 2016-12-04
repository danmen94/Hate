<?php
/**
 * @brief		Multi Factor Authentication Handler for Security Questions
 * @author		<a href='http://www.invisionpower.com'>Invision Power Services, Inc.</a>
 * @copyright	(c) 2001 - 2016 Invision Power Services, Inc.
 * @license		http://www.invisionpower.com/legal/standards/
 * @package		IPS Community Suite
 * @since		2 Sep 2016
 * @version		SVN_VERSION_NUMBER
 */

namespace IPS\MFA\SecurityQuestions;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * Multi Factor Authentication Handler for Security Questions
 */
class _Handler extends \IPS\MFA\MFAHandler
{
	/**
	 * Handler is enabled
	 *
	 * @return	bool
	 */
	public function isEnabled()
	{
		return \IPS\Settings::i()->security_questions_enabled;
	}
	
	/**
	 * Member *can* use this handler (even if they have not yet configured it)
	 * If they have opted out, will return false
	 *
	 * @return	bool
	 */
	public function memberCanUseHandler( \IPS\Member $member )
	{
		return \IPS\Settings::i()->security_questions_can_opt_out ? ( !$member->members_bitoptions['security_questions_opt_out'] ) : TRUE;
	}
	
	/**
	 * Member has configured this handler
	 *
	 * @return	bool
	 */
	public function memberHasConfiguredHandler( \IPS\Member $member )
	{
		return $member->members_bitoptions['has_security_answers'];
	}
	
	/**
	 * Get the form for a member to configure
	 *
	 * @param	\IPS\Member		$member					The member
	 * @param	\IPS\Http\Url	$url					URL for page
	 * @param	bool			$isManualConfiguration	Set to TRUE if the user is setting up manually rather than when trying to access a protected area
	 * @return	string
	 */
	public function configurationForm( \IPS\Member $member, \IPS\Http\Url $url, $isManualConfiguration=FALSE )
	{
		$securityQuestions = array();
		foreach ( Question::roots() as $question )
		{
			$securityQuestions[ $question->id ] = $question->_title;
		}
				
		$form = new \IPS\Helpers\Form( 'security_question_form', 'save', $url );
		$form->class = 'ipsForm_vertical';
		foreach ( range( 1, min( \IPS\Settings::i()->security_questions_number ?: 3, count( $securityQuestions ) ) ) as $i )
		{
			$questionField = new \IPS\Helpers\Form\Select( 'security_question_q_' . $i, NULL, TRUE, array( 'options' => $securityQuestions ) );
			$questionField->label = \IPS\Member::loggedIn()->language()->addToStack('security_question_q');

			$answerField = new \IPS\Helpers\Form\Text( 'security_question_a_' . $i, NULL, TRUE );
			$answerField->label = \IPS\Member::loggedIn()->language()->addToStack('security_question_a');
			
			$form->add( $questionField );
			$form->add( $answerField );
		}
		
		if ( \IPS\Settings::i()->security_questions_can_opt_out )
		{
			$form->addButton( 'security_questions_optout', 'link', $url->setQueryString( '_securityOptOut', 1 ), 'ipsButton ipsButton_link', array( 'name' => 'optout', 'data-confirm' => '', 'data-confirmSubMessage' => \IPS\Member::loggedIn()->language()->checkKeyExists('security_questions_opt_out_warning_value') ? \IPS\Member::loggedIn()->language()->addToStack('security_questions_opt_out_warning_value') : '' ) );
			if ( isset( \IPS\Request::i()->_securityOptOut ) )
			{
				$member->members_bitoptions['security_questions_opt_out'] = TRUE;
				$member->save();
				\IPS\Output::i()->redirect( $url );
			}
		}
				
		if ( $values = $form->values() )
		{
			$answers = array();
			foreach ( $values as $k => $v )
			{
				if ( preg_match( '/^security_question_q_(\d+)$/', $k, $matches ) )
				{
					if ( isset( $answers[ $v ] ) )
					{
						$form->error = \IPS\Member::loggedIn()->language()->addToStack('security_questions_unique');
						break;
					}
					else
					{
						$answers[ $v ] = array(
							'answer_question_id'	=> $v,
							'answer_member_id'		=> $member->member_id,
							'answer_answer'			=> \IPS\Text\Encrypt::fromPlaintext( $values[ 'security_question_a_' . $matches[1] ] )->tag()
						);
					}
				}
			}
			
			if ( !$form->error )
			{				
				\IPS\Db::i()->delete( 'core_security_answers', array( 'answer_member_id=?', $member->member_id ) );
				\IPS\Db::i()->insert( 'core_security_answers', $answers );
				
				$member->members_bitoptions['has_security_answers'] = TRUE;
				$member->members_bitoptions['security_questions_opt_out'] = FALSE;
				$member->save();
				
				\IPS\Output::i()->redirect( $url->setQueryString( '_securityQuestionSetup', 1 ) );
			}
		}
		
		return \IPS\Theme::i()->getTemplate( 'system', 'core' )->securityQuestionsSetup( $form, $isManualConfiguration );
	}
	
	/**
	 * Is the member authenticated?
	 *
	 * @param	\IPS\Member		$member	The member
	 * @return	bool
	 */
	public function memberIsAuthenticated( \IPS\Member $member )
	{
		if ( isset( $_SESSION['securityQuestionAnswered'] ) and ( !\IPS\Settings::i()->security_questions_timer or ( ( $_SESSION['securityQuestionAnswered'] + ( \IPS\Settings::i()->security_questions_timer * 60 ) ) > time() ) ) )
		{
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Get the form for a member to authenticate
	 *
	 * @param	\IPS\Member		$member	The member
	 * @param	\IPS\Http\Url	$url	URL for page
	 * @return	string
	 */
	public function authenticationForm( \IPS\Member $member, \IPS\Http\Url $url )
	{		
		/* Select a question/answer */
		try
		{
			$chosenAnswer = \IPS\Db::i()->select( '*', 'core_security_answers', array( 'answer_member_id=? AND answer_is_chosen=1', $member->member_id ) )->first();
			$chosenQuestion = Question::load( $chosenAnswer['answer_question_id'] );
		}
		catch ( \UnderflowException $e )
		{
			$chosenQuestion = NULL;
			foreach ( \IPS\Db::i()->select( '*', 'core_security_answers', array( 'answer_member_id=?', $member->member_id ), 'RAND()' ) as $chosenAnswer )
			{
				try
				{
					$chosenQuestion = Question::load( $chosenAnswer['answer_question_id'] );
					\IPS\Db::i()->update( 'core_security_answers', array( 'answer_is_chosen' => 1 ), array( 'answer_member_id=? AND answer_question_id=?', $member->member_id, $chosenQuestion->id ) );
					break;
				}
				catch ( \OutOfRangeException $e ) { }
			}
			if ( !$chosenQuestion )
			{
				return NULL;
			}
		}
		$chosenAnswer = \IPS\Text\Encrypt::fromTag( $chosenAnswer['answer_answer'] )->decrypt();
		
		/* Build form */
		$form = new \IPS\Helpers\Form( 'securityanswer', 'continue' );
		$form->class = 'ipsForm_vertical';
		$field = new \IPS\Helpers\Form\Text( 'answer', NULL, TRUE, array(), function( $val ) use ( $chosenAnswer, $member ) {
			if ( $chosenAnswer !== $val )
			{
				$member->failed_security_answers++;
				$member->save();
				
				throw new \DomainException('security_answer_incorrect');
			}
		} );
		$field->label = $chosenQuestion->_title;
		$form->add( $field );
		$form->addButton( 'security_answer_forgot', 'link', \IPS\Http\Url::internal( 'app=core&module=system&controller=settings&area=securityquestionsforgot', 'front', 'securityquestionsforgot' ) );
				
		/* If a submission was managed, we're validated */
		if ( $form->values() )
		{
			$member->failed_security_answers = 0;
			$member->save();
			\IPS\Db::i()->update( 'core_security_answers', array( 'answer_is_chosen' => 0 ), array( 'answer_member_id=?', $member->member_id ) );
			$_SESSION['securityQuestionAnswered'] = time();
			return NULL;
		}
		
		/* Have we got this incorrect too many times? */
		if ( $member->failed_security_answers >= \IPS\Settings::i()->security_questions_tries )
		{
			return \IPS\Theme::i()->getTemplate( 'system', 'core' )->securityQuestionsFail( \IPS\Http\Url::internal( 'app=core&module=system&controller=settings&area=securityquestionsforgot', 'front', 'securityquestionsforgot' ) );
		}
		
		/* Otherwise, show the form */
		return \IPS\Theme::i()->getTemplate( 'system', 'core' )->securityQuestionsForm( $form );
	}
}