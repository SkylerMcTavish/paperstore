<?php

  global $response, $Session;
  require_once DIRECTORY_CLASS . "class.reports.php";
  switch ($action)
  {

    case 'rep.balance.generate_report':
        $id_product = ( isset($_POST['id_product']) && is_numeric($_POST['id_product']) && $_POST['id_product'] > 0 ) ? $_POST['id_product'] : 0;
		$fini = ( isset($_POST['fini']) &&  $_POST['fini'] != '' ) ? strtotime($_POST['fini']) : 0;
		$ffin = ( isset($_POST['ffin']) &&  $_POST['ffin'] != '' ) ? strtotime($_POST['ffin']) : 0;
        
		$data = new stdClass;
		$data->name = 'Balance de Productos';
		$data->tag = 'product_balance';
		$filters = array();
		
		if($id_product > 0)
		{
		  $fil = new stdClass;
		  $fil->filter = 'sp_pd_id_product';
		  $fil->value = $id_product;
		  $fil->mode = '=';
		  $filters[] = $fil;
		}
		if($fini > 0)
		{
		  $fil = new stdClass;
		  $fil->filter = 'sp_timestamp';
		  $fil->value = $fini;
		  $fil->mode = '>=';
		  $filters[] = $fil;
		}
		if($ffin > 0)
		{
		  $fil = new stdClass;
		  $fil->filter = 'sp_timestamp';
		  $fil->value = $ffin;
		  $fil->mode = '<=';
		  $filters[] = $fil;
		}
		
		$data->filters = $filters;
		$report = new Report($data);
		$report->generate_report();
		$response['html'] = $report->get_info_html();
		
		if ( count($report->error) > 0 )
		{
			$response['error'] 	= $report->get_errors(); 
		}
		else
		{
			$response['success'] = TRUE;
		}
		$response['success'] = TRUE;
		
    break;    
    default:
        $response['error'] = "Invalid report.";
    break;
  }
?>