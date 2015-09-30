<?php
require_once 'init.php';
//ini_set('display_errors', TRUE);  
global $Session;
$action = $_POST['action'];
$cb	 	= $_POST['cb'];
 
switch( $action ){
	case 'edit_channel':
		if ( !$Session->is_admin() ){
			global $Log;
			$Log->write_log( "Restricted attempt to channel edition. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		} 
		$command = ( $cb != '' ) ? $cb : LST_CGF ;
		if ( ! class_exists( 'CGF') )
				require_once DIRECTORY_CLASS . "class.cgf.php";
		$cgf = new CGF();
		
		if ( isset( $_POST['id_channel'] ) && is_numeric($_POST['id_channel']) && $_POST['id_channel'] >= 0 ){
			$id_channel = $_POST['id_channel'];  
		} else  $id_channel = 0;
		
		$channel = new stdClass;
		$channel->id_channel= $id_channel;
		$channel->channel 	=  ( isset($_POST['channel'])	&& $_POST['channel'] != '' ) ? strip_tags($_POST['channel']) : ''; 
		$resp = $cgf->save_channel( $channel ); 
		if ( $resp === TRUE ){  
			header("Location: index.php?command=" . $command . "&msg=" . urlencode( "El registro se guardó exitosamente." ) );				
		} else { 
			header("Location: index.php?command=" . $command . "&err=" . urlencode( $cgf->get_errors() ) ); 
		} 
		break;
	case 'edit_group':
		if ( !$Session->is_admin() ){
			global $Log;
			$Log->write_log( "Restricted attempt to group edition. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		} 
		$command = ( $cb != '' ) ? $cb : LST_CGF ;
		if ( ! class_exists( 'CGF') ) 
			require_once DIRECTORY_CLASS . "class.cgf.php";
		$cgf = new CGF();
		
		if ( isset( $_POST['id_group'] ) && is_numeric($_POST['id_group']) && $_POST['id_group'] >= 0 ){
			$id_group = $_POST['id_group'];  
		} else  $id_group = 0;
		
		$group = new stdClass;
		$group->id_group	= $id_group;
		$group->id_channel	= ( isset($_POST['id_channel'])	&& is_numeric($_POST['id_channel'])) 	? $_POST['id_channel'] + 0		: 0;
		$group->group 		= ( isset($_POST['group'])		&& 		$_POST['group'] != '' 		) 	? strip_tags($_POST['group']) 	: '';
		
		$resp = $cgf->save_group( $group ); 
		if ( $resp === TRUE ){  
			header("Location: index.php?command=" . $command . "&msg=" . urlencode( "El registro se guardó exitosamente." ) );				
		} else { 
			header("Location: index.php?command=" . $command . "&err=" . urlencode( $cgf->get_errors() ) ); 
		} 
		break;
	case 'edit_format':
		if ( !$Session->is_admin() ){
			global $Log;
			$Log->write_log( "Restricted attempt to format edition. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		} 
		$command = ( $cb != '' ) ? $cb : LST_CGF ;
		if ( ! class_exists( 'CGF') ) 
			require_once DIRECTORY_CLASS . "class.cgf.php";
		$cgf = new CGF();
		
		if ( isset( $_POST['id_format'] ) && is_numeric($_POST['id_format']) && $_POST['id_format'] >= 0 ){
			$id_format = $_POST['id_format'] + 0;  
		} else  $id_format = 0;
		
		$format = new stdClass;
		$format->id_format	= $id_format;
		$format->id_group	= ( isset($_POST['id_group'])	&& is_numeric($_POST['id_group'])) 	? $_POST['id_group'] + 0		: 0;
		$format->format 	= ( isset($_POST['format'])		&& 		$_POST['format'] != '' 	) 	? strip_tags($_POST['format']) 	: '';
		//var_dump( $format );
		$resp = $cgf->save_format( $format ); 
		if ( $resp === TRUE ){  
			header("Location: index.php?command=" . $command . "&msg=" . urlencode( "El registro se guardó exitosamente." ) );				
		} else { 
			header("Location: index.php?command=" . $command . "&err=" . urlencode( $cgf->get_errors() ) ); 
		} 
		break;
		
	case 'edit_pdv':
		ini_set('display_errors', TRUE);
		if ( !$Session->is_admin() ){
			global $Log;
			$Log->write_log( "Restricted attempt to pdv edition. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		} 
		$command = ( $cb != '' ) ? $cb : LST_PDV ;
		if ( ! class_exists( 'AdminPDV') )
				require_once DIRECTORY_CLASS . "class.admin.pdv.php";
		
		if ( isset( $_POST['id_pdv'] ) && is_numeric($_POST['id_pdv']) && $_POST['id_pdv'] >= 0 ){
			$id_pdv = $_POST['id_pdv'];  
		} else  $id_pdv = 0;
		$pdv = new AdminPDV( $id_pdv );  
		/* Base information */
		$pdv->name 		 	= ( isset($_POST['name']) 	  		&& $_POST['name'] != '' 			) 	? strip_tags($_POST['name']) 		: '';
		$pdv->id_pdv_type 	= ( isset($_POST['id_pdv_type'])	&& is_numeric($_POST['id_pdv_type'])) 	? ($_POST['id_pdv_type'] + 0 )		: 0;
		$pdv->id_format 	= ( isset($_POST['id_format'])		&& is_numeric($_POST['id_format'])	)	? ($_POST['id_format'] + 0 )		: 0;
		$pdv->id_viamente	= ( isset($_POST['id_viamente']) 	&& $_POST['id_viamente'] != ''		)	? strip_tags($_POST['id_viamente']) : '';
		$pdv->zone 		 	= ( isset($_POST['zone']) 	  		&& $_POST['zone'] != '' 			) 	? strip_tags($_POST['zone']) 		: ''; 
		$pdv->latitude 		= ( isset($_POST['latitude']) 		&& is_numeric($_POST['latitude'])) 		? ($_POST['latitude'] + 0) 			: 0;
		$pdv->longitude 	= ( isset($_POST['longitude']) 	  	&& is_numeric($_POST['longitude'])) 	? ($_POST['longitude'] + 0) 		: 0;
		
		/* Address information */
		$pdv->address->street		= ( isset($_POST['street'])			&& $_POST['street'] != ''			)	? strip_tags($_POST['street']) 		: '';
		$pdv->address->ext_num		= ( isset($_POST['ext_num']) 		&& $_POST['ext_num'] != ''			)	? strip_tags($_POST['ext_num']) 	: '';
		$pdv->address->int_num	 	= ( isset($_POST['int_num'])  		&& $_POST['int_num'] != '' 			) 	? strip_tags($_POST['int_num']) 	: ''; 
		$pdv->address->locality		= ( isset($_POST['locality'])   	&& $_POST['locality'] != '' 		)	? strip_tags($_POST['locality']) 	: '';
		$pdv->address->district 	= ( isset($_POST['district']) 		&& $_POST['district'] != '' 		) 	? strip_tags($_POST['district']) 	: '';
		$pdv->address->city			= ( isset($_POST['city']) 			&& $_POST['city'] != ''				)	? strip_tags($_POST['city']) 		: '';
		$pdv->address->brick	 	= ( isset($_POST['brick'])  		&& $_POST['brick'] != '' 			) 	? strip_tags($_POST['brick']) 		: ''; 
		$pdv->address->zipcode		= ( isset($_POST['zipcode']) 		&& is_numeric($_POST['zipcode'])	)	? ($_POST['zipcode'] + 0) 			: 0;
		$pdv->address->id_state 	= ( isset($_POST['id_state']) 		&& is_numeric($_POST['id_state'])	)	? ($_POST['id_state'] + 0) 			: 0; 
		
		/* Contact information */
		$pdv->contact->business_name= ( isset($_POST['business_name'])	&& $_POST['business_name'] != ''	)	? strip_tags($_POST['business_name']) : '';
		$pdv->contact->rfc			= ( isset($_POST['rfc']) 			&& $_POST['rfc'] != ''				)	? strip_tags($_POST['rfc']) 		: '';
		$pdv->contact->phone_1	 	= ( isset($_POST['phone_1'])  		&& $_POST['phone_1'] != '' 			) 	? strip_tags($_POST['phone_1']) 	: ''; 
		$pdv->contact->phone_2		= ( isset($_POST['phone_2'])   		&& $_POST['phone_2'] != '' 			) 	? strip_tags($_POST['phone_2']) 	: '';
		$pdv->contact->email	 	= ( isset($_POST['email']) 	  		&& $_POST['email'] != '' 			) 	? strip_tags($_POST['email']) 		: '';
		
		/* Schedule information */
		$pdv->schedule->id_frequency= ( isset($_POST['id_frequency']) 	&& is_numeric($_POST['id_frequency'])) 	? ($_POST['id_frequency']) 	: 0;
		$pdv->schedule->schedule_from=( isset($_POST['schedule_from']) 	&& is_numeric($_POST['schedule_from'])) ? ($_POST['schedule_from'])	: 0;
		$pdv->schedule->schedule_to	= ( isset($_POST['schedule_to']) 	&& is_numeric($_POST['schedule_to'])) 	? ($_POST['schedule_to']) 	: 0; 
		$pdv->schedule->weekdays	= ( isset($_POST['weekdays']) 	  	&& is_array($_POST['weekdays'])) 		? ($_POST['weekdays']) 		: array(); 
		$pdv->schedule->weekdays_str = implode(";",$pdv->schedule->weekdays); 
		  
		foreach ($pdv->meta->options as $k => $option) {
			$id 	= $option->id_option;
			$idx 	= "pdv_option_" . $id;
			$pdv->meta->options[$k]->value = ( isset($_POST[$idx]) && $_POST[$idx] != '' )? strip_tags($_POST[$idx]) : '';
		}
		$resp = $pdv->save(); 
		  
		if ( $resp === TRUE ){ 
			header("Location: index.php?command=" . $command . "&msg=" . urlencode( "El registro se guardó exitosamente." )   );
		} else {  
			header("Location: index.php?command=" . $command . "&err=" . urlencode( $pdv->get_errors() ) ); 
		}  
		break;
		
	default: 
		$command = ( $cb != '' ) ? $cb : HOME ;
		header("Location: index.php?command=" . $command . "&err=" . urlencode( "Acción inválida." ));
		break;
} 
?>