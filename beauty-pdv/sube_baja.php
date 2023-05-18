<?php 
	include("./head.php");
	include("./php/conexion.php");

  VerificarPrivilegio("TURNOS (PDV)", $_SESSION['PDVtipo_u'], $conn);
  RevisarLogin();
    
	include("./librerias_js.php");
	$cod_salon = $_SESSION['PDVslncodigo'];
  $salon     = $_SESSION['PDVslnNombre'];

?>

<input type="hidden" value="<?php echo $salon ?>" class="sln">
<input type="hidden" value="<?php echo $cod_salon ?>" id="cod_salon">

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="hpanel hred" style="width: 85%">
				<div class="panel-heading">
					<span>Sube y Baja</span>
          
				</div>
				<div class="panel-body">
						<table class="table table-bordered" id="tbl_crear_subeybaja">
							<thead>
								<tr class="active">
									<th><i class="fa fa-user"></i> Colaborador</th>
									<th><i class="fa fa-cube"></i> Cargo</th>
									<th><i class="fa fa-calendar-o"></i> Turno</th>
									<th title="AÑADIR COLABORADOR A LA COLA"><center><span><button class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Listado Ausentes" id="btnModalAusentes" style="border-radius: 0px"><i class="fa fa-user"></i></button></span></center></th>	
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
            <div class="row">
                <div class="col-md-12">
						        <textarea name="" maxlength="100" id="comentario" class="form-control" rows="3" placeholder="Espacio para comentarios iniciales"></textarea>                  
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                  <textarea name="" maxlength="100" id="comentariof" class="form-control" rows="3" placeholder="Espacio para comentarios finales"></textarea>                  
                </div>
            </div>					
				</div>
				<div class="panel-footer">
					<button type="button" id="btn_fin_subebaja"  class="btn btn-primary">Cerrar Sube y Baja</button>
          <!-- <button type="button" id="btn_comentario" class="btn btn-success" disabled><i class="fa fa-edit"></i></button>  -->
        </div>
				
			</div>
		</div>
	</div>
</div>

<!-- Modal Cerrar Sube y Baja -->
<!-- <div class="modal fade" id="modal_cerrar_sube_baja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cerrar Sube y Baja</h4>
      </div>
      <div class="modal-body">
        <textarea name="" id="txt_comentario_subebaja_final" class="form-control" rows="2" placeholder="Espacio para comentarios de cierre"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_fin_subebaja">Finalizar Sube y Baja</button>
      </div>
    </div>
  </div>
</div>
 -->

<!-- Modal Ver Salon -->
<div class="modal fade" id="modalVerSalon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="title_imagen"><?php echo $_SESSION['PDVslnNombre']?></h4>
      </div>
      <div class="modal-body">
          <img id="imagen_salon" src="" alt="Salón" class="img-responsive">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalServicios" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        			<h4 class="modal-title">Servicios del colaborador</h4>
				</div>
				<div class="modal-body">
					<div class="panel panel-info">
  						<div class="panel-heading">
    						<h3 class="panel-title">Servicios Autorizados</h3>
  						</div>
					  	<div class="panel-body">
					    	<div class="row">
								<div class="col-xs-3">
									<img src="" id="imagenColaboradorServicio" alt="Imagen colaborador" class="img-thumbail img-responsive" width="180" height="180">
								</div>
								<div class="col-xs-9">
								    <div class="form-group">
										<div class="col-sm-12">
											<input type="hidden" id="txtCodigoColaborador">
										</div>
									</div>
									<div class="form-group">									
										<!-- <label class="label label-success" id="nombreColaboradorServicio"></label> -->					
									</div>
                  <div class="form-group">                  
                      <div id="listaData"></div>         
                  </div>
								<!--   <div class="form-group">
                  <label class="label label-warning" id="cargoColaboradorServicio"></label>
                
                </div> -->
									
								</div>
							</div> 
					  	</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive" id="">                             
							    	<table class="table table-hover table-bordered table-striped" id="tblLista" style="width: 100%">
                        <thead>
                          <tr class="info">
                            <th>Servicio</th>
                            <th>Duración</th> 
                          </tr>         
                        </thead>

                        <tbody>

                        </tbody>                        
                    </table>	                  
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" title="Cerrar ventana">Cerrar</button>
				</div>
			</div>
		</div>
	</div>


<!-- Modal -->
<div class="modal fade" id="modalReporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="myModalLabel">Seleccionar Tipo Reporte</h4>
      </div>
      <div class="modal-body">
         <div class="panel panel-info">
             <div class="panel-heading">
                 <h3 class="panel-title"></h3>
             </div>
             <div class="panel-body">
                    <select name="" id="selReport" class="form-control" required="required">
                        <option value="1">AGENDA</option>
                        <option value="2">BIOMÉTRICO</option>
                    </select>
             </div>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnIr">Ir</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Ver Salon -->
