//<?php

abstract class rules_hook_ipsPatternsActiveRecord extends _HOOK_CLASS_
{

	/**
	 * @brief	Cache for Rules Data
	 */
	protected $rulesData = array();
	
	/**
	 * @brief	Cache for Raw Rules Data
	 */
	protected $rulesDataRaw = NULL;
	
	/**
	 * @brief	Track Loaded Data Keys
	 */
	protected $rulesLoadedKeys = array();
	
	/**
	 * @brief	Track if all data has been loaded
	 */
	protected $rulesAllKeysLoaded = FALSE;
	
	/**
	 * @brief 	Flag for if rules data has been updated
	 */
	public $rulesDataChanged = FALSE;

	/**
	 * Save Changed Columns
	 *
	 * @return	void
	 */
	public function save()
	{
		try
		{
			if ( $this->_new )
			{
				$result = call_user_func_array( 'parent::save', func_get_args() );			
				\IPS\rules\Event::load( 'rules', 'System', 'record_updated' )->trigger( $this, $this->_data, TRUE );
				
				/* Core doesn't reset changed after saving new item */
				$this->changed = array();
			}
			else
			{
				$changed 		= $this->changed;
				$rulesDataChanged 	= $this->rulesDataChanged;
				
				$result = call_user_func_array( 'parent::save', func_get_args() );
				
				if ( ! empty( $changed ) or $rulesDataChanged )
				{
					\IPS\rules\Event::load( 'rules', 'System', 'record_updated' )->trigger( $this, $changed, FALSE );
				}
			}
			
			$this->rulesDataChanged = FALSE;
			return $result;
		}
		catch ( \RuntimeException $e )
		{
			if ( method_exists( get_parent_class(), __FUNCTION__ ) )
			{
				return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
			}
			else
			{
				throw $e;
			}
		}
	}

	/**
	 * [ActiveRecord] Delete Record
	 *
	 * @return	void
	 */
	public function delete()
	{
		try
		{
			$result = call_user_func_array( 'parent::delete', func_get_args() );
			\IPS\rules\Event::load( 'rules', 'System', 'record_deleted' )->trigger( $this );
			
			if ( $this->rulesTableExists() )
			{
				$idField = $this::$databaseColumnId;
				\IPS\Db::i()->delete( \IPS\rules\Data::getTableName( get_class( $this ) ), array( 'entity_id=?', $this->$idField ) );
			}
			
			return $result;
		}
		catch ( \RuntimeException $e )
		{
			if ( method_exists( get_parent_class(), __FUNCTION__ ) )
			{
				return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
			}
			else
			{
				throw $e;
			}
		}
	}
	
	/**
	 * Rules Data Class
	 */
	public static function rulesDataClass()
	{
		try
		{
			return '-' . str_replace( '\\', '-', get_called_class() );
		}
		catch ( \RuntimeException $e )
		{
			if ( method_exists( get_parent_class(), __FUNCTION__ ) )
			{
				return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
			}
			else
			{
				throw $e;
			}
		}
	}
	
	/**
	 * Get Raw Rules Data
	 */
	public function getRulesDataRaw()
	{
		try
		{
			if ( isset( $this->rulesDataRaw ) )
			{
				return $this->rulesDataRaw;
			}
			
			$idField = static::$databaseColumnId;
			
			try
			{
				$this->rulesDataRaw = \IPS\Db::i()->select( '*', \IPS\rules\Data::getTableName( get_class( $this ) ), array( 'entity_id=?', $this->$idField ) )->first();
			}
			catch ( \UnderflowException $e )
			{
				$this->rulesDataRaw = array();
			}
			
			return $this->rulesDataRaw;
		}
		catch ( \RuntimeException $e )
		{
			if ( method_exists( get_parent_class(), __FUNCTION__ ) )
			{
				return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
			}
			else
			{
				throw $e;
			}
		}
	}
	
	/**
	 * Get Rules Data With Permission Check
	 * @param 	string			$key		The data to retrieve/set
	 * @param 	\IPS\Member|NULL	$member		The member to check access against or NULL for currently logged in member
	 * @param	string			$permission	The permission to check
	 * @return 	mixed|NULL				Rules Data or NULL if member does not have permission
	 */
	public function getRulesDataWithPermission( $key, \IPS\Member $member=NULL, $permission='view' )
	{
		try
		{
			try
			{
				$data = \IPS\rules\Data::load( $key, 'data_column_name' );
				if ( $data->can( $permission, $member ) )
				{
					return $this->getRulesData( $key );
				}
			}
			catch ( \OutOfRangeException $e ) { }
			
			return NULL;
		}
		catch ( \RuntimeException $e )
		{
			if ( method_exists( get_parent_class(), __FUNCTION__ ) )
			{
				return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
			}
			else
			{
				throw $e;
			}
		}
	}
	
