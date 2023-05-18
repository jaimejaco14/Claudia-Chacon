<?php
include 'head.php';
include "librerias_js.php";
include "../cnx_data.php";
VerificarPrivilegio("ACTIVOS", $_SESSION['tipo_u'], $conn);
RevisarLogin();
$today= date("Y-m-d");
$codigo = $_GET['id_act'];
$sql = "SELECT  a.actcodigo,a.actnombre,a.marcodigo,ma.marnombre,a.actmodelo,a.actespecificaciones,a.actgenerico,a.actimagen,a.actserial,a.actdescripcion,a.actfechacompra,a.prvcodigo,ter.trcrazonsocial,a.fabcodigo,fa.fabnombre,a.paicodigo,pa.painombre,a.actfechainicio,a.actcodigoexterno,a.actcosto_base,a.actcosto_impuesto,a.sbgcodigo,tp.tianombre,st.sbtnombre,ga.granombre,sg.sbganombre,sg.sbgubicacionetiqueta,a.pracodigo,pr.pranombre,a.actreq_mant_prd,a.actfreq_mant,a.actreq_rev_prd,a.actfreq_rev,a.actgtia_tiempo,a.actgtia_tiempo_valor,a.unacodigo_tiempo,un.unanombre un1,a.actgtia_uso,a.actgtia_uso_valor,a.unacodigo_uso,un2.unanombre un2,a.actreq_insumos,a.actreq_repuestos
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
    WHERE a.actcodigo =".$codigo;
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
     
}

?>
<style>
  .panel-title{cursor:pointer;}
