<?php

class Tax extends Object{

	public $id_tax;
	public $tax;
	public $hour;
	public $fraction;
	public $f_half;
	public $s_half;
	public $timestamp;
	public $id_type;
	public $type;

	function __construct($id_tax = 0)
	{
		$this->class = "Tax";
		$this->clean();
		
		if($id_tax > 0)
		{
			global $obj_bd;
			$query = 	" SELECT id_tax, tx_tax, tx_hour_amount, tx_amount_fraction, tx_amount_first_half, tx_amount_second_half, tx_timestamp, tx_type, ".
						" CASE tx_type ".
						" 	WHEN 1 THEN 'Hora Completa' ".
						" 	WHEN 2 THEN 'Fraccion de 10 minutos' ".
						"	WHEN 3 THEN 'Mitad de Hora' ".
						" END AS tx_tipo ".
						" FROM ".PFX_MAIN_DB."tax ".
						" WHERE id_tax = :id_tax ";
			$resp = $obj_bd->query($query, array(":id_tax" => $id_tax) );
			
			if($resp !== FALSE)
			{
				if(count($resp) > 0)
				{
					$info = $resp[0];
					
					$this->id_tax		= $info['id_tax'];
					$this->tax			= $info['tx_tax'];
					$this->hour			= $info['tx_hour_amount'];
					$this->fraction		= $info['tx_amount_fraction'];
					$this->f_half		= $info['tx_amount_first_half'];
					$this->s_half		= $info['tx_amount_second_half'];
					$this->id_type		= $info['tx_type'];
					$this->type			= $info['tx_tipo'];
					
					$this->timestamp	= $info['tx_timestamp'];
				}
				else
				{
					$this->set_error('No se encontro la tarifa ['.$id_tax.'].', ERR_DB_QRY);
					return FALSE;
				}
			}
			else
			{
				$this->set_error('Error al acceder a la base de datos.', ERR_DB_QRY);
				return FALSE;
			}
			
		}
		
	}
	
	public function clean()
	{
		$this->id_tax		= 0;
		$this->tax			= '';
		$this->hour			= 0;
		$this->fraction		= 0;
		$this->f_half		= 0;
		$this->s_half		= 0;
		$this->id_type		= 0;
		$this->type			= '';
		$this->timestamp	= 0;
		
		$this->error = array();
	}
	
	public function get_array()
	{
		$array = array(
			"id_tax"		=> $this->id_tax,
			"tax"			=> $this->tax,
			"hour"			=> $this->hour,
			"fraction"		=> $this->fraction,
			"fhalf"			=> $this->f_half,
			"shalf"			=> $this->s_half,
			"id_type"		=> $this->id_type,
			"type"			=> $this->type,
			"timestamp"		=> $this->timestamp
		);
		
		return $array;
	}
	
	private function validate()
	{
		if( !$this->tax != '' ){
			$this->set_error('Nombre Invalido para la tarifa.', ERR_VAL_EMPTY);
			return FALSE;
		}
		
		if( !is_numeric($this->hour) || !$this->hour > 0 ){
			$this->set_error('Costo por hora invalido.', ERR_VAL_INVALID);
			return FALSE;
		}
		
		if( !is_numeric($this->id_type) || !$this->id_type > 0 ){
			$this->set_error('Tipo de tarifa invalido.', ERR_VAL_INVALID);
			return FALSE;
		}
		
		switch($this->id_type)
		{
			case 2:
				if( !is_numeric($this->fraction) || !$this->fraction > 0 ){
					$this->set_error('Costo de fraccion invalido.', ERR_VAL_INVALID);
					return FALSE;
				}
			break;
			
			case 3:
				if( !is_numeric($this->f_half) || !$this->f_half > 0 ){
					$this->set_error('Costo de primer media hora invalido.', ERR_VAL_INVALID);
					return FALSE;
				}
				
				if( !is_numeric($this->s_half) || !$this->s_half > 0 ){
					$this->set_error('Costo de segunda media hora invalido.', ERR_VAL_INVALID);
					return FALSE;
				}
			break;
			
		}
		
		return TRUE;
	}
	
	public function save()
	{
		if($this->validate())
		{
			global $obj_bd;
			$values = array(
				":tax"			=> $this->tax,
				":hour"			=> $this->hour,
				":fraction"		=> $this->fraction,
				":fhalf"		=> $this->f_half,
				":shalf"		=> $this->s_half,
				":type"			=> $this->id_type,
				":time"			=> time()
			);
			
			$action = 'SAVE';
			if($this->id_tax > 0)
			{
				$values['id_tax'] = $this->id_tax;
				$action = 'UPDATE';
				$query = 	" UPDATE ".PFX_MAIN_DB."tax SET ".
							" tx_tax 					= :tax, ".
							" tx_hour_amount 			= :hour, ".
							" tx_amount_fraction 		= :fraction, ".
							" tx_amount_first_half 		= :fhalf, ".
							" tx_amount_second_half 	= :shalf, ".
							" tx_type 					= :type, ".
							" tx_timestamp	 			= :time ".
							" WHERE id_tax = :id_tax ";
			}
			else
			{
				$action = 'INSERT';
				$query = 	" INSERT INTO ".PFX_MAIN_DB."tax ".
							" (tx_tax, tx_hour_amount, tx_amount_fraction, tx_amount_first_half, tx_amount_second_half, tx_type, tx_status, tx_timestamp ) ".
							" VALUES ".
							" (:tax, :hour, :fraction, :fhalf, :shalf, :type, 1, :time ) ";
			}
			
			$resp = $obj_bd->execute($query, $values);
			
			if($resp !== FALSE )
			{
				if($this->id_tax == 0)
				{
					$this->id_tax = $obj_bd->get_last_id();
				}
				
				$this->set_msg('Tax ['.$this->id_tax.'] saved.');
				return TRUE;
				
			}
			else
			{
				$this->set_error('Error al intentar guardar la tarifa.',ERR_DB_EXEC);
				return FALSE;
			}
		}
		else
		{
				return FALSE;
		}
	}
	
	private function validate_delete()
	{
		global $Settings;
		
		$id_default = (int)$Settings->get_settings_option('default_tax');
		
		if($id_default == $this->id_tax )
		{
			$this->set_error("No se puede eliminar la tarifa que esta siendo utilizada actualmente. ", ERR_VAL_INVALID);
			return FALSE;
		}
		
		return TRUE;
	}
	
	public function set_default()
	{
		if($this->id_tax > 0)
		{
			global $Settings;
			$Settings->save_settings_option('default_tax', $this->id_tax);
			return TRUE;
		}
		else
		{
			$this->set_error("Tarifa invalida.", ERR_VAL_INVALID);
			return FALSE;
		}
	}
	
	public function delete()
	{
		if($this->id_tax > 0)
		{
			if($this->validate_delete())
			{
				global $obj_bd;
				$query = 	" UPDATE ".PFX_MAIN_DB."tax SET ".
							" tx_status 	= 0, ".
							" tx_timestamp 	= :time ".
							" WHERE id_tax = :id_tax ";
				$resp = $obj_bd->execute($query, array( ":time" => time(), ":id_tax" => $this->id_tax ) );
				
				if($resp !== FALSE)
				{
					$this->set_msg("La tarifa [".$this->id_tax."] se elimino correctamente.");
					return TRUE;
				}
				else
				{
					$this->set_error("Ocurrio un error al tratar de borrar la tarifa. ", ERR_DB_EXEC);
					return FALSE;
				}
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
}

?>