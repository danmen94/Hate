<?php
/**
 * @brief		Security Questions
 * @author		<a href='http://www.invisionpower.com'>Invision Power Services, Inc.</a>
 * @copyright	(c) 2001 - 2016 Invision Power Services, Inc.
 * @license		http://www.invisionpower.com/legal/standards/
 * @package		IPS Community Suite
 * @since		26 Aug 2016
 * @version		SVN_VERSION_NUMBER
 */

namespace IPS\core\modules\admin\settings;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * Security Questions
 */
class _securityquestions extends \IPS\Node\Controller
{
	/**
	 * Node Class
	 */
	protected $nodeClass = '\IPS\MFA\SecurityQuestions\Question';
	
	/**
	 * Execute
	 *
	 * @return	void
	 */
	public function execute()
	{
		\IPS\Dispatcher::i()->checkAcpPermission( 'securityquestions_settings' );
		parent::execute();
	}
	
	/**
	 * Manage
	 *
	 * @return	void
	 */
	protected function manage()
	{
		$activeTabContents = '';
		$tabs = array( 'settings' => 'security_question_settings' );
		if ( \IPS\Settings::i()->security_questions_enabled )
		{
			$tabs['questions'] = 'security_questions';
		}
		$activeTab = ( isset( \IPS\Request::i()->tab ) and array_key_exists( \IPS\Request::i()->tab, $tabs ) ) ? \IPS\Request::i()->tab : 'settings';
		
		if ( $activeTab === 'settings' )
		{
			$activeTabContents = $this->_manageSettings();
		}
		else
		{
			$activeTabContents = $this->_manageQuestions();
		}
		
		\IPS\Output::i()->title = \IPS\Member::loggedIn()->language()->addToStack('menu__core_settings_securityquestions');
		if( \IPS\Request::i()->isAjax() )
		{
			\IPS\Output::i()->output = $activeTabContents;
		}
		else
		{
			\IPS\Output::i()->output = \IPS\Theme::i()->getTemplate( 'global' )->tabs( $tabs, $activeTab, $activeTabContents, \IPS\Http\Url::internal( "app=core&module=settings&controller=securityquestions" ) );
		}
	}
	
	/**
	 * Manage Settings
	 *
	 * @return	string
	 */
	protected function _manageSettings()
	{		
		$form = new \IPS\Helpers\Form;
		$form->add( new \IPS\Helpers\Form\YesNo( 'security_questions_enabled', \IPS\Settings::i()->security_questions_enabled, FALSE, array( 'togglesOn' => array( 'security_questions_prompt', 'security_questions_can_opt_out', 'security_questions_number', 'security_questions_areas', 'security_questions_tries', 'security_questions_timer' ) ) ) );
		$form->add( new \IPS\Helpers\Form\Radio( 'security_questions_prompt', \IPS\Settings::i()->security_questions_prompt, FALSE, array( 'options' => array( 'access' => 'security_questions_prompt_access', 'register' => 'security_questions_prompt_register' ) ), NULL, NULL, NULL, 'security_questions_prompt' ) );
		$form->add( new \IPS\Helpers\Form\YesNo( 'security_questions_can_opt_out', \IPS\Settings::i()->security_questions_can_opt_out, FALSE, array( 'togglesOn' => array( 'security_questions_opt_out_warning' ) ), NULL, NULL, NULL, 'security_questions_can_opt_out' ) );
		$form->add( new \IPS\Helpers\Form\Translatable( 'security_questions_opt_out_warning', NULL, FALSE, array( 'app' => 'core', 'key' => 'security_questions_opt_out_warning_value' ), NULL, NULL, NULL, 'security_questions_opt_out_warning' ) );
		$form->add( new \IPS\Helpers\Form\Number( 'security_questions_number', \IPS\Settings::i()->security_questions_number, FALSE, array( 'min' => 1, 'max' => \IPS\Db::i()->select( 'COUNT(*)', 'core_security_questions' )->first() ?: NULL ), NULL, NULL, NULL, 'security_questions_number' ) );
		$form->add( new \IPS\Helpers\Form\CheckboxSet( 'security_questions_areas', \IPS\Settings::i()->security_questions_areas ? explode( ',', \IPS\Settings::i()->security_questions_areas ) : array_keys( \IPS\MFA\MFAHandler::areas() ), FALSE, array( 'options' => \IPS\MFA\MFAHandler::areas() ), NULL, NULL, NULL, 'security_questions_areas' ) );
		$form->add( new \IPS\Helpers\Form\Number( 'security_questions_tries', \IPS\Settings::i()->security_questions_tries, FALSE, array( 'min' => 1 ), NULL, NULL, NULL, 'security_questions_tries' ) );
		$form->add( new \IPS\Helpers\Form\Number( 'security_questions_timer', \IPS\Settings::i()->security_questions_timer, FALSE, array( 'unlimited' => 0, 'unlimitedLang' => 'security_questions_timer_session' ), NULL, NULL, \IPS\Member::loggedIn()->language()->addToStack('minutes'), 'security_questions_timer' ) );
		
		if ( $values = $form->values() )
		{
			$values['security_questions_areas'] = implode( ',', $values['security_questions_areas'] );
			
			\IPS\Lang::saveCustom( 'core', 'security_questions_opt_out_warning_value', $values['security_questions_opt_out_warning'] );
			unset( $values['security_questions_opt_out_warning'] );
			
			$form->saveAsSettings( $values );			
			\IPS\Session::i()->log( 'acplogs__security_question_settings_edited' );
			
			\IPS\Output::i()->redirect( \IPS\Http\Url::internal( 'app=core&module=settings&controller=securityquestions&tab=settings' ), 'saved' );
		}
		
		return (string) $form;
	}
	
	/**
	 * Manage Questions
	 *
	 * @return	string
	 */
	protected function _manageQuestions()
	{
		parent::manage();
		return \IPS\Output::i()->output;
	}
	
	/**
	 * Redirect after save
	 *
	 * @param	\IPS\Node\Model	$old	A clone of the node as it was before or NULL if this is a creation
	 * @param	\IPS\Node\Model	$node	The node now
	 * @return	void
	 */
	protected function _afterSave( \IPS\Node\Model $old = NULL, \IPS\Node\Model $new )
	{
		if( \IPS\Request::i()->isAjax() )
		{
			\IPS\Output::i()->json( array() );
		}
		else
		{
			\IPS\Output::i()->redirect( $this->url->setQueryString( array( 'tab' => 'questions', 'root' => ( $new->parent() ? $new->parent()->_id : '' ) ) ), 'saved' );
		}
	}
}