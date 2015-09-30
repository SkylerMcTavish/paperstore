<?php

/*05/01/15 CS*/
global $response; 
global $Session;
global $Settings;

if ( $Session->is_admin() ){
	switch ( $action ){
		case 'bookingsave':
			require_once DIRECTORY_CLASS . "class.admin.visit.php";
			require_once DIRECTORY_CLASS . "class.pdv.php";				
			$id_visit=0;

			$id_visit_status=1;
			$id_pdv=(isset($_POST['c0']) && is_numeric($_POST['c0']) && $_POST['c0'] > 0 ) ? $_POST['c0'] : 0;
			$scheduled_start=(isset($_POST['c1']) && is_numeric($_POST['c1']) && $_POST['c1'] > 0 ) ? $_POST['c1'] : 0; 		
			$scheduled_end=(isset($_POST['c2']) && is_numeric($_POST['c2']) && $_POST['c1'] > 0 ) ? $_POST['c2'] : 0; 
			$real_start=(isset($_POST['c3']) && is_numeric($_POST['c3']) && $_POST['c3'] > 0 ) ? $_POST['c3'] : 0; 
			$real_end=(isset($_POST['c4']) && is_numeric($_POST['c4']) && $_POST['c4'] > 0 ) ? $_POST['c4'] : 0; 
			$id_user=(isset($_POST['c5']) && is_numeric($_POST['c5']) && $_POST['c5'] > 0 ) ? $_POST['c5'] : 0;
			$latitude=(isset($_POST['c7']) && is_numeric($_POST['c7']) && $_POST['c7'] > 0 ) ? $_POST['c7'] : 0;
			$longitude=(isset($_POST['c8']) && is_numeric($_POST['c8'])) ? $_POST['c8'] : 0; 
			  
		
			if ( $id_pdv > 0 ){
				$Visit = new AdminVisit();				
				$Visit->id_pdv = $id_pdv;
				$Visit->id_user= $id_user;
				$Visit->scheduled_start = $scheduled_start;
				$Visit->scheduled_end = $scheduled_end;
				$Visit->real_end= $real_end;
				$Visit->real_start = $real_start;		
				$Visit->id_visit_status=$id_visit_status;
				$Visit->latitude=$latitude;
				$Visit->longitude=$longitude;
				$response['info'] = $Visit->save();					
					
					if ( count($Visit->error) > 0 ){
					$response['error'] = $Visit->get_errors(); 
				} else {
					$response['success'] = TRUE;
				}
			} else{
				$response['error'] = "Opción no válida.";
			} 
			break;
		default:
			$response['error'] = "Invalid action.";
			break;	
	}
}else{
	$response['error'] = "Restricted action.";
} 
?>