</style>
<div class="small-header">
    <div class="hpanel">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="inicio.php">Inicio</a></li>
                    <li class="active">
                        <span>Activos</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group">
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    <div class="content animated-panel">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li class="listact"><a href="activos.php" id=""> Activos</a></li>
                <li class="active detact" ><a data-toggle="tab" id="detact" href="#tab-2">  Detalles</a></li>
                <li class="movact" ><a data-toggle="tab" id="movact" href="#tab-3">  Ubicación</a></li>
                <li class="revmtto" style="display:none;"><a data-toggle="tab" id="revmtto" href="#tab-4">  Programación</a></li>
                <button id="exportPDF" class="btn btn-default pull-right" data-toggle="tooltip" data-placement="top" title="Exportar a PDF"><i class="fa fa-file-pdf-o text-danger"></i></button>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane">
                    <div class="panel-body">
                        <div id="listado">
                        </div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane active">
                    <div class="panel-body">
                        <div id="detalles">
                            <div class="row">
                                <form id="form_atc" role="form" name="form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" id="codigo" name="codigo" value="<?php echo $codigo;?>">
                                    <div class="panel-group" id="accordion">
                                      <!-- Generalidades -->
                                          <div class="panel panel-default">
                                            <div class="panel-heading head1" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                              <h4 class="panel-title ">
                                                  Datos Generales <small class="tit1" style="color:red;"></small> <i class="pull-right fa fa-angle-double-down"></i>
                                              </h4>
                                            </div>
                                            <div id="collapse1" class="panel-collapse collapse in">
                                              <div class="panel-body">
                                                  <div class="col-md-6">
                                                        <!-- Codigo -->
                                                            <div class="form-group">
                                                            </div>
                                                        <!-- nombre -->
                                                            <div class="form-group">
                                                              <div class="col-md-2">
                                                                <label>Codigo</label>
                                                                <input  class="form-control text-center" type="text" name="" id="codigodeactivo" value="<?php echo $codigo;?>" autocomplete="off" readonly>
                                                              </div>
                                                              <div class="col-md-10">
                                                                <label>Nombre</label>
                                                                <input  class="form-control text-uppercase" type="text" name="act_name" id="act_name" autocomplete="off" placeholder="Ingrese nombre" data-error="camp obligatorio" value="<?php echo $nombre;?>">
                                                                <div id="Info" class="help-block with-errors"></div>
                                                                
                                                              </div>
                                                            </div>
                                                        <!-- marca -->
                                                            <div class="form-group" id="oldmar">
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th>Marca</th>
                                                                        <td><?php echo $nommarca ; ?> <a id="editmar" class="btn btn-default btn-sm pull-right" data-toggle="tooltip" data-placement="top" title="Editar marca"><span class="fa fa-edit text-info"></span></a></td>

                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="form-group" style="display: none;" id="newmar">
                                                              <label>Marca</label>
                                                                  <div class="input-group">
                                                                  <div class="input-group-btn"> <a data-toggle="modal" data-target="#modal_marca"><button class="btn btn-default" title="Agregar nuevo"><i class="fa fa-plus-square text-info"></i></button></a></div>
                                                                  <select class="form-control" name="marcas" id="marcas" data-error="Escoja una opcion" ></select>
                                                                  </div>
                                                            </div>
                                                        <!-- modelo -->
                                                          <div class="form-group">
                                                              <label>Modelo</label>
                                                              <input  class="form-control text-uppercase" type="text" id="modelo" name="modelo" autocomplete="off" value="<?php echo $modelo;?>">
                                                          </div>
                                                        <!-- espec -->
                                                           <div class="form-group">
                                                              <label>Especificaciones</label>
                                                              <input  class="form-control text-uppercase" autocomplete="off" type="text" id="especificaciones" name="especificaciones" value="<?php echo $espec;?>">
                                                          </div>
                                                        <!-- Generico -->
                                                            <div class="form-group">
                                                                <label class="control-label">Activo genérico</label><br>
                                                                <div class="pull-left">
                                                                  <div class="TriSea-technologies-Switch col-md-2">
                                                                      <input id="generico" name="generico" class="generico" type="checkbox"/>
                                                                      <label for="generico" class="label-primary"></label>
                                                                  </div>
                                                                </div>
                                                            </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                      <!-- img  box-->
                                                          <div class="col-md-12">
                                                              <div class="col-sm-1 col-md-1">
                                                              </div>
                                                              <div class="col-sm-6 col-md-4">
                                                                  <img src="../contenidos/imagenes/activo/<?php echo $img;?>?<?php echo time(); ?>"  id="imgact" class="img-rounded img-responsive" onerror="this.src='../contenidos/imagenes/default.jpg';">
                                                              </div>
                                                              <div class="col-sm-6 col-md-5"><center  data-toggle="tooltip" data-placement="bottom" title="Haga click sobre el QR para descargar">
                                                                <a href="php/qr.php?codact=<?php echo $codigo;?>" download="QR-activo-<?php echo $codigo;?>.jpg"><?php echo '<img class="print" src="php/qr.php?codact='.$codigo.'" />';?></a></center><br>
                                                                <!-- <a id="printQR" href="php/printQR.php?actcod=<?php echo $codigo;?>" target="_blank" class="btn btn-default btn-block" data-toggle="tooltip" data-placement="right" title="Imprimir QR"><i class="fa fa-print text-info"></i></a> -->
                                                              </div>
                                                              
                                                          </div>
                                                            <br><br><br>
                                                      <!-- img LOADER-->
                                                          <div class="form-gruop">
                                                              <label>Imagen</label>
                                                              <input class="form-control" id="imagen" name="imagen" type="file">
                                                              <div id="InfoImg" class="help-block with-errors"></div>
                                                          </div>
                                                      <!-- SN -->
                                                            <div class="form-group">
                                                              <label>Serial</label>
                                                              <input  class="form-control text-uppercase" type="text" id="serial" name="serial" value="<?php echo $serial;?>" autocomplete="off" >
                                                              <div id="infosn"></div>
                                                            </div>
                                                      <!--desc -->
                                                          <div class="form-group">
                                                              <label>Descripción</label>
                                                              <textarea class="form-control text-uppercase" id="marcadescripcion" name="marcadescripcion" type="text"  style="resize: none;" value="<?php echo $descr;?>"><?php echo $descr;?></textarea>
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
                                                      <!-- fecha compra -->
                                                          <div class="form-group">
                                                              <label>Fecha de compra</label>
                                                              <input  class="form-control fecha" type="text" name="marcafecha" max="<?php echo $today;?>" placeholder="Ingrese fecha"  value="<?php echo $fecha; ?>" autocomplete="off">
                                                          </div>
                                                      <!-- proveedor -->
                                                            <div class="form-group" id="oldpro">
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th>proveedor</th>
                                                                        <td><?php echo $prove ; ?> <a id="editpro" class="btn btn-default btn-sm pull-right" data-toggle="tooltip" data-placement="top" title="Editar proveedor"><span class="fa fa-edit text-info"></span></a></td>

                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="form-group" style="display: none;" id="newpro">
                                                              <label>Proveedor</label>
                                                              <div class="input-group">
                                                              <div class="input-group-btn"> <a id="addprov"><button class="btn btn-default" title="Agregar Proveedor"><i class="fa fa-plus-square text-info"></i></button></a></div><select class="form-control" name="provdor" id="provdor" data-error="Elija Proveedor" >
                                                              </select>
                                                              </div>
                                                            </div>
                                                      <!-- Fabricante -->
                                                            <div class="form-group" id="oldfab">
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th>Fabricante</th>
                                                                        <td><?php echo $fab ; ?> <a id="editfab" class="btn btn-default btn-sm pull-right" data-toggle="tooltip" data-placement="top" title="Editar fabricante"><span class="fa fa-edit text-info"></span></a></td>

                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="form-group" style="display: none;" id="newfab">
                                                                  <label>Fabricante</label>
                                                                  <div class="input-group">
                                                                  <div class="input-group-btn"> <a data-toggle="modal" data-target="#modal_fab"><button class="btn btn-default" title="Agregar fabricante"><i class="fa fa-plus-square text-info"></i></button></a></div><select class="form-control" name="fabrica" id="fabrica" data-error="Elija fabricante" >
                                                                  </select>
                                                                  </div>
                                                            </div>
                                                      <!-- pais -->
                                                            <div class="form-group" id="oldpai">
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th>País de orígen</th>
                                                                        <td><?php echo $pais ; ?> <a id="editpai" class="btn btn-default btn-sm pull-right" data-toggle="tooltip" data-placement="top" title="Editar país"><span class="fa fa-edit text-info"></span></a></td>

                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="form-group" style="display: none;" id="newpai">
                                                              <label>País de Origen</label>
                                                              <div class="input-group">
                                                              <div class="input-group-btn"> <a data-toggle="modal" data-target="#modal_pais"><button class="btn btn-default" title="Agregar País"><i class="fa fa-plus-square text-info"></i></button></a></div><select class="form-control" name="pais" id="pais" data-error="Elija País" >
                                                              </select>
                                                              </div>
                                                            </div>   
                                                </div>
                                                <div class="col-md-6">
                                                       <!-- Fecha de inicio uso -->
                                                          <div class="form-group">
                                                          <label for="fechainicio">Fecha de inicio de uso</label>
                                                              <input  class="form-control fecha" type="text" id="fechainicio" name="fechainicio" max="<?php echo $today;?>" value="<?php echo $fechini;?>" autocomplete="off">
                                                          </div>
                                                      <!-- cod ext -->
                                                          <div class="form-group">
                                                              <label>Codigo externo</label>
                                                              <input  class="form-control" id="codext" name="codigo_externo" type="text"  value="<?php echo $cod_ext;?>" data-error="Campo obligatorio" autocomplete="off">
                                                              <div id="infocodex"></div>
                                                          </div>
                                                      <!-- costo -->
                                                          <div class="form-group">
                                                              <label>Costo Base</label>
                                                              <input  class="form-control number" type="number" id="costobase" name="costobase" value="<?php echo $costo;?>" autocomplete="off">
                                                          </div> 
                                                      <!-- impuesto -->
                                                          <div class="form-group">
                                                              <label>Impuesto Base</label>
                                                              <input  class="form-control number" type="number" id="impuesto" name="impuesto" value="<?php echo $impu;?>" autocomplete="off">
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
                                                <div id="newtigru" style="display:none;">
                                                  <div class="col-md-3">
                                                    <!-- tipo act -->
                                                    <div class="form-group">
                                                        <label>Tipo activo </label>
                                                        <div class="input-group">
                                                       <div class="input-group-btn"> <a data-toggle="modal" data-target="#modal_tipo"><button class="btn btn-default" title="Agregar nuevo"><i class="fa fa-plus-square text-info"></i></button></a></div><select class="form-control" name="tipoactivo" id="tipoactivo" data-error="Escoja una opcion" ></select>
                                                        </div>  
                                                    </div>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <!-- sub-tipo act -->
                                                    <div class="form-group">
                                                        <label>Subtipo activo </label>
                                                        <div class="input-group">
                                                       <div class="input-group-btn"> <a data-toggle="modal"><button id="newsubtia" class="btn btn-default" title="Agregar nuevo"><i class="fa fa-plus-square text-info"></i></button></a></div><select class="form-control" name="subtipoactivo" id="subtipoactivo" data-error="Escoja una opcion" >
                                                         <option value="0">- Seleccione SubTipo -</option>
                                                       </select>
                                                        </div>  
                                                    </div>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <!--grupo act -->
                                                    <div class="form-group">
                                                        <label> Grupo activo </label>
                                                        <div class="input-group">
                                                        <div class="input-group-btn"> <a data-toggle="modal"> <button class="btn btn-default" title="Agregar nuevo" id="newgru"><i class="fa fa-plus-square text-info"></i></button> </a> </div>
                                                        <select class="form-control" name="grupoactivo" id="grupoactivo" data-error="Escoja una opcion" >
                                                            <option value="0">- Seleccione grupo -</option>
                                                        </select>
                                                        </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <!--sub-grupo act -->
                                                    <div class="form-group">
                                                        <label> Subgrupo activo </label>
                                                        <div class="input-group">
                                                        <div class="input-group-btn"> <a data-toggle="modal"> <button class="btn btn-default" title="Agregar nuevo" id="newsubgru"><i class="fa fa-plus-square text-info"></i></button> </a> </div>
                                                        <select class="form-control" name="subgrupoactivo" id="subgrupoactivo" data-error="Escoja una opcion" >
                                                            <option value="0">- Seleccione subgrupo -</option>
                                                        </select>
                                                        </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-12">
                                                      <b id="primsj"></b><br>
                                                      <b id="ubicmsj"></b>
                                                  </div>
                                                </div>
                                                <div id="oldtigru">
                                                    <table class="table table-bordered">
                                                      <thead>
                                                        <tr>
                                                          <th class="text-center">Tipo Activo</th>
                                                          <th class="text-center">Subtipo Activo</th>
                                                          <th class="text-center">Grupo Activo</th>
                                                          <th class="text-center">
                                                            Subgrupo Activo
                                                            <button id="edittigru" class="btn btn-default btn-sm pull-right" data-toggle="tooltip" data-placement="top" title="Editar Clasificación"><i class="fa fa-edit text-info"></i></button>
                                                          </th>
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
                                      <!-- Mantenimiento -->
                                          <div class="panel panel-default">
                                            <div class="panel-heading head5" data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                                              <h4 class="panel-title ">
                                                Mantenimiento <small class="tit5" style="color:red;"></small><i class="pull-right fa fa-angle-double-down"></i>
                                              </h4>
                                            </div>
                                            <div id="collapse4" class="panel-collapse collapse">
                                              <div class="panel-body">
                                                <div class="col-md-6">
                                                    <!--mtto-->
                                                    <div class="row">
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Mantenimiento</label><br>
                                                            <div class="pull-left" data-toggle="tooltip" data-placement="right" title="seleccione si el activo requiere de Mantenimiento">
                                                                  <div class="TriSea-technologies-Switch col-md-2 col-md-pull-1">
                                                                      <input id="mttosw" name="mttosw" class="mttosw" type="checkbox"/>
                                                                      <label for="mttosw" class="label-primary"></label>
                                                                  </div>
                                                            </div>
                                                        </div>
                                                      </div>
                                                      <div class="col-md-6" style="display:none;" id="fqmtto">
                                                          <label>Frecuencia (dias)</label>
                                                          <input  class="form-control number" name="freqmtto" type="number" id="freqmtto"  placeholder="dias" data-error="Campo obligatorio" disabled  min="1" value="<?php echo $fqmtto;?>" autocomplete="off">
                                                      </div>
                                                    </div><br><br>
                                                    <!--Prioridad -->
                                                    <div class="form-group" id="oldpri">
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <th>Prioridad</th>
                                                                        <td><?php echo $prinom ; ?> <a id="editpri" class="btn btn-default btn-sm pull-right" data-toggle="tooltip" data-placement="top" title="Editar prioridad"><span class="fa fa-edit text-info"></span></a></td>

                                                                    </tr>
                                                                </table>
                                                            </div>
                                                    <div class="form-group" id="newpri" style="display:none;">
                                                        <label> Prioridad </label>
                                                        <select class="form-control" name="prioridad" id="prioridad" data-error="Escoja una opcion" >
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                 
                                                    <!--revision-->
                                                        <div class="row">
                                                          <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Revisión</label><br>
                                                                <div class="pull-left" data-toggle="tooltip" data-placement="right" title="seleccione si el activo requiere de Revisiones periodicas">
                                                                      <div class="TriSea-technologies-Switch col-md-2 col-md-pull-1">
                                                                          <input id="revsw" name="revsw" class="revsw" type="checkbox"/>
                                                                          <label for="revsw" class="label-primary"></label>
                                                                      </div>
                                                                </div>
                                                            </div>
                                                          </div>
                                                          <div class="col-md-6" style="display:none;" id="fqrev">
                                                              <label>Frecuencia (dias)</label>
                                                              <input  class="form-control number" name="freqrev" type="number" id="freqrev"  placeholder="dias" data-error="Campo obligatorio" disabled  min="1" value="<?php echo $fqrev;?>" autocomplete="off">
                                                          </div>
                                                        </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                      <!-- Garantia -->
                                          <div class="panel panel-default">
                                            <div class="panel-heading head5" data-toggle="collapse" data-parent="#accordion" href="#collapse7">
                                              <h4 class="panel-title">
                                                Garantía <small class="tit6" style="color:red;"></small><i class="pull-right fa fa-angle-double-down"></i>
                                              </h4>
                                            </div>
                                            <div id="collapse7" class="panel-collapse collapse">
                                              <div class="panel-body">
                                                    <div class="col-md-6">
                                                        <!--garantia x tiempo-->
                                                        <div class="row">
                                                          <div class="col-md-3 swgaract1">
                                                              <div class="form-group">
                                                                  <label class="control-label">Tiempo</label><br>
                                                                  <div class="pull-left" data-toggle="tooltip" data-placement="right" title="seleccione si el activo tiene garantia">
                                                                        <div class="TriSea-technologies-Switch col-md-2">
                                                                            <input id="garactsw" name="garactsw" class="garactsw" type="checkbox"/>
                                                                            <label for="garactsw" class="label-primary"></label>
                                                                        </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-3 garact" style="display:none;">
                                                              <label for="timegar">Cantidad</label>
                                                              <input  class="form-control number" name="timegar" type="number" id="timegar" data-error="Campo obligatorio" autocomplete="off"  min="1">
                                                          </div>
                                                          <div class="col-md-6 garact" style="display:none;">
                                                            <label for="unitime">Unidad</label>
                                                            <div class="input-group">
                                                              <div class="input-group-btn"><a data-toggle="modal" data-target="#modal_uni1"><button class="btn btn-default btnnewunidad1" title="Agregar nuevo"><i class="fa fa-plus-square text-info"></i></button></a></div>
                                                              <select name="unitime" id="unitime" class="form-control"></select>
                                                            </div>
                                                          </div>
                                                          <div class="col-md-9" id="oldgar1">
                                                              <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                      <th colspan="2" class="text-center">Garantía por tiempo</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-center">Cantidad</th>
                                                                        <th class="text-center">Unidad
                                                                            <button id="editgar1" class="btn btn-default btn-sm pull-right" data-toggle="tooltip" data-placement='top' title='editar garantia'><i class="fa fa-edit text-info"></i></button>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-center"><?php echo $gartival;?></td>
                                                                        <td class="text-center"><?php echo $gartiuni;?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>    
                                                          </div>
                                                          
                                                        </div>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <!--garantia x uso-->
                                                        <div class="row">
                                                          <div class="col-md-3 swgaract2">
                                                              <div class="form-group">
                                                                  <label class="control-label">Uso</label><br>
                                                                  <div class="pull-left" data-toggle="tooltip" data-placement="right" title="seleccione si el activo tiene garantía">
                                                                        <div class="TriSea-technologies-Switch col-md-2">
                                                                            <input id="garactsw2" name="garactsw2" class="garactsw2" type="checkbox"/>
                                                                            <label for="garactsw2" class="label-primary"></label>
                                                                        </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-3 garact2" style="display:none;">
                                                              <label for="cantuso">Cantidad</label>
                                                              <input  class="form-control number" name="cantuso" type="number" id="cantuso" data-error="Campo obligatorio" autocomplete="off" min="1">
                                                          </div>
                                                          <div class="col-md-6 garact2" style="display:none;">
                                                              <label for="uniuso">Unidad</label>
                                                              <div class="input-group">
                                                                <div class="input-group-btn"> <a data-toggle="modal" data-target="#modal_uni2"> <button class="btn btn-default btnnewunidad" title="Agregar nuevo"><i class="fa fa-plus-square text-info"></i></button> </a> </div>
                                                              <select name="uniuso" id="uniuso" class="form-control"></select>
                                                            </div>
                                                          </div>
                                                          <div class="col-md-9" id="oldgar2" >
                                                              <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                      <th colspan="2" class="text-center">Garantía por uso</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="text-center">Cantidad</th>
                                                                        <th class="text-center">Unidad
                                                                            <button id="editgar2" class="btn btn-default btn-sm pull-right" data-toggle="tooltip" data-placement='top' title='editar garantia'><i class="fa fa-edit text-info"></i></button>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-center"><?php echo $garusoval;?></td>
                                                                        <td class="text-center"><?php echo $garusouni;?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>    
                                                          </div>
                                                        </div>  
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                      <!-- Insumos -->
                                          <div class="panel panel-default">
                                            <div class="panel-heading head5" data-toggle="collapse" data-parent="#accordion" href="#collapse8">
                                              <h4 class="panel-title">
                                                Insumos <small class="tit7" style="color:red;"></small><i class="pull-right fa fa-angle-double-down"></i>
                                              </h4>
                                            </div>
                                            <div id="collapse8" class="panel-collapse collapse">
                                              <div class="panel-body">
                                                <div class="row">
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">Insumos</label><br>
                                                        <div class="pull-left">
                                                          <div class="TriSea-technologies-Switch col-md-2">
                                                              <input id="insumos" name="insumos" class="insumos" type="checkbox"/>
                                                              <label for="insumos" class="label-primary"></label>
                                                          </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group addinsumos col-md-3">
                                                        <label>Asignar Insumos</label>
                                                        <div class="input-group">
                                                       <div class="input-group-btn"> <a data-toggle="modal" data-target="#modal_insumos"><button class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Crear Insumo"><i class="fa fa-plus-square text-info"></i></button></a></div><select class="form-control" name="selinsumos" id="selinsumos" data-error="Escoja una opcion" ></select>
                                                        </div>  
                                                    </div>
                                                    <div class="form-group addinsumos col-md-2">
                                                        <label>cantidad</label>
                                                        <div class="input-group">
                                                          <input  class="form-control number" name="cantinsumo" type="number" id="cantinsumo"  placeholder="Cant" data-error="Campo obligatorio" disabled  min="1" autocomplete="off">
                                                          <div class="input-group-btn"> <button id="assigninsumo" class="btn btn-info" data-toggle="tooltip" data-placement="right" title="Asignar este insumo al activo actual" disabled><i class="fa fa-plus"></i></button> </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 table-responsive" id="tbinsumo">
                                                      <table class="table table-bordered">
                                                        <thead>
                                                          <tr>
                                                            <th class="text-center">Referencia</th>
                                                            <th class="text-center">Nombre</th>
                                                            <th class="text-center">Especificaciones</th>
                                                            <th class="text-center">Cantidad</th>
                                                            <th class="text-center">Opciones</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody id="tbodyinsumos">
                                                        </tbody>
                                                      </table>                      
                                                    </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                      <!-- Repuestos -->
                                          <div class="panel panel-default">
                                            <div class="panel-heading head5" data-toggle="collapse" data-parent="#accordion" href="#collapse9">
                                              <h4 class="panel-title">
                                                Repuestos <small class="tit8" style="color:red;"></small><i class="pull-right fa fa-angle-double-down"></i>
                                              </h4>
                                            </div>
                                            <div id="collapse9" class="panel-collapse collapse">
                                              <div class="panel-body">
                                                  <div class="row">
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">Repuestos</label><br>
                                                        <div class="pull-left">
                                                          <div class="TriSea-technologies-Switch col-md-2">
                                                              <input id="swrepuesto" name="swrepuesto" class="swrepuesto" type="checkbox"/>
                                                              <label for="swrepuesto" class="label-primary"></label>
                                                          </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group addrepuesto col-md-3">
                                                        <label>Asignar Repuestos</label>
                                                        <div class="input-group">
                                                       <div class="input-group-btn"> <a data-toggle="modal" data-target="#modal_repu"><button class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Crear Repuesto"><i class="fa fa-plus-square text-info"></i></button></a></div><select class="form-control" name="selrepuesto" id="selrepuesto" data-error="Escoja una opcion" ></select>
                                                        </div>  
                                                    </div>
                                                    <div class="form-group addrepuesto col-md-2">
                                                        <label>cantidad</label>
                                                        <div class="input-group">
                                                          <input  class="form-control number" name="cantrepuesto" type="number" id="cantrepuesto"  placeholder="Cant" data-error="Campo obligatorio" disabled  min="1" autocomplete="off">
                                                          <div class="input-group-btn"> <button id="assignrepuesto" class="btn btn-info" data-toggle="tooltip" data-placement="right" title="Asignar este insumo al activo actual" disabled><i class="fa fa-plus"></i></button> </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 table-responsive" id="tbrepuesto">
                                                      <table class="table table-bordered">
                                                        <thead>
                                                          <tr>
                                                            <th class="text-center">Referencia</th>
                                                            <th class="text-center">Nombre</th>
                                                            <th class="text-center">Especificaciones</th>
                                                            <th class="text-center">Cantidad</th>
                                                            <th class="text-center">Opciones</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody id="tbodyrepuestos">
                                                        </tbody>
                                                      </table>                      
                                                    </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                      <!-- Adjuntos -->
                                        <div class="panel panel-default">
                                          <div class="panel-heading head5" data-toggle="collapse" data-parent="#accordion" href="#collapse10">
                                            <h4 class="panel-title">
                                              Adjuntos <small class="tit8" style="color:red;"></small><i class="pull-right fa fa-angle-double-down"></i>
                                            </h4>
                                          </div>
                                          <div id="collapse10" class="panel-collapse collapse">
                                            <div class="panel-body">
                                              <div class="panel-body">
                                                    <h5> Adjuntar Archivos. <button type="button" class="btn btn-default btn-sm" id="btn_newdoc" data-id="<?php echo $codigo;?>" data-toggle="modal" data-target="#modal_newdoc"><i class="fa fa-plus-square-o text-info"></i></button></h5> 
                                                    <div class="help-block" id="divtbadjuntos">
                                                       
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                   </div>
                                   <div class="col-md-12">
                                        <button type="submit" class="btn btn-success pull-right" data-toggle="tooltip" data-placement="top" title="Guardar Cambios"><i class="fa fa-save"></i></button>
                                        <button type="reset" id="resetform" class="btn btn-default pull-right" data-toggle="tooltip" data-placement="top" title="Cancelar"><i class="fa fa-times text-danger"></i></button>
                                        <button  id="duplicador" class="btn btn-default pull-right" data-toggle="tooltip" data-placement="top" title="Duplicar Activo"><i class="fa fa-copy text-info"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-3" class="tab-pane">
                    <div class="panel-body">
                    <h4><b>Ubicación actual:</b></h4><h4 id="ubicact"></h4>
                        <div id="movimientos"></div>
                    </div>
                </div>
                <div id="tab-4" class="tab-pane">
                    <div class="panel-body">
                        <form id="form_filtro">
                            <div class="row"> 
                                <div class="form-group col-md-2">
                                    <select class="form-control" id="filtipo" name="filtipo">
                                        <option value=""> -Filtrar por tipo- </option>
                                        <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                                        <option value="REVISION">REVISIÓN</option>
                                        <option value="SERVICIO">SERVICIO</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control" id="filest" name="filest">
                                        <option value=""> -Filtrar por estado- </option>
                                        <option value="CANCELADO">CANCELADO</option>
                                        <option value="EJECUTADO">EJECUTADO</option>
                                        <option value="PROGRAMADO">PROGRAMADO</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <h5><b>Filtrar por fecha</b></h5>
                                </div>
                                 <div class="form-group col-md-2">
                                    <input class="form-control fecha text-center" style="cursor:pointer;caret-color: transparent !important;" type="text" name="fildesde" id="fildesde" placeholder="Desde">
                                </div>
                                <div class="form-group col-md-1">
                                    <center><h5><b>a:</b></h5></center>
                                </div>
                                 <div class="form-group col-md-2">
                                    <input class="form-control fecha text-center" style="cursor:pointer;caret-color: transparent !important;" type="text" name="filhasta" id="filhasta" placeholder="Hasta" disabled>
                                </div>
                                <div class="form-group col-md-2" style="display:none;" id="divreset">
                                    <button id="resetfil" type="reset" class="btn btn-info pull-left" data-toggle="tooltip" data-placement="right" title="Reiniciar filtro"><span class="fa fa-filter"></span></button>
                                </div>
                            </div>
                            <div class="row">    
                                <div id="revmttoact" class="revmttoact"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal tipo activo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_tipo">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar nuevo tipo activos</h4>
          </div>
            <form id="form_tia" method="post" class="formul">
          <div class="modal-body">
              
                <div class="form-gruop">
                  <label>
                      Nombre
                  </label>
                  <input class="form-control text-uppercase" id="tianame" name="tianame" maxlength="50" type="text" required autocomplete="off">
                  <div id="infotia" class="help-block with-errors err"></div>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Guardar</button>
           
          </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal tipo activo -->

