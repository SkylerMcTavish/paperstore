<?php

  /**
   * Order CLass
   * 
   * @package		SF·Tracker 			
   * @since        18/01/2015
   * 
   */
  class Order extends Object
  {

      public $id_order;
      public $id_pdv;
      public $id_user;
      //public $id_visit;

      public $pdv;
      public $user;

      /*
        public $id_supplier;
        public $id_branch;
        public $supplier;
        public $branch;
        public $client_code;
        public $agent_number;
        public $confirmation_code;
       */
      public $date;
      public $detail = array();
      public $total;
      public $subtotal;
      public $tax;
      public $folio;
      public $id_order_status = 0;
      public $status;
      public $timestamp;

      /**
       * Order()    
       * Creates a User object from the DB.
       *  
       * @param	$id_order (optional) If set populates values from DB record. 
       * 
       */
      function __construct($id_order = 0)
      {
          $this->class = 'Order';
          $this->error = array();
          $this->clean();
          if ($id_order > 0)
          {
              global $obj_bd;

              $query = "SELECT "
                      . " o.id_order, p.id_pdv, u.id_user, o.or_date, o.or_folio, "
                      . " u.us_user, p.pdv_name, "
                      . " os.os_order_status "
                      . " FROM " . PFX_MAIN_DB . "order o "
                      . " INNER JOIN " . PFX_MAIN_DB . "pdv p ON o.or_pdv_id_pdv = p.id_pdv"
                      . " INNER JOIN " . PFX_MAIN_DB . "user u ON o.or_us_id_user = u.id_user  "
                      . " INNER JOIN " . PFX_MAIN_DB . "order_status os ON o.or_os_id_order_status=os.id_order_status"
                      . " WHERE o.id_order = :id_order ";



              $info = $obj_bd->query($query, array(':id_order' => $id_order));
              if ($info !== FALSE)
              {
                  if (count($info) > 0)
                  {

                      $or = $info[0];
                      $this->id_order = $or['id_order'];
                      $this->id_pdv = $or['id_pdv'];
                      $this->id_user = $or['id_user'];
                      //$this->id_visit = $or['or_vi_id_visit']; 
                      $this->pdv = $or['pdv_name'];
                      $this->user = $or['us_user'];
                      $this->folio = $or['or_folio'] != '' ? $or['or_folio'] : $this->id_order;

                      $this->date = $or['or_date'];
                      $this->total = 0;
                      $this->subtotal = 0;
                      $this->tax = 0;

                      $this->status = $or['os_order_status'];
                      $this->timestamp = $or['or_timestamp'];

                      $this->set_order_detail();
                  }
                  else
                  {
                      $this->set_error("Order not found (" . $id_order . "). ", ERR_DB_NOT_FOUND, 2);
                  }
              }
              else
              {
                  $this->set_error("An error ocurred while querying the Data Base for Order (" . $id_order . ") information. ", ERR_DB_QRY, 2);
              }
          }
      }

      /**
       * set_order_detail()
       * populates order detail array 
       * 
       */
      private function set_order_detail()
      {
          $this->detail = array();
          if ($this->id_order > 0)
          {
              global $obj_bd;
              $query = " SELECT  "
                      . " id_order_detail, id_product, pd_product, id_product_presentation, pp_product_presentation, od_quantity, od_price "
                      . " FROM " . PFX_MAIN_DB . "order_detail "
                      . " INNER JOIN " . PFX_MAIN_DB . "product ON id_product = od_pd_id_product "
                      . "  LEFT JOIN " . PFX_MAIN_DB . "product_presentation ON id_product_presentation = od_pp_id_product_presentation "
                      . " WHERE od_or_id_order = :id_order ORDER BY id_order_detail ASC ";
              $result = $obj_bd->query($query, array(':id_order' => $this->id_order));
              if ($result !== FALSE)
              {
                  if (count($result) > 0)
                  {
                      foreach ($result as $k => $tk)
                      {
                          $detail = new stdClass;
                          $detail->id_order_detail = $tk['id_order_detail'];
                          $detail->id_product = $tk['id_product'];
                          $detail->product = $tk['pd_product'];
                          $detail->quantity = $tk['od_quantity'];
                          $detail->price = $tk['od_price'];
                          $detail->tax = 0.15;
                          $detail->id_product_presentation = $tk['id_product_presentation'];
                          $detail->product_presentation = $tk['pp_product_presentation'];

                          $this->subtotal = $this->subtotal + ($detail->quantity * $detail->price);
                          $this->detail[] = $detail;
                      }

                      $this->tax = $this->subtotal * 0.15;
                      $this->total = $this->subtotal * 1.15;
                  }
                  else
                  {
                      $this->set_error("No detail found for Order (" . $this->id_order . "). ", ERR_DB_NOT_FOUND, 2);
                  }
              }
              else
              {
                  $this->set_error("An error ocurred while querying the Data Base for detail for Order (" . $this->id_order . "). ", ERR_DB_QRY, 2);
              }
          }
      }

      /**
       * get_array()
       * returns an Array with order information
       *   
       * @return	$array Array width Order information
       */
      public function get_array()
      {
          $array = array(
               'id_order' => $this->id_order,
               'id_pdv' => $this->id_pdv,
               'id_user' => $this->id_user,
               //'id_supplier'		=>	$this->id_supplier, 
               //'id_branch'			=>	$this->id_branch, 
               'id_visit' => $this->id_visit,
               'pdv' => $this->pdv,
               'user' => $this->user,
               //'supplier'		=>	$this->supplier,
               //'branch'			=>	$this->branch,
               'date' => date('Y-m-d', $this->date),
               'detail' => array(),
               'subtotal' => $this->subtotal,
               'tax' => $this->subtotal * 0.15,
               'total' => $this->subtotal * 1.15
          );
          foreach ($this->detail as $k => $tk)
          {
              $array['detail'][] = $tk;
          }
          return $array;
      }

      /**
       * get_info_html()
       * returns a String of HTML with order information 
       * 
       * @return	$html String html order info template
       */
      public function get_info_html()
      {
          $html = "";
          $order = $this;
          ob_start();
          require_once DIRECTORY_VIEWS . "order/info.order.php";
          $html .= ob_get_contents();
          ob_end_clean();
          return str_replace(array("\n", "\t"), "", $html);
      }

      /**
       * clean()    
       * Cleans all parameters and resets all objects
       *  
       */
      public function clean()
      {
          $this->id_order = 0;
          $this->id_pdv = 0;
          $this->id_user = 0;
          $this->pdv = "";
          $this->user = "";
          $this->date = "";
          $this->total = 0;
          $this->folio = "";
          $this->id_order_status = 0;
          $this->status = 0;
          $this->timestamp = 0;

          $this->detail = array();

          $this->error = array();
      }

  }

?>