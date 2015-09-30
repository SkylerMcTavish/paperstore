<?php
//ini_set('display_errors' , TRUE);
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.admin.proyect.asignation.php";
switch ( $action ){  
	case 'asign_record':  
		if ( $Session->id_proyect > 0 ){
			$asign = new ProyectAsignation( $Session->id_proyect ); 
			
			$source = ( isset($_POST['source']) && $_POST['source'] != "" ) ? $_POST['source'] 	: "";
			$value	= ( isset($_POST['value']) 	&& $_POST['value']	== "false" ) ? FALSE 	: TRUE;
			$id		= ( isset($_POST['id']) 	&& $_POST['id'] 	!= "" ) ? $_POST['id']  	: "";
			
			switch ( $source ) {
				case 'user': 			$resp = $asign->asign_user( $id, $value ); 	break;
				case 'product':			$resp = $asign->asign_product( $id, $value ); 	break;
				case 'pdv': 			$resp = $asign->asign_pdv( $id, $value ); 	break;
				case 'evidence_type': 	$resp = $asign->asign_evidence_type( $id, $value ); 	break;
				case 'task_omition': 	$resp = $asign->asign_task_omition( $id, $value ); 	break;
				case 'visit_omition': 	$resp = $asign->asign_visit_omition( $id, $value ); 	break;
				default:
					$resp = FALSE;
					$response['error'] = "Invalid source"; 
					break;
			} 
			if ( !$resp ){
				$response['error'] = $asign->get_errors(); 
			} else { 
				$response['success'] = TRUE;
			}
		} else{
			$response['error'] = "Invalid proyect.";
		} 
		break;
		
	case 'asign_records':
		if ( $Session->id_proyect > 0 )
		{
			$asign = new ProyectAsignation( $Session->id_proyect );
			
			$source = ( isset($_POST['source']) && $_POST['source'] != "" ) ? $_POST['source'] 	: "";
			$state	= ( isset($_POST['state']) 	&& $_POST['state']	== "false" ) ? FALSE : TRUE;
			$ids	= ( isset($_POST['ids']) 	&& $_POST['ids'] 	!= "" ) ? explode(';', $_POST['ids'] ) : "";
			
			switch ( $source )
			{
				case 'user':
					foreach($ids as $id)
					{
						$resp = $asign->asign_user( $id, $state );
					}
				break;
				
				case 'product':
					foreach($ids as $id)
					{
						$resp = $asign->asign_product( $id, $state );
					}
				break;
				
				case 'pdv':
					foreach($ids as $id)
					{
						$resp = $asign->asign_pdv( $id, $state );
					}
				break;
				
				case 'evidence_type':
					foreach($ids as $id)
					{
						$resp = $asign->asign_evidence_type( $id, $state );
					}
				break;
				
				case 'task_omition':
					foreach($ids as $id)
					{
						$resp = $asign->asign_task_omition( $id, $state );
					}	
				break;
				
				case 'visit_omition':
					foreach($ids as $id)
					{
						$resp = $asign->asign_visit_omition( $id, $state );
					}	
				break;
				
				default:
					$resp = FALSE;
					$response['error'] = "Invalid source"; 
					break;
			}
			
			if ( !$resp )
			{
				$response['error'] = $asign->get_errors(); 
			}
			else
			{ 
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid proyect.";
		} 
	break;
	
	case 'asign_all':
		if ( $Session->id_proyect > 0 )
		{
			if( isset($_POST['state']) && is_numeric($_POST['state']) )
			{
				$asign = new ProyectAsignation( $Session->id_proyect );
				$source = ( isset($_POST['source']) && $_POST['source'] != "" ) ? $_POST['source'] 	: "";
				$state = ( is_numeric( $_POST['state'] ) ? $_POST['state'] : 0 );
				
				switch ( $source )
				{
					case 'user': 			$resp = $asign->asign_user_all( $state ); break;
					case 'product': 		$resp = $asign->asign_product_all( $state ); break;
					case 'pdv':				$resp = $asign->asign_pdv_all( $state ); break;
					case 'evidence_type':	$resp = $asign->asign_evidence_type_all( $state ); break; 
					case 'task_omition':	$resp = $asign->asign_task_omition_all( $state ); break;
					case 'visit_omition':	$resp = $asign->asign_visit_omition_all( $state ); break; 
					default:
						$resp = FALSE;
						$response['error'] = "Invalid source"; 
						break;
				}
				
				if ( !$resp )
				{
					$response['error'] = $asign->get_errors(); 
				}
				else
				{ 
					$response['success'] = TRUE;
				}
			}
			else
			{
				$response['error'] = "Bad Parameters.";
			}
		}
		else
		{
			$response['error'] = "Invalid proyect.";
		} 
	break;
		
	case 'activate_record':
		if ( $Session->id_proyect > 0 )
		{
			$asign = new ProyectAsignation( $Session->id_proyect ); 
			
			$source = ( isset($_POST['source']) && $_POST['source'] != "" ) ? $_POST['source'] 	: "";
			$value	= ( isset($_POST['value']) 	&& $_POST['value']	== "false" ) ? FALSE 	: TRUE;
			$id		= ( isset($_POST['id']) 	&& $_POST['id'] 	!= "" ) ? $_POST['id']  	: "";
			
			switch ( $source ) {
				case 'user': 	$resp = $asign->active_user( $id, $value ); 	break;
				case 'product': $resp = $asign->active_product( $id, $value ); 	break;
				case 'pdv': $resp = $asign->active_pdv( $id, $value ); 	break; 
				default:
					$resp = FALSE;
					$response['error'] = "Invalid source"; 
					break;
			} 
			if ( !$resp ){
				$response['error'] = $asign->get_errors(); 
			} else { 
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid proyect.";
		} 
	break;
	
	case 'activate_records':
		if ( $Session->id_proyect > 0 )
		{
			$asign = new ProyectAsignation( $Session->id_proyect );
			
			$source = ( isset($_POST['source']) && $_POST['source'] != "" ) ? $_POST['source'] 	: "";
			$state	= ( isset($_POST['state']) 	&& $_POST['state']	== "false" ) ? FALSE : TRUE;
			$ids	= ( isset($_POST['ids']) 	&& $_POST['ids'] 	!= "" ) ? explode(';', $_POST['ids'] ) : "";
			
			switch ( $source )
			{
				case 'user':
					foreach($ids as $id)
					{
						$resp = $asign->active_user( $id, $state );
					}
				break;
				
				case 'product':
					foreach($ids as $id)
					{
						$resp = $asign->active_product( $id, $state );
					}
				break;
				
				case 'pdv':
					foreach($ids as $id)
					{
						$resp = $asign->active_pdv( $id, $state );
					}
				break; 
				
				default:
					$resp = FALSE;
					$response['error'] = "Invalid source"; 
					break;
			}
			
			if ( !$resp )
			{
				$response['error'] = $asign->get_errors(); 
			}
			else
			{ 
				$response['success'] = TRUE;
			}
		}
		else
		{
			$response['error'] = "Invalid proyect.";
		} 
	break;
	
	case 'activate_all':
		if ( $Session->id_proyect > 0 )
		{
			if( isset($_POST['state']) && is_numeric($_POST['state']) )
			{
				$asign = new ProyectAsignation( $Session->id_proyect );
				$source = ( isset($_POST['source']) && $_POST['source'] != "" ) ? $_POST['source'] 	: "";
				$state = ( is_numeric( $_POST['state'] ) ? $_POST['state'] : 0 );
				
				switch ( $source )
				{
					case 'user':
						$resp = $asign->activate_user_all( $state );
					break;
					
					case 'product':
						$resp = $asign->activate_product_all( $state );
					break;
					
					case 'pdv':
						$resp = $asign->activate_pdv_all( $state );
					break;
					
					default:
						$resp = FALSE;
						$response['error'] = "Invalid source"; 
						break;
				}
				
				if ( !$resp )
				{
					$response['error'] = $asign->get_errors(); 
				}
				else
				{ 
					$response['success'] = TRUE;
				}
			}
			else
			{
				$response['error'] = "Bad Parameters.";
			}
		}
		else
		{
			$response['error'] = "Invalid proyect.";
		} 
	break;
		
	default:
		$response['error'] = "Invalid action.";
			break;
}
?>