<?php

/**
 * AdminProyectList
 */
class AdminProyectSupervisorList extends DataTable {
	 
	private $us_parent; 
	 
	function __construct( $which = '', $table_id = '', $parent = 0 ) {
		$this->class = 'AdminProyectSupervisorList';
		$this->us_parent = ( $parent > 0 ? $parent : 0 );
		if ( $which != '' ) {
			global $Session;
			$this->which = $which; 
			parent::__construct( $which, $table_id ); 
			$this->id_proyect = $Session->get_proyect();
			
			$this->set_query();
			$this->set_template(); 
		} else {
			$this->clean();
			$this->error[] = "Listado inválido.";
		} 
	}
	
	public function set_list( $which, $table_id = '' ){ 
		$this->which = $which;
		if ( $table_id != '')
			$this->table_id = $table_id;
		else 
			$this->table_id = $which ;
		$this->set_query();
		$this->set_template();
	}
	
	private function set_query(){
		switch ( $this->which ){ 
			
			case 'lst_pry_supervisor':
				$this->query = 	"SELECT id_user, us_user, us_zone, pf_profile, usu_us_id_parent IS NOT NULL as asigned, ".$this->us_parent." as parent ".
								" FROM " . PFX_MAIN_DB . "proyect_user ".
								" INNER JOIN " . PFX_MAIN_DB . "user ON id_user = pu_us_id_user AND us_pf_id_profile > 4 ".
								" INNER JOIN " . PFX_MAIN_DB . "profile ON us_pf_id_profile = id_profile ".
								" LEFT JOIN  " . PFX_MAIN_DB . "pr1_user_supervisor ON usu_us_id_user = pu_us_id_user ".
								" WHERE pu_pr_id_proyect = ".ID_PRY. " AND us_status > 0 AND usu_us_id_parent IS NULL ".
								" OR usu_us_id_parent = ".$this->us_parent;
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_user';
				$this->sort = " ORDER BY " . $this->sidx . " " . $this->sord . " ";
			break;
			
			case 'lst_pry_agenda':			
				$this->query= "SELECT id_user, us_user, id_visit, vi_pdv_id_pdv, vi_us_id_user, vi_status, id_pdv, ".
							"pdv_name, pdv_zone, pdv_status FROM " . PFX_MAIN_DB . "user RIGHT JOIN  " . PFX_PRY_DB . "visit ".
							"ON id_user=vi_us_id_user RIGHT JOIN sf_pdv ON vi_pdv_id_pdv=id_pdv WHERE id_user =".$this->us_parent;				
				$this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_user';
				$this->sort = " ORDER BY " . $this->sidx . " " . $this->sord . " ";
			break;
						
			
		}
		
	}
	
	private function set_template(){
		switch ( $this->which ){ 
			case 'lst_pry_supervisor':
				$this->columns = array(
					array( 'idx' => 'id_user',		'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'us_user',		'lbl' => 'Usuario', 	'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'us_zone',		'lbl' => 'Zona', 		'sortable' => TRUE, 	'searchable' => TRUE	), 
					array( 'idx' => 'pf_profile',	'lbl' => 'Perfil', 		'sortable' => TRUE, 	'searchable' => TRUE	),
					array( 'idx' => 'asigned',		'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE	)
				); 
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.supervisor.php"; 
			break;
			case 'lst_pry_agenda':
				$this->columns = array(
					array( 'idx' => 'id_user',		'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'us_user',		'lbl' => 'Usuario', 	'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'pdv_name',		'lbl' => 'PDV', 		'sortable' => TRUE, 	'searchable' => TRUE	), 
					array( 'idx' => 'pdv_zone',		'lbl' => 'Zona', 		'sortable' => TRUE, 	'searchable' => TRUE	),
					array( 'idx' => 'asigned',		'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE	)					
				); 
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.agenda.php"; 
			break;
		}
	} 
}


?>