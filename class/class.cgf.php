<?php
/**
* CGF CLass
* 
* @package		SF Tracker			
* @since        11/11/2014 
* 
*/ 
class CGF extends Object {
	 
	public $branches = array(); 
	
	/**
	* User()    
	* Creates a User object from the DB.
	*  
	* @param	$id_supplier (optional) If set populates values from DB record. 
	* 
	*/  
	function __construct( ){
		global $obj_bd;
		$this->error = array();
		$this->class = "CGF";
		 
	}
	
	/**
	 * get_channel()
	 * Returns a  the channel record form the DB for the $id_channel recieved
	 * 
	 * @param 	$id_channel 
	 */
	public function get_channel( $id_channel ){ 
		$channel = new stdClass;
		$channel->id_channel = 0;
		$channel->channel = ""; 
		if ( $id_channel > 0 ){
			global $obj_bd; 
			$query = "SELECT id_channel, ch_channel FROM " . PFX_MAIN_DB . "channel WHERE id_channel = :id_channel ";
			$resp = $obj_bd->query( $query, array( ':id_channel' => $id_channel ) );
			if ( $resp !== FALSE ){
				$ch = $resp[0]; 
				$channel->id_channel= $ch['id_channel'];
				$channel->channel 	= $ch['ch_channel'];  
			}
		}
		return $channel;
	}
	
	/**
	 * get_group()
	 * Returns a  the group record form the DB for the $id_group recieved
	 * 
	 * @param 	$id_group 
	 */
	public function get_group( $id_group ){ 
		$group = new stdClass;
		$group->id_group = 0;
		$group->id_channel= 0;
		$group->channel= "";
		$group->group = ""; 
		if ( $id_group > 0 ){
			global $obj_bd; 
			$query = "SELECT id_group, gr_ch_id_channel, gr_group FROM " . PFX_MAIN_DB . "group WHERE id_group = :id_group ";
			$resp = $obj_bd->query( $query, array( ':id_group' => $id_group ) );
			if ( $resp !== FALSE ){
				$ch = $resp[0]; 
				$group->id_group	= $ch['id_group'];
				$group->id_channel 	= $ch['gr_ch_id_channel'];  
				$group->group 		= $ch['gr_group'];  
			}
		}
		return $group;
	}
	
	/**
	 * get_format()
	 * Returns a  the format record form the DB for the $id_format recieved
	 * 
	 * @param 	$id_channel 
	 */
	public function get_format( $id_format ){ 
		$format = new stdClass;
		$format->id_channel	= 0;
		$format->id_group	= 0;
		$format->id_format 	= 0;
		$format->channel 	= "";
		$format->group 		= "";
		$format->format 	= ""; 
		if ( $id_format > 0 ){
			global $obj_bd; 
			$query = "SELECT id_format, id_group, fo_format, gr_group, gr_ch_id_channel FROM " . PFX_MAIN_DB . "format "
						. " INNER JOIN " . PFX_MAIN_DB . "group ON id_group = fo_gr_id_group"
					. "  WHERE id_format = :id_format ";
			$resp = $obj_bd->query( $query, array( ':id_format' => $id_format ) );
			if ( $resp !== FALSE ){
				$ch = $resp[0]; 
				$format->id_format	= $ch['id_format'];
				$format->id_group 	= $ch['id_group'];  
				$format->id_channel	= $ch['gr_ch_id_channel'];  
				$format->group 		= $ch['gr_group'];  
				$format->format 	= $ch['fo_format'];  
			}
		}
		return $format;
	}
	 
