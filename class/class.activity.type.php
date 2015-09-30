<?php
/**
* Activity Type CLass
* 
* @package		Ragasa
* @since        4/2/2015
* @author		ignacio.cerda
* 
*/ 
class ActivityType extends Object {
	 
	public $id_activity_type;
	public $activity_type;
	
	public $table_aux;
	public $label_table_aux;
	public $id_table_aux;
	public $col_table_aux;
	public $pfx_table_aux;		//prefijo de los campos de la tabla
	public $base_pfx_table_aux; //permite definir si la tabla se encuentra en un proyecto o no
	
	
	function __construct( $id_activity_type = 0 )
	{
		global $obj_bd;
		$this->class = 'ActivityType';
		$this->error = array();
		$this->clean();
		
		if ( $id_activity_type > 0 )
		{
			$query = 	" SELECT id_activity_type, at_activity_type, at_table_aux ".
						" FROM ". PFX_MAIN_DB ."activity_type ".
						" WHERE id_activity_type = :id_activity_type ";
					
			$info = $obj_bd->query( $query, array( ':id_activity_type' => $id_activity_type ) );
			
			if ( $info !== FALSE )
			{
				if ( count($info) > 0 )
				{ 
					$act = $info[0];
					$this->id_activity_type 	= $act['id_activity_type'];
					$this->activity_type 		= $act['at_activity_type'];
					
					$this->set_aux_table($act['at_table_aux']);
					
					
				}
				else
				{
					$this->set_error( "Activity Type not found (" . $id_activity_type . "). ", ERR_DB_NOT_FOUND, 2 ); 
				}
			}
			else
			{ 
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
			} 
		}   
	}
	
	private function set_aux_table( $table_aux = '' )
	{
		if($table_aux != '' )
		{
			$this->table_aux = $table_aux;
			
			switch($this->table_aux)
			{
				case 'form':
					$this->id_table_aux 		= 'id_form';
					$this->col_table_aux 		= 'title';
					$this->pfx_table_aux		= 'frm_';
					$this->label_table_aux		= 'Formulario';
					$this->base_pfx_table_aux	= PFX_MAIN_DB;
				break;
				
				case 'media_file':
					$this->id_table_aux 		= 'id_media_file';
					$this->col_table_aux 		= 'title';
					$this->pfx_table_aux		= 'mf_';
					$this->label_table_aux		= 'Archivo de Medios';
					$this->base_pfx_table_aux	= PFX_MAIN_DB;
				break;
				
				case 'profile':
					$this->id_table_aux 		= 'id_profile';
					$this->col_table_aux 		= 'profile';
					$this->pfx_table_aux		= 'pf_';
					$this->label_table_aux		= 'Perfil de Usuario';
					$this->base_pfx_table_aux	= PFX_MAIN_DB;
				break;
				
				case 'evidence_type':
					$this->id_table_aux 		= 'id_evidence_type';
					$this->col_table_aux 		= 'evidence_type';
					$this->pfx_table_aux		= 'et_';
					$this->label_table_aux		= 'Tipo de Evidencia';
					$this->base_pfx_table_aux	= PFX_MAIN_DB;
				break;
			}
		}
	}
	
	public function get_table_aux_html_option()
	{
		$html = '';
		if( $this->table_aux != '' )
		{
			global $obj_bd;
			$query = "";
			$values = array( ':status' => 1 );
			
			$query = 	" SELECT ". $this->id_table_aux . " as id, ".
						" ". $this->pfx_table_aux.$this->col_table_aux . " as opt ".
						" FROM " . $this->base_pfx_table_aux. $this->table_aux . " ".
						" WHERE " . $this->pfx_table_aux."status = :status ";
			
			$info = $obj_bd->query( $query, $values );
			
			if ( $info !== FALSE )
			{
				$html = '<option value="" >Selecciona una opción</option>';
				foreach( $info as $k => $opt)
				{
					$html .= '<option value="'.$opt['id'].'" >' . $opt['opt'] . '</option>';
				}
				
			}
			else
			{
				$this->set_error( "An error ocurred while querying the Data Base. ", ERR_DB_QRY, 2 );
			}
		}
		
		return $html;
	}
	
	public function get_array()
	{
		$values = array(
							'id_activity_type'	=> $this->id_activity_type,
							'activity_type'		=> $this->activity_type,
							'table_aux'			=> $this->table_aux
						);
		
		return $values;
	}
	
	private function clean()
	{
		$this->id_activity_type	= 0;
		$this->activity_type	= '';
		$this->table_aux		= '';
		$this->id_table_aux		= '';
		$this->col_table_aux	= '';
	}
}

?>