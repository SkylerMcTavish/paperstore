<?php

if (!class_exists('ActivityType')){
	require_once 'class.activity.type.php';
}

/**
* AdminActivity Type CLass
* 
* @package		Ragasa
* @since        4/2/2015
* @author		ignacio.cerda
* 
*/  
class AdminActivityType extends ActivityType {
	 
	
	function __construct( $id_activity_type )
	{
		global $Session;  
		$this->class = 'AdminActivityType';  
		if ( !$Session->is_admin() )
		{
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1); 
		}
		parent::__construct( $id_activity_type );
		$this->class = 'AdminActivityType';  
	}
	
	private function validate()
	{
		global $Validate;
		if ( !$this->activity_type != '' )
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
					':activity_type'	=> $this->activity_type,
					':table_aux'		=> $this->table_aux
				);
				
				if($this->id_activity_type > 0)
				{
					$values[':id_activity_type'] = $this->id_activity_type;
					$action = 'UPDATE';
					
					$query = 	" UPDATE ". PFX_MAIN_DB . "activity_type SET ".
								" at_activity_type 	= :activity_type , ".
								" at_table_aux	 	= :table_aux ".
								" WHERE id_activity_type = :id_activity_type ";
				}
				else
				{
					$action = 'INSERT';
				
					$query =	" INSERT INTO ". PFX_MAIN_DB . "activity_type ".
								" (at_activity_type, at_table_aux ) VALUES ".
								" (:activity_type, :table_aux) ";
				}
				
				$result = $obj_bd->execute( $query, $values );
				
				if ( $result !== FALSE )
				{ 
					if ( $this->id_activity_type == 0)
					{
						$this->id_activity_type = $obj_bd->get_last_id();
					}
					$this->set_msg($action, " Activity Type " . $this->id_activity_type. " saved. ");
					
					
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
	
	private function validate_delete()
	{
		global $obj_bd;
		$query = 	" SELECT COUNT(id_activity) as used ".
					" FROM ". PFX_MAIN_DB ."activity ".
					" WHERE ac_at_id_Activity_type = :id_actype ";
					
		$info = $obj_bd->query( $query, array( ':id_actype' => $this->id_activity_type ) );
			
		if ( $info !== FALSE )
		{
			$used = $info[0];
			return ( $used['used'] > 0 ) ? FALSE : TRUE ;
		}
		else
		{ 
			$this->set_error( "An error ocurred while trying to save the record. "  , ERR_DB_EXEC, 3 );
			return FALSE;
		} 
	}
	
	public function delete()
	{
		if($this->id_activity_type > 0)
		{
			if($this->validate_delete())
			{
				global $obj_bd;
				$query = " DELETE FROM ". PFX_MAIN_DB. "activity_type WHERE id_activity_type = :id_actype ";
				$result = $obj_bd->execute( $query, array(':id_actype' => $this->id_activity_type) );
				
				if ( $result !== FALSE )
				{ 
					$this->set_msg('DELETE', " Activity Type " . $this->id_activity_type. " deleted. ");
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
				$this->set_error( "Activity type in use. "  , ERR_DB_EXEC, 3 );
				return FALSE;
			}
		}
	}
}

?>