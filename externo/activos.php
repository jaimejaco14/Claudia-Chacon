<?php
session_start();
include '../cnx_data.php';
$idact=$_GET['idact'];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#c9ad7d" />

    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Expires" CONTENT="-1">

    <!-- Page title -->
    <title>Beauty Soft ERP</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" type="image/ico" href="../contenidos/imagenes/favicon.png" />
    <link rel="stylesheet" href="../lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../lib/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="../lib/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="../lib/vendor/toastr/build/toastr.min.css" />
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../lib/styles/style.css">
    <link rel="stylesheet" href="../lib/styles/static_custom.css">

    <script src="../lib/vendor/jquery/dist/jquery.min.js"></script>
	<script src="../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
	<script src="../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body class="fixed-navbar fixed-sidebar hide-sidebar" style="position: relative;">
<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        <span>
            BEAUTY
        </span>
    </div>
    <div class="content">
    	<a data-toggle="modal" href='#modal-login'><span class="fa fa-support pull-right"></span></a>
    </div>
</div>

<!-- MODAL LOGIN -->
<div class="modal fade" id="modal-login">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><span class="fa fa-lock"></span> Codigo de seguridad</h4>
			</div>
			<div class="modal-body">
				<input id="secure" class="form-control text-center" type="password">
			</div>
			<div class="modal-footer">
				<button id="unlock" type="button" class="btn btn-default">Ok</button>
			</div>
		</div>
	</div>
</div>

<!-- MODAL DE SERVICIO -->
<div class="modal fade" id="modal-servicio">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><span class="fa fa-ambulance"></span> ORDEN DE SERVICIO</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
					<tbody>
                        <tr><th>Activo:</th><td id="nomact2"></td></tr>
                        <tr><th>Ubicación:</th><td id="ubiact2"></td></tr>
                        <tr><th>Actividad:</th><td id="actact2"></td></tr>
                    </tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary">Ejecutar</button>
			</div>
		</div>
	</div>
</div>
<?php
    $sql = "SELECT  a.actcodigo,a.actnombre,a.marcodigo,ma.marnombre,a.actmodelo,a.actespecificaciones,a.actgenerico,a.actimagen,a.actserial,a.actdescripcion,a.actfechacompra,a.prvcodigo,ter.trcrazonsocial,a.fabcodigo,fa.fabnombre,a.paicodigo,pa.painombre,a.actfechainicio,a.actcodigoexterno,a.actcosto_base,a.actcosto_impuesto,a.sbgcodigo,tp.tianombre,st.sbtnombre,ga.granombre,sg.sbganombre,sg.sbgubicacionetiqueta,a.pracodigo,pr.pranombre,a.actreq_mant_prd,a.actfreq_mant,a.actreq_rev_prd,a.actfreq_rev,a.actgtia_tiempo,a.actgtia_tiempo_valor,a.unacodigo_tiempo,un.unanombre un1,a.actgtia_uso,a.actgtia_uso_valor,a.unacodigo_uso,un2.unanombre un2,a.actreq_insumos,a.actreq_repuestos,l.lugnombre,are.arenombre
        FROM btyactivo a
        join btyactivo_subgrupo sg on sg.sbgcodigo=a.sbgcodigo
        join btyactivo_grupo ga on ga.gracodigo=sg.gracodigo
        join btyactivo_subtipo st on st.sbtcodigo=ga.sbtcodigo
        join btyactivo_tipo tp on tp.tiacodigo=st.tiacodigo
        join btyactivo_marca ma on ma.marcodigo=a.marcodigo
        join btyactivo_fabricante fa on fa.fabcodigo=a.fabcodigo
        join btyactivo_prioridad pr on pr.pracodigo=a.pracodigo
        join btypais pa on pa.paicodigo=a.paicodigo
        join btyproveedor po on po.prvcodigo=a.prvcodigo
        join btyactivo_unidad un on a.unacodigo_tiempo=un.unacodigo
        join btyactivo_unidad un2 on a.unacodigo_uso=un2.unacodigo
        join btytercero ter on po.trcdocumento=ter.trcdocumento
	    join btyactivo_movimiento mo on mo.actcodigo=a.actcodigo
	    join btyactivo_area are on are.arecodigo=mo.arecodigo_nue
		join btyactivo_lugar l on l.lugcodigo=are.lugcodigo
        WHERE a.actcodigo =$idact and mo.mvaconsecutivo=(select max(ma.mvaconsecutivo) from btyactivo_movimiento ma where ma.actcodigo=$idact and ma.mvaestado='EJECUTADO')";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
            # code...
            $codigo   = $row['actcodigo'];
            $nombre   = $row['actnombre'];
            $marca    = $row['marcodigo'];
            $nommarca = $row['marnombre'];
            $modelo   = $row['actmodelo'];
            $espec    = $row['actespecificaciones'];
            $img      =$row['actimagen'];
            $gener    =$row['actgenerico'];
            $serial   = $row['actserial'];
            $descr    = strtoupper($row['actdescripcion']);
            
            $fecha    = $row['actfechacompra'];
            $prove    = $row['trcrazonsocial'];
            $fab      = $row['fabnombre'];
            $pais     = $row['painombre'];
            $fechini  = $row['actfechainicio'];
            $cod_ext  = $row['actcodigoexterno'];
            $costo    = $row['actcosto_base'];
            $impu     = $row['actcosto_impuesto'];

            $nomtia   = $row['tianombre'];
            $subtia   =$row['sbtnombre'];
            $nomgru   =$row['granombre'];
            $subgru   =$row['sbganombre'];
            $ubicQR   =$row['sbgubicacionetiqueta'];

            $rqmtto   =$row['actreq_mant_prd'];
            $fqmtto   =$row['actfreq_mant'];
            $rqrev    =$row['actreq_rev_prd'];
            $fqrev    =$row['actfreq_rev'];

            $pri      = $row['pracodigo'];
            $prinom   = $row['pranombre'];

            $garti    =$row['actgtia_tiempo'];
            $gartival =$row['actgtia_tiempo_valor'];
            $gartiuni =$row['un1'];

            $garuso   =$row['actgtia_uso'];
            $garusoval=$row['actgtia_uso_valor'];
            $garusouni=$row['un2'];

            $insu     =$row['actreq_insumos'];
            $repu     =$row['actreq_repuestos'];  

            $lugar	  =$row['lugnombre'];
            $area	  =$row['arenombre'];
    }

