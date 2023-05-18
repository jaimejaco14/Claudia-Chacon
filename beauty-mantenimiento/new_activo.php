<?php 
include '../../cnx_data.php';
include 'head.php';
VerificarPrivilegio("ACTIVOS", $_SESSION['tipo_u'], $conn);
    RevisarLogin();  
?>
<style>
  .panel-title{cursor:pointer;}
</style>
<div class="small-header">
    <div class="hpanel">
        <div class="panel-body">
       <h2 class="pull-left">REGISTRO DE ACTIVOS</h2>
            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="index.php">Inicio</a></li>
                    <li>
                        <a href="activos.php">Activos</a>
                    </li>
                    <li class="active">
                        <span>Nuevo Activo</span>
                    </li>
                </ol>
            </div>
        </div>        
    </div>
    <div class="container" style="background-color:white;">
      <form id="form_atc" method="post" class="formul" autocomplete="off">
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
                          <!-- nombre -->
                          <div class="form-group">
                              <label>Nombre</label>
                              <input  class="form-control text-uppercase" type="text" name="act_name" id="act_name" placeholder="INGRESE NOMBRE" data-error="camp obligatorio" >
                              <div id="infonomact" class="help-block with-errors"></div>
                          </div>
                          <!-- marca -->
                          <div class="form-group">
                              <label>Marca</label>
                              <div class="input-group">
                              <div class="input-group-btn"> <a data-toggle="modal" data-target="#modal_marca"><button class="btn btn-default" title="Agregar nuevo"><i class="fa fa-plus-square text-info"></i></button></a></div><select class="form-control" name="marcas" id="marcas" data-error="Escoja una opcion" >
                              </select>
                              </div>
                          </div>
                          <!-- modelo -->
                          <div class="form-group">
                              <label>Modelo</label>
                              <input  class="form-control text-uppercase" type="text" id="modelo" name="modelo" placeholder="INGRESE MODELO" >
                          </div>
                          <!-- espec -->
                           <div class="form-group">
                              <label>Especificaciones</label>
                              <input  class="form-control text-uppercase" type="text" id="especificaciones" name="especificaciones" placeholder="INGRESE ESPECIFICACIONES" >
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
                                  <img src="../contenidos/imagenes/default.jpg"  id="imgact" class="img-rounded img-responsive" onerror="this.src='../contenidos/imagenes/default.jpg';">
                              </div>
                          </div>
                          <br><br><br>

                          <!-- img -->
                          <div class="form-gruop">
                              <label>Imagen</label>
                              <input class="form-control" id="imagen" name="imagen" type="file">
                              <div id="InfoImg" class="help-block with-errors"></div>
                          </div>
                          <!-- SN -->
                           <div class="form-group">
                              <label>Serial</label>
                              <input  class="form-control text-uppercase" type="text" id="serial" name="serial" placeholder="INGRESE SERIAL" >
                              <div id="infosn"></div>
                          </div>
                          <!--desc -->
                          <div class="form-group">
                              <label>Descripción</label>
                              <textarea class="form-control text-uppercase" id="marcadescripcion" name="marcadescripcion" type="text"  style="resize: none;"></textarea>
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
                              <input  class="form-control fecha" type="text" name="marcafecha" max="<?php echo $today;?>" placeholder="SELECCIONE FECHA" >
                          </div>
                          <!-- proveedor -->
                           <div class="form-group">
                              <label>Proveedor</label>
                              <div class="input-group">
                              <div class="input-group-btn"> <a id="addprov"><button class="btn btn-default" title="Agregar Proveedor"><i class="fa fa-plus-square text-info"></i></button></a></div><select class="form-control" name="proveedor" id="proveedor" data-error="Elija Proveedor" >
                              </select>
                              </div>
                          </div>
                          <!-- Fabricante -->
                           <div class="form-group">
                              <label>Fabricante</label>
                              <div class="input-group">
                              <div class="input-group-btn"> <a data-toggle="modal" data-target="#modal_fab"><button class="btn btn-default" title="Agregar fabricante"><i class="fa fa-plus-square text-info"></i></button></a></div><select class="form-control" name="fabrica" id="fabrica" data-error="Elija fabricante" >
                              </select>
                              </div>
                          </div>
                          <!-- pais -->
                          <div class="form-group">
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
                              <input  class="form-control fecha" type="text" id="fechainicio" name="fechainicio" max="<?php echo $today;?>" placeholder="SELECCIONE FECHA" >
                          </div>
                          <!-- cod ext -->
                          <div class="form-group">
                              <label>Codigo externo</label>
                              <input  class="form-control" id="codext" name="codigo_externo" type="text"  placeholder="CODIGO EXTERNO" data-error="Campo obligatorio" >
                              <div id="infocodex"></div>
                          </div>
                          <!-- costo -->
                          <div class="form-group">
                              <label>Costo Base</label>
                              <input  class="form-control number" type="number" id="costobase" name="costobase" >
                          </div> 
                          <!-- impuesto -->
                          <div class="form-group">
                              <label>Impuesto Base</label>
                              <input  class="form-control number" type="number" id="impuesto" name="impuesto" >
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
                    <div class="col-md-3">
                      <!-- tipo act -->
                      <div class="form-group">
                          <label>Tipo </label>
                          <div class="input-group">
                         <div class="input-group-btn"> <a data-toggle="modal" data-target="#modal_tipo"><button class="btn btn-default" title="Agregar nuevo"><i class="fa fa-plus-square text-info"></i></button></a></div><select class="form-control" name="tipoactivo" id="tipoactivo" data-error="Escoja una opcion" ></select>
                          </div>  
                      </div>
                    </div>
                    <div class="col-md-3">
                      <!-- sub-tipo act -->
                      <div class="form-group">
                          <label>Subtipo </label>
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
                          <label> Grupo </label>
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
                          <label> Subgrupo </label>
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
                </div>
              </div>
          <!-- Ubicacion -->
              <div class="panel panel-default ">
                <div class="panel-heading head4" data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                  <h4 class="panel-title">
                    Ubicación <small class="tit4" style="color:red;"></small><i class="pull-right fa fa-angle-double-down"></i>
                  </h4>
                </div>
                <div id="collapse5" class="panel-collapse collapse">
                  <div class="panel-body">
                    <div class="col-md-6">
                      <!--ubicacion -->
                      <div class="form-group">
                          <label> Ubicación </label>
                          <div class="input-group">
                            <div class="input-group-btn"> <a data-toggle="modal"> <button class="btn btn-default" title="Agregar nuevo" id="btnnewlug"><i class="fa fa-plus-square text-info"></i></button> </a> </div>
                            <select class="form-control" name="sellugar" id="sellugar" data-error="Escoja una opcion" ></select>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label> Área </label>
                          <div class="input-group">
                            <div class="input-group-btn"> <a data-toggle="modal"> <button class="btn btn-default" title="Agregar nuevo" id="btnnewarea"><i class="fa fa-plus-square text-info"></i></button> </a> </div>
                            <select class="form-control" name="selar" id="selar" data-error="Escoja una opcion" >
                                <option value="0">- Seleccione área -</option>
                            </select>
                          </div>
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
                              <input  class="form-control number" name="freqmtto" type="number" id="freqmtto"  placeholder="DIAS" data-error="Campo obligatorio" disabled  min="1">
                          </div>
                        </div><br><br>
                        <!--Prioridad -->
                        <div class="form-group">
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
                              <input  class="form-control number" name="freqrev" type="number" id="freqrev"  placeholder="DIAS" data-error="Campo obligatorio" disabled  min="1">
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
                          <div class="col-md-3">
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
                              <input  class="form-control number" name="timegar" type="number" id="timegar" data-error="Campo obligatorio" disabled  min="1" max="365">
                          </div>
                          <div class="col-md-6 garact" style="display:none;">
                            <label for="unitime">Unidad</label>
                            <div class="input-group">
                              <div class="input-group-btn"><a data-toggle="modal" data-target="#modal_uni1"><button class="btn btn-default btnnewunidad1" title="Agregar nuevo"><i class="fa fa-plus-square text-info"></i></button></a></div>
                              <select name="unitime" id="unitime" class="form-control"></select>
                            </div>
                          </div>
                          
                        </div>
                        <br>
              
                    </div>
                    <div class="col-md-6">
                        <!--garantia x uso-->
                        <div class="row">
                          <div class="col-md-3">
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
                              <input  class="form-control number" name="cantuso" type="number" id="cantuso" data-error="Campo obligatorio" disabled  min="1">
                          </div>
                          <div class="col-md-6 garact2" style="display:none;">
                              <label for="uniuso">Unidad</label>
                              <div class="input-group">
                                <div class="input-group-btn"> <a data-toggle="modal" data-target="#modal_uni2"> <button class="btn btn-default btnnewunidad" title="Agregar nuevo"><i class="fa fa-plus-square text-info"></i></button> </a> </div>
                              <select name="uniuso" id="uniuso" class="form-control"></select>
                            </div>
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
                    <div class="col-md-6">
                        <div class="form-group col-md-6">
                            <label class="control-label">Insumos</label><br>
                            <div class="pull-left" data-toggle="tooltip" data-placement="right" title="Seleccione si el activo requiere de insumos.">
                              <div class="TriSea-technologies-Switch col-md-2">
                                  <input id="insumos" name="insumos" class="insumos" type="checkbox"/>
                                  <label for="insumos" class="label-primary"></label>
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        
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
                                <div class="pull-left" data-toggle="tooltip" data-placement="right" title="Seleccione si el activo requiere de repuestos.">
                                  <div class="TriSea-technologies-Switch col-md-2">
                                      <input id="rptos" name="rptos" class="rptos" type="checkbox"/>
                                      <label for="rptos" class="label-primary"></label>
                                  </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                  </div>
                </div>
              </div>
        </div> 
        <div class="col-md-12">
            <button type="submit" class="btn btn-success pull-right" data-toggle="tooltip" data-placement="top" title="Guardar Activo"><i class="fa fa-save"></i></button>
            <button type="reset" id="resetnewact"  class="btn btn-default pull-right" data-toggle="tooltip" data-placement="top" title="Cancelar"><i class="fa fa-close text-danger"></i></button>
        </div>
      </form>
    </div>
