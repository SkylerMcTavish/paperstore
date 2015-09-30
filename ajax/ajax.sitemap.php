<?php 
global $response, $Session; 
require_once DIRECTORY_CLASS . "class.sitemap.php"; 
switch ( $action )
{
	case 'set_sitemap_size': 
		$x = ( isset($_POST['x']) && is_numeric($_POST['x']) && $_POST['x'] > 0 ) ? $_POST['x'] : 1;
		$y = ( isset($_POST['y']) && is_numeric($_POST['y']) && $_POST['y'] > 0 ) ? $_POST['y'] : 1;
		$map = new Sitemap();
		$map->set_size($x, $y);
		$response['html'] = $map->get_layout_html();
		if ( count( $map->error ) > 0 )
		{
			$response['error'] = $map->get_errors(); 
		}
		else
		{
			$response['success'] = TRUE;
		}
	break;
	
	case 'set_computer':
		$site = ( isset($_POST['site']) && is_numeric($_POST['site']) && $_POST['site'] > 0 ) ? $_POST['site'] : 1;
		$status = ( isset($_POST['status']) && is_numeric($_POST['status']) && $_POST['status'] > 0 ) ? $_POST['status'] : 0;
		$computer = ( isset($_POST['computer']) && is_numeric($_POST['computer']) && $_POST['computer'] > 0 ) ? $_POST['computer'] : 0;
		$map = new Sitemap();
		$map->set_sitemap_element($status, $site, $computer);
		$response['html'] = $map->get_layout_html();
		if ( count( $map->error ) > 0 )
		{
			$response['error'] = $map->get_errors(); 
		}
		else
		{
			$response['success'] = TRUE;
		}
	break;
	
	case 'set_leasing':
		$id_computer = ( isset($_POST['id_computer']) && is_numeric($_POST['id_computer']) && $_POST['id_computer'] > 0 ) ? $_POST['id_computer'] : 0;
		require_once DIRECTORY_CLASS . "class.admin.computer.php";
		$Computer = new AdminComputer($id_computer);
		$response['time'] = $Computer->lease();
		
		if( count($Computer->error) > 0 )
		{
			$response['error'] = $Computer->get_errors(); 
		}
		else
		{
			$response['success'] = TRUE;
		}
	break;
	
	case 'set_release':
		$id_computer = ( isset($_POST['id_computer']) && is_numeric($_POST['id_computer']) && $_POST['id_computer'] > 0 ) ? $_POST['id_computer'] : 0;
		require_once DIRECTORY_CLASS . "class.admin.computer.php";
		$Computer = new AdminComputer($id_computer);
		$total = $Computer->release();
		
		if( count($Computer->error) > 0 )
		{
			$response['error'] = $Computer->get_errors(); 
		}
		else
		{
			$response['amount'] = number_format($total, 2);
			$response['success'] = TRUE;
		}
	break;
	
	default:
		$response['error'] = "Invalid action.";
	break;
}
?>