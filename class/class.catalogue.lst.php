<?php

/**
 * CatalogueList
 */
class CatalogueList extends DataTable {
	
	function __construct( $which = '', $table_id = '' ) {
		
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
			case 'rack':
				$this->query = " SELECT *, id_rack as id, rk_name as value  FROM " . PFX_MAIN_DB . "rack c WHERE rk_status = 1 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_rack';
			break;
			
			case 'brand':
				$this->query = " SELECT *, id_brand as id, br_brand as value  FROM " . PFX_MAIN_DB . "brand c WHERE br_status = 1 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_brand';
			break;
			
			case 'supplier':
				$this->query = " SELECT *, id_supplier as id, sp_supplier as value  FROM " . PFX_MAIN_DB . "supplier c WHERE sp_status = 1 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_supplier';
			break;
			
			case 'product_category':
				$this->query = " SELECT *, id_product_category as id, pc_product_category as value  FROM " . PFX_MAIN_DB . "product_category c WHERE pc_status = 1 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_product_category';
			break;
		/**************************************/
			case 'company':
				$this->query = " SELECT *, id_company as id, cm_company as value  FROM " . PFX_MAIN_DB . "company c WHERE cm_status = 1 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_company';
				break;
			case 'country':
				$this->query = " SELECT *, id_country as id, cnt_country as value  FROM " . PFX_MAIN_DB . "country c WHERE cnt_status = 1 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_country';
				break;
			case 'evidence_type':
				$this->query = " SELECT *, id_evidence_type as id, et_evidence_type as value FROM " . PFX_MAIN_DB . "evidence_type c WHERE et_status = 1 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_evidence_type';
				break; 
			case 'region':
				$this->query = " SELECT *, id_region as id, re_region as value FROM " . PFX_MAIN_DB . "region WHERE re_status = 1 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_region';
				break;
			case 'visit_reschedule_cause':
				$this->query = " SELECT *, id_visit_reschedule_cause as id, vrc_visit_reschedule_cause as value FROM " . PFX_MAIN_DB . "visit_reschedule_cause WHERE vrc_status = 1 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_visit_reschedule_cause';
				break;
			case 'state':
				$this->query = " SELECT *, id_state as id, st_state as value, cnt_country as parent FROM " . PFX_MAIN_DB . "state "
					. " INNER JOIN " . PFX_MAIN_DB . "country ON id_country = st_cnt_id_country " 
				. " WHERE st_status = 1 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_state';
				break;
			case 'task_omition_cause':
				$this->query = " SELECT *, id_task_omition_cause as id,  toc_task_omition_cause as value, 
									IFNULL( tt_task_type, 'Default' )  as parent 
								FROM " . PFX_MAIN_DB . "task_omition_cause "
					. " LEFT JOIN " . PFX_MAIN_DB . "task_type ON id_task_type = toc_tt_id_task_type " 
				. " WHERE toc_status = 1 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_task_omition_cause';
				break;
		}
		
		$this->sort = " ORDER BY " . $this->sidx . " " . $this->sord . " ";
	}

	
	private function set_template() {
		switch ( $this->which ){ 
			case 'company':
				$this->title = " Compañías ";
				$this->columns = array(
					array( 'idx' => 'id_company',	'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'cm_company',	'lbl' => 'Compañía',  	'sortable' => TRUE, 	'searchable' => TRUE, 	'width' => '80%;' ),  
					array( 'idx' => 'actions',	 	'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE	)
				); 
				 
				break; 
			case 'country':
				$this->title = " Países ";
				$this->columns = array(
					array( 'idx' => 'id_country',	'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'cnt_country',	'lbl' => 'País',  		'sortable' => TRUE, 	'searchable' => TRUE, 	'width' => '80%;'  	),  
					array( 'idx' => 'actions',	 	'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE	)
				); 
				 
				break; 
			case 'evidence_type':
				$this->title = " Tipos de Evidencia ";
				$this->columns = array(
					array( 'idx' => 'id_evidence_type',	'lbl' => 'ID', 					'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'et_evidence_type',	'lbl' => 'Tipo de Evidencia',  	'sortable' => TRUE, 	'searchable' => TRUE, 	'width' => '80%;'  	),  
					array( 'idx' => 'actions',	 		'lbl' => 'Acciones', 			'sortable' => FALSE, 	'searchable' => FALSE	)
				); 
				 
				break;  
			case 'region':
				$this->title = " Regiones ";
				$this->columns = array(
					array( 'idx' => 'id_region',	'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 're_region',	'lbl' => 'Región',  	'sortable' => TRUE, 	'searchable' => TRUE, 	'width' => '80%;'  	),  
					array( 'idx' => 'actions',	 	'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE	)
				); 
				 
				break;
			case 'state':
				$this->title = " Estados ";
				$this->columns = array(
					array( 'idx' => 'id_state',		'lbl' => 'ID', 			'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'cnt_country',	'lbl' => 'País', 	 	'sortable' => TRUE, 	'searchable' => TRUE, 	'width' => '20%;'  	),
					array( 'idx' => 'st_state',		'lbl' => 'Estado',  	'sortable' => TRUE, 	'searchable' => TRUE, 	'width' => '60%;' 	),  
					array( 'idx' => 'actions',		'lbl' => 'Acciones', 	'sortable' => FALSE, 	'searchable' => FALSE	)
				); 
				break;  
			case 'task_omition_cause':
				$this->title = " Motivos de Omisión de Tarea ";
				$this->columns = array(
					array( 'idx' => 'id_task_omition_cause',	'lbl' => 'ID', 					'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'tt_task_type',				'lbl' => 'Tipo de Tarea',		'sortable' => TRUE, 	'searchable' => TRUE , 	'width' => '30%;' 	),
					array( 'idx' => 'toc_task_omition_cause',	'lbl' => 'Motivo de Omisión',	'sortable' => TRUE, 	'searchable' => TRUE , 	'width' => '50%;' 	),  
					array( 'idx' => 'actions',					'lbl' => 'Acciones', 			'sortable' => FALSE, 	'searchable' => FALSE	)
				);  
				break; 
			case 'visit_reschedule_cause':
				$this->title = " Motivos de Reagendación ";
				$this->columns = array(
					array( 'idx' => 'id_visit_reschedule_cause',	'lbl' => 'ID', 						'sortable' => TRUE, 	'searchable' => TRUE  	),
					array( 'idx' => 'vrc_visit_reschedule_cause',	'lbl' => 'Motivo de Reagendación',  'sortable' => TRUE, 	'searchable' => TRUE, 	'width' => '80%;'  	),  
					array( 'idx' => 'actions',	 					'lbl' => 'Acciones', 				'sortable' => FALSE, 	'searchable' => FALSE	)
				);  
				break;
		}
		$this->template = DIRECTORY_VIEWS . "/lists/lst.admin.catalogue.php"; 
	}
}


?>