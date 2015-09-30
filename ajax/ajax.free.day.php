<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.free.day.php";
switch ( $action ){
	case 'delete_free_day':
		$id_free_day =( isset($_POST['id_free_day']) && is_numeric($_POST['id_free_day']) && $_POST['id_free_day'] > 0 ) ? $_POST['id_free_day'] : 0;
		echo $id_free_day;
			if ( $id_free_day > 0 ){				
			
				$freeday = new Freeday($id_free_day);
				$freeday->id_free_day = $id_free_day; 
				$resp = $freeday->delete();
				if ( !$resp || count($freeday->error) > 0 ){
					$response['error'] 	= $freeday->get_errors();
				} else {
					$response['success'] = TRUE;
				}							
			} else{
				$response['error'] = "Invalid Free Day.";
			} 
		break;
		case 'is_unique_day':
			global $Validate;
			$id_free_day = $_POST['id_free_day'];
			$free_day = $_POST['free_day']; 					
			$id_free_day = ( !is_numeric($id_free_day) ) ? 0 : $id_free_day;					
			$response['unique']  = $Validate->is_unique(  'pr1_free_day', 'fd_date_string', $free_day, 'id_free_day', $id_free_day );
			$response['success'] = TRUE; 
		break;
	case 'get_free_day':  
			$id_free_day = ( isset($_POST['id_free_day']) && is_numeric($_POST['id_free_day']) && $_POST['id_free_day'] > 0 ) ? $_POST['id_free_day'] : 0;
			if ( $id_free_day > 0 ){
				$freeday = new Freeday( $id_free_day );
				$response['info'] = $freeday->get_array();
				if ( count( $freeday->error ) > 0 ){
					$response['error'] = $freeday->get_errors(); 
				} else {
					$response['success'] = TRUE;
				}
			} else{
				$response['error'] = "Invalid Free Day.";
			}
	break;
	
	default:
		$response['error'] = "Invalid action.";
			break;
}
?>