<?php
    //include "conexion.php";
    $today= date("Y-m-d");
    $codigo = $_POST['id_act'];
    $sql = "SELECT  a.actcodigo,a.actnombre,a.marcodigo,ma.marnombre,a.actmodelo,a.actespecificaciones,a.actgenerico,a.actimagen,a.actserial,a.actdescripcion,a.actfechacompra,a.prvcodigo,ter.trcrazonsocial,a.fabcodigo,fa.fabnombre,a.paicodigo,pa.painombre,a.actfechainicio,a.actcodigoexterno,a.actcosto_base,a.actcosto_impuesto,a.gracodigo,ga.granombre,ta.tianombre,a.pracodigo,pr.pranombre,a.actreq_mant_prd,a.actfreq_mant,a.actreq_rev_prd,a.actfreq_rev,a.actgtia_tiempo,a.actgtia_tiempo_valor,a.unacodigo_tiempo,un.unanombre un1,a.actgtia_uso,a.actgtia_uso_valor,a.unacodigo_uso,un2.unanombre un2,a.actreq_insumos,a.actreq_repuestos
            FROM btyactivo a
            join btyactivo_grupo ga on ga.gracodigo=a.gracodigo
            join btyactivo_tipo ta on ta.tiacodigo=ga.tiacodigo
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
            $codigo = $row['actcodigo'];
            $nombre = $row['actnombre'];
            $marca  = $row['marcodigo'];
            $nommarca  = $row['marnombre'];
            $modelo = $row['actmodelo'];
            $espec  = $row['actespecificaciones'];
            $img    =$row['actimagen'];
            $gener  =$row['actgenerico'];
            $serial = $row['actserial'];
            $descr  = $row['actdescripcion'];
            
            $fecha  = $row['actfechacompra'];
            $prove  = $row['trcrazonsocial'];
            $fab    = $row['fabnombre'];
            $pais    = $row['painombre'];
            $fechini = $row['actfechainicio'];
            $cod_ext= $row['actcodigoexterno'];
            $costo  = $row['actcosto_base'];
            $impu   = $row['actcosto_impuesto'];

            $grupo  = $row['gracodigo'];
            $nomgru = $row['granombre'];
            $tipo   = $row['tiacodigo'];
            $nomtia = $row['tianombre'];

            $rqmtto =$row['actreq_mant_prd'];
            $fqmtto =$row['actfreq_mant'];
            $rqrev  =$row['actreq_rev_prd'];
            $fqrev  =$row['actfreq_rev'];

            $pri    = $row['pracodigo'];
            $prinom = $row['pranombre'];

            $garti  = $row['actgtia_tiempo'];
            $gartival=$row['actgtia_tiempo_valor'];
            $gartiuni=$row['un1'];

            $garuso  = $row['actgtia_uso'];
            $garusoval=$row['actgtia_uso_valor'];
            $garusouni=$row['un2'];

            $insu     =$row['actreq_insumos'];
            $repu     =$row['actreq_repuestos'];
         
    }

?>
<style>
  .panel-title{cursor:pointer;}
