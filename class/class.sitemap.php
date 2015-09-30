<?php

class Sitemap extends Object{

	public $x;
	public $y;
	
	public $computers;
	
	function __construct()
	{
		$this->clean();
		global $Settings;
		$sites = explode(',', $Settings->get_settings_option('sitemap_config') );
		$this->x = $sites[0];
		$this->y = $sites[1];
		
		$this->set_computers();
	}
	
	public function set_computers()
	{
		global $obj_bd;
		$query =	" SELECT id_computer, cm_computer, sm_site,  IF( ls_start IS NULL, 0, ls_start) AS ls_start ".
					" FROM ".PFX_MAIN_DB."sitemap ".
					" INNER JOIN ".PFX_MAIN_DB."computer ON id_computer = sm_cm_id_computer ".
					" LEFT JOIN ".PFX_MAIN_DB."leasing ON ls_cm_id_computer = sm_cm_id_computer AND ls_status > 0 ";
		$resp = $obj_bd->query($query);
		
		if($resp !== FALSE)
		{
			$this->computers = array();
			foreach($resp as $k => $info)
			{
				$computer = new stdClass;
				$computer->id			= $info['id_computer'];
				$computer->computer		= $info['cm_computer'];
				$computer->site			= $info['sm_site'];
				$computer->since		= $info['ls_start'];
				
				$this->computers[] = $computer;
			}
		}
		else
		{
			$this->set_error("Error al acceder a la base de datos", ERR_DB_QRY);
		}
	}
	
	public function set_size($x, $y)
	{
		$this->x = $x;
		$this->y = $y;
		
		global $Settings;
		
		$Settings->save_settings_option('sitemap_config', $this->x.','.$this->y);
	}
	
	public function clean()
	{
		$this->x			= 0;
		$this->y			= 0;
		$this->computers 	= array();
	}
	
	private function get_element_site($site)
	{
		foreach($this->computers as $comp)
		{
			if($comp->site == $site)
				return $comp;
		}
		
		return FALSE;
	}
	
	public function get_layout_html()
	{
		$html = '';
		$site = 1;
		$anchor = ( 12 % $this->x == 0 ? 12 / $this->x : floor(12 / $this->x) );
		for($i = 0; $i < $this->y; $i++)
		{
			$html .= '<div class="row">';
			for($j = 0; $j< $this->x; $j++)
			{
				$cmp = $this->get_element_site($site);
				if($cmp !== FALSE )
				{
					$html .= '<div class="col-lg-'.$anchor.'">
								<div class="box " style="border:1px #00F solid;">
									<div class="box-header">
										<div class="box-name">
											<i class="fa fa-desktop"></i>
											<span>'.$cmp->computer.'</span>
										</div>
										<div class="no-move"></div>
									</div>
									<div class="box-content">
										<div style="min-height: 80px; position: relative;" >
											<div class="col-sm-12 text-center">
												<p>&nbsp;</p>
												<p>&nbsp;</p>
												<button type="button" class="btn btn-default" onclick="asign_computer(0, '.$site.')">
													<i class="fa fa-minus"></i>
													Quitar
												</button>
											</div>
										</div>
									<p>&nbsp;</p>
									</div>
								</div>
							</div>';
				}
				else
				{
					$html .= '<div class="col-lg-'.$anchor.'">
								<div class="box ">
									<div class="box-header">
										<div class="box-name">
											<i class="fa fa-circle"></i>
											<span>Espacio Libre</span>
										</div>
										<div class="no-move"></div>
									</div>
									<div class="box-content">
										<div style="min-height: 80px; position: relative;" >
											<div class="col-sm-12 text-center">
												<p>&nbsp;</p>
												<p>&nbsp;</p>
												<button type="button" class="btn btn-default" onclick="asign_computer(1, '.$site.')">
													<i class="fa fa-plus"></i>
													Asignar
												</button>
											</div>
										</div>
									<p>&nbsp;</p>
									</div>
								</div>
							</div>';
				}
				$site++;
			}
			$html .= '</div>';
		}
		return str_replace(array("\n", "\t"), "", $html);
	}
	
	public function set_sitemap_element($state, $site, $id_computer)
	{
		if( !$site > 0)
		{
			$this->set_error('Invalid Site', ERR_VAL_EMPTY);
			return FALSE;
		}
		
		if( $state > 0 && !$id_computer > 0 )
		{
			$this->set_error('Invalid ID Computer', ERR_VAL_EMPTY);
			return FALSE;
		}
		$action = 'UPDATE';
		global $obj_bd;
		if($state > 0)//insertar
		{
			$values = array(
				":site"			=> $site,
				":id_computer"	=> $id_computer,
				":timestamp"	=> time()
			);
			
			$action = 'INSERT';
			$query = 	" INSERT INTO ".PFX_MAIN_DB."sitemap ".
						" (sm_cm_id_computer, sm_site, sm_status, sm_timestamp) VALUES ".
						" (:id_computer, :site, 1, :timestamp) ";
		}
		else
		{
			$action = 'DELETE';
			$values = array( ":site" => $site);
			$query = 	" DELETE FROM ".PFX_MAIN_DB."sitemap ".
						" WHERE sm_site = :site ";
		}
		
		$resp = $obj_bd->execute($query, $values);
		//$this->set_msg($action.' Computer ['.$id_computer.'] saved.'.$query.print_r($values, TRUE) );
		
		if( $resp !== FALSE)
		{
			$this->set_msg($action.' Computer ['.$id_computer.'] saved.');
			$this->set_computers();
			return TRUE;
		}
		else
		{
			$this->set_error('Error al insertar en la base de datos.', ERR_DB_EXEC);
			return FALSE;
		}
	}
	
