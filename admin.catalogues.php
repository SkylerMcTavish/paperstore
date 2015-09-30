<?php
require_once 'init.php'; 
global $Session;
if ( $Session->is_admin() ){
	$action = $_POST['action'];
	switch( $action ){
		case 'edit_catalogue_admin':
			$catalogue 	= ( isset( $_POST['catalogue'] ) 		&& $_POST['catalogue'] != '' ) 	? $_POST['catalogue'] 	: '';
			$id 		= ( isset( $_POST['id_catalogue'] ) 	&& $_POST['id_catalogue'] > 0 ) ? $_POST['id_catalogue'] : 0;
			$value	 	= ( isset( $_POST['cat_value'] ) 		&& $_POST['cat_value'] != '' ) 	? $_POST['cat_value'] 	: '';
			$id_parent 	= ( isset( $_POST['cat_id_parent'] )	&& $_POST['cat_id_parent'] != '' ) ? $_POST['cat_id_parent'] 	: 0;
			if ( $catalogue != '' ){
				
				if ( $value == '' ){
					header("Location: index.php?err=" . urlencode( "Valor inválido." ));
				} 
				require_once DIRECTORY_CLASS . "class.admin.catalogue.php";
				$cat = new CatalogueAdmin( $catalogue, $id );
				$cat->value = $value;
				if ( $cat->parent ){
					$cat->id_parent = $id_parent;
				}
				$resp = $cat->save();
				if ( $resp === TRUE ){
					$str_err = "";
					if  ( count( $cat->error) > 0 ){
						$str_err = "&err=" . urlencode( $cat->get_errors() );
					} 
					header("Location: index.php?command=" . ADMIN_CATALOGUE . "&cat=" . $catalogue . "&msg=" . urlencode( "El registro se guardó exitosamente." ) . $str_err );				
				} else { 
					header("Location: index.php?command=" . ADMIN_CATALOGUE . "&cat=" . $catalogue . "&err=" . urlencode( $cat->get_errors() ) ); 
				} 
			} else {
				header("Location: index.php?err=" . urlencode( "Catálogo inválido." ));	
			}
			break;
		default: 
			header("Location: index.php?err=" . urlencode( "Acción inválida." ));
			break;
	}
} else {
	header("Location: index.php?err=" . urlencode( "Acción restringida." ));
}
?>