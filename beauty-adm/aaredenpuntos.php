<?php 
include 'head.php';
include 'librerias_js.php';
?>
<div class="container">
	<h2 class="text-center">Registro de redención de Puntos Chacón</h2>
	<div class="table-responsive">
		<table id="tbred" class="table table-hover table-condensed">
			<thead>
				<tr>
					<th>Cliente</th>
					<th>Salón</th>
					<th>Fecha</th>
					<th>Hora</th>
					<th>No Orden</th>
					<th>Tipo</th>
					<th>Puntos</th>
					<th>Monto</th>
					<th>Usuario</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
<script>
	$(document).ready(function(){
		redencion();
	});
	var  redencion  = function() { 
	   	var tabla = $('#tbred').DataTable({
	      	"ajax": {
	      	"method": "POST",
	      	"url": "reportes/redencionpuntos.php",
	      	"data": {opc: "gentb"},
	      	},
	      	dom: 'Bfrtip',
	        buttons: [ 
	            {
	                extend:    'excel',
	                text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
	                titleAttr: 'Exportar a Excel',
	                exportOptions: {
	                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
	                },
	                title:'BeautySoft - Informe Redencion puntos chacon',
	            }
	        ],
	      "columns":[
	        {"data": "nomcli"},
	        {"data": "salon"},
	        {"data": "fecha"},
	        {"data": "hora"}, 
	        {"data": "orden"}, 
	        {"data": "tipo"}, 
	        {"data": "punto"}, 
	        {"data": "monto",render: $.fn.dataTable.render.number( ',', '.', 0 )}, 
	        {"data": "user"}, 
	      	],"language":{
		        "lengthMenu": "Mostrar _MENU_ registros por página",
		        "info": "<label class='btn btn-info'>_MAX_ Redenciones</label><br>Mostrando página _PAGE_ de _PAGES_",
		        "infoEmpty": "",
		        "infoFiltered": "(filtrada de _MAX_ registros)",
		        "loadingRecords": "<h3><i class='fa fa-spin fa-spinner'></i> Cargando, por favor espere...</h3>",
		        "processing":     "Procesando...",
		        "search": "_INPUT_",
		        "searchPlaceholder":"Buscar...",
		        "zeroRecords":    "No se encontraron registros coincidentes",
		        "paginate": {
		          "next":       "Siguiente",
		          "previous":   "Anterior"
	        	} 
	        },  
	         "columnDefs":[
	              {className:"text-center","targets":[2,3,4,5]},
	              {className:"text-right","targets":[6,7]},
	        ],
	             
	        "order": [[2, "desc"]],
	        "bDestroy": true,
	        "pageLength":10,
	    });
	};
</script>