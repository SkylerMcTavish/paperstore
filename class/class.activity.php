<?php
/**
* Activity CLass
* 
* @package		Ragasa
* @since        4/2/2015
* @author		ignacio.cerda
* 
*/ 
class Activity extends Object {
	 
	public $id_activity;
	public $activity;
	public $description;
	public $id_aux;
	public $lbl_aux;
	public $default_activity;
	 
	public $id_activity_type;
	public $activity_type;
	
	public $timestamp;
	
	function __construct( $id_activity = 0 )
	{
		global $obj_bd;
		$this->class = 'Activity';
		$this->error = array();
		$this->clean();
		
		if ( $id_activity > 0 )
		{
			$query = 	" SELECT id_activity, ac_activity, ac_description, ac_aux_id_auxiliar, ac_at_id_activity_type, ac_default, ac_timestamp ".
						" FROM ". PFX_MAIN_DB ."activity ".
						" WHERE id_activity = :id_activity ";
					
			$info = $obj_bd->query( $query, array( ':id_activity' => $id_activity ) );
			
			if ( $info !== FALSE )
			{
				if ( count($info) > 0 )
				{ 
					$act = $info[0];
					$this->id_activity 		= $act['id_activity'];
					$this->activity 		= $act['ac_activity'];
					$this->description	 	= $act['ac_description'];
					$this->id_aux	 		= $act['ac_aux_id_auxiliar'];
					$this->default_activity	= $act['ac_default'];
					
					$this->timestamp		= $act['ac_timestamp'];
					
					$this->set_activity_type( $act['ac_at_id_activity_type'] );
					$this->set_auxiliar_data();
					
				}
				else
				{
					$this->set_error( "Activity not found (" . $id_activity . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			}
			else
			{ 
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
			} 
		}   
	}
	
	private function set_auxiliar_data()
	{
		if($this->id_aux > 0 )
		{
			global $obj_bd;
			$query = 	" SELECT ".$this->activity_type->id_table_aux . " as id, " .
							$this->activity_type->pfx_table_aux.$this->activity_type->col_table_aux . " as opt ".
						" FROM " .$this->activity_type->base_pfx_table_aux.$this->activity_type->table_aux . " ".
						" WHERE ". $this->activity_type->id_table_aux . " = :id_aux " ;

			$info = $obj_bd->query( $query, array(':id_aux' => $this->id_aux) );
			
			if ( $info !== FALSE )
			{
				if ( count($info) > 0 )
				{ 
					$aux = $info[0];
					$this->lbl_aux = $aux['opt'];
				}
				else
				{
					$this->set_error( "Auxiliar data not found (" . $this->activity_type->table_aux . "," . $this->id_aux. "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			}
			else
			{ 
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
			} 
			
		}
	}
	
	private function set_activity_type( $type = 0 )
	{
		if($type > 0 )
		{
			if ( !class_exists( 'ActivityType' ) ) 
		 		require_once 'class.activity.type.php';
			 $this->activity_type = new ActivityType( $type ); 
		}
		else
		{
			$this->set_error( "Invalid Activity Type ID. ", ERR_DB_NOT_FOUND, 2  );
		}
	}
	
	public function get_info_html()
	{
		$html  = "";
		$activity = $this;
		ob_start();
		require_once DIRECTORY_VIEWS . "activity/info.activity.php"; 
		$html .= ob_get_contents();
		ob_end_clean(); 
		return str_replace(array("\n", "\t"), "", $html);
	}
	
	public function get_array()
	{
		$values = array(
							'id_activity'	=> $this->id_activity,
							'activity'		=> $this->activity,
							'description'	=> $this->description,
							'id_aux'		=> $this->id_aux,
							'default'		=> $this->default_activity,
							'timestamp'		=> $this->timestamp,
							'activity_type'	=> $this->activity_type->get_array()
						);
		
		return $values;
	}
	
	private function clean()
	{
		$this->id_activity 		= 0;
		$this->activity 		= '';
		$this->description	 	= '';
		$this->id_aux	 		= 0;
		$this->default_activity	= 0;
		$this->id_activity_type	= 0;
		$this->timestamp		= 0;
		
		//$this->set_activity_type($this->id_activity_type);
	}
}

?>