</div>
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
                  <input class="form-control text-uppercase" id="tianame" name="tianame" maxlength="50" type="text" required>
                  <div id="infotia" class="help-block with-errors err"></div>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Cancelar" data-dismiss="modal"><i class="fa fa-close text-danger"></i></button>
            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fa fa-save text-primary"></i></button>
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
            <form id="form_subtia" method="post" class="formul">
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
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Cancelar" data-dismiss="modal"><i class="fa fa-close text-danger"></i></button>
            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fa fa-save text-primary"></i></button>
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
            <form id="form_gra" method="post" class="formul">
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
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Cancelar" data-dismiss="modal"><i class="fa fa-close text-danger"></i></button>
            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fa fa-save text-primary"></i></button>
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
            <form id="form_subgra" method="post" class="formul">
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
                    </div>
                   <input type="hidden" name="grucodigo" id="grucodigo">

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Cancelar" data-dismiss="modal"><i class="fa fa-close text-danger"></i></button>
                <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fa fa-save text-primary"></i></button>
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
            <form id="form_mar" method="post" class="formul">
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
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Cancelar" data-dismiss="modal"><i class="fa fa-close text-danger"></i></button>
            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fa fa-save text-primary"></i></button>
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
                  <input class="form-control text-uppercase nomlugar" id="lugname" name="lugname" maxlength="50" type="text" required>
                  <div id="Infolug" class="help-block with-errors infolug err"></div>
                </div>
              </div>
              <div class="modal-footer">
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Cancelar" data-dismiss="modal"><i class="fa fa-close text-danger"></i></button>
            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fa fa-save text-primary"></i></button>
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
                <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Cancelar" data-dismiss="modal"><i class="fa fa-close text-danger"></i></button>
                <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fa fa-save text-primary"></i></button>
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
                  <input class="form-control text-uppercase" id="paisname" name="paisname" maxlength="50" type="text" required>
                  <div id="infopais" class="help-block with-errors err"></div>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Cancelar" data-dismiss="modal"><i class="fa fa-close text-danger"></i></button>
            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fa fa-save text-primary"></i></button>
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
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Cancelar" data-dismiss="modal"><i class="fa fa-close text-danger"></i></button>
            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fa fa-save text-primary"></i></button>
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
                  <input class="form-control text-uppercase" id="uniname1" name="uniname1" maxlength="6" type="text" placeholder="EJ: DIA, MES, AÑO, ETC" required>
                  <div id="infouni1" class="help-block with-errors err"></div>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Cancelar" data-dismiss="modal"><i class="fa fa-close text-danger"></i></button>
            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fa fa-save text-primary"></i></button>
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
                  <input class="form-control text-uppercase" id="uniname2" name="uniname2" maxlength="10" type="text" placeholder="EJ: IMPRESIONES, CICLOS, KILOMETROS, ETC" required>
                  <div id="infouni2" class="help-block with-errors err"></div>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Cancelar" data-dismiss="modal"><i class="fa fa-close text-danger"></i></button>
            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fa fa-save text-primary"></i></button>
          </div>
             </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
