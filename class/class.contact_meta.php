<?php
if (!class_exists('Meta')){
	require_once 'class.meta.php';
}

/**
 * class ContactMeta
 * 
 */
class ContactMeta extends Meta {
	
	public $options = array();
	public $error 	= array();

	function __construct( $id_contact = 0 ) {
		global $obj_bd;
		$this->class = 'ContactMeta';
		$this->type = "contact";
		$query = "SELECT "
					. " id_contact_option, id_data_type, dt_data_type, cop_label, cop_options, cop_timestamp, "
					. " IFNULL(cm_co_id_contact,0) as id_contact, cm_value "
				. " FROM " . PFX_MAIN_DB . "contact_option  "
					. " INNER JOIN " . PFX_MAIN_DB . "data_type 	ON cop_dt_id_data_type = id_data_type "
					. "  LEFT JOIN " . PFX_MAIN_DB . "contact_meta 	ON cm_cop_id_contact_option = id_contact_option AND cm_co_id_contact = :id_contact  "  
				. " WHERE cop_status = 1 ORDER BY id_contact_option ASC;";
		$opts = $obj_bd->query( $query, array( ':id_contact' => $id_contact ) ); 
		if ( $opts !== FALSE ){
			if (count($opts) > 0 ){
				foreach ($opts as $k => $opt) {
					$this->options[] = $this->format_option( $opt );
				}
			}
		}else {
			$this->set_error( "Could not retrieve options ", ERR_DB_QRY, 2);
			return NULL;
		}
	}
	
	private function format_option( $option ){
		$resp = new stdClass;
		$resp->id_option 	= $option['id_contact_option'];
		$resp->id_data_type	= $option['id_data_type'];
		$resp->data_type 	= $option['dt_data_type'];
		$resp->label	 	= stripslashes($option['cop_label']);
		$resp->options	 	= stripslashes($option['cop_options']); 
		$resp->timestamp 	= $option['cop_timestamp'];
		$resp->id_contact 	= $option['id_contact']; 
		$resp->value	 	= stripslashes($option['cm_value']);
		return $resp;
	}
	
	public function get_option( $id ){
		foreach ($this->options as $k => $option) {
			if ( $option->id_option == $id )
				return $option;
		}
		return FALSE;
	}
	
	public function delete_option( $id_option = 0){
		global $Session;
		if ( $id_option > 0 && $Session->is_admin() ){
			global $obj_bd;
			$query = "UPDATE " . PFX_MAIN_DB . "contact_option SET " 
						. " cop_status = 0, cop_timestamp = :cop_timestamp "
					. " WHERE id_contact_option = :id_contact_option  ";
			$result = $obj_bd->execute( $query, array( ':cop_timestamp' => time(), ':id_contact_option' => $id_option ) );
			if ( $result !== FALSE ){ 
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to save the record. ", ERR_DB_EXEC, 3 );
				return FALSE;
			}
		}
	}
	
	public function save_option( $option ){
		global $Session;
		if ( $Session->is_admin() ){
			global $Validate;
			global $obj_bd;
			
			if ( !( $Validate->is_number( $option->id_option ) && $option->id_option >= 0 ) ){
				$this->set_error('Invalid option ID.', ERR_VAL_NOT_INT );
				return FALSE;
			}
			if ( !( $Validate->is_number( $option->id_data_type ) && $option->id_data_type > 0 ) ){
				$this->set_error('Invalid data type ID.', ERR_VAL_NOT_INT );
				return FALSE;
			}
			if ( !( $option->label != '' ) ){
				$this->set_error('Invalid Label.', ERR_VAL_EMPTY );
				return FALSE;
			}
			
			$values = array( 
							':cop_id_data_type'	=> $option->id_data_type,
							':cop_label'		=> $option->label,
							':cop_options'		=> $option->options,
							':cop_timestamp'	=> time() 
						);
			
			if ( $option->id_option > 0 ){
				$query = "UPDATE " . PFX_MAIN_DB . "contact_option SET "
							. " cop_dt_id_data_type = :cop_id_data_type, "
							. " cop_label 			= :cop_label, "
							. " cop_options 		= :cop_options, "
							. " cop_status 			= 1, "
							. " cop_timestamp 		= :cop_timestamp "
						. " WHERE id_contact_option = :id_contact_option "; 
				$values[':id_contact_option'] = $option->id_option;
			} else {
				$query = "INSERT INTO " . PFX_MAIN_DB . "contact_option "
							. " ( cop_dt_id_data_type, cop_label, cop_options, cop_status, cop_timestamp ) "
							. " VALUES ( :cop_id_data_type, :cop_label, :cop_options, 1, :cop_timestamp  ) ";
			} 
			$result = $obj_bd->execute( $query, $values );
			if ( $result !== FALSE ){ 
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to save the record. ", ERR_DB_EXEC, 3 );
				return FALSE;
			}
		}
	}

	public function save_values( $id_contact ){
		if ( $id_contact > 0 ) {
			global $obj_bd;
			$resp = TRUE;
			foreach ($this->options as $k => $option) {
				$query = "SELECT id_contact_meta, cm_value FROM " . PFX_MAIN_DB . "contact_meta "
							. " WHERE cm_cop_id_contact_option = :id_option " 
							. " AND cm_co_id_contact = :id_contact ";
				$values = array( ':id_option' => $option->id_option, ':id_contact' => $id_contact ); 
				$exist = $obj_bd->query( $query, $values );
				if ( $exist !== FALSE ){
					$skip = FALSE;
					if ( is_array( $option->value ) ){
						$value = "";
						foreach ($option->value as $k => $val) {
							$value  .= ($k>0 ? ";" : "") . $val;
						}
					} else {
						$value = $option->value;
					}
					
					if ( count( $exist ) > 0 ){ 
						if ( $option->value != $exist[0]['cm_value'] ){
							$query = " UPDATE " . PFX_MAIN_DB . "contact_meta SET cm_value = :cm_value "
									. " WHERE cm_cop_id_contact_option = :id_option  AND cm_co_id_contact = :id_contact  ";
						} else {
							$skip = TRUE;
						}
					} else {
						$query = " INSERT INTO " . PFX_MAIN_DB . "contact_meta (cm_cop_id_contact_option, cm_co_id_contact, cm_value ) "
								. " VALUES ( :id_option, :id_contact, :cm_value ) "; 
					}
					if ( !$skip ){ 
						$params = array( ':cm_value' => $value, ':id_option' => $option->id_option, ':id_contact' => $id_contact ); 
						$result = $obj_bd->execute( $query, $params );
						$resp 	= ($resp && $result);
					}
				}
			} 
			return $resp;
		}
	}
}
?>