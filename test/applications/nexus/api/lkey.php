<?php
/**
 * @brief		License Key API
 * @author		<a href='http://www.invisionpower.com'>Invision Power Services, Inc.</a>
 * @copyright	(c) 2001 - 2016 Invision Power Services, Inc.
 * @license		http://www.invisionpower.com/legal/standards/
 * @package		IPS Community Suite
 * @subpackage	Nexus
 * @since		10 Dec 2015
 * @version		SVN_VERSION_NUMBER
 */

namespace IPS\nexus\api;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * @brief	License Key API
 */
class _lkey extends \IPS\Api\Controller
{
	/**
	 * GET /nexus/lkey/{key}
	 * Get information about a specific purchase from its license key
	 *
	 * @param		string		$lkey			License key
	 * @throws		2X310/1		INVALID_KEY		The license key does not exist
	 * @return		\IPS\nexus\Purchase
	 */
	public function GETitem( $lkey )
	{
		try
		{
			$licenseKey = \IPS\nexus\Purchase\LicenseKey::load( $lkey );
			$purchase = $licenseKey->purchase;
			
			return new \IPS\Api\Response( 200, $purchase->apiOutput() );
		}
		catch ( \OutOfRangeException $e )
		{
			throw new \IPS\Api\Exception( 'INVALID_KEY', '2X332/1', 404 );
		}
	}
	
	/**
	 * POST /nexus/lkey/{key}
	 * Update custom fields for a purchase from its license key
	 *
	 * @apiparam	object		customFields	Values for custom fields
	 * @throws		2X310/2		INVALID_KEY		The license key does not exist
	 * @return		\IPS\nexus\Purchase
	 */
	public function POSTitem( $lkey )
	{
		try
		{	
			$licenseKey = \IPS\nexus\Purchase\LicenseKey::load( $lkey );
			$purchase = $licenseKey->purchase;		
		}
		catch ( \OutOfRangeException $e )
		{
			throw new \IPS\Api\Exception( 'INVALID_KEY', '2X332/2', 404 );
		}
		
		if ( isset( \IPS\Request::i()->customFields ) )
		{
			$customFields = $purchase->custom_fields;
			foreach ( \IPS\Request::i()->customFields as $k => $v )
			{
				$customFields[ $k ] = $v;
			}
			$purchase->custom_fields = $customFields;
		}
		
		$purchase->save();
		
		return new \IPS\Api\Response( 200, $purchase->apiOutput() );
	}
}