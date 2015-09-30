<?php
if ( !class_exists( "Loader" ) ){
	require_once DIRECTORY_CLASS . "class.loader.php";
}

/**
 * class PDVLoader
 */
class PDVLoader extends Loader {
	
	private $PDV;
	private $divisions; 
	private $channels; 
	private $states; 
	
	function __construct( ){ 
		if ( !class_exists( "AdminPDV" ) ){
			require_once DIRECTORY_CLASS . "class.admin.pdv.php";
		}
		$this->class 	 = "PDVLoader";
		$this->line 	 = 0;
		$this->processed = 0;
		$this->saved 	 = 0;
		$this->divisions = array();
		$this->channels	 = array();
		$this->states	 = array(); 
		$this->PDV 	 	 = new AdminPDV(0);
	}
	
	public function load_uploaded_file( $file ){
		if ( !class_exists( "FileManager" ) ){
			require_once DIRECTORY_CLASS . "class.file.manager.php";
		}
		$fm = new FileManager();
		$response = $fm->save_uploaded( $file, DIRECTORY_UPLOADS . "pdv_tmpl_" . date( 'YmdHis' ) , 7 );
		
		if ( $response !== FALSE ){ 
			return $this->process_file( $response->location ); 
		} else {
			$this->error[] = $fm->error[ count($fmanager->error) - 1 ];
			return FALSE;
		}
	}
	
	private function process_file( $route ){ 
		if ( $this->open_file( $route ) ){ 
			$line = 0;
			try { 
				while (($row = fgetcsv($this->handle, 1000, ",")) !== FALSE) { 
					if ( trim($row[0]) != 'JDE' && trim($row[0]) != '' ){
						$resp = $this->process_line($row);
						$this->processed++;
						if ( $resp )
							$this->saved++; 
					}
					$this->line++;
				}  
				$this->close_file();
			} catch ( Exception $e ){
				$this->set_error("An error occurred while processing the file (Line " . $line . " ). ", ERR_VAL_INVALID);
			}
		}
		else return FALSE;
	}
	
	private function process_line( $line ){ 
		if ( is_array( $line ) && count( $line ) > 5 ){ 
			// main
			$jde 		= trim( $line[0] );
			$name 		= trim( $line[1] );
			$lastname 	= trim( $line[2] );
			$lastname2 	= trim( $line[3] );
			
			$route	 	= trim( $line[16] );
			$division 	= trim( $line[17] );
			$channel 	= trim( $line[18] );
			
			// address
			$street		= trim( $line[4] );
			$ext_num 	= trim( $line[5] );
			$int_num 	= trim( $line[6] );
			$colonia	= trim( $line[7] );
			$delegacion	= trim( $line[8] );
			$city		= trim( $line[9] );
			$city_code	= trim( $line[19] );
			$state	 	= trim( $line[10] );
			$zip	 	= trim( $line[11] );
			$country 	= trim( $line[12] ); 
			
			// contact
			$rfc	 	= trim( $line[13] );
			$curp	 	= trim( $line[14] );
			$tel	 	= trim( $line[15] ); 
			$email 		= trim( $line[19] ); 
			$invoice	= trim( $line[20] );
			
			$id_pdv = $this->find_pdv( $jde );

			if ( is_numeric( $division ) ){
				$id_division = $division;
			} else {
				$id_division  = $this->get_division_id( $division );
				if ( !$id_division ){
					$this->set_error("Invalid Division ( '$division' ) on line " . $this->line . ". ", ERR_VAL_INVALID );
					return FALSE;
				}
			}
			if ( is_numeric( $channel ) ){
				$id_channel = $channel;
			} else {
				$id_channel = $this->get_channel_id( $channel );
				if ( !$id_channel ){
					$this->set_error("Invalid Channel ( '$channel' ) on line " . $this->line . ". ", ERR_VAL_INVALID );
					return FALSE;
				}
			}
			
			if ( is_numeric( $state ) ){
				$id_state = $state;
			} else {
				$id_state = $this->get_state_id( $state );
				if ( !$id_state ){
					$this->set_error("Invalid State ( '$state' ) on line " . $this->line . ". ", ERR_VAL_INVALID );
					return FALSE;
				}
			}
			 
			
			$this->PDV->clean();
			
			$this->PDV->id_pdv  	= $id_pdv;
			$this->PDV->jde			= $jde;
			$this->PDV->name 		= $name;
			$this->PDV->lastname	= $lastname;
			$this->PDV->lastname2	= $lastname2;
			$this->PDV->route		= $route;
			$this->PDV->id_channel 	= $id_channel;
			$this->PDV->id_format 	= 1;
			$this->PDV->id_division	= $id_division; 
			$this->PDV->id_pdv_type	= 1;
			$this->PDV->invoice		= $invoice == 0 ? 0 : 1;
			
			$this->PDV->latitude	= 0; 
			$this->PDV->longitude	= 0; 
			
			$this->PDV->address->street		= $street;
			$this->PDV->address->ext_num	= $ext_num;
			$this->PDV->address->int_num	= $int_num;
			$this->PDV->address->locality	= $colonia;
			$this->PDV->address->district	= $delegacion;
			$this->PDV->address->city		= $city_code;
			$this->PDV->address->city_code	= $city_code;
			$this->PDV->address->id_state	= $id_state;
			$this->PDV->address->zipcode	= $zip;  
				
			$this->PDV->contact->business_name	= $name;
			$this->PDV->contact->rfc			= $rfc;
			$this->PDV->contact->phone_1		= $tel;
			$this->PDV->contact->curp			= $curp;
			$this->PDV->contact->email			= $email;
			
			$resp = $this->PDV->save();
			if ( $resp !== FALSE ){
				$this->set_msg( "LOAD", "PDV " . $this->PDV->id_pdv . " ($jde) created successfully. ");
				return TRUE;
			} else return FALSE;
			
		} else {
			$this->set_error("Invalid line data (Line " . $this->line . "). ", ERR_VAL_INVALID );
			return FALSE;
		} 
	}

