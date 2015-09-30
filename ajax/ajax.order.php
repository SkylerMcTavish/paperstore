<?php

  global $response, $Session;

  require_once DIRECTORY_CLASS . "class.order.php";

  switch ($action)
  {

      case 'get_order_info_html':
          $id_order = ( isset($_POST['id_order']) && is_numeric($_POST['id_order']) && $_POST['id_order'] > 0 ) ? $_POST['id_order'] : 0;

          if ($id_order > 0)
          {
              $order = new Order($id_order);

              $response['html'] = $order->get_info_html();

              if (count($order->error) > 0)
              {
                  $response['error'] = $order->get_errors();
              }
              else
              {
                  $response['success'] = TRUE;
              }
          }
          else
          {
              $response['error'] = "Invalid product.";
          }
          break;
      default:
          $response['error'] = "Invalid action.";
          break;
  }
?>