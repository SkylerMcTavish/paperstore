<?php
/*paperstore*/
  if (!class_exists('Product'))
  {
      require_once 'class.product.php';
  }

  /**
   * AdminProduct CLass
   *
   * @package		SF·Tracker
   * @since        11/25/2014
   *
   */
  class AdminProduct extends Product
  {

      /**
       * __construct()
       * Creates a User object from the DB.
       *
       * @param	$id_product (optional) If set populates values from DB record.
       *
       */
      function __construct($id_product)
      {
          global $Session;
          $this->class = 'AdminProduct';
          if (!$Session->is_admin())
          {
              $this->set_error('Restricted Access', SES_RESTRICTED_ACCESS, 3);
              throw new Exception("Restricted access.", 1);
          }
          parent::__construct($id_product);
          $this->class = 'AdminProduct';
      }

      /**
       * save()
       * Inserts or Update the record in the DB.
       *
       */
      public function save()
      {
          global $Session;
          if ($Session->is_admin())
          {
              if ($this->validate())
              {
                  global $obj_bd;
                  $values = array(
                       ':pd_product'      => $this->product,
                       ':pd_sku'          => $this->sku,
                       ':pd_description'  => $this->description,
                       ':alias'           => $this->alias,
                       ':id_brand'        => $this->id_brand,
                       ':id_category'     => $this->id_category,
                       ':id_supplier'     => $this->id_supplier,
                       ':pd_timestamp'    => time()
                  );
                  if ($this->id_product > 0)
                  {
                      $values[':id_product'] = $this->id_product;
                      $query = " UPDATE " . PFX_MAIN_DB . "product SET "
                              . " pd_product 		            = :pd_product , "
                              . " pd_alias 	    	            = :alias , "
                              . " pd_sku 			            = :pd_sku , "
                              . " pd_description 	            = :pd_description , "
                              . " pd_br_id_brand 	            = :id_brand, "
                              . " pd_pc_id_product_category     = :id_category , "
                              . " pd_sp_id_supplier             = :id_supplier , "
                              . " pd_status	 	                = 1, "
                              . " pd_timestamp 	                = :pd_timestamp "
                              . " WHERE id_product 	= :id_product ";
                  }
                  else
                  {
                      $query =  " INSERT INTO " . PFX_MAIN_DB . "product ".
                                " ( pd_product, pd_alias, pd_sku, pd_description, pd_br_id_brand, pd_pc_id_product_category, ".
                                    " pd_sp_id_supplier, pd_status, pd_timestamp ) ".
                                " VALUES (:pd_product, :alias, :pd_sku, :pd_description, :id_brand, :id_category, :id_supplier, 1, :pd_timestamp ) ";
                  }
                  $result = $obj_bd->execute($query, $values);
                  if ($result !== FALSE)
                  {
                      if ($this->id_product == 0)
                      {
                          $this->id_product = $obj_bd->get_last_id();
                      }
                      //$this->save_price();
                      $this->set_msg('SAVE', " Product " . $this->id_product . " saved. ");
                      //return $this->meta->save_values($this->id_product);
                      return TRUE;
                  }
                  else
                  {
                      $this->set_error("An error ocurred while trying to save the record. " . print_r($obj_bd->error, TRUE), ERR_DB_EXEC, 3);
                      return FALSE;
                  }
              }
              else
              {
                return FALSE;
              }
          }
          else
          {
              $this->set_error("Restricted action.", SES_RESTRICTED_ACTION);
              return FALSE;
          }
      }

      /**
       * save_prices()
       * Saves the product prices info to the DB
       *
       * @return 	TRUE | FALSE
       */
      public function save_price()
      {
          if ($this->id_product > 0)
          {
              if ($this->validate_price($this->price))
              {
                  global $obj_bd;

                  $query = "SELECT pri_pd_id_product "
                          . " FROM " . PFX_MAIN_DB . "price "
                          . " WHERE pri_pd_id_product = :id_product "
                          . " AND pri_pp_id_product_presentation = :id_product_presentation ";

                  $resp = $obj_bd->query($query, array(':id_product' => $this->id_product, ':id_product_presentation' => $this->id_product_presentation));


                  if ($resp !== FALSE)
                  {
                      if (count($resp) > 0)
                      {
                          $query = "UPDATE " . PFX_MAIN_DB . "price SET "
                                  . " pri_price	= :price, "
                                  . " pri_units	= :units "
                                  . " WHERE pri_pd_id_product = :id_product "
                                  . " AND pri_pp_id_product_presentation = :id_product_presentation ";
                      }
                      else
                      {
                          $query = "INSERT INTO " . PFX_MAIN_DB . "price "
                                  . " ( pri_pd_id_product, pri_pp_id_product_presentation, pri_price, pri_units ) "
                                  . " VALUES ( :id_product, :id_product_presentation, :price, :units ) ";
                      }

                      $values = array(
                           ':id_product' => $this->id_product,
                           ':id_product_presentation' => $this->id_product_presentation,
                           ':price' => $this->price,
                           ':units' => $this->units
                      );
                     

                      $resp = $obj_bd->execute($query, $values);

                      if (!$resp)
                      {
                          $this->set_error(' An error occurred while saving Product Price information ', ERR_DB_EXEC, 3);
                          return FALSE;
                      }
                      else
                      {
                          $this->set_msg('SAVE', " Product " . $this->id_product . " price information saved. ");
                          //$this->set_prices();
                          return TRUE;
                      }
                  }
                  else
                  {
                      $this->set_error(" An error occured while querying for the price", ERR_DB_QRY);
                      return FALSE;
                  }
              }
              else
              { //Validation
                  return FALSE;
              }
          }
      }

      /**
       * save_supplier_code()
       * Saves the product schdeule info to the DB
       *
       * @return 	TRUE | FALSE
       */
      public function save_supplier_code($code)
      {
          if ($this->id_product > 0)
          {
              if ($this->validate_supplier_code($code))
              {
                  global $obj_bd;
                  $query = "SELECT sc_code FROM " . PFX_MAIN_DB . "supplier_code "
                          . " WHERE sc_pd_id_product = :id_product AND sc_su_id_supplier = :id_supplier ";
                  $resp = $obj_bd->query($query, array(':id_product' => $this->id_product, ':id_supplier' => $code->id_supplier));
                  if ($resp !== FALSE)
                  {
                      if (count($resp) > 0)
                      {
                          $query = "UPDATE " . PFX_MAIN_DB . "supplier_code SET "
                                  . " sc_code	= :code "
                                  . " WHERE sc_pd_id_product = :id_product AND sc_su_id_supplier = :id_supplier ";
                      }
                      else
                      {
                          $query = "INSERT INTO " . PFX_MAIN_DB . "supplier_code ( sc_pd_id_product, sc_su_id_supplier, sc_code ) "
                                  . " VALUES ( :id_product, :id_supplier, :code ) ";
                      }
                      $values = array(
                           ':id_product' => $this->id_product,
                           ':id_supplier' => $code->id_supplier,
                           ':code' => $code->code
                      );
                      $resp = $obj_bd->execute($query, $values);
                      if (!$resp)
                      {
                          $this->set_error(' An error occurred while saving Product Supplier Code information ', ERR_DB_EXEC, 3);
                          return FALSE;
                      }
                      else
                      {
                          $this->set_msg('SAVE', " Product " . $this->id_product . " Supplier Code information saved. ");
                          $this->set_supplier_codes();
                          return TRUE;
                      }
                  }
                  else
                  {
                      $this->set_error(" An error occured while querying for the Supplier Code", ERR_DB_QRY);
                      return FALSE;
                  }
              }
              else
              { //Validation
                  return FALSE;
              }
          }
      }

      /**
       * validate()
       * Validates the values before inputing to Data Base
       *
       * @return        Boolean TRUE if valid; FALSE if invalid
       */
      public function validate()
      {
          global $Validate;
          if (!$this->product != '')
          {
              $this->set_error('Product value empty. ', ERR_VAL_EMPTY);
              return FALSE;
          }
          if (!$this->alias != '')
          {
              $this->set_error('Alias value empty. ', ERR_VAL_EMPTY);
              return FALSE;
          }
          if (!$this->sku != '')
          {
              $this->set_error('SKU value empty. ', ERR_VAL_EMPTY);
              return FALSE;
          }
          if (!is_numeric($this->id_brand) || !( $this->id_brand > 0 ))
          {
              $this->set_error('Invalid Brand value. ', ERR_VAL_INVALID);
              return FALSE;
          }
          
          if (!is_numeric($this->id_category) || !( $this->id_category > 0 ))
          {
              $this->set_error('Invalid Category value. ', ERR_VAL_INVALID);
              return FALSE;
          }
          
          if (!is_numeric($this->id_supplier) || !( $this->id_supplier > 0 ))
          {
              $this->set_error('Invalid Supplier value. ', ERR_VAL_INVALID);
              return FALSE;
          }
          return TRUE;
      }

      /**
       * validate_price()
       * Validates the values before inputing to Data Base
       *
       * @return        Boolean TRUE if valid; FALSE if invalid
       */
      public function validate_price()
      {
          global $Validate;
          if (!is_numeric($this->price) || !($this->price > 0))
          {
              $this->set_error(' Price: Invalid Price. ', ERR_VAL_INVALID);
              return FALSE;
          }
          if (!is_numeric($this->units) || !($this->units > 0))
          {
              $this->set_error(' Price: Invalid Units. ', ERR_VAL_INVALID);
              return FALSE;
          }
          if (!is_numeric($this->id_product_presentation) || !($this->id_product_presentation > 0 ))
          {
              $this->set_error(' Price: Invalid Presentation value. ', ERR_VAL_INVALID);
              return FALSE;
          }
          return TRUE;
      }

      /**
       * validate_supplier_code()
       * Validates the values before inputing to Data Base
       *
       * @return        Boolean TRUE if valid; FALSE if invalid
       */
      public function validate_supplier_code($code)
      {
          global $Validate;
          if (!( $code->code != ''))
          {
              $this->set_error('Supplier Code: Invalid Code. ', ERR_VAL_INVALID);
              return FALSE;
          }
          if (!is_numeric($code->id_supplier) || !( $code->id_supplier > 0 ))
          {
              $this->set_error('Supplier Code: Invalid Supplier . ', ERR_VAL_INVALID);
              return FALSE;
          }
          return TRUE;
      }

      /**
       * delete()
       * Changes status for Product to 0 in the DB.
       *
       * @return 	TRUE on success; FALSE otherwise
       */
      public function delete()
      {
          global $Session;
          if ($Session->is_admin())
          {
              global $obj_bd;
              $query = " UPDATE " . PFX_MAIN_DB . "product SET pd_status = 0 WHERE id_product = :id_product ";
              $result = $obj_bd->execute($query, array(':id_product' => $this->id_product));
              if ($result !== FALSE)
              {
                  $this->clean();
                  return TRUE;
              }
              else
              {
                  $this->set_error("An error ocurred while trying to set status to 0. ", ERR_DB_EXEC, 3);
                  return FALSE;
              }
          }
      }

      /**
       * delete_price()
       * Deletes Price record from the DB.
       *
       * @param	$id_pp  ID of the product presentation
       *
       * @return 	TRUE on success; FALSE otherwise
       */
      public function delete_price($id_pp)
      { //product presentation
          global $Session;
          if ($Session->is_admin())
          {
              global $obj_bd;
              $query = " DELETE FROM " . PFX_MAIN_DB . "price WHERE pri_pd_id_product = :id_product AND :pri_pp_id_product_presentation = :id_product_presentation ";
              $result = $obj_bd->execute($query, array(':id_product' => $this->id_product, ':id_product_presentation' => $id_pp));
              if ($result !== FALSE)
              {
                  $this->set_prices();
                  return TRUE;
              }
              else
              {
                  $this->set_error("An error ocurred while trying to delete the Price from the DB. ", ERR_DB_EXEC, 3);
                  return FALSE;
              }
          }
      }

      /**
       * delete_supplier_code()
       * Deletes Supplier Code record from the DB.
       *
       * @param	$id_pp  ID of the product presentation
       *
       * @return 	TRUE on success; FALSE otherwise
       */
      public function delete_supplier_code($id_supplier)
      { //product presentation
          global $Session;
          if ($Session->is_admin())
          {
              global $obj_bd;
              $query = " DELETE FROM " . PFX_MAIN_DB . "supplier_code WHERE sc_pd_id_product = :id_product AND :sc_su_id_supplier  = :id_supplier ";
              $result = $obj_bd->execute($query, array(':id_product' => $this->id_product, ':id_supplier' => $id_supplier));
              if ($result !== FALSE)
              {
                  $this->set_supplier_codes();
                  return TRUE;
              }
              else
              {
                  $this->set_error("An error ocurred while trying to delete the Supplier Code from the DB. ", ERR_DB_EXEC, 3);
                  return FALSE;
              }
          }
      }

  }

?>