	/**
	 * Get Rules Data
	 *
	 * @param 	string|NULL		$key		The data to retrieve/set
	 * @return	array					Rules Data
	 */
	public function getRulesData( $key=NULL )
	{
		try
		{
			$idField 	= static::$databaseColumnId;
			$data_class 	= $this::rulesDataClass();
			
			if ( ! $this->$idField )
			{
				return $key ? NULL : array();
			}
			
			if ( isset( $key ) )
			{
				if ( array_key_exists( $key, $this->rulesData ) )
				{
					return $this->rulesData[ $key ];
				}
	
				$where = array( 'data_class=? AND data_column_name=?', $data_class, $key );
				
				/* Prevent subsequent requests for this key in any case */
				$this->rulesData[ $key ] = NULL;
			}
			else
			{
				if ( $this->rulesAllKeysLoaded )
				{
					return $this->rulesData;
				}
				
				$this->rulesAllKeysLoaded = TRUE;
				$where = array( 'data_class=?', $data_class );
			}
			
			if ( $this->rulesTableExists() and $data = $this->getRulesDataRaw() )
			{		
				foreach ( \IPS\rules\Data::roots( NULL, NULL, array( $where ) ) as $data_field )
				{
					if ( ! isset( $this->rulesLoadedKeys[ $data_field->column_name ] ) or $this->rulesLoadedKeys[ $data_field->column_name ] !== TRUE )
					{
						$data_field_data = $data[ 'data_' . $data_field->column_name ];
						
						/**
						 * If the database data is NULL, no need to proceed
						 */
						if ( ! isset ( $data_field_data ) )
						{
							$this->rulesData[ $data_field->column_name ] = NULL;
							$this->rulesLoadedKeys[ $data_field->column_name ] = TRUE;
							continue;
						}
						
						/**
						 * Check if this data only applies for specific containers
						 */
						if 
						( 
							/* Node */
							(
								$this instanceof \IPS\Node\Model and
								$nodeClass = get_class( $this )
							) 
							or
							/* Content Item */
							( 
								$this instanceof \IPS\Content\Item and 
								isset( $this::$containerNodeClass ) and 
								$nodeClass = $this::$containerNodeClass 
							)
						)
						{
							$configuration = json_decode( $data_field->configuration, TRUE ) ?: array();
							$containers = 'containers-' . str_replace( '\\', '-', $nodeClass );
							
							if ( isset( $configuration[ $containers ] ) and is_array( $configuration[ $containers ] ) )
							{
								$node_id = 0;
								if ( $this instanceof \IPS\Content\Item )
								{
									if ( $node = $this->containerWrapper() )
									{
										$node_id = $node->_id;
									}
								}
								else if ( $this instanceof \IPS\Node\Model )
								{
									$node_id = $this->_id;
								}
								
								if ( ! in_array( $node_id, $configuration[ $containers ] ) )
								{
									$this->rulesData[ $data_field->column_name ] = NULL;
									$this->rulesLoadedKeys[ $data_field->column_name ] = TRUE;
									continue;
								}
							}
						}
					
						switch ( $data_field->type )
						{
							case 'object':
							
								/**
								 * Specific object types are stored as an integer id
								 */
								if ( $data_field->type_class )
								{
									switch ( $data_field->type_class )
									{
										case '-IPS-DateTime':
										
											$data_field_data = \IPS\DateTime::ts( $data_field_data );
											break;
											
										case '-IPS-Http-Url':
										
											$data_field_data = new \IPS\Http\Url( $data_field_data );
											break;
										
										default:
										
											try
											{
												$objClass = str_replace( '-', '\\', $data_field->type_class );
												$data_field_data = $objClass::load( $data_field_data );
											}
											catch ( \Exception $e )
											{
												$data_field_data = NULL;
											}
									}
								}
								
								/**
								 * Arbitrary objects are stored as json encoded arguments
								 */
								else
								{
									$data_field_data = \IPS\rules\Application::restoreArg( json_decode( $data_field_data, TRUE ) );
								}
								break;
							
							case 'array':
								
								/**
								 * Arrays of certain object types are saved as comma separated lists
								 */
								if ( $data_field->type_class and $data_field->type_class !== '-IPS-Http-Url' )
								{
									$data_field_data = explode( ',', $data_field_data );
									$_data_field_data = array();
									$objClass = str_replace( '-', '\\', $data_field->type_class );
									
									foreach ( $data_field_data as $_id )
									{
										switch ( $data_field->type_class )
										{
											case '-IPS-DateTime':
											
												if ( ! $_id ) continue;
											
												$_data_field_data[ $_id ] = \IPS\DateTime::ts( $_id );
												break;
											
											default:
											
												try
												{
													$_data_field_data[ $_id ] = $objClass::load( $_id );
												}
												catch ( \Exception $e ) {}
										}
										
									}
									
									$data_field_data = $_data_field_data;
								}
								
								/**
								 * Arbitrary arrays are json_encoded
								 */
								else
								{
									$data_field_data = json_decode( $data_field_data, TRUE );
									$_data_field_data = array();
									if ( is_array ( $data_field_data ) )
									{
										foreach ( $data_field_data as $k => $value )
										{
											$result = \IPS\rules\Application::restoreArg( $value );
											if ( $result !== NULL )
											{
												$_data_field_data[ $k ] = $result;
											}
										}
										
										$data_field_data = $_data_field_data;
									}
									else
									{
										$data_field_data = array();
									}
								}
								break;
								
							case 'mixed':
							
								$data_field_data = \IPS\rules\Application::restoreArg( json_decode( $data_field_data, TRUE ) );
								break;
								
							case 'bool':
							
								$data_field_data = (bool) $data_field_data;
								break;
								
							case 'int':
								
								$data_field_data = (int) $data_field_data;
								break;
							
							case 'float':
							
								$data_field_data = (float) $data_field_data;
								break;
								
							case 'string':
							
								$data_field_data = (string) $data_field_data;
								break;
	
						}
						
						$this->rulesData[ $data_field->column_name ] = $data_field_data;
						$this->rulesLoadedKeys[ $data_field->column_name ] = TRUE;
					}
				}
			}
			
			return $key ? $this->rulesData[ $key ] : $this->rulesData;
		}
		catch ( \RuntimeException $e )
		{
			if ( method_exists( get_parent_class(), __FUNCTION__ ) )
			{
				return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
			}
			else
			{
				throw $e;
			}
		}
	}
	