<!-- Modal sub-tipo activo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_subtipo">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar nuevo subtipo activos</h4>
          </div>
            <form id="form_subtia" method="post" class="formul" autocomplete="off">
          <div class="modal-body">
              <input type="hidden" name="tiacodigo" id="tiacodigo">
                <div class="form-gruop">
                  <label>
                      Nombre
                  </label>
                  <input class="form-control text-uppercase" id="subtianame" name="subtianame" maxlength="50" type="text" required>
                  <div id="infosubtia" class="help-block with-errors err"></div>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Guardar</button>
           
          </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal sub-tipo activo -->

<!-- Modal Grupo activo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_grupo">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar nuevo grupo activos</h4>
          </div>
            <form id="form_gra" method="post" class="formul" autocomplete="off">
              <div class="modal-body">
                  
                    <div class="form-group">
                      <label>
                          Nombre
                      </label>
                      <input class="form-control text-uppercase" id="graname" name="graname" maxlength="50" type="text" required>
                      <div id="infogra" class="help-block with-errors err"></div>
                    </div>
                   <input type="hidden" name="subtiacodigo" id="subtiacodigo">

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Guardar</button>
               
              </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal Grupo activo -->

<!-- Modal SubGrupo activo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_subgrupo">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar nuevo Subgrupo activos</h4>
          </div>
            <form id="form_subgra" method="post" class="formul" autocomplete="off">
              <div class="modal-body">
                  
                    <div class="form-group">
                      <label>
                          Nombre
                      </label>
                      <input class="form-control text-uppercase" id="sbgname" name="sbgname" maxlength="50" type="text" required>
                      <div id="infosubgra" class="help-block with-errors err"></div>
                    </div>
                    <div class="form-group">
                      <label for="prioact">
                          Prioridad
                      </label>
                     <select name="prioact" id="prioact" class="form-control" required></select>
                    </div>
                    <div class="form-group">
                      <label>
                          Ubicacion del Codigo QR
                      </label>
                      <textarea class="form-control text-uppercase" id="labelubic" name="labelubic" maxlength="50" style="resize: none;" required></textarea>
                      <div id="infogra" class="help-block with-errors err"></div>
                    </div>
                   <input type="hidden" name="grucodigo" id="grucodigo">

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Guardar</button>
               
              </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal SubGrupo activo -->

<!-- Modal Marca -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_marca">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar nueva marca</h4>
          </div>
            <form id="form_mar" method="post" class="formul" autocomplete="off">
          <div class="modal-body">
              
                <div class="form-gruop">
                  <label>
                      Nombre
                  </label>
                  <input class="form-control text-uppercase" id="marname" name="marname" maxlength="50" type="text" required>
                  <div id="infomar" class="help-block with-errors err"></div>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Guardar</button>
           
          </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal marca -->

<!-- Modal nuevo lugar -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_newlugar">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-plus text-info"></i> Agregar nuevo Lugar</h4>
          </div>
            <form id="form_newlug" method="post" autocomplete="off">
              <div class="modal-body">
                <div class="form-gruop">
                  <label>
                      Nombre del lugar
                  </label>
                  <input class="form-control text-uppercase nomlugar" id="lugname" name="lugname" maxlength="50" type="text" required>
                  <div id="Infolug" class="help-block with-errors infolug err"></div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="submitformgru" class="btn btn-success">Guardar</button>
              </div>
             </form>
        </div>
      </div>
    </div>
<!-- /.modal nuevo lugar -->

<!-- Modal nueva area -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_newarealug">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-plus text-info"></i> Agregar area a:</h4><div class="col-md-4"><h4 id="titmodluar"></h4></div>
          </div>
            <form id="form_newarea" autocomplete="off">
              <div class="modal-body">
                <input type="hidden" name="idlug" id="idlug">
                <div class="form-group">
                  <label>
                      Nombre del área
                  </label>
                  <input class="form-control text-uppercase nomarea" id="arname" name="arname" maxlength="50" type="text" required>
                  <div class="help-block with-errors infoar err"></div>
                </div>
                <div class="form-group">
                  <label>
                      Descripción
                  </label>
                  <input class="form-control text-uppercase" id="ardesc" name="ardesc" maxlength="50" type="text" >
                </div>
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="" class="btn btn-success">Guardar</button>
              </div>
            </form>
        </div>
      </div>
    </div>
<!-- /.modal nuevo area -->

<!-- Modal pais -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_pais">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar nuevo País</h4>
          </div>
            <form id="form_pais" method="post" class="formul" autocomplete="off">
          <div class="modal-body">
              
                <div class="form-gruop">
                  <label>
                      Nombre
                  </label>
                  <input class="form-control text-uppercase" id="paisname" name="paisname" maxlength="50" type="text" required>
                  <div id="infopais" class="help-block with-errors err"></div>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Guardar</button>
           
          </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal pais -->

<!-- Modal fabricante -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_fab">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar nuevo Fabricante</h4>
          </div>
            <form id="form_fab" method="post" class="formul">
          <div class="modal-body">
              
                <div class="form-gruop">
                  <label>
                      Nombre
                  </label>
                  <input class="form-control text-uppercase" id="fabname" name="fabname" maxlength="50" type="text" required>
                  <div id="infofab" class="help-block with-errors err"></div>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Guardar</button>
           
          </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal fabricante -->

<!-- Modal unidad1 -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_uni1">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar Nueva unidad de tiempo</h4>
          </div>
            <form id="form_uni1" method="post" class="formul">
          <div class="modal-body">
              
                <div class="form-gruop">
                  <label>
                      Nombre
                  </label>
                  <input class="form-control text-uppercase" id="uniname1" name="uniname1" maxlength="6" type="text" placeholder="ej: Dia, mes, año, semana, etc" required>
                  <div id="infouni1" class="help-block with-errors err"></div>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Guardar</button>
           
          </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal unidad1 -->

<!-- Modal unidad2 -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_uni2">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar Nueva unidad de uso</h4>
          </div>
            <form id="form_uni2" method="post" class="formul">
          <div class="modal-body">
              
                <div class="form-gruop">
                  <label>
                      Nombre
                  </label>
                  <input class="form-control text-uppercase" id="uniname2" name="uniname2" maxlength="10" type="text" placeholder="ej: Horas, ciclos, kilometros, etc" required>
                  <div id="infouni2" class="help-block with-errors err"></div>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Guardar</button>
           
          </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal unidad2 -->

<!-- Modal insumos -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_insumos">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar Nuevo insumo</h4>
          </div>
            <form id="form_insumos" method="post" class="formul">
          <div class="modal-body">
              
                <div class="form-group">
                  <label>
                      Nombre
                  </label>
                  <input class="form-control text-uppercase" id="insname" name="insname" maxlength="49" type="text" required>
                  <div id="infoinsumo" class="help-block with-errors err"></div>
                </div>
                <div class="form-group">
                  <label>
                      Referencia
                  </label>
                  <input class="form-control text-uppercase" id="insref" name="insref" maxlength="49" type="text" required>
                </div>
                <div class="form-group">
                  <label>
                      Especificaciones
                  </label>
                  <textarea class="form-control text-uppercase" style="resize:none;" id="insespec" name="insespec" type="text" required></textarea>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Guardar</button>
           
          </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal insumos -->

<!-- Modal repuestos -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_repu">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar Nuevo insumo</h4>
          </div>
            <form id="form_repu" method="post" class="formul">
          <div class="modal-body">
              
                <div class="form-group">
                  <label>
                      Nombre
                  </label>
                  <input class="form-control text-uppercase" id="repname" name="repname" maxlength="49" type="text" required>
                  <div id="inforepu" class="help-block with-errors err"></div>
                </div>
                <div class="form-group">
                  <label>
                      Referencia
                  </label>
                  <input class="form-control text-uppercase" id="repref" name="repref" maxlength="49" type="text" required>
                </div>
                <div class="form-group">
                  <label>
                      Especificaciones
                  </label>
                  <textarea class="form-control text-uppercase" style="resize:none;" id="repespec" name="repespec" type="text" required></textarea>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Guardar</button>
           
          </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal repuestos -->

<!-- Modal Adjuntos-->
  <div id="modal_newdoc" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"">
    <div class="modal-dialog" role="document"> 
        <div class="modal-content" > 

            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                <h5 class="modal-title"><span class="fa fa-file"></span> Cargar Adjunto</h5> 
                
            </div> 
            <div class="modal-body">
                <div class="row carga">
                    <div class="col-md-10 col-md-push-1 oculgen">
                        <button id="addti_doc" class="btn btn-info btn-sm pull-left" data-toggle="tooltip" data-placement="right" title="Nuevo tipo de adjunto"><span class="fa fa-plus"></span></button>
                    </div>
                    <form action="php/processadjunto.php" method="POST" enctype="multipart/form-data" role="form" id="formul" target="contenedor_subir_archivo"> 
                        <input type="hidden" id="codigoactivo" name="codigoactivo" value="<?php echo $codigo;?>">
                         <input type="hidden" id="opc" name="opc" value="new">
                        <div class="oculgen carga">
                            <div class="form-group col-md-10 col-md-push-1">
                                <select class="form-control" id="seltidoc" name="seltidoc" required></select>
                            </div>
                            <div class="form-group col-md-10 col-md-push-1">
                            <label for="nomadjunto">Nombre del Archivo</label>
                              <input class="form-control" type="text" id="nomadjunto" name="nomadjunto" placeholder="Nombre del archivo" required>                       
                            </div>
                        </div> 
                        <div class="col-md-8 col-md-push-2 oculgen" style="display:none;" id="iconoPDF">
                            <div class="panel-body file-body">
                                <center><i class="fa fa-file text-center" style="color:lightblue;"></i></center>
                            </div>
                            <div class="panel-footer">
                                <h4 id="nomarchivo" class="text-center"></h4>
                            </div>
                        </div>
                        <div id="divuploader" class="col-md-10 col-md-push-1">
                            <div id="area" class="area" style="align-items: center;border: 3px dashed #aaa;border-radius: 5px;color: #555;display: flex;flex-flow: column nowrap;font-size: 15px;justify-content: center;max-height: 200px;margin: 30px auto;overflow: auto;text-align: center;white-space: pre-line;width: 100%;">
                                <i class="fa fa-cloud-upload" style="font-size:40px;"></i>
                                <small id="msj1">Arrastre archivo aquí</small>
                                <small id="msj2" class="text-center">O haga click para buscar el archivo</small>
                                <input type="file" id="files" name="archivoPDF" class="form-control uploader" required />
                            </div>
                            <style>
                                .dragging {
                                    background-color: rgba(255, 255, 0, .3);
                                    background-color:lightblue;
                                } 
                                .uploader{
                                    opacity: 0;
                                    height:60%;
                                    width:90%;
                                    padding:0%;
                                    z-index:0;
                                    position:absolute;
                                }

                            </style>
                        </div>
                        <div id="divobser" class="col-md-10 col-md-push-1 oculgen carga"><br>
                            <label class="col-md-4 control-label" for="textinput2">Descripción</label>  
                            <textarea id="txtobserv" name="txtobserv" class="form-control" style="resize: none;" required></textarea>
                            <br>
                        </div>
                        <div class="col-md-10 col-md-push-1 oculgen carga">
                            <button id="subirarchivo" type="submit" class="btn btn-info pull-right" data-toggle="tooltip" data-placement="top" title="Guardar"><span class="fa fa-save"></span></button>
                            <button id="resetform" class="btn btn-danger pull-right" type="reset" data-toggle="tooltip" data-placement="top" title="Cancelar" data-dismiss="modal"><span class="fa fa-remove"></span></button>
                        </div>
                        <div class="col-md-10 col-md-push-1">
                            <h4 id="respuesta"></h4>
                        </div>
                        <iframe width="1" height="1" frameborder="0" name="contenedor_subir_archivo" style="display: none"></iframe>
                    </form>
                </div>
                <div class="row newtidocform" style="display:none;">
                    <div class="col-md-10 col-md-push-1">
                        <a id="btnback" class="btn btn-info"><span class="fa fa-arrow-left" data-toggle="tooltip" data-placement="right" title="Regresar"></span></a>
                    </div>
                    <div class="col-md-10 col-md-push-1">
                        <form class="form-horizontal" id="formnuca">
                            <fieldset>
                            <!-- Form Name -->
                                <legend>Nuevo tipo de archivo adjunto</legend>
                                <!-- Text input-->
                                <div class="form-group">
                                  <label class="col-md-4 control-label" for="textinput1">Nombre tipo de adjunto</label>  
                                  <div class="col-md-8">
                                  <input id="textinput1" name="textinput1" type="text" placeholder="ej: Manual, foto, procedimiento" class="form-control input-md" required>
                                  </div>
                                </div>
                                <!-- Button (Double) -->
                                <div class="form-group">
                                  <div class="col-md-12">
                                    <button id="" type="submit" class="btn btn-primary pull-right" data-toggle="tooltip" data-placement="top" title="Guardar"><span class="fa fa-save"></span></button>
                                    <button id="resetnutido" type="reset" class="btn btn-danger pull-right" data-toggle="tooltip" data-placement="top" title="Cancelar"><span class="fa fa-remove"></span></button>
                                  </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer"> 
                <!-- <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button> -->
            </div> 
        </div> 
    </div>
  </div>
<!-- Fin Modal Adjuntos-->