<div class="modal fade" id="mdlBackDohor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="title_imagen">Dev_BckDor</h4>
      </div>
      <div class="modal-body">
          <form action="" method="POST" role="form">
          
          	<div class="form-group">
          		<label for="">Pass</label>
          		<input type="password" class="form-control" id="pass" placeholder="*/*/*/*/*">
          		<button type="button" id="btn_del" style="display: none" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-trash"></i> Del</button>
          	</div>           
          	<button type="button" id="btn_back_door" class="btn btn-primary">Submit</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="btn_clean" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div> -->



<!-- Modal -->
<div class="modal fade" id="modalAusentes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width: 85%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-th-list" aria-hidden="true"></i>  Listado de Colaboradores No Laboran</h4>
      </div>
      <div class="modal-body">
         <div class="table-responsive">
              <table class="table table-hover table-bordered" id="tblColNoLab" >
                <thead>
                  <tr>
                    <th>Colaborador</th>
                    <th>Cargo</th>
                    <th>Perfil</th>
                    <th>Tipo</th>
                    <th>Programación</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<style>
	th,td{ 
		white-space: nowrap;
	}

	.mybutton{
		border-radius: 0px!important;
	}

	.selected{
		background-color: #ffeaea;
    font-weight: bold;
	}



	.deselected{
		background-color: red;
	}
</style>

<script src="js/sube_baja.js"></script>

<script>
$(document).ready(function() {     

   /* $(document).on('click', '#btn_paginar', function() {
          var data = $(this).data("id");
          $.ajax({
          type: "POST",
          url: "php/sube_baja/lista_servicios.php",
          data: {page: data, cod: $('#txtCodigoColaborador').val()},
          success: function (data) {
             $('#list').html(data);
          }
      });
    });*/



/*$(document).keydown(function(e) {

if(e.shiftKey && e.altKey && e.keyCode == 80)
{
  $('#mdlBackDoor').modal("show");
}

});*/


/*$(document).on('click', '#btn_back_door', function() {
  var pass = $('#pass').val();
  $.ajax({
  		url: 'php/sube_baja/back_door.php',
  		method: 'POST',
  		data: {p: pass},
  		success: function (data) {
  			if (data == 1) {
  				$('#btn_del').css("display", "block");
  				$('#pass').css("display", "none");
  				$('#btn_back_door').css("display", "none");
  				$('#pass').val("");
  			}else{
  				swal("You can not access this website." , "", "error");
  				$('#mdlBackDoor').modal("hide");
  				$('#pass').val("");
  			}
  		}
  });
});*/

$(document).on('click', '#btn_del', function() {
	var sln = $('#cod_salon').val();

	$.ajax({
		url: 'php/sube_baja/del_ini_subebaja.php',
		method: 'POST',
		data: {sln:sln},
		success: function (data) {
			if (data == 1) {
				alert("Deleted");
			    location.reload();
			}
		}
	});

});


 $(document).on('click', '.sln_nombre', function() {
        var id = $('#cod_salon').val();
        $('#modalVerSalon').modal("show");
        $('body').removeClass("modal-open");
        $('body').removeAttr("style");

       $.ajax({
            url: 'php/sube_baja/cargar_imagen_sln.php',
            method: 'POST',
            data: {id:id},
            success: function (data) {
                var array = eval(data);
                for(var i in array){
                    $('#title_imagen').html("Salón "+array[i].nombre);
                    $("#imagen_salon").removeAttr("src");        
                    $('#imagen_salon').attr("src", "../contenidos/imagenes/salon/"+array[i].imagen);
                }
            }
       });
});
});

 $(document).ready(function() {
        $(document).on('click', '.selector', function(event) {
            var url = $(this).data("url");
            var res = url.substr(19); 
            
            $.ajax({
                url: 'bloquear_pantalla.php',
                method: 'POST',
                data: {url:url},
                success: function (data) 
                {
          
                    window.location="bloquear_pantalla.php?url="+res+"";
                }
            });
        });
    });



$(document).on('click', '.btnModalReporte', function(event) 
{
    $('#modalReporte').modal("show");
});

$(document).on('click', '#btnIr', function(event) 
{
    var sel = $('#selReport').val();

    switch (sel) 
    {
        case '1':
            window.location="reporteAgenda.php";
            break;

        case '2':
            window.location="reporteBiometrico.php";
            break;
        default:
            // statements_def
            break;
    }
});

</script>
