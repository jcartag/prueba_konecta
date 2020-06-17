<!DOCTYPE html>
<html>
	<head>
		<title>Prueba_Konecta</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<br />
			
			<h3 align="center">Prueba_konecta_php_react</h3>
			<br />
			<div align="right" style="margin-bottom:5px;">
				<button type="button" name="add_button" id="add_button" class="btn btn-success btn-xs">Add</button>
			</div>

			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Referencia</th>
							<th>Precio</th>
							<th>Peso</th>
							<th>Categoria</th>
							<th>Stock</th>
							<th>Fecha_inicial</th>
							<th>Fecha_final</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</body>
</html>
<div id="apicrudModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" id="api_crud_form">
				<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        	<h4 class="modal-title">Agregar datos</h4>
		      	</div>
		      	<div class="modal-body">
		      		<div class="form-group">
			        	<label>Ingrese el nombre</label>
			        	<input type="text" name="nombre" id="nombre" class="form-control" />
			        </div>
			        <div class="form-group">
			        	<label>Ingrese la referencia</label>
			        	<input type="text" name="referencia" id="referencia" class="form-control" />
			        </div>
					<div class="form-group">
			        	<label>Ingrese el precio</label>
			        	<input type="text" name="precio" id="precio" class="form-control" />
			        </div>
					<div class="form-group">
			        	<label>Ingrese el peso</label>
			        	<input type="text" name="peso" id="peso" class="form-control" />
			        </div>
					<div class="form-group">
			        	<label>Ingrese la categoria</label>
			        	<input type="text" name="categoria" id="categoria" class="form-control" />
			        </div>
					<div class="form-group">
			        	<label>Ingrese el stock</label>
			        	<input type="text" name="stock" id="stock" class="form-control" />
			        </div>
					<div class="form-group">
			        	<label>Ingrese la Fecha_inicial</label>
			        	<input type="text" name="fecha_inicial" id="fecha_inicial" class="form-control" />
			        </div>
					<div class="form-group">
			        	<label>Ingrese la Fecha final</label>
			        	<input type="text" name="fecha_final" id="fecha_final" class="form-control" />
			        </div>
			    </div>
			    <div class="modal-footer">
			    	<input type="hidden" name="hidden_id" id="hidden_id" />
			    	<input type="hidden" name="action" id="action" value="insert" />
			    	<input type="submit" name="button_action" id="button_action" class="btn btn-info" value="Insert" />
			    	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      		</div>
			</form>
		</div>
  	</div>
</div>


<script type="text/javascript">
$(document).ready(function(){

	fetch_data();

	function fetch_data()
	{
		$.ajax({
			url:"fetch.php",
			success:function(data)
			{
				$('tbody').html(data);
			}
		})
	}

	$('#add_button').click(function(){
		$('#action').val('insert');
		$('#button_action').val('Insert');
		$('.modal-title').text('Add Data');
		$('#apicrudModal').modal('show');
	});

	$('#api_crud_form').on('submit', function(event){
		event.preventDefault();
		if($('#nombre').val() == '')
		{
			alert("ingrese el nombre");
		}
		else if($('#referencia').val() == '')
		{
			alert("Ingrese la referencia");
		}
		else if($('#precio').val() == '')
		{
			alert("Ingrese el precio");
		}
		else if($('#peso').val() == '')
		{
			alert("Ingrese el pero");
		}
		else if($('#categoria').val() == '')
		{
			alert("Ingrese la categoria");
		}
		else if($('#stock').val() == '')
		{
			alert("Ingrese el stock");
		}
		else if($('#Fecha_inicial').val() == '')
		{
			alert("Ingrese la fecha_inicial");
		}
		else if($('#fecha_final').val() == '')
		{
			alert("Ingrese la fecha_final");
		}
		else
		{
			var form_data = $(this).serialize();
			$.ajax({
				url:"action.php",
				method:"POST",
				data:form_data,
				success:function(data)
				{
					fetch_data();
					$('#api_crud_form')[0].reset();
					$('#apicrudModal').modal('hide');
					if(data == 'insert')
					{
						alert("Datos ingresados");
					}
					if(data == 'update')
					{
						alert("Data actualizados");
					}
				}
			});
		}
	});

	$(document).on('click', '.edit', function(){
		var id = $(this).attr('id');
		var action = 'fetch_single';
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(data)
			{
				$('#hidden_id').val(id);
				$('#nombre').val(data.nombre);
				$('#referencia').val(data.referencia);
				$('#precio').val(data.precio);
				$('#peso').val(data.peso);
				$('#categoria').val(data.categoria);
				$('#stock').val(data.stock);
				$('#fecha_inicial').val(data.fecha_inicial);
				$('#fecha_final').val(data.fecha_final);
				$('#action').val('update');
				$('#button_action').val('Update');
				$('.modal-title').text('Edit Data');
				$('#apicrudModal').modal('show');
			}
		})
	});

	$(document).on('click', '.delete', function(){
		var id = $(this).attr("id");
		var action = 'delete';
		if(confirm("Estás seguro de que deseas eliminar los datos"))
		{
			$.ajax({
				url:"action.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data)
				{
					fetch_data();
					alert("Datos eliminados");
				}
			});
		}
	});

});
</script>