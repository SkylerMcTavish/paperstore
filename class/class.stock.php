<?php

  /**
   * Stock CLass
   *
   * @package		SF·Tracker
   * @since        11/19/2014
   *
   */
  class Stock extends Object
  {

      public $s_id_stock = 0;
      public $s_id_visit = 0;
      public $s_id_product;
      public $s_actual = 0;
      public $s_anaquel = 0;
      public $s_exhibicion = 0;
      public $s_total = 0;
      public $s_precio = 0;
      public $error = array();

      /**
       * save()
       * Inserts or Update the record in the DB.
       *
       */
      public function save()
      {
          global $obj_bd;


          $values = array(
               ':id_visit' => $this->s_id_visit,
               ':id_product' => $this->s_id_product,
               ':current' => $this->s_actual,
               ':shelf' => $this->s_anaquel,
               ':exhibition' => $this->s_exhibicion,
               ':price' => $this->s_precio,
               ':status' => 1,
               ':time' => time()
          );

          $query = "INSERT INTO " . PFX_MAIN_DB . "visit_stock "
                  . " (vsk_vi_id_visit,vsk_pd_id_product,vsk_current,vsk_shelf,vsk_exhibition,vsk_price,vsk_status,vsk_timestamp) "
                  . " VALUES (:id_visit,:id_product,:current,:shelf,:exhibition,:price,:status,:time) ";


          $result = $obj_bd->execute($query, $values);

          if ($result !== FALSE)
          {
              $this->set_msg("SAVE", " Stock " . $obj_bd->get_last_id() . " saved. ");
              return TRUE;
          }
          else
          {
              $this->set_error("An error ocurred while trying to save the record. ", ERR_DB_EXEC, 3);
              return FALSE;
          }
      }

      /**
       * set_order_detail()
       * populates order detail array 
       * 
       */
      public function get_stock_detail()
      {

          if ($this->s_id_visit > 0)
          {
              global $obj_bd;

              $query = " SELECT  "
                      . " vsk_vi_id_visit, id_product, pd_product, vsk_current, vsk_shelf, vsk_exhibition, vsk_price "
                      . " FROM " . PFX_MAIN_DB . "visit_stock "
                      . " INNER JOIN " . PFX_MAIN_DB . "product ON id_product = vsk_pd_id_product "
                      . " WHERE vsk_vi_id_visit = :id_visit ORDER BY vsk_vi_id_visit ASC ";

              $result = $obj_bd->query($query, array(':id_visit' => $this->s_id_visit));

              if ($result !== FALSE)
              {
                  if (count($result) > 0)
                  {
                      $resp = "";

                      foreach ($result as $key => $val)
                      {
                          ob_start();
                          include DIRECTORY_VIEWS . "lists/lst.stock.php";
                          $resp .= ob_get_clean();
                      }

                      return $resp;
                  }
                  else
                  {
                      $this->set_error("No detail found for Visit (" . $this->s_id_visit . "). ", ERR_DB_NOT_FOUND, 2);
                  }
              }
              else
              {
                  $this->set_error("An error ocurred while querying the Data Base for detail for visit (" . $this->s_id_visit . "). ", ERR_DB_QRY, 2);
              }
          }
      }

      public function clean()
      {
          $this->s_id_stock = 0;
          $this->s_id_visit = 0;
          $this->s_id_product;
          $this->s_actual = 0;
          $this->s_anaquel = 0;
          $this->s_exhibicion = 0;
          $this->s_total = 0;
          $this->s_precio = 0;
          $this->error = array();
      }

  }

?>