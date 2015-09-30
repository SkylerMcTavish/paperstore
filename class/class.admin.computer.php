<?php
if (!class_exists('Computer')){
	require_once 'class.computer.php';
}

class AdminComputer extends Computer{


	function __construct($id_compuer = 0)
	{
		parent::__construct( $id_compuer );
		$this->class = 'AdminComputer';
	}
	
	private function validate()
	{
		global $Validate; 
		if ( !$this->id_type > 0 || !$Validate->exists( 'computer_type', 'id_computer_type', $this->id_type )){
			$this->set_error( 'Invalid Computer Type. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		if ( !$this->computer  != ''){
			$this->set_error( 'Invalid Computer Name. ', ERR_VAL_INVALID );
			return FALSE;
		}   
		if ( !$this->brand  != ''){
			$this->set_error( 'Invalid Computer Brand. ', ERR_VAL_INVALID );
			return FALSE;
		}
		if ( !$this->serial  != ''){
			$this->set_error( 'Invalid Serial Number. ', ERR_VAL_INVALID );
			return FALSE;
		} 
		
		return TRUE;
	}
	
	public function save()
	{
		if($this->validate())
		{
			global $obj_bd;
			
			$values = array(
				":computer"		=> $this->computer,
				":id_type"		=> $this->id_type,
				":brand"		=> $this->brand,
				":model"		=> $this->model,
				":serial"		=> $this->serial,
				":so"			=> $this->so,
				":timestamp"	=> time()
			);
			$action = 'SAVE';
			
			if($this->id_computer > 0)
			{
				$values[':id_computer'] = $this->id_computer;
				$action = 'UPDATE';
				$query =	" UPDATE ".PFX_MAIN_DB."computer SET ".
							" cm_computer 				= :computer, ".
							" cm_ct_id_computer_type	= :id_type, ".
							" cm_brand					= :brand, ".
							" cm_model					= :model, ".
							" cm_serial					= :serial, ".
							" cm_so						= :so, ".
							" cm_timestamp				= :timestamp ".
							" WHERE id_computer = :id_computer ";
			}
			else
			{
				$action = 'INSERT';
				$query = 	" INSERT INTO ".PFX_MAIN_DB."computer ".
							" (cm_computer, cm_ct_id_computer_type,cm_brand, cm_model, cm_serial, cm_so, cm_status, cm_timestamp ) ".
							" VALUES ".
							" (:computer, :id_type, :brand, :model, :serial, :so, 1, :timestamp) ";
			}
			
			$resp = $obj_bd->execute($query, $values);
			if ( $result !== FALSE )
			{ 
				if ( $this->id_computer == 0)
				{
					$this->id_computer = $obj_bd->get_last_id(); 
				}  
				$this->set_msg( $action , " Computer " . $this->id_computer. " saved. ");				
				return TRUE;
			}
			else
			{ 
				$this->set_error( "An error ocurred while trying to save the record. " , ERR_DB_EXEC, 3 );
				return FALSE;
			} 
			
		}
		else
		{
			return FALSE;
		}
	}
	
	private function valid_lease()
	{
		global $obj_bd;
		$query = 	" SELECT count(id_leasing) AS used ".
					" FROM ".PFX_MAIN_DB."leasing ".
					" WHERE ls_end = 0 AND ls_cm_id_computer =  :id_computer ";
		$resp = $obj_bd->query($query, array(":id_computer" => $this->id_computer));
		if($resp !== NULL)
		{
			$info = $resp[0];
			if($info['used'] > 0)
			{
				$this->set_error("Computadora no disponible. ".$query.print_r($values, TRUE) , ERR_DB_EXEC, 3 );
				return FALSE;
			}
			else
			{
				$this->set_msg("Computadora [".$this->id_computer."] disponible para rentar. ");
				return TRUE;
			}
		}
		else
		{
			$this->set_error("Ocurrio un error al tratar de verificar la disponibilidad de la computadora. ".$query.print_r($values, TRUE) , ERR_DB_EXEC, 3 );
			return FALSE;
		}
	}
	
	public function lease()
	{
		global $obj_bd;
		global $Settings;
		global $Session;
		
		if($this->valid_lease())
		{
			$id_tax = $Settings->get_settings_option('default_tax');
			$start = time();
			
			$values = array(
				":id_computer"	=> $this->id_computer,
				":start"		=> $start,
				":id_user"		=> $Session->get_id(),
				":id_tax"		=> $id_tax,
				":time"			=> time()
			);
			
			$query = 	" INSERT INTO ".PFX_MAIN_DB."leasing ( ls_cm_id_computer, ls_start, ls_end, ls_us_id_user, ls_tx_id_tax, ls_status, ls_timestamp ) VALUES ".
						" (:id_computer, :start, 0, :id_user, :id_tax, 1, :time) ";
						
			$resp = $obj_bd->execute($query, $values);
			
			if($resp !== FALSE)
			{
				$this->set_msg("Computer [".$this->id_computer."] on leasing since [".date('Y-m-d H:i:s', $start)."].");
				return $start;
			}
			else
			{
				$this->set_error("Ocurrio un error al tratar de rentar la computadora. ".$query.print_r($values, TRUE) , ERR_DB_EXEC, 3 );
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	private function calculate_lease_amount($end)
	{
		global $obj_bd;
		
		$query = 	" SELECT tx_tax, tx_hour_amount, tx_type, tx_amount_fraction, tx_amount_first_half, tx_amount_second_half, ls_start ".
					" FROM ".PFX_MAIN_DB."leasing ".
					" INNER JOIN ".PFX_MAIN_DB."tax ON id_tax = ls_tx_id_tax ".
					" WHERE ls_cm_id_computer = :id_computer AND ls_end = 0 ";
					
		$resp = $obj_bd->query($query, array(":id_computer" => $this->id_computer) );
		if($resp !== FALSE)
		{
			if( count($resp) > 0 )
			{
				$info = $resp[0];
				
				$tax 			= $info['tx_tax'];
				$type 			= $info['tx_type'];
				$amount			= $info['tx_hour_amount'];
				$fraction 		= $info['tx_amount_fraction'];
				$f_half 		= $info['tx_amount_first_half'];
				$s_half 		= $info['tx_amount_second_half'];
				$start 			= $info['ls_start'];
				
				$total = 0;
				$diff = $end - $start;
				
				switch($type)
				{
					case 1:
						$total_hours = ceil( $diff / 3600 );
						$total = $total_hours * $amount;
						
						$this->set_msg( "Horas: ".($total_hours). " costo: ".$total );
					break;
					
					case 2:
						$total_hours = $diff / 3600;
						$half = ceil( ( ( ($total_hours - floor($total_hours)) * 60) / 10) );
						$total = (floor($total_hours) * $amount)  + ($half * $fraction);
						
						$this->set_msg( "Horas: ".floor($total_hours). " costo: ".(floor($total_hours) * $amount) );
						$this->set_msg( "Fraccion: ".$half. " costo: ". ($half * $fraction ) );
					break;
					
					case 3:
						$total_hours = $diff / 3600;
						$half = $total_hours - floor($total_hours);
						$subtotal = floor($total_hours) * $amount;
						$total = $subtotal + ( $half > 0.5 ? $s_half : $f_half );
						
						$this->set_msg( "Horas: ".floor($total_hours). " costo: ".$subtotal );
						$this->set_msg( "Fraccion: ".$half. " costo: ". ($total - $subtotal ) );
					break;
				}
				
				$this->set_msg( "Costo Total: ".$total );
				return $total;
			}
			else
			{
				$this->set_error("Ocurrio un error al obtener la informacion de renta de la computadora. ", ERR_DB_EXEC, 3 );
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Ocurrio un error al tratar de liberar la computadora. ", ERR_DB_EXEC, 3 );
			return FALSE;
		}
		
	}
	
	public function release()
	{
		global $obj_bd;
		$end = time();
		
		$total = $this->calculate_lease_amount($end);
		
		if($total !== FALSE)
		{
			$values = array(
				":id_computer"	=> $this->id_computer,
				":end"			=> $end,
				":total"		=> $total
			);
			
			$query = 	" UPDATE ".PFX_MAIN_DB."leasing SET ".
						" ls_end		= :end, ".
						" ls_total		= :total, ".
						" ls_status 	= 0 ".
						" WHERE ls_cm_id_computer = :id_computer AND ls_end = 0";
						
			$resp = $obj_bd->execute($query, $values);
			
			if($resp !== FALSE)
			{
				$this->set_msg("Computer [".$this->id_computer."] on released at [".date('Y-m-d H:i:s', $end)."].");
				return $total;
			}
			else
			{
				$this->set_error("Ocurrio un error al tratar de rentar la computadora. ".$query.print_r($values, TRUE) , ERR_DB_EXEC, 3 );
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Ocurrio un error al calcular la renta de la computadora. ", ERR_DB_EXEC, 3 );
			return FALSE;
		}
	}
}

?>