<?php

  require_once 'init.php';
  global $Session;
  $action = $_POST['action'];
  $cb = $_POST['cb'];

  switch ($action)
  {
	case 'edit_computer':
		if (!$Session->is_admin())
		{
			global $Log;
			$Log->write_log("Restricted attempt to computer edition. ", SES_RESTRICTED_ACTION, 3);
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode("Acción restringida."));
			die();
		}
		$command = ( $cb != '' ) ? $cb : LST_COMPUTER;
		if (!class_exists('AdminComputer'))
			require_once DIRECTORY_CLASS . "class.admin.computer.php";
		if (isset($_POST['id_computer']) && is_numeric($_POST['id_computer']) && $_POST['id_computer'] >= 0)
		{
			$id_computer = $_POST['id_computer'];
		}
		else
			$id_computer = 0;
			
			
		$computer = new AdminComputer($id_computer);
		$computer->computer = ( isset($_POST['computer']) && $_POST['computer'] != '' ) ? strip_tags($_POST['computer']) : '';
		$computer->id_type 	= ( isset($_POST['id_type']) && is_numeric($_POST['id_type']) ) ? ($_POST['id_type'] + 0 ) : 0;
		$computer->brand	= ( isset($_POST['brand']) && $_POST['brand'] != '' ) ? strip_tags($_POST['brand']) : '';
		$computer->model	= ( isset($_POST['model']) && $_POST['model'] != '' ) ? strip_tags($_POST['model']) : '';
		$computer->serial	= ( isset($_POST['serial']) && $_POST['serial'] != '' ) ? strip_tags($_POST['serial']) : '';
		$computer->so		= ( isset($_POST['so']) && $_POST['so'] != '' ) ? strip_tags($_POST['so']) : '';
		
		$resp = $computer->save();
		if ($resp === TRUE)
		{
			header("Location: index.php?command=" . $command . "&msg=" . urlencode("El registro se guardó exitosamente."));
		}
		else
		{
			header("Location: index.php?command=" . $command . "&err=" . urlencode($product->get_errors()));
		}
		break;
		
	default:
		$command = ( $cb != '' ) ? $cb : HOME;
		header("Location: index.php?command=" . $command . "&err=" . urlencode("Acción inválida."));
		break;
  }
?>