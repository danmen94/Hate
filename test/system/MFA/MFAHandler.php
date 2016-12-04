<?php
/**
 * @brief		Abstract Multi Factor Authentication Handler and Factory
 * @author		<a href='http://www.invisionpower.com'>Invision Power Services, Inc.</a>
 * @copyright	(c) 2001 - 2016 Invision Power Services, Inc.
 * @license		http://www.invisionpower.com/legal/standards/
 * @package		IPS Community Suite
 * @since		26 Aug 2016
 * @version		SVN_VERSION_NUMBER
 */

namespace IPS\MFA;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * Abstract Multi Factor Authentication Handler and Factory
 */
abstract class _MFAHandler
{
	/**
	 * Get areas
	 *
	 * @return	array
	 */
	public static function areas()
	{
		$return = array();
		foreach ( \IPS\Application::allExtensions( 'core', 'MFAArea', FALSE, 'core', NULL, FALSE ) as $k => $v )
		{
			$return[ $k ] = "MFA_{$k}";
		}
		return $return;
	}
	
	/**
	 * Get handlers
	 *
	 * @return	array
	 */
	public static function handlers()
	{
		return array( new \IPS\MFA\SecurityQuestions\Handler() );
	}
	
	/**
	 * Display output when trying to access an area
	 *
	 * @param	string			$app	The application which owns the MFAArea extension
	 * @param	string			$area	The MFAArea key
	 * @param	\IPS\Http\Url	$url	URL for page
	 * @return	string
	 */
	public static function accessToArea( $app, $area, \IPS\Http\Url $url )
	{
		/* If MFA is not enabled for this area, do nothing */
		if ( !\IPS\Settings::i()->security_questions_areas or !in_array( "{$app}_{$area}", explode( ',', \IPS\Settings::i()->security_questions_areas ) ) )
		{
			return NULL;
		}
		
		/* Find a handler. Because only one exists at the moment, we just use the first one we find */
		$acceptableHandlers = array();
		foreach ( static::handlers() as $handler )
		{
			/* If it's enabled and we can use it... */
			if ( $handler->isEnabled() and $handler->memberCanUseHandler( \IPS\Member::loggedIn() ) )
			{
				/* If we have configured it... */
				if ( $handler->memberHasConfiguredHandler( \IPS\Member::loggedIn() ) )
				{
					/* We can check if we're authenticated... */
					if ( $handler->memberIsAuthenticated( \IPS\Member::loggedIn() ) )
					{
						return NULL;
					}
					/* And if not, show the authentication form */
					else
					{
						$authenticationForm = $handler->authenticationForm( \IPS\Member::loggedIn(), $url );
						if ( $authenticationForm )
						{
							return $authenticationForm;
						}
					}
				}
				/* If not, show the configuration form */
				else
				{
					return $handler->configurationForm( \IPS\Member::loggedIn(), $url );
				}
			}
		}
		
		/* Still here? There are no handlers so they can just go ahead */
		return NULL;
	}
	
	/**
	 * Handler is enabled
	 *
	 * @return	bool
	 */
	abstract public function isEnabled();
	
	/**
	 * Member *can* use this handler (even if they have not yet configured it)
	 * If they have opted out, will return false
	 *
	 * @param	\IPS\Member	$member	The member
	 * @return	bool
	 */
	abstract public function memberCanUseHandler( \IPS\Member $member );
	
	/**
	 * Member has configured this handler
	 *
	 * @param	\IPS\Member	$member	The member
	 * @return	bool
	 */
	abstract public function memberHasConfiguredHandler( \IPS\Member $member );
	
	/**
	 * Get the form for a member to configure
	 *
	 * @param	\IPS\Member		$member					The member
	 * @param	\IPS\Http\Url	$url					URL for page
	 * @param	bool			$isManualConfiguration	Set to TRUE if the user is setting up manually rather than when trying to access a protected area
	 * @return	string
	 */
	abstract public function configurationForm( \IPS\Member $member, \IPS\Http\Url $url, $isManualConfiguration = FALSE );
	
	/**
	 * Is the member authenticated?
	 *
	 * @param	\IPS\Member		$member	The member
	 * @return	bool
	 */
	abstract public function memberIsAuthenticated( \IPS\Member $member );
	
	/**
	 * Get the form for a member to authenticate
	 *
	 * @param	\IPS\Member		$member	The member
	 * @param	\IPS\Http\Url	$url	URL for page
	 * @return	string
	 */
	abstract public function authenticationForm( \IPS\Member $member, \IPS\Http\Url $url );
	
}