	/**
	 * Get value from data store
	 *
	 * @param	mixed	$key	Key
	 * @return	mixed	Value from the datastore
	 */
	public function __get( $key )
	{
		try
		{
			/**
			 * Always return a core value if it is available
			 */
			$value = parent::__get( $key );
			if ( $value !== NULL or array_key_exists( $key, $this->_data ) )
			{
				return $value;
			}
			
			/**
			 * Check if we can load rules data for this key
			 */
			if ( $this->rulesTableExists() )
			{
				/* Use 'r_' prefix to get rules data, bypassing permission checks */
				if ( mb_substr( $key, 0, 2 ) == 'r_' and $this->rulesKeyExists( mb_substr( $key, 2 ) ) )
				{
					return $this->getRulesData( mb_substr( $key, 2 ) );
				}
				
				/* Get rules data with a permission check */
				if ( $this->rulesKeyExists( $key ) )
				{
					return $this->getRulesDataWithPermission( $key );
				}
			}
			
			return NULL;
		}
		catch ( \RuntimeException $e )
		{
			if ( method_exists( get_parent_class(), __FUNCTION__ ) )
			{
				return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
			}
			else
			{
				throw $e;
			}
		}
	}

	/**
	 * Set value in data store
	 *
	 * @see		\IPS\Patterns\ActiveRecord::save
	 * @param	mixed	$key	Key
	 * @param	mixed	$value	Value
	 * @return	void
	 */
	public function __set( $key, $value )
	{
		try
		{
			/**
			 * Core updates the "changed" array on any __set( $key, $value ).
			 * We only want that to happen if the value has ACTUALLY changed.
			 * This makes the changed array actually useful
			 */
			if( ! method_exists( $this, 'set_'.$key ) and array_key_exists( $key, $this->_data ) and $this->_data[ $key ] === $value )
			{
				return $value;
			}
			
			return parent::__set( $key, $value );
		}
		catch ( \RuntimeException $e )
		{
			if ( method_exists( get_parent_class(), __FUNCTION__ ) )
			{
				return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
			}
			else
			{
				throw $e;
			}
		}
	}

