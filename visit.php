<?php 
/*19/02/14 CS*/
global $Session;
if ( !$Session->is_proyect_admin() || !$Session->is_proyect_admin()){  
	require_once DIRECTORY_VIEWS . "base/403.php";
	die();
} 
require_once DIRECTORY_CLASS . "class.visit.php";
$id_proyect = $Session->get_proyect(); 
if ( !( $id_proyect > 0 ) ){ 
	$error .= "Proyecto inválido.";
	header( "Location:index.php?command=" . LST_PROYECT . "&err=" . urlencode($error) ); 
}
global $Index; 
require_once DIRECTORY_CLASS . "class.admin.proyect.lst.php";
$proyect = new Proyect( $id_proyect ); 
$list = new AdminProyectList( 'lst_pry_form' );

echo "visit.php";
?>

