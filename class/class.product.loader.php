<?php

    if (!class_exists("Loader"))
    {
        require_once DIRECTORY_CLASS . "class.loader.php";
    }
  
    /**
     * class ProductLoader
     */
    class ProductLoader extends Loader
    {
  
        private $Product;
        private $Wharehouse;
        private $Rack;
        private $brands;
        private $pdvs;
        private $supply;
  
        function __construct()
        {
            if (!class_exists("AdminProduct"))
            {
                require_once DIRECTORY_CLASS . "class.admin.product.php";
            }
            /*
            if (!class_exists("AdminWarehouse"))
            {
                require_once DIRECTORY_CLASS . "class.admin.warehouse.php";
            }
            */
            
            if (!class_exists("AdminBarStock"))
            {
                require_once DIRECTORY_CLASS . "class.admin.bar.stock.php";
            }
            if (!class_exists("AdminSupply"))
            {
                require_once DIRECTORY_CLASS . "class.admin.supply.php";
            }
  
            $this->class = "ProductLoader";
  
            $this->line = 0;
            $this->processed = 0;
            $this->saved = 0;
            $this->users = array();
  
            $this->Product      = new AdminProduct(0);
            //$this->Wharehouse   = new AdminWarehouse(0);
            $this->Rack         = new AdminBarStock(0);
            $this->supply       = new AdminSupply(0);
            
        }
  
        public function load_uploaded_file($file)
        {
            if (!class_exists("FileManager"))
            {
                require_once DIRECTORY_CLASS . "class.file.manager.php";
            }
  
            $fm = new FileManager();
  
            $response = $fm->save_uploaded($file, DIRECTORY_UPLOADS . "product_tmpl_" . date('YmdHis'), 7);
  
            if ($response !== FALSE)
            {
                return $this->process_file($response->location);
            }
            else
            {
                $this->error[] = $fm->error[count($fm->error) - 1];
                return FALSE;
            }
        }
  
        private function process_file($route)
        {
  
            if ($this->open_file($route))
            {
                $line = 0;
                try
                {
                    while (($row = fgetcsv($this->handle, 1000, ",")) !== FALSE)
                    {
                        if ($row[0] != '' && trim($row[0]) != 'Producto' && trim($row[0]) != '')
                        {
                            $resp = $this->process_line($row);
                            $this->processed++;
                            if ($resp)
                                $this->saved++;
                        }
                        $this->line++;
                    }
                    $this->close_file();
                }
                catch (Exception $e)
                {
                    $this->set_error("An error occurred while processing the file (Line " . $line . " ). ".$e, ERR_VAL_INVALID);
                }
            }
            else
                return FALSE;
        }
  
        private function process_line($line)
        {
  
            if (is_array($line))
            {
                /*
                $product            = utf8_encode( trim($line[0]) );
                $cantidad           = trim($line[1]);
                $empaque            = utf8_encode( trim($line[2]) );
                $cant_empaque       = trim($line[3]);
                $costo              = trim($line[4]);
                $supplier           = utf8_encode( trim($line[5]) );
                $precio_publico     = trim($line[6]);
                $bar_stock          = trim($line[7]);
                $categoria          = utf8_encode( trim($line[8]) );
                $marca              = utf8_encode( trim($line[9]) );
                //$bodega             = trim($line[10]);
                */
                
                $product            = utf8_encode( trim($line[0]) );
                $bar_stock          = trim($line[1]);
                $costo              = trim($line[2]);
                $precio_publico     = trim($line[3]);
                $categoria          = utf8_encode( trim($line[4]) );
                $marca              = utf8_encode( trim($line[5]) );
                $supplier           = utf8_encode( trim($line[6]) );
                $minimo              = trim($line[7]);
                
                $alias = $descripcion = $product ;
                $sku = "SKU-".$product;
                
                $id_marca = $this->get_brand_id($marca);
                if (!$id_marca)
                {
                    $this->set_error("Invalid ID Brand ( '$marca' ) on line " . $this->line . ". ", ERR_VAL_INVALID);
                    return FALSE;
                }
                
                $id_supplier = $this->get_supplier_id($supplier);
                if (!$id_supplier)
                {
                    $this->set_error("Invalid ID Supplier ( '$supplier' ) on line " . $this->line . ". ", ERR_VAL_INVALID);
                    return FALSE;
                }
                
                $id_category = $this->get_category_id($categoria);
                if (!$id_category)
                {
                    $this->set_error("Invalid ID Category ( '$categoria' ) on line " . $this->line . ". ", ERR_VAL_INVALID);
                    return FALSE;
                }
                
                $id_empaque = 5;//$this->get_pack_id($empaque, $cant_empaque);
                $id_product = $this->get_product_id($product);
                
                $this->Product->clean();
                
                $this->Product->product         = $product;
                $this->Product->sku             = $sku;
                $this->Product->description     = $descripcion;
                $this->Product->alias           = $alias;
                $this->Product->id_brand        = $id_marca;
                $this->Product->id_category     = $id_category;
                $this->Product->id_supplier     = $id_supplier;
                $this->Product->id_product      = $id_product;
                
                $resp = $this->Product->save();
                if ($resp !== FALSE)
                {
                    $this->set_msg("LOAD", "Product " . $this->Product->id_product . " created successfully. ");
                    $success = TRUE;
                    
                    /*
                    $this->Wharehouse->clean();
                    $this->Wharehouse->id_product = $this->Product->id_product;
                    $this->Wharehouse->id_packing = $id_empaque;
                    $this->Wharehouse->quantity   = $bodega;
                    $this->Wharehouse->min        = ($bodega > 1 ? ($bodega / 2) : $bodega);
                    $this->Wharehouse->max        = ($bodega > 0 ? ($bodega * 2) : 10 );
                    $this->Wharehouse->buy_price  = $costo;
                    */
                    /*                 
                    if( $this->Wharehouse->save() )
                    {
                        $success = $success && TRUE;
                    }
                    else
                    {
                        $this->set_error('Error al guardar en bodega. Producto: ['.$this->Product->id_product.']',ERR_DB_EXEC);
                        $success = $success && FALSE;
                    }
                    */
                    
                    $this->Rack->clean();                    
                    $this->Rack->load_stock_from_product($this->Product->id_product);
                    $current = $this->Rack->quantity;
                    $this->Rack->id_product     = $this->Product->id_product;
                    $this->Rack->quantity       = ( $this->Rack->id_stock > 0 ? $this->Rack->quantity + $bar_stock : $bar_stock);
                    $this->Rack->sell_price     = $precio_publico;
                    $this->Rack->min            = ($minimo  > 0 ? $minimo : 1);//($bar_stock > 1 ? ($bar_stock / 2) : $bar_stock);
                    $this->Rack->max            = ($bar_stock > 0 ? ($bar_stock * 2) : 10);
                    $this->Rack->buy_price      = $costo;
                    $this->Rack->id_product_packing = $id_empaque;
                    
                    if( $this->Rack->save() )
                    {
                        $success = $success && TRUE;
                    }
                    else
                    {
                        $this->set_error('Error al guardar en mostrador. Producto: ['.$this->Product->id_product.']',ERR_DB_EXEC);
                        $success = $success && FALSE;
                    }
                    
                    $this->supply->clean();
                    $this->supply->id_bar_stock = $this->Rack->id_stock;
                    $this->supply->id_product = $this->Product->id_product;
                    $this->supply->current = $current;
                    $this->supply->supplied = $bar_stock;                    
                    $this->supply->save();
                    
                    return $success;
                }
                else
                {
                    return FALSE;
                }
            }
            else
            {
                $this->set_error("Invalid line data (Line " . $this->line . "). ", ERR_VAL_INVALID);
                return FALSE;
            }
        }
        private function get_jde($jde)
        {
            global $Validate;
            if ($jde != '')
            {
                global $obj_bd;
                $query = " SELECT id_product, pd_jde FROM " . PFX_MAIN_DB . "product "
                        . " WHERE pd_jde = :pd_jde AND pd_status =1 "; 
                $result = $obj_bd->query($query, array(':pd_jde' => $jde));
                if ($result !== FALSE)
                {
                    if (count($result) > 0)
                    {
                        $id_product = $result[0]["id_product"];
                        return $id_product;
                    }
                    else
                    {
  
                        return FALSE;
                    }
                }
                else
                {
                    $this->set_error("Database error while querying for product jde '" . $jde . "'. ", ERR_VAL_INVALID);
                    return FALSE;
                }
            }
            else
            {
                $this->set_error("Invalid jde ( '$jde' ) on line " . $this->line . ". ", ERR_VAL_INVALID);
                return FALSE;
            }
        }
  
        private function get_brand_id($brand = '')
        {
            global $Validate;
            if ($brand != '')
            {
                global $obj_bd;
                $query = " SELECT id_brand FROM " . PFX_MAIN_DB . "brand "
                        . " WHERE br_brand = :brand AND br_status = 1  ";
                $result = $obj_bd->query($query, array(':brand' => $brand));
                if ($result !== FALSE)
                {
                    if (count($result) > 0)
                    {
                        $id_brand = $result[0]['id_brand'];
                        if ($Validate->is_integer($id_brand) && $id_brand > 0)
                        {
                            return $id_brand;
                        }
                        else
                        {
                            return FALSE;
                        }
                    }
                    else
                    {
                        $query =    " INSERT INTO ".PFX_MAIN_DB."brand (br_brand, br_status, br_timestamp )".
                                    " VALUES ".
                                    " (:brand, 1, :timestamp) ";
                        $values = array(
                            ":brand"        => $brand,
                            ":timestamp"    => time()
                        );
                        
                        $ins = $obj_bd->execute($query, $values);
                        if($ins !== FALSE)
                        {
                            $id_brand = $obj_bd->get_last_id();
                            return $id_brand;
                        }
                        else
                        {
                            $this->set_error("Database error while querying for brand '" . $brand . "'. ", ERR_VAL_INVALID);
                            return FALSE;
                        }
                    }
                }
                else
                {
                    $this->set_error("Database error while querying for brand '" . $brand . "'. ", ERR_VAL_INVALID);
                    return FALSE;
                }
            }
            else
            {
                $this->set_error("Invalid ID Brand ( '$brand' ) on line " . $this->line . ". ", ERR_VAL_INVALID);
                return FALSE;
            }
        }
        
        private function get_supplier_id($supplier)
        {
            global $Validate;
            if ($supplier != '')
            {
                global $obj_bd;
                $query = " SELECT id_supplier FROM " . PFX_MAIN_DB . "supplier "
                        . " WHERE sp_supplier = :supplier AND sp_status = 1  ";
                $result = $obj_bd->query($query, array(':supplier' => $supplier));
                if ($result !== FALSE)
                {
                    if (count($result) > 0)
                    {
                        $id_supplier = $result[0]['id_supplier'];
                        if ($Validate->is_integer($id_supplier) && $id_supplier > 0)
                        {
                            return $id_supplier;
                        }
                        else
                        {
                            return FALSE;
                        }
                    }
                    else
                    {
                        $query =    " INSERT INTO ".PFX_MAIN_DB."supplier (sp_supplier, sp_status, sp_timestamp )".
                                    " VALUES ".
                                    " (:supplier, 1, :timestamp) ";
                        $values = array(
                            ":supplier"        => $supplier,
                            ":timestamp"        => time()
                        );
                        
                        $ins = $obj_bd->execute($query, $values);
                        if($ins !== FALSE)
                        {
                            $id_supplier = $obj_bd->get_last_id();
                            return $id_supplier;
                        }
                        else
                        {
                            $this->set_error("Database error while querying for supplier '" . $supplier . "'. ", ERR_VAL_INVALID);
                            return FALSE;
                        }
                    }
                }
                else
                {
                    $this->set_error("Database error while querying for supplier '" . $supplier . "'. ", ERR_VAL_INVALID);
                    return FALSE;
                }
            }
            else
            {
                $this->set_error("Invalid ID Supplier ( '$supplier' ) on line " . $this->line . ". ", ERR_VAL_INVALID);
                return FALSE;
            }
        }
        
        private function get_category_id($category)
        {
            global $Validate;
            if ($category != '')
            {
                global $obj_bd;
                $query = " SELECT id_product_category FROM " . PFX_MAIN_DB . "product_category "
                        . " WHERE pc_product_category = :category AND pc_status = 1  ";
                $result = $obj_bd->query($query, array(':category' => $category));
                if ($result !== FALSE)
                {
                    if (count($result) > 0)
                    {
                        $id_category = $result[0]['id_product_category'];
                        if ($Validate->is_integer($id_category) && $id_category > 0)
                        {
                            return $id_category;
                        }
                        else
                        {
                            return FALSE;
                        }
                    }
                    else
                    {
                        $query =    " INSERT INTO ".PFX_MAIN_DB."product_category (pc_product_category, pc_status, pc_timestamp )".
                                    " VALUES ".
                                    " (:category, 1, :timestamp) ";
                        $values = array(
                            ":category"        => $category,
                            ":timestamp"        => time()
                        );
                        
                        $ins = $obj_bd->execute($query, $values);
                        if($ins !== FALSE)
                        {
                            $id_category = $obj_bd->get_last_id();
                            return $id_category;
                        }
                        else
                        {
                            $this->set_error("Database error while querying for category '" . $category . "'. ", ERR_VAL_INVALID);
                            return FALSE;
                        }
                    }
                }
                else
                {
                    $this->set_error("Database error while querying for category '" . $category . "'. ", ERR_VAL_INVALID);
                    return FALSE;
                }
            }
            else
            {
                $this->set_error("Invalid ID Category ( '$category' ) on line " . $this->line . ". ", ERR_VAL_INVALID);
                return FALSE;
            }
        }
        
        private function get_pack_id($pack, $unit)
        {
            global $Validate;
            if ($pack != '')
            {
                global $obj_bd;
                $query = " SELECT id_product_packing FROM " . PFX_MAIN_DB . "product_packing "
                        . " WHERE pp_product_packing = :pack AND pp_unity_quantity = :quantity AND pp_status = 1  ";
                $result = $obj_bd->query($query, array(':pack' => $pack, ":quantity" => $unit));
                if ($result !== FALSE)
                {
                    if (count($result) > 0)
                    {
                        $id_pack = $result[0]['id_product_packing'];
                        if ($Validate->is_integer($id_pack) && $id_pack > 0)
                        {
                            return $id_pack;
                        }
                        else
                        {
                            return FALSE;
                        }
                    }
                    else
                    {
                        $query =    " INSERT INTO ".PFX_MAIN_DB."product_packing (pp_product_packing, pp_unity_quantity, pp_status, pp_timestamp )".
                                    " VALUES ".
                                    " (:pack, :quantity, 1, :timestamp) ";
                        $values = array(
                            ":pack"             => $pack,
                            ":quantity"         => $unit,
                            ":timestamp"        => time()
                        );
                        
                        $ins = $obj_bd->execute($query, $values);
                        if($ins !== FALSE)
                        {
                            $id_pack = $obj_bd->get_last_id();
                            return $id_pack;
                        }
                        else
                        {
                            $this->set_error("Database error while querying for packing '" . $pack . "'. ", ERR_VAL_INVALID);
                            return FALSE;
                        }
                    }
                }
                else
                {
                    $this->set_error("Database error while querying for packing '" . $pack . "'. ", ERR_VAL_INVALID);
                    return FALSE;
                }
            }
            else
            {
                $this->set_error("Invalid ID Packing ( '$pack' ) on line " . $this->line . ". ", ERR_VAL_INVALID);
                return FALSE;
            }
        }
        
        private function get_product_id($product = '')
        {
            global $Validate;
            if ($product != '')
            {
                global $obj_bd;
                $query = " SELECT id_product FROM " . PFX_MAIN_DB . "product "
                        . " WHERE pd_product = :product AND pd_status = 1  ";
                $result = $obj_bd->query($query, array(':product' => $product));
                if ($result !== FALSE)
                {
                    if (count($result) > 0)
                    {
                        $id_product = $result[0]['id_product'];
                        if ($Validate->is_integer($id_product) && $id_product > 0)
                        {
                            return $id_product;
                        }
                        else
                        {
                            return 0;
                        }
                    }
                }
                else
                {
                    $this->set_error("Database error while querying for product '" . $product . "'. ", ERR_VAL_INVALID);
                    return 0;
                }
            }
            else
            {
                $this->set_error("Invalid ID Product ( '$product' ) on line " . $this->line . ". ", ERR_VAL_INVALID);
                return 0;
            }
        }
  
        private function get_user_id($user = '')
        {
            global $Validate;
            if ($user != '' && $Validate->is_email($user))
            {
                if (array_key_exists($user, $this->users))
                {
                    return $this->users[$user];
                }
                else
                {
                    global $obj_bd;
                    $query = " SELECT id_user FROM " . PFX_MAIN_DB . "proyect_user "
                            . " INNER JOIN " . PFX_MAIN_DB . "user ON id_user = pu_us_id_user  "
                            . " WHERE us_user = :us_user AND pu_pr_id_proyect = :id_proyect AND pu_active = 1  ";
                    $result = $obj_bd->query($query, array(':us_user' => $user, ':id_proyect' => ID_PRY));
                    if ($result !== FALSE)
                    {
                        if (count($result) > 0)
                        {
                            $id_user = $result[0]['id_user'];
                            if ($Validate->is_integer($id_user) && $id_user > 0)
                            {
                                $this->users[$user] = $id_user;
                                return $id_user;
                            }
                            else
                                return FALSE;
                        }
                    } else
                    {
                        $this->set_error("Database error while querying for user '" . $user . "'. ", ERR_VAL_INVALID);
                        return FALSE;
                    }
                }
            }
            else
            {
                $this->set_error("Invalid User ( '$user' ) on line " . $this->line . ". ", ERR_VAL_INVALID);
                return FALSE;
            }
        }
  
        private function get_pdv_id($pdv = '')
        {
            global $Validate;
            if ($pdv != '')
            {
                if (array_key_exists($pdv, $this->pdvs))
                {
                    return $this->pdvs[$pdv];
                }
                else
                {
                    global $obj_bd;
                    $query = " SELECT id_pdv FROM " . PFX_MAIN_DB . "proyect_pdv "
                            . " INNER JOIN " . PFX_MAIN_DB . "pdv ON id_pdv = ppv_pdv_id_pdv "
                            . " WHERE pdv_id_viamente = :pdv AND ppv_pr_id_proyect = :id_proyect AND ppv_active = 1 ";
                    $result = $obj_bd->query($query, array(':pdv' => $pdv, ':id_proyect' => ID_PRY));
                    if ($result !== FALSE)
                    {
                        if (count($result) > 0)
                        {
                            $id_pdv = $result[0]['id_pdv'];
                            if ($Validate->is_integer($id_pdv) && $id_pdv > 0)
                            {
                                $this->pdvs[$pdv] = $id_pdv;
                                return $id_pdv;
                            }
                            else
                                return FALSE;
                        }
                    } else
                    {
                        $this->set_error("Database error while querying for pdv '" . $pdv . "'. ", ERR_VAL_INVALID);
                        return FALSE;
                    }
                }
            }
            else
            {
                $this->set_error("Invalid User ( '$pdv' ) on line " . $this->line . ". ", ERR_VAL_INVALID);
                return FALSE;
            }
        }
  
        private function get_timestamp($date, $time)
        {
            // >> 15/01/2015   ,   10:20
            try
            {
                list( $d, $m, $Y ) = explode("/", $date);
                list( $H, $i ) = explode(":", $time);
                return mktime($H, $i, 0, $m, $d, $Y);
            }
            catch (Exception $e)
            {
                $this->set_error("Invalid date parameters ( $date , $time )", ERR_VAL_INVALID);
                return FALSE;
            }
        }
  
    }

?>