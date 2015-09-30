<?php
/*paperstore*/
  /**
   * CatalogueList
   */
  class AdminList extends DataTable
  {

      function __construct($which = '', $table_id = '')
      {
          $this->class = 'AdminList';
          if ($which != '')
          {
              $this->which = $which;
              parent::__construct($which, $table_id);
              $this->set_query();
              $this->set_template();
          }
          else
          {
              $this->clean();
              $this->error[] = "Listado inválido.";
          }
      }

      private function set_query()
      {
          switch ($this->which)
          {
          
            case 'lst_product':
                  $this->query = " SELECT "
                          . " id_product, pd_product, pd_alias, br_brand, pd_br_id_brand "
                          . " FROM " . PFX_MAIN_DB . "product "
                          . " INNER JOIN " . PFX_MAIN_DB . "brand ON id_brand = pd_br_id_brand "
                          . " WHERE pd_status = 1 ";
                  $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_product';
            break;
            
            case 'lst_sell':
                $this->query =  " SELECT id_sell, sl_date, sl_subtotal, sl_discount, sl_total, id_user, us_user, sl_timestamp ".
                                " FROM ".PFX_MAIN_DB."sell ".
                                " INNER JOIN sky_user ON id_user = sl_us_id_user ".
                                " WHERE sl_status > 0 AND sl_subtotal > 0";
				$this->sord = ' DESC ';
                $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'sl_date';
            break;
            
            case 'lst_daily_sell':
                $start  = mktime(0, 0, 0, date('n'), date('j'), date('Y') );
                $end    = mktime(23, 59, 59, date('n'), date('j'), date('Y') );
                $this->query =  " SELECT id_sell, sl_date, sl_subtotal, sl_discount, sl_total, id_user, us_user, sl_timestamp ".
                                " FROM ".PFX_MAIN_DB."sell ".
                                " INNER JOIN sky_user ON id_user = sl_us_id_user ".
                                " WHERE sl_status > 0 AND sl_ss_id_sell_status = 2 AND sl_date >= ".$start." AND sl_date <= ".$end;
                $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_sell';
            break;
            
            case 'lst_bar_stock':
                $this->query =  " SELECT id_bar_stock, id_product, pd_product, bs_unity_quantity, bs_sell_price, bs_min, bs_max, bs_buy_price ".
                                " FROM ".PFX_MAIN_DB."bar_stock ".
                                " INNER JOIN ".PFX_MAIN_DB."product ON id_product = bs_pd_id_product ".
                                " WHERE bs_status > 0";
                $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_bar_stock';
            break;
            
            case 'lst_warehouse':
                $this->query =  " SELECT id_storehouse_stock, id_product, pd_product, pp_product_packing, pp_unity_quantity, ss_quantity, ".
                                    " (pp_unity_quantity * ss_quantity) AS ss_total, ss_min, ss_max, ss_timestamp ".
                                " FROM ".PFX_MAIN_DB."storehouse_stock ".
                                " INNER JOIN ".PFX_MAIN_DB."product ON id_product = ss_pd_id_product ".
                                " INNER JOIN ".PFX_MAIN_DB."product_packing ON id_product_packing = ss_pp_id_product_packing ".
                                " WHERE ss_status > 0 ";
                $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_storehouse_stock';
            break;
            
            case 'lst_computer':
                $this->query =  " SELECT id_computer, cm_computer, ct_computer_type, cm_brand, cm_model ".
                                " FROM ".PFX_MAIN_DB."computer ".
                                " INNER JOIN ".PFX_MAIN_DB."computer_type ON id_computer_type = cm_ct_id_computer_type ".
                                " WHERE cm_status > 0 ";
                $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_computer';
            break;
            
            case 'lst_tax':
                $this->query =  " SELECT id_tax, tx_tax, tx_hour_amount, tx_amount_fraction, tx_amount_first_half, tx_amount_second_half, tx_timestamp, tx_type, ".
                                " CASE tx_type ".
                                "    WHEN 1 THEN 'Hora Completa' ".
                                "    WHEN 2 THEN 'Fraccion de 10 minutos' ".
                                "    WHEN 3 THEN 'Mitad de Hora' ".
                                " END AS tx_tipo ".
                                " FROM ".PFX_MAIN_DB."tax ".
                                " WHERE tx_status > 0";
                $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_tax';
            break;
            
            case 'lst_service':
                $this->query =  " SELECT id_service, sr_service, sr_price ".
                                " FROM ".PFX_MAIN_DB."service ".
                                " WHERE sr_status > 0 ";
                $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_service';
            break;
			
			case 'lst_leasing':
				$this->query =	" SELECT id_leasing, id_computer, cm_computer, ls_start, ls_end, ls_total, tx_tax ".
								" FROM ".PFX_MAIN_DB."leasing ".
								" INNER JOIN ".PFX_MAIN_DB."computer ON id_computer = ls_cm_id_computer ".
								" INNER JOIN ".PFX_MAIN_DB."tax ON id_tax = ls_tx_id_tax ".
								" WHERE ls_status = 0 AND ls_end > 0 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'ls_start';
				$this->sord = ' DESC ';
			break;
          
            /****************************************************/
          
          
              case 'lst_admin_users':
                  $this->query = " SELECT * FROM (  SELECT "
                          . " id_user , us_user, pf_profile, id_profile "
                          . " FROM " . PFX_MAIN_DB . "user u "
                          . " INNER JOIN " . PFX_MAIN_DB . "profile p ON id_profile = us_pf_id_profile  "
                          . " WHERE us_status = 1 GROUP BY id_user ) as tbl WHERE id_user > 0 ";
                  $this->group = " GROUP BY id_user ";
                  $this->sidx = ( $this->sidx != 'id' ) ? $this->sidx : 'id_user';
                  break;
              case 'lst_pdv':
                  $this->query = " SELECT  id_pdv, pdv_pvt_id_pdv_type, pvt_pdv_type, pdv_ch_id_channel, ch_channel, " .
                          " pdv_dv_id_division, dv_division, pdv_name, pdv_jde, pdv_route " .
                          " FROM " . PFX_MAIN_DB . "pdv " .
                          " INNER JOIN " . PFX_MAIN_DB . "pdv_type ON id_pdv_type = pdv_pvt_id_pdv_type " .
                          " INNER JOIN " . PFX_MAIN_DB . "channel ON id_channel = pdv_ch_id_channel " .
                          " INNER JOIN " . PFX_MAIN_DB . "division ON id_division = pdv_dv_id_division " .
                          " WHERE pdv_status = 1 ";
                  $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_pdv';
                  break;
              
              case 'lst_prospect':
              case 'lst_prospect_exp':
                  $this->query = " SELECT "
                          . " id_prospect, pro_name,pro_lastname,pro_lastname2,pro_latitude,pro_longitude,pro_phone,"
                          . " pro_street,pro_ext_num,pro_int_num,pro_district,pro_locality,pro_city,pro_state,pro_email,"
                          . " pro_rfc,pro_curp, pro_route,pro_dv_id_division,pro_ch_id_channel,pro_us_id_user, 'MX' as pro_country "
                          . " FROM " . PFX_MAIN_DB . "prospect "
                          . " WHERE pro_status = 1 ";
                  $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_prospect';
                  break;
              case 'lst_supplier':
                  $this->query = " SELECT *, id_supplier as id, su_supplier as value, '1' as detail FROM " . PFX_MAIN_DB . "supplier WHERE su_status = 1 ";
                  $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_supplier';
                  break;

              case 'lst_channel':
                  $this->query = "select id_channel, ch_channel, ch_status, ch_timestamp from " . PFX_MAIN_DB . "channel ";
                  $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_channel';
                  break;

              case 'lst_group':
                  $this->query = "select id_group, gr_ch_id_channel, gr_group, ch_channel from " . PFX_MAIN_DB . "group inner join " . PFX_MAIN_DB . "channel on id_channel = gr_ch_id_channel ";
                  $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_group';
                  break;

              case 'lst_format':
                  $this->query = "select id_format, fo_format, gr_group from " . PFX_MAIN_DB . "format inner join " . PFX_MAIN_DB . "group on id_group = fo_gr_id_group ";
                  $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_format';
                  break;

              case 'lst_brand':
                  $this->query = "select id_brand, ba_brand, ba_rival from " . PFX_MAIN_DB . "brand";
                  $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_brand';
                  break;

              case 'lst_family':
                  $this->query = "select id_family, fa_family, ba_brand, fa_rival " .
                          "from " . PFX_MAIN_DB . "family " .
                          "inner join " . PFX_MAIN_DB . "brand on fa_ba_id_brand = id_brand " .
                          "where fa_status > 0 ";

                  $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_family';
                  break;

              case 'lst_visit':
                  $this->query = " SELECT id_visit, vi_pdv_id_pdv, pdv_name, vi_us_id_user, us_user, vi_scheduled_start, " .
                          " vi_scheduled_end, vi_vs_id_visit_status, vs_visit_status" .
                          " FROM " . PFX_MAIN_DB . "visit " .
                          " INNER JOIN " . PFX_MAIN_DB . "pdv ON id_pdv = vi_pdv_id_pdv " .
                          " INNER JOIN " . PFX_MAIN_DB . "user ON id_user = vi_us_id_user " .
                          " INNER JOIN " . PFX_MAIN_DB . "visit_status ON id_visit_status = vi_vs_id_visit_status " .
                          " WHERE vi_status > 0";
                  $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_visit';
                  break;

              case 'lst_order':
                  $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_order';
                  $start = (($this->page - 1) * $this->rows); 
                  $this->query = "SELECT "
                          . " o.id_order, p.id_pdv, u.id_user, o.or_date, o.or_folio, id_order_status, "
                          . " u.us_user, p.pdv_name, "
                          . " o.or_status, (IFNULL(SUM( od_sum ),0) * 1.15) as total "
                          . " FROM " . PFX_MAIN_DB . "order o "
                          . " INNER JOIN " . PFX_MAIN_DB . "pdv p ON o.or_pdv_id_pdv = p.id_pdv"
                          . " INNER JOIN " . PFX_MAIN_DB . "user u ON o.or_us_id_user = u.id_user  "
                          . " INNER JOIN " . PFX_MAIN_DB . "order_status os ON o.or_os_id_order_status=os.id_order_status"
                          . " INNER JOIN ( SELECT od_or_id_order , od_quantity * od_price AS od_sum FROM " . PFX_MAIN_DB . "order_detail  ) as tbl "
                          . " ON tbl.od_or_id_order= id_order "
                          . " WHERE o.or_status=1 GROUP BY id_order ";
                  break;
              case 'lst_payment':
                  $this->query = " SELECT id_payment, id_pdv, pdv_name, id_user, us_user, py_date_payment, id_payment_method, pm_payment_method, py_total " .
                          " FROM " . PFX_MAIN_DB . "payment " .
                          " INNER JOIN " . PFX_MAIN_DB . "pdv ON id_pdv = py_pdv_id_pdv " .
                          " INNER JOIN " . PFX_MAIN_DB . "user ON id_user = py_us_id_user " .
                          " INNER JOIN " . PFX_MAIN_DB . "payment_method ON id_payment_method = py_pm_id_payment_method " .
                          " LEFT JOIN  " . PFX_MAIN_DB . "invoice ON id_invoice = py_in_id_invoice " .
                          " WHERe py_status > 0 ";
                  $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_payment';
                  break;

              case 'lst_deposit':
                  $this->query = " SELECT id_deposit, dp_us_id_user, us_user, dp_folio, dp_date, dp_total, dp_ev_id_evidence, ev_route " .
                          " FROM rg_deposit " .
                          " INNER JOIN rg_user ON id_user = dp_us_id_user " .
                          " INNER JOIN rg_evidence ON id_evidence = dp_ev_id_evidence " .
                          " WHERE dp_status > 0 ";
                  $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_deposit';
                  break;

              case 'lst_invoice':
                  $this->query = " SELECT id_invoice, in_date, id_pdv, pdv_name, in_folio, in_total " .
                          " FROM " . PFX_MAIN_DB . "invoice " .
                          " INNER JOIN rg_pdv ON id_pdv = in_pdv_id_pdv ";
                  $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_invoice';
                  break;

              case 'lst_city':
                  $this->query = " SELECT id_city, ct_city, ct_code, ct_st_st_code " .
                          " FROM " . PFX_MAIN_DB . "city " .
                          " WHERE ct_status > 0";
                  $this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_city';
			  break;
			  
			case 'lst_activity_type':
				$this->query =	" SELECT id_activity_type, at_activity_type, at_table_aux, ".
								" CASE at_table_aux ".
									" WHEN 'form' THEN 'Formulario' ".
									" WHEN 'evidence_type' THEN 'Tipo de Evidencia' ".
									" WHEN 'media_file' THEN 'Archivo de Medios' ".
									" WHEN 'profile' THEN 'Perfil de Usuario' ".
									" ELSE 'Sin Apoyo' ".
								" END as ac_label_table_aux ".
								" FROM " . PFX_MAIN_DB . "activity_type " ;
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_activity_type';				
			break;
			
			case 'lst_activity':
				$this->query =	" SELECT id_activity, ac_activity, at_activity_type, ac_default ".
								" FROM " . PFX_MAIN_DB . "activity ".
								" INNER JOIN " . PFX_MAIN_DB . "activity_type ON id_activity_type = ac_at_id_activity_type ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_activity';
			break;
			
			case 'lst_task_type':
				$this->query =	" SELECT id_task_type, tt_task_type ".
								" FROM " . PFX_MAIN_DB . "task_type ".
								" WHERE tt_status > 0 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_task_type';
			break;
			
			case 'lst_task_type_activities':
				$this->query =	" SELECT tta_tt_id_task_type, tt_task_type, tta_ac_id_activity, ac_activity ".
								" FROM " . PFX_MAIN_DB . "task_type_activities ".
								" INNER JOIN " . PFX_MAIN_DB . "task_type ON id_task_type = tta_tt_id_task_type ".
								" INNER JOIN " . PFX_MAIN_DB . "activity ON id_activity = tta_ac_id_activity ";
								
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'tta_tt_id_task_type';
			break;
			
			case 'lst_pdv_type':
				$this->query = 	" SELECT id_pdv_type, pvt_pdv_type ".
								" FROM " . PFX_MAIN_DB . "pdv_type ".
								" WHERE pvt_status > 0 ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'id_pdv_type';
			break;
			
			case 'lst_pdv_type_task':
				$this->query = 	" SELECT ptt_pvt_id_pdv_type, pvt_pdv_type, ptt_tt_id_task_type, tt_task_type ".
								" FROM " . PFX_MAIN_DB . "pdv_type_task_type ".
								" INNER JOIN " . PFX_MAIN_DB . "pdv_type ON id_pdv_type = ptt_pvt_id_pdv_type ".
								" INNER JOIN " . PFX_MAIN_DB . "task_type ON id_task_type = ptt_tt_id_task_type ";
				$this->sidx = ( $this->sidx != 'id') ? $this->sidx : 'ptt_pvt_id_pdv_type';
			break;
			
          }
          $this->sort = " ORDER BY " . $this->sidx . " " . $this->sord . " ";
      }

    private function set_template()
    {
        switch ($this->which)
        {
        
        case 'lst_product':
        //id_product, pd_product, pd_sku, br_brand, pd_br_id_brand
            $this->title = " Productos ";
            $this->columns = array(
                array('idx' => 'id_product', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                array('idx' => 'pd_product', 'lbl' => 'Producto', 'sortable' => TRUE, 'searchable' => TRUE, 'width' => '40%'),
                array('idx' => 'br_brand', 'lbl' => 'Marca', 'sortable' => TRUE, 'searchable' => TRUE),
                array('idx' => 'pd_alias', 'lbl' => 'Alias', 'sortable' => TRUE, 'searchable' => TRUE),                
                array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE, 'width' => '120px')
            );
            $this->template = DIRECTORY_VIEWS . "/lists/lst.product.php";
        break;
        
        case 'lst_sell':
        case 'lst_daily_sell':
                //$this->query =  " SELECT id_sell, sl_date, sl_subtotal, sl_discount, sl_total, id_user, us_user, sl_timestamp ".
            $this->title = " Ventas ";
            $this->columns = array(
                array('idx' => 'id_sell',       'lbl' => 'ID',          'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'sl_date',       'lbl' => 'Fecha',       'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'sl_subtotal',   'lbl' => 'Subtotal',    'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'sl_total',      'lbl' => 'Total',       'sortable' => TRUE,     'searchable' => TRUE ),
                array('idx' => 'us_user',       'lbl' => 'Usuario',     'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'actions',       'lbl' => 'Acciones',    'sortable' => FALSE,    'searchable' => FALSE, 'width' => '120px')
            );
            $this->template = DIRECTORY_VIEWS . "/lists/lst.sell.php";
        break;
        
        case 'lst_bar_stock':
            $this->title = " Inventario de Mostrador ";
            $this->columns = array(
                array('idx' => 'id_bar_stock',      'lbl' => 'ID',                  'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'pd_product',        'lbl' => 'Producto',            'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'bs_unity_quantity', 'lbl' => 'Cantidad (Unidades)', 'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'bs_sell_price',     'lbl' => 'Precio Venta',        'sortable' => TRUE,     'searchable' => TRUE ),
				array('idx' => 'bs_buy_price',      'lbl' => 'Precio Compra',       'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'bs_min',            'lbl' => 'Minimo',              'sortable' => TRUE,     'searchable' => TRUE),                
                array('idx' => 'actions',           'lbl' => 'Acciones',            'sortable' => FALSE,    'searchable' => FALSE, 'width' => '120px')
            );
            $this->template = DIRECTORY_VIEWS . "/lists/lst.bar.stock.php";
        break;
        
        case 'lst_warehouse':
            //SELECT id_storehouse_stock, id_product, pd_product, pp_product_packing, ss_quantity, ss_min, ss_max, ss_timestamp ".
            $this->title = " Inventario de Bodega ";
            $this->columns = array(
                array('idx' => 'id_storehouse_stock',   'lbl' => 'ID',                  'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'pd_product',            'lbl' => 'Producto',            'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'pp_product_packing',    'lbl' => 'Empaque',             'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'pp_unity_quantity',     'lbl' => 'Unids/Empaque',       'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'ss_quantity',           'lbl' => 'Cantidad',            'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'ss_total',              'lbl' => 'Total',               'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'ss_min',                'lbl' => 'Mínimo',              'sortable' => TRUE,     'searchable' => TRUE ),
                array('idx' => 'ss_max',                'lbl' => 'Máximo',              'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'actions',               'lbl' => 'Acciones',            'sortable' => FALSE,    'searchable' => FALSE, 'width' => '120px')
            );
            $this->template = DIRECTORY_VIEWS . "/lists/lst.warehouse.php";
        break;
        
        case 'lst_computer':
            //$this->query =  " SELECT id_computer, cm_computer, ct_computer_type, cm_brand, cm_model ".
            $this->title = " Computadoras Registradas ";
            $this->columns = array(
                array('idx' => 'id_computer',           'lbl' => 'ID',              'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'cm_computer',           'lbl' => 'Computadora',     'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'ct_computer_type',      'lbl' => 'Tipo',            'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'cm_brand',              'lbl' => 'Marca',           'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'cm_model',              'lbl' => 'Modelo',          'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'actions',               'lbl' => 'Acciones',        'sortable' => FALSE,    'searchable' => FALSE, 'width' => '120px')
            );
            $this->template = DIRECTORY_VIEWS . "/lists/lst.computer.php";
        break;
        
        case 'lst_tax':
            $this->title = " Tarifas del Ciber ";//10.13.51.120
            $this->columns = array(
                array('idx' => 'id_tax',                    'lbl' => 'ID',                  'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'tx_tax',                    'lbl' => 'Tarifa',              'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'tx_hour_amount',            'lbl' => 'Costo/Hora',          'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'tx_tipo',                   'lbl' => 'Tipo',                'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'tx_amount_fraction',        'lbl' => 'Costo 10 Minutos',    'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'tx_amount_first_half',      'lbl' => 'Costo Primera Mitad', 'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'tx_amount_second_half',     'lbl' => 'Costo Segunda Mitad', 'sortable' => TRUE,     'searchable' => TRUE),
                array('idx' => 'actions',                   'lbl' => 'Acciones',            'sortable' => FALSE,    'searchable' => FALSE, 'width' => '180px')
            );
            $this->template = DIRECTORY_VIEWS . "/lists/lst.tax.php";
        break;
        
        case 'lst_service':
                //$this->query =  " SELECT id_service, sr_service, sr_price ".
                $this->title = " Servicios ";
                $this->columns = array(
					array('idx' => 'id_service',          'lbl' => 'ID',            'sortable' => TRUE,     'searchable' => TRUE),
					array('idx' => 'sr_service',          'lbl' => 'Servicio',      'sortable' => TRUE,     'searchable' => TRUE),
					array('idx' => 'sr_price',            'lbl' => 'Costo',         'sortable' => TRUE,     'searchable' => TRUE),
					array('idx' => 'actions',             'lbl' => 'Acciones',      'sortable' => FALSE,    'searchable' => FALSE, 'width' => '180px')
				);
            $this->template = DIRECTORY_VIEWS . "/lists/lst.service.php";
        break;
		
		case 'lst_leasing':
				//$this->query =	" SELECT id_leasing, id_computer, cm_computer, ls_start, ls_end, ls_total, tx_tax ".
				$this->title = " Rentas ";
                $this->columns = array(
					array('idx' => 'id_leasing',        'lbl' => 'ID',            'sortable' => TRUE,     'searchable' => TRUE),
					array('idx' => 'cm_computer',       'lbl' => 'Computadora',   'sortable' => TRUE,     'searchable' => TRUE),
					array('idx' => 'ls_start',          'lbl' => 'Fecha',         'sortable' => TRUE,     'searchable' => TRUE),
					array('idx' => 'ls_start',          'lbl' => 'Hora Inicio',   'sortable' => TRUE,     'searchable' => TRUE),
					array('idx' => 'ls_end',          	'lbl' => 'Hora Final',    'sortable' => TRUE,     'searchable' => TRUE),
					array('idx' => 'ls_total',          'lbl' => 'Costo', 	      'sortable' => TRUE,     'searchable' => TRUE),
					array('idx' => 'tx_tax',            'lbl' => 'Tarifa',        'sortable' => TRUE,     'searchable' => TRUE)
				);
            $this->template = DIRECTORY_VIEWS . "/lists/lst.leasing.php";
				
		break;
        /*********************************************************************************************************************************/
            
              case 'lst_admin_users':
                  $this->title = " Usuarios ";
                  $this->columns = array(
                       array('idx' => 'id_user', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'image', 'lbl' => 'Imágen', 'sortable' => FALSE, 'searchable' => FALSE),
                       array('idx' => 'us_user', 'lbl' => 'Usuario', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'pf_profile', 'lbl' => 'Perfil', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE)
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.users.php";
                  break;
              case 'lst_pdv':
                  $this->title = " Puntos de Venta ";
                  $this->columns = array(
                       array('idx' => 'id_pdv', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'pdv_name', 'lbl' => 'Nombre', 'sortable' => TRUE, 'searchable' => TRUE, 'width' => '30%'),
                       array('idx' => 'pdv_jde', 'lbl' => 'JDE', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'ch_channel', 'lbl' => 'Canal', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'dv_division', 'lbl' => 'División', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE, 'width' => '120px')
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.pdv.php";
                  break;              
              case 'lst_prospect':
                  $this->title = " Prospectos ";
                  $this->columns = array(
                       array('idx' => 'id_prospect', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'pro_name', 'lbl' => 'Nombre', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'pro_rfc', 'lbl' => 'RFC', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'pro_email', 'lbl' => 'E-mail', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'pro_route', 'lbl' => 'Ruta', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE, 'width' => '120px')
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.prospect.php";
                  break;
              case 'lst_prospect_exp':
                  $this->title = " Prospectos "; 
                  $this->columns = array(
                       array('idx' => 'id_prospect', 	'lbl' => 'ID', 					'width' => '25'),
                       array('idx' => 'pro_name', 		'lbl' => 'Nombre/Razón Social', 'width' => '40'),
                       array('idx' => 'pro_lastname', 	'lbl' => 'Apellido Paterno', 	'width' => '40'),
                       array('idx' => 'pro_lastname2',	'lbl' => 'Apellido Materno', 	'width' => '40'),
                       array('idx' => 'pro_street',		'lbl' => 'Calle',			 	'width' => '40'),
                       array('idx' => 'pro_ext_num', 	'lbl' => 'Número Exterior', 	'width' => '40'),
                       array('idx' => 'pro_int_num',	'lbl' => 'Número Interior', 	'width' => '40'),
                       array('idx' => 'pro_locality',	'lbl' => 'Colonia',			 	'width' => '40'),
                       array('idx' => 'pro_district',	'lbl' => 'Delegación',		 	'width' => '40'),
                       array('idx' => 'pro_city',		'lbl' => 'Ciudad',			 	'width' => '40'),
                       array('idx' => 'pro_state',		'lbl' => 'Estado',			 	'width' => '40'),
                       array('idx' => 'pro_zipcode',	'lbl' => 'Código Postal',	 	'width' => '40'),
                       array('idx' => 'pro_country',	'lbl' => 'País',			 	'width' => '40'),
                       array('idx' => 'pro_rfc',		'lbl' => 'R.F.C.',			 	'width' => '40'),
                       array('idx' => 'pro_curp',		'lbl' => 'CURP (Persona Física)','width'=> '40'),
                       array('idx' => 'pro_phone',		'lbl' => 'Teléfono',		 	'width' => '40'),
                       array('idx' => 'pro_route',		'lbl' => 'Clave',			 	'width' => '40'),
                       array('idx' => 'dv_division',	'lbl' => 'División',		 	'width' => '40'),
                       array('idx' => 'ch_channel',		'lbl' => 'Canal de Distribución','width' => '40'),
                       array('idx' => 'pro_email',		'lbl' => 'E-mail',			 	'width' => '40') 
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.prospect.php";
                  break;
              case 'lst_supplier':
                  $this->title = " Mayorista ";
                  $this->columns = array(
                       array('idx' => 'id_supplier', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'su_supplier', 'lbl' => 'Mayorista', 'sortable' => TRUE, 'searchable' => TRUE, 'width' => '80%'),
                       array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE)
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.supplier.php";
                  break;

              case 'lst_channel':
                  $this->title = " Canal ";
                  $this->columns = array(
                       array('idx' => 'id_channel', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'ch_channel', 'lbl' => 'Canal', 'sortable' => TRUE, 'searchable' => TRUE, 'width' => '80%'),
                       array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE)
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.channel.php";
                  break;
              case 'lst_group':
                  $this->title = " Grupo ";
                  $this->columns = array(
                       array('idx' => 'id_group', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'gr_group', 'lbl' => 'Grupo', 'sortable' => TRUE, 'searchable' => TRUE, 'width' => '50%'),
                       array('idx' => 'ch_channel', 'lbl' => 'Canal', 'sortable' => TRUE, 'searchable' => TRUE, 'width' => '50%'),
                       array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE)
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.group.php";
                  break;
				  
              case 'lst_format':
                  $this->title = " Formato ";
                  $this->columns = array(
                       array('idx' => 'id_format', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'fo_format', 'lbl' => 'Formato', 'sortable' => TRUE, 'searchable' => TRUE, 'width' => '50%'),
                       array('idx' => 'gr_group', 'lbl' => 'Grupo', 'sortable' => TRUE, 'searchable' => TRUE, 'width' => '50%'),
                       array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE)
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.format.php";
                  break;

              case 'lst_brand':
                  $this->title = " Marcas ";
                  $this->columns = array(
                       array('idx' => 'id_brand', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'ba_brand', 'lbl' => 'Marca', 'sortable' => TRUE, 'searchable' => TRUE, 'width' => '80%'),
                       array('idx' => 'ba_rival', 'lbl' => 'Comp.', 'sortable' => TRUE, 'searchable' => FALSE, 'width' => '25px !important'),
                       array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE)
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.brand.php";
                  break;

              case 'lst_family':
                  $this->title = " Familias ";
                  $this->columns = array(
                       array('idx' => 'id_family', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'fa_family', 'lbl' => 'Familia', 'sortable' => TRUE, 'searchable' => TRUE, 'width' => '50%'),
                       array('idx' => 'ba_brand', 'lbl' => 'Marca', 'sortable' => TRUE, 'searchable' => TRUE, 'width' => '50%'),
                       array('idx' => 'fa_rival', 'lbl' => 'Comp.', 'sortable' => TRUE, 'searchable' => FALSE, 'width' => '25px !important'),
                       array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE)
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.family.php";
                  break;

              case 'lst_visit':
                  $this->title = " Visitas ";
                  $this->columns = array(
                       array('idx' => 'id_visit', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'pdv_name', 'lbl' => 'PDV', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'us_user', 'lbl' => 'Usuario', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'vi_scheduled_start', 'lbl' => 'Inicio', 'sortable' => TRUE, 'searchable' => FALSE),
                       array('idx' => 'vs_visit_status', 'lbl' => 'Status', 'sortable' => TRUE, 'searchable' => FALSE),
                       array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE)
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.visit.php";
                  break;

              case 'lst_order':
                  $this->title = " Pedidos ";
                  $this->columns = array(
                       array('idx' => 'id_order', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'or_date', 'lbl' => 'Fecha', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'us_user', 'lbl' => 'Usuario', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'pdv_name', 'lbl' => 'PDV', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'or_total', 'lbl' => 'Total', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE, 'width' => '60px')
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.order.php";
                  break;

              case 'lst_payment':
                  $this->title = " Pagos ";
                  $this->columns = array(
                       array('idx' => 'id_payment', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'pdv_name', 'lbl' => 'PDV', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'us_user', 'lbl' => 'Usuario', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'py_date_payment', 'lbl' => 'Fecha', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'pm_payment_method', 'lbl' => 'Método de Pago', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'py_total', 'lbl' => 'Total', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE, 'width' => '60px')
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.payment.php";
                  break;

              case 'lst_deposit':
                  $this->title = " Depósitos ";
                  $this->columns = array(
                       array('idx' => 'id_deposit', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'us_user', 'lbl' => 'Usuario', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'dp_folio', 'lbl' => 'Folio', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'dp_date', 'lbl' => 'Fecha', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'dp_total', 'lbl' => 'Total', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'evidence', 'lbl' => 'Evidencia', 'sortable' => FALSE, 'searchable' => FALSE, 'width' => '60px'),
                       array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE, 'width' => '60px')
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.deposit.php";
                  break;

              case 'lst_invoice':
                  $this->title = " Facturas ";
                  $this->columns = array(
                       array('idx' => 'id_invoice', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'in_folio', 'lbl' => 'Folio', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'pdv_name', 'lbl' => 'PDV', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'in_total', 'lbl' => 'Total', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'in_date', 'lbl' => 'Fecha', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE, 'width' => '60px')
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.invoice.php";
                  break;

              case 'lst_city':
                  $this->title = " Ciudades ";
                  $this->columns = array(
                       array('idx' => 'id_city', 'lbl' => 'ID', 'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'ct_city', 'lbl' => 'Ciudad', 'sortable' => TRUE, 'searchable' => TRUE, 'width' => '60%;'),
                       array('idx' => 'ct_code', 'lbl' => 'Codigo', 'sortable' => TRUE, 'searchable' => TRUE,),
                       array('idx' => 'ct_st_st_code', 'lbl' => 'Codigo del Estado', 'sortable' => TRUE, 'searchable' => TRUE,),
                       array('idx' => 'actions', 'lbl' => 'Acciones', 'sortable' => FALSE, 'searchable' => FALSE)
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.city.php";
                  break;
				  
			case 'lst_activity':
				$this->title = " Actividades ";
                  $this->columns = array(
                       array('idx' => 'id_activity', 			'lbl' => 'ID', 			'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'ac_activity', 			'lbl' => 'Actividad', 	'sortable' => TRUE, 'searchable' => TRUE, 'width' => '60%;'),
                       array('idx' => 'at_activity_type',		'lbl' => 'Tipo', 		'sortable' => TRUE, 'searchable' => TRUE,),
                       array('idx' => 'actions', 				'lbl' => 'Acciones',	'sortable' => FALSE, 'searchable' => FALSE)
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.activity.php";
			break;
				  
			case 'lst_activity_type':
				$this->title = " Tipos de Actividades ";
                  $this->columns = array(
                       array('idx' => 'id_activity_type', 	'lbl' => 'ID', 					'sortable' => TRUE, 'searchable' => TRUE),
                       array('idx' => 'at_activity_type', 	'lbl' => 'Tipo de Actividad',	'sortable' => TRUE, 'searchable' => TRUE, 'width' => '60%;'),
                       array('idx' => 'at_table_aux', 		'lbl' => 'Apoyo', 				'sortable' => TRUE, 'searchable' => TRUE,),
                       array('idx' => 'actions', 			'lbl' => 'Acciones',			'sortable' => FALSE,'searchable' => FALSE)
                  );
                  $this->template = DIRECTORY_VIEWS . "/lists/lst.activity.type.php";
			break;
			
			case 'lst_task_type':
				$this->title = " Tipos de Tareas ";
				$this->columns = array(
					 array('idx' => 'id_task_type', 	'lbl' => 'ID', 				'sortable' => TRUE, 'searchable' => TRUE),
					 array('idx' => 'tt_task_type', 	'lbl' => 'Tipo de Tarea',	'sortable' => TRUE, 'searchable' => TRUE, 'width' => '50%;'),
					 array('idx' => 'actions', 			'lbl' => 'Acciones',		'sortable' => FALSE,'searchable' => FALSE)
				);
				$this->template = DIRECTORY_VIEWS . "/lists/lst.task.type.php";
			break;
			
			case 'lst_task_type_activities':
				$this->title = " Actividades por Tipo de Tarea ";
				$this->columns = array(
					 array('idx' => 'tta_tt_id_task_type', 	'lbl' => 'ID', 				'sortable' => TRUE, 'searchable' => TRUE),
					 array('idx' => 'tt_task_type', 		'lbl' => 'Tipo de Tarea',	'sortable' => TRUE, 'searchable' => TRUE, 'width' => '50%;'),
					 array('idx' => 'ac_activity', 			'lbl' => 'Actividad',		'sortable' => TRUE, 'searchable' => TRUE, 'width' => '50%;'),
					 array('idx' => 'actions', 				'lbl' => 'Acciones',		'sortable' => FALSE,'searchable' => FALSE)
				);
				$this->template = DIRECTORY_VIEWS . "/lists/lst.task.type.activity.php";
			break;
			
			case 'lst_pdv_type':
				$this->title = " Tipos de PDV ";
				$this->columns = array(
					 array('idx' => 'id_pdv_type', 		'lbl' => 'ID', 				'sortable' => TRUE, 'searchable' => TRUE),
					 array('idx' => 'pvt_pdv_type', 	'lbl' => 'Tipo de PDV',		'sortable' => TRUE, 'searchable' => TRUE, 'width' => '50%;'),
					 array('idx' => 'actions', 			'lbl' => 'Acciones',		'sortable' => FALSE,'searchable' => FALSE)
				);
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pdv.type.php";
			break;
			
			case 'lst_pdv_type_task':
				$this->title = " Tareas por Tipo de PDV ";
				$this->columns = array(
					 array('idx' => 'ptt_pvt_id_pdv_type', 	'lbl' => 'ID', 				'sortable' => TRUE, 'searchable' => TRUE),
					 array('idx' => 'pvt_pdv_type', 		'lbl' => 'Tipo de PDV',		'sortable' => TRUE, 'searchable' => TRUE, 'width' => '50%;'),
					 array('idx' => 'tt_task_type', 		'lbl' => 'Tarea',			'sortable' => TRUE, 'searchable' => TRUE, 'width' => '50%;'),
					 array('idx' => 'actions', 				'lbl' => 'Acciones',		'sortable' => FALSE,'searchable' => FALSE)
				);
				$this->template = DIRECTORY_VIEWS . "/lists/lst.pdv.type.task.php";
			break;
			
          }
      }

  }

?>