<?php
if (!class_exists('Meta')){
	require_once 'class.meta.php';
}

/**
 * class PDVMeta
 */
class PDVMeta extends Meta {
	
	public $options = array();
	public $error 	= array();
	
	function __construct( $id_pdv = 0 ) {
		global $obj_bd;
		$this->class = 'PDVMeta';
		$this->type = "pdv";
		$this->template = DIRECTORY_VIEWS . "/lists/lst.contact_option.php";
		$query = "SELECT "
					. " id_pdv_option, id_data_type, dt_data_type, pvo_label, pvo_options, pvo_timestamp, "
					. " IFNULL(pvm_pdv_id_pdv,0) as id_pdv, pvm_value "
				. " FROM " . PFX_MAIN_DB . "pdv_option "
					. " INNER JOIN " . PFX_MAIN_DB . "data_type ON pvo_dt_id_data_type = id_data_type "
					. "  LEFT JOIN " . PFX_MAIN_DB . "pdv_meta 	ON pvm_pvo_id_pdv_option = id_pdv_option AND pvm_pdv_id_pdv = :id_pdv  "  
				. " WHERE pvo_status = 1 ORDER BY id_pdv_option ASC;";
		$opts = $obj_bd->query( $query, array( ':id_pdv' => $id_pdv ) ); 
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
		$resp->id_option 	= $option['id_pdv_option'];
		$resp->id_data_type	= $option['id_data_type'];
		$resp->data_type 	= $option['dt_data_type'];
		$resp->label	 	= stripslashes($option['pvo_label']);
		$resp->options	 	= stripslashes($option['pvo_options']); 
		$resp->timestamp 	= $option['pvo_timestamp'];
		$resp->id_pdv 	= $option['id_pdv']; 
		$resp->value	 	= stripslashes($option['pvm_value']);
		return $resp;
	} 
	
	public function delete_option( $id_option = 0){
		global $Session;
		if ( $id_option > 0 && $Session->is_admin() ){
			global $obj_bd;
			$query = "UPDATE " . PFX_MAIN_DB . "pdv_option SET " 
						. " pvo_status = 0, pvo_timestamp = :pvo_timestamp "
					. " WHERE id_pdv_option = :id_pdv_option  ";
			$result = $obj_bd->execute( $query, array( ':pvo_timestamp' => time(), ':id_pdv_option' => $id_option ) );
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
		if (  $Session->is_admin()  ){
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
							':pvo_id_data_type'	=> $option->id_data_type,
							':pvo_label'		=> $option->label,
							':pvo_options'		=> $option->options,
							':pvo_timestamp'	=> time() 
						);
			
			if ( $option->id_option > 0 ){
				$query = "UPDATE " . PFX_MAIN_DB . "pdv_option SET "
							. " pvo_dt_id_data_type = :pvo_id_data_type, "
							. " pvo_label 			= :pvo_label, "
							. " pvo_options 		= :pvo_options, "
							. " pvo_status 			= 1, "
							. " pvo_timestamp 		= :pvo_timestamp "
						. " WHERE id_pdv_option = :id_pdv_option "; 
				$values[':id_pdv_option'] = $option->id_option;
			} else {
				$query = "INSERT INTO " . PFX_MAIN_DB . "pdv_option "
							. " ( pvo_dt_id_data_type, pvo_label, pvo_options, pvo_status, pvo_timestamp ) "
							. " VALUES ( :pvo_id_data_type, :pvo_label, :pvo_options, 1, :pvo_timestamp  ) ";
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

	public function save_values( $id_pdv ){
		if ( $id_pdv > 0 ) {
			global $obj_bd;
			$resp = TRUE;
			foreach ($this->options as $k => $option) {
				$query = "SELECT id_pdv_meta, pvm_value FROM " . PFX_MAIN_DB . "pdv_meta "
							. " WHERE pvm_pvo_id_pdv_option = :id_option " 
							. " AND pvm_pdv_id_pdv = :id_pdv ";
				$values = array( ':id_option' => $option->id_option, ':id_pdv' => $id_pdv ); 
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
						if ( $option->value != $exist[0]['pvm_value'] ){
							$query = " UPDATE " . PFX_MAIN_DB . "pdv_meta SET pvm_value = :pvm_value "
									. " WHERE pvm_pvo_id_pdv_option = :id_option  AND pvm_pdv_id_pdv = :id_pdv  ";
						} else {
							$skip = TRUE;
						}
					} else {
						$query = " INSERT INTO " . PFX_MAIN_DB . "pdv_meta (pvm_pvo_id_pdv_option, pvm_pdv_id_pdv, pvm_value ) "
								. " VALUES ( :id_option, :id_pdv, :pvm_value ) "; 
					}
					if ( !$skip ){ 
						$params = array( ':pvm_value' => $value, ':id_option' => $option->id_option, ':id_pdv' => $id_pdv ); 
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