?>
<style>
  .panel-title{cursor:pointer;}
</style>
<div class="content"><br><br><br><br>	
	<div class="row">
	        <div class="panel-group" id="accordion">
	          	<!-- Generalidades -->
	              <div class="panel panel-default">
	                <div class="panel-heading head1" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
	                  <h4 class="panel-title ">
	                      Generalidades <small class="tit1" style="color:red;"></small> <i class="pull-right fa fa-angle-double-down"></i>
	                  </h4>
	                </div>
	                <div id="collapse1" class="panel-collapse collapse in">
	                  <div class="panel-body">
	                      <div class="col-md-6">
	                            <!-- nombre -->
	                                <div class="form-group">
	                                  <div class="col-md-2">
	                                    <label>Codigo</label>
	                                    <input  class="form-control text-center" type="text" name="" id="actcodigo" value="<?php echo $codigo;?>" readonly>
	                                  </div>
	                                  <div class="col-md-10">
	                                    <label>Nombre</label>
	                                    <input  class="form-control text-uppercase" type="text" name="act_name" id="act_name" placeholder="Ingrese nombre" data-error="camp obligatorio" value="<?php echo $nombre;?>" readonly>                                   
	                                  </div>
	                                </div><br><br><br><br>
	                            <!-- marca -->
	                                <div class="form-group" id="oldmar">
	                                    <table class="table table-bordered">
	                                        <tr>
	                                            <th>Marca</th>
	                                            <td><?php echo $nommarca ; ?></td>

	                                        </tr>
	                                    </table>
	                                </div>
	                            <!-- modelo -->
	                              <div class="form-group">
	                                  <label>Modelo</label>
	                                  <input  class="form-control text-uppercase" type="text" id="modelo" name="modelo" value="<?php echo $modelo;?>" readonly>
	                              </div>
	                            <!-- espec -->
	                               <div class="form-group">
	                                  <label>Especificaciones</label>
	                                  <input  class="form-control text-uppercase" type="text" id="especificaciones" name="especificaciones" value="<?php echo $espec;?>" readonly>
	                              </div>
	                            <!-- Generico -->
	                                <div class="form-group">
	                                    <label class="control-label">Activo genérico</label><br>
	                                    <input class="form-control" id="generico" name="generico" class="generico" type="text" readonly>
	                                </div>
	                      </div>
	                      <div class="col-md-6">
	                          <!-- img  box-->
	                              <div class="col-md-12">
	                                  <div class="col-sm-6 col-md-3">
	                                      <img src="../contenidos/imagenes/activo/<?php echo $img;?>?<?php echo time(); ?>"  id="imgact" class="img-rounded img-responsive" onerror="this.src='../contenidos/imagenes/default.jpg';">
	                                  </div>
	                              </div>
	                                <br><br><br>
	                          <!-- SN -->
	                                <div class="form-group">
	                                  <label>Serial</label>
	                                  <input  class="form-control text-uppercase" type="text" id="serial" name="serial" value="<?php echo $serial;?>" readonly>
	                                </div>
	                          <!--desc -->
	                              <div class="form-group">
	                                  <label>Descripción</label>
	                                  <textarea class="form-control text-uppercase" id="marcadescripcion" name="marcadescripcion" type="text"  style="resize: none;" value="<?php echo $descr;?>" readonly><?php echo $descr;?></textarea>
	                              </div>                   
	                      </div>
	                  </div>
	                  </div>
	              </div>
	          	<!-- Datos de compra -->
	              <div class="panel panel-default">
	                <div class="panel-heading head2" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
	                  <h4 class="panel-title ">
	                    Datos de compra <small class="tit2" style="color:red;"></small><i class="pull-right fa fa-angle-double-down"></i>
	                  </h4>
	                </div>
	                <div id="collapse2" class="panel-collapse collapse">
	                  <div class="panel-body">
	                    <div class="col-md-6">
	                          
	                          <!-- proveedor -->
	                                <div class="form-group" id="oldpro">
	                                    <table class="table table-bordered">
	                                        <tr>
	                                            <th>proveedor</th>
	                                            <td><?php echo $prove ; ?></td>

	                                        </tr>
	                                    </table>
	                                </div>
	                                
	                          <!-- Fabricante -->
	                                <div class="form-group" id="oldfab">
	                                    <table class="table table-bordered">
	                                        <tr>
	                                            <th>Fabricante</th>
	                                            <td><?php echo $fab ; ?></td>

	                                        </tr>
	                                    </table>
	                                </div>
	                          <!-- pais -->
	                                <div class="form-group" id="oldpai">
	                                    <table class="table table-bordered">
	                                        <tr>
	                                            <th>País de orígen</th>
	                                            <td><?php echo $pais ; ?></td>

	                                        </tr>
	                                    </table>
	                                </div>
	                    </div>
	                    <div class="col-md-6">
	                    		<!-- fecha compra -->
	                              <div class="form-group">
	                                  <label>Fecha de compra</label>
	                                  <input  class="form-control fecha" type="text" name="marcafecha" max="<?php echo $today;?>" readonly  value="<?php echo $fecha; ?>">
	                              </div>
	                           <!-- Fecha de inicio uso -->
	                              <div class="form-group">
	                              <label for="fechainicio">Fecha de inicio de uso</label>
	                                  <input  class="form-control fecha" type="text" id="fechainicio" name="fechainicio"  value="<?php echo $fechini;?>" readonly>
	                              </div>
	                          <!-- cod ext -->
	                              <div class="form-group">
	                                  <label>Codigo externo</label>
	                                  <input  class="form-control" id="codext" name="codigo_externo" type="text"  value="<?php echo $cod_ext;?>" readonly>
	                                  <div id="infocodex"></div>
	                              </div>
	                    </div>
	                  </div>
	                </div>
	              </div>
	          	<!-- Clasificacion -->
	              <div class="panel panel-default ">
	                <div class="panel-heading head3" data-toggle="collapse" data-parent="#accordion" href="#collapse3">
	                  <h4 class="panel-title">
	                    Clasificación <small class="tit3" style="color:red;"></small><i class="pull-right fa fa-angle-double-down"></i>
	                  </h4>
	                </div>
	                <div id="collapse3" class="panel-collapse collapse">
	                  <div class="panel-body">
	                    <div id="oldtigru" class="table-responsive">
	                        <table class="table table-bordered">
	                          <thead>
	                            <tr>
	                              <th class="text-center">Tipo Activo</th>
	                              <th class="text-center">Subtipo Activo</th>
	                              <th class="text-center">Grupo Activo</th>
	                              <th class="text-center">Subgrupo Activo</th>
	                            </tr>
	                          </thead>
	                          <tbody>
	                            <tr>
	                               <td class="text-center"><?php echo $nomtia;?></td>
	                               <td class="text-center"><?php echo $subtia;?></td>
	                               <td class="text-center"><?php echo $nomgru;?></td>
	                               <td class="text-center"><?php echo $subgru;?></td>
	                            </tr>
	                            <tr>
	                              <td colspan="4"><b>Ubicación del codigo QR: </b><?php echo $ubicQR;?></td>
	                            </tr>
	                          </tbody>
	                        </table>
	                    </div>
	                  </div>
	                </div>
	              </div>
	            <!-- Ubicacion -->
	              <div class="panel panel-default ">
	                <div class="panel-heading head4" data-toggle="collapse" data-parent="#accordion" href="#collapse4">
	                  <h4 class="panel-title">
	                    Ubicación <i class="pull-right fa fa-angle-double-down"></i>
	                  </h4>
	                </div>
	                <div id="collapse4" class="panel-collapse collapse">
	                  <div class="panel-body">
	                    <div id="oldtigru" class="table-responsive">
	                        <table class="table table-bordered">
	                          <thead>
	                            <tr>
	                              <th class="text-center">Lugar</th>
	                              <th class="text-center">Area</th>
	                            </tr>
	                          </thead>
	                          <tbody>
	                            <tr>
	                               <td class="text-center"><?php echo $lugar;?></td>
	                               <td class="text-center"><?php echo $area;?></td>
	                            </tr>
	                          </tbody>
	                        </table>
	                    </div>
	                  </div>
	                </div>
	              </div>
	       </div>
	</div>