<!-- Modal EDITAR Adjuntos-->
  <div id="modal_newdoc2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"">
      <div class="modal-dialog" role="document"> 
          <div class="modal-content" > 

              <div class="modal-header"> 
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                  <h5 class="modal-title"><span class="fa fa-file"></span> Editar Documento</h5> 
                  
              </div> 
              <div class="modal-body">
                  <div class="row carga">
                      <form action="processadjuntoact.php" method="POST" enctype="multipart/form-data" role="form" id="formul2" target="contenedor_subir_archivo"> 
                          <input type="hidden" id="daccol" name="daccol">
                           <input type="hidden" id="opc" name="opc" value="upd">
                          <div class="oculgen carga">
                              <div class="col-md-10 col-md-push-1">
                                  
                                  <select class="form-control" id="seltidoc2" name="seltidoc2" required>
                                      <option value="">Seleccione tipo de documento</option>
                                          <?php
                                          include 'conexion.php';
                                          $sqltd="SELECT * from btytipo_adjunto_colaborador tac where tac.tacestado=1 order by tac.tacnombre ";
                                          $restd=$conn->query($sqltd);
                                          while($rowtd=$restd->fetch_array()){
                                              ?>
                                              <option value="<?php echo $rowtd[0];?>"><?php echo $rowtd[1];?></option>
                                              <?php
                                          }
                                          ?>
                                  </select>
                              </div>
                          </div> 
                          <div class="col-md-8 col-md-push-2 oculgen" style="display:none;" id="iconoPDF2">
                              <div class="panel-body file-body">
                                  <center><i class="fa fa-file-pdf-o text-center" style="color:red;"></i></center>
                              </div>
                              <div class="panel-footer">
                                  <h4 id="nomarchivo2" class="text-center"></h4>
                              </div>
                          </div>
                          <div id="divuploader2" class="col-md-10 col-md-push-1">
                              <div id="area2" class="area2" style="align-items: center;border: 3px dashed #aaa;border-radius: 5px;color: #555;display: flex;flex-flow: column nowrap;font-size: 15px;justify-content: center;max-height: 200px;margin: 30px auto;overflow: auto;text-align: center;white-space: pre-line;width: 100%;">
                                  <i class="fa fa-cloud-upload" style="font-size:40px;"></i>
                                  <small id="msj12">Arrastre archivo PDF aquí</small>
                                  <small id="msj22" class="text-center">O haga click para buscar el archivo</small>

                                  <input type="file" id="files2" name="archivoPDF2" class="form-control uploader2" />
                              </div>
                              <style>
                                  .dragging2 {
                                      background-color: rgba(255, 255, 0, .3);
                                      background-color:lightblue;
                                  } 
                                  .uploader2{
                                      opacity: 0;
                                      height:60%;
                                      width:90%;
                                      padding:0%;
                                      z-index:0;
                                      position:absolute;
                                  }

                              </style>
                          </div>
                          <div id="divobser2" class="col-md-10 col-md-push-1 oculgen carga"><br>
                              <label class="col-md-4 control-label" for="textinput2">Observaciones/Comentarios</label>  
                              <textarea id="txtobserv2" name="txtobserv2" class="form-control" style="resize: none;" required></textarea>
                              <br>
                          </div>
                          <div class="col-md-10 col-md-push-1 oculgen carga">
                              <button id="subirarchivo2" type="submit" class="btn btn-info pull-right" data-toggle="tooltip" data-placement="top" title="Guardar"><span class="fa fa-save"></span></button>
                              <button id="resetform2" class="btn btn-danger pull-right" type="reset" data-toggle="tooltip" data-placement="top" title="Cancelar"><span class="fa fa-remove"></span></button>
                          </div>
                          <div class="col-md-10 col-md-push-1">
                              <h4 id="respuesta2"></h4>
                          </div>
                          <iframe width="1" height="1" frameborder="0" name="contenedor_subir_archivo2" style="display: none"></iframe>
                      </form>
                  </div>

              </div>
              <div class="modal-footer"> 
                  <button type="button" class="btn btn-info" data-dismiss="modal" onclick="$('#resetform2').click()">Cerrar</button>
              </div> 
          </div> 
      </div>
  </div>
<!-- FIN Modal EDITAR Adjuntos-->

<!-- Modal programacion actividades-->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_prog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   <center> <h3><span class="fa fa-edit"></span><b> Este activo NO tiene programación de actividades vigente</b></h3></center>
                </div>
                <form id="form_prog" method="post" class="formul">
                    <div class="modal-body">
                        <input type="hidden" name="idact" id="idactivo">
                        <center><h4><b>¿Desea programar mantenimiento y revisión?</b></h4></center><br>
                        <div class="row">
                            <div class="form-group">
                              <label class="col-md-4 control-label" for="ultfechamtto">Fecha último Mantenimiento</label>  
                              <div class="col-md-5">
                              <input id="ultfechamtto" name="ultfechamtto" type="text" class="form-control input-md dateform" required value="<?php echo date('Y-m-d');?>" style="color: transparent;text-shadow: 0 0 0 black;text-align: center;" max="<?php echo date('Y-m-d');?>">
                              </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                              <label class="col-md-4 control-label" for="ultfecharev">Fecha última Revisión</label>  
                              <div class="col-md-5">
                              <input id="ultfecharev" name="ultfecharev" type="text" class="form-control input-md dateform" required value="<?php echo date('Y-m-d');?>" style="color: transparent;text-shadow: 0 0 0 black;text-align: center;" max="<?php echo date('Y-m-d');?>">
                              </div>
                            </div>
                        </div>
                        <br>
                        <center>La revisión y mantenimiento serán programadas a partir de las fechas anteriores y con la frecuencia de éstas asignadas al activo</center>
                        <br><br>
                        <center><h4><b>Programación Automática del resto del año</b></h4> </center>
                        <div class="row">
                            <div class="form-group col-md-4 col-md-push-3" data-toggle="tooltip" data-placement="bottom" title="Seleccione si desea programar automaticamente las proximas revisiones del año a partir de la ultima fecha">
                                <label class="control-label">Revisiones</label><br>
                                <div class="pull-left">
                                  <div class="TriSea-technologies-Switch col-md-2">
                                      <input id="autorev" name="autorev" class="autorev" type="checkbox"/>
                                      <label for="autorev" class="label-primary"></label>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4 col-md-push-2" data-toggle="tooltip" data-placement="bottom" title="Seleccione si desea programar automaticamente los proximos mantenimientos del año a partir de la ultima fecha">
                                <label class="control-label">Mantenimientos</label><br>
                                <div class="pull-left">
                                  <div class="TriSea-technologies-Switch col-md-2">
                                      <input id="automtto" name="automtto" class="automtto" type="checkbox"/>
                                      <label for="automtto" class="label-primary"></label>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button id="genprog" type="submit" class="btn btn-success" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Generando...">Programar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal programacion -->

<style>
   .TriSea-technologies-Switch > input[type="checkbox"] {
          display: none;   
      }

      .TriSea-technologies-Switch > label {
          cursor: pointer;
          height: 0px;
          position: relative; 
          width: 40px;  
      }

      .TriSea-technologies-Switch > label::before {
          background: rgb(0, 0, 0);
          box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
          border-radius: 8px;
          content: '';
          height: 16px;
          margin-top: -8px;
          position:absolute;
          opacity: 0.3;
          transition: all 0.4s ease-in-out;
          width: 40px;
      }
      .TriSea-technologies-Switch > label::after {
          background: rgb(255, 255, 255);
          border-radius: 16px;
          box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
          content: '';
          height: 24px;
          left: -4px;
          margin-top: -8px;
          position: absolute;
          top: -4px;
          transition: all 0.3s ease-in-out;
          width: 24px;
      }
      .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::before {
          background: inherit;
          opacity: 0.5;
      }
      .TriSea-technologies-Switch > input[type="checkbox"]:checked + label::after {
          background: inherit;
          left: 20px;
      }
</style>     

<script>   //start 


    $('[data-toggle="tooltip"]').tooltip();
    $('#side-menu').children(".active").removeClass("active");
    $("#ACTIVO").addClass("active");

    $('.fecha').datetimepicker({
        format: "YYYY-MM-DD",
                locale: "es",
                useCurrent: false
    });
    $('#sellugar').selectpicker({
            liveSearch: true,
            title:'Buscar y seleccionar lugar...'
    });

    $('#selinsumos').selectpicker({
            liveSearch: true,
            title:'Buscar y seleccionar insumo...'
    });

     $('#selrepuesto').selectpicker({
            liveSearch: true,
            title:'Buscar y seleccionar insumo...'
    });

    $('#provdor').selectpicker({
        liveSearch: true,
        title:'Buscar y seleccionar proveedor...'
    });
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
            $("#generico").prop('checked', true).change();
        }else{
            $("#generico").prop('checked', false).change();
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

        if(mtto==1 || rev==1){
            $(".revmtto").show();
            loadrevmtto(act);
        }else{
            $(".revmtto").hide();
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

        $('#mttosw').change(function(){
          if(this.checked){
              $("#freqmtto").removeAttr('disabled');
              $("#freqmtto").val('');
              $('#fqmtto').fadeIn('slow');
            }
          else{
            $('#fqmtto').fadeOut();
            $("#freqmtto").attr('disabled', 'disabled');
          }
        });

        $('#revsw').change(function(){
            if(this.checked){
                $("#freqrev").removeAttr('disabled');
                $("#freqrev").val('');
                $('#fqrev').fadeIn('slow');
            }else{
                $('#fqrev').fadeOut();
              $("#freqrev").attr('disabled', 'disabled');
            }
        });

        $('#garactsw').change(function(){
            if(this.checked){
                $("#timegar").removeAttr('disabled');
                $("#timegar").val('');
                $('.garact').fadeIn('slow');
            }else{
                $('.garact').fadeOut();
              $("#timegar").attr('disabled', 'disabled');
            }
        });

        $('#garactsw2').change(function(){
            if(this.checked){
                $("#cantuso").removeAttr('disabled');
                $("#cantuso").val('');
                $('.garact2').fadeIn('slow');
            }else{
                $('.garact2').fadeOut();
              $("#cantuso").attr('disabled', 'disabled');
            }
        });

        $('#insumos').change(function(){
          if(this.checked){
              $(".addinsumos").show();
            $("#tbinsumo").show();
            }
          else{
            $(".addinsumos").hide();
            $("#tbinsumo").hide();
          }
        });
        $('#swrepuesto').change(function(){
          if(this.checked){
            $(".addrepuesto").show();
            $("#tbrepuesto").show();
            }
          else{
            $(".addrepuesto").hide();
            $("#tbrepuesto").hide();
          }
        });
    });

    $("#exportPDF").click(function(e){
      var idact=$("#codigo").val();
      window.open('php/repindivactivo.php?id_act='+idact);
    })
