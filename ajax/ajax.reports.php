<?php

  global $response, $Session;
  require_once DIRECTORY_CLASS . "class.reports.php";
  switch ($action)
  {

    case 'rep.balance.generate_report':
        $id_product = ( isset($_POST['id_product']) && is_numeric($_POST['id_product']) && $_POST['id_product'] > 0 ) ? $_POST['id_product'] : 0;
		$fini = ( isset($_POST['fini']) && is_numeric($_POST['fini']) && $_POST['fini'] > 0 ) ? $_POST['fini'] : 0;
		$ffin = ( isset($_POST['ffin']) && is_numeric($_POST['ffin']) && $_POST['ffin'] > 0 ) ? $_POST['ffin'] : 0;
        
		$data = new stdClass;
		$data->name = 'Balance de Productos';
		$report = new Report($data);
		
    break;    
    default:
        $response['error'] = "Invalid report.";
    break;
  }
?>