</div>
<script> //start 
    $('[data-toggle="tooltip"]').tooltip();
    $('#side-menu').children(".active").removeClass("active");
    $("#ACTIVO").addClass("active");

    
    $(document).ready(function() {
        var act       = '<?php echo $codigo;?>';
        var gen       = '<?php echo $gener;?>';
        var mtto      = '<?php echo $rqmtto;?>';
        var rev       = '<?php echo $rqrev;?>';
        var pri       = '<?php echo $pri;?>';
        var gti       = '<?php echo $garti;?>';
        var gus       = '<?php echo $garuso;?>';
        var ins       = '<?php echo $insu;?>';
        var rpt       = '<?php echo $repu;?>';
        

        if(gen==1){
            $("#generico").val('SI');
        }else{
            $("#generico").val('NO');
        }

        if(mtto==1){
            $("#mttosw").prop('checked', true).change();
            $("#freqmtto").removeAttr('disabled');
            $("#fqmtto").show();
        }else{
            $("#fqmtto").hide();
            $("#mttosw").prop('checked', false).change();
            $("#freqmtto").attr('disabled','disabled');
        }
        if(rev==1){
            $("#revsw").prop('checked', true).change();
            $("#freqrev").removeAttr('disabled');
            $("#fqrev").show();
        }else{
            $("#fqrev").hide();
            $("#revsw").prop('checked', false).change();
            $("#freqrev").attr('disabled','disabled');
        }


        if(gti==1){
            $(".swgaract1").hide();
            $("#garactsw").prop('checked', true).change();
            $("#oldgar1").show();
        }else{
            $(".swgaract1").show();
            $("#garactsw").prop('checked', false).change();
            $("#oldgar1").hide();
        }
        if(gus==1){
            $(".swgaract2").hide();
            $("#garactsw2").prop('checked', true).change();
            $("#oldgar2").show();
        }else{
            $(".swgaract2").show();
            $("#garactsw2").prop('checked', false).change();
            $("#oldgar2").hide();
        }

        if(ins==1){
          $("#insumos").prop('checked', true).change();
          $(".addinsumos").show();
          $("#tbinsumo").show();
        }else{
          $("#insumos").prop('checked', false).change();
          $(".addinsumos").hide();
          $("#tbinsumo").hide();
        }
        if(rpt==1){
          $("#swrepuesto").prop('checked', true).change();
          $(".addrepuesto").show();
          $("#tbrepuesto").show();
        }else{
          $("#swrepuesto").prop('checked', false).change();
          $(".addrepuesto").hide();
          $("#tbrepuesto").hide();
        }

    });
</script>
<script type="text/javascript">
	$("#unlock").click(function(e){
		e.preventDefault();
		var pass=$("#secure").val();
		$("#modal-login").modal('hide');
		$.ajax({
			url:'php/exeservicio.php',
			type:'POST',
			data:'opc=unlock&pass='+pass,
			success:function(res){
				if(res=='OK'){
					consact();
				}else{
					location.reload();
				}
			}
		});
	});
	function consact(){
		var idact=$("#actcodigo").val();
		$.ajax({
			url:'php/exeservicio.php',
			type:'POST',
			data:'opc=seek&idact='+idact,
			success:function(res){
				window.location.href = res;
			}
		})
	}
</script>


</body>