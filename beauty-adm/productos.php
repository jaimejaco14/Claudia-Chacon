<?php 
    include("./head.php");
    include '../cnx_data.php';

    VerificarPrivilegio("PRODUCTO", $_SESSION['tipo_u'], $conn);
    RevisarLogin();
    include "librerias_js.php";

?>
<script src="js/productos.js"></script>



<div class="normalheader ">
    <div class="hpanel">
        <div class="panel-body">
            <a class="small-header-action" href="">
                <div class="clip-header">
                    <i class="fa fa-arrow-up"></i>
                </div>
            </a>

            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb"> 
                    <li><a href="index.html">Inicio</a></li>
                    <li>
                        <span>Inventario</span>
                    </li>
                    <li class="active">
                        <span>Productos</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs">
                Productos
            </h2>
            <hr style="width: 50%; margin-left: 0">
            <input type="text" name="" id="txt_buscar" style="width: 50%" class="form-control" value="" placeholder="Buscar por código, codigo de barras, producto o código anterior" title="Buscar Pruducto">
        </div>
    </div>
</div>

<div class="content">
 <div class="col-lg-12">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li class="active lista"><a data-toggle="tab" class="tab_lista" id="tab_lista" href="#tab-3"><i class="fa fa-table"></i>  Productos</a></li>
                <li class=" nuevo"><a data-toggle="tab" href="#tab-4"><i class="fa fa-plus"></i> Nuevo Producto</a></li>
                <li class=" edit disabled"><a data-toggle="tab" id="edit_prod" class="disabled" ><i class="fa fa-edit"></i>  Editar Producto</a></li>
                <li class="tipo_lista"><a data-toggle="tab" href="#tab-6" id="tipo_lista"><i class="fa fa-list"></i>  Tipo Lista</a></li>
                <button class="btn pull-right btn-link" id="" data-toggle="tooltip" data-placement="bottom" title="Enviar Correo"><i class="fa fa-envelope-o text-info"></i></button>
                <button class="btn pull-right btn-link" id="btn_reporte_pdf" data-toggle="tooltip" data-placement="bottom" title="Exportar PDF"><i class="fa fa-file-pdf-o text-info"></i></button>
                <button class="btn pull-right btn-link" id="btn_reporte_excel" data-toggle="tooltip" data-placement="bottom" title="Exportar EXCEL"><i class="fa fa-file-excel-o text-info"></i></button>
            </ul>
            <div class="tab-content">
                <div id="tab-3" class="tab-pane active">
                    <div class="panel-body panel_nuevo" id="tumb_productos">
                      <?php include "listado_productos.php";?>

                    </div> 
                </div>
                <!--Pestaña NUEVO PRODUCTO-->
                <div id="tab-4" class="tab-pane panel_n">
                    <div class="panel-body">
                       <div class="col-md-6">
                         <form id="nuevo_producto" method="POST" enctype="multipart/form-data" runat="server">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">Nombre del Producto</label>
                                  <input type="text" name="producto" class="form-control" id="producto" placeholder="Nombre del Producto">
                              </div>
                              <div class="form-group">
                                  <label for="exampleInputPassword1">Alias</label>
                                  <input type="text" maxlength="10" class="form-control" id="alias" name="alias" placeholder="Alias">
                              </div>
                               <div class="form-group">
                                    <label for="exampleInputPassword1">Impuesto</label>
                                    <div class="input-group">
                                    <select name="sel_impuesto" id="sel_impuesto" class="form-control">
                                         
                                    </select>
                                    <div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Impuesto">
                                      <button type="button" data-toggle="modal" data-target="#modalimpuesto" id="" name="" class="btn btn-default">
                                        <span class="fa fa-plus-square text-info"></span>
                                      </button>
                                  </div>
                                  </div>
                              </div>
                              <div class="form-group">
                                <label for="exampleInputFile">Imagen del Producto</label>
                                <input type="file" id="file_nuevo" name="file_nuevo">
                              </div> 

                               <div class="form-group">
                                <label for="exampleInputFile">Costo Inicial</label>
                                <input type="number" name="costo_inicial" id="costo_inicial" class="form-control">
                              </div>                                                                                             
                       </div> 

                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="exampleInputPassword1">Uni. Medida</label>
                              <div class="input-group">
                                <select name="sel_unimedida" id="sel_unimedida" class="form-control">
                                       
                                </select>
                                <div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Unidad de Medida">
                                  <button type="button" data-toggle="modal" data-target="#modalunimedi" id="btn_unidad_med" name="btn_unidad_med" class="btn btn-default">
                                    <span class="fa fa-plus-square text-info"></span>
                                  </button>
                                </div>
                              </div>
                          </div>

    

                          <div class="form-group">
                            <label for="exampleInputEmail1">Código Anterior</label>
                            <input type="number" class="form-control" name="cod_anterior" id="cod_anterior" placeholder="Código Anterior">
                          </div>

                          <div class="form-group">
                            <label for="exampleInputPassword1">Tipo Comisión</label>
                            <select name="sel_tipo" id="sel_tipo" class="form-control">
                              <option value="0" selected>Seleccione Tipo Comisión</option>
                              <option value="FIJO">Fijo</option>
                              <option value="PORCENTUAL">Porcentual</option>                      
                            </select>
                          </div> 
                          <div class="form-group">
                            <label for="exampleInputEmail1">Comisión</label>
                            <input type="number"  class="form-control" name="comision" id="comision" placeholder="Comisión">
                          </div>                             
                        </div>

                        <div class="row">
                          <div class="col-md-12"> 
                        <hr>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="3" placeholder="Digite la descripción"></textarea> 
                       </div>
                        </div>
                       <div class="row">
                           <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group" style="float:left; margin-right: 8px">
                                          <div class="checkbox">
                                            <label>
                                              <input type="checkbox" id="propor" name="proporcionado" value="1"> Porcionado
                                            </label>
                                          </div>                                
                                    </div>
                                </div>
                                   <div class="col-md-3">
                                    <div class="form-group" style="float:left; margin-right: 8px">
                                          <div class="checkbox">
                                            <label>
                                              <input type="checkbox" id="ctrl_venc" name="ctrl_venc" value="1" checked> Ctrl Vencimiento
                                            </label>
                                          </div>                                
                                    </div>
                                  </div>
                                   <div class="col-md-3">
                                    <div class="form-group" style="float:left; margin-right: 8px">
                                          <div class="checkbox">
                                            <label>
                                              <input type="checkbox" id="precio_f" name="precio_f" value="1"> Precio Fijo
                                            </label>
                                          </div>                                
                                    </div>
                                </div>
                                   <div class="col-md-3">
                                    <div class="form-group" style="float:left; margin-right: 8px">
                                          <div class="checkbox">
                                            <label>
                                              <input type="checkbox" id="activo" name="activo" value="1" checked> Activo
                                            </label>
                                          </div>                                
                                    </div>
                                </div>
                           </div>
                       </div>
                       <hr>
                       <div class="row">
                         <div class="col-md-12">
                              <div class="col-md-3">  
                                <div class="form-group">
                                    <label class="control-label">Grupo</label>
                                    <div class="input-group">
                                          <select name="sel_grupo" id="sel_grupo" required class="form-control">
                                            <option></option>
                                          </select>
                                          <div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Grupo">
                                              <button type="button" data-toggle="modal" data-target="#modalGrupo" id="" name="" class="btn btn-default">
                                                  <span class="fa fa-plus-square text-info"></span>
                                              </button>
                                          </div>
                                    </div>
                                </div>
                              </div>
                              <div class="col-md-3">  
                                <div class="form-group">
                                    <label class="control-label">Sub-grupo</label>
                                    <div class="input-group">
                                          <select disabled name="sel_subgrupo" id="sel_subgrupo" required class="form-control">
                                            <option></option>
                                          </select>
                                          <div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Sub-grupo">
                                              <button type="button" data-toggle="modal" data-target="#modalSubgrupo" id="" name="" class="btn btn-default btn_grp" disabled>
                                                  <span class="fa fa-plus-square text-info"></span>
                                              </button>
                                          </div>
                                    </div>
                                </div>
                              </div>
                              <div class="col-md-3">  
                                <div class="form-group">
                                    <label class="control-label">Línea</label>
                                    <div class="input-group">
                                          <select disabled name="linea" id="linea" required class="form-control">
                                            <option></option>
                                          </select>
                                          <div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Línea">
                                              <button type="button" data-toggle="modal" data-target="#modalLinea" id="" name="" class="btn btn-default btn_lin" disabled>
                                                  <span class="fa fa-plus-square text-info"></span>
                                              </button>
                                          </div>
                                    </div>
                                </div>
                              </div>
                              <div class="col-md-3">  
                                <div class="form-group">
                                    <label class="control-label">Sub-línea</label>
                                    <div class="input-group">
                                          <select disabled name="sublinea" id="sublinea" required class="form-control">
                                            <option></option>
                                          </select>
                                          <div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Sub-línea">
                                              <button type="button" data-toggle="modal" data-target="#modalSublinea" id="" name="" class="btn btn-default btn_sublin" disabled>
                                                  <span class="fa fa-plus-square text-info"></span>
                                              </button>
                                          </div>
                                    </div>
                                </div>
                              </div>
                         </div>
                         <div class="col-md-6">
                              <div class="form-group">
                                    <label class="control-label">Características</label>
                                    <div class="input-group">
                                          <select disabled name="caracteristicas" id="caracteristicas" required class="form-control">
                                            <option></option>
                                          </select>
                                          <div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Características">
                                              <button type="button" data-toggle="modal" data-target="#modalCarac" id="" name="" class="btn btn-default btn_car" disabled>
                                                  <span class="fa fa-plus-square text-info"></span>
                                              </button>
                                          </div>
                                    </div>
                                </div>
                         </div>
                       </div>
                       <hr>
                       <button type="submit" id="btn_guardar_pro" class="btn btn-success">Guardar</button>
                    </form>                      
                    </div>
                </div>
              <div id="tab-5" class="tab-pane panel-edit">
                <div class="panel-body panel_edicion">
                  <strong id="stn_info">No ha seleccionado ningún producto </strong><br>                        
                    <div class="row" id="edicion">
                      
                                       
                    </div>
                  </div>
                </div>

                <div id="tab-6" class="tab-pane panel-edit">
                <div class="panel-body">
                  <strong id="stn_info">Tipo Lista </strong><br>                        
                    <div class="row" id="">
                      
                                       
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Añadir Nuevo Grupo -->
<div class="modal fade" id="modalGrupo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Añadir Nuevo Grupo</h4>
      </div>
      <div class="modal-body">
              <form id="form_nuevo_grupo" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nombre de Grupo</label>
                    <input type="text" name="txt_grupo" class="form-control" id="txt_grupo" placeholder="Digite Grupo">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Alias</label>
                    <input maxlength="15" type="text" name="txt_alias" class="form-control" id="txt_alias" placeholder="Digite Alias">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Descripción</label>
                    <textarea name="txt_descripcion" id="txt_descripcion" class="form-control" rows="3" placeholder="Digite la descripción"></textarea>
                  </div>
                   <div class="form-group">
                    <label for="exampleInputFile">Imagen</label>
                    <input type="file" name="file" id="file">
                  </div>        
      </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-success">Guardar</button>
              </form>
              </div>
    </div>
  </div>