	private function find_pdv( $jde ){
		if ( $jde != '' ){
			global $obj_bd;
			$query = "SELECT id_pdv FROM " . PFX_MAIN_DB . "pdv WHERE pdv_jde = :jde ";
			$result = $obj_bd->query($query, array( ':jde' => $jde ) );
			if ( $result !== FALSE ){ 
				if ( count( $result ) > 0 ){
					$id_pdv = $result[0]['id_pdv']; 
				} else $id_pdv = 0;
				return $id_pdv;
			} else {
				$this->set_error("Database error while querying for pdv jde:'" . $jde . "'. ", ERR_VAL_INVALID );
				return 0;
			}
		}
	}
	
	private function get_division_id( $division = '' ){ 
		global $Validate; 
		if ( $division != '' ){
			if ( array_key_exists( $division , $this->divisions ) ){
				return $this->divisions[ $division ];
			} else {
				global $obj_bd;
				$query = " SELECT id_division FROM " . PFX_MAIN_DB . "division "  
						. " WHERE dv_division = :division  ";
				$result = $obj_bd->query($query, array( ':division' => $division ) );
				if ( $result !== FALSE ){ 
					if ( count( $result ) > 0 ){
						$id_division = $result[0]['id_division'];
						if ( $Validate->is_integer( $id_division ) && $id_division > 0 ){
							$this->divisions[ $division ] = $id_division;
							return $id_division;
						} 
						else return FALSE;
					} 
				} else {
					$this->set_error("Database error while querying for division '" . $division . "'. ", ERR_VAL_INVALID );
					return FALSE;
				}
			} 
		} else {
			$this->set_error("Invalid User ( '$division' ) on line " . $this->line . ". ", ERR_VAL_INVALID );
			return FALSE;
		} 
	}
	
	private function get_channel_id( $channel = '' ){ 
		global $Validate; 
		if ( $channel != '' ){
			if ( array_key_exists( $channel , $this->channels ) ){
				return $this->channels[ $channel ];
			} else {
				global $obj_bd;
				$query = " SELECT id_channel FROM " . PFX_MAIN_DB . "channel "  
						. " WHERE ch_code = :channel  ";
				$result = $obj_bd->query($query, array( ':channel' => $channel ) );
				if ( $result !== FALSE ){ 
					if ( count( $result ) > 0 ){
						$id_channel = $result[0]['id_channel'];
						if ( $Validate->is_integer( $id_channel ) && $id_channel > 0 ){
							$this->channels[ $channel ] = $id_channel;
							return $id_channel;
						} 
						else return FALSE;
					} 
				} else {
					$this->set_error("Database error while querying for channel '" . $channel . "'. " , ERR_VAL_INVALID );
					return FALSE;
				}
			} 
		} else {
			$this->set_error("Invalid User ( '$channel' ) on line " . $this->line . ". ", ERR_VAL_INVALID );
			return FALSE;
		} 
	}
	 
	private function get_state_id( $state = '' ){ 
		global $Validate; 
		if ( $state != '' ){
			if ( array_key_exists( $state , $this->states ) ){
				return $this->states[ $state ];
			} else {
				global $obj_bd;
				$query = " SELECT id_state FROM " . PFX_MAIN_DB . "state "  
						. " WHERE st_code = :state  ";
				$result = $obj_bd->query($query, array( ':state' => $state ) );
				if ( $result !== FALSE ){ 
					if ( count( $result ) > 0 ){
						$id_state = $result[0]['id_state'];
						if ( $Validate->is_integer( $id_state ) && $id_state > 0 ){
							$this->states[ $state ] = $id_state;
							return $id_state;
						} 
						else return FALSE;
					} 
				} else {
					$this->set_error("Database error while querying for state '" . $state . "'. ", ERR_VAL_INVALID );
					return FALSE;
				}
			} 
		} else {
			$this->set_error("Invalid User ( '$state' ) on line " . $this->line . ". ", ERR_VAL_INVALID );
			return FALSE;
		} 
	}
	 
	private function get_timestamp( $date, $time ){
		// >> 15/01/2015   ,   10:20
		try{
			list( $d, $m, $Y ) 	= explode("/", $date );
			list( $H, $i ) 		= explode(":", $time );
			return mktime( $H, $i, 0, $m, $d, $Y );
		} catch ( Exception $e ){
			$this->set_error("Invalid date parameters ( $date , $time )", ERR_VAL_INVALID);
			return FALSE;
		} 
		
	}

}
?>