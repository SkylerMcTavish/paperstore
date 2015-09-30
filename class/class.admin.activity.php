<?php

if (!class_exists('Activity'))
{
	require_once 'class.activity.php';
}

/**
* AdminActivity CLass
* 
* @package		Ragasa
* @since        4/2/2015
* @author		ignacio.cerda
* 
*/  
class AdminActivity extends Activity {
	 
	
	function __construct( $id_activity )
	{
		global $Session;  
		$this->class = 'AdminActivity';  
		if ( !$Session->is_admin() )
		{
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1); 
		}
		parent::__construct( $id_activity );
		$this->class = 'AdminActivity';  
	}
	
	private function validate()
	{
		global $Validate;
		if ( !$this->activity != '' )
		{
			$this->set_error( 'Name value empty. ', ERR_VAL_EMPTY );
			return FALSE;
		}
		if ( !is_numeric($this->id_activity_type) || !( $this->id_activity_type > 0 ) )
		{ 
			$this->set_error( 'Invalid Activity Type value. ', ERR_VAL_INVALID );
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
					':activity'			=> $this->activity,
					':description'		=> $this->description,
					':id_aux'			=> $this->id_aux,
					':default'			=> $this->default_activity,
					':id_activity_type'	=> $this->id_activity_type,
					':timestamp'		=> time()
				);
				
				if($this->id_activity > 0)
				{
					$values[':id_activity'] = $this->id_activity;
					
					$action = 'UPDATE';
					
					$query = 	" UPDATE ". PFX_MAIN_DB . "activity SET ".
								" ac_activity 				= :activity , ".
								" ac_description 			= :description , ".
								" ac_aux_id_auxiliar 		= :id_aux , ".
								" ac_at_id_activity_type	= :id_activity_type , ".
								" ac_default 				= :default, ".
								" ac_status 				= 1, ".
								" ac_timestamp 				= :timestamp ".
								" WHERE id_activity	= :id_activity ";
				}
				else
				{
					$action = 'INSERT';
				
					$query =	" INSERT INTO ". PFX_MAIN_DB . "activity ".
								" (ac_activity, ac_description, ac_at_id_activity_type , ac_aux_id_auxiliar, ac_default, ac_status, ac_timestamp ) VALUES ".
								" (:activity , :description , :id_activity_type , :id_aux , :default, 1, :timestamp ) ";
				}
				
				$result = $obj_bd->execute( $query, $values );
				
				if ( $result !== FALSE )
				{ 
					if ( $this->id_activity == 0)
					{
						$this->id_activity = $obj_bd->get_last_id();
					}
					$this->set_msg($action, " Activity " . $this->id_activity. " saved. ");
					
					
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
	
	public function validate_delete()
	{
		if($this->default_activity > 0)
		{
			return FALSE;
		}
		else
		{
			$this->set_error( "Default Activity."  , ERR_DB_EXEC, 3 );
			return FALSE;
		}
	}
}

?>