<?php
if (!class_exists('Proyect')){
	require_once 'class.proyect.php';
}
/**
* AdminProyect CLass
* 
* @package		SF Tracker			
* @since        18/05/2014 
* 
*/ 
class ProyectAsignation extends Proyect{
	
	/**
	* AdminProyect()    
	* Creates a User object from the DB.
	*  
	* @param 		$id_proyect (optional) If set populates values from DB record. 
	*/  
	function ProyectAsignation( $id_proyect = 0 ){
		global $Session;  
		$this->class = 'ProyectAsignation';  
		if ( !$Session->is_admin() ){
			$this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
			throw new Exception("Restricted access.", 1); 
		}
		parent::__construct( $id_proyect );
		$this->class = 'AdminProyect';
	}
	
	/******** User ********/
	/**
	* asign_user()    
	* Inserts a cycle record for the proyect in the DB. 
	* 
	* @param	$id_user Integer
	* @param 	$asign Boolean TRUE: asign; FALSE: unassign
	* 
	* @return 	Boolean TRUE if successful, FALSE otherwise  
	*/  
	public function asign_user( $id_user, $asign = TRUE ){
		global $Session;
		if ( $Session->is_admin() ){
			if ( is_numeric( $id_user ) && $id_user > 1 ){
				global $obj_bd;
				$query = " DELETE FROM " . PFX_MAIN_DB . "proyect_user "
							. " WHERE pu_pr_id_proyect = :id_proyect AND pu_us_id_user = :id_user "; 
				$values = array(  ':id_proyect' => $this->id_proyect, ":id_user" => $id_user );
				$resp = $obj_bd->execute($query, $values);
				if ( $resp ){
					if ( $asign ) {
						$query = "INSERT INTO " . PFX_MAIN_DB . "proyect_user ( pu_pr_id_proyect, pu_us_id_user, pu_active, pu_timestamp ) " 
								. " VALUES ( :id_proyect, :id_user, :active, :timestamp ) "; 
						$values[':active'] = 1; 
						$values[':timestamp'] = time(); 
						
						$resp = $obj_bd->execute($query, $values);
						if ( $resp ){ 
							return TRUE;
						} else { 
							$this->set_error("Database error while asigning user ( " . $id_user . " )." , ERR_DB_EXEC );
							return FALSE;
						}
					} else {
						return TRUE;
					}
				}
				else {
					$this->set_error("Database error while (un)asigning user ( " . $id_user . " )." , ERR_DB_EXEC );
					return FALSE;
				}
			} else {
				$this->set_error("Invalid user.", ERR_VAL_INVALID);
				return FALSE;
			}
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	public function asign_user_all($state)
	{
		global $Session;
		
		if ( $Session->is_admin() )
		{
			global $obj_bd;
			
			if($state > 0)
			{
				$query = 	" INSERT INTO ". PFX_MAIN_DB ."proyect_user (pu_pr_id_proyect, pu_us_id_user, pu_active, pu_timestamp) ".
							" SELECT :id_proyect, id_user, 1, :time FROM ". PFX_MAIN_DB ."user ".
							" WHERE us_pf_id_profile > 1 AND us_status > 0 ".
							" AND id_user NOT IN (SELECT pu_us_id_user FROM ". PFX_MAIN_DB ."proyect_user WHERE pu_pr_id_proyect = :id_proyect ) ";
				$values = array(':id_proyect' => $this->id_proyect, ":time" => time() ); 
			}
			else
			{
				$query = 	" DELETE FROM " . PFX_MAIN_DB ."proyect_user WHERE pu_pr_id_proyect = :id_proyect ";
				$values = array(':id_proyect' => $this->id_proyect  ); 
			}
			
			
			$resp = $obj_bd->execute($query, $values);
			if ( $resp )
			{
				return TRUE;
			}
			else
			{
				$this->set_error("Database error while (un)asigning all users. " , ERR_DB_EXEC );
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	public function active_user( $id_user, $active = TRUE ){
		global $Session;
		
		if ( $Session->is_admin() )
		{
			if ( is_numeric( $id_user ) && $id_user > 1 )
			{
				global $obj_bd;
				$query = " UPDATE ". PFX_MAIN_DB ."proyect_user SET pu_active = :active "
							. " WHERE pu_pr_id_proyect = :id_proyect AND pu_us_id_user = :id_user ";
				
				$values = array(':active' => ( $active ? 1 : 0 ) ,  ':id_proyect' => $this->id_proyect, ":id_user" => $id_user ); 
				
				$resp = $obj_bd->execute($query, $values);
				if ( $resp )
				{
					return TRUE;
				}
				else {
					$this->set_error("Database error while (de)activating user ( " . $id_user . " )." , ERR_DB_EXEC );
					return FALSE;
				}
			}
			else {
				$this->set_error("Invalid user.", ERR_VAL_INVALID);
				return FALSE;
			}
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	public function activate_user_all($state)
	{
		global $Session;
		
		if ( $Session->is_admin() )
		{
			global $obj_bd;
			$query = 	" UPDATE ". PFX_MAIN_DB ."proyect_user SET pu_active = :active, pu_timestamp = :time WHERE pu_pr_id_proyect = :id_proyect ";
			
			$values = array(':id_proyect' => $this->id_proyect, ":time" => time(), ":active" => $state ); 
			
			$resp = $obj_bd->execute($query, $values);
			if ( $resp )
			{
				return TRUE;
			}
			else
			{
				$this->set_error("Database error while (de)activating all users. " , ERR_DB_EXEC );
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	/*asignaciones/activaciones de productos*/
	public function asign_product($id_product, $asign = TRUE)
	{
		global $Session;
		if ( $Session->is_admin() )
		{
			if ( is_numeric( $id_product ) )
			{
				global $obj_bd;
				
				if($asign)
				{
					$qry = 	" INSERT INTO ". PFX_MAIN_DB ."proyect_product ( ppo_pr_id_proyect, ppo_po_id_product, ppo_active, ppo_timestamp ) ".
							" VALUES ( :id_proyect, :id_product, 1, :time ) ";
					$values = array( ":id_proyect" => $this->id_proyect, ":id_product" => $id_product, ":time" => time() );
				}
				else
				{
					$qry =	"DELETE FROM ". PFX_MAIN_DB ."proyect_product WHERE ppo_pr_id_proyect = :id_proyect AND ppo_po_id_product = :id_product ";
					$values = array( ":id_proyect" => $this->id_proyect, ":id_product" => $id_product );
				}
				
				$resp = $obj_bd->execute($qry, $values);
				if ( $resp  )
				{
					return TRUE;
				}
				else
				{
					$this->set_error("Database error while asigning product ( " . $id_product . " ). ", ERR_DB_EXEC );
					return FALSE;
				}
			}
			else
			{
				$this->set_error("Invalid product.", ERR_VAL_INVALID);
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	public function active_product( $id_product, $active = TRUE )
	{
		global $Session;
		
		if ( $Session->is_admin() )
		{
			if ( is_numeric( $id_product ) )
			{
				global $obj_bd;
				$query = " UPDATE ". PFX_MAIN_DB ."proyect_product SET ppo_active = :active "
							. " WHERE ppo_pr_id_proyect = :id_proyect AND ppo_po_id_product = :id_product ";
				
				$values = array(':active' => ( $active ? 1 : 0 ) ,  ':id_proyect' => $this->id_proyect, ":id_product" => $id_product ); 
				
				$resp = $obj_bd->execute($query, $values);
				if ( $resp )
				{
					return TRUE;
				}
				else
				{
					$this->set_error("Database error while (de)activating product ( " . $id_product . " )." , ERR_DB_EXEC );
					return FALSE;
				}
			}
			else
			{
				$this->set_error("Invalid product.", ERR_VAL_INVALID);
				return FALSE;
			}
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	public function asign_product_all($state)
	{
		global $Session;
		if ( $Session->is_admin() )
		{
			global $obj_bd;
			
			if($state > 0)
			{
				$query = 	" INSERT INTO " . PFX_MAIN_DB ."proyect_product ( ppo_pr_id_proyect, ppo_po_id_product, ppo_active, ppo_timestamp ) ".
							" SELECT :id_proyect, id_product, 1, :time FROM " . PFX_MAIN_DB ."product ".
							" WHERE id_product NOT IN ( SELECT ppo_po_id_product FROM " . PFX_MAIN_DB ."proyect_product WHERE ppo_pr_id_proyect = :id_proyect ) ";
				$values = array(':id_proyect' => $this->id_proyect, ":time" => time() ); 
			}
			else
			{
				$query = 	" DELETE FROM " . PFX_MAIN_DB ."proyect_product WHERE ppo_pr_id_proyect = :id_proyect ";
				$values = array(':id_proyect' => $this->id_proyect  ); 
			}
			
			
			$resp = $obj_bd->execute($query, $values);
			if ( $resp )
			{
				return TRUE;
			}
			else
			{
				$this->set_error("Database error while (un)asigning all products. " , ERR_DB_EXEC );
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	public function activate_product_all($state)
	{
		global $Session;
		
		if ( $Session->is_admin() )
		{
			global $obj_bd;
			$query = 	" UPDATE ". PFX_MAIN_DB ."proyect_product SET ppo_active = :active, ppo_timestamp = :time WHERE ppo_pr_id_proyect = :id_proyect ";
			
			$values = array(':id_proyect' => $this->id_proyect, ":time" => time(), ":active" => $state ); 
			
			$resp = $obj_bd->execute($query, $values);
			if ( $resp )
			{
				return TRUE;
			}
			else
			{
				$this->set_error("Database error while (de)activating all users. " , ERR_DB_EXEC );
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	/*asignaciones, activaciones PDVs*/
	public function asign_pdv($id_pdv, $asign = TRUE)
	{
		global $Session;
		if ( $Session->is_admin() )
		{
			if ( is_numeric( $id_pdv ) )
			{
				global $obj_bd;
				
				if($asign)
				{
					$qry = 	" INSERT INTO ". PFX_MAIN_DB ."proyect_pdv ( ppv_pr_id_proyect, ppv_pdv_id_pdv, ppv_active, ppv_timestamp ) ".
							" VALUES ( :id_proyect, :id_pdv, 1, :time ) ";
					$values = array( ":id_proyect" => $this->id_proyect, ":id_pdv" => $id_pdv, ":time" => time() );
				}
				else
				{
					$qry =	"DELETE FROM ". PFX_MAIN_DB ."proyect_pdv WHERE ppv_pr_id_proyect = :id_proyect AND ppv_pdv_id_pdv = :id_pdv ";
					$values = array( ":id_proyect" => $this->id_proyect, ":id_pdv" => $id_pdv );
				}
				
				$resp = $obj_bd->execute($qry, $values);
				if ( $resp  )
				{
					return TRUE;
				}
				else
				{
					$this->set_error("Database error while asigning PDV ( " . $id_pdv . " ). ", ERR_DB_EXEC );
					return FALSE;
				}
			}
			else
			{
				$this->set_error("Invalid PDV.", ERR_VAL_INVALID);
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	public function asign_pdv_all($state)
	{
		global $Session;
		if ( $Session->is_admin() )
		{
			global $obj_bd;
			
			if($state > 0)
			{
				$query = 	" INSERT INTO ". PFX_MAIN_DB ."proyect_pdv (ppv_pr_id_proyect, ppv_pdv_id_pdv, ppv_active, ppv_timestamp) ".
							" SELECT :id_proyect, id_pdv, 1, :time FROM ". PFX_MAIN_DB ."pdv ".
							" WHERE id_pdv NOT IN ( SELECT ppv_pdv_id_pdv FROM ". PFX_MAIN_DB ."proyect_pdv WHERE ppv_pr_id_proyect = :id_proyect ) ";
				$values = array(':id_proyect' => $this->id_proyect, ":time" => time() ); 
			}
			else
			{
				$query = 	" DELETE FROM " . PFX_MAIN_DB ."proyect_pdv WHERE ppv_pr_id_proyect = :id_proyect ";
				$values = array(':id_proyect' => $this->id_proyect  ); 
			}
			
			
			$resp = $obj_bd->execute($query, $values);
			if ( $resp )
			{
				return TRUE;
			}
			else
			{
				$this->set_error("Database error while (un)asigning all PDVs. " , ERR_DB_EXEC );
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	public function active_pdv( $id_pdv, $active = TRUE )
	{
		global $Session;
		
		if ( $Session->is_admin() )
		{
			if ( is_numeric( $id_pdv ) )
			{
				global $obj_bd;
				$query = " UPDATE ". PFX_MAIN_DB ."proyect_pdv SET ppv_active = :active "
							. " WHERE ppv_pr_id_proyect = :id_proyect AND ppv_pdv_id_pdv = :id_pdv ";
				
				$values = array(':active' => ( $active ? 1 : 0 ) ,  ':id_proyect' => $this->id_proyect, ":id_pdv" => $id_pdv ); 
				
				$resp = $obj_bd->execute($query, $values);
				if ( $resp )
				{
					return TRUE;
				}
				else
				{
					$this->set_error("Database error while (de)activating PDV ( " . $id_pdv . " )." , ERR_DB_EXEC );
					return FALSE;
				}
			}
			else
			{
				$this->set_error("Invalid PDV.", ERR_VAL_INVALID);
				return FALSE;
			}
		} else {
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	
	public function activate_pdv_all($state)
	{
		global $Session;
		
		if ( $Session->is_admin() )
		{
			global $obj_bd;
			$query = 	" UPDATE ". PFX_MAIN_DB ."proyect_pdv SET ppv_active = :active, ppv_timestamp = :time WHERE ppv_pr_id_proyect = :id_proyect ";
			
			$values = array(':id_proyect' => $this->id_proyect, ":time" => time(), ":active" => $state ); 
			
			$resp = $obj_bd->execute($query, $values);
			if ( $resp )
			{
				return TRUE;
			}
			else
			{
				$this->set_error("Database error while (de)activating all users. " , ERR_DB_EXEC );
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	/*catalogos*/
	public function asign_evidence_type($id_evidence, $asign = TRUE)
	{
		global $Session;
		if ( $Session->is_admin() )
		{
			if ( is_numeric( $id_evidence ) )
			{
				global $obj_bd;
				
				if($asign)
				{
					$qry = 	" INSERT INTO ". PFX_MAIN_DB ."proyect_evidence_type (pet_pr_id_proyect, pet_et_id_evidence_type) ".
							" VALUES ( :id_proyect, :id_evidence) ";
				}
				else
				{
					$qry =	" DELETE FROM ". PFX_MAIN_DB ."proyect_evidence_type WHERE pet_pr_id_proyect = :id_proyect ".
							" AND pet_et_id_evidence_type = :id_evidence ";
				}
				
				$values = array( ":id_proyect" => $this->id_proyect, ":id_evidence" => $id_evidence );
				
				$resp = $obj_bd->execute($qry, $values);
				if ( $resp  )
				{
					return TRUE;
				}
				else
				{
					$this->set_error("Database error while asigning the evidence type ( " . $id_evidence . " ). ", ERR_DB_EXEC );
					return FALSE;
				}
			}
			else
			{
				$this->set_error("Invalid Evidence Type.", ERR_VAL_INVALID);
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	public function asign_evidence_type_all($state)
	{
		global $Session;
		if ( $Session->is_admin() )
		{
			global $obj_bd;
			
			if($state > 0)
			{
				$query = 	" INSERT INTO " . PFX_MAIN_DB ."proyect_evidence_type (pet_pr_id_proyect, pet_et_id_evidence_type) ".
							" SELECT :id_proyect, id_evidence_type ".
							" FROM " . PFX_MAIN_DB ."evidence_type ".
							" WHERE id_evidence_type NOT IN ".
							" (SELECT pet_et_id_evidence_type FROM " . PFX_MAIN_DB ."proyect_evidence_type WHERE pet_pr_id_proyect = :id_proyect ) ";
			}
			else
			{
				$query = 	" DELETE FROM " . PFX_MAIN_DB ."proyect_evidence_type WHERE pet_pr_id_proyect = :id_proyect ";
			}
			$values = array(':id_proyect' => $this->id_proyect ); 
			
			$resp = $obj_bd->execute($query, $values);
			if ( $resp )
			{
				return TRUE;
			}
			else
			{
				$this->set_error("Database error while (un)asigning all Evidence Types. " , ERR_DB_EXEC );
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	public function asign_task_omition($id_toc, $asign = TRUE)
	{
		global $Session;
		if ( $Session->is_admin() )
		{
			if ( is_numeric( $id_toc ) )
			{
				global $obj_bd;
				
				if($asign)
				{
					$qry = 	" INSERT INTO ". PFX_MAIN_DB ."proyect_omition_cause (poc_pr_id_proyect, poc_toc_id_task_omition_cause) ".
							" VALUES ( :id_proyect, :id_toc) ";
				}
				else
				{
					$qry =	" DELETE FROM ". PFX_MAIN_DB ."proyect_omition_cause WHERE poc_pr_id_proyect = :id_proyect ".
							" AND poc_toc_id_task_omition_cause = :id_toc ";
				}
				
				$values = array( ":id_proyect" => $this->id_proyect, ":id_toc" => $id_toc );
				
				$resp = $obj_bd->execute($qry, $values);
				if ( $resp  )
				{
					return TRUE;
				}
				else
				{
					$this->set_error("Database error while asigning the toc ( " . $id_toc . " ). ", ERR_DB_EXEC );
					return FALSE;
				}
			}
			else
			{
				$this->set_error("Invalid Evidence Type.", ERR_VAL_INVALID);
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	public function asign_task_omition_all($state)
	{
		global $Session;
		if ( $Session->is_admin() )
		{
			global $obj_bd;
			
			if($state > 0)
			{
				$query = 	" INSERT INTO " . PFX_MAIN_DB ."proyect_omition_cause (poc_pr_id_proyect, poc_toc_id_task_omition_cause) ".
							" SELECT :id_proyect, id_task_omition_cause ".
							" FROM " . PFX_MAIN_DB ."task_omition_cause ".
							" WHERE id_task_omition_cause NOT IN ".
							" (SELECT poc_toc_id_task_omition_cause FROM " . PFX_MAIN_DB ."proyect_omition_cause ".
							" WHERE poc_pr_id_proyect = :id_proyect ) ";
			}
			else
			{
				$query = 	" DELETE FROM " . PFX_MAIN_DB ."proyect_omition_cause WHERE poc_pr_id_proyect = :id_proyect ";
			}
			$values = array(':id_proyect' => $this->id_proyect ); 
			
			$resp = $obj_bd->execute($query, $values);
			if ( $resp )
			{
				return TRUE;
			}
			else
			{
				$this->set_error("Database error while (un)asigning all TOC. " , ERR_DB_EXEC );
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	public function asign_visit_omition($id_vrc, $asign = TRUE)
	{
		global $Session;
		if ( $Session->is_admin() )
		{
			if ( is_numeric( $id_vrc ) )
			{
				global $obj_bd;
				
				if($asign)
				{
					$qry = 	" INSERT INTO ". PFX_MAIN_DB ."proyect_reschedule_cause (prc_pr_id_proyect, prc_vrc_id_visit_reschedule_cause) ".
							" VALUES ( :id_proyect, :id_vrc) ";
				}
				else
				{
					$qry =	" DELETE FROM ". PFX_MAIN_DB ."proyect_reschedule_cause WHERE prc_pr_id_proyect = :id_proyect ".
							" AND prc_vrc_id_visit_reschedule_cause = :id_vrc ";
				}
				
				$values = array( ":id_proyect" => $this->id_proyect, ":id_vrc" => $id_vrc );
				
				$resp = $obj_bd->execute($qry, $values);
				if ( $resp  )
				{
					return TRUE;
				}
				else
				{
					$this->set_error("Database error while asigning the vrc ( " . $id_vrc . " ). ", ERR_DB_EXEC );
					return FALSE;
				}
			}
			else
			{
				$this->set_error("Invalid Visit Reschedule Cause.", ERR_VAL_INVALID);
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	public function asign_visit_omition_all($state)
	{
		global $Session;
		if ( $Session->is_admin() )
		{
			global $obj_bd;
			
			if($state > 0)
			{
				$query = 	" INSERT INTO " . PFX_MAIN_DB ."proyect_reschedule_cause (prc_pr_id_proyect, prc_vrc_id_visit_reschedule_cause) ".
							" SELECT :id_proyect, id_visit_reschedule_cause ".
							" FROM " . PFX_MAIN_DB ."visit_reschedule_cause ".
							" WHERE id_visit_reschedule_cause NOT IN ".
							" (SELECT prc_vrc_id_visit_reschedule_cause FROM " . PFX_MAIN_DB ."proyect_reschedule_cause ".
							" WHERE prc_pr_id_proyect = :id_proyect ) ";
			}
			else
			{
				$query = 	" DELETE FROM " . PFX_MAIN_DB ."proyect_reschedule_cause WHERE prc_pr_id_proyect = :id_proyect ";
			}
			$values = array(':id_proyect' => $this->id_proyect ); 
			
			$resp = $obj_bd->execute($query, $values);
			if ( $resp )
			{
				return TRUE;
			}
			else
			{
				$this->set_error("Database error while (un)asigning all VRC. " , ERR_DB_EXEC );
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	public function asign_supplier($id_supplier, $asign = TRUE)
	{
		global $Session;
		if ( $Session->is_admin() )
		{
			if ( is_numeric( $id_supplier ) )
			{
				global $obj_bd;
				
				if($asign)
				{
					$qry = 	" INSERT INTO ". PFX_MAIN_DB ."proyect_supplier (psu_pr_id_proyect, psu_su_id_supplier) ".
							" VALUES ( :id_proyect, :id_supplier) ";
				}
				else
				{
					$qry =	" DELETE FROM ". PFX_MAIN_DB ."proyect_supplier WHERE psu_pr_id_proyect = :id_proyect ".
							" AND psu_su_id_supplier = :id_supplier ";
				}
				
				$values = array( ":id_proyect" => $this->id_proyect, ":id_supplier" => $id_supplier );
				
				$resp = $obj_bd->execute($qry, $values);
				if ( $resp  )
				{
					return TRUE;
				}
				else
				{
					$this->set_error("Database error while asigning the supplier ( " . $id_supplier . " ). ", ERR_DB_EXEC );
					return FALSE;
				}
			}
			else
			{
				$this->set_error("Invalid Supplier.", ERR_VAL_INVALID);
				return FALSE;
			}
		}
		else
		{
			$this->set_error("Restricted action.", SES_RESTRICTED_ACTION, 3);
			return FALSE;
		}
	}
	
	public function asign_supplier_all($state)
	{
		global $Session;
		if ( $Session->is_admin() )
		{
			global $obj_bd;
			
			if($state > 0)
			{
				$query = 	" INSERT INTO " . PFX_MAIN_DB ."proyect_supplier (psu_pr_id_proyect, psu_su_id_supplier) ".
							" SELECT :id_proyect, id_supplier ".
							" FROM " . PFX_MAIN_DB ."supplier ".
							" WHERE id_supplier NOT IN ".
							" (SELECT psu_su_id_supplier FROM " . PFX_MAIN_DB ."proyect_supplier ".
							" WHERE psu_pr_id_proyect = :id_proyect ) ";
			}
			else
			{
				$query = 	" DELETE FROM " . PFX_MAIN_DB ."proyect_supplier WHERE psu_pr_id_proyect = :id_proyect ";
			}
			$values = array(':id_proyect' => $this->id_proyect ); 
			
			$resp = $obj_bd->execute($query, $values);
			if ( $resp )
			{
				return TRUE;
			}
			else
			{
				$this->set_error("Database error while (un)asigning all Suppliers. " , ERR_DB_EXEC );
				return FALSE;
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