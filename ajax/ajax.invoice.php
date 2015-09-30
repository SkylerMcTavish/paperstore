<?php

  global $response, $Session;
  require_once DIRECTORY_CLASS . "class.invoice.php";
  switch ($action)
  {

      case 'get_invoice_info_html':
          $id_invoice = ( isset($_POST['id_invoice']) && is_numeric($_POST['id_invoice']) && $_POST['id_invoice'] > 0 ) ? $_POST['id_invoice'] : 0;

          if ($id_invoice > 0)
          {
              $invoice = new Invoice($id_invoice);
              $response['html'] = $invoice->get_info_html();

              if (count($deposit->error) > 0)
              {
                  $response['error'] = $invoice->get_errors();
              }
              else
              {
                  $response['success'] = TRUE;
              }
          }
          else
          {
              $response['error'] = "Invalid invoice.";
          }
          break;

      default:
          $response['error'] = "Invalid action.";
          break;
  }
?>