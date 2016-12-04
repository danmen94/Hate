<?php
/**
 * @brief		RecordFeed Widget
 * @author		<a href='http://www.invisionpower.com'>Invision Power Services, Inc.</a>
 * @copyright	(c) 2001 - 2016 Invision Power Services, Inc.
 * @license		http://www.invisionpower.com/legal/standards/
 * @package		IPS Community Suite
 * @subpackage	Content
 * @since		24 Nov 2014
 * @version		SVN_VERSION_NUMBER
 */

namespace IPS\cms\widgets;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * RecordFeed Widget
 */
class _RecordFeed extends \IPS\Content\Widget
{
	/**
	 * @brief	Widget Key
	 */
	public $key = 'RecordFeed';
	
	/**
	 * @brief	App
	 */
	public $app = 'cms';
		
	/**
	 * @brief	Plugin
	 */
	public $plugin = '';
	
	/**
	 * Class
	 */
	protected static $class = 'IPS\cms\Records';

	/**
	 * Specify widget configuration
	 *
	 * @param	null|\IPS\Helpers\Form	$form	Form object
	 * @return	null|\IPS\Helpers\Form
	 */
	public function configuration( &$form=null )
	{
 		if ( $form === null )
		{
	 		$form = new \IPS\Helpers\Form;
 		}

		$databases = array();
		$database  = NULL;
		foreach( \IPS\cms\Databases::databases() as $obj )
		{
			if ( $obj->page_id )
			{
				$databases[ $obj->_id ] = $obj->_title;
			}
			
			if ( ( isset( \IPS\Request::i()->cms_rf_database ) AND $obj->id == \IPS\Request::i()->cms_rf_database ) OR ( ( isset( $this->configuration['cms_rf_database'] ) AND $obj->id == $this->configuration['cms_rf_database'] ) ) )
			{
				$database = $obj;
				static::$class = '\IPS\cms\Records' . $database->id;
			}
		}

		if ( isset( $this->configuration['cms_rf_database'] ) )
		{
			$form->addDummy( 'cms_rf_database', $database->_title, \IPS\Member::loggedIn()->language()->addToStack( 'cms_rf_database_description' ) );
			$form->hiddenValues['cms_rf_database'] = $database->_id;
		}
		else
		{
			$form->add( new \IPS\Helpers\Form\Select( 'cms_rf_database', 0, FALSE, array(
				'disabled' => false,
				'options'  => $databases
			) ) );
		}

		$form = parent::configuration( $form );

		/* Tags */
		if ( $database and $database->tags_enabled )
		{
			$options = array( 'autocomplete' => array( 'unique' => TRUE, 'source' => NULL, 'freeChoice' => TRUE ) );

			if ( \IPS\Settings::i()->tags_force_lower )
			{
				$options['autocomplete']['forceLower'] = TRUE;
			}

			if ( \IPS\Settings::i()->tags_clean )
			{
				$options['autocomplete']['filterProfanity'] = TRUE;
			}

			$options['autocomplete']['prefix'] = FALSE;

			$form->add( new \IPS\Helpers\Form\Text( 'widget_feed_tags', ( isset( $this->configuration['widget_feed_tags'] ) ? $this->configuration['widget_feed_tags'] : array( 'tags' => NULL ) ), FALSE, $options ) );
		}
		
		/* Any filterable fields */
		if ( $database )
		{
			$fieldClass   = 'IPS\cms\Fields' .  $database->id;
			foreach( $fieldClass::fields( $this->_getCustomValuesFromConfiguration(), 'view', NULL, $fieldClass::FIELD_SKIP_TITLE_CONTENT | $fieldClass::FIELD_DISPLAY_FILTERS ) as $id => $field )
			{
				$form->add( $field );
			}
		}
		
		if ( $database )
		{
			\IPS\Member::loggedIn()->language()->words['widget_feed_container_content_db_lang_su_' . $database->id ] = \IPS\Member::loggedIn()->language()->addToStack('widget_feed_container_cms');
		}
		
		return $form;
 	} 
 	
