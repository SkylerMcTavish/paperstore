<?php
if (!class_exists('Proyect'))
{
	require_once 'class.proyect.php';
}

class ProyectSupervisor extends Proyect{
	
	function ProyectSupervisor( $id_proyect = 0 )
	{
		global $Session;  
		$this->class = 'ProyectSupervisor';  
		if ( !$Session->is_admin() )
		{
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1); 
		}
		parent::__construct( $id_proyect );
		$this->class = 'ProyectSupervisor';  
	}
	

	public function get_supervisor_option_HTML()
	{
		global $obj_bd;
		$query = 	" SELECT id_user, us_user, pf_profile, pu_pr_id_proyect FROM ".PFX_MAIN_DB."proyect_user ".
					" INNER JOIN ".PFX_MAIN_DB."user ON id_user = pu_us_id_user AND pu_pr_id_proyect = :id_proyect ".
					" INNER JOIN ".PFX_MAIN_DB."profile ON id_profile = us_pf_id_profile ".
					" WHERE us_status > 0 AND id_profile = :id_profile ";
		
		$values = array( ':id_proyect' => $this->id_proyect, ':id_profile' => 4 );
		$resp = $obj_bd->query($query, $values);
		$html = '';
		if($resp !== FALSE)
		{
			foreach($resp as $k => $info)
				{
					$html .= '<option value="'.$info['id_user'].'" >'.$info['us_user'].'</option>';
				}
		}
		else
		{
			$this->set_error("Database error while querying the DB. " , ERR_DB_EXEC );
		}
		
		return $html;
		
	}

	public function asign_user_supervisor($id_parent, $id_user, $state)
	{
		global $Session;
		if ( $Session->is_admin() )
		{
			global $obj_bd;
			require_once DIRECTORY_CLASS.'class.user.php';
			$parent = new User($id_parent);
			$user = new User($id_user);
			
			if( count($parent->error) > 0 || count($user->error) > 0 )
			{
				$this->set_error("Parent and/or User are invalid. ", ERR_DB_NOT_FOUND);
				return FALSE;
			}
			else
			{
				if($state > 0)
				{
					$query = 	" INSERT INTO ".PFX_PRY_DB. "user_supervisor (usu_us_id_user, usu_us_id_parent) ".
								" VALUES (:id_user , :id_parent) ";
				}
				else
				{
					$query = 	" DELETE FROM " . PFX_PRY_DB. "user_supervisor ".
								" WHERE usu_us_id_user = :id_user AND usu_us_id_parent = :id_parent ";
				}
				
				$values = array(':id_parent' => $parent->id_user , ':id_user' => $user->id_user);
				
				$resp = $obj_bd->execute($query, $values);
				
				if ( $resp !== FALSE )
				{
					return TRUE;
				}
				else
				{
					$this->set_error("Database error while (un)asigning user [".$id_user."] to supervisor [".$id_parent."]. " , ERR_DB_EXEC );
					return FALSE;
				}
			}
			
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
}
	
?>