	/**
	 * Set Rules Data
	 *
	 * @param 	string|NULL	$key		The data to retrieve/set
	 * @param	mixed		$value		The value to set
	 * @return	array				Rules Data
	 */
	public function setRulesData( $key, $value )
	{
		try
		{
			$idField = static::$databaseColumnId;
			if ( ! $this->$idField )
			{
				return NULL;
			}
			
			if ( $this->rulesTableExists() )
			{
				if ( \IPS\Db::i()->checkForColumn( \IPS\rules\Data::getTableName( get_class( $this ) ), 'data_' . $key ) )
				{
					$save_value = NULL;
					$data_class = $this::rulesDataClass();
					$data_field = \IPS\rules\Data::load( $key, 'data_column_name', array( 'data_class=?', $data_class ) );
					
					/* Only continue if value has changed */
					$existingValue = $this->getRulesData( $key );
					if ( $value === $existingValue )
					{
						return FALSE;
					}
					
					if ( $value !== NULL )
					{											
						switch ( $data_field->type )
						{
							case 'object':
							
								if ( ! is_object( $value ) )
								{
									if ( ! $value )
									{
										$save_value = $value = NULL;
										break;
									}
									
									throw new \InvalidArgumentException( 'Value is expected to be an object. ' . gettype( $value ) . ' given.' );
								}
							
								if ( $data_field->type_class )
								{
									$objClass = ltrim( str_replace( '-', '\\', $data_field->type_class ), '\\' );
									
									if ( get_class( $value ) != $objClass )
									{
										throw new \InvalidArgumentException( 'Object is expected to be of class: \\' . $objClass );
									}
									
									switch ( $objClass ) 
									{
										case 'IPS\DateTime':
										
											$save_value = $value->getTimestamp();
											break;
											
										case 'IPS\Http\Url':
										
											$save_value = (string) $value;
											break;
											
										default:
										
											$_idField = $value::$databaseColumnId;
											$save_value = $value->$_idField;
									}
								}
								else
								{
									$save_value = json_encode( \IPS\rules\Application::storeArg( $value ) );
								}
								break;
								
							case 'array':
							
								if ( ! is_array( $value ) )
								{
									if ( ! $value )
									{
										$save_value = $value = NULL;
										break;
									}
									
									throw new \InvalidArgumentException( 'Value is expected to be an array' );
								}
								
								/**
								 * Url's should not be saved using comma seperation, so use json encoded format 
								 */
								if ( $data_field->type_class and $data_field->type_class !== '-IPS-Http-Url' )
								{
									$ids = array();
									$new_value = array();
									$objClass = ltrim( str_replace( '-', '\\', $data_field->type_class ), '\\' );
									
									foreach ( $value as $k => $obj )
									{
										if ( ! is_object( $obj ) or get_class( $obj ) != $objClass )
										{
											continue;
										}
										
										switch ( $objClass ) 
										{
											case 'IPS\DateTime':
											
												$ts = $obj->getTimestamp();
												$ids[] = $ts;
												$new_value[ $ts ] = $obj;
												break;
												
											default: 
											
												$_idField = $obj::$databaseColumnId;
												$ids[] = $obj->$_idField;
												$new_value[ $obj->$_idField ] = $obj;
												break;
										}
									}
									$save_value = implode( ',', array_unique( $ids ) );
									$value = $new_value;
								}
								else
								{
									$save_value = array();
									$new_value = array();
									foreach ( $value as $k => $v )
									{
										$result = \IPS\rules\Application::storeArg( $v );
										if ( $result !== NULL )
										{
											$save_value[ $k ] = $result;
											$new_value[ $k ] = $v;
										}
									}
									
									$save_value = json_encode( $save_value );
									$value = $new_value;
								}
								break;
								
							case 'mixed':
							
								$save_value = json_encode( \IPS\rules\Application::storeArg( $value ) );
								break;
								
							case 'int':
							
								$save_value = (int) $value;
								break;
								
							case 'float':
							
								$save_value = (float) $value;
								break;
								
							case 'bool':
							
								$save_value = (bool) $value;
								break;
								
							case 'string':
							
								$save_value = (string) $value;
								break;
								
							default:
							
								$save_value = $value;
								break;
						}
					}
					
					/**
					 * Update or create the database record
					 */
					if ( \IPS\Db::i()->select( 'COUNT(*)', \IPS\rules\Data::getTableName( get_class( $this ) ), array( 'entity_id=?', $this->$idField ) )->first() )
					{
						\IPS\Db::i()->update( \IPS\rules\Data::getTableName( get_class( $this ) ), array( 'data_' . $key => $save_value ), array( 'entity_id=?', $this->$idField ) );
					}
					else
					{
						\IPS\Db::i()->insert( \IPS\rules\Data::getTableName( get_class( $this ) ), array( 'entity_id' => $this->$idField, 'data_' . $key => $save_value ) );
					}
					
					$this->rulesDataRaw = \IPS\Db::i()->select( '*', \IPS\rules\Data::getTableName( get_class( $this ) ), array( 'entity_id=?', $this->$idField ) )->first();
					$this->rulesData[ $key ] = $value;
					$this->rulesDataChanged = TRUE;
					
					/* Trigger Event */
					$event_id = 'updated_' . $data_field->key;
					\IPS\rules\Event::load( 'rules', 'CustomData', $event_id )->trigger( $this, $value );
					
					return TRUE;
				}
				else
				{
					throw new \InvalidArgumentException( 'Data key doesnt exist' );
				}
			}
			
			return FALSE;
		}
		catch ( \RuntimeException $e )
		{
			if ( method_exists( get_parent_class(), __FUNCTION__ ) )
			{
				return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
			}
			else
			{
				throw $e;
			}
		}
	}
	