 	/**
	 * Fetch custom field values from the saved configuration
	 *
	 * @param	boolean	$keyAsInt	Returns an array with just the field ID, as opposed to 'field_x'
	 * @return array
	 */
 	protected function _getCustomValuesFromConfiguration( $keyAsInt=false )
 	{
	 	$customValues = array();
		foreach( $this->configuration as $k => $v )
		{
			if ( mb_substr( $k, 0, 8 ) === 'content_' )
			{
				$customValues[ $keyAsInt ? str_replace( 'content_field_', '', $k ) : mb_substr( $k, 8 ) ] = $v;
			}
		}
		
		return $customValues;
 	}
 	
 	/**
 	 * Ran before saving widget configuration
 	 *
 	 * @param	array	$values	Values from form
 	 * @return	array
 	 */
 	public function preConfig( $values )
 	{
	 	static::$class = '\IPS\cms\Records' . $values['cms_rf_database'];
	 	
	 	foreach( $values as $k => $v )
	 	{
		 	/* We need to reformat this a little */
		 	if ( is_array( $v ) and isset( $v['start'] ) and isset( $v['end'] ) )
		 	{
				$start = ( $v['start'] instanceof \IPS\DateTime ) ? $v['start']->getTimestamp() : intval( $v['start'] );
				$end   = ( $v['end'] instanceof \IPS\DateTime )   ? $v['end']->getTimestamp()   : intval( $v['end'] );
				
				$values[ $k ] = array( 'start' => $start, 'end' => $end );
			}
	 	}
	 	
	 	return parent::preConfig( $values );
 	}
 	
 	/**
	 * Get where clause
	 *
	 * @return	array
	 */
	protected function buildWhere()
	{
		$where = parent::buildWhere();

		$fieldClass   = 'IPS\cms\Fields' .  $this->configuration['cms_rf_database'];
		$customFields = $fieldClass::data( 'view', NULL, $fieldClass::FIELD_SKIP_TITLE_CONTENT | $fieldClass::FIELD_DISPLAY_FILTERS );

		if ( !isset( $this->configuration['widget_feed_use_perms'] ) or $this->configuration['widget_feed_use_perms'] )
		{
			$where['container'][] = array( 'category_can_view_others=1' );
		}
		foreach( $this->_getCustomValuesFromConfiguration( TRUE ) as $f => $v )
		{
			$k = 'field_' . $f;
			if ( isset( $customFields[ $f ] ) and $v !== '___any___' AND $v !== NULL )
			{
				if ( is_array( $v ) )
				{
					if ( array_key_exists( 'start', $v ) or array_key_exists( 'end', $v ) )
					{
						$start = ( $v['start'] instanceof \IPS\DateTime ) ? $v['start']->getTimestamp() : intval( $v['start'] );
						$end   = ( $v['end'] instanceof \IPS\DateTime )   ? $v['end']->getTimestamp()   : intval( $v['end'] );
						
						if ( $start or $end )
						{
							$where[] = array( '( ' . $k . ' BETWEEN ' . $start . ' AND ' . $end . ' )' );
						}
					}
					else
					{
						$like = array();
						if ( count( $v ) )
						{
							foreach( $v as $val )
							{
								if ( $val === 0 or ! empty( $val ) )
								{
									$like[]  = "CONCAT( ',', " .  $k . ", ',') LIKE '%," . \IPS\Db::i()->real_escape_string( $val ) . ",%'";
								}
							}
							
							$where[] = array( '( ' . \IPS\Db::i()->in( $k, $v ) .  ( count( $like ) ? " OR (" . implode( ' OR ', $like ) . ') )' : ')' ) );
						}
					}
				}
				else
				{
					if ( $v === false )
					{
						continue;
					}
					if ( $v !== 0 and ! $v )
					{
						$where[] = array( $k . " IS NULL" );
					}
					else
					{
						$where[] = array( $k . "=?", $v );
					}
				}
			}
		}
		
		return $where;
	}

	/**
	 * Render a widget
	 *
	 * @return	string
	 */
	public function render()
	{
		if( isset( $this->configuration['cms_rf_database'] ) )
		{
			try
			{
				$database = \IPS\cms\Databases::load($this->configuration['cms_rf_database']);
				static::$class = '\IPS\cms\Records' . $database->id;
				
				if ( ! $database->page_id )
				{
					throw new \OutOfRangeException;
				}
			}
			catch ( \OutOfRangeException $e )
			{
				return '';
			}
		}
		else
		{
			return '';
		}

		return parent::render();
	}
}