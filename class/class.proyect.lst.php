<?php

/**
 * ProyectList
 */
class ProyectList extends DataTable {
	
	function __construct( $which = '', $table_id = '' ) {
		$this->class = 'ProyectList';
		if ( $which != '' ) {
			$this->which = $which; 
			parent::__construct( $which, $table_id );
			$this->set_query();
			$this->set_template(); 
		} else {
			$this->clean();
			$this->error[] = "Listado inválido.";
		} 
	}
	
	private function set_query(){
		switch ( $this->which ){ 
			case 'lst_proyect':
				$this->query = " SELECT " 
								. " id_proyect, pr_proyect, id_proyect_type, prt_proyect_type, id_region, re_region, id_company, cm_company " 
							. " FROM " . PFX_MAIN_DB . "proyect " 
								. " INNER JOIN " . PFX_MAIN_DB . "proyect_type ON id_proyect_type = pr_prt_id_proyect_type " 
								. " INNER JOIN " . PFX_MAIN_DB . "region ON id_region = pr_re_id_region " 
								. " INNER JOIN " . PFX_MAIN_DB . "company ON id_company = pr_cm_id_company " 
							. " WHERE pr_status = 1 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_proyect';
				break;
			case 'lst_pry_order':
				
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_order';
				$start 	= (($this->page - 1) * $this->rows);  
				
				$this->query = " SELECT "
								. " tbl.*, SUM( od_quantity * od_price ) AS total "
							. " FROM ( "
								. " SELECT "
									. " id_order, id_pdv, id_user, or_date, pdv_name, us_user, or_status "
								. " FROM " . PFX_MAIN_DB . "order " 
									. " INNER JOIN " . PFX_MAIN_DB . "user ON id_user = or_us_id_user "
									. " INNER JOIN " . PFX_MAIN_DB . "pdv ON id_pdv = or_pdv_id_pdv " 
								. " WHERE or_status = 1 "
								. (		( $this->sidx != "total" ) 
										? " ORDER BY " . $this->sidx . " " . $this->sord . " " 
											. " LIMIT " . $start . ", " . $this->rows . " "
										: "" 
									)
							. " ) as tbl "
								. " INNER JOIN " .  PFX_MAIN_DB . "order_detail ON od_or_id_order = id_order " 
							. " WHERE or_status = 1 "
							. " GROUP BY id_order ";
				break;
			case 'lst_pry_visit':		
				$this->query = " SELECT "
								. " id_visit, id_pdv, id_user, id_visit_status, vi_scheduled_start, vi_scheduled_end, vi_real_start, vi_real_end, "
								. " pdv_name, us_user, vs_visit_status, vi_latitude, vi_longitude"
							. " FROM " . PFX_MAIN_DB . "visit "
								. " INNER JOIN " . PFX_MAIN_DB . "visit_status ON id_visit_status = vi_vs_id_visit_status "
								. " INNER JOIN " . PFX_MAIN_DB . "user ON id_user = vi_us_id_user "
								. " INNER JOIN " . PFX_MAIN_DB . "pdv ON id_pdv = vi_pdv_id_pdv "
							. " WHERE vi_status = 1 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_visit';
				break;
		}
		$this->sort = " ORDER BY " . $this->sidx . " " . $this->sord . " ";
	}
	
	private function set_template() {
		switch ( $this->which ){ 
			case 'lst_proyect':
				$this->title = " Proyectos ";
				$this->columns = array(
					array( 'idx' => 'id_proyect',		'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'prt_proyect_type',	'lbl' => 'Tipo',		'sortable' => TRUE, 	'searchable' => TRUE 	),
					array( 'idx' => 'pr_proyect',		'lbl' => 'Proyecto',	'sortable' => TRUE, 	'searchable' => TRUE 	),   
					array( 'idx' => 're_region',		'lbl' => 'Región',		'sortable' => TRUE, 	'searchable' => TRUE 	),   
					array( 'idx' => 'cm_company',		'lbl' => 'Compañía',	'sortable' => TRUE, 	'searchable' => TRUE 	),   
					array( 'idx' => 'actions',			'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE, 'width' => '120px'	)
				); 
				$this->template = DIRECTORY_VIEWS . "/lists/lst.proyect.php"; 
				break;  
			case 'lst_pry_visit':
				$this->title = " Visitas ";
				$this->columns = array(
					array( 'idx' => 'id_visit',			'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'vi_scheduled_start','lbl'=> 'Inicio Prog.','sortable' => TRUE, 	'searchable' => TRUE 	),
				//	array( 'idx' => 'vi_scheduled_end',	'lbl' => 'Final Prog.',	'sortable' => TRUE, 	'searchable' => TRUE 	),
					array( 'idx' => 'vi_real_start',	'lbl' => 'Inicio Real',	'sortable' => TRUE, 	'searchable' => TRUE 	),
				//	array( 'idx' => 'vi_real_end',		'lbl' => 'Final Real', 	'sortable' => TRUE, 	'searchable' => TRUE 	),   
					array( 'idx' => 'us_user',			'lbl' => 'Usuario',		'sortable' => TRUE, 	'searchable' => TRUE 	),   
					array( 'idx' => 'pdv_name',			'lbl' => 'PDV',			'sortable' => TRUE, 	'searchable' => TRUE 	), 			 
					array( 'idx' => 'vs_visit_status',	'lbl' => 'Status',		'sortable' => TRUE, 	'searchable' => TRUE 	),   
					array( 'idx' => 'actions',			'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE, 'width' => '60px'	)
				); 
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.visit.php"; 
				break;  
			case 'lst_pry_order':
				$this->title = " Pedidos ";
				$this->columns = array(
					array( 'idx' => 'id_order',			'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'or_date',			'lbl' => 'Fecha',		'sortable' => TRUE, 	'searchable' => TRUE 	),    
					array( 'idx' => 'us_user',			'lbl' => 'Usuario',		'sortable' => TRUE, 	'searchable' => TRUE 	),   
					array( 'idx' => 'pdv_name',			'lbl' => 'PDV',			'sortable' => TRUE, 	'searchable' => TRUE 	),   
					array( 'idx' => 'total',			'lbl' => 'Total',		'sortable' => TRUE, 	'searchable' => TRUE 	),   
					array( 'idx' => 'actions',			'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE, 'width' => '60px'	)
				); 
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pry.order.php"; 
				break;  
		}
	}
	 

}


?>