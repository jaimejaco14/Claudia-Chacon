<?php 
include 'head.php';
include 'librerias_js.php';
?>
<div class="container">
	<h2 class="text-center">Registro de redenciones promoApp</h2>
	<div class="table-responsive">
		<table id="tbred" class="table table-hover table-condensed">
			<thead>
				<tr>
					<th>Cliente</th>
					<th>Salón</th>
					<th>Fecha</th>
					<th>Hora</th>
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
	      	"url": "reportes/redencionapp.php",
	      	"data": {opc: "gentb"},
	      	},
	      	dom: 'Bfrtip',
	        buttons: [ 
	            {
	                extend:    'excel',
	                text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
	                titleAttr: 'Exportar a Excel',
	                exportOptions: {
	                    columns: [ 0, 1, 2, 3 ]
	                },
	                title:'BeautySoft - Informe Redenciones App',
	            }
	        ],
	      "columns":[
	        {"data": "nomcli"},
	        {"data": "salon"},
	        {"data": "fecha"},
	        {"data": "hora"}, 
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
	              {className:"text-center","targets":[2,3]},
	        ],
	             
	        "order": [[2, "desc"]],
	        "bDestroy": true,
	        "pageLength":10,
	    });
	};
</script>