</div>


<!-- Modal Añadir Nuevo SubGrupo -->
<div class="modal fade" id="modalSubgrupo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Añadir Nuevo Subgrupo</h4>
      </div>
      <div class="modal-body">
         <form id="form_nuevo_subgrupo" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nombre de Subgrupo</label>
                    <input type="text" name="txt_subgrupo" class="form-control" id="txt_subgrupo" placeholder="Digite Sub-grupo">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Alias</label>
                    <input maxlength="15" type="text" name="txt_subalias" class="form-control" id="txt_subalias" placeholder="Digite Alias">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Descripción</label>
                    <textarea name="txt_subdescripcion" id="txt_subdescripcion" class="form-control" rows="3" placeholder="Digite la descripción"></textarea>
                  </div>
                   <div class="form-group">
                    <label for="exampleInputFile">Imagen</label>
                    <input type="file" name="subfile" id="subfile">
                  </div>        
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-success">Guardar</button>
              </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal Añadir Nueva Línea -->
<div class="modal fade" id="modalLinea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Añadir Nueva Línea</h4>
      </div>
      <div class="modal-body">
        <form id="form_nueva_linea" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nombre de Línea</label>
                    <input type="text" name="txt_linea" class="form-control" id="txt_linea" placeholder="Digite Línea">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Alias</label>
                    <input maxlength="15" type="text" name="txt_lin_alias" class="form-control" id="txt_lin_alias" placeholder="Digite Alias">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Descripción</label>
                    <textarea name="txt_lin_descricpion" id="txt_lin_descricpion" class="form-control" rows="3" placeholder="Digite la descripción"></textarea>
                  </div>
                   <div class="form-group">
                    <label for="exampleInputFile">Imagen</label>
                    <input type="file" name="lin_file" id="lin_file">
                  </div>        
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-success">Guardar</button>
              </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal Añadir Nueva Sublinea -->