</script>
<script>   //forms modales 
   
    $("#btnnewlug").click(function(e){
        $("#modal_newlugar").modal('show');
    });

    $("#form_newlug").submit(function(e){
        e.preventDefault();
        var formdata=$(this).serialize();
        $.ajax({
            url:'php/operlugararea.php',
            type:'GET',
            data:'opc=addlug&'+formdata,
            success:function(res){
                if(res=='true'){
                    $("#modal_newlugar").modal('hide');
                    $('#sellugar').selectpicker('refresh')
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado, por favor refresque la página e intentelo nuevamente.','error');
                }
            }
        });
    });
    $(".nomlugar").keyup(function(e){
        var str=$(this).val();
        $.ajax({
            url:'php/operlugararea.php',
            type:'GET',
            data:'opc=buslug&str='+str,
            success:function(res){
                if(res=='false'){
                    $(".infolug").html('<h4><font color="red"> Ya existe este nombre</font><input tipo="text" hidden required /></h4>');
                }else{
                    $(".infolug").html('');
                }
            }   
        })
    });
    $(".nomlugar").blur(function(e){
        var str=$(this).val();
        $.ajax({
            url:'php/operlugararea.php',
            type:'GET',
            data:'opc=buslug&str='+str,
            success:function(res){
                if(res=='false'){
                    $(".infolug").html('<h4><font color="red"> Ya existe este nombre</font><input tipo="text" hidden required /></h4>');
                }else{
                    $(".infolug").html('');
                }
            }   
        })
    });

    $("#form_insumos").submit(function(e){
        e.preventDefault();
        var formdata=$(this).serialize();
        $.ajax({
            url:'php/loadselact.php',
            type:'POST',
            data:'opc=addinsumo&'+formdata,
            success:function(res){
                if(res=='true'){
                    $("#modal_insumos").modal('hide');
                    $('#selinsumos').selectpicker('refresh')
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado, por favor refresque la página e intentelo nuevamente.','error');
                }
            }
        });
    });
    $("#insname").keyup(function(e){
        var str=$(this).val();
        $.ajax({
            url:'php/loadselact.php',
            type:'POST',
            data:'opc=seekins&str='+str,
            success:function(res){
                if(res=='false'){
                    $("#infoinsumo").html('<h4><font color="red"> Ya existe este insumo</font><input tipo="text" hidden required /></h4>');
                }else{
                    $("#infoinsumo").html('');
                }
            }   
        })
    });
    $("#insname").blur(function(e){
        var str=$(this).val();
        $.ajax({
            url:'php/loadselact.php',
            type:'POST',
            data:'opc=seekins&str='+str,
            success:function(res){
                if(res=='false'){
                    $("#infoinsumo").html('<h4><font color="red"> Ya existe este insumo</font><input tipo="text" hidden required /></h4>');
                }else{
                    $("#infoinsumo").html('');
                }
            }   
        })
    });

    $("#form_repu").submit(function(e){
      e.preventDefault();
      var formdata=$(this).serialize();
      $.ajax({
          url:'php/loadselact.php',
          type:'POST',
          data:'opc=addrepu&'+formdata,
          success:function(res){
              if(res=='true'){
                  $("#modal_repu").modal('hide');
                  $('#selrepuesto').selectpicker('refresh')
              }else{
                  swal('Oops!','Ha ocurrido un error inesperado, por favor refresque la página e intentelo nuevamente.','error');
              }
          }
      });
    });
    $("#repname").keyup(function(e){
        var str=$(this).val();
        $.ajax({
            url:'php/loadselact.php',
            type:'POST',
            data:'opc=seekrep&str='+str,
            success:function(res){
                if(res=='false'){
                    $("#inforepu").html('<h4><font color="red"> Ya existe este repuesto</font><input tipo="text" hidden required /></h4>');
                }else{
                    $("#inforepu").html('');
                }
            }   
        })
    });
    $("#repname").blur(function(e){
        var str=$(this).val();
        $.ajax({
            url:'php/loadselact.php',
            type:'POST',
            data:'opc=seekrep&str='+str,
            success:function(res){
                if(res=='false'){
                    $("#inforepu").html('<h4><font color="red"> Ya existe este repuesto</font><input tipo="text" hidden required /></h4>');
                }else{
                    $("#inforepu").html('');
                }
            }   
        })
    });

    $("#resetform").click(function(e){
      location.reload();
    });
    function done () {
        swal({
          title: "Activo actualizado exitosamente",
          text: "",
          type: "success",
          confirmButtonText: "Ok"
          },
          function () {
              location.reload();
        });
    }
    $("#addprov").click(function(e){
        e.preventDefault();
        window.open('../../beauty/beauty-adm/nuevo_proveedor.php');
    })

    $("#btnnewarea").click(function(e){
        var idlug=$("#sellugar").val();
        if(idlug>0){
          var nomlug=$("#sellugar option:selected").text();
          $("#titmodluar").html(nomlug);
          $("#idlug").val(idlug);
          $("#modal_newarealug").modal('show');
        }else{
          swal('Atención!','Debe seleccionar un lugar para poder crear áreas.','warning')
        }
    });

    $("#form_newarea").submit(function(e){
        e.preventDefault();
        var formdata=$(this).serialize();
        var idlug=$("#sellugar").val();
        $.ajax({
            url:'php/operlugararea.php',
            type:'GET',
            data:'opc=addarea&'+formdata,
            success:function(res){
                if(res=='true'){
                    $("#areas").load('php/operlugararea.php?opc=loadarea&id='+idlug);
                    loadarea();
                    $("#modal_newarealug").modal('hide');
                    $("#form_newarea")[0].reset();
                    closemodal($("#modal_newarealug"),$("#selar"));
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado, recargue la página e intentelo nuevamente','error');
                }
            }
        })
    });

    $(".nomarea").keyup(function(e) {
       var str=$(this).val();
       var idlug=$("#sellugar").val();
        $.ajax({
            url:'php/operlugararea.php',
            type:'GET',
            data:'opc=valnomarea&str='+str+'&idlug='+idlug,
            success:function(res){
                if(res=='false'){
                    $(".infoar").html('<h4><font color="red"> Ya existe esta area en este lugar</font><input tipo="text" hidden  required/></h4>');
                }else{
                    $(".infoar").html('');
                }
            }   
        })
    });
    $(".nomarea").blur(function(e) {
       var str=$(this).val();
       var idlug=$("#sellugar").val();
        $.ajax({
            url:'php/operlugararea.php',
            type:'GET',
            data:'opc=valnomarea&str='+str+'&idlug='+idlug,
            success:function(res){
                if(res=='false'){
                    $(".infoar").html('<h4><font color="red"> Ya existe esta area en este lugar</font><input tipo="text" hidden  required/></h4>');
                }else{
                    $(".infoar").html('');
                }
            }   
        })
    });

    $("#form_pais").submit(function(e){
      e.preventDefault();
      var formdata=$(this).serialize();
      $.ajax({
        url:'php/loadselact.php',
        type:'POST',
        data:'opc=addpais&'+formdata,
        success:function(res){
          loadpais();
          $("#modal_pais").modal('hide');
          $("#form_pais")[0].reset();
          closemodal($("#modal_pais"),$("#pais"));
        }
      })
    });

    $("#paisname").keyup(function(e) {
       var str=$(this).val();
        $.ajax({
            url:'php/loadselact.php',
            type:'POST',
            data:'opc=seekpais&key='+str,
            success:function(res){
                if(res=='false'){
                    $("#infopais").html('<h4><font color="red"> Ya existe este pais, verifique</font><input tipo="text" hidden  required/></h4>');
                }else{
                    $("#infopais").html('');
                }
            }   
        })
    });
    $("#paisname").blur(function(e) {
       var str=$(this).val();
        $.ajax({
            url:'php/loadselact.php',
            type:'POST',
            data:'opc=seekpais&key='+str,
            success:function(res){
                if(res=='false'){
                    $("#infopais").html('<h4><font color="red"> Ya existe este pais, verifique</font><input tipo="text" hidden  required/></h4>');
                }else{
                    $("#infopais").html('');
                }
            }   
        })
    });

    $("#form_fab").submit(function(e){
      e.preventDefault();
      var formdata=$(this).serialize();
      $.ajax({
        url:'php/loadselact.php',
        type:'POST',
        data:'opc=addfab&'+formdata,
        success:function(res){
          loadfabrica();
          $("#modal_fab").modal('hide');
          $("#form_fab")[0].reset();
          closemodal($("#modal_fab"),$("#fabrica"));
        }
      })
    });

    $("#fabname").keyup(function(e) {
       var str=$(this).val();
        $.ajax({
            url:'php/loadselact.php',
            type:'POST',
            data:'opc=seekfab&key='+str,
            success:function(res){
                if(res=='false'){
                    $("#infofab").html('<h4><font color="red"> Ya existe este fabricante, verifique</font><input tipo="text" hidden required /></h4>');
                }else{
                    $("#infofab").html('');
                }
            }   
        })
    });
    $("#fabname").blur(function(e) {
       var str=$(this).val();
        $.ajax({
            url:'php/loadselact.php',
            type:'POST',
            data:'opc=seekfab&key='+str,
            success:function(res){
                if(res=='false'){
                    $("#infofab").html('<h4><font color="red"> Ya existe este fabricante, verifique</font><input tipo="text" hidden required /></h4>');
                }else{
                    $("#infofab").html('');
                }
            }   
        })
    });

    $("#form_uni1").submit(function(e){
      e.preventDefault();
      var formdata=$(this).serialize();
      $.ajax({
        url:'php/loadselact.php',
        type:'POST',
        data:'opc=adduni1&'+formdata,
        success:function(res){
          loadunitie();
          $("#modal_uni1").modal('hide');
          $("#form_uni1")[0].reset();
          closemodal($("#modal_uni1"),$("#unitime"));
        }
      })
    });

    $("#uniname1").keyup(function(e) {
       var str=$(this).val();
        $.ajax({
            url:'php/loadselact.php',
            type:'POST',
            data:'opc=seekuni1&key='+str,
            success:function(res){
                if(res=='false'){
                    $("#infouni1").html('<h4><font color="red"> Ya existe esta unidad de tiempo, verifique</font><input tipo="text" hidden required /></h4>');
                }else{
                    $("#infouni1").html('');
                }
            }   
        })
    });
    $("#uniname1").blur(function(e) {
       var str=$(this).val();
        $.ajax({
            url:'php/loadselact.php',
            type:'POST',
            data:'opc=seekuni1&key='+str,
            success:function(res){
                if(res=='false'){
                    $("#infouni1").html('<h4><font color="red"> Ya existe esta unidad de tiempo, verifique</font><input tipo="text" hidden required /></h4>');
                }else{
                    $("#infouni1").html('');
                }
            }   
        })
    });

    $("#form_uni2").submit(function(e){
      e.preventDefault();
      var formdata=$(this).serialize();
      $.ajax({
        url:'php/loadselact.php',
        type:'POST',
        data:'opc=adduni2&'+formdata,
        success:function(res){
         loaduniuso();
          $("#modal_uni2").modal('hide');
          $("#form_uni2")[0].reset();
          closemodal($("#modal_uni2"),$("#uniuso"));
        }
      })
    });

    $("#uniname2").keyup(function(e) {
       var str=$(this).val();
        $.ajax({
            url:'php/loadselact.php',
            type:'POST',
            data:'opc=seekuni2&key='+str,
            success:function(res){
                if(res=='false'){
                    $("#infouni2").html('<h4><font color="red"> Ya existe esta unidad de uso, verifique</font><input tipo="text" hidden required /></h4>');
                }else{
                    $("#infouni2").html('');
                }
            }   
        })
    });
    $("#uniname2").blur(function(e) {
       var str=$(this).val();
        $.ajax({
            url:'php/loadselact.php',
            type:'POST',
            data:'opc=seekuni2&key='+str,
            success:function(res){
                if(res=='false'){
                    $("#infouni2").html('<h4><font color="red"> Ya existe esta unidad de uso, verifique</font><input tipo="text" hidden required /></h4>');
                }else{
                    $("#infouni2").html('');
                }
            }   
        })
    });

    $(document).ready(function() { 

          
          
          $('#marname').keyup(function(){
            this.value=this.value.toUpperCase();
            var name = $(this).val();        
            var dataString = 'opc=seekmar&key='+name;
            $.ajax({
                type: "POST",
                url: "php/loadselact.php",
                data: dataString,
                success: function(data) {
                    if(data=='false'){
                      $("#infomar").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe esta marca</font></div>');
                    }else{
                      $("#infomar").html('');
                    }
                }
            });
          });
          $('#marname').blur(function(){
            this.value=this.value.toUpperCase();
            var name = $(this).val();        
            var dataString = 'opc=seekmar&key='+name;
            $.ajax({
                type: "POST",
                url: "php/loadselact.php",
                data: dataString,
                success: function(data) {
                    if(data=='false'){
                      $("#infomar").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe esta marca</font></div>');
                    }else{
                      $("#infomar").html('');
                    }
                }
            });
          });
          function ok() {
              swal({
                  title: "nueva opcion agregada correctamente",
                  text: "",
                  type: "success",
                  confirmButtonText: "Aceptar"
              },
              function () {
                  //window.location = "new_activo.php";
              });
          }


          $("#form_mar").on("submit", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "php/loadselact.php",
                data: $(this).serialize()+'&opc=addmar',
                success: function(data) {
                    if (data == "TRUE"){
                      loadmar();
                      $("#form_mar")[0].reset();
                      $(".modal").modal('hide');
                      closemodal($("#modal_marca"),$("#marcas"));
                    }else{
                      swal('Oops!','Ha ocurrido un error inesperado; refresque la pagina e intentelo nuevamente','error');
                    }  
                }
            });
          });

          /*$('#act_name').blur(function(){
              $(this).val = $(this).val().toUpperCase();
              var username = $(this).val();        
              var dataString = 'act_name='+username;
              $.ajax({
                  type: "POST",
                  url: "check_activos.php",
                  data: dataString,
                  success: function(data) {
                      $('#Info').fadeIn(1000).html(data);
                  }
              });
          });  */
  
    });


    $(".modal").on("hidden.bs.modal", function () {
          $("#form_gra")[0].reset();
          $("#form_tia")[0].reset();
          $("#form_subgra")[0].reset();
          $("#form_subtia")[0].reset();
          $("#form_mar")[0].reset();
          $("#form_pais")[0].reset();
          $("#form_newlug")[0].reset();
          $("#form_newarea")[0].reset();
          $("#form_insumos")[0].reset();
          $("#form_repu")[0].reset();
          $(".err").html('');
    });
</script>
<script>    //eventos y funciones de selects
      $("#imagen").on("change", function(){
          mostrarImagen(this);
      });

      $("#selinsumos").change(function(e){
         var ins=$(this).val();
         if(ins!=0){
            $("#cantinsumo").removeAttr('disabled');
            $("#assigninsumo").removeAttr('disabled');
            $("#cantinsumo").focus();
         }else{
            $("#cantinsumo").attr('disabled', 'disabled');
            $("#assigninsumo").attr('disabled', 'disabled');
            $("#cantinsumo").val('');
         }
      });

      $("#selrepuesto").change(function(e){
         var ins=$(this).val();
         if(ins!=0){
            $("#cantrepuesto").removeAttr('disabled');
            $("#assignrepuesto").removeAttr('disabled');
            $("#cantrepuesto").focus();
         }else{
            $("#cantrepuesto").attr('disabled', 'disabled');
            $("#assignrepuesto").attr('disabled', 'disabled');
            $("#cantrepuesto").val('');
         }
      });


      function mostrarImagen(input) {

          var imagen = input.files[0];
          var stringImagen = imagen["type"].split("/");
          var tipoImagen = stringImagen[1];
          var tamanoImagen = imagen["size"];

          if((tipoImagen != "jpeg") && (tamanoImagen < 512000)){

              swal("Error", "Debe subir una imagen con extensi\u00F3n .jpg", "error");
              $("#imagen").val('');
          }
          else if((tipoImagen == "jpeg") && (tamanoImagen > 512000)){

              swal("Error", "Debe subir una imagen con tama\u00F1o menor a 500KB", "error");
              $("#imagen").val('');
          }
          else if((tipoImagen != "jpeg") && (tamanoImagen > 512000)){

              swal("Error", "Debe subir una imagen con extensi\u00F3n .jpg. Debe subir una imagen con tama\u00F1o menor a 500KB", "error");
              $("#imagen").val('');
          }
          else{

              if (input.files && input.files[0]) {
                
                  var reader = new FileReader();
                
                  reader.onload = function (e) {
                      $('#imgact').attr('src', e.target.result);
                  }
                
                  reader.readAsDataURL(input.files[0]);
              }
          }
      }

      function loadmar(){
        $.ajax({
          url:'php/loadselact.php',
          type:'POST',
          data:'opc=mar',
          success:function(res){
            $("#marcas").html(res); 
          }
        })
      }

      function loadarea(){
        $("#selar").html('');
        var idlug=$("#sellugar").val();
        $.ajax({
            url:'php/operlugararea.php',
            type:'GET',
            data:'opc=loadselarea&id='+idlug,
            success:function(res){
                var json = JSON.parse(res);
                var ar = "";
                for(var i in json){
                    ar += "<option value='"+json[i].id+"'>"+json[i].name+"</option>";
                }
                $("#selar").html(ar);
            }
        });
      }

      function loadprove(){
        $.ajax({
          url:'php/loadselact.php',
          type:'POST',
          data:'opc=prov',
          success:function(res){
            $("#provdor").html(res); 
          }
        });
      }

      function loadfabrica(){
        $.ajax({
          url:'php/loadselact.php',
          type:'POST',
          data:'opc=fab',
          success:function(res){
            $("#fabrica").html(res); 
          }
        });
      }

      function loadpais(){
        $.ajax({
          url:'php/loadselact.php',
          type:'POST',
          data:'opc=pais',
          success:function(res){
            $("#pais").html(res); 
          }
        });
      }

      function loadprio(){
        $.ajax({
          url:'php/loadselact.php',
          type:'POST',
          data:'opc=prio',
          success:function(res){
            $("#prioridad").html(res); 
            $("#prioact").html(res); 
          }
        });
      }

      function loadunitie(){
        $.ajax({
          url:'php/loadselact.php',
          type:'POST',
          data:'opc=unitie',
          success:function(res){
            $("#unitime").html(res); 
          }
        });
      }

      function loaduniuso(){
        $.ajax({
          url:'php/loadselact.php',
          type:'POST',
          data:'opc=uniuso',
          success:function(res){
            $("#uniuso").html(res); 
          }
        });
      }
</script>
<script>    //funciones encontrar mayor indice select y funcion cerrar modal
      function findMaxValue(element) {
          var maxValue = undefined;
          $('option', element).each(function() {
              var val = $(this).attr('value');
              val = parseInt(val, 10);
              if (maxValue === undefined || maxValue < val) {
                  maxValue = val;
              }
          });
          element.val(maxValue);
      }


      function closemodal(ele1,ele2){
        ele1.on("hidden.bs.modal", function () {
            findMaxValue(ele2);
            changeprio();
        });
      }