<!-- /.modal unidad2 -->

<!-- Vendor scripts -->
<?php include "librerias_js.php"; ?>



<script>
  $('[data-toggle="tooltip"]').tooltip();
  $('#side-menu').children(".active").removeClass("active");
  $("#ACTIVO").addClass("active");
  $('.fecha').datetimepicker({
    format: "YYYY-MM-DD",
            locale: "es",
            useCurrent: false
  });
  $('.number').on('input', function () { 
    this.value = this.value.replace(/[^0-9\.]/g,'');
  });

    $("#resetnewact").click(function(e){
      location.reload();
    })
</script>
<script type="text/javascript">
  $(document).ready(function() {
    
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

    $("#resetform").click(function(e){
      location.reload();
    });

  });
    function done (cod) {
          swal({
              title: "Activo guardado exitosamente con el codigo: "+cod,
              text: "Ir a lista de activos",
              type: "success",
              confirmButtonText: "Aceptar"
              },
              function () {
                  window.location = "activos.php";
              });
    }


  $("#addprov").click(function(e){
    e.preventDefault();
    window.open('../../beauty/beauty-adm/nuevo_proveedor.php');
  })


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



        /*$('#act_name').keyup(function(){
            var txt = $(this).val().toUpperCase();     
            var dataString = 'opc=seekactnom&act_name='+txt;
            $.ajax({
                type: "POST",
                url: "php/loadselact.php",
                data: dataString,
                success: function(res) {
                    if(res=='false'){
                      $("#infonomact").html('<h5><font color="red"> Este nombre ya ha sido registrado</font><input tipo="text" hidden required /></h5>');
                    }else{
                      $("#infonomact").html('');
                    }
                }
            });
        });  
        $('#act_name').blur(function(){
            var txt = $(this).val().toUpperCase();     
            var dataString = 'opc=seekactnom&act_name='+txt;
            $.ajax({
                type: "POST",
                url: "php/loadselact.php",
                data: dataString,
                success: function(res) {
                    if(res=='false'){
                      $("#infonomact").html('<h5><font color="red"> Este nombre ya ha sido registrado</font><input tipo="text" hidden required /></h5>');
                    }else{
                      $("#infonomact").html('');
                    }
                }
            });
        });  */
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
<script>
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


                },
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
                        $("#infosubgra").html('<div id="Error" class="help-block with-type-errors"> <input tipo="text" hidden  required/> <font color="red"> Ya existe este Subgrupo de activos</font></div>');
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
      /*********************************/
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
          $("#primsj").html('Esta clasificación de activos maneja prioridad ' + prio);
          $("#prioridad").val(codpri);
          $("#ubicmsj").html('Ubicación del codigo QR: '+ubic);
        }else{
          $("#primsj").html('');
        }
      }
