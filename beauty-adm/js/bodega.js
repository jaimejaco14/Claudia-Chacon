 /*====================================
 =            Activar Menu            =
 ====================================*/
 
 	$("#side-menu").children('.active').removeClass('active');  
  	$("#INVENTARIO").addClass("active");
  	$("#BODEGA").addClass("active"); 
 
 /*=====  End of Activar Menu  ======*/

 $(document).ready(function() {
 	$('#modaladicion_bodega').on('shown.bs.modal', function () {
		$('#nombre_bodega').focus();
	});
 });

 $(document).on('click', '#btn_modal_bod', function() {
 	  
 });

 $(document).on('blur', '#nombre_bodega', function() {
 	  var nombre = $('#nombre_bodega').val();
 	  $.ajax({
          url: 'bod_check_nombre.php',
          method: 'POST',
          data: {nombre: nombre},
          success: function (data) {
          	  if (data == 1) {
          	  	  	swal({
					  	title: "Ya existe un registro con este nombre",
					  	text: "Intente con otro",
					  	type: "warning",
					  	confirmButtonColor: "#DD6B55",
  						confirmButtonText: "OK",
  						closeOnConfirm: true
					},
					function(){
							$('#nombre_bodega').focus();	
					});
          	  }
          }
 	  });
 });

 $(document).on('blur', '#alias', function() {
 	  var alias = $('#alias').val();
 	  $.ajax({
          url: 'bod_check_alias.php',
          method: 'POST',
          data: {alias: alias},
          success: function (data) {
          	  if (data == 1) {
          	  	  swal({
					  title: "Ya existe un registro con este alias",
					  text: "Intente con otro",
					  type: "warning",
					  confirmButtonColor: "#DD6B55",
					},
					function(){
  							$('#alias').focus();					
					});
          	  }
          }
 	  });
 });


 $(document).on('click', '#btn_guardar_bodega', function() {
 	   var nombre = $('#nombre_bodega').val();
 	   var alias  = $('#alias').val();
 	   var cod    = $('#consec').val();
		 if (nombre == "") {
		 	  	  swal({
					  title: "Este campo es obligatorio",
					  type: "warning",
					  confirmButtonColor: "#DD6B55",
					},
					function(){
  							$('#nombre_bodega').focus();
						
					});
		 	  }else{
		 	  		if (alias == "") {
		 	  			swal({
						  title: "Este campo es obligatorio",
						  type: "warning",
						  confirmButtonColor: "#DD6B55",
						},
						function(){
	  							$('#alias').focus();
							
						});
		 	  		}else{
		 	  			$.ajax({
		 	  				url: 'bodega__insertar.php',
		 	  				method: 'POST',
		 	  				data: {nombre: nombre, alias: alias, cod: cod},
		 	  				success: function (data) {
		 	  					if (data == 1) {
		 	  						swal({
										  	title: "Ya existe un registro con este nombre",
										  	text: "Intente con otro",
										  	type: "warning",
										  	confirmButtonColor: "#DD6B55",
					  						confirmButtonText: "OK",
					  						closeOnConfirm: true
										});
		 	  					}else{
		 	  						if (data ==2) {
		 	  							swal({
											  title: "Ya existe un registro con este alias",
											  text: "Intente con otro",
											  type: "warning",
											  confirmButtonColor: "#DD6B55",
											});
		 	  						}else{
		 	  							swal({
										  	title: "Ingreso correcto",
										  	type: "success",
					  						confirmButtonText: "OK",
					  						closeOnConfirm: true
										});
										$('#modaladicion_bodega').modal("hide");
											$('#nombre_bodega').val("");
											$('#alias').val("");
											tbl_bodegas();		
										    //location.reload();

		 	  						}
		 	  					}
		 	  				}
		 	  			});
		 	  		}
		 	  }
 });


 $(document).on('click', '#btn_edit_bodega', function() {
 	  var id = $(this).data("id");

 	  $.ajax({
          url: 'bodega_editar.php',
          method: 'POST',
          data: {id:id},
          success: function (data) {
          	console.log(data);
          	  var array = eval(data);
          	  for(var i in array){
          	  	$('#cod_bod').val(array[i].id);
          	  	$('#nom_bodega').val(array[i].nom);
          	  	$('#nom_alias').val(array[i].ali);
          	  }
          }
 	  });
 });


 $(document).on('click', '#btn_guardar_mod_bod', function() {
 	 var id = $('#cod_bod').val();
 	 var nombre_bod = $('#nom_bodega').val();
 	 var nombre_alias = $('#nom_alias').val();

 	 if (nombre_alias == "") {
 	 	 swal("Debe ingresar el nombre");
 	 }else{
 	 	if (nombre_alias == "") {
 	 		 swal("Debe ingresar el alias");
 	 	}else{
 	 		$.ajax({
 	 			url: 'guardar_mod_bodega.php',
 	 			method: 'POST',
 	 			data: {id:id, nombre_bod:nombre_bod, nombre_alias:nombre_alias},
 	 			success: function (data) {
 	 				 if (data == 1) {
 	 				 	swal("Ya existe un registro con este nombre.");
 	 				 }else{
 	 				 	if (data ==2) {
 	 				 		swal("Ya existe un registro con este alias."); 	 				 		
 	 				 	}else{
 	 				 		if (data == 3) {	 	 				 	
		 	 				 	$('#nom_bodega').val("");
								$('#nom_alias').val("");
								$('#modal_editar_bodega').modal("hide");
								location.reload();
								tbl_bodegas();								
 	 				 		}
 	 				 	}
 	 				 }
 	 			}
 	 		});
 	 	}
 	 }
 });

 $(document).on('click', '#btn_elim_bodega', function() {
 	var $row = $(this).closest("tr");    // Find the row
    var $id = $row.find(".sorting_1").text(); // Find the text
    var id = $id;
	swal({
		  title: "¿Desea eliminar bodega?",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Eliminar",
		  cancelButtonText: "Cancelar",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm){
		  if (isConfirm) {
		  	$.ajax({
		 		url: 'bodega_eliminar.php',
		 		method: 'POST',
		 		data: {id:id},
		 		success: function (data) {
		 			if (data == 1) {
		    			swal("Eliminado!", "Se ha eliminado la bodega.", "success");
		    			tbl_bodegas();
		 			}
		 		}
		 	});
		  }else{
		  	swal("Cancelado");
		  } 
		});
 });

 
