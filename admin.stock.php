<?php
require_once 'init.php';
global $Session;
$action = $_POST['action'];
$cb	 	= $_POST['cb'];
 
switch( $action )
{ 
	/**** Bar Stock ****/
	case 'edit_bar_supply': 
		if ( !$Session->is_admin() )
		{
			global $Log;
			$Log->write_log( "Restricted attempt to supply bar stock. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		}
		$command = ( $cb != '' ) ? $cb : LST_BAR_STOCK ; 
		if ( ! class_exists( 'AdminBarStock' ) )
				require_once DIRECTORY_CLASS . "class.admin.bar.stock.php";
		
		if ( isset( $_POST['id_bar_supply'] ) && is_numeric($_POST['id_bar_supply']) && $_POST['id_bar_supply'] >= 0 ){
			$id_stock = $_POST['id_bar_supply'];  
		} 
		else
			$id_stock = 0;
		$stock = new AdminBarStock( $id_stock ); 
		
		$stock->id_product 	= ( isset($_POST['id_product'])	&& is_numeric($_POST['id_product'])) ? ($_POST['id_product']) : 0;
		
		$quantity 	= ( isset($_POST['quantity'])	&& is_numeric($_POST['quantity'])) ? ($_POST['quantity']) : 0;
		$supplied 	= ( isset($_POST['supply'])	&& is_numeric($_POST['supply'])) ? ($_POST['supply']) : 0;
		$stock->quantity = $quantity + $supplied;
		
		$stock->min 	= ( isset($_POST['min'])	&& is_numeric($_POST['min'])) ? ($_POST['min']) : 0;
		//$stock->max 	= ( isset($_POST['max'])	&& is_numeric($_POST['max'])) ? ($_POST['max']) : 0;
		$stock->buy_price = ( isset($_POST['buy_price'])&& is_numeric($_POST['buy_price'])) ? ($_POST['buy_price']) : 0.0;
		
		$stock->sell_price 	= ( isset($_POST['price'])	&& is_numeric($_POST['price'])) ? ($_POST['price']) : 0;
		
		
		$resp = $stock->save(); 
		if ( $resp === TRUE )
		{  
			header("Location: index.php?command=" . $command . "&msg=" . urlencode( "El registro se guardó exitosamente." ) . $str_err );
			
			require_once DIRECTORY_CLASS . "class.admin.supply.php";
			$supply = new AdminSupply(0);
			$supply->id_bar_stock = $stock->id_stock;
			$supply->id_product = $stock->id_product;
			$supply->current = $quantity;
			$supply->supplied = $supplied;
			$supply->save();
		}
		else
		{ 
			header("Location: index.php?command=" . $command . "&err=" . urlencode( $pdv->get_errors() ) ); 
		} 
	break;
	
	case 'edit_warehouse':
		if ( !$Session->is_admin() )
		{
			global $Log;
			$Log->write_log( "Restricted attempt to supply bar stock. ", SES_RESTRICTED_ACTION, 3 );
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode( "Acción restringida." ) );
			die();
		}
		$command = ( $cb != '' ) ? $cb : LST_WAREHOUSE ; 
		if ( ! class_exists( 'AdminWarehouse' ) )
				require_once DIRECTORY_CLASS . "class.admin.warehouse.php";
		
		if ( isset( $_POST['id_warehouse'] ) && is_numeric($_POST['id_warehouse']) && $_POST['id_warehouse'] >= 0 ){
			$id_stock = $_POST['id_warehouse'];  
		} 
		else
			$id_stock = 0;
		$stock = new AdminWarehouse( $id_stock ); 
		
		$stock->id_product 	= ( isset($_POST['id_product'])	&& is_numeric($_POST['id_product'])) ? ($_POST['id_product']) : 0;
		
		$quantity 	= ( isset($_POST['quantity'])	&& is_numeric($_POST['quantity'])) ? ($_POST['quantity']) : 0;
		$supplied 	= ( isset($_POST['supply'])	&& is_numeric($_POST['supply'])) ? ($_POST['supply']) : 0;
		$stock->quantity = $quantity + $supplied;
		
		$stock->min 	= ( isset($_POST['min'])	&& is_numeric($_POST['min'])) ? ($_POST['min']) : 0;
		$stock->max 	= ( isset($_POST['max'])	&& is_numeric($_POST['max'])) ? ($_POST['max']) : 0;
		
		$stock->id_packing 	= ( isset($_POST['id_packing'])	&& is_numeric($_POST['id_packing'])) ? ($_POST['id_packing']) : 0;
		
		
		$resp = $stock->save(); 
		if ( $resp === TRUE )
		{  
			header("Location: index.php?command=" . $command . "&msg=" . urlencode( "El registro se guardó exitosamente." ) . $str_err );				
		}
		else
		{ 
			header("Location: index.php?command=" . $command . "&err=" . urlencode( $pdv->get_errors() ) ); 
		} 
	break;
		
	default: 
		$command = ( $cb != '' ) ? $cb : HOME ;
		header("Location: index.php?command=" . $command . "&err=" . urlencode( "Acción inválida." ));
		break;
}
?>