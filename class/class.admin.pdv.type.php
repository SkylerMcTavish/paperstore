<?php

if (!class_exists('PDVType')){
	require_once 'class.pdv.type.php';
}

/**
* Admin PDV Type CLass
* 
* @package		Ragasa
* @since        4/2/2015
* @author		ignacio.cerda
* 
*/  
class AdminPDVType extends PDVType {
	 
	
	function __construct( $id_pdv_type )
	{
		global $Session;  
		$this->class = 'AdminPDVType';  
		if ( !$Session->is_admin() )
		{
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1); 
		}
		parent::__construct( $id_pdv_type );
		$this->class = 'AdminPDVType';  
	}
	
	private function validate()
	{
		global $Validate;
		if ( !$this->pdv_type != '' )
		{
			$this->set_error( 'Name value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		} 
		return TRUE;
	}
	
	public function save()
	{
		global $Session;
		if ( $Session->is_admin() )
		{ 
			if ( $this->validate() )
			{ 
				global $obj_bd;
				$action = 'SAVE';
				
				$values = array
				(
					':pdv_type'	=> $this->pdv_type,
					':timestamp'	=> time()
				);
				
				if($this->pdv_type > 0)
				{
					$values[':id_pvt'] = $this->id_pdv_type;
					$action = 'UPDATE';
					
					$query = 	" UPDATE ". PFX_MAIN_DB . "pdv_type SET ".
								" pvt_pdv_type 		= :pdv_type , ".
								" pvt_timestamp		= :timestamp".
								" WHERE id_pdv_type = :id_pvt ";
				}
				else
				{
					$action = 'INSERT';
				
					$query =	" INSERT INTO ". PFX_MAIN_DB . "pdv_type ".
								" (pvt_pdv_type, pvt_status, pvt_timestamp ) VALUES ".
								" ( :pdv_type, 1 , :timestamp ) ";
				}
				
				$result = $obj_bd->execute( $query, $values );
				
				if ( $result !== FALSE )
				{ 
					if ( $this->id_pdv_type == 0)
					{
						$this->id_pdv_type = $obj_bd->get_last_id();
					}
					$this->set_msg($action, " PDV Type " . $this->id_pdv_type. " saved. ");
					
					
					return TRUE;
				}
				else
				{ 
					$this->set_error( "An error ocurred while trying to save the record. "  , ERR_DB_EXEC, 3 );
					return FALSE;
				} 
			}
		}
	}
	
	public function set_task_type($id_task_type = 0, $status = 0)
	{
		if($id_task_type > 0)
		{
			global $obj_bd;
			
			$action = "SET";
			if($status > 0)
			{
				$action = "INSERT";
				$query = 	" INSERT INTO ". PFX_MAIN_DB . "pdv_type_task_type (ptt_pvt_id_pdv_type, ptt_tt_id_task_type) VALUES ".
							" (:id_pvt, :id_ttype) ";
			}
			else
			{
				$action = "DELETE";
				$query =	" DELETE FROM ". PFX_MAIN_DB . "pdv_type_task_type ".
							" WHERE ptt_pvt_id_pdv_type = :id_pvt AND ptt_tt_id_task_type = :id_ttype ";
			}
			$params = array(':id_pvt' => $this->id_pdv_type, ':id_ttype' => $id_task_type);
			
			$result = $obj_bd->execute( $query, $params );
				
			if ( $result !== FALSE )
			{ 
				$this->set_msg($action, " PDV Type Task Type" . $this->id_pdv_type. ",". $id_task_type. " seted. ");
				return TRUE;
			}
			else
			{ 
				$this->set_error( "An error ocurred while trying to $action the record. "  , ERR_DB_EXEC, 3 );
				return FALSE;
			} 
		}
		else
		{
			$this->set_error( 'Invalid Task Type. ', ERR_VAL_EMPTY );
			return FALSE;
		}
	}
	
	private function validate_delete()
	{
		
		global $obj_bd;
		$query = 	" SELECT COUNT(pdv_pvt_id_pdv_type) AS used ".
					" FROM ". PFX_MAIN_DB . "pdv ".
					" WHERE pdv_pvt_id_pdv_type = :id_pvt ";
		$result = $obj_bd->query( $query, array(':id_pvt' => $this->id_pdv_type) );
				
		if ( $result !== FALSE )
		{ 
			$info = $result[0];
			$count = $info['used'];
			
			if($count > 0)
			{
				$this->set_error( "PDV Type in use. "  , ERR_DB_EXEC, 3 );
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
		else
		{ 
			$this->set_error( "An error ocurred while trying to delete the record. "  , ERR_DB_EXEC, 3 );
			return FALSE;
		} 
	}
	
	private function delete_tasks_type()
	{
		foreach($this->task_types as $task)
		{
			$this->set_task_type($task['id_task_type'], 0);
		}
	}
	
	public function delete()
	{
		if($this->validate_delete() )
		{
			global $obj_bd;
			$query = 	" UPDATE ". PFX_MAIN_DB ."pdv_type SET pvt_status = 0, pvt_timestamp = :time ".
						" WHERE id_pdv_type = :id_pvt ";
			$params = array(':time' => time() , ':id_pvt' => $this->id_pdv_type );
						
			$result = $obj_bd->execute( $query, $params );
				
			if ( $result !== FALSE )
			{ 
				$this->set_msg('DELETE', " PDV Type" . $this->id_pdv_type.  " deleted. ");
				$this->delete_tasks_type();
				return TRUE;
			}
			else
			{ 
				$this->set_error( "An error ocurred while trying to delete the record. "  , ERR_DB_EXEC, 3 );
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