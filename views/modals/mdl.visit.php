<div id="mdl_frm_visit" class="modal fade"  role="dialog" aria-labelledby="mdl_frm_visit" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clean_form();"> &times; </button>
				<h4 id="mdl_frm_company_title" class="modal-title">Crear una Visita</h4>
			</div>
			<form id="frm_booking" class="form-horizontal" role="form" method="post" action="no" >
				<div class="modal-body">   
					<fieldset>  
						<div class="col-xs-12">
							<div class="form-group"> 							
								<label class="control-label">Hora de Inicio</label><br>								
								<input type="text" id="inp_time_start" name="time_start" class="form-control" onfocus="timend();"/><br>								
							</div>  
						</div> 
						<div class="col-xs-12">
							<div class="form-group"> 							
								<label class="control-label">Hora de Fin</label><br>
								<input type="text" id="inp_time_end" name="time_end" class="form-control"/>
							</div>  
						</div>  
					</fieldset> 
				</div>
				<div class="modal-footer">
					<input type='hidden' id='inp_fecha2' name='fecha' value='<?php echo $_GET['fecha']; ?>' />
					<input type='hidden' id='inp_user2'  name='usuario' value='<?php echo $_GET['user']; ?>' />
					<input type='hidden' id="inp_id_pdv" name="id_pdv" value=""/>
					<input type='hidden' id="inp_pdv" name="pdv" value=""/>
					<input type='hidden' id="inp_latitude" name="id_pdv" value=""/>
					<input type='hidden' id="inp_longitude" name="pdv" value=""/>
					<button type="button" class="btn btn-default" data-dismiss="modal" >Cancelar</button>
					<button type="button" class="btn btn-default" onclick="booking();" >Aceptar</button>
				</div>
			</form>		
		</div>
	</div>
</div>