<div class="modal fade" id="modalSublinea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Añadir Nueva Sublínea</h4>
      </div>
      <div class="modal-body">
           <form id="form_nueva_sublinea" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nombre de Sublínea</label>
                    <input type="text" name="txt_sublinea" class="form-control" id="txt_sublinea" placeholder="Digite Sub-línea">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Alias</label>
                    <input maxlength="15" type="text" name="txt_sublin_alias" class="form-control" id="txt_sublin_alias" placeholder="Digite Alias">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Descripción</label>
                    <textarea name="txt_sublin_descricpion" id="txt_sublin_descricpion" class="form-control" rows="3" placeholder="Digite la descripción"></textarea>
                  </div>
                   <div class="form-group">
                    <label for="exampleInputFile">Imagen</label>
                    <input type="file" name="sublin_file" id="sublin_file">
                  </div>        
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-success">Guardar</button>
              </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Añadir Nueva Caracteristica -->
<div class="modal fade" id="modalCarac" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Añadir Nueva Característica</h4>
      </div>
      <div class="modal-body">
          <form id="form_nueva_caracteristica" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nombre de Característica</label>
                    <input type="text" name="txt_caracteristica" class="form-control" id="txt_caracteristica" placeholder="Digite Característica">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Alias</label>
                    <input maxlength="15" type="text" name="txt_car_alias" class="form-control" id="txt_car_alias" placeholder="Digite Alias">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Descripción</label>
                    <textarea name="txt_car_descp" id="txt_car_descp" class="form-control" rows="3" placeholder="Digite la descripción"></textarea>
                  </div>
                   <div class="form-group">
                    <label for="exampleInputFile">Imagen</label>
                    <input type="file" name="car_file" id="car_file">
                  </div>        
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-success">Guardar</button>
                </div>
              </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal Enviar Correo -->