	/**
	* validate_channel()    
	* Validates the channel values before inputing to Data Base 
	*  
	* @return        Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate_channel( $channel ){ 
		global $Validate; 
		if ( !is_numeric($channel->id_channel) || $channel->id_channel < 0 ){
			$this->set_error( 'Invalid Id value ( ' . $channel->id_channel . ' ). ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( !$channel->channel != '' ){
			$this->set_error( 'Channel value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !$Validate->is_unique( 'channel', 'ch_channel', $channel->channel, 'id_channel', $channel->id_channel ) ){
			$this->set_error( 'Channel not unique. ', ERR_VAL_NOT_UNIQUE );
			return FALSE;
		} 
			
		return TRUE; 
	}
	
	/**
	* validate_group()    
	* Validates the group values before inputing to Data Base 
	*  
	* @return        Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate_group( $group ){ 
		global $Validate; 
		if ( !is_numeric($group->id_group) || $group->id_group < 0 ){
			$this->set_error( 'Invalid Id value ( ' . $group->id_group . ' ). ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( !is_numeric($group->id_channel) || $group->id_channel < 1 ){
			$this->set_error( 'Invalid Channel ID value ( ' . $group->id_channel. ' ). ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( !$group->group != '' ){
			$this->set_error( 'Group value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !$Validate->is_unique( 'group', 'gr_group', $group->group, 'id_group', $group->id_group, 'gr_ch_id_channel', $group->id_channel ) ){
			$this->set_error( 'Group not unique. ', ERR_VAL_NOT_UNIQUE );
			return FALSE;
		} 
			
		return TRUE; 
	}
	
	/**
	* validate_format()    
	* Validates the format values before inputing to Data Base 
	*  
	* @return        Boolean TRUE if valid; FALSE if invalid
	*/ 
	public function validate_format( $format ){ 
		global $Validate; 
		if ( !is_numeric($format->id_format) || $format->id_format < 0 ){
			$this->set_error( 'Invalid Id value ( ' . $format->id_format . ' ). ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( !is_numeric($format->id_group) || $format->id_group < 0 ){
			$this->set_error( 'Invalid Group ID value ( ' . $format->id_group. ' ). ', ERR_VAL_INVALID );
			return FALSE;
		} 
		if ( !$format->format != '' ){
			$this->set_error( 'Format value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !$Validate->is_unique( 'format', 'fo_format', $format->format, 'id_format', $format->id_format, 'fo_gr_id_group', $format->id_group ) ){
			$this->set_error( 'Format not unique. ', ERR_VAL_NOT_UNIQUE );
			return FALSE;
		} 
			
		return TRUE; 
	}
	
	/**
	* save_channel()    
	* Inserts or Update the record in the DB. 
	* 
	 * @param 	$channel Channel object
	*/  
	public function save_channel( $channel ){
		global $Session;
		if ( $Session->is_admin() ){ 
			if ( $this->validate_channel( $channel ) ){
				global $obj_bd;
				
				$values = array( ':ch_channel' => $channel->channel, ':ch_timestamp' => time() );
				if ( $channel->id_channel > 0 ){
					$values[':id_channel'] = $channel->id_channel;
					$query = " UPDATE " . PFX_MAIN_DB . "channel SET "  
								. " ch_channel	 = :ch_channel , " 
								. " ch_status	 = 1, "
								. " ch_timestamp = :ch_timestamp "
							. " WHERE id_channel = :id_channel ";
				} else {
					$query = "INSERT INTO " . PFX_MAIN_DB . "channel ( ch_channel, ch_status, ch_timestamp ) "
							. " VALUES  ( :ch_channel, 1, :ch_timestamp ) ";
				}  
				$result = $obj_bd->execute( $query, $values );
				if ( $result !== FALSE ){
					if ( $channel->id_channel == 0){
						$channel->id_channel = $obj_bd->get_last_id();
					}
					$this->set_msg('SAVE', " Channel " . $channel->id_channel . " saved. ");
					return TRUE;
				} else {
					$this->set_error( "An error ocurred while trying to save channel record. ", ERR_DB_EXEC, 3 );
					return FALSE;
				} 
			}
			
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
		}
	}

	/**
	* save_group()    
	* Inserts or Update the record in the DB. 
	* 
	 * @param 	$group Group object
	*/  
	public function save_group( $group ){
		global $Session;
		if ( $Session->is_admin() ){ 
			if ( $this->validate_group( $group ) ){
				global $obj_bd; 
				$values = array( ':id_channel' => $group->id_channel, ':gr_group' => $group->group, ':gr_timestamp' => time() );
				if ( $group->id_group > 0 ){
					$values[':id_group'] = $group->id_group;
					$query = " UPDATE " . PFX_MAIN_DB . "group SET "  
								. " gr_ch_id_channel = :id_channel , " 
								. " gr_group	 = :gr_group , " 
								. " gr_status	 = 1, "
								. " gr_timestamp = :gr_timestamp "
							. " WHERE id_group = :id_group ";
				} else {
					$query = "INSERT INTO " . PFX_MAIN_DB . "group ( gr_group, gr_ch_id_channel, gr_status, gr_timestamp ) "
							. " VALUES  ( :gr_group, :id_channel, 1, :gr_timestamp ) ";
				}  
				$result = $obj_bd->execute( $query, $values );
				if ( $result !== FALSE ){
					if ( $group->id_group == 0){
						$group->id_group = $obj_bd->get_last_id();
					}
					$this->set_msg('SAVE', " Group " . $group->id_group . " saved. ");
					return TRUE;
				} else {
					$this->set_error( "An error ocurred while trying to save group record. ", ERR_DB_EXEC, 3 );
					return FALSE;
				} 
			}
			
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
		}
	}

	/**
	* save_format()    
	* Inserts or Update the record in the DB. 
	* 
	 * @param 	$format Group object
	*/  
	public function save_format( $format ){
		global $Session;
		if ( $Session->is_admin() ){ 
			if ( $this->validate_format( $format ) ){
				global $obj_bd; 
				$values = array( ':id_group' => $format->id_group, ':fo_format' => $format->format, ':fo_timestamp' => time() );
				if ( $format->id_format > 0 ){
					$values[':id_format'] = $format->id_format;
					$query = " UPDATE " . PFX_MAIN_DB . "format SET "  
								. " fo_gr_id_group = :id_group , " 
								. " fo_format	 = :fo_format , " 
								. " fo_status	 = 1, "
								. " fo_timestamp = :fo_timestamp "
							. " WHERE id_format = :id_format ";
				} else {
					$query = "INSERT INTO " . PFX_MAIN_DB . "format ( fo_format, fo_gr_id_group, fo_status, fo_timestamp ) "
							. " VALUES  ( :fo_format, :id_group, 1, :fo_timestamp ) ";
				}  
				$result = $obj_bd->execute( $query, $values );
				if ( $result !== FALSE ){
					if ( $format->id_format == 0){
						$format->id_format = $obj_bd->get_last_id();
					} 
					$this->set_msg('SAVE', " Format " . $format->id_format. " saved. ");
					return TRUE;
				} else {
					$this->set_error( "An error ocurred while trying to save format record. ", ERR_DB_EXEC, 3 );
					return FALSE;
				} 
			}
			
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
			return FALSE;
		}
	} 
	 
	/**
	* delete_channel()    
	* Changes status for Channel to 0 in the DB.
	*
	* @param	$id_channel
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete_channel( $id_channel ){
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "channel SET ch_status = 0 WHERE id_channel = :id_channel ";
			$result = $obj_bd->execute( $query, array( ':id_channel' => $id_channel ) );
			if ( $result !== FALSE ){
				$this->set_msg('DELETE', " Channel " . $id_channel . " deleted. "); 
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to set status to 0. ", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		}
	}
	
	/**
	* delete_group()    
	* Changes status for Group to 0 in the DB.
	*
	* @param	$id_group
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete_group( $id_group ){
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "group SET gr_status = 0 WHERE id_group = :id_group ";
			$result = $obj_bd->execute( $query, array( ':id_group' => $id_group ) );
			if ( $result !== FALSE ){
				$this->set_msg('DELETE', " Group " . $id_group . " deleted. ");
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to set status to 0. ", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		}
	}
	
	/**
	* delete_format()    
	* Changes status for Format to 0 in the DB.
	*
	* @param	$id_format  
	* @return 	TRUE on success; FALSE otherwise 
	*/  
	public function delete_format( $id_format ){
		global $Session;
		if ( $Session->is_admin() ){
			global $obj_bd;
			$query = " UPDATE "  . PFX_MAIN_DB . "format SET fo_status = 0 WHERE id_format = :id_format ";
			$result = $obj_bd->execute( $query, array( ':id_format' => $id_format ) );
			if ( $result !== FALSE ){ 
				$this->set_msg('DELETE', " Format " . $id_format . " deleted. ");
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to set status to 0. ", ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		}
	} 
	 
}

?>