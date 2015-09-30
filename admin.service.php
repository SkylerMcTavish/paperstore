<?php

  require_once 'init.php';
  ini_set('display_errors', TRUE);  
  global $Session;
  $action = $_POST['action'];
  $cb = $_POST['cb'];

  switch ($action)
  {
	case 'edit_service':
		if (!$Session->is_admin())
		{
			global $Log;
			$Log->write_log("Restricted attempt to product edition. ", SES_RESTRICTED_ACTION, 3);
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode("Acción restringida."));
			die();
		}
		$command = ( $cb != '' ) ? $cb : ( isset($_POST['products']) ? FRM_SERVICE : LST_SERVICE );
		
		if (!class_exists('AdminService'))
			require_once DIRECTORY_CLASS . "class.admin.service.php";
		if (isset($_POST['id_service']) && is_numeric($_POST['id_service']) && $_POST['id_service'] >= 0)
		{
			$id_service = $_POST['id_service'];
		}
		else
			$id_service = 0;
			
		
		$service = new AdminService($id_service);
		$service->service 	 = ( isset($_POST['service']) && $_POST['service'] != '' ) ? strip_tags($_POST['service']) : '';
		$service->price		 = ( isset($_POST['price']) && is_numeric($_POST['price']) ) ? strip_tags($_POST['price']) : 0;
		$resp = $service->save();
		if ($resp === TRUE)
		{
			header("Location: index.php?command=" . $command . "&msg=" . urlencode("El registro se guardó exitosamente.")."&id_service=".$service->id_service);
		}
		else
		{
			header("Location: index.php?command=" . $command . "&err=" . urlencode($service->get_errors()));
		}
	break;
	
	default:
		$command = ( $cb != '' ) ? $cb : HOME;
		header("Location: index.php?command=" . $command . "&err=" . urlencode("Acción inválida."));
	break;
  }
?>