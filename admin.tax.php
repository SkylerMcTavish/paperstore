<?php

  require_once 'init.php';
//ini_set('display_errors', TRUE);  
  global $Session;
  $action = $_POST['action'];
  $cb = $_POST['cb'];

  switch ($action)
  {
	case 'edit_tax':
		if (!$Session->is_admin())
		{
			global $Log;
			$Log->write_log("Restricted attempt to brand edition. ", SES_RESTRICTED_ACTION, 3);
			header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode("Acción restringida."));
			die();
		}
		$command = ( $cb != '' ) ? $cb : FRM_TAXES;
		if (!class_exists('Tax'))
			require_once DIRECTORY_CLASS . "class.tax.php";
	   
		
		if (isset($_POST['id_tax']) && is_numeric($_POST['id_tax']) && $_POST['id_tax'] >= 0)
		{
			$id_tax = $_POST['id_tax'];
		}
		else
			$id_tax = 0;
		
		$tax = new Tax($id_tax);
		$tax->tax = ( isset($_POST['tax']) && $_POST['tax'] != '' ) ? strip_tags($_POST['tax']) : '';
		$tax->hour = ( isset($_POST['hour']) && $_POST['hour'] >= 0 ) ? strip_tags($_POST['hour']) : 0;
		$type = ( isset($_POST['type']) && $_POST['type'] >= 0 ) ? strip_tags($_POST['type']) : 0;
		
		$tax->id_type = $type;
		
		switch($type)
		{
			case 2:
				$tax->fraction = ( isset($_POST['fraction']) && $_POST['fraction'] >= 0 ) ? strip_tags($_POST['fraction']) : 0;
			break;
			
			case 3:
				$tax->f_half = ( isset($_POST['first_half']) && $_POST['first_half'] >= 0 ) ? strip_tags($_POST['first_half']) : 0;
				$tax->s_half = ( isset($_POST['second_half']) && $_POST['second_half'] >= 0 ) ? strip_tags($_POST['second_half']) : 0;
			break;
		}
		
		$resp = $tax->save();
		if ($resp === TRUE)
		{
			header("Location: index.php?command=" . $command . "&msg=" . urlencode("El registro se guardó exitosamente."));
		}
		else
		{
			header("Location: index.php?command=" . $command . "&err=" . urlencode($tax->get_errors()));
		}
		break;
	default:
		$command = ( $cb != '' ) ? $cb : HOME;
		header("Location: index.php?command=" . $command . "&err=" . urlencode("Acción inválida."));
		break;
  }
?>