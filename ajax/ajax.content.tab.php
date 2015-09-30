<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.content.tab.php"; 
switch ( $action ){
	case 'get_tab_info_html': 
		$tab = ( isset($_POST['tab']) && is_numeric($_POST['tab']) && $_POST['tab'] > 0 ) ? $_POST['tab'] : 0;
		
		if ( $tab != null || $tab!="" ){
			$tab= new TAB( $tab ); 
			$response['html'] = $tab->get_info_html( );
			if ( count( $tab->error ) > 0 ){
				$response['error'] = $tab->get_errors(); 
			} else {
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid Visit.";
		} 
		break;  
	
}
?>