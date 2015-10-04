<?php

  global $response, $Session;

  require_once DIRECTORY_CLASS . "class.bar.stock.php";
  require_once DIRECTORY_CLASS . "class.warehouse.php";

  switch ($action)
  {

      case 'get_bar_stock_info':
          $id_stock = ( isset($_POST['id_stock']) && is_numeric($_POST['id_stock']) && $_POST['id_stock'] > 0 ) ? $_POST['id_stock'] : 0;
          
          if ($id_stock > 0)
          {
              $stock = new BarStock($id_stock);
              $response['info'] = $stock->get_array();
              if (count($stock->error) > 0)
              {
                  $response['error'] = $stock->get_errors();
              }
              else
              {
                  $response['success'] = TRUE;
              }
          }
          else
          {
              $response['error'] = "Invalid Id Stock.";
          }
      break;
      
      case'get_warehouse_info':
        $id_stock = ( isset($_POST['id_stock']) && is_numeric($_POST['id_stock']) && $_POST['id_stock'] > 0 ) ? $_POST['id_stock'] : 0;
          
          if ($id_stock > 0)
          {
              $stock = new Warehouse($id_stock);
              $response['info'] = $stock->get_array();
              if (count($stock->error) > 0)
              {
                  $response['error'] = $stock->get_errors();
              }
              else
              {
                  $response['success'] = TRUE;
              }
          }
          else
          {
              $response['error'] = "Invalid Id Stock.";
          }
      break;
    
      case 'get_supply_list_html':
          $stock = new BarStock(0);
          $stock->generate_supply_list();
          $response['html'] = $stock->supply_list_html();
          if (count($stock->error) > 0)
          {
              $response['error'] = $stock->get_errors();
          }
          else
          {
              $response['success'] = TRUE;
          }
      break;
      
      default:
          $response['error'] = "Invalid action.";
      break;
  }
?>