<?php 
include '../../cnx_data.php';
include '../head.php';
VerificarPrivilegio("SERVICIOS COLABORADOR", $_SESSION['tipo_u'], $conn);
include '../librerias_js.php';

?>
<style>
	.texto-danger{
		color:red;
	}
	.texto-success{
		color:green;
	}
</style>	
<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">
			<h3><b>Servicios por colaborador y perfil</b></h3>
			Consultar / Asignar / Modificar
		</div>
		<div class="content">
			<div class="col-md-6">
				<div class="input-group-btn">
	                <select id="clb" class="form-control"></select>
	                <button class="btn btn-primary" id="seekser"><i class="fa fa-search"></i></button>
	            </div>
            </div>
		</div>
		<div class="container" id="catser">
			<input type="hidden" id="currperf">
			<div class="perfiles" style="display:none;">
				<h4><b>Perfil actual del colaborador</b></h4>
				<div class="btn-group">
					<?php 
					$sql="SELECT ctccodigo,ctcnombre FROM btycategoria_colaborador where ctcestado=1 order by ctccodigo";
					$res=$conn->query($sql);
					while($row=$res->fetch_array()){
						?>
						<button class="btn btn-default btnperfil" data-id="<?php echo $row['ctccodigo'];?>"><?php echo $row['ctcnombre'];?></button>
						<?php
					}
					?>
				</div><br><br>
				<a class="histoctg" data-toggle="modal" href='#historialctg'><small><b><i class="fa fa-history"></i> Ver historial de Perfiles</b></small></a><br><br>
			</div>
			<div class="panel panel-default" id="contaccordion"></div>
		</div>
	</div>
</div>
<div class="modal fade" id="historialctg">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-history text-primary"></i> Historial de perfiles</h4>
			</div>
			<div class="modal-body">
				<div class="tbhistorial">
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script>
	/*************************asignacion de clase en menu lateral**************************/
	$('#side-menu').children('.active').removeClass("active");  
  	$("#COLABORADORES").addClass("active");
  	$("#SERVICIOS").addClass("active");
  	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip(); 
	});
</script>
<script>
	/*********************************Select busqueda de colaborador***********************/
        $(document).ready(function() {
            $('#clb').selectpicker({
                liveSearch: true,
                title:'Buscar y seleccionar colaborador...'
            });
        });
        $('#clb').on('show.bs.select', function (e) 
        {
            $('.bs-searchbox').addClass('seekclb');
            $('.seekclb .form-control').attr('id', 'seekclb');
        });

        $(document).on('keyup', '#seekclb', function(event) {
            var seek = $(this).val();
            $.ajax({
                url: 'serviciosoper.php',
                type: 'POST',
                data:'opc=seek&texto='+seek,
                success: function(data){
                    var json = JSON.parse(data);
                    var colaboradores = "";
                    for(var i in json){
                        colaboradores += "<option value='"+json[i].codigo+"•"+json[i].cargo+"•"+json[i].codcateg+"'>"+json[i].nombrecol+"</option>";
                    }
                    $("#clb").html(colaboradores);
                    $("#clb").selectpicker('refresh');
                }
            }); 
        });
        $("#clb").change(function(e){
        	$(".perfiles").hide();
        	$(".btnperfil").each(function(){
    			$(this).removeClass('btn-primary').addClass('btn-default');
        	})
        	$("#contaccordion").html('');
        })
    /**************************************************************************************/
    /***************************************Botón de busqueda******************************/
	    $("#seekser").click(function(e){
	    	e.preventDefault();
	    	var clb = $("#clb").val().split("•");
	    	$("#contaccordion").html('');
	    	if(clb[0]>0){
		    	$.ajax({
		    		url: 'serviciosoper.php',
		            type: 'POST',
		            data:'opc=proc&clb='+clb[0]+'&crg='+clb[1],
		            success: function(data){
		            	$(".perfiles").show();
		            	$(".btnperfil").each(function(){
		            		if(clb[2]==$(this).data('id')){
		            			$(this).removeClass('btn-default').addClass('btn-primary');
		            			$("#currperf").val(clb[2])
		            		}
		            	})
		            	$("#contaccordion").html(data);
		            	$('[data-toggle="tooltip"]').tooltip();
		            	countserv();
		            }
		    	})
	    	}else{
	    		swal('Seleccione colaborador!','','error')
	    	}

	    })
    /**************************************************************************************/
</script>
<script>
	/*****habilitar y deshabilitar servicios*****/
	$(document).on('click','.enabser', function(e){
		var ctrl=$(this);
		var idcol=$("#clb").val().split("•");
		var idser=$(this).data('id');
		$.ajax({
			url:'serviciosoper.php',
			data:'opc=updser&idcol='+idcol[0]+'&idser='+idser,
			type:'POST',
			success: function(data){
				if(data=='ok'){
					ctrl.find('.sw').removeClass('fa-times texto-danger').addClass('fa-check texto-success');;
					ctrl.removeClass('enabser').addClass('disabser');
					countserv();
				}else{
					swal('Oops!','Ocurrió un error inesperado, refresque la página e intentelo nuevamente','error');
				}
			}
		})
	});
	$(document).on('click','.disabser', function(e){
		var ctrl=$(this);
		var pap = ctrl.closest('table').attr('name');
		var idcol=$("#clb").val().split("•");
		var idser=ctrl.data('id');
		$.ajax({
			url:'serviciosoper.php',
			data:'opc=disser&idcol='+idcol[0]+'&idser='+idser,
			type:'POST',
			success: function(data){
				if(data=='ok'){
					ctrl.find('.sw').removeClass('fa-check texto-success').addClass('fa-times texto-danger');
					ctrl.removeClass('disabser').addClass('enabser');
					countserv();
				}else{
					swal('Oops!','Ocurrió un error inesperado, refresque la página e intentelo nuevamente','error');
				}
			}
		})
	});
</script>
<script>
	function countserv(){
		var i=1;
    	$('.detser').each(function(){
    		var c=this.getElementsByClassName('disabser').length;
    		$(".titleser"+i+" .cont").html(c);
    		i++;
    	})
	}
</script>
<script>
	/******botones de cambio de perfil******/
	$(".btnperfil").click(function(e){
		e.preventDefault();
		var ctrl=$(this);
		var idctg=ctrl.data('id');
		var idcol=$("#clb").val().split('•');
		var perfact=$("#currperf").val();
		if(idctg!=perfact){
			$.ajax({
				url:'serviciosoper.php',
				type:'POST',
				data:'opc=perf&idctg='+idctg+'&idcol='+idcol[0],
				success:function(data){
					if(data=='ok'){
						$(".btnperfil").removeClass('btn-primary').addClass('btn-default');
						$(".btnperfil").each(function(){
		            		if(idctg==$(this).data('id')){
		            			$(this).removeClass('btn-default').addClass('btn-primary');
		            		}
		            	});
		            	$("#currperf").val(idctg);
		            }else{
		            	swal('Error!','Recargue la página e intentelo nuevamente!','error');
		            }
				}
			})
		}
	})
</script>
<script>
	$(".histoctg").click(function(e){
		e.preventDefault();
		var idcol=$("#clb").val().split('•');
		$(".tbhistorial").html('');
		$.ajax({
			url:'serviciosoper.php',
			type:'POST',
			data:'opc=histo&idcol='+idcol[0],
			success:function(data){
				$(".tbhistorial").html(data);
				$("#historialctg").show();
			}
		})
	})
</script>