	/**
	 * @brief	Cache for data fields
	 */
	protected static $dataFields = array();
	
	/**
	 * Get Associated Rules Data Fields
	 *
	 * @param	string		$perm		The permission to check for
	 * @param	bool		$displayOnly	Check only for fields set to automatic display
	 * @param	bool		$withData	Return only fields for this record that have data
	 * @return	array
	 */
	public function rulesDataFields( $perm='view', $displayOnly=TRUE, $withData=TRUE )
	{
		try
		{
			$cache_key = $withData ? md5( json_encode( array( static::rulesDataClass(), $perm, $displayOnly, $this->activeid ) ) ) : md5( json_encode( array( static::rulesDataClass(), $perm, $displayOnly ) ) );
			
			if ( isset( static::$dataFields[ $cache_key ] ) )
			{
				return static::$dataFields[ $cache_key ];
			}
		
			$dataFields = array();
			$display_mode = $displayOnly ? " AND data_display_mode='automatic'" : '';
			$where = array( array( 'data_class=?' . $display_mode, static::rulesDataClass() ) );
			
			if ( $withData )
			{
				foreach( \IPS\rules\Data::roots( $perm, NULL, $where ) as $data )
				{
					if ( $this->getRulesData( $data->column_name ) !== NULL )
					{
						$dataFields[] = $data;
					}
				}
			}
			else
			{
				$dataFields = \IPS\rules\Data::roots( $perm, NULL, $where );
			}
			
			return static::$dataFields[ $cache_key ] = $dataFields;
		}
		catch ( \RuntimeException $e )
		{
			if ( method_exists( get_parent_class(), __FUNCTION__ ) )
			{
				return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
			}
			else
			{
				throw $e;
			}
		}
	}
	
	/**
	 * Check for data table
	 *
	 * @return	bool
	 */
	public function rulesTableExists()
	{
		try
		{
			static $tableExists = array();
			$table_name = \IPS\rules\Data::getTableName( get_class( $this ) );
			
			if ( ! isset ( $tableExists[ $table_name ] ) )
			{
				$tableExists[ $table_name ] = \IPS\Db::i()->checkForTable( $table_name );
			}
			
			return $tableExists[ $table_name ];
		}
		catch ( \RuntimeException $e )
		{
			if ( method_exists( get_parent_class(), __FUNCTION__ ) )
			{
				return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
			}
			else
			{
				throw $e;
			}
		}
	}
	
	/**
	 * @brief	Key Exists Cache
	 */
	protected static $keyExists = array();	
	
	/**
	 * Check for existence of data key
	 * 
	 * @param 	string		$key		The key to check
	 * @return	bool
	 */
	public function rulesKeyExists( $key )
	{		
				try
				{
			if ( isset( static::$keyExists[ get_class( $this ) ][ $key ] ) )
			{
				return static::$keyExists[ get_class( $this ) ][ $key ];
			}
	
			return static::$keyExists[ get_class( $this ) ][ $key ] = ( $this->rulesTableExists() and \IPS\Db::i()->checkForColumn( \IPS\rules\Data::getTableName( get_class( $this ) ), 'data_' . $key ) );
		}
		catch ( \RuntimeException $e )
		{
			if ( method_exists( get_parent_class(), __FUNCTION__ ) )
			{
				return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
			}
			else
			{
				throw $e;
			}
		}
	}
	
	/**
	 * Get Active Record ID
	 *
	 * @return	int		The active record id
	 */
	public function get_activeid()
	{
		try
		{
			$idField = static::$databaseColumnId;
			return $this->$idField;
		}
		catch ( \RuntimeException $e )
		{
			if ( method_exists( get_parent_class(), __FUNCTION__ ) )
			{
				return call_user_func_array( 'parent::' . __FUNCTION__, func_get_args() );
			}
			else
			{
				throw $e;
			}
		}
	}

}