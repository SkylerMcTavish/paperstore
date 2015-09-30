<div class="col-xs-12 col-sm-12" style="min-height: 400px; overflow-x:auto;"> 
	<table id='tbl_sell_product' class="table table-striped table-bordered table-hover datatable">
		<thead>
			<tr>
				<th>ID</th>
				<th>Producto</th>
				<th>Alias</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$html = '';
				if(count($data) > 0)
				{
					foreach($data as $k => $info)
					{
						$html .= '<tr>'.
									'<td>'.$info['id_product'].'</td>'.
									'<td>'.$info['pd_product'].'</td>'.
									'<td>'.$info['pd_alias'].'</td>'.
								'</tr>';
					}
				}
				else
				{
					$html = '<tr><td colspan="3" align="center">No se encontraron productos.</td></tr>';
				}
				
				echo $html;
			?>
		 </tbody>
	</table> 
</div>