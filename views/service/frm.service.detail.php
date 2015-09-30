<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
	<table id='tbl_service_product' class="table table-striped table-bordered table-hover datatable">
		<thead>
			<tr>
				<th>Producto</th>
				<th>Precio</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $service->get_detail_list_html();  ?>
		 </tbody>
	</table> 
</div>