<!-- <div class="modal fade" id="modalenviocorreoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Enviar Correo</h4>
      </div>
      <div class="modal-body">
          <form id="form_nueva_caracteristica" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="sr-only" for="exampleInputAmount"></label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
                      <input type="email" class="form-control" id="txt_correos" placeholder="Digite Correo Electrónico">
                      <div class="input-group-addon"><button id="btn_add_correo" type="button" data-toggle="tooltip" data-placement="bottom" title="Añadir e-mail" class="btn btn-xs btn-info"><i class="fa fa-plus"></i></button></div>
                    </div>
                  </div> 
                  <div class="form-group">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="rptf"> PDF
                        </label> 
                        <label>
                          <input type="checkbox" id="rptx"> EXCEL 
                        </label>                       
                      </div> 
                  </div>                                  
                  <div class="form-group">
                    <table class="table table-hover table-bordered" id="tabla_envio_correo">
                      <thead>
                        <tr>
                          <th>Email</th>
                          <th>Remover</th>
                        </tr>
                      </thead>
                      <tbody>
                          
                      </tbody>
                    </table>
                  </div>                                           
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="button" id="btn_envio_correo" class="btn btn-success">Guardar</button>
                </div>
              </form>
      </div>
    </div>
  </div>
</div> -->

<div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" id="modalenviocorreo">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="TituloSalonBase" class="modal-title">Enviar al Correo</h4>
                <h4 id="actual"></h4>
            </div>
            <form >     
                <div class="modal-body">
                    <div class="row">
                    <div class="form-group col-lg-6 ">
                    <div class="hpanel stats">
                    <br>
                    <div class="panel-heading hbuilt">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        Correos
                    </div>
                    <div class="panel-body list" style="display: none;">
                    <b>E-mails</b>
                        <div class="stats-icon pull-right">
                             <i class="pe-7s-mail fa-2x"></i>
                        </div>
                        <div class="m-t-xl">
                            <small>
                               <div class=" table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="tbcorreo">
                            <tr>
                            </tr>
                            </table>
                            <br>
                            </div>
                            </small>
                        </div>
                    </div>
                    <div class="panel-footer" style="display: none;">
                    <button style="display:none" type="button" onclick="delet()" class="btn btn-default pe-7s-close" id="qtcr"></button>
                    </div>
                </div>
                    
                            
                        </div>
                         Direccion de Correo:

                        <div class="input-group col-lg-5">
                       
                         <input type="email" name="emailr" id="emailr" class="form-control" placeholder="Adicionar...">

                           <span class="input-group-btn">

                                <button onclick="adcc();" class="btn btn-default" id="btn_send_co" type="button"><i class="glyphicon glyphicon-plus small"></i> </button>
                           </span>
                    </div>
                    <br>
                    <label class="checkbox-inline"><input  type="checkbox" id="rptf"  name="rptf" value="" >PDF</label>&nbsp;&nbsp;
                            <label class="checkbox-inline"><input  type="checkbox" id="rptx" name="rptx" value="" >Excel</label>  
                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" onclick="env()" class="btn btn-default " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Enviar</span></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>



