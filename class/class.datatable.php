<?php
  require_once 'class/PHPExcel.php';

  /**
   * Class DataTable
   */
  abstract class DataTable
  {

      public $page;
      public $rows;
      public $table_id;
      public $sord;
      public $sidx;
      public $fidx;
      public $fval;
      public $exfidx;
      public $exfval;
      public $acciones;
      public $idioma = 1;
      public $title;
      protected $which;
      protected $query;
      protected $where;
      protected $group;
      protected $sort;
      protected $limit;
      public $total_pages = 0;
      public $total_records = 0;
      protected $columns = array();
      protected $template = "";
      protected $template_header = "";
      protected $template_foot = "";
      protected $cols = array();
      protected $id_proyect;
      protected $showing_template = " Mostrando %s - %s de %s registros. ";
      protected $sel_all_option = FALSE;
      protected $sel_all_function = '';
      protected $sel_all_fcn_params = array();
      public $error = array();

      public function __construct($which = '', $table_id = '')
      {

          $this->which = $which;
          $this->page = isset($_REQUEST['page']) && $_REQUEST['page'] > 0 ? $_REQUEST['page'] : 1;
          $this->rows = isset($_REQUEST['rows']) && is_numeric($_REQUEST['rows']) ? $_REQUEST['rows'] : 25;
          $this->sord = isset($_REQUEST['sord']) && $_REQUEST['sord'] != '' ? $_REQUEST['sord'] : "ASC";
          $this->sidx = isset($_REQUEST['sidx']) && $_REQUEST['sidx'] != '' ? $_REQUEST['sidx'] : "id";

          if ($table_id != '')
              $this->table_id = $table_id;
          else
              $this->table_id = $which;

          $this->set_search();
      }

      protected function set_list($which, $table_id = '')
      {
          $this->which = $which;
          if ($table_id != '')
              $this->table_id = $table_id;
          else
              $this->table_id = $which;
      }

      public function set_filter($col, $val, $signo = '=', $modo = 'AND', $open = '', $close = '')
      {
          if ($signo == 'LIKE')
              $this->where .= " " . $modo . " " . $open . " " . ($col) . " " . $signo . " '%" . ($val) . "%' " . $close . " ";
          else if($signo == 'IN')
              $this->where .= " " . $modo . " " . $open . " " . ($col) . " " . $signo . "  " . ($val) . "  " . $close . " ";
          else
              $this->where .= " " . $modo . " " . $open . " " . ($col) . " " . $signo . "  '" . ($val) . "'  " . $close . " ";
              
          $this->fidx = $col;
          $this->fval = $val;
      }

      public function set_title($title)
      {
          $this->title = $title;
      }

      public function set_search()
      {
          if (isset($_REQUEST['searchField']) && $_REQUEST['searchField'] != '' && isset($_REQUEST['searchString']) && $_REQUEST['searchString'] != '')
          {
              $sfield = $_REQUEST['searchField'];
              $sstr = $_REQUEST['searchString'];
              $this->where .= " AND $sfield LIKE '%" . ($sstr) . "%' ";
          }
      }

      public function set_select_all_function($function, $params)
      {
          $this->sel_all_option = TRUE;
          $this->sel_all_function = $function;
          $this->sel_all_fcn_params = $params;
      }

      public function get_list_html($ajax = FALSE)
      {
          if (count($this->error) == 0 && $this->query != '' && $this->template != '')
          {
              global $obj_bd;
              $query = $this->query
                      . " " . $this->where
                      . " " . $this->group
                      . " " . $this->sort;
              
              $q_cuantos = "SELECT count(*) as RecordCount FROM (" . $query . ") as cuenta ";
              $record = $obj_bd->query($q_cuantos);
              if ($record === FALSE)
              {
                  $this->set_error('Ocurrió un error al contar los registros en la BD. ', LOG_DB_ERR, 1);
                  return FALSE;
              }
              $this->total_records = (int) $record[0]["RecordCount"];
              $start = (($this->page - 1) * $this->rows);
              if ($this->rows > 0)
              {
                  $this->total_pages = ceil($this->total_records / $this->rows);
              }
              else
              {
                  $this->total_pages = 0;
              }
              $limit = " LIMIT " . $start . ", " . $this->rows;
              $result = $obj_bd->query($query . $limit);
              if ($result !== FALSE)
              {
                  if (!$ajax)
                      $this->get_header_html();
                  if (count($result) > 0)
                  {
                      $resp = "";
                      foreach ($result as $k => $record)
                      {
                          ob_start();
                          require $this->template;
                          $resp .= ob_get_clean();
                      }
                  }
                  else
                  {
                      $resp = "<tr> <td align='center' colspan='" . count($this->columns) . "'> No se encontraron registros. </td> <tr>";
                  }
                  if ($ajax)
                  {
                      return $resp;
                  }
                  else
                  {
                      echo $resp;
                      $this->get_foot_functions();
                  }
              }
              else
              {
                  $this->set_error('Ocurrió un error al obtener los registros de la BD', LOG_DB_ERR, 2);
                  return false;
              }
          }
      }

      public function get_html_search()
      {
          ?> <select id="inp_<?php echo $this->table_id ?>_srch_idx"> <?php
          foreach ($this->columns as $k => $col)
          {
              if ($col['searchable'])
              {
                  echo "<option value='" . $col['idx'] . "'>" . $col['lbl'] . "</option>";
              }
          }
          ?> </select>
          <input type="text" id="inp_<?php echo $this->table_id ?>_srch_string">
          <button onclick="reload_table('<?php echo $this->table_id ?>')"><i class="fa fa-search"></i></button>
          <?php
      }

      private function get_header_html()
      {
          if (is_array($this->columns))
          {
              ?>
              <thead>
                  <tr >
                      <td colspan="<?php echo count($this->columns) ?>">
                          <div class="row">
                              <div class="col-xs-12 text-center"> <h4 id='lbl_title'><?php echo $this->title ?></h4> </div>
                              <div class="col-xs-6">
                                  Buscar 
                                  <?php $this->get_html_search(); ?>  
                              </div>
                              <div class="col-xs-6 text-right"> 
                                  <span id='<?php echo $this->table_id ?>_lbl_foot' >
                                      <?php echo $this->get_foot_records_label(); ?>
                                  </span>
                                  <select id="inp_<?php echo $this->table_id ?>_rows" name="<?php echo $this->table_id ?>_rows" onchange="reload_table('<?php echo $this->table_id ?>');">
                                      <option value="25"  <?php $this->rows == 25 ? "selected='selected'" : "" ?>>25</option>
                                      <option value="50"  <?php $this->rows == 50 ? "selected='selected'" : "" ?>>50</option>
                                      <option value="100" <?php $this->rows == 100 ? "selected='selected'" : "" ?>>100</option>   
                                  </select> 
                                  registros por página. 
                                  <button onclick="reload_table('<?php echo $this->table_id ?>');"><i class="fa fa-refresh"></i></button>
                              </div>
                              <?php $this->get_select_all_functions() ?>

                          </div>
                      </td>
                  </tr>
                  <tr>
                      <?php
                      foreach ($this->columns as $k => $col)
                      {
                          $sort_cls = "";
                          $sort_func = "";
                          if ($col['sortable'])
                          {
                              $sort_cls = "sortable sorting";
                              $sort_dir = "ASC";
                              if ($this->sidx == $col['idx'])
                              {
                                  $sort_cls .= ( $this->sord == 'DESC') ? "_asc" : "_desc";
                                  $sort_dir = ( $this->sord == 'DESC') ? "ASC" : "DESC";
                              }
                              $sort_func = "onclick='sort_table(\"" . $this->table_id . "\", \"" . $col['idx'] . "\", \"" . $sort_dir . "\" )'";
                          }
                          echo " <th id='" . $this->table_id . "_hd_" . $col['idx'] . "' class='" . $this->table_id . "_head " . $sort_cls . "' " . $sort_func
                          . ( isset($col['width']) && $col['width'] != '' ? " style='width:" . $col['width'] . ";'" : "" )
                          . " > " . $col['lbl']
                          . "</th>";
                      }
                      ?></tr>
              </thead> 
              <tbody id="<?php echo $this->table_id ?>_tbody" > <?php
              }
          }

		private function get_select_all_functions() {
			if ($this->sel_all_option === TRUE) { ?>
              <div class="col-xs-6 text-right">
                  Seleccionar Todo&nbsp;&nbsp;
                  <input type="checkbox" id="inp_select_all_<?php echo $this->table_id ?>"
                         onchange="<?php
                         echo $this->sel_all_function . " (";

                         $this->sel_all_fcn_params[] = "'inp_select_all_" . $this->table_id . "'";
                         $params = implode(',', $this->sel_all_fcn_params);

                         echo $params . ")"
                         ?>" />
              </div> <?php
          }
      }

      public function get_foot_records_label()
      {
          $start = (($this->page - 1) * $this->rows);
          $stop = $start + $this->rows;
          $stop = ( $stop <= $this->total_records ) ? $stop : $this->total_records;
          return sprintf($this->showing_template, $start + 1, $stop, $this->total_records);
      }

      private function get_foot_functions()
      {
          ?>
          </tbody>
          <tfoot>
              <tr> 
                  <td colspan="<?php echo count($this->columns) ?>">
                      <div class="row">
                          <div class="col-xs-6" style="margin-top: 10px;" > 
                              <input type="hidden" id="inp_<?php echo $this->table_id ?>_sord" name="<?php echo $this->table_id ?>_sord" value="<?php echo $this->sord ?>" />
                              <input type="hidden" id="inp_<?php echo $this->table_id ?>_sidx" name="<?php echo $this->table_id ?>_sidx" value="<?php echo $this->sidx ?>" />
                              <input type="hidden" id="inp_<?php echo $this->table_id ?>_fval" name="<?php echo $this->table_id ?>_fval" value="<?php echo $this->fval ?>" />
                              <input type="hidden" id="inp_<?php echo $this->table_id ?>_fidx" name="<?php echo $this->table_id ?>_fidx" value="<?php echo $this->fidx ?>" />
                              <input type="hidden" id="inp_<?php echo $this->table_id ?>_exfval" name="<?php echo $this->table_id ?>_exfval" value="<?php echo $this->exfval ?>" />
                              <input type="hidden" id="inp_<?php echo $this->table_id ?>_exfidx" name="<?php echo $this->table_id ?>_exfidx" value="<?php echo $this->exfidx ?>" />
                              <input type="hidden" id="inp_<?php echo $this->table_id ?>_rows" name="<?php echo $this->table_id ?>_rows" value="<?php echo $this->rows ?>" />
                              <input type="hidden" id="inp_<?php echo $this->table_id ?>_list" name="<?php echo $this->table_id ?>_list" value="<?php echo $this->which ?>" />
                              <input type="hidden" id="inp_<?php echo $this->table_id ?>_cols" name="<?php echo $this->table_id ?>_cols" value="<?php echo count($this->columns) ?>" />
                              <input type="hidden" id="inp_<?php echo $this->table_id ?>_tpages" name="<?php echo $this->table_id ?>_tpages" value="<?php echo $this->total_pages ?>" /> 
                          </div> 
                          <div class="col-xs-6 text-right">
                              <div class="datatable-paginate">
                                  <ul class="pagination">
                                      <li <?php echo ( $this->page > 1 ) ? "" : "class=''"; ?> >
                                          <a href="#" onclick="move_page('<?php echo $this->table_id ?>','f');"><i class="fa fa-angle-double-left"></i></a>
                                      </li>
                                      <li <?php echo ( $this->page > 1 ) ? "" : "class=''"; ?> >
                                          <a href="#" onclick="move_page('<?php echo $this->table_id ?>','p');"><i class="fa fa-angle-left"></i></a>
                                      </li>
                                      <li>
                                          <a href="#">
                                          	<span>
                                              Página <input id="inp_<?php echo $this->table_id ?>_page" name="page" value="<?php echo $this->page; ?>"  />
                                              <button style='margin-left: -5px;' onclick="reload_table('<?php echo $this->table_id ?>');"><i class="fa fa-gear"></i></button> de 
                                              <span id="<?php echo $this->table_id ?>_lbl_tpages"><?php echo $this->total_pages; ?></span>
                                  			</span>
                                          </a>
                                      </li> 
                                      <li <?php echo ( $this->page < $this->total_pages ) ? "" : "class='disabled'"; ?> >
                                          <a href="#" onclick="move_page('<?php echo $this->table_id ?>','n');"><i class="fa fa-angle-right"></i></a>
                                      </li>
                                      <li <?php echo ( $this->page < $this->total_pages ) ? "" : "class='disabled'"; ?> >
                                          <a href="#" onclick="move_page('<?php echo $this->table_id ?>','l');"><i class="fa fa-angle-double-right"></i></a>
                                      </li> 
                                  </ul> 
                              </div> 
                          </div>
                      </div>
                  </td>
              </tr>
          </tfoot> <?php
      }

      public function get_list_xml()
      {
          if (count($this->error) == 0 && $this->query != '' && $this->template != '')
          {
              global $obj_bd;
              $consulta = $this->query
                      . " " . $this->where
                      . " " . $this->group
                      . " " . $this->sort;
              $cuantos = $obj_bd->query("SELECT count(*) as RecordCount FROM (" . $this->query . " " . $this->where . ") as cuenta");
              $many = $cuantos[0];
              $total = (int) $many["RecordCount"];

              if ($total > 0)
              {
                  $total_pages = ceil($total / $this->rows);
              }
              else
              {
                  $total_pages = 0;
              }

              $start = (($this->page - 1) * $this->rows);
              $limit = " LIMIT " . $start . ", " . $this->rows;

              $result = $obj_bd->query($consulta . $limit);
              if ($result !== FALSE)
              {
                  $this->set_template(true);
                  $this->set_xml_header();
                  echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
                  echo "<rows>\n";
                  echo "<page>" . $this->page . "</page>\n";
                  echo "<total>" . $total_pages . "</total>\n";
                  echo "<records>" . $total . "</records>\n";
                  foreach ($result as $k => $record)
                  {
                      require $this->template;
                  }
                  echo "</rows>";
              }
          }
      }

      public function get_list_xls()
      {

          if (count($this->error) == 0 && $this->query != '')
          {
              global $Session;

              global $obj_bd;

              $query = $this->query
                      . " " . $this->where
                      . " " . $this->group
                      . " " . $this->sort;

              $result = $obj_bd->query($query);

              if ($result !== FALSE)
              { 
                  $xls = new PHPExcel();

                  // Set document properties
                  $xls->getProperties()->setCreator(SYS_TITLE) 
                          ->setTitle($this->title)
                          ->setSubject($this->title)
                          ->setDescription($this->title . " al día " . date('Y-m-d'))
                          ->setKeywords("")
                          ->setCategory($this->title);


                  // Rename worksheet
                  $xls->getActiveSheet()->setTitle($this->title); 
				  
                  $xls->getDefaultStyle()
                          ->getAlignment()
                          ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                  $xls->setActiveSheetIndex(0);
 
					/*    CABECERA    */
					$last_letter = "A"; 
					foreach ($this->columns as $k => $col ) {
						$ltr = $this->get_column_letter( $k );
						$width = isset( $col['width'] ) && is_numeric( $col['width'] ) ? $col['width'] : 40; 
						
						$xls->getActiveSheet()->getColumnDimension( $ltr )->setWidth($width);
						$xls->getActiveSheet()->setCellValue( $ltr . '1', $col['lbl']);
						
						$last_letter = $ltr;
					} 
					$columna = "A1:" . $last_letter . "1"; 
					$estilo_header = $this->get_estilo_xls('header');
					$xls->getActiveSheet()->setSharedStyle($estilo_header, $columna);
		  
					foreach ($result as $k => $val) {
                      	$r = $k + 2; 
						foreach ($this->columns as $k => $col) {
							$xls->getActiveSheet()->setCellValueExplicit($this->get_column_letter($k) . $r, $val[$col['idx']], PHPExcel_Cell_DataType::TYPE_STRING); 
						}
					}

					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="' . str_replace(array(" ","/"), "_", strtolower( $this->title )) . '.xlsx"');
					header('Cache-Control: max-age=0');
					$objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel2007');
					$objWriter->save('php://output');
					
					
				if($this->which == 'lst_prospect_exp') {
					$ids = str_replace(array('(',')'), '', $this->fval); 
					require_once 'class.admin.prospect.php'; 
					$update = new AdminProspect(0); 
					$update->update_export($ids);
				}
				die();
              }
          }
      }
 
	private function get_column_letter( $k = 0 ){
		$letters = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"); 
		$pre = "";
		$times = floor( $k / count( $letters ) );
		if ( $times > 0 ){
			$pre = $letters[ $times - 1 ];
		}
		$idx = $k % count( $letters );
		$ltr = $pre . $letters[ $idx ]; 
		return $ltr;
	}
 
      private function set_header_xls($xls)
      {
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="reporte-prospectos.xlsx"');
          header('Cache-Control: max-age=0');

          $objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel2007');
          $objWriter->save('php://output');
          die();
      }

      private function get_estilo_xls($cual)
      {
          $resp = new PHPExcel_Style();
 
          if ($cual == 'header') {
              $resp->applyFromArray(
                      array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('argb' => 'CCCCCC')),
                           'font' => array('bold' => true, 'color' => array('argb' => '000000'), 'size' => '11'),
                           'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)
                      )
              );
          }
          else
          {
              $resp->applyFromArray(
                      array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('argb' => 'FFFFFF')),
                           'font' => array('bold' => false, 'color' => array('argb' => '000000'), 'size' => '11'),
                           'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER)
              ));
          }
          return $resp;
      }

      private function set_header_xml()
      {
          header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
          header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
          header("Cache-Control: no-cache, must-revalidate");
          header("Pragma: no-cache");
          header("Content-type: text/xml");
      }

      public function get_array()
      {
          if (count($this->error) == 0 && $this->query != '')
          {
              $this->bd = new IBD;
              $query = $this->query
                      . " " . $this->where
                      . " " . $this->group;
              global $obj_bd;
              $result = $obj_bd->query($query);
              if ($result !== FALSE)
              {
                  return $result;
              }
              else
              {
                  $this->set_error('Ocurrió un error al obtener los registros de la BD', LOG_DB_ERR, 2);
                  return FALSE;
              }
          }
      }

      public function clean()
      {
          $this->where = "";
          $this->columns = array();
          $this->error = array();
      }

      public function get_errors($break = "<br/>")
      {
          $resp = "";
          if (count($this->error) > 0)
          {
              foreach ($this->error as $k => $err)
                  $resp .= " ERROR @ Class DataTable: " . $err . $break;
          }
          return $resp;
      }

      private function set_error($err, $type, $lvl = 1)
      {
          global $Log;
          $this->error[] = $err;
          $Log->write_log(" ERROR @ Class DataTable : " . $err, $type, $lvl);
      }

  }
?>