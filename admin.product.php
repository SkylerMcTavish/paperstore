<?php

  require_once 'init.php';
  //ini_set('display_errors', TRUE);  
  global $Session;
  $action = $_POST['action'];
  $cb = $_POST['cb'];

  switch ($action)
  {
      case 'edit_brand':
          if (!$Session->is_admin())
          {
              global $Log;
              $Log->write_log("Restricted attempt to brand edition. ", SES_RESTRICTED_ACTION, 3);
              header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode("Acción restringida."));
              die();
          }
          $command = ( $cb != '' ) ? $cb : LST_BAFA;
          if (!class_exists('BAFA'))
              require_once DIRECTORY_CLASS . "class.bafa.php";
          $bafa = new BAFA();

          if (isset($_POST['id_brand']) && is_numeric($_POST['id_brand']) && $_POST['id_brand'] >= 0)
          {
              $id_brand = $_POST['id_brand'];
          }
          else
              $id_brand = 0;

          $brand = new stdClass;
          $brand->id_brand = $id_brand;
          $brand->brand = ( isset($_POST['brand']) && $_POST['brand'] != '' ) ? strip_tags($_POST['brand']) : '';
          $brand->rival = ( isset($_POST['rival']) && $_POST['rival'] >= 0 ) ? strip_tags($_POST['rival']) : 0;
          $resp = $bafa->save_brand($brand);
          if ($resp === TRUE)
          {
              header("Location: index.php?command=" . $command . "&msg=" . urlencode("El registro se guardó exitosamente."));
          }
          else
          {
              header("Location: index.php?command=" . $command . "&err=" . urlencode($bafa->get_errors()));
          }
          break;
      case 'edit_family':
          if (!$Session->is_admin())
          {
              global $Log;
              $Log->write_log("Restricted attempt to family edition. ", SES_RESTRICTED_ACTION, 3);
              header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode("Acción restringida."));
              die();
          }
          $command = ( $cb != '' ) ? $cb : LST_BAFA;
          if (!class_exists('BAFA'))
              require_once DIRECTORY_CLASS . "class.bafa.php";
          $bafa = new BAFA();

          if (isset($_POST['id_family']) && is_numeric($_POST['id_family']) && $_POST['id_family'] >= 0)
          {
              $id_family = $_POST['id_family'] + 0;
          }
          else
              $id_family = 0;

          $family = new stdClass;
          $family->id_family = $id_family;
          $family->id_brand = ( isset($_POST['id_brand']) && is_numeric($_POST['id_brand'])) ? $_POST['id_brand'] + 0 : 0;
          $family->family = ( isset($_POST['family']) && $_POST['family'] != '' ) ? strip_tags($_POST['family']) : '';
          $family->rival = ( isset($_POST['rival']) && $_POST['rival'] >= 0 ) ? strip_tags($_POST['rival']) : 0;
          //var_dump( $family );
          $resp = $bafa->save_family($family);
          if ($resp === TRUE)
          {
              header("Location: index.php?command=" . $command . "&msg=" . urlencode("El registro se guardó exitosamente."));
          }
          else
          {
              header("Location: index.php?command=" . $command . "&err=" . urlencode($bafa->get_errors()));
          }
          break;
      case 'edit_product':
          if (!$Session->is_admin())
          {
              global $Log;
              $Log->write_log("Restricted attempt to product edition. ", SES_RESTRICTED_ACTION, 3);
              header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode("Acción restringida."));
              die();
          }
          $command = ( $cb != '' ) ? $cb : LST_PRODUCT;
          if (!class_exists('AdminProduct'))
              require_once DIRECTORY_CLASS . "class.admin.product.php";
          if (isset($_POST['id_product']) && is_numeric($_POST['id_product']) && $_POST['id_product'] >= 0)
          {
              $id_product = $_POST['id_product'];
          }
          else
              $id_product = 0;
              
              
          $product = new AdminProduct($id_product);
          $product->product = ( isset($_POST['product']) && $_POST['product'] != '' ) ? strip_tags($_POST['product']) : '';
          $product->alias   = ( isset($_POST['alias']) && $_POST['alias'] != '' ) ? strip_tags($_POST['alias']) : '';
          $product->description = ( isset($_POST['description']) && $_POST['description'] != '' ) ? strip_tags($_POST['description']) : '';
          $product->sku = ( isset($_POST['sku']) && $_POST['sku'] != '' ) ? strip_tags($_POST['sku']) : '';
          $product->id_brand = ( isset($_POST['id_brand']) && is_numeric($_POST['id_brand']) ) ? ($_POST['id_brand'] + 0 ) : 0;
          $product->id_category = ( isset($_POST['id_category']) && is_numeric($_POST['id_category']) ) ? ($_POST['id_category'] + 0 ) : 0;
          $product->id_supplier = ( isset($_POST['id_supplier']) && is_numeric($_POST['id_supplier']) ) ? ($_POST['id_supplier'] + 0 ) : 0;
          
          $resp = $product->save();
          if ($resp === TRUE)
          {
              header("Location: index.php?command=" . $command . "&msg=" . urlencode("El registro se guardó exitosamente."));
              /*
                if ( $id_product == 0)
                header("Location: index.php?command=" . FRM_PRODUCT . "&id_pd=" . $product->id_product . "&msg=" . urlencode( "El registro se guardó exitosamente." )   );
                else
                header("Location: index.php?command=" . $command . "&msg=" . urlencode( "El registro se guardó exitosamente." )   );
               * 
               */
          }
          else
          {
              header("Location: index.php?command=" . $command . "&err=" . urlencode($product->get_errors()));
          }
          break;
		case 'upload_products':
            if (!$Session->is_admin())
            {
                global $Log;
                $Log->write_log("Restricted attempt to product load. ", SES_RESTRICTED_ACTION, 3);
                header("Location: index.php?command=" . ERR_403 . "&err=" . urlencode("Acción restringida."));
                die();
            }
            $command = ( $cb != '' ) ? $cb : LST_PRODUCT;
            if (isset($_FILES["csv_products"]) && $_FILES["csv_products"]["name"] != '')
            {
                require_once DIRECTORY_CLASS . 'class.product.loader.php';
                $_product = new ProductLoader;
                $resp = $_product->load_uploaded_file($_FILES["csv_products"]);
                if ($resp == TRUE)
                {
                    header("Location: index.php?command=" . $command . "&msg=" . urlencode("Los productos fueron generadas de manera exitosa."));
                }
                else
                {
                    header("Location: index.php?command=" . $command . "&err=" . urlencode($_product->get_errors()));
                }
            }
            else
            {
                header("Location: index.php?command=" . $command . "&err=" . urlencode("No se detecto nigun archivo csv"));
            }
        break;

      default:
          $command = ( $cb != '' ) ? $cb : HOME;
          header("Location: index.php?command=" . $command . "&err=" . urlencode("Acción inválida."));
          break;
  }
?>