<!-- Modal Nuevo Uni Medida -->
<div class="modal fade" id="modalunimedi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva Unidad de Medida</h4>
      </div>
      <div class="modal-body">
          <form id="form_nueva_caracteristica" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="sr-only" for="exampleInputAmount"></label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-balance-scale"></i></div>
                          <input type="email" class="form-control" id="txt_unidad_med" placeholder="Digite Unidad">                     
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="sr-only" for="exampleInputAmount"></label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-tag"></i></div>
                          <input type="email" class="form-control" maxlength="3" id="txt_alias_uni" placeholder="Digite alias">                     
                    </div>
                  </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="button" id="btn_guardar_unimedida" class="btn btn-success">Guardar</button>
                </div>
              </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal Nuevo Impuesto -->
<div class="modal fade" id="modalimpuesto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Impuesto</h4>
      </div>
      <div class="modal-body">          
                  <div class="form-group">
                    <label class="sr-only" for="exampleInputAmount"></label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-balance-scale"></i></div>
                          <input type="text" class="form-control" id="txt_impuesto" placeholder="Digite Impuesto">                     
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="sr-only" for="exampleInputAmount"></label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-tag"></i></div>
                          <input type="text" class="form-control" maxlength="10" id="txt_alias_imp" placeholder="Digite alias">                    
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="sr-only" for="exampleInputAmount"></label>
                    <div class="input-group">
                      <div class="input-group-addon" id="tpi"><i class="fa fa-ellipsis-h"></i></div>
                        <select name="" id="sel_impuesto_nuevo" class="form-control">
                              <option value="sel"  selected>Seleccione tipo</option>
                              <option value="1">Porcentaje</option>
                              <option value="0">Fijo</option>
                        </select>                     
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="sr-only" for="exampleInputAmount"></label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-usd"></i></div>
                          <input type="number" class="form-control" maxlength="5" id="valor" placeholder="Digite valor">                    
                    </div>
                  </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="button" id="btn_guardar_impuesto" class="btn btn-success">Guardar</button>
                </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>