</script>
<script>



      $("#imagen").on("change", function(){
          mostrarImagen(this);
      });



     

      
      function mostrarImagen(input) {

          var imagen = input.files[0];
          var stringImagen = imagen["type"].split("/");
          var tipoImagen = stringImagen[1];
          var tamanoImagen = imagen["size"];

          if((tipoImagen != "jpeg") && (tamanoImagen < 1024000)){

              swal("Error", "Debe subir una imagen con extensi\u00F3n .jpg", "error");
              $("#imagen").val('');
          }
          else if((tipoImagen == "jpeg") && (tamanoImagen > 1024000)){

              swal("Error", "Debe subir una imagen con tama\u00F1o menor a 500KB", "error");
              $("#imagen").val('');
          }
          else if((tipoImagen != "jpeg") && (tamanoImagen > 1024000)){

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
            $("#proveedor").html(res); 
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
<script>
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
<script>
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
<script>
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
    $(document).ready(function() {
        $('#sellugar').selectpicker({
            liveSearch: true,
            showSubtext: true,
            title:'Buscar y seleccionar lugar...'
        });

        $('#proveedor').selectpicker({
            liveSearch: true,
            title:'Buscar y seleccionar proveedor...'
        });
    });

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

    $('#proveedor').on('show.bs.select', function (e) {
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
                $("#proveedor").html(data);
                $("#proveedor").selectpicker('refresh');
            }
        }); 
    });

    $("#sellugar").change(function(e){
        loadarea();
    });

    
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
</script>
<script>
  $("#serial").keyup(function(e){
    var str=$(this).val();
    $.ajax({
      url:'php/loadselact.php',
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
  $("#serial").blur(function(e){
    var str=$(this).val();
    $.ajax({
      url:'php/loadselact.php',
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
      url:'php/loadselact.php',
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
  $("#codext").blur(function(e){
    var str=$(this).val();
    $.ajax({
      url:'php/loadselact.php',
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
<script>
  $("#form_atc").on("submit", function(e){
    e.preventDefault();
    sw=validar();
    console.log(sw);
    if(sw!=0){
      var formData = new FormData($(this)[0]);
      console.log(formData);
      $.ajax({
          url: "php/insert_activo.php",
          type: "post",
          dataType: "html",
          contentType: false,
          cache: false,
          processData:false,
          data: formData,
          success:function(data){
            var answ=data.split('•');
            if (answ[0] == "TRUE") {
              done(answ[1]);
            }else{
              swal('Oops!','Ha ocurrido un error, refreque la pagina e intentelo nuevamente!','error');
              console.log(answ.resp);
              console.log(answ.sql);
            }
          }
      })
    }   
  });
  function validar(){
    var sw,sw1,sw2,sw3,sw4,swm,swm1,swm2,swm3,swg1,sgw2,a,b,c,d,e,f,g;
    //generalidades***********************************************************************************************************
    if(($("#act_name").val()!='') && ($("#marcas").val()!=0) && ($("#modelo").val()!='') && ($("#especificaciones").val()!='') && ($("#marcadescripcion").val()!='')){sw1=0}else{sw1=1}
      if(sw1==1){$(".tit1").html('(Incompleto)');a=0;}else{$(".tit1").html('');a=1;}
    //datos de compra***********************************************************************************************************
    if(($("#proveedor").val()!=0) && ($("#fabrica").val()!=0) && ($("#pais").val()!=0) && ($("#costobase").val()!='') && ($("#impuesto").val()!='')){sw2=0}else{sw2=1}
      if(sw2==1){$(".tit2").html('(Incompleto)');b=0;}else{$(".tit2").html('');b=1;}
    //clasificacion***********************************************************************************************************
    if(($("#subgrupoactivo").val()!=0)){sw3=0}else{sw3=1}
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
  })
</script>