</script>
<script>    //funciones y eventos en busqueda de select 2
    $('#sellugar').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('algo');
        $('.algo .form-control').attr('id', 'fucker');
    });

    $(document).on('keyup', '#fucker', function(event) {
        var seek = $(this).val();
        $.ajax({
            url: 'php/operlugararea.php',
            type: 'GET',
            data:'opc=loadsellug&key='+seek,
            success: function(data){
                var json = JSON.parse(data);
                var lugs = "";
                for(var i in json){
                    lugs += "<option value='"+json[i].id+"'>"+json[i].name+"</option>";
                }
                $("#sellugar").html(lugs);
                $("#sellugar").selectpicker('refresh');
            }
        }); 
    });

    $('#provdor').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('proveclass');
        $('.proveclass .form-control').attr('id', 'proveid');
    });

    $(document).on('keyup', '#proveid', function(event) {
        var seek = $(this).val();
        $.ajax({
            url: 'php/loadselact.php',
            type: 'POST',
            data:'opc=prov&key='+seek,
            success: function(data){
                $("#provdor").html(data);
                $("#provdor").selectpicker('refresh');
            }
        }); 
    });

    $('#selinsumos').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('insclass');
        $('.insclass .form-control').attr('id', 'insuid');
    });

    $(document).on('keyup', '#insuid', function(event) {
        var seek = $(this).val();
        $.ajax({
            url: 'php/loadselact.php',
            type: 'POST',
            data:'opc=insumo&key='+seek,
            success: function(data){
                $("#selinsumos").html(data);
                $("#selinsumos").selectpicker('refresh');
            }
        }); 
    });

    $('#selrepuesto').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('repclass');
        $('.repclass .form-control').attr('id', 'repuid');
    });

    $(document).on('keyup', '#repuid', function(event) {
        var seek = $(this).val();
        $.ajax({
            url: 'php/loadselact.php',
            type: 'POST',
            data:'opc=repuesto&key='+seek,
            success: function(data){
                $("#selrepuesto").html(data);
                $("#selrepuesto").selectpicker('refresh');
            }
        }); 
    });

    $("#sellugar").change(function(e){
        loadarea();
    });   
</script>
<script>    // validacion de serial y codigo externo unicos
  $("#serial").keyup(function(e){
    var actcod='<?php echo $codigo;?>';
    var str=$(this).val();
    $.ajax({
      url:'php/loadselact.php',
      type:'POST',
      data:'opc=seeksnedt&txt='+str+'&actcod='+actcod,
      success:function(res){
        if(res=='false'){
          $("#infosn").html('<h4><font color="red"> Este serial ya ha sido registrado</font><input tipo="text" hidden required /></h4>');
        }else{
          $("#infosn").html('');
        }
      }
    });
  });
  $("#serial").blur(function(e){
    var actcod='<?php echo $codigo;?>';
    var str=$(this).val();
    $.ajax({
      url:'php/loadselact.php',
      type:'POST',
      data:'opc=seeksnedt&txt='+str+'&actcod='+actcod,
      success:function(res){
        if(res=='false'){
          $("#infosn").html('<h4><font color="red"> Este serial ya ha sido registrado</font><input tipo="text" hidden required /></h4>');
        }else{
          $("#infosn").html('');
        }
      }
    });
  });

  $("#codext").keyup(function(e){
    var str=$(this).val();
    var actcod='<?php echo $codigo;?>';
    $.ajax({
      url:'php/loadselact.php',
      type:'POST',
      data:'opc=seekcodexedt&txt='+str+'&actcod='+actcod,
      success:function(res){
        if(res=='false'){
          $("#infocodex").html('<h4><font color="red"> Este codigo ya ha sido registrado</font><input tipo="text" hidden  required/></h4>');
        }else{
          $("#infocodex").html('');
        }
      }
    });
  });
  $("#codext").blur(function(e){
    var str=$(this).val();
    var actcod='<?php echo $codigo;?>';
    $.ajax({
      url:'php/loadselact.php',
      type:'POST',
      data:'opc=seekcodexedt&txt='+str+'&actcod='+actcod,
      success:function(res){
        if(res=='false'){
          $("#infocodex").html('<h4><font color="red"> Este codigo ya ha sido registrado</font><input tipo="text" hidden  required/></h4>');
        }else{
          $("#infocodex").html('');
        }
      }
    });
  });
</script>
<script>    //submit y validacion de formulario editar
  $("#form_atc").on("submit", function(e){
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      console.log(formData);
      $.ajax({
          url: "php/insert_activo.php",
          type: "post",
          dataType: "html",
          contentType: false,
          cache: false,
          processData:false,
          data: formData
      })
      .done(function(res){
         if (res == "TRUE") {
          done();
         }
      });
    
  });
    function validar(){
        var sw,sw1,sw2,sw3,sw4,swm,swm1,swm2,swm3,swg1,sgw2,a,b,c,d,e,f;
        //generalidades***********************************************************************************************************
        if(($("#act_name").val()!='') && ($("#marcas").val()!=0) && ($("#modelo").val()!='') && ($("#especificaciones").val()!='') && ($("#serial").val()!='') && ($("#marcadescripcion").val()!='')){sw1=0}else{sw1=1}
          if(sw1==1){$(".tit1").html('(Incompleto)');a=0;}else{$(".tit1").html('');a=1;}
        //datos de compra***********************************************************************************************************
        if(($("#marcafecha").val()!='') && ($("#proveedor").val()!=0) && ($("#fabrica").val()!=0) && ($("#pais").val()!=0) && ($("#codext").val()!='') && ($("#costobase").val()!='') && ($("#impuesto").val()!='')){sw2=0}else{sw2=1}
          if(sw2==1){$(".tit2").html('(Incompleto)');b=0;}else{$(".tit2").html('');b=1;}
        //clasificacion***********************************************************************************************************
        if(($("#tipoactivo").val()!=0) && ($("#grupoactivo").val()!=0)){sw3=0}else{sw3=1}
          if(sw3==1){$(".tit3").html('(Incompleto)');c=0;}else{$(".tit3").html('');c=1;}
        //ubicacion***********************************************************************************************************
        if($("#selar").val()!=0){sw4=0;}else{sw4=1;}
          if(sw4==1){$(".tit4").html('(Incompleto)');d=0;}else{$(".tit4").html('');d=1;}
        //mantenimiento***********************************************************************************************************
        swm1=1,swm2=1;
        if($("#mttosw").is(':checked')){
          if($("#freqmtto").val()==''){swm1=0;}
        }
        if($("#revsw").is(':checked')){
          if($("#freqrev").val()==''){swm2=0;}
        }
        if($("#prioridad").val()!=0){swm3=1;}else{swm3=0;}
        e=swm1*swm2*swm3;
          if(e==0){$(".tit5").html('(Incompleto)');}else{$(".tit5").html('');}
        //garantia***********************************************************************************************************
        swg1=1,swg2=1;
        if($("#garactsw").is(':checked')){
          if(($("#timegar").val()=='') || ($("#unitime").val()==0)){swg1=0;}
        }
        if($("#garactsw2").is(':checked')){
          if(($("#cantuso").val()=='') || ($("#uniuso").val()==0)){swg2=0;}
        }
        f=swg1*swg2
           if(f==0){$(".tit6").html('(Incompleto)');}else{$(".tit6").html('');}
        //insumos =>sin validacion de campos incompletos por ahora
        //repuestos =>sin validacion de campos incompletos por ahora

        sw=a*c*b*d*e*f;

        return sw;
    }
  $(".panel-heading").click(function(e){
    $( e.target ).find('small').html('');
  });

    $('.number').on('input', function () { 
        this.value = this.value.replace(/[^0-9.]/g,'');
    });
</script>
<script>    //botones de edicion de opciones select
  $("#editmar").click(function(e){
    e.preventDefault();
    $("#oldmar").hide();
    $("#newmar").fadeIn();
  })
  $("#editpro").click(function(e){
    e.preventDefault();
    $("#oldpro").hide();
    $("#newpro").fadeIn();
  })
  $("#editfab").click(function(e){
    e.preventDefault();
    $("#oldfab").hide();
    $("#newfab").fadeIn();
  })
  $("#editpai").click(function(e){
    e.preventDefault();
    $("#oldpai").hide();
    $("#newpai").fadeIn();
  })
  $("#edittigru").click(function(e){
    e.preventDefault();
    $("#oldtigru").hide();
    $("#newtigru").fadeIn();
  })
  $("#editpri").click(function(e){
    e.preventDefault();
    $("#oldpri").hide();
    $("#newpri").fadeIn();
  })
  $("#editgar1").click(function(e){
    e.preventDefault();
    $("#oldgar1").hide();
    $(".garact").fadeIn();
    $(".swgaract1").fadeIn();
  })
  $("#editgar2").click(function(e){
    e.preventDefault();
    $("#oldgar2").hide();
    $(".garact2").fadeIn();
    $(".swgaract2").fadeIn();
  })
</script>
<script>    //funciones de insumos y repuestos
    $("#assigninsumo").click(function(e){
      e.preventDefault();
      var idact=$("#codigo").val();
      var idins=$("#selinsumos").val();
      var cant=$("#cantinsumo").val();
      if(cant>0){
        datos='opc=assignins&idact='+idact+'&idins='+idins+'&cant='+cant;
        $.ajax({
          url:'php/loadselact.php',
          type:'POST',
          data:datos,
          success:function(res){
            if(res=='true'){
              swal('Insumo asignado!','','success');
              $('[data-toggle="tooltip"], .tooltip').tooltip("hide");
              loadinsumos();
              $("#selinsumos").html('');
              $("#selinsumos").selectpicker('refresh');
              $("#cantinsumo").val('');
              $("#cantinsumo").attr('disabled', 'disabled');
              $("#assigninsumo").attr('disabled', 'disabled');
            }else if(res=='dup'){
              swal('Ya asignado!','Este insumo ya está asignado a este activo, Verifique.','warning');
            }
            else{
              swal('Oops!','ha ocurrido un error inesperado, refresque la pagina e intentelo nuevamente.','warning');
            }
          }
        })
      }else{
        swal('Debe especificar la cantidad','','warning');
      }
    });

    $("#assignrepuesto").click(function(e){
      e.preventDefault();
      var idact=$("#codigo").val();
      var idrep=$("#selrepuesto").val();
      var cant=$("#cantrepuesto").val();
      if(cant>0){
        datos='opc=assignrep&idact='+idact+'&idrep='+idrep+'&cant='+cant;
        $.ajax({
          url:'php/loadselact.php',
          type:'POST',
          data:datos,
          success:function(res){
            if(res=='true'){
              swal('Repuesto asignado!','','success');
              $('[data-toggle="tooltip"], .tooltip').tooltip("hide");
              loadrepuestos();
              $("#selrepuesto").html('');
              $("#selrepuesto").selectpicker('refresh');
              $("#cantrepuesto").val('');
              $("#cantrepuesto").attr('disabled', 'disabled');
              $("#assignrepuesto").attr('disabled', 'disabled');
            }else if(res=='dup'){
              swal('Ya asignado!','Este repuesto ya está asignado a este activo, Verifique.','warning');
            }
            else{
              swal('Oops!','ha ocurrido un error inesperado, refresque la pagina e intentelo nuevamente.','warning');
            }
          }
        })
      }else{
        swal('Debe especificar la cantidad','','warning');
      }
    });

    function loadinsumos(){
      var idact=$("#codigo").val();
      $.ajax({
        url:'php/loadselact.php',
        type:'POST',
        data:'opc=loadtbinsu&idact='+idact,
        success:function(res){
          $("#tbodyinsumos").html(res);
           $('[data-toggle="tooltip"]').tooltip();
        }
      })
    }
    function loadrepuestos(){
      var idact=$("#codigo").val();
      $.ajax({
        url:'php/loadselact.php',
        type:'POST',
        data:'opc=loadtbrep&idact='+idact,
        success:function(res){
          $("#tbodyrepuestos").html(res);
           $('[data-toggle="tooltip"]').tooltip();
        }
      })
    }
    $(document).ready(function() {
      loadinsumos();
      loadrepuestos();
    });