<style>
  .cod_prod{
    display: none;
  }
  th,td{
    text-align: center;
  }
</style>

<script>
  var i=0;
  var arr1=[];



  function adcc () {
      if (i<=4) {

          arr1[i]=($('#emailr').val());
          var table = document.getElementById("tbcorreo");
              {
                var row = table.insertRow(0);
                var cell1 = row.insertCell(0);
                cell1.innerHTML = arr1[i];
              }

            $('#qtcr').show();
            $('#emailr').val('');
               i++;
       }else{
          swal("¡Los sentimos solo son adminitidos 5 Correos!")
       }
   
  }

  $(document).ready(function() {
    $(document).on('click', '#btn_paginar', function() {
        var data = $(this).data("id");
        $.ajax({
            type: "POST",
            url: "listado_productos.php",
            data: {page: data},
            success: function (data) {
                $('#tumb_productos').html(data);
            }
        });
    });
  });


  function env () {
      i=0;
      var tipey
      var tipex
          $('#qtcr').hide();
          $('#tbcorreo').empty();
          $('#emailr').val('');
          $('#rptx').removeAttr('checked');
          $('#rptf').removeAttr('checked');
          $.ajax({
             async: false,
             type: "POST",
             url: "envio_correo_productos.php",
             data: {
                 correos: arr1
             },
             success: function(data) {
              swal("Mensaje", data+"!")
             }
          });
          arr1=[];
   } 



   function delet() {
        swal({
        title: "Estas seguro?",
        text: "Desea remover el ultimo correo adicionado ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si, Borrar!",
        closeOnConfirm: false
        },function(){
          var quit=arr1.pop();
          if (quit!=null) {  
            swal("Deleted!", "El Correo "+quit+" fue removido", "success");
            document.getElementById("tbcorreo").deleteRow(0);
            i--;
          }else{
              $('#qtcr').hide();
              ver=0;
              swal("Error", "No hay correos por Remover");
              showCancelButton: false;
          }
      });
   }

  $('#rptf').on("click", function(){
      $.ajax({
         async: false,
         type: "POST",
         url: "reporte_productos.php",
         data: {
             envio: 1, dato: $("#txt_buscar").val()
         },
         success: function(data) {
          console.log(data);
         }
      });
             
  }); 
        
  $('#rptx').on("click", function(){
            
      $.ajax({
           async: false,
           type: "POST",
           url: "reporte_productos.php",
           data: {
               enviox: 1, dato: $("#txt_buscar").val()
           },
           success: function(data) {
            console.log(data);
           }
      });
  });


  function obtenerGruposServicio(){

      $.ajax({
        url: 'obtenerCategoriasListaPrecios.php',
        data: {categoria: "grupo"},
      })
      .done(function(grupos){

        var jsonGrupos = JSON.parse(grupos);
        var grupos;

        if(jsonGrupos.result == "full"){

          grupos = "<option selected disabled>--- Seleccione un grupo ---</option>";

          for(i in jsonGrupos.grupos){

            grupos += "<option value='"+jsonGrupos.grupos[i].codigo+"'>"+jsonGrupos.grupos[i].nombre+"</option>";
          }
        }
        else{

          grupos = "<option selected disabled> No hay grupos</option>";
        }

        $("#selectGrupoServiciosLista").html(grupos);
      });

      $("#selectSubgrupoServiciosLista").attr("disabled", "disabled");
      $("#selectLineaServiciosLista").attr("disabled", "disabled");
      $("#selectSublineaServiciosLista").attr("disabled", "disabled");
      $("#selectCaracteristicaServiciosLista").attr("disabled", "disabled");
      $("#selectSubgrupoServiciosLista").val("");
      $("#selectLineaServiciosLista").val("");
      $("#selectSublineaServiciosLista").val("");
      $("#selectCaracteristicaServiciosLista").val("");
    }

 $(document).ready(function() {
    conteoPermisos ();
});
</script>









