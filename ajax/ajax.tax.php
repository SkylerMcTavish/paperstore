<?php

  global $response, $Session;
  require_once DIRECTORY_CLASS . "class.tax.php";
  switch ($action)
  {

    case 'get_tax_info':
        $id_tax = ( isset($_POST['id_tax']) && is_numeric($_POST['id_tax']) && $_POST['id_tax'] > 0 ) ? $_POST['id_tax'] : 0;
        if ($id_tax > 0)
        {
            $Tax = new Tax($id_tax);
            $response['info'] = $Tax->get_array();
            if (count($Tax->error) > 0)
            {
                $response['error'] = $Tax->get_errors();
            }
            else
            {
                $response['success'] = TRUE;
            }
        }
        else
        {
            $response['error'] = "Invalid tax.";
        }
    break;
    
    case 'delete_tax':
        $id_tax = ( isset($_POST['id_tax']) && is_numeric($_POST['id_tax']) && $_POST['id_tax'] > 0 ) ? $_POST['id_tax'] : 0;
        if ($id_tax > 0)
        {
            $Tax = new Tax($id_tax);
            $Tax->delete();
            if (count($Tax->error) > 0)
            {
                $response['error'] = $Tax->get_errors();
            }
            else
            {
                $response['success'] = TRUE;
            }
        }
        else
        {
            $response['error'] = "Invalid tax.";
        }
    break;
    
    case 'use_tax':
        $id_tax = ( isset($_POST['id_tax']) && is_numeric($_POST['id_tax']) && $_POST['id_tax'] > 0 ) ? $_POST['id_tax'] : 0;
        if ($id_tax > 0)
        {
            $Tax = new Tax($id_tax);
            $Tax->set_default();
            $response['info'] = array( "tax" => $Tax->tax, "hour" => '$ '.number_format($Tax->hour, 2) );
            if (count($Tax->error) > 0)
            {
                $response['error'] = $Tax->get_errors();
            }
            else
            {
                $response['success'] = TRUE;
            }
        }
        else
        {
            $response['error'] = "Invalid tax.";
        }
    break;
    
    default:
        $response['error'] = "Invalid action.";
    break;
  }
?>