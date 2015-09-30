<?php global $catalogue; ?>

<!-- Modal --> 
<div id="mdl_frm_user" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_user" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_user_title" class="modal-title">Edición de Usuario</h4>
			</div>
			<form id="frm_user" class="form-horizontal" role="form" method="post" action="users.php" >
				<div class="modal-body">   
					<fieldset> <div id="inf_pop_div">
						<legend> Usuario </legend> 
							<div class="form-group" >
								<div class="hidden-xs col-sm-1"> &nbsp; </div> 
								<div class="col-xs-12 col-sm-4">
									<label class="control-label">Usuario</label>
									<input type="email" id="inp_user" name="user" class="form-control" value="" required  data-validation="required email unique-user" />
								</div> 
								<div class="hidden-xs col-sm-2"> &nbsp; </div>
								<div class="col-xs-12 col-sm-4">
									<label class="control-label">Perfil</label>
									<select id="inp_profile" name="profile" class="form-control" required data-validation="required select-option" > 
										<?php echo $catalogue->get_catalgue_options('profiles'); ?>
									</select>
								</div>
							</div>	
							<div class="form-group">

								<div class="hidden-xs col-sm-1"> &nbsp; </div>
								<div class="col-xs-12 col-sm-4">
									<label class="control-label">JDE</label>
									<input type="text" id="inp_jde" name="jde" class="form-control" value=""  />
								</div>
							</div>
							</div>
							<div class="form-group" id='opc_password'>
								<div class="hidden-xs col-sm-1"> &nbsp; </div>
								<div class="col-xs-12 col-sm-10">
									<label class="control-label"> Contraseña </label>
									<div class="radio"> 
										<label> 
											<input type="radio" name="pwd_option" id="inp_pwd_option_manual" value="pwd_manual" onchange="change_password_option(this.value);" /> 
											Asignar contraseña manualmente. 
										</label> 
									</div> 
									<div id='div_password' class="form-group " style="display:none;" >
										<label class="col-sm-2 control-label">Contraseña:</label>
										<div class="col-sm-4">
											<input class="form-control" type="password" id="inp_password" name="inp_password" data-validation-optional="true"  />
										</div>
										<label class="col-sm-2 control-label"> Confirmación contraseña:</label>
										<div class="col-sm-4">
											<input class="form-control" type="password" id="inp_password_match" data-validation="password-match" data-validation-optional="true" data-validation-target="inp_password" />
										</div>
									</div> 
									<div class="radio"> 
										<label> 
											<input type="radio" name="pwd_option" id="inp_pwd_option_email" value="pwd_email" onchange="change_password_option(this.value);" /> 
											Generar contraseña y enviar por E-mail. 
										</label>
									</div>
								</div>
							</div> 
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_id_user' name='id_user' value='' />
					<input type='hidden' id='inp_action'  name='action' value='edit_user' />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_user_edition();">
						Cancelar
					</button>
					<button type="submit" class="btn btn-default" >
						Aceptar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>  

<!-- Password Change User Detail Modal -->

<div id="mdl_form_pass" class="modal fade"  role="dialog" aria-labelledby="mdl_detail_pass" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">	
			<div class="modal-header">
				<form id="frm_pass" class="form-horizontal" role="form" method="post" action="users.php" >					
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_user_title" class="modal-title">Edición de Password</h4>
			</div>		
			<div class="modal-body"><fieldset> 
			<label class="col-sm-2 control-label">Contraseña:</label>
			<div class="col-sm-4">
				<input class="form-control" type="password" id="frm_inp_password" name="inp_password" data-validation-optional="true"  />
			</div>
			<label class="col-sm-2 control-label"> Confirmación contraseña:</label>
			<div class="col-sm-4">
				<input class="form-control" type="password" id="frm_inp_password_match" data-validation="password-match" data-validation-optional="true" data-validation-target="inp_password" />
				</fieldset> 
			</div>
			
			<div class="modal-footer">
					<input type='hidden' id='form_pass_inp_id_user' name='id_user' value='' />
					<input type='hidden' id='form_pass_inp_action'  name='action' value='chpassword' />
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel_user_edition();">Cancelar</button>
					<button type="submit" class="btn btn-default" >Aceptar</button>
					
				</div>
				</form>
		</div>
	</div>
</div>