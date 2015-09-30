<?php
require_once 'init.php'; 
if ( $Session->is_admin() ){
	$action = $_POST['action'];
	switch( $action ){
		case 'edit_supplier':
			$id_supplier = $_POST['id_supplier'];
			$su_supplier = $_POST['supplier']; 
		
			if ( $su_supplier != '' ){
				require_once DIRECTORY_CLASS . "class.supplier.php";
				$sup  = new Supplier( $id_supplier );
				$sup->supplier = $su_supplier;
				$sup->id_supplier = $id_supplier; 
				$resp = $sup->save(); 
				if ( $resp === TRUE ){ 
					$str_err = "";
					if  ( count( $sup->error ) > 0 ){
						$str_err = "&err=" . urlencode( $sup->get_errors() );
					} 
					header("Location: index.php?command=" . LST_SUPPLIER .  "&msg=" . urlencode( "El registro se guardó exitosamente." ) . $str_err );				
				} else { 
					header("Location: index.php?command=" . LST_SUPPLIER .  "&err=" . urlencode( $sup->get_errors() ) ); 
				} 
			} else { 
				header("Location: index.php?command=" . LST_SUPPLIER .  "&err=" . urlencode( "No se recibió un nombre de Mayorista válido.") ); 
			} 
			break;
		/* *
		 */
		case 'edit_branch':
			$id_supplier = ( isset( $_POST['id_supplier'] ) && $_POST['id_supplier'] > 0 ) ? $_POST['id_supplier'] : 0;
			$id_branch	 = ( isset( $_POST['id_branch'] ) 	&& $_POST['id_branch'] > 0 ) ? $_POST['id_branch'] : 0; 
			if ( $id_supplier > 0 ){
				require_once DIRECTORY_CLASS . "class.supplier.php";
				$Sup  = new Supplier( $id_supplier );
				
				$name	 = ( isset( $_POST['branch'] ) 	&& $_POST['branch'] != '' ) ? $_POST['branch'] : "";
				$num	 = ( isset( $_POST['number'] ) 	&& $_POST['number'] != '' ) ? $_POST['number'] : "";
				
				if ( $name != '' && $num != '' ){
					$branch = new stdClass;
					$branch->id_branch = $id_branch;
					$branch->branch	= $name;
					$branch->num 	= $num; 
					$resp = $Sup->save_branch( $branch ); 
					if ( $resp === TRUE ){ 
						$str_err = "";
						if  ( count( $Sup->error ) > 0 ){
							$str_err = "&err=" . urlencode( $Sup->get_errors() );
						} 
						header("Location: index.php?command=" . LST_SUPPLIER .  "&msg=" . urlencode( "El registro se guardó exitosamente." ) . $str_err );				
					} else { 
						header("Location: index.php?command=" . LST_SUPPLIER .  "&err=" . urlencode( $Sup->get_errors() ) ); 
					} 
				} else { 
					header("Location: index.php?command=" . LST_SUPPLIER .  "&err=" . urlencode( "No se recibieron los datos necesarios." ) );
				} 
				
			} else { 
				header("Location: index.php?command=" . LST_SUPPLIER .  "&err=" . urlencode( "No se recibió un Mayorista válido." ) ); 
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