	private function get_leasing_script($site, $start)
	{
		$script = '
			<script>
				var times'.$site.' = '.$start.';
				function count_time_'.$site.'()
				{
					if (times'.$site.' > 0)
					{
						var now = Math.floor(Date.now() / 1000);
						var diff = now - times'.$site.';
						
						var hh = Math.floor(diff / 3600);
						diff = diff - (hh * 3600);
						var mm = Math.floor(diff / 60);
						diff = diff - (mm * 60);
						var ss = Math.floor(diff / 1);
						
						mm = "0" + mm;
						ss = "0" + ss;
						
						var time_text = hh + ":" + mm.substr(mm.length-2) + ":" + ss.substr(ss.length-2);
						$("#time_'.$site.'").html(time_text);
					}
				}
				
				function start_count_'.$site.'()
				{
					$("#box_'.$site.'").css("border", "1px #00F solid");
					$("#head_'.$site.'").css("color", "#00F");
					$("#btn_leasing_'.$site.'").prop("disabled", "disabled");
					$("#btn_release_'.$site.'").removeProp("disabled");
					
					set_leasing_'.$site.'();
					
					var date = new Date(times'.$site.'*1000);
					var hours = date.getHours();
					var minutes = "0" + date.getMinutes();
					var seconds = "0" + date.getSeconds();
					var formattedTime = hours + ":" + minutes.substr(minutes.length-2) + ":" + seconds.substr(seconds.length-2);
					$("#start_'.$site.'").html("Entrada: " + formattedTime);
				}
				
				function stop_count_'.$site.'()
				{
					var id_computer = $("#inp_id_computer_'.$site.'").val();
					$.ajax({
						url: "ajax.php",
						type: "POST",
						async: false,
						data:
						{
							resource: 		"sitemap",
							action: 		"set_release",
							id_computer:	id_computer
						},
						dataType: "json",
						success: function(data)
						{
							if (data.success == true )
							{
								var amount = data.amount;
								times'.$site.' = 0;
								$("#box_'.$site.'").css("border", "1px solid #f8f8f8");
								$("#head_'.$site.'").css("color", "#000");
								$("#start_'.$site.'").html("Libre");
								$("#time_'.$site.'").html("00:00:00");
								
								$("#btn_release_'.$site.'").prop("disabled", "disabled");
								$("#btn_leasing_'.$site.'").removeProp("disabled");
								
								$("#inp_total").val(amount);
								$("#mdl_frm_paybox").modal(\'show\');
								
								
								return true;
							}
							else
							{  
								show_error( data.error );
								return false;
							}
						}
					});				
				}
				
				function set_leasing_'.$site.'()
				{
					var id_computer = $("#inp_id_computer_'.$site.'").val();
					$.ajax({
						url: "ajax.php",
						type: "POST",
						async: false,
						data:
						{
							resource: 		"sitemap",
							action: 		"set_leasing",
							id_computer:	id_computer
						},
						dataType: "json",
						success: function(data)
						{
							if (data.success == true )
							{
								times'.$site.' = data.time;
								return true;
							}
							else
							{  
								show_error( data.error );
								return false;
							}
						}
					});
				}
				
				setInterval(count_time_'.$site.', 1000);
			</script>
		';
		
		return $script;
	}
	
	public function get_ciber_html()
	{
		$html = '';
		$site = 1;
		$anchor = ( 12 % $this->x == 0 ? 12 / $this->x : floor(12 / $this->x) );
		for($i = 0; $i < $this->y; $i++)
		{
			$html .= '<div class="row">';
			for($j = 0; $j< $this->x; $j++)
			{
				$cmp = $this->get_element_site($site);
				if($cmp !== FALSE )
				{
					$html .= $this->get_leasing_script($site, $cmp->since);
					$html .= '
						<div class="col-lg-'.$anchor.'">
							<div class="box" id="box_'.$site.'" '.($cmp->since > 0 ? 'style="border:1px #00F solid;"' : '' ).'>
								<div class="box-header" id="head_'.$site.'" '.($cmp->since > 0 ? 'style="color:#00F;"' : '' ).'>
									<div class="box-name">
										<i class="fa fa-desktop"></i>
										<span>'.$cmp->computer.'</span>
										<input type="hidden" id="inp_id_computer_'.$site.'" value="'.$cmp->id.'" />
									</div>
									<div class="no-move"></div>
								</div>
								<div class="box-content">
									<div style="min-height: 80px; position: relative;" >
										<div class="col-sm-12 text-center">
											<p id="start_'.$site.'">'. ($cmp->since > 0 ? "Entrada: ".date('H:i:s', $cmp->since) : 'Libre' ).'</p>
											<p>Tiempo: <strong id="time_'.$site.'">00:00:00</strong></p>
											<button id="btn_leasing_'.$site.'" type="button" class="btn btn-default" onclick="start_count_'.$site.'()" '. ($cmp->since > 0 ? 'disabled="disabled"' : '' ).'>
												<i class="fa fa-toggle-down"></i>
												Renta
											</button>
											<button id="btn_release_'.$site.'" type="button" class="btn btn-default" onclick="stop_count_'.$site.'()" '. ($cmp->since > 0 ? '' : 'disabled="disabled"' ).' >
												<i class="fa fa-toggle-up"></i>
												Libera
											</button>
										</div>
									</div>
								<p>&nbsp;</p>
								</div>
							</div>
						</div>
					';
				}
				else
				{
					$html.= '<div class="col-lg-'.$anchor.'">&nbsp;</div>';
				}
				$site++;
			}
			$html .= '</div>';
		}
		//return str_replace(array("\n", "\t"), "", $html);
		return $html;
	}
}

?>