</script>
<script>    //funciones de tipo y grupo
      $('#tipoactivo').change(function () {
        $('#subtipoactivo').html('');
        var tia =$(this).val();
        var datos = 'opc=subtia&tia='+tia;
        $.ajax({
          type: "POST", 
          url: "php/loadselact.php",
          data: datos, 
          success: function(a) {
            $('#subtipoactivo').html(a);
            $('#grupoactivo').html('<option value="0"> -Seleccione Grupo- </option>');
            $('#subgrupoactivo').html('<option value="0"> -Seleccione Subgrupo- </option>');
            $("#primsj").html('');
            $("#ubicmsj").html('');
          }
        });
      });

      $('#subtipoactivo').change(function () {
        $('#grupoactivo').html('');
        var subtia =$(this).val();
        var datos = 'opc=gru&sbt='+subtia;
        $.ajax({
          type: "POST", 
          url: "php/loadselact.php",
          data: datos, 
          success: function(a) {
            $('#grupoactivo').html(a);
            $('#subgrupoactivo').html('<option value="0"> -Seleccione Subgrupo- </option>');
            $("#primsj").html('');
            $("#ubicmsj").html('');
          }
        });
      });

      $("#grupoactivo").change(function(e){
        $('#subgrupoactivo').html('');
        var gru =$(this).val();
        var datos = 'opc=subgru&gru='+gru;
        $.ajax({
          type: "POST", 
          url: "php/loadselact.php",
          data: datos, 
          success: function(a) {
            $('#subgrupoactivo').html(a);
            $("#primsj").html('');
            $("#ubicmsj").html('');
          }
        });
      });

      $("#subgrupoactivo").change(function(e){
          changeprio();
      });


      function loadtipo(){
        $("#tipoactivo").html('');
        $.ajax({
          url:'php/loadselact.php',
          type:'POST',
          data:'opc=tia',
          success:function(res){
            $("#tipoactivo").html(res); 
            $("#grupoactivo").html('<option value="0">- Seleccione Grupo -</option>');
          }
        })
      }
      function loadsubtipo(){
        var tia=$("#tipoactivo").val();
        $("#subtipoactivo").html('');
        $.ajax({
          url:'php/loadselact.php',
          type:'POST',
          data:'opc=subtia&tia='+tia,
          success:function(res){
            $("#subtipoactivo").html(res); 
            $("#grupoactivo").html('<option value="0">- Seleccione Grupo -</option>');
          }
        })
      }
      function loadgru(){
        var sbt =$("#subtipoactivo").val();
        var datos = 'opc=gru&sbt='+sbt;
        console.log(sbt);
        $('#grupoactivo').html('');
        $.ajax({
          type: "POST", 
          url: "php/loadselact.php",
          data: datos, 
          success: function(a) {
            $('#grupoactivo').html(a);
          }
        });
      }
      function loadsubgru(){
        $('#subgrupoactivo').html('');
        var gru =$("#grupoactivo").val();
        var datos = 'opc=subgru&gru='+gru;
        $.ajax({
          type: "POST", 
          url: "php/loadselact.php",
          data: datos, 
          success: function(a) {
            $('#subgrupoactivo').html(a);
          }
        });
      }

      

      $("#newsubtia").click(function(e){
        e.preventDefault();
        var idti=$("#tipoactivo").val();
        if(idti!=0){
          $("#tiacodigo").val(idti);
          console.log(idti);
          $("#modal_subtipo").modal('show');
        }else{
          swal('Para agregar un nuevo subtipo debe seleccionar un tipo de activo','','warning')
        }
      });
      $("#newgru").click(function(e){
        e.preventDefault();
        var idsbt=$("#subtipoactivo").val();
        if(idsbt!=0){
          $("#subtiacodigo").val(idsbt);
          $("#modal_grupo").modal('show');
        }else{
          swal('Para agregar un nuevo grupo debe seleccionar un tipo y subtipo de activo','','warning')
        }
      });  
      $("#newsubgru").click(function(e){
        e.preventDefault();
        var idti=$("#grupoactivo").val();
        if(idti!=0){
          $("#grucodigo").val(idti);
          $("#modal_subgrupo").modal('show');
        }else{
          swal('Para agregar un nuevo subgrupo debe seleccionar un Grupo de activos','','warning');
        }
      });
      $("#form_tia").on("submit", function(event) {
          event.preventDefault();
          var long = $.trim($('#tianame').val()).length;
          console.log(long);
          if(long  > 0){
            $.ajax({
                type: "POST",
                url: "php/loadselact.php",
                data: $(this).serialize()+'&opc=addtia',
                success: function(data) {
                    if (data == "TRUE"){
                      loadtipo();
                      $(".modal").modal('hide');
                      $("#form_tia")[0].reset();
                      closemodal($("#modal_tipo"),$("#tipoactivo"));
                    }else{
                      swal('Oops!','Ha ocurrido un error inesperado; refresque la pagina e intentelo nuevamente','error');
                    }  
               }
            });
          }else{
            swal('Nombre de Tipo NO permitido','','warning');
          }
      });

      $("#form_subtia").on("submit", function(e) {
          e.preventDefault();
          var long = $.trim($('#subtianame').val()).length;
          console.log(long);
          if(long  > 0){
            $.ajax({
                type: "POST",
                url: "php/loadselact.php",
                data: $(this).serialize()+'&opc=addsubtia',
                success: function(data) {
                    if (data == "true"){
                      loadsubtipo();
                      $("#form_subtia")[0].reset();
                      $(".modal").modal('hide');
                      closemodal($("#modal_subtipo"),$("#subtipoactivo"));
                    }  else{
                      swal('Oops!','Ha ocurrido un error, refreque la pagina e intentelo nuevamente!','error')
                    }
                },
            });
          }else{
            swal('Nombre de Subtipo NO permitido','','warning');
          }
      });

      $("#form_gra").on("submit", function(e) {
          e.preventDefault();
          var long = $.trim($('#graname').val()).length;
          console.log(long);
          if(long  > 0){
            $.ajax({
                type: "POST",
                url: "php/loadselact.php",
                data: $(this).serialize()+'&opc=addgru',
                success: function(data) {
                     
                    if (data == "TRUE"){
                      $("#form_gra")[0].reset();
                      $(".modal").modal('hide');
                      loadgru();
                      closemodal($("#modal_grupo"),$("#grupoactivo"));
                    }  else{
                      swal('','Ha ocurrido un error, refreque la pagina e intentelo nuevamente!','error')
                    }
                }
            });
          }else{
            swal('Nombre de grupo NO permitido','','warning');
          }
      });

      $("#form_subgra").on("submit", function(e) {
          e.preventDefault();
          var long = $.trim($('#sbgname').val()).length;
          console.log(long);
          if(long  > 0){
            if($("#prioact").val()!=0){
              $.ajax({
                  type: "POST",
                  url: "php/loadselact.php",
                  data: $(this).serialize()+'&opc=addsubgru',
                  success: function(data) {
                      if (data == "TRUE"){
                        loadsubgru();
                        $("#form_subgra")[0].reset();
                        $(".modal").modal('hide');
                        closemodal($("#modal_subgrupo"),$("#subgrupoactivo"));
                      }  else{
                        swal('Oops!','Ha ocurrido un error, refreque la pagina e intentelo nuevamente!','error')
                      }
                  }
              });
            }else{
              swal('Seleccione una prioridad!','','warning');
            }
          }else{
            swal('Nombre de subgrupo NO permitido','','warning');
          }
      });
      $('#graname').keyup(function(){
              this.value=this.value.toUpperCase();
              var name = $(this).val();     
              var idtia=$("#subtipoactivo").val();
              var dataString = 'opc=seekgra&key='+name+'&sbt='+idtia;
              $.ajax({
                  type: "POST",
                  url: "php/loadselact.php",
                  data: dataString,
                  success: function(data) {
                      if(data=='false'){
                        $("#infogra").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden  required/> <font color="red"> Ya existe este grupo de activos</font></div>');
                      }else{
                        $("#infogra").html('');
                      }
                  }
              });
          });
      $('#sbgname').keyup(function(){
              this.value=this.value.toUpperCase();
              var name = $(this).val();     
              var gru=$("#grupoactivo").val();
              var dataString = 'opc=seeksubgra&key='+name+'&gra='+gru;
              $.ajax({
                  type: "POST",
                  url: "php/loadselact.php",
                  data: dataString,
                  success: function(data) {
                      if(data=='false'){
                        $("#infosubgra").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden  required/> <font color="red"> Ya existe este grupo de activos</font></div>');
                      }else{
                        $("#infosubgra").html('');
                      }
                  }
              });
          });
      $('#tianame').keyup(function(){
              this.value=this.value.toUpperCase();
              var name = $(this).val();        
              var dataString = 'opc=seektia&key='+name;
              $.ajax({
                  type: "POST",
                  url: "php/loadselact.php",
                  data: dataString,
                  success: function(data) {
                      if(data=='false'){
                        $("#infotia").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este tipo de activo</font></div>');
                      }else{
                        $("#infotia").html('');
                      }
                  }
              });
          });
      $('#subtianame').keyup(function(){
              this.value=this.value.toUpperCase();
              var name = $(this).val();  
              var tia=$("#tipoactivo").val();
              var dataString = 'opc=seeksubtia&key='+name+'&tia='+tia;
              $.ajax({
                  type: "POST",
                  url: "php/loadselact.php",
                  data: dataString,
                  success: function(data) {
                      if(data=='false'){
                        $("#infosubtia").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este subtipo de activo</font></div>');
                      }else{
                        $("#infosubtia").html('');
                      }
                  }
              });
          });
      $('#graname').blur(function(){
              this.value=this.value.toUpperCase();
              var name = $(this).val();     
              var idtia=$("#subtipoactivo").val();
              var dataString = 'opc=seekgra&key='+name+'&sbt='+idtia;
              $.ajax({
                  type: "POST",
                  url: "php/loadselact.php",
                  data: dataString,
                  success: function(data) {
                      if(data=='false'){
                        $("#infogra").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden  required/> <font color="red"> Ya existe este grupo de activos</font></div>');
                      }else{
                        $("#infogra").html('');
                      }
                  }
              });
          });
      $('#sbgname').blur(function(){
              this.value=this.value.toUpperCase();
              var name = $(this).val();     
              var gru=$("#grupoactivo").val();
              var dataString = 'opc=seeksubgra&key='+name+'&gra='+gru;
              $.ajax({
                  type: "POST",
                  url: "php/loadselact.php",
                  data: dataString,
                  success: function(data) {
                      if(data=='false'){
                        $("#infosubgra").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden  required/> <font color="red"> Ya existe este Subgrupo de activos</font></div>');
                      }else{
                        $("#infosubgra").html('');
                      }
                  }
              });
          });
      $('#tianame').blur(function(){
              this.value=this.value.toUpperCase();
              var name = $(this).val();        
              var dataString = 'opc=seektia&key='+name;
              $.ajax({
                  type: "POST",
                  url: "php/loadselact.php",
                  data: dataString,
                  success: function(data) {
                      if(data=='false'){
                        $("#infotia").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este tipo de activo</font></div>');
                      }else{
                        $("#infotia").html('');
                      }
                  }
              });
          });
      $('#subtianame').blur(function(){
              this.value=this.value.toUpperCase();
              var name = $(this).val();  
              var tia=$("#tipoactivo").val();
              var dataString = 'opc=seeksubtia&key='+name+'&tia='+tia;
              $.ajax({
                  type: "POST",
                  url: "php/loadselact.php",
                  data: dataString,
                  success: function(data) {
                      if(data=='false'){
                        $("#infosubtia").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden required /> <font color="red"> Ya existe este subtipo de activo</font></div>');
                      }else{
                        $("#infosubtia").html('');
                      }
                  }
              });
          });


      function changeprio(){
        var ele=$("#subgrupoactivo");
        if(ele.val()!=0){
          var prio = ele.find(':selected').data('prio')
          var codpri=ele.find(':selected').data('codprio');
          var ubic=ele.find(':selected').data('labelact');
          $("#primsj").html('Este grupo de activos maneja prioridad ' + prio);
          $("#prioridad").val(codpri);
          $("#ubicmsj").html('Ubicación del codigo QR: '+ubic);
        }else{
          $("#primsj").html('');
        }
      }
</script>
<script>    //ejecucion funciones carga de selects
  $(document).ready(function() {
    loadtipo();
    loadmar();
    loadfabrica();
    loadpais();
    loadprio();
    loadunitie();
    loaduniuso();
  }); 
</script>
<script>    //operaciones de adjuntos
  /*********************drop zone 1*********************************************/
    var dropzone = document.getElementById('area');
    var  fileInput = document.getElementById("files");
    var  body = document.getElementById("body");

    dropzone.ondragover = function(e){e.preventDefault(); 
      dropzone.classList.add('dragging');
      $("#msj1").html('Suelte el archivo aquí!<br>.');
      $("#msj2").hide();
     }
    dropzone.ondrop = function(e){ onDragOver(e); } 

    function onDragOver(e) {
        fileInput.files = e.dataTransfer.files;
    } 
    dropzone.addEventListener('dragleave', () => {
      dropzone.classList.remove('dragging');
      $("#msj1").html('Arrastre archivo aquí');
      $("#msj2").show();
    });
  /*********************drop zone 2*********************************************/
    var dropzone2 = document.getElementById('area2');
    var  fileInput2 = document.getElementById("files2");
    var  body = document.getElementById("body");

    dropzone2.ondragover = function(e){e.preventDefault(); 
      dropzone2.classList.add('dragging2');
      $("#msj12").html('Suelte el archivo aquí!<br>.');
      $("#msj22").hide();
     }
    dropzone2.ondrop = function(e){ onDragOver(e); } 

    function onDragOver(e) {
        fileInput2.files = e.dataTransfer.files;
    } 
    dropzone2.addEventListener('dragleave', () => {
      dropzone2.classList.remove('dragging2');
      $("#msj12").html('Arrastre archivo aquí');
      $("#msj22").show();
    });  
  /**********************flies change*******************************************/
    $("#files").change(function(e){
        var ext = $("#files").val();
        var aux = ext.split('.');
        $("#nomarchivo").text(this.files[0].name);
        $("#area").hide();
        $("#iconoPDF").show();
    });
    $("#files2").change(function(e){
        var ext = $("#files2").val();
        var aux = ext.split('.');
        $("#nomarchivo2").text(this.files[0].name);
        $("#area2").hide();
        $("#iconoPDF2").show();
    });  
  /**********************modal hide*********************************************/
    $('#modal_newdoc').on('hidden.bs.modal', function () {
        $("#area").show();
        $(".oculgen").show();
        $("#iconoPDF").hide();
        $("#formul")[0].reset();   
        $(".newtidocform").hide();
        $(".carga").show();
        $("#respuesta").html('');
        $("#divtbadjuntos").html('');
        var id='<?php echo $codigo;?>';
        $.ajax({
            url:'php/adjuntoact.php',
            type:'POST',
            dataType:'html',
            data:'id='+id,
            success:function(res){
                $("#divtbadjuntos").html(res);
            }
        })
    });
    $('#modal_newdoc2').on('hidden.bs.modal', function () {
        $("#area2").show();
        $("#iconoPDF2").hide();
        $("#formul2")[0].reset();   
        $(".newtidocform").hide();
        $(".carga").show();
        $("#respuesta2").html('');
        $("#divtbadjuntos").html('');
        var id='<?php echo $codigo;?>';
        $.ajax({
            url:'php/adjuntoact.php',
            type:'POST',
            dataType:'html',
            data:'id='+id,
            success:function(res){
                $("#divtbadjuntos").html(res);
            }
        })
    });
  /***********************form nuevo tipo adjunto*******************************/
    $("#formnuca").submit(function(e){
        e.preventDefault();
        var form=$(this).serialize();
        $.ajax({
            url:'php/operadjuntoact.php',
            type:'POST',
            data:'opc=nuca&'+form,
            success:function(res){
                cargarselect();
                $("#formnuca")[0].reset();
                $("#btnback").click();
            }
        });

    });
    $("#resetnutido").click(function(e){
        $("#btnback").click();
    })
  /**********************funciones de carga de adjunto**************************/
    function cargando(){
        if($( '.oculgen' ).is(":visible")){
                  $( '.oculgen' ).hide();
             }
        $("#respuesta").html('Cargando...');
    } 
    function resultadoOk(){
      $("#respuesta").html('Guardado exitosamente!');
    } 
    function resultadoErroneo(){
      $("#respuesta").html('Ha surgido un error y no se ha podido subir el archivo.');
    } 
    function cargando2(){
        if($( '.oculgen' ).is(":visible")){
                  $( '.oculgen' ).hide();
             }
        $("#respuesta2").html('Cargando...');
    } 
    function resultadoOk2(){
      $("#respuesta2").html('Actualizado exitosamente!.');
    } 
    function resultadoErroneo2(){
      $("#respuesta2").html('Ha surgido un error y no se ha podido actualizar el archivo.');
    } 
  /*********************carga de tbadjunto y select*****************************/
    function cargartabla(){
        var id='<?php echo $codigo;?>';
        $("#divtbadjuntos").html('');
        $.ajax({
            url:'php/adjuntoact.php',
            type:'POST',
            dataType:'html',
            data:'id='+id,
            success:function(res){
                $("#divtbadjuntos").html(res);
            }
        });
    }
    function cargarselect(){
        $("#seltidoc").html('');
        $.ajax({
            url:'php/operadjuntoact.php',
            type:'POST',
            dataType:'html',
            data:'opc=load',
            success:function(res){
                $("#seltidoc").html(res);
            }
        });
    }
  /*****************************upload adj**************************************/
    $(document).ready(function(){
        
       $("#subirarchivo").click(function(){
            var bool=false;
            if(($("#seltidoc").val()!=null) && ($("#txtobserv").val()!='')){
                bool=true;
            }
            if(bool){
                //$(".oculgen").hide();
                cargando();
            }
       });
       $("#subirarchivo2").click(function(){
        $("#area2").hide();
            var bool=false;
            if(($("#seltidoc2").val()!=null) && ($("#txtobserv2").val()!='')){
                bool=true;
            }
            if(bool){
                //$(".oculgen").hide();
                cargando2();
            }
       });
    }); 
  /********************acciones de modal (ocultar mostrar opciones)*************/
    $("#addti_doc").click(function(e){
      e.preventDefault();
        $(".carga").hide();
        $(".newtidocform").fadeIn();
    });

    $("#btnback").click(function(e){
      e.preventDefault();
        $(".carga").fadeIn();
        $(".newtidocform").hide();
        //$("#resetform").click();

    });
    cargartabla();
    cargarselect(); 
</script>
<script>    //oper insumos
    $(document).on('click' , '.btndelins' , function(e){
        e.preventDefault();
        var idins=$(this).data('ins-id');
        var idact=$(this).data('act-id');

        swal({
            title: "¿Seguro que desea eliminar este insumo?",
            text: "Esta acción NO puede deshacerse, ni reversarse",
            type: "warning",
            showCancelButton:  true,
            cancelButtonText:"No",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí"  
            },function () {
                $.ajax({
                    url:'php/loadselact.php',
                    type:'POST',
                    data:'opc=delinsumo&idins='+idins+'&idact='+idact,
                    success:function(res){
                        if(res=='true'){
                            loadinsumos();
                        }else{
                            swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','ERROR')
                        }
                    }
                })
        });        
    });
    var tbinscant=0;
    $(document).on('click' , '.btneditins' , function(e){
        e.preventDefault();
        var idins=$(this).data('ins-id');
        var idact=$(this).data('act-id');
        var fila=$(this).parents("tr").find(".cant").html();
        tbinscant=fila;
        //console.log(fila);
        $(this).hide();
        $(this).parents("tr").find(".cant").html('<div class="col-xs-4 col-xs-push-4"><input style="background:#FFFFCC" class="form-control col-md-2 number text-center nuecant" type="number" autofocus ></div>');
        $(this).parents("tr").find(".nuecant").val(fila).focus();
        $(this).parents("tr").find('.btneditins').hide();
        $(this).parents("tr").find('.btndelins').hide();
        $(this).parents("tr").find(".opc").append('<button data-toggle="tooltip" data-placement="top" title="Guardar cambio" class="btn btn-default updcant" data-ins-id="'+idins+'" data-act-id="'+idact+'"><i class="fa fa-play" style="color:green;"></i></button>');
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).on('click' , '.updcant' , function(e){
        e.preventDefault();
        var idins=$(this).data('ins-id');
        var idact=$(this).data('act-id');
        var cant=$(this).parents("tr").find(".nuecant").val();
        $.ajax({
            url:'php/loadselact.php',
            type:'POST',
            data:'opc=updins&idins='+idins+'&idact='+idact+'&cant='+cant,
            success:function(res){
                if(res=='true'){
                    loadinsumos();
                }else if(res==0){
                    swal('La cantidad debe ser mayor a cero!','','error')
                }
                else{
                    swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','ERROR')
                }
            }
        })       
    });
</script>
<script>    //oper repuestos
    $(document).on('click' , '.btndelrep' , function(e){
        e.preventDefault();
        var idrep=$(this).data('rep-id');
        var idact=$(this).data('act-id');

        swal({
            title: "¿Seguro que desea eliminar este repuesto?",
            text: "Esta acción NO puede deshacerse, ni reversarse",
            type: "warning",
            showCancelButton:  true,
            cancelButtonText:"No",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí"  
            },function () {
                $.ajax({
                    url:'php/loadselact.php',
                    type:'POST',
                    data:'opc=delrep&idrep='+idrep+'&idact='+idact,
                    success:function(res){
                        if(res=='true'){
                            loadrepuestos();
                        }else{
                            swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','ERROR')
                        }
                    }
                })
        });        
    });
    var tbrepcant=0;
    $(document).on('click' , '.btneditrep' , function(e){
        e.preventDefault();
        var idrep=$(this).data('rep-id');
        var idact=$(this).data('act-id');
        var fila=$(this).parents("tr").find(".cant2").html();
        tbrepcant=fila;
        //console.log(fila);
        $(this).hide();
        $(this).parents("tr").find(".cant2").html('<div class="col-xs-4 col-xs-push-4"><input style="background:#FFFFCC" class="form-control col-md-2 number text-center nuecantr" type="number" autofocus ></div>');
        $(this).parents("tr").find(".nuecantr").val(fila).focus();
        $(this).parents("tr").find('.btneditrep').hide();
        $(this).parents("tr").find('.btndelrep').hide();
        $(this).parents("tr").find(".opc").append('<button data-toggle="tooltip" data-placement="top" title="Guardar cambio" class="btn btn-default updcantr" data-rep-id="'+idrep+'" data-act-id="'+idact+'"><i class="fa fa-play" style="color:green;"></i></button>');
         $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).on('click' , '.updcantr' , function(e){
        e.preventDefault();
        var idrep=$(this).data('rep-id');
        var idact=$(this).data('act-id');
        var cant=$(this).parents("tr").find(".nuecantr").val();
        $.ajax({
            url:'php/loadselact.php',
            type:'POST',
            data:'opc=updrep&idrep='+idrep+'&idact='+idact+'&cant='+cant,
            success:function(res){
                if(res=='true'){
                    loadrepuestos();
                }else if(data==0){
                    swal('La cantidad debe ser mayor a cero.','','ERROR')
                }
                else{
                    swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','ERROR')
                }
            }
        })       
    });
</script>
<script>    //oper filtro mtto


    $("#filtipo").change(function(e){
        filtro();
    })

    $("#filest").change(function(e){
        filtro();
    })

    $("#fildesde").on('dp.change', function(e){
        $("#filhasta").removeAttr('disabled').focus().val('');
    });
    $("#filhasta").on('dp.change', function(e){
        var a = Date.parse($("#fildesde").val());
        var b = Date.parse($("#filhasta").val());
        var c = b-a;
        if(c<0){
            swal('Error!','La fecha "hasta" debe ser posterior a la fecha "desde"','error');
            $("#filhasta").val('');
        }else{
            filtro();
        }
    });

    function filtro(){
        $(".revmttoact").html('');
        var idact=$("#codigo").val();
        var fest=$("#filest").val();
        var ftpo=$("#filtipo").val();
        if($("#filhasta").val()!=''){    
            var filfe="'"+$("#fildesde").val()+"' and '"+$("#filhasta").val()+"'";
        }else{
            var filfe="";
        }
        $.ajax({
            url:'php/revmttoactivo.php',
            type:'POST',
            data:'opc=loadact&filestado='+fest+'&filtipo='+ftpo+'&idact='+idact+'&filfe='+filfe,
            success:function(res){
                $(".revmttoact").html(res);
                $('[data-toggle="tooltip"]').tooltip();
                $("#divreset").show();
            }
        })
    }

    $("#resetfil").click(function(e){
        var idact=$("#codigo").val();
        loadrevmtto(idact);
        $("#divreset").hide();
    })
</script>
<script>  //modal mtto 
    $('#revmtto').click(function(e){
        var idact=$("#codigo").val();
        $.ajax({
            url:'php/revmttoactivo.php',
            type:'POST',
            data:'opc=chkprog&idact='+idact,
            success:function(res){
                if(res=='false'){
                    $("#modal_prog").modal('show');
                }
            }
        }); 
    });
    $("#passmttosi").click(function(e){
        $("#ultfechamtto").removeAttr('readonly');
    });
    $("#passmttono").click(function(e){
        $("#ultfechamtto").attr('readonly','true');
        $("#ultfechamtto").val('<?php echo date('Y-m-d');?>');
    });

    $("#passrevsi").click(function(e){
        $("#ultfecharev").removeAttr('readonly');
    });
    $("#passrevno").click(function(e){
        $("#ultfecharev").attr('readonly','true');
        $("#ultfecharev").val('<?php echo date('Y-m-d');?>');
    });

    $("#modal_prog").on("hidden.bs.modal", function () {
        $("#autorev").prop('checked', false).change();
        $("#automtto").prop('checked', false).change();
        $("#genprog").button('reset');
    });
    
    $("#genprog").click(function(e){
        var $this = $(this);
        $this.button('loading');
    });
</script>
<script>  //oper movimientos 
    $(document).on('click' , '.btnejecutarmv' , function(e){
        e.preventDefault();
        var idmov=$(this).data('id');
        var idact=$(this).data('cod-id');
        $.ajax({
            url:'php/opermovimiento.php',
            type:'POST',
            data:'opc=exemov&idmov='+idmov+'&idact='+idact,
            success:function(res){
                if(res=='true'){
                    movimiento(idact);
                    ubicacion(idact);
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','ERROR')
                }
            }
        })
    });

    $(document).on('click' , '.btncancelarmv' , function(e){
        e.preventDefault();
        var idmov=$(this).data('id');
        var idact=$(this).data('cod-id');
        $.ajax({
            url:'php/opermovimiento.php',
            type:'POST',
            data:'opc=canmov&idmov='+idmov,
            success:function(res){
                if(res=='true'){
                    movimiento(idact);
                    ubicacion(idact);
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','error');
                }
            }
        })
    });

    $(document).on('click' , '.btncancelaract' , function(e){
        e.preventDefault();
        var idpgm=$(this).data('id');
        var idact=$(this).data('cod-id');
        $.ajax({
            url:'php/revmttoactivo.php',
            type:'POST',
            data:'opc=canact&idpgm='+idpgm,
            success:function(res){
                if(res=='true'){
                    loadrevmtto(idact);
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','error');
                }
            }
        })
    });

    $(document).on('click' , '.btnejecutaract' , function(e){
        e.preventDefault();
        var idpgm=$(this).data('id');
        var idact=$(this).data('cod-id');
        $.ajax({
            url:'php/revmttoactivo.php',
            type:'POST',
            data:'opc=exeact&idpgm='+idpgm,
            success:function(res){
                if(res=='true'){
                    loadrevmtto(idact);
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado; Recargue la página e intentelo nuevamente.','error');
                }
            }
        })
    });



    function ubicacion(id) {
        $("#ubicact").html('');
        $.ajax({
            url: 'php/opermovimiento.php',
            type: 'POST',
            data:'opc=loadlugarea&id='+id,
            success: function(data){
                var datos = JSON.parse(data);
                $("#ubicact").html(datos.lugar);
                $("#ubicact").append(' - '+datos.area);
            }
        })
    }

    $("#form_prog").submit(function(e){
        e.preventDefault();
        var idact=$("#codigo").val();
        $("#idactivo").val(idact);
        var formdata=$(this).serialize();
        //console.log(formdata);
        $.ajax({
            url:'php/revmttoactivo.php',
            type:'POST',
            data:'opc=addrevmtto&'+formdata,
            success:function(res){
                if(res=='true'){
                    loadrevmtto(idact);
                    $("#modal_prog").modal('hide');
                    $("#automtto").prop('checked', false).change();
                    $("#autorev").prop('checked', false).change();
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado, refresque la pagina e intentelo nuevamente.','error');
                }
            }
        })
    });
</script>
<script>  //movimientos e imagen
    var act='<?php echo $codigo;?>';
    function movimiento(id){
        $("#movimientos").html('');
        $.ajax({
            type: "POST",
            url: "php/loadmovactivo.php",
            data: 'idact='+id,
            success:function(res){
                $("#movimientos").html(res);
            }
        });
    }
    function paginarm(id) {
        $(".revmttoact").html('');
        var idact=$("#codigo").val();
        var fest=$("#filest").val();
        var ftpo=$("#filtipo").val();
        if($("#filhasta").val()!=''){    
            var filfe="'"+$("#fildesde").val()+"' and '"+$("#filhasta").val()+"'";
        }else{
            var filfe="";
        }
        $.ajax({
            url:'php/revmttoactivo.php',
            type:'POST',
            data:'opc=loadact&filestado='+fest+'&filtipo='+ftpo+'&idact='+idact+'&filfe='+filfe+'&page='+id,
            success:function(res){
                $(".revmttoact").html(res);
                $('[data-toggle="tooltip"]').tooltip();
                $("#divreset").show();
            }
        })
    }
    function loadrevmtto(idact){
        $(".revmttoact").html('');
        $.ajax({
            url:'php/revmttoactivo.php',
            type:'POST',
            data:'opc=loadact&idact='+idact,
            success:function(res){
                $(".revmttoact").html(res);
                $('[data-toggle="tooltip"]').tooltip();
            }
        })
    }
    function mostrarImagen(input) {

        var imagen = input.files[0];
        var stringImagen = imagen["type"].split("/");
        var tipoImagen = stringImagen[1];
        var tamanoImagen = imagen["size"];

        if((tipoImagen != "jpeg") && (tamanoImagen < 512000)){

            swal("Error", "Debe subir una imagen con extensi\u00F3n .jpg", "error");
            $("#imagen").val('');
        }
        else if((tipoImagen == "jpeg") && (tamanoImagen > 512000)){

            swal("Error", "Debe subir una imagen con tama\u00F1o menor a 500KB", "error");
            $("#imagen").val('');
        }
        else if((tipoImagen != "jpeg") && (tamanoImagen > 512000)){

            swal("Error", "Debe subir una imagen con extensi\u00F3n .jpg. Debe subir una imagen con tama\u00F1o menor a 500KB", "error");
            $("#imagen").val('');
        }
        else{

            if (input.files && input.files[0]) {
              
                var reader = new FileReader();
              
                reader.onload = function (e) {
                    $('#imgact').attr('src', e.target.result);
                }
              
                reader.readAsDataURL(input.files[0]);
            }
        }
    }
    movimiento(act);
    ubicacion(act);
</script> 
<script>  //duplicador de activos
   $("#duplicador").click(function(e){
    e.preventDefault();
    var idact=$("#codigodeactivo").val();
    $.ajax({
      url:'php/duplicaract.php',
      type:'POST',
      data:'idact='+idact,
      success:function(res){
        //console.log(res);
        if(res=='true'){
          swal({
            title: "Copia exitosa!",
            text: "Se ha copiado este activo exitosamente",
            type: "success",
            confirmButtonText: "Ok"
            },
            function (onConfirm) {
                window.location="activos.php";
          });

        }else{
          swal('Oops!','Ha ocurrido un error inesperado, por favor refresque la página e intentelo nuevamente.','error');
        }
      }
    })
   })
</script>