</style>
<div class="row">
    <form id="form_atc" role="form" name="form" method="post" enctype="multipart/form-data">
        <input type="hidden" id="codigo" name="codigo" value="<?php echo $codigo;?>">
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
                                  <label>Nombre</label>
                                  <input  class="form-control text-uppercase" type="text" name="act_name" id="act_name" placeholder="Ingrese nombre" data-error="camp obligatorio" value="<?php echo $nombre;?>">
                                  <div id="Info" class="help-block with-errors"></div>
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
                                  <input  class="form-control text-uppercase" type="text" id="modelo" name="modelo" value="<?php echo $modelo;?>">
                              </div>
                            <!-- espec -->
                               <div class="form-group">
                                  <label>Especificaciones</label>
                                  <input  class="form-control text-uppercase" type="text" id="especificaciones" name="especificaciones" value="<?php echo $espec;?>">
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
                                  <div class="col-sm-6 col-md-3">
                                      <img src="../contenidos/imagenes/activo/<?php echo $img;?>?<?php echo time(); ?>"  id="imgact" class="img-rounded img-responsive" onerror="this.src='../contenidos/imagenes/default.jpg';">
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
                                  <input  class="form-control text-uppercase" type="text" id="serial" name="serial" value="<?php echo $serial;?>" >
                                  <div id="infosn"></div>
                                </div>
                          <!--desc -->
                              <div class="form-group">
                                  <label>Descripción</label>
                                  <textarea class="form-control" id="marcadescripcion" name="marcadescripcion" type="text"  style="resize: none;" value="<?php echo $descr;?>"><?php echo $descr;?></textarea>
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
                                  <input  class="form-control fecha" type="text" name="marcafecha" max="<?php echo $today;?>" placeholder="Ingrese fecha"  value="<?php echo $fecha; ?>">
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
                                  <input  class="form-control fecha" type="text" id="fechainicio" name="fechainicio" max="<?php echo $today;?>" value="<?php echo $fechini;?>" >
                              </div>
                          <!-- cod ext -->
                              <div class="form-group">
                                  <label>Codigo externo</label>
                                  <input  class="form-control" id="codext" name="codigo_externo" type="text"  value="<?php echo $cod_ext;?>" data-error="Campo obligatorio" >
                                  <div id="infocodex"></div>
                              </div>
                          <!-- costo -->
                              <div class="form-group">
                                  <label>Costo Base</label>
                                  <input  class="form-control number" type="number" id="costobase" name="costobase" value="<?php echo $costo;?>" >
                              </div> 
                          <!-- impuesto -->
                              <div class="form-group">
                                  <label>Impuesto Base</label>
                                  <input  class="form-control number" type="number" id="impuesto" name="impuesto" value="<?php echo $impu;?>">
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
                    <!-- tipo y grupo -->
                        <div class="form-group" id="oldtigru">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Tipo de activo</th>
                                    <th>Grupo de activo  <a id="edittigru" class="btn btn-default pull-right" data-toggle="tooltip" data-placement="top" title="Editar tipo y grupo de activo"><span class="fa fa-edit text-info"></span></a></th>

                                </tr>
                                <tr>
                                    <td><?php echo $nomtia;?></td>
                                    <td><?php echo $nomgru;?></td>
                                </tr>
                            </table>
                        </div>
                        <div id="newtigru" style="display:none;">
                            <div class="col-md-6">
                              <!-- tipo act -->
                              <div class="form-group">
                                  <label>Tipo activo </label>
                                  <div class="input-group">
                                 <div class="input-group-btn"> <a data-toggle="modal" data-target="#modal_tipo"><button class="btn btn-default" title="Agregar nuevo"><i class="fa fa-plus-square text-info"></i></button></a></div><select class="form-control" name="tipoactivo" id="tipoactivo" data-error="Escoja una opcion" ></select>
                                  </div>  
                              </div>
                              
                            </div>
                            <div class="col-md-6">
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
                              <b id="primsj"></b>
                            </div>
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
                              <input  class="form-control number" name="freqmtto" type="number" id="freqmtto"  placeholder="dias" data-error="Campo obligatorio" disabled  min="1" value="<?php echo $fqmtto;?>">
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
                                  <input  class="form-control number" name="freqrev" type="number" id="freqrev"  placeholder="dias" data-error="Campo obligatorio" disabled  min="1" value="<?php echo $fqrev;?>">
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
                                  <input  class="form-control number" name="timegar" type="number" id="timegar" data-error="Campo obligatorio"   min="1">
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
                                  <input  class="form-control number" name="cantuso" type="number" id="cantuso" data-error="Campo obligatorio"  min="1">
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
                              <input  class="form-control number" name="cantinsumo" type="number" id="cantinsumo"  placeholder="Cant" data-error="Campo obligatorio" disabled  min="1">
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
                      <div class="col-md-6">
                          <div class="form-group col-md-6">
                              <label class="control-label">Repuestos</label><br>
                              <div class="pull-left">
                                <div class="TriSea-technologies-Switch col-md-2">
                                    <input id="rptos" name="rptos" class="rptos" type="checkbox"/>
                                    <label for="rptos" class="label-primary"></label>
                                </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          
                      </div>
                      <div class="col-md-12">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>Referencia</th>
                              <th>Nombre</th>
                              <th>Especificaciones</th>
                              <th>Cantidad</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td colspan="4" class="text-center">No hay registros</td>
                            </tr>
                          </tbody>
                        </table>                      
                      </div>

                      <div class="col-md-12">
                          <button type="submit" class="btn btn-success pull-right" data-toggle="tooltip" data-placement="top" title="Guardar Cambios"><i class="fa fa-save"></i></button>
                          <button type="reset" id="resetform" class="btn btn-default pull-right">Cancelar</button>
                      </div>
                  </div>
                </div>
              </div>
       </div>
    </form>
</div>
<!-- Modal Grupo activo -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_grupo">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar nuevo grupo activos</h4>
          </div>
            <form id="form_gra" method="post" class="formul">
              <div class="modal-body">
                  
                    <div class="form-group">
                      <label>
                          Nombre
                      </label>
                      <input class="form-control text-uppercase" id="graname" name="graname" maxlength="50" type="text" >
                      <div id="infogra" class="help-block with-errors err"></div>
                    </div>
                    <div class="form-group">
                      <label for="priogruac">
                          Prioridad
                      </label>
                     <select name="priogruac" id="priogruac" class="form-control"></select>
                    </div>
                   <input type="hidden" name="tiacodigo" id="tiacodigo">

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
                  <input class="form-control text-uppercase" id="tianame" name="tianame" maxlength="50" type="text" >
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

<!-- Modal Marca -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal_marca">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar nueva marca</h4>
          </div>
            <form id="form_mar" method="post" class="formul">
          <div class="modal-body">
              
                <div class="form-gruop">
                  <label>
                      Nombre
                  </label>
                  <input class="form-control text-uppercase" id="marname" name="marname" maxlength="50" type="text" >
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
            <form id="form_newlug" method="post">
              <div class="modal-body">
                <div class="form-gruop">
                  <label>
                      Nombre del lugar
                  </label>
                  <input class="form-control text-uppercase nomlugar" id="lugname" name="lugname" maxlength="50" type="text" >
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
            <form id="form_newarea">
              <div class="modal-body">
                <input type="hidden" name="idlug" id="idlug">
                <div class="form-group">
                  <label>
                      Nombre del área
                  </label>
                  <input class="form-control text-uppercase nomarea" id="arname" name="arname" maxlength="50" type="text" >
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
            <form id="form_pais" method="post" class="formul">
          <div class="modal-body">
              
                <div class="form-gruop">
                  <label>
                      Nombre
                  </label>
                  <input class="form-control text-uppercase" id="paisname" name="paisname" maxlength="50" type="text" >
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
                  <input class="form-control text-uppercase" id="fabname" name="fabname" maxlength="50" type="text" >
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
                  <input class="form-control text-uppercase" id="uniname1" name="uniname1" maxlength="6" type="text" placeholder="ej: Dia, mes, año, semana, etc">
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
                  <input class="form-control text-uppercase" id="uniname2" name="uniname2" maxlength="10" type="text" placeholder="ej: Horas, ciclos, kilometros, etc">
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
                  <input class="form-control text-uppercase" id="insname" name="insname" maxlength="49" type="text">
                  <div id="infoinsumo" class="help-block with-errors err"></div>
                </div>
                <div class="form-group">
                  <label>
                      Referencia
                  </label>
                  <input class="form-control text-uppercase" id="insref" name="insref" maxlength="49" type="text">
                </div>
                <div class="form-group">
                  <label>
                      Especificaciones
                  </label>
                  <textarea class="form-control text-uppercase" style="resize:none;" id="insespec" name="insespec" type="text"></textarea>
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
<script> //start 
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
            showSubtext: true,
            title:'Buscar y seleccionar lugar...'
    });

    $('#selinsumos').selectpicker({
            liveSearch: true,
            showSubtext: true,
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
          $("#rptos").prop('checked', true).change();
        }else{
          $("#rptos").prop('checked', false).change();
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
    });
</script>
<script type="text/javascript">   //forms modales 
    $("#newgru").click(function(e){
        e.preventDefault();
        var idti=$("#tipoactivo").val();
        if(idti!=0){
          $("#tiacodigo").val(idti);
          $("#modal_grupo").modal('show');
        }else{
          swal('Para agregar un nuevo grupo debe seleccionar un tipo de activo')
        }
    });
    $("#btnnewlug").click(function(e){
        $("#modal_newlugar").modal('show');
    });

    $("#form_newlug").submit(function(e){
        e.preventDefault();
        var formdata=$(this).serialize();
        $.ajax({
            url:'operlugararea.php',
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
            url:'operlugararea.php',
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
            url:'loadselact.php',
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
            url:'loadselact.php',
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
              window.location = "activo.php";
        });
    }
    $("#addprov").click(function(e){
        e.preventDefault();
        window.open('nuevo_proveedor.php');
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
            url:'operlugararea.php',
            type:'GET',
            data:'opc=addarea&'+formdata,
            success:function(res){
                if(res=='true'){
                    $("#areas").load('operlugararea.php?opc=loadarea&id='+idlug);
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
            url:'operlugararea.php',
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
        url:'loadselact.php',
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
            url:'loadselact.php',
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
        url:'loadselact.php',
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
            url:'loadselact.php',
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
        url:'loadselact.php',
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
            url:'loadselact.php',
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
        url:'loadselact.php',
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
            url:'loadselact.php',
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

          $('#graname').keyup(function(){
            this.value=this.value.toUpperCase();
            var name = $(this).val();     
            var idtia=$("#tiacodigo").val();
            var dataString = 'opc=seekgra&key='+name+'&tia='+idtia;
            $.ajax({
                type: "POST",
                url: "loadselact.php",
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
          $('#tianame').keyup(function(){
            this.value=this.value.toUpperCase();
            var name = $(this).val();        
            var dataString = 'opc=seektia&key='+name;
            $.ajax({
                type: "POST",
                url: "loadselact.php",
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
          $('#marname').keyup(function(){
            this.value=this.value.toUpperCase();
            var name = $(this).val();        
            var dataString = 'opc=seekmar&key='+name;
            $.ajax({
                type: "POST",
                url: "loadselact.php",
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
          $("#form_gra").on("submit", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "loadselact.php",
                data: $(this).serialize()+'&opc=addgru',
                success: function(data) {
                     
                    if (data == "TRUE"){
                      loadgru();
                      $("#form_gra")[0].reset();
                      $(".modal").modal('hide');
                      closemodal($("#modal_grupo"),$("#grupoactivo"));
                      changeprio();
                    }  else{
                      swal('','Ha ocurrido un error, refreque la pagina e intentelo nuevamente!','error')
                    }


                },
            });
          });

          $("#form_mar").on("submit", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "loadselact.php",
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

          $('#act_name').blur(function(){
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
          });  
          $("#form_tia").on("submit", function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "loadselact.php",
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
          });
    });


    $(".modal").on("hidden.bs.modal", function () {
          $("#form_gra")[0].reset();
          $("#form_tia")[0].reset();
          $("#form_mar")[0].reset();
          $("#form_pais")[0].reset();
          $("#form_newlug")[0].reset();
          $("#form_newarea")[0].reset();
          $(".err").html('');
    });
</script>
<script>    //eventos y funciones de selects
      $("#imagen").on("change", function(){
          mostrarImagen(this);
      });

      $('#tipoactivo').change(function () {
        $('#grupoactivo').html('');
        var cod =$(this).val();
        var datos = 'opc=gru&codigo='+cod;
        $.ajax({
          type: "POST", 
          url: "loadselact.php",
          data: datos, 
          success: function(a) {
          $('#grupoactivo').html(a);
          changeprio();
          }
        });
      });

      $("#grupoactivo").change(function(e){
        changeprio();
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

      function changeprio(){
        var ele=$("#grupoactivo");
        if(ele.val()!=''){
          var prio = ele.find(':selected').data('prio')
          var codpri=ele.find(':selected').data('codprio');
          $("#primsj").html('Este grupo de activos maneja prioridad ' + prio);
          $("#prioridad").val(codpri);
        }else{
          $("#primsj").html('');
        }
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

      function loadtipo(){
        $("#tipoactivo").html('');
        $.ajax({
          url:'loadselact.php',
          type:'POST',
          data:'opc=tia',
          success:function(res){
            $("#tipoactivo").html(res); 
            $("#grupoactivo").html('<option value="0">- Seleccione una opcion -</option>');
          }
        })
      }

      function loadmar(){
        $.ajax({
          url:'loadselact.php',
          type:'POST',
          data:'opc=mar',
          success:function(res){
            $("#marcas").html(res); 
          }
        })
      }

      function loadgru(){
        var cod =$("#tipoactivo").val();
        var datos = 'opc=gru&codigo='+cod;
        $('#grupoactivo').html('');
        $.ajax({
          type: "POST", 
          url: "loadselact.php",
          data: datos, 
          success: function(a) {
            $('#grupoactivo').html(a);
          }
        });
      }
      function loadarea(){
        $("#selar").html('');
        var idlug=$("#sellugar").val();
        $.ajax({
            url:'operlugararea.php',
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
          url:'loadselact.php',
          type:'POST',
          data:'opc=prov',
          success:function(res){
            $("#provdor").html(res); 
          }
        });
      }

      function loadfabrica(){
        $.ajax({
          url:'loadselact.php',
          type:'POST',
          data:'opc=fab',
          success:function(res){
            $("#fabrica").html(res); 
          }
        });
      }

      function loadpais(){
        $.ajax({
          url:'loadselact.php',
          type:'POST',
          data:'opc=pais',
          success:function(res){
            $("#pais").html(res); 
          }
        });
      }

      function loadprio(){
        $.ajax({
          url:'loadselact.php',
          type:'POST',
          data:'opc=prio',
          success:function(res){
            $("#prioridad").html(res); 
            $("#priogruac").html(res); 
          }
        });
      }

      function loadunitie(){
        $.ajax({
          url:'loadselact.php',
          type:'POST',
          data:'opc=unitie',
          success:function(res){
            $("#unitime").html(res); 
          }
        });
      }

      function loaduniuso(){
        $.ajax({
          url:'loadselact.php',
          type:'POST',
          data:'opc=uniuso',
          success:function(res){
            $("#uniuso").html(res); 
          }
        });
      }
</script>
<script>    //ejecucion funciones carga de selects
  $(document).ready(function() {
    loadtipo();
    loadmar();
    //loadprove();
    loadfabrica();
    loadpais();
    loadprio();
    loadunitie();
    loaduniuso();
  }); 
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
            url: 'operlugararea.php',
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
            url: 'loadselact.php',
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
            url: 'loadselact.php',
            type: 'POST',
            data:'opc=insumo&key='+seek,
            success: function(data){
                $("#selinsumos").html(data);
                $("#selinsumos").selectpicker('refresh');
            }
        }); 
    });

    $("#sellugar").change(function(e){
        loadarea();
    });   
</script>
<script>    // validacion de serial y codigo externo unicos
  $("#serial").keyup(function(e){
    var str=$(this).val();
    $.ajax({
      url:'loadselact.php',
      type:'POST',
      data:'opc=seeksn&txt='+str,
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
    $.ajax({
      url:'loadselact.php',
      type:'POST',
      data:'opc=seekcodex&txt='+str,
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
          url: "insert_activo.php",
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
          url:'loadselact.php',
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

    function loadinsumos(){
      var idact=$("#codigo").val();
      $.ajax({
        url:'loadselact.php',
        type:'POST',
        data:'opc=loadtbinsu&idact='+idact,
        success:function(res){
          $("#tbodyinsumos").html(res);
        }
      })
    }
    $(document).ready(function() {
      loadinsumos();
    });
</script>
      





