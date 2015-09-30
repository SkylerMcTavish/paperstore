<?php
require_once DIRECTORY_CLASS . "class.admin.lst.php";	
global $Index; 
$list = new AdminList('lst_admin_users' ); 

$request = new stdClass;
$request->id_profile = (isset($_GET['id_pf']) && $_GET['id_pf'] > 0 ) ? $_GET['id_pf'] : 0;

if ( $request->id_profile > 0 ){
	$list->set_filter( 'id_profile', $request->id_profile ); 
	$list->fidx = 'id_profile';
	$list->fval = $request->id_profile;
}

?>
<script>
	var id_profile 		=  <?php echo $request->id_profile ?>;
	var command 		= '<?php echo $Index->command;  ?>';
	var cmd_frm_contact = '<?php echo FRM_CONTACT;  ?>';
</script>
<div id="dashboard-header" class="row">
	<div class="col-xs-12 ">
		<h2> Usuarios </h2>
	</div>  
</div> 
<div id='users-content' class='row '> 
	<div class="col-xs-12 col-sm-12">
		<div class='row-fluid'>
			<div id="users_links" class="col-xs-12 col-sm-2 pull-right tabs-links" >
				<ul class="nav nav-pills nav-stacked">
					<?php 
						echo $catalogue->get_catalgue_lists( 'profiles', $request->id_profile, $Index->link . '&id_pf=', 'Todos' );
					?>
				</ul>
			</div>
			<div id="users_tabs" class="col-xs-12 col-sm-10 tabs-content">
				<div id="dashboard-overview" class="row" style="visibility: visible; position: relative;"> 
					<div class="col-xs-9">
						<h3 id='lbl_table_users'> 
							<?php
								if ( $request->id_profile > 0 ){
									$profiles = $catalogue->get_catalogue('profiles', TRUE);
									foreach ($profiles as $k => $pf) {
										if ( $pf['id'] == $request->id_profile ){
											$list->set_title($pf['opt']);
											echo $pf['opt'];
										}
									}
								} else {
									echo "Todos los usuarios.";
								}
							?>  
						</h3> 
					</div>
					<div id='fnc_table_users' class='col-xs-3 pull-right ' style='padding-top: 15px;'> 
						<button class="btn btn-default pull-right" type="button" title="Crear Usuario" onclick='edit_user(0);' data-target="#mdl_frm_user" data-toggle="modal">
							<i class="fa fa-plus"></i>
							<span class='hidden-xs hidden-sm' >Crear Usuario</span>
						</button>
					</div> 
					<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
						<table class="table table-striped table-bordered table-hover datatable" id='tbl_usuarios'>
							 <?php $list->get_list_html();  ?>
						</table> 
					</div>
				</div>
			</div> 
			<div class="clearfix"></div>
		</div>
	</div>
</div>
</div>
	</div>
</div>


