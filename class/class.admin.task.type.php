<?php

if (!class_exists('TaskType')){
	require_once 'class.task.type.php';
}

/**
* AdminActivity Type CLass
* 
* @package		Ragasa
* @since        4/2/2015
* @author		ignacio.cerda
* 
*/  
class AdminTaskType extends TaskType {
	 
	
	function __construct( $id_task_type )
	{
		global $Session;  
		$this->class = 'AdminTaskType';  
		if ( !$Session->is_admin() )
		{
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1); 
		}
		parent::__construct( $id_task_type );
		$this->class = 'AdminTaskType';  
	}
	
	private function validate()
	{
		global $Validate;
		if ( !$this->task_type != '' )
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
					':task_type'	=> $this->task_type,
					':description'	=> $this->description,
					':timestamp'	=> time()
				);
				
				if($this->id_task_type > 0)
				{
					$values[':id_task_type'] = $this->id_task_type;
					$action = 'UPDATE';
					
					$query = 	" UPDATE ". PFX_MAIN_DB . "task_type SET ".
								" tt_task_type 		= :task_type , ".
								" tt_description	= :description, ".
								" tt_timestamp		= :timestamp".
								" WHERE id_task_type = :id_task_type ";
				}
				else
				{
					$action = 'INSERT';
				
					$query =	" INSERT INTO ". PFX_MAIN_DB . "task_type ".
								" (tt_task_type, tt_description, tt_status, tt_timestamp ) VALUES ".
								" ( :task_type, :description , 1 ,:timestamp ) ";
				}
				
				$result = $obj_bd->execute( $query, $values );
				
				if ( $result !== FALSE )
				{ 
					if ( $this->id_task_type == 0)
					{
						$this->id_task_type = $obj_bd->get_last_id();
					}
					$this->set_msg($action, " Task Type " . $this->id_task_type. " saved. ");
					
					
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
	
	public function set_activity($id_activity = 0, $status = 0)
	{
		if($id_activity > 0)
		{
			global $obj_bd;
			
			$action = "SET";
			if($status > 0)
			{
				$action = "INSERT";
				$query = 	" INSERT INTO ". PFX_MAIN_DB . "task_type_activities (tta_tt_id_task_type, tta_ac_id_activity) VALUES ".
							" (:id_ttype, :id_activity) ";
			}
			else
			{
				$action = "DELETE";
				$query =	" DELETE FROM ". PFX_MAIN_DB . "task_type_activities ".
							" WHERE tta_tt_id_task_type = :id_ttype AND tta_ac_id_activity = :id_activity ";
			}
			$params = array(':id_ttype' => $this->id_task_type, ':id_activity' => $id_activity);
			
			$result = $obj_bd->execute( $query, $params );
				
			if ( $result !== FALSE )
			{ 
				$this->set_msg($action, " Task Type Activity" . $this->id_task_type. ",". $id_activity. " seted. ");
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
			$this->set_error( 'Invalid Activity. ', ERR_VAL_EMPTY );
			return FALSE;
		}
	}
	
	private function validate_delete()
	{
		
		global $obj_bd;
		$query = 	" SELECT COUNT(tta_tt_id_task_type) as used ".
					" FROM ". PFX_MAIN_DB ."task_type_activities ".
					" WHERE tta_tt_id_task_type = :id_ttype  ";
		$result = $obj_bd->query( $query, array(':id_ttype' => $this->id_task_type) );
				
		if ( $result !== FALSE )
		{ 
			$info = $result[0];
			$count = $info['used'];
			
			if($count > 0)
			{
				$this->set_error( "Task Type in use. "  , ERR_DB_EXEC, 3 );
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
	
	public function delete()
	{
		if($this->validate_delete() )
		{
			global $obj_bd;
			$query = 	" UPDATE ". PFX_MAIN_DB ."task_type SET tt_status = 0, tt_timestamp = :time ".
						" WHERE id_task_type = :id_ttype ";
			$params = array(':time' => time() , ':id_ttype' => $this->id_task_type );
						
			$result = $obj_bd->execute( $query, $params );
				
			if ( $result !== FALSE )
			{ 
				$this->set_msg('DELETE', " Task Type" . $this->id_task_type.  " deleted. ");
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