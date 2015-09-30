<?php

class Computer extends Object{

	public $id_computer;
	public $computer;
	public $id_type;
	public $type;
	public $brand;
	public $model;
	public $serial;
	public $so;
	
	public $timestamp;

	function __construct($id_computer = 0)
	{
		$this->class = 'Computer';
		$this->clean();
		
		if($id_computer > 0)
		{
			global $obj_bd;
			$query = 	" SELECT id_computer, cm_computer, id_computer_type, ct_computer_type, cm_brand, cm_model, cm_serial, cm_so, cm_timestamp ".
						" FROM ".PFX_MAIN_DB."computer ".
						" INNER JOIN ".PFX_MAIN_DB."computer_type ON id_computer_type = cm_ct_id_computer_type ".
						" WHERE id_computer = :id_computer ";
			$resp = $obj_bd->query($query, array(":id_computer" => $id_computer));
			
			if($resp !== FALSE)
			{
				if( count($resp) > 0 )
				{
					$info = $resp[0];
					$this->id_computer 		= $info['id_computer'];
					$this->computer			= $info['cm_computer'];
					$this->id_type			= $info['id_computer_type'];
					$this->type				= $info['ct_computer_type'];
					$this->brand			= $info['cm_brand'];
					$this->model			= $info['cm_model'];
					$this->serial			= $info['cm_serial'];
					$this->so				= $info['cm_so'];
					
					$this->timestamp 		= $info['cm_timestamp'];
					
				}
				else
				{
					$this->set_error("Error, no existe la computadora [$id_computer]", ERR_DB_QRY);
				}
			}
			else
			{
				$this->set_error("Error al acceder a la base de datos.", ERR_DB_QRY);
			}
		}
	}
	
	public function clean()
	{
		$this->id_computer 		= 0;
		$this->computer			= '';
		$this->id_type			= 0;
		$this->type				= '';
		$this->brand			= '';
		$this->model			= '';
		$this->serial			= '';
		$this->so				= '';
		
		$this->timestamp 		= 0;
		$this->error 			= array();
	}
}

?>