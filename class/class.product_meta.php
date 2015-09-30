<?php
if (!class_exists('Meta')){
	require_once 'class.meta.php';
}

/**
 * class ProductMeta
 * 
 */
class ProductMeta extends Meta {
	
	public $options = array();
	public $error 	= array();

	function __construct( $id_product = 0 ) {
		global $obj_bd;
		$this->class = 'ProductMeta';
		$this->type = "product";
		$this->template = DIRECTORY_VIEWS . "/lists/lst.product_option.php";
		$query = "SELECT "
					. " id_product_option, id_data_type, dt_data_type, pdo_label, pdo_options, pdo_timestamp, "
					. " IFNULL(pdm_pd_id_product,0) as id_product, pdm_value "
				. " FROM " . PFX_MAIN_DB . "product_option  "
					. " INNER JOIN " . PFX_MAIN_DB . "data_type 	ON pdo_dt_id_data_type = id_data_type "
					. "  LEFT JOIN " . PFX_MAIN_DB . "product_meta 	ON pdm_pdo_id_product_option = id_product_option AND pdm_pd_id_product = :id_product  "  
				. " WHERE pdo_status = 1 ORDER BY id_product_option ASC;";
		$opts = $obj_bd->query( $query, array( ':id_product' => $id_product ) ); 
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
		$resp->id_option 	= $option['id_product_option'];
		$resp->id_data_type	= $option['id_data_type'];
		$resp->data_type 	= $option['dt_data_type'];
		$resp->label	 	= stripslashes($option['pdo_label']);
		$resp->options	 	= stripslashes($option['pdo_options']); 
		$resp->timestamp 	= $option['pdo_timestamp'];
		$resp->id_product 	= $option['id_product']; 
		$resp->value	 	= stripslashes($option['pdm_value']);
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
			$query = "UPDATE " . PFX_MAIN_DB . "product_option SET " 
						. " pdo_status = 0, pdo_timestamp = :pdo_timestamp "
					. " WHERE id_product_option = :id_product_option  ";
			$result = $obj_bd->execute( $query, array( ':pdo_timestamp' => time(), ':id_product_option' => $id_option ) );
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
							':pdo_id_data_type'	=> $option->id_data_type,
							':pdo_label'		=> $option->label,
							':pdo_options'		=> $option->options,
							':pdo_timestamp'	=> time() 
						);
			
			if ( $option->id_option > 0 ){
				$query = "UPDATE " . PFX_MAIN_DB . "product_option SET "
							. " pdo_dt_id_data_type = :pdo_id_data_type, "
							. " pdo_label 			= :pdo_label, "
							. " pdo_options 		= :pdo_options, "
							. " pdo_status 			= 1, "
							. " pdo_timestamp 		= :pdo_timestamp "
						. " WHERE id_product_option = :id_product_option "; 
				$values[':id_product_option'] = $option->id_option;
			} else {
				$query = "INSERT INTO " . PFX_MAIN_DB . "product_option "
							. " ( pdo_dt_id_data_type, pdo_label, pdo_options, pdo_status, pdo_timestamp ) "
							. " VALUES ( :pdo_id_data_type, :pdo_label, :pdo_options, 1, :pdo_timestamp  ) ";
			} 
			$result = $obj_bd->execute( $query, $values );
			if ( $result !== FALSE ){ 
				return TRUE;
			} else {
				$this->set_error( "An error ocurred while trying to save the record. " , ERR_DB_EXEC, 3 );
				return FALSE;
			}
		}
	}

	public function save_values( $id_product ){
		if ( $id_product > 0 ) {
			global $obj_bd;
			$resp = TRUE;
			foreach ($this->options as $k => $option) {
				$query = "SELECT id_product_meta, pdm_value FROM " . PFX_MAIN_DB . "product_meta "
							. " WHERE pdm_pdo_id_product_option = :id_option " 
							. " AND pdm_pd_id_product = :id_product ";
				$values = array( ':id_option' => $option->id_option, ':id_product' => $id_product ); 
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
					$this->set_msg("MSG", print_r($option, TRUE));
					if ( count( $exist ) > 0 ){ 
						if ( $option->value != $exist[0]['pdm_value'] ){
							$query = " UPDATE " . PFX_MAIN_DB . "product_meta SET pdm_value = :pdm_value "
									. " WHERE pdm_pdo_id_product_option = :id_option  AND pdm_pd_id_product = :id_product  ";
						} else {
							$skip = TRUE;
						}
					} else {
						$query = " INSERT INTO " . PFX_MAIN_DB . "product_meta (pdm_pdo_id_product_option, pdm_pd_id_product, pdm_value ) "
								. " VALUES ( :id_option, :id_product, :pdm_value ) "; 
					}
					if ( !$skip ){ 
						$params = array( ':pdm_value' => $value, ':id_option' => $option->id_option, ':id_product' => $id_product ); 
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