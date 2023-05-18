<?php 

  include '../cnx_data.php';
  include 'head.php';
VerificarPrivilegio("SERVICIOS", $_SESSION['tipo_u'], $conn);

    $queryGrupos      = "SELECT grucodigo AS codigoGrupo, grunombre AS nombreGrupo FROM btygrupo WHERE tpocodigo = 2 AND gruestado = 1";
    $resulQueryGrupos = $conn->query($queryGrupos);
?>
<!-- Input para guardar el tipo de usuario y verificar acceso a modificacion de categorias -->
<input type="number" name="txtTipoUsuario" id="txtTipoUsuario" value="<?php echo $_SESSION['tipo_u'] ?>" readonly style="display: none">
<div class="row">
    <div class="col-sm-12">
        <div class="content animate-panel">
            <div class="row">
                <div class="hpanel">
                    <div class="panel-heading">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        NUEVO SERVICIO
                    </div>
                    <div class="panel-body">
                        <form enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-6 col-md-8">
                                    <div class="form-group">
                                        <label class="control-label">Nombre del servicio</label>
                                        <input type="text" maxlength="50" id="txtNombreServicio" name="txtNombreServicio" required class="form-control text-uppercase" placeholder="Nombre del servicio">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">C&oacute;digo anterior</label>
                                        <input type="number" min="1" class="form-control text-uppercase" name="txtCodigoAnteriorServicio" placeholder="C&oacute;digo anterior" id="txtCodigoAnteriorServicio">
                                        <small id="mensajeErrorCodigoAnterior" class="text-danger"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="display: none">
                                <div class="col-sm-12">
                                    <label>Codigo anterior 2</label>
                                    <input type="number" name="txtCodigoAnteriorServicio2" value="1" id="txtCodigoAnteriorServicio2" min="0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Alias</label>
                                        <input type="text" maxlength="10" class="form-control text-uppercase" placeholder="Alias del servicio" required id="txtAliasServicio" name="txtAliasServicio">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Duraci&oacute;n estimada del servicio</label>
                                        <div class="input-group">
                                            <input type="number" min="1" class="form-control" placeholder="0" id="txtDuracionServicio" name="txtDuracionServicio" required>
                                            <div class="input-group-addon">
                                                <span>min.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Porcentaje de comisi&oacute;n</label>
                                        <div class="input-group">
                                            <input type="number" name="txtComisionServicio" id="txtComisionServicio" class="form-control" placeholder="0" min="0" max="100" required>
                                            <div class="input-group-addon">
                                                <span class="fa fa-percent"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-md-4">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="checkPrecioFijoServicio" id="checkPrecioFijoServicio" value="1" checked> Precio fijo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-4">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label data-toggle="tooltip" data-placement="top" title="Permitir que se pueda agendar mediante citas">
                                                <input type="checkbox" name="checkCitaServicio" value="1" id="checkCitaServicio" checked> Disponible para cita
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-4">
                                    <div class="form-group">
                                         <div class="checkbox">
                                            <label data-toggle="tooltip" data-placement="top" title="Permitir que se pueda programar su realizaci&oacute;n a domicilio">
                                                <input type="checkbox" name="checkDomicilioServicio" value="1" id="checkDomicilioServicio" checked> Disponible para domicilio
                                            </label>
                                        </div>
                                     </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Imagen del servicio</label>
                                        <input type="file" name="iflImagenServicio" id="iflImagenServicio" placeholder="Imagen del servicio" class="form-control">
                                        <p class="help-block" id="mensajeImagen"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Categoria del servicio</label>
                                    <select name="" id="ctcservicio" class="form-control" required="required">
                                        <?php 
                                            $sql="SELECT ctccodigo,ctcnombre FROM btycategoria_colaborador cc WHERE cc.ctcestado=1 order by cc.ctccodigo";
                                            $res=$conn->query($sql);
                                            while($row=$res->fetch_array()){
                                                ?>
                                                <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="selcargo">Cargo(s) asociados al servicio </label><br>                                    
                                    <select class="form-control" name="selcargo" id="selcargo" data-error="Escoja una opcion" multiple="multiple">
                                        <?php
                                        $result = $conn->query("SELECT crgcodigo, crgnombre FROM btycargo where crgcodigo NOT IN (4,5,6) ORDER BY crgnombre");
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {                
                                                echo '<option value="'.$row['crgcodigo'].'">'.$row['crgnombre'].'</option>';
                                            }
                                        }
        
                                        ?>
                                    </select>  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Descripci&oacute;n del servicio</label>
                                        <textarea name="txtDescripcionServicio" id="txtDescripcionServicio" placeholder="Descripci&oacute;n del servicio" rows="2" maxlength="500" class="form-control text-uppercase"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Grupo</label>
                                        <div class="input-group">
                                            <select name="selectGrupoServicio" id="selectGrupoServicio" required class="form-control">
                                                <?php 
                                                    if(mysqli_num_rows($resulQueryGrupos) > 0){

                                                        echo "<option selected disabled>---Seleccione un grupo---</option>";

                                                        while($registrosGrupos = $resulQueryGrupos->fetch_array()){

                                                            echo "<option value='".$registrosGrupos["codigoGrupo"]."'>".$registrosGrupos["nombreGrupo"]."</option>";
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <div class="input-group-btn"  data-toggle="tooltip" data-placement="top" title="Nuevo grupo">
                                                <button type="button" data-toggle="modal" data-target="#modalGrupo" id="btnSelectGrupo" name="btnSelectGrupo" class="btn btn-default">
                                                    <span class="fa fa-plus-square text-info"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Sub-grupo</label>
                                        <div class="input-group">
                                            <select disabled name="selectSubgrupoServicio" id="selectSubgrupoServicio" required class="form-control">
                                                <option></option>
                                            </select>
                                            <div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Nuevo subgrupo">
                                                <button type="button" data-toggle="modal" data-target="#modalSubgrupo" id="btnSelectSubgrupo" name="btnSelectSubgrupo" class="btn btn-default" disabled>
                                                    <span class="fa fa-plus-square text-info"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">L&iacute;nea</label>
                                        <div class="input-group">
                                            <select disabled name="selectLineaServicio" id="selectLineaServicio" required class="form-control">
                                                <option></option>
                                            </select>
                                            <div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Nueva l&iacute;nea">
                                                <button type="button" data-toggle="modal" data-target="#modalLinea" disabled id="btnSelectLinea" name="btnSelectLinea" class="btn btn-default">
                                                    <span class="fa fa-plus-square text-info"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Sub-l&iacute;nea</label>
                                        <div class="input-group">
                                            <select disabled name="selectSublineaServicio" id="selectSublineaServicio" required class="form-control">
                                                <option></option>
                                            </select>
                                            <div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Nueva subl&iacute;nea">
                                                <button type="button" data-toggle="modal" data-target="#modalSublinea" disabled id="btnSelectSublinea" name="btnSelectSublinea" class="btn btn-default">
                                                    <span class="fa fa-plus-square text-info"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Caracter&iacute;stica</label>
                                        <div class="input-group">
                                            <select disabled name="selectCaracteristicaServicio" id="selectCaracteristicaServicio" required class="form-control">
                                                <option></option>
                                            </select>
                                            <div class="input-group-btn" data-toggle="tooltip" data-placement="top" title="Nueva caracter&iacute;stica">
                                                <button type="button" data-toggle="modal" data-target="#modalCaracteristica" id="btnSelectCaracteristica" disabled name="btnSelectCaracteristica" class="btn btn-default">
                                                    <span class="fa fa-plus-square text-info"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Requiere Insumos</label><br>
                                        <!-- <div class="col-md-4" data-toggle="tooltip" data-placement="right" title="seleccione si el servicio requiere de insumos">
                                               <input type="checkbox" name="swins" id="swins"  data-toggle="toggle" data-off="NO" data-on="SI" >
                                        </div> -->
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

                                       <div class="pull-left" data-toggle="tooltip" data-placement="right" title="seleccione si el servicio requiere de insumos">
                                            <div class="TriSea-technologies-Switch col-md-2">
                                                <input id="TriSeaPrimary" name="swins" class="swins" type="checkbox"/>
                                                <label for="TriSeaPrimary" class="label-primary"></label>
                                            </div>
                                       </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="button" id="btnCrearServicio" name="btnCrearServicio" class="btn btn-success">
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Inicio modal nuevo grupo -->
<div class="modal fade" tabindex="-1" id="modalGrupo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo grupo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-pencil"></span>
                                </div>
                                <input type="text" required id="txtNombreGrupo" name="txtNombreGrupo" maxlength="50" class="form-control text-uppercase" placeholder="Nombre del grupo">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Alias</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-pencil"></span>
                                </div>
                                <input type="text" required id="txtAliasGrupo" name="txtAliasGrupo" maxlength="10" class="form-control text-uppercase" placeholder="Alias del grupo">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Descripci&oacute;n</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-pencil"></span>
                                </div>
                                <textarea name="txtDescripcionGrupo" id="txtDescripcionGrupo" rows="2" class="form-control text-uppercase" placeholder="Descripci&oacute;n del grupo"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Imagen</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-image"></span>
                                </div>
                                <input type="file" name="iflImagenGrupo" id="iflImagenGrupo" class="form-control">  
                            </div>
                            <p class="help-block" id="mensajeImagenGrupo"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnCrearGrupo" name="btnCrearGrupo">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal nuevo grupo -->
<!-- Inicio modal nuevo sub-grupo -->
<div class="modal fade" tabindex="-1" id="modalSubgrupo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nuevo sub-grupo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-pencil"></span>
                                </div>
                                <input type="text" required id="txtNombreSubgrupo" name="txtNombreSubgrupo" maxlength="50" class="form-control text-uppercase" placeholder="Nombre del sub-grupo">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Alias</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-pencil"></span>
                                </div>
                                <input type="text" required id="txtAliasSubgrupo" name="txtAliasSubgrupo" maxlength="10" class="form-control text-uppercase" placeholder="Alias del sub-grupo">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Descripci&oacute;n</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-pencil"></span>
                                </div>
                                <textarea name="txtDescripcionSubgrupo" id="txtDescripcionSubgrupo" rows="2" class="form-control text-uppercase" placeholder="Descripci&oacute;n del sub-grupo"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Imagen</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-image"></span>
                                </div>
                                <input type="file" name="iflImagenSubgrupo" id="iflImagenSubgrupo" class="form-control">   
                            </div>
                            <p class="help-block" id="mensajeImagenSubgrupo"></p>
                        </div>
                    </div>
                    <div class="col-sm-12" hidden>
                        <input type="hidden" name="txtCodigoGrupo" id="txtCodigoGrupo">
                        <div class="form-group">
                            <label class="control-label">Grupo</label>
                            <select class="form-control" required id="selectGrupoSubgrupo" name="selectGrupoSubgrupo">
                                <option disabled selected></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnCrearSubgrupo" name="btnCrearSubgrupo">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal nuevo sub-grupo --> 
<!-- Inicio modal nueva linea -->
<div class="modal fade" tabindex="-1" id="modalLinea">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva l&iacute;nea</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-pencil"></span>
                                </div>
                                <input type="text" required id="txtNombreLinea" name="txtNombreLinea" maxlength="50" class="form-control text-uppercase" placeholder="Nombre de la l&iacute;nea">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Alias</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-pencil"></span>
                                </div>
                                <input type="text" required id="txtAliasLinea" name="txtAliasLinea" maxlength="10" class="form-control text-uppercase" placeholder="Alias de la l&iacute;nea">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Descripci&oacute;n</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-pencil"></span>
                                </div>
                                <textarea name="txtDescripcionLinea" id="txtDescripcionLinea" rows="2" class="form-control text-uppercase" placeholder="Descripci&oacute;n de la l&iacute;nea"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Imagen</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-image"></span>
                                </div>
                                <input type="file" name="iflImagenLinea" id="iflImagenLinea" class="form-control">   
                            </div>
                            <p class="help-block" id="mensajeImagenLinea"></p>
                        </div>
                    </div>
                    <div class="col-sm-6" hidden>
                        <div class="form-group">
                            <label class="control-label">Grupo</label>
                            <select class="form-control" required id="selectGrupoLinea" name="selectGrupoLinea">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6" hidden>
                        <div class="form-group">
                            <label class="control-label">Sub-grupo</label>
                            <select class="form-control" required id="selectSubgrupoLinea" name="selectSubgrupoLinea" disabled>
                                <option></option>
                            </select>
                        </div>
                        <input type="text" name="txtCodigoSubgrupo" id="txtCodigoSubgrupo">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnCrearLinea" name="btnCrearLinea">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal nueva linea -->
<!-- Inicio modal nueva sub-linea -->
<div class="modal fade" tabindex="-1" id="modalSublinea">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva sub-l&iacute;nea</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-pencil"></span>
                                </div>
                                <input type="text" required id="txtNombreSublinea" name="txtNombreSublinea" maxlength="50" class="form-control text-uppercase" placeholder="Nombre de la sub-l&iacute;nea">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Alias</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-pencil"></span>
                                </div>
                                <input type="text" required id="txtAliasSublinea" name="txtAliasSublinea" maxlength="10" class="form-control text-uppercase" placeholder="Alias de la sub-l&iacute;nea">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Descripci&oacute;n</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-pencil"></span>
                                </div>
                                <textarea name="txtDescripcionSublinea" id="txtDescripcionSublinea" rows="2" class="form-control text-uppercase" placeholder="Descripci&oacute;n de la sub-l&iacute;nea"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Imagen</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-image"></span>
                                </div>
                                <input type="file" name="iflImagenSublinea" id="iflImagenSublinea" class="form-control">   
                            </div>
                            <p class="help-block" id="mensajeImagenSublinea"></p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group" hidden>
                            <label class="control-label">Grupo</label>
                            <select class="form-control" required id="selectGrupoSublinea" name="selectGrupoSublinea">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group" hidden>
                            <label class="control-label">Sub-grupo</label>
                            <select class="form-control" required id="selectSubgrupoSublinea" disabled name="selectSubgrupoSublinea">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group" hidden>
                            <label class="control-label">L&iacute;nea</label>
                            <select class="form-control" required id="selectLineaSublinea" disabled name="selectLineaSublinea">
                                <option></option>
                            </select>
                            <input type="text" name="txtCodigoLinea" id="txtCodigoLinea">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnCrearSublinea" name="btnCrearSublinea">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal nueva sub-linea -->
<!-- Inicio modal nueva caracteristica -->
<div class="modal fade" tabindex="-1" id="modalCaracteristica">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Nueva caracte&iacute;stica</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Nombre</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-pencil"></span>
                                </div>
                                <input type="text" required id="txtNombreCaracteristica" name="txtNombreCaracteristica" maxlength="50" class="form-control text-uppercase" placeholder="Nombre de la caracter&iacute;stica">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Alias</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-pencil"></span>
                                </div>
                                <input type="text" required id="txtAliasCaracteristica" name="txtAliasCaracteristica" maxlength="10" class="form-control text-uppercase" placeholder="Alias de la caracter&iacute;stica">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Descripci&oacute;n</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-pencil"></span>
                                </div>
                                <textarea name="txtDescripcionCaracteristica" id="txtDescripcionCaracteristica" rows="2" class="form-control text-uppercase" placeholder="Descripci&oacute;n de la caracter&iacute;stica"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Imagen</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-image"></span>
                                </div>
                                <input type="file" name="iflImagenCaracteristica" id="iflImagenCaracteristica" class="form-control">   
                            </div>
                            <p class="help-block" id="mensajeImagenCaracteristica"></p>
                        </div>
                    </div>
                    <div class="col-sm-6" hidden>
                        <div class="form-group">
                            <label class="control-label">Grupo</label>
                            <select class="form-control" required id="selectGrupoCaracteristica" name="selectGrupoCaracteristica">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6" hidden>
                        <div class="form-group">
                            <label class="control-label">Sub-grupo</label>
                            <select class="form-control" required id="selectSubgrupoCaracteristica" disabled name="selectSubgrupoCaracteristica">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6" hidden>
                        <div class="form-group">
                            <label class="control-label">L&iacute;nea</label>
                            <select class="form-control" required id="selectLineaCaracteristica" disabled name="selectLineaCaracteristica">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6" hidden>
                        <div class="form-group">
                            <label class="control-label">Sub-l&iacute;nea</label>
                            <select class="form-control" required id="selectSublineaCaracteristica" disabled name="selectSublineaCaracteristica">
                                <option></option>
                            </select>
                            <input type="text" name="txtCodigoSublinea" id="txtCodigoSublinea">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnCrearCaracteristica" name="btnCrearCaracteristica">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin modal nueva caracteristica -->
<?php 
    include 'librerias_js.php';
?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript" charset="utf-8">
    $('#side-menu').children('.active').removeClass("active");  
    $("#INVENTARIO").addClass("active");
    $("#SERVICIOS").addClass("active");

    $(document).ready(function(){
        $("#selcargo").select2({placeholder:"Elija cargo(s)"});



        $('[data-toggle="tooltip"]').tooltip();
        
        /*variables*/
            var nombreServicio          = $("#txtNombreServicio");
            var aliasServicio           = $("#txtAliasServicio");
            var codigoAnteriorServicio  = $("#txtCodigoAnteriorServicio");
            var duracionServicio        = $("#txtDuracionServicio");
            var comisionServicio        = $("#txtComisionServicio");
            var imagenServicio          = $("#iflImagenServicio");
            var descripcionServicio     = $("#txtDescripcionServicio");
            var grupoServicio           = $("#selectGrupoServicio");
            var subgrupoServicio        = $("#selectSubgrupoServicio");
            var lineaServicio           = $("#selectLineaServicio");
            var sublineaServicio        = $("#selectSublineaServicio");
            var caracteristicaServicio  = $("#selectCaracteristicaServicio");
            var checkPrecioFijoServicio = $("#checkPrecioFijoServicio");
            var checkCitaServicio       = $("#checkCitaServicio");
            var checkDomicilioServicio  = $("#checkDomicilioServicio")
            var btnNuevoGrupo           = $("#btnSelectGrupo");
            var btnNuevoSubgrupo        = $("#btnSelectSubgrupo");
            var btnNuevaLinea           = $("#btnSelectLinea");
            var btnNuevaSublinea        = $("#btnSelectSublinea");
            var btnNuevaCaracteristica  = $("#btnSelectCaracteristica");
            var btnCrearServicio        = $("#btnCrearServicio")
            var btnCrearGrupo           = $("#btnCrearGrupo");
            var btnCrearSubgrupo        = $("#btnCrearSubgrupo");
            var btnCrearLinea           = $("#btnCrearLinea");
            var btnCrearSublinea        = $("#btnCrearSublinea");
            var btnCrearCaracteristica  = $("#btnCrearCaracteristica");
            var categoria               = $("#ctcservicio");
            var cargo                   = $("#selcargo");
        /*fin variables*/

        //Verificar que el usuario actual tenga permiso para modificar Categorias
        $.ajax({
            url: 'verificarAccesoClasificaciones.php',
            type: 'GET',
            data: {tipoUsuario: $("#txtTipoUsuario").val()},

            success: function(resultado){

                var jsonResultado = JSON.parse(resultado);

                if(jsonResultado.acceso != "Si"){

                    btnNuevoGrupo.attr("disabled", true);
                    btnNuevoSubgrupo.attr("disabled", true);
                    btnNuevaLinea.attr("disabled", true);
                    btnNuevaSublinea.attr("disabled", true);
                    btnNuevaCaracteristica.attr("disabled", true);
                }
            }
        });

        //Llenar select de subgrupos al escoger un grupo
        grupoServicio.on("change", function(){

            $('#btnSelectSubgrupo').attr("disabled", false);
            $('#btnSelectLinea').attr("disabled", true);
            $('#btnSelectSublinea').attr("disabled", true);
            $('#btnSelectCaracteristica').attr("disabled", true);


            subgrupoServicio.attr("disabled", false);
            lineaServicio.attr("disabled", true);
            sublineaServicio.attr("disabled", true);
            caracteristicaServicio.attr("disabled", true);
            subgrupoServicio.val(0);
            lineaServicio.val(0);
            sublineaServicio.val(0);
            caracteristicaServicio.val(0);

            $.ajax({
                url: 'categoriasNuevoServicio.php',
                type: 'GET',
                data: {codigoGrupo: grupoServicio.val()},

                success : function(dataSubgrupos){

                    var resultSubgruposServicio = "";
                    var jsonSubgruposServicio = JSON.parse(dataSubgrupos);

                    if(jsonSubgruposServicio.result == "full"){

                        resultSubgruposServicio += "<option selected disabled>---Seleccione un sub-grupo---</option>";

                        for(datos in jsonSubgruposServicio.dataSubgrupos){

                            resultSubgruposServicio += "<option value='"+jsonSubgruposServicio.dataSubgrupos[datos].codigo+"'>"+jsonSubgruposServicio.dataSubgrupos[datos].nombre+"</option>";
                        }
                    }else{

                        resultSubgruposServicio = "<option disabled selected>No hay sub-grupos registrados</option>";
                    }

                    subgrupoServicio.html(resultSubgruposServicio);
                }
            });
        });
        
        //Llenar select de lineas al escoger un subgrupo
        subgrupoServicio.on("change", function(){

            $('#btnSelectLinea').attr("disabled", false);
            $('#btnSelectSublinea').attr("disabled", true);
            $('#btnSelectCaracteristica').attr("disabled", true);

            lineaServicio.attr('disabled', false);
            sublineaServicio.attr("disabled", true);
            caracteristicaServicio.attr("disabled", true);
            lineaServicio.val(0);
            sublineaServicio.val(0);
            caracteristicaServicio.val(0);

            $.ajax({
                url: 'categoriasNuevoServicio.php',
                type: 'GET',
                data: {codigoSubgrupo: subgrupoServicio.val()},

                success : function(dataLineas){

                    var resultLineasServicio = "";
                    var jsonLineasServicio = JSON.parse(dataLineas);

                    if(jsonLineasServicio.result == "full"){

                        resultLineasServicio += "<option selected disabled>---Seleccione una l&iacute;nea---</option>";

                        for(datos in jsonLineasServicio.dataLineas){

                            resultLineasServicio += "<option value='"+jsonLineasServicio.dataLineas[datos].codigo+"'>"+jsonLineasServicio.dataLineas[datos].nombre+"</option>";
                        }
                    }else{

                        resultLineasServicio = "<option disabled selected>No hay l&iacute;neas registradas</option>";
                    }

                    lineaServicio.html(resultLineasServicio);
                }
            });
        });

        //Llenar select de sublineas al escoger una linea
        lineaServicio.on("change", function(){

            $('#btnSelectSublinea').attr("disabled", false);
            $('#btnSelectCaracteristica').attr("disabled", true);

            sublineaServicio.attr("disabled", false);
            caracteristicaServicio.attr("disabled", true);
            sublineaServicio.val(0);
            caracteristicaServicio.val(0);

            $.ajax({
                url: 'categoriasNuevoServicio.php',
                type: 'GET',
                data: {codigoLinea: lineaServicio.val()},

                success : function(dataSublineas){

                    var resultSublineasServicio = "";
                    var jsonSublineasServicio = JSON.parse(dataSublineas);

                    if(jsonSublineasServicio.result == "full"){

                        resultSublineasServicio += "<option selected disabled>---Seleccione una sub-l&iacute;nea--</option>";

                        for(datos in jsonSublineasServicio.dataSublineas){

                            resultSublineasServicio += "<option value='"+jsonSublineasServicio.dataSublineas[datos].codigo+"'>"+jsonSublineasServicio.dataSublineas[datos].nombre+"</option>";
                        }
                    }else{

                        resultSublineasServicio = "<option disabled selected>No hay sub-l&iacute;neas registradas</option>";
                    }

                    sublineaServicio.html(resultSublineasServicio);
                }
            });
        });

        //Llenar select de caracteristicas al seleccionar sublinea
        sublineaServicio.on("change", function(){

            $('#btnSelectCaracteristica').attr("disabled", false);
 
            caracteristicaServicio.attr("disabled", false);
            caracteristicaServicio.val(0);

            $.ajax({
                url: 'categoriasNuevoServicio.php',
                type: 'GET',
                data: {codigoSublinea: sublineaServicio.val()},

                success : function(dataCaracteristicas){

                    var resultCaracteristicasServicio = "";
                    var jsonCaracteristicasServicio = JSON.parse(dataCaracteristicas);

                    if(jsonCaracteristicasServicio.result == "full"){

                        resultCaracteristicasServicio += "<option selected disabled>---Seleccione una caracter&iacute;stica--</option>";

                        for(datos in jsonCaracteristicasServicio.dataCaracteristicas){

                            resultCaracteristicasServicio += "<option value='"+jsonCaracteristicasServicio.dataCaracteristicas[datos].codigo+"'>"+jsonCaracteristicasServicio.dataCaracteristicas[datos].nombre+"</option>";
                        }
                    }else{

                        resultCaracteristicasServicio = "<option disabled selected>No hay caracter&iacute;sticas registradas</option>";
                    }

                    caracteristicaServicio.html(resultCaracteristicasServicio);
                }
            });
        });

        //Al crear un Grupo
        btnCrearGrupo.on("click", function(){

            var nombreGrupo      = $("#txtNombreGrupo");
            var aliasGrupo       = $("#txtAliasGrupo");
            var descripcionGrupo = $("#txtDescripcionGrupo");
            var imagenGrupo      = $("#iflImagenGrupo");
            var errores          = new Array();

            if((nombreGrupo.val() != "") && (aliasGrupo.val() != "")){

                if(imagenGrupo[0].files[0] == null){

                    $.ajax({
                        url: 'nuevoGrupoServicio.php',
                        type: 'POST',
                        data: {
                            nombre: nombreGrupo.val(),
                            alias: aliasGrupo.val(),
                            descripcion: descripcionGrupo.val(),
                        },

                        success : function(grupoCreado){

                            var jsonGrupoCreado = JSON.parse(grupoCreado);

                            if(jsonGrupoCreado.result == "creado"){

                                swal({
                                    title: "Grupo creado",
                                    type: "success",
                                    confirmButtonText: "Aceptar"
                                },
                                function(){

                                    $("#modalGrupo").modal("hide");
                                    nombreGrupo.val("");
                                    aliasGrupo.val("");
                                    descripcionGrupo.val("");
                                });                            
                            }
                            else{

                                swal("Error", "No se puedo registrar el nuevo grupo", "error");                            
                            }
                        }
                    });
                }
                else{

                    var imagen = imagenGrupo[0].files[0];
                    var stringImagen = imagen["type"].split("/");
                    var tipoImagen = stringImagen[1];
                    var tamanoImagen = imagen["size"];

                    if((tipoImagen != "jpeg") && (tamanoImagen < 512000)){

                        $("#mensajeImagenGrupo").text("Debe subir una imagen con extensi\u00F3n .jpg").css("color", "red");
                    }
                    else if((tipoImagen == "jpeg") && (tamanoImagen > 512000)){

                        $("#mensajeImagenGrupo").text("Debe subir una imagen con tama\u00F1o menor a 500KB").css("color", "red");
                    }
                    else if((tipoImagen != "jpeg") && (tamanoImagen > 512000)){

                        $("#mensajeImagenGrupo").text("Debe subir una imagen con extensi\u00F3n .jpg. Debe subir una imagen con tama\u00F1o menor a 500KB").css("color", "red");
                    }
                    else{

                        var formData = new FormData();
                        formData.append("nombre", nombreGrupo.val());
                        formData.append("alias", aliasGrupo.val());
                        formData.append("descripcion", descripcionGrupo.val());
                        formData.append("imagen", imagen);

                        $.ajax({
                            url: 'nuevoGrupoServicio.php',
                            type: 'POST',
                            /*data: {
                                nombre: nombreGrupo.val(),
                                alias: aliasGrupo.val(),
                                descripcion: descripcionGrupo.val(),
                            },*/
                            data: formData,
                            processData: false, 
                            contentType: false,

                            success : function(grupoCreado){

                                var jsonGrupoCreado = JSON.parse(grupoCreado);

                                if(jsonGrupoCreado.result == "creado"){

                                    swal({
                                        title: "Grupo creado",
                                        type: "success",
                                        confirmButtonText: "Aceptar"
                                    },
                                    function(){

                                        $("#modalGrupo").modal("hide");
                                        nombreGrupo.val("");
                                        aliasGrupo.val("");
                                        descripcionGrupo.val("");
                                    });                            
                                }
                                else{

                                    swal("Error", "No se puedo registrar el nuevo grupo", "error");                            
                                }
                            }
                        });
                    }
                }
            }
            else{
                
                if(nombreGrupo.val() == ""){

                    errores.push("Complete el campo Nombre");
                }
                if(aliasGrupo.val() == ""){

                    errores.push("Complete el campo Alias");
                }

                var i            = 0;
                var mensajeError = "";

                for(i = 0; i < errores.length; i++){

                    mensajeError += errores[i] + "\n";
                }

                swal("Error", mensajeError, "error");
            }
        });

        //Al abrir modal Nuevo subgrupo
        btnNuevoSubgrupo.on("click", function(){

            var grupoSubgrupo = $("#selectGrupoSubgrupo");

            obtenerGruposModals(grupoSubgrupo);
            $("#txtCodigoGrupo").val($('#selectGrupoServicio').val());
            /*$.ajax({
                url: 'obtenerGruposModalsServicio.php',
                type: 'GET',
                data: {opcion: '1'},

                success : function(grupos){

                    var gruposObtenidos = "";
                    var jsonGrupos      = JSON.parse(grupos);

                    if(jsonGrupos.result == "full"){

                        gruposObtenidos = "<option disabled selected>--Seleccione un grupo---</option>";

                        for(datos in jsonGrupos.grupos){

                            gruposObtenidos += "<option value='"+jsonGrupos.grupos[datos].codigo+"'>"+jsonGrupos.grupos[datos].nombre+"</option>";
                        }   
                    }
                    else{

                        gruposObtenidos = "<option disabled selected>--No hay grupos registrados</option>";
                    }

                    grupoSubgrupo.html(gruposObtenidos);
                }
            });*/
        });

        //Al crear un sub-grupo
        btnCrearSubgrupo.on("click", function(){

            var nombreSubgrupo      = $("#txtNombreSubgrupo");
            var aliasSubgrupo       = $("#txtAliasSubgrupo");
            var descripcionSubgrupo = $("#txtDescripcionSubgrupo");
            var imagenSubgrupo      = $("#iflImagenSubgrupo");
            var grupoSubgrupo       = $("#selectGrupoSubgrupo");
            var errores             = new Array();

             if((nombreSubgrupo.val() != "") && (aliasSubgrupo.val() != "") && ($('#txtCodigoGrupo').val() != null)) {

                if(imagenSubgrupo[0].files[0] == null){

                    $.ajax({
                        url: 'nuevoSubgrupoServicio.php',
                        type: 'POST',
                        data: {
                            nombre: nombreSubgrupo.val(),
                            alias: aliasSubgrupo.val(),
                            descripcion: descripcionSubgrupo.val(),
                            // imagen: imagenSubgrupo.val(),
                            grupo: $('#txtCodigoGrupo').val()
                        },

                        success : function(subgrupoCreado){

                            var jsonSubgrupoCreado = JSON.parse(subgrupoCreado);

                            if(jsonSubgrupoCreado.result == "creado"){

                                swal({
                                    title: "Sub-grupo creado",
                                    type: "success",
                                    confirmButtonText: "Aceptar"
                                },
                                function(){

                                    $("#modalSubgrupo").modal("hide");
                                    nombreSubgrupo.val("");
                                    aliasSubgrupo.val("");
                                    descripcionSubgrupo.val("");
                                    grupoSubgrupo.val("");
                                });                            
                            }
                            else{

                                swal("Error", "No se puedo registrar el nuevo sub-grupo", "error");                            
                            }
                        }
                    });    
                }
                else{

                    var imagen = imagenSubgrupo[0].files[0];
                    var stringImagen = imagen["type"].split("/");
                    var tipoImagen = stringImagen[1];
                    var tamanoImagen = imagen["size"];

                    if((tipoImagen != "jpeg") && (tamanoImagen < 512000)){

                        $("#mensajeImagenSubgrupo").text("Debe subir una imagen con extensi\u00F3n .jpg").css("color", "red");
                    }
                    else if((tipoImagen == "jpeg") && (tamanoImagen > 512000)){

                        $("#mensajeImagenSubgrupo").text("Debe subir una imagen con tama\u00F1o menor a 500KB").css("color", "red");
                    }
                    else if((tipoImagen != "jpeg") && (tamanoImagen > 512000)){

                        $("#mensajeImagenSubgrupo").text("Debe subir una imagen con extensi\u00F3n .jpg. Debe subir una imagen con tama\u00F1o menor a 500KB").css("color", "red");
                    }
                    else{

                        var formData = new FormData();
                        formData.append('nombre', nombreSubgrupo.val());
                        formData.append("alias", aliasSubgrupo.val());
                        formData.append("descripcion", descripcionSubgrupo.val());
                        formData.append("grupo", $('#txtCodigoGrupo').val());
                        formData.append("imagen", imagen);

                        $.ajax({
                            url: 'nuevoSubgrupoServicio.php',
                            type: 'POST',
                            /*data: {
                                nombre: nombreSubgrupo.val(),
                                alias: aliasSubgrupo.val(),
                                descripcion: descripcionSubgrupo.val(),
                                imagen: imagenSubgrupo.val(),
                                grupo: grupoSubgrupo.val()
                            },*/
                            data: formData,
                            processData: false,
                            contentType: false,

                            success : function(subgrupoCreado){

                                var jsonSubgrupoCreado = JSON.parse(subgrupoCreado);

                                if(jsonSubgrupoCreado.result == "creado"){

                                    swal({
                                        title: "Sub-grupo creado",
                                        type: "success",
                                        confirmButtonText: "Aceptar"
                                    },
                                    function(){

                                        $("#modalSubgrupo").modal("hide");
                                        nombreSubgrupo.val("");
                                        aliasSubgrupo.val("");
                                        descripcionSubgrupo.val("");
                                        grupoSubgrupo.val("");
                                    });                            
                                }
                                else{

                                    swal("Error", "No se puedo registrar el nuevo sub-grupo", "error");                            
                                }
                            }
                        });
                    }

                }
            }
            else{
                
                if(nombreSubgrupo.val() == ""){

                    errores.push("Complete el campo Nombre");
                }
                if(aliasSubgrupo.val() == ""){

                    errores.push("Complete el campo Alias");
                }
                if(grupoSubgrupo.val() == null){

                    errores.push("Seleccion un grupo");
                }

                var i            = 0;
                var mensajeError = "";

                for(i = 0; i < errores.length; i++){

                    mensajeError += errores[i] + "\n";
                }

                swal("Error", mensajeError, "error");
            }
        });

        //Al abrir modal Nueva linea
        btnNuevaLinea.on("click", function(){

            var grupoLinea = $("#selectGrupoLinea");
             $('#txtCodigoSubgrupo').val($('#selectSubgrupoServicio').val());
            //var subgrupoLiena = $("#selectSubgrupoLinea");
            //
            obtenerGruposModals(grupoLinea);
            /*$.ajax({
                url: 'obtenerGruposModalsServicio.php',
                type: 'GET',

                success : function(grupos){

                    var gruposObtenidos = "";
                    var jsonGrupos      = JSON.parse(grupos);

                    if(jsonGrupos.result == "full"){

                        gruposObtenidos = "<option disabled selected>--Seleccione un grupo---</option>";

                        for(datos in jsonGrupos.grupos){

                            gruposObtenidos += "<option value='"+jsonGrupos.grupos[datos].codigo+"'>"+jsonGrupos.grupos[datos].nombre+"</option>";
                        }   
                    }
                    else{

                        gruposObtenidos = "<option disabled selected>--No hay grupos registrados</option>";
                    }

                    grupoLinea.html(gruposObtenidos);
                }
            });*/
        });

        //Al seleccionar grupo de Nueva linea
        $("#selectGrupoLinea").on("change", function(){

            $("#selectSubgrupoLinea").attr("disabled", false);
            obtenerSubgruposModals($("#selectGrupoLinea").val(), $("#selectSubgrupoLinea"));
            /*$.ajax({
                url: 'obtenerSubgruposModalsServicio.php',
                type: 'GET',
                data: {grupo: $("#selectGrupoLinea").val()},

                success : function(subgrupos){

                    var subgruposObtenidos = "";
                    var jsonSubgrupos      = JSON.parse(subgrupos);

                    if(jsonSubgrupos.result == "full"){

                        subgruposObtenidos = "<option disabled selected>--Seleccione un sub-grupo---</option>";

                        for(datos in jsonSubgrupos.subgrupos){

                            subgruposObtenidos += "<option value='"+jsonSubgrupos.subgrupos[datos].codigo+"'>"+jsonSubgrupos.subgrupos[datos].nombre+"</option>";
                        }
                    }
                    else{

                        subgruposObtenidos = "<option disabled selected>---No hay subgrupos registrados---</div>";
                    }

                    $("#selectSubgrupoLinea").html(subgruposObtenidos);
                }
            });*/

        });

        //Al crear una linea
        btnCrearLinea.on("click", function(){

            var nombreLinea      = $("#txtNombreLinea");
            var aliasLinea       = $("#txtAliasLinea");
            var descripcionLinea = $("#txtDescripcionLinea");
            var imagenLinea      = $("#iflImagenLinea");
            var grupoLinea       = $("#selectGrupoLinea");
            var subgrupoLinea    = $("#selectSubgrupoLinea");
            var errores          = new Array();

            if((nombreLinea.val() != "") && (aliasLinea.val() != "")  && (($('#txtCodigoSubgrupo')).val() != "")){

                if(imagenLinea[0].files[0] == null){

                    $.ajax({
                        url: 'nuevaLineaServicio.php',
                        type: 'POST',
                        data: {
                            nombre: nombreLinea.val(),
                            alias: aliasLinea.val(),
                            descripcion: descripcionLinea.val(),
                            /*grupo: grupoLinea.val(),*/
                            subgrupo: $('#txtCodigoSubgrupo').val(),
                        },

                        success : function(lineaCreada){

                            var jsonLineaCreada = JSON.parse(lineaCreada);

                            if(jsonLineaCreada.result == "creado"){

                                swal({
                                    title: "Linea creada",
                                    type: "success",
                                    confirmButtonText: "Aceptar"
                                },
                                function(){

                                    $("#modalLinea").modal("hide");
                                    nombreLinea.val("");
                                    aliasLinea.val("");
                                    descripcionLinea.val("");
                                    grupoLinea.val("");
                                    subgrupoLinea.val("");
                                    subgrupoLinea.attr("disabled", true);
                                });                            
                            }
                            else{

                                swal("Error", "No se puedo registrar la nueva linea", "error");                            
                            }
                        }
                    });    
                }
                else{

                    var imagen = imagenLinea[0].files[0];
                    var stringImagen = imagen["type"].split("/");
                    var tipoImagen = stringImagen[1];
                    var tamanoImagen = imagen["size"];

                    if((tipoImagen != "jpeg") && (tamanoImagen < 512000)){

                        $("#mensajeImagenLinea").text("Debe subir una imagen con extensi\u00F3n .jpg").css("color", "red");
                    }
                    else if((tipoImagen == "jpeg") && (tamanoImagen > 512000)){

                        $("#mensajeImagenLinea").text("Debe subir una imagen con tama\u00F1o menor a 500KB").css("color", "red");
                    }
                    else if((tipoImagen != "jpeg") && (tamanoImagen > 512000)){

                        $("#mensajeImagenLinea").text("Debe subir una imagen con extensi\u00F3n .jpg. Debe subir una imagen con tama\u00F1o menor a 500KB").css("color", "red");
                    }
                    else{

                        var formData = new FormData();
                        formData.append("nombre", nombreLinea.val());
                        formData.append("alias", aliasLinea.val());
                        formData.append("descripcion", descripcionLinea.val());
                        formData.append("subgrupo", $('#txtCodigoSubgrupo').val());
                        formData.append("imagen", imagen);


                        $.ajax({
                            url: 'nuevaLineaServicio.php',
                            type: 'POST',
                            data: formData,
                            /*data: {
                                nombre: nombreLinea.val(),
                                alias: aliasLinea.val(),
                                descripcion: descripcionLinea.val(),
                                imagen: imagenLinea.val(),
                                subgrupo: subgrupoLinea.val()
                            },*/
                            processData: false, 
                            contentType: false,

                            success : function(lineaCreada){

                                var jsonLineaCreada = JSON.parse(lineaCreada);

                                if(jsonLineaCreada.result == "creado"){

                                    swal({
                                        title: "Linea creada",
                                        type: "success",
                                        confirmButtonText: "Aceptar"
                                    },
                                    function(){

                                        $("#modalLinea").modal("hide");
                                        nombreLinea.val("");
                                        aliasLinea.val("");
                                        descripcionLinea.val("");
                                        grupoLinea.val("");
                                        subgrupoLinea.val("");
                                        subgrupoLinea.attr("disabled", true);
                                    });                            
                                }
                                else{

                                    swal("Error", "No se puedo registrar la nueva linea", "error");                            
                                }
                            }
                        });
                    }
                }
            }
            else{
                
                if(nombreLinea.val() == ""){

                    errores.push("Complete el campo Nombre");
                }
                if(aliasLinea.val() == ""){

                    errores.push("Complete el campo Alias");
                }
                if(grupoLinea.val() == null){

                    errores.push("Seleccione un grupo");
                }
                if(subgrupoLinea.val() == null){

                    errores.push("Seleccione un sub-grupo");
                }

                var i            = 0;
                var mensajeError = "";

                for(i = 0; i < errores.length; i++){

                    mensajeError += errores[i] + "\n";
                }

                swal("Error", mensajeError, "error");
            }

        });

        //Al abrir modal de Nueva sublinea
        btnNuevaSublinea.on("click", function(){

            $('#txtCodigoLinea').val($('#selectLineaServicio').val());

            var grupoSublinea = $("#selectGrupoSublinea");
            obtenerGruposModals(grupoSublinea);
        });

        //Al selecccionar grupo de nueva sublinea
        $("#selectGrupoSublinea").on("change", function(){

            $("#selectSubgrupoSublinea").attr("disabled", false);
            $("#selectLineaSublinea").attr("disabled", true);
            $("#selectSubgrupoSublinea").val();
            $("#selectLineaSublinea").val();
            obtenerSubgruposModals($("#selectGrupoSublinea").val(), $("#selectSubgrupoSublinea"));
        });

        //Al seleccionar subgrupo de nueva sublinea
        $("#selectSubgrupoSublinea").on("change", function(){

            $("#selectLineaSublinea").attr("disabled", false);
            $("#selectLineaSublinea").val();
            obtenerLineasModals($("#selectSubgrupoSublinea").val(), $("#selectLineaSublinea"));
        });

        //AL crear nueva sublinea
        btnCrearSublinea.on("click", function(){

            var nombreSublinea      = $("#txtNombreSublinea");
            var aliasSublinea       = $("#txtAliasSublinea");
            var descripcionSublinea = $("#txtDescripcionSublinea");
            var imagenSublinea      = $("#iflImagenSublinea");
            var grupoSublinea       = $("#selectGrupoSublinea");
            var subgrupoSublinea    = $("#selectSubgrupoSublinea");
            var lineaSublinea       = $("#selectLineaSublinea");
            var errores             = new Array();

            if((nombreSublinea.val() != "") && (aliasSublinea.val() != "") && ( $('#txtCodigoLinea').val() != "") ) {

                if(imagenSublinea[0].files[0] == null){

                    $.ajax({
                        url: 'nuevaSublineaServicio.php',
                        type: 'POST',
                        data: {
                            nombre: nombreSublinea.val(),
                            alias: aliasSublinea.val(),
                            descripcion: descripcionSublinea.val(),
                            linea: $('#txtCodigoLinea').val()
                        },

                        success : function(sublineaCreada){

                            var jsonSublineaCreada = JSON.parse(sublineaCreada);

                            if(jsonSublineaCreada.result == "creado"){

                                swal({
                                    title: "Sub-linea creada",
                                    type: "success",
                                    confirmButtonText: "Aceptar"
                                },
                                function(){

                                    $("#modalSublinea").modal("hide");
                                    nombreSublinea.val("");
                                    aliasSublinea.val("");
                                    descripcionSublinea.val("");
                                    grupoSublinea.val("");
                                    subgrupoSublinea.val("");
                                    lineaSublinea.val("");
                                    subgrupoSublinea.attr("disabled", true);
                                    lineaSublinea.attr("disabled", true);
                                });                            
                            }
                            else{

                                swal("Error", "No se puedo registrar la nueva sub-linea", "error");                            
                            }
                        }
                    });    
                }
                else{

                    var imagen       = imagenSublinea[0].files[0];
                    var stringImagen = imagen["type"].split("/");
                    var tipoImagen   = stringImagen[1];
                    var tamanoImagen = imagen["size"];

                    if((tipoImagen != "jpeg") && (tamanoImagen < 512000)){

                        $("#mensajeImagenSublinea").text("Debe subir una imagen con extensi\u00F3n .jpg").css("color", "red");
                    }
                    else if((tipoImagen == "jpeg") && (tamanoImagen > 512000)){

                        $("#mensajeImagenSublinea").text("Debe subir una imagen con tama\u00F1o menor a 500KB").css("color", "red");
                    }
                    else if((tipoImagen != "jpeg") && (tamanoImagen > 512000)){

                        $("#mensajeImagenSublinea").text("Debe subir una imagen con extensi\u00F3n .jpg. Debe subir una imagen con tama\u00F1o menor a 500KB").css("color", "red");
                    }
                    else{

                        var formData = new FormData();
                        formData.append("nombre", nombreSublinea.val());
                        formData.append("alias", aliasSublinea.val());
                        formData.append("descripcion", descripcionSublinea.val());
                        formData.append("linea", $('#txtCodigoLinea').val());
                        formData.append("imagen", imagen);

                        $.ajax({
                            url: 'nuevaSublineaServicio.php',
                            type: 'POST',
                            /*data: {
                                nombre: nombreSublinea.val(),
                                alias: aliasSublinea.val(),
                                descripcion: descripcionSublinea.val(),
                                imagen: imagenSublinea.val(),
                                /*grupo: grupoSublinea.val(),
                                linea: lineaSublinea.val()
                            },*/
                            data: formData,
                            processData: false, 
                            contentType: false,

                            success : function(sublineaCreada){

                                var jsonSublineaCreada = JSON.parse(sublineaCreada);

                                if(jsonSublineaCreada.result == "creado"){

                                    swal({
                                        title: "Sub-linea creada",
                                        type: "success",
                                        confirmButtonText: "Aceptar"
                                    },
                                    function(){

                                        $("#modalSublinea").modal("hide");
                                        nombreSublinea.val("");
                                        aliasSublinea.val("");
                                        descripcionSublinea.val("");
                                        grupoSublinea.val("");
                                        subgrupoSublinea.val("");
                                        lineaSublinea.val("");
                                        subgrupoSublinea.attr("disabled", true);
                                        lineaSublinea.attr("disabled", true);
                                    });                            
                                }
                                else{

                                    swal("Error", "No se puedo registrar la nueva sub-linea", "error");                            
                                }
                            }
                        });
                    }
                }
            }
            else{
                
                if(nombreSublinea.val() == ""){

                    errores.push("Complete el campo Nombre");
                }
                if(aliasSublinea.val() == ""){

                    errores.push("Complete el campo Alias");
                }
                if(grupoSublinea.val() == null){

                    errores.push("Seleccione un grupo");
                }
                if(subgrupoSublinea.val() == null){

                    errores.push("Seleccione un sub-grupo");
                }
                if(lineaSublinea.val() == null){

                    errores.push("Seleccione una linea");
                }

                var i            = 0;
                var mensajeError = "";

                for(i = 0; i < errores.length; i++){

                    mensajeError += errores[i] + "\n";
                }

                swal("Error", mensajeError, "error");
            }
        });

        //Al abrir modal nueva caracteristica
        btnNuevaCaracteristica.on("click", function(){

            $('#txtCodigoSublinea').val($("#selectSublineaServicio").val());

            var grupoCaracteristica = $("#selectGrupoCaracteristica");
            obtenerGruposModals(grupoCaracteristica);
        });

        //Al seleccionar grupo de nueva caracteristica
        $("#selectGrupoCaracteristica").on("change", function(){

            $("#selectSubgrupoCaracteristica").attr("disabled", false);
            $("#selectLineaCaracteristica").attr("disabled", true);
            $("#selectSublineaCaracteristica").attr("disabled", true);
            $("#selectSubgrupoCaracteristica").val("");
            $("#selectLineaCaracteristica").val("");
            $("#selectSublineaCaracteristica").val("");
            obtenerSubgruposModals($("#selectGrupoCaracteristica").val(), $("#selectSubgrupoCaracteristica"));
        });

        //Al seleccionar subgrupo de nueva caracteristica
        $("#selectSubgrupoCaracteristica").on("change", function(){

            $("#selectLineaCaracteristica").attr("disabled", false);
            $("#selectSublineaCaracteristica").attr("disabled", true);
            $("#selectLineaCaracteristica").val();
            $("#selectSublineaCaracteristica").val();
            obtenerLineasModals($("#selectSubgrupoCaracteristica").val(), $("#selectLineaCaracteristica"));
        });

        //AL seleccionar linea de nueva caracteristica
        $("#selectLineaCaracteristica").on("change", function(){

            $("#selectSublineaCaracteristica").attr("disabled", false);
            $("#selectSublineaCaracteristica").val("");
            obtenerSublineasModals($("#selectLineaCaracteristica").val(), $("#selectSublineaCaracteristica"));
        });

        //Al crear nueva caracteristica        
        btnCrearCaracteristica.on("click", function(){

            var nombreCaracteristica      = $("#txtNombreCaracteristica");
            var aliasCaracteristica       = $("#txtAliasCaracteristica");
            var descripcionCaracteristica = $("#txtDescripcionCaracteristica");
            var imagenCaracteristica      = $("#iflImagenCaracteristica");
            var grupoCaracteristica       = $("#selectGrupoCaracteristica");
            var subgrupoCaracteristica    = $("#selectSubgrupoCaracteristica");
            var lineaCaracteristica       = $("#selectLineaCaracteristica");
            var sublineaCaracteristica    = $("#selectSublineaCaracteristica");
            var errores                   = new Array();

            if((nombreCaracteristica.val() != "") && (aliasCaracteristica.val() != "")  && ($('#txtCodigoSublinea').val() != "")){

                if(imagenCaracteristica[0].files[0] == null){
                    
                    $.ajax({
                        url: 'nuevaCaracteristicaServicio.php',
                        type: 'POST',
                        data: {
                            nombre: nombreCaracteristica.val(),
                            alias: aliasCaracteristica.val(),
                            descripcion: descripcionCaracteristica.val(),                            
                            sublinea: $('#txtCodigoSublinea').val()
                        },

                        success : function(caracteristicaCreada){

                            var jsonCaracteristicaCreada = JSON.parse(caracteristicaCreada);

                            if(jsonCaracteristicaCreada.result == "creado"){

                                swal({
                                    title: "Caracteristica creada",
                                    type: "success",
                                    confirmButtonText: "Aceptar"
                                },
                                function(){

                                    $("#modalCaracteristica").modal("hide");
                                    nombreCaracteristica.val("");
                                    aliasCaracteristica.val("");
                                    descripcionCaracteristica.val("");
                                    grupoCaracteristica.val("");
                                    subgrupoCaracteristica.val("");
                                    lineaCaracteristica.val("");
                                    sublineaCaracteristica.val("");
                                    subgrupoCaracteristica.attr("disabled", true);
                                    lineaCaracteristica.attr("disabled", true);
                                    sublineaCaracteristica.attr("disabled", true);
                                });                            
                            }
                            else{

                                swal("Error", "No se puedo registrar la nueva caracteristica", "error");                            
                            }
                        }
                    });
                }
                else{

                    var imagen = imagenCaracteristica[0].files[0];
                    var stringImagen = imagen["type"].split("/");
                    var tipoImagen = stringImagen[1];
                    var tamanoImagen = imagen["size"];

                    if((tipoImagen != "jpeg") && (tamanoImagen < 512000)){

                        $("#mensajeImagenCaracteristica").text("Debe subir una imagen con extensi\u00F3n .jpg").css("color", "red");
                    }
                    else if((tipoImagen == "jpeg") && (tamanoImagen > 512000)){

                        $("#mensajeImagenCaracteristica").text("Debe subir una imagen con tama\u00F1o menor a 500KB").css("color", "red");
                    }
                    else if((tipoImagen != "jpeg") && (tamanoImagen > 512000)){

                        $("#mensajeImagenCaracteristica").text("Debe subir una imagen con extensi\u00F3n .jpg. Debe subir una imagen con tama\u00F1o menor a 500KB").css("color", "red");
                    }
                    else{

                        var formData = new FormData();
                        formData.append("nombre", nombreCaracteristica.val());
                        formData.append("alias", aliasCaracteristica.val());
                        formData.append("descripcion", descripcionCaracteristica.val());
                        formData.append("sublinea", $('#txtCodigoSublinea').val());
                        formData.append("imagen", imagen);
                        
                        $.ajax({
                            url: 'nuevaCaracteristicaServicio.php',
                            type: 'POST',
                            /*data: {
                                nombre: nombreCaracteristica.val(),
                                alias: aliasCaracteristica.val(),
                                descripcion: descripcionCaracteristica.val(),
                                imagen: imagenCaracteristica.val(),
                                sublinea: sublineaCaracteristica.val()
                            },*/
                            data: formData,
                            processData: false, 
                            contentType: false,

                            success : function(caracteristicaCreada){

                                var jsonCaracteristicaCreada = JSON.parse(caracteristicaCreada);

                                if(jsonCaracteristicaCreada.result == "creado"){

                                    swal({
                                        title: "Caracteristica creada",
                                        type: "success",
                                        confirmButtonText: "Aceptar"
                                    },
                                    function(){

                                        $("#modalCaracteristica").modal("hide");
                                        nombreCaracteristica.val("");
                                        aliasCaracteristica.val("");
                                        descripcionCaracteristica.val("");
                                        grupoCaracteristica.val("");
                                        subgrupoCaracteristica.val("");
                                        lineaCaracteristica.val("");
                                        sublineaCaracteristica.val("");
                                        subgrupoCaracteristica.attr("disabled", true);
                                        lineaCaracteristica.attr("disabled", true);
                                        sublineaCaracteristica.attr("disabled", true);
                                    });                            
                                }
                                else{

                                    swal("Error", "No se puedo registrar la nueva caracteristica", "error");                            
                                }
                            }
                        });
                    }
                }

            }
            else{
                
                if(nombreCaracteristica.val() == ""){

                    errores.push("Complete el campo Nombre");
                }
                if(aliasCaracteristica.val() == ""){

                    errores.push("Complete el campo Alias");
                }
                if(grupoCaracteristica.val() == null){

                    errores.push("Seleccione un grupo");
                }
                if(subgrupoCaracteristica.val() == null){

                    errores.push("Seleccione un sub-grupo");
                }
                if(lineaCaracteristica.val() == null){

                    errores.push("Seleccione una linea");
                }
                if(sublineaCaracteristica.val() == null){

                    errores.push("Seleccione una sub-linea");
                }

                var i            = 0;
                var mensajeError = "";

                for(i = 0; i < errores.length; i++){

                    mensajeError += errores[i] + "\n";
                }

                swal("Error", mensajeError, "error");
            }
        });

        //Funcion para obtener los grupos en los modals
        function obtenerGruposModals(selectGrupo){

            $.ajax({
                url: 'obtenerGruposModalsServicio.php',
                type: 'GET',

                success : function(grupos){

                    var gruposObtenidos = "";
                    var jsonGrupos      = JSON.parse(grupos);

                    if(jsonGrupos.result == "full"){

                        gruposObtenidos = "<option disabled selected>--Seleccione un grupo---</option>";

                        for(datos in jsonGrupos.grupos){

                            gruposObtenidos += "<option value='"+jsonGrupos.grupos[datos].codigo+"'>"+jsonGrupos.grupos[datos].nombre+"</option>";
                        }   
                    }
                    else{

                        gruposObtenidos = "<option disabled selected>--No hay grupos registrados</option>";
                    }

                    selectGrupo.html(gruposObtenidos);
                }
            });
        }

        //Funcion para obtener los subgrupos en los modals
        function obtenerSubgruposModals(codGrupo, selectSubgrupo){

            $.ajax({
                url: 'obtenerSubgruposModalsServicio.php',
                type: 'GET',
                data: {grupo: codGrupo},

                success : function(subgrupos){

                    var subgruposObtenidos = "";
                    var jsonSubgrupos      = JSON.parse(subgrupos);

                    if(jsonSubgrupos.result == "full"){

                        subgruposObtenidos = "<option disabled selected>--Seleccione un sub-grupo---</option>";

                        for(datos in jsonSubgrupos.subgrupos){

                            subgruposObtenidos += "<option value='"+jsonSubgrupos.subgrupos[datos].codigo+"'>"+jsonSubgrupos.subgrupos[datos].nombre+"</option>";
                        }
                    }
                    else{

                        subgruposObtenidos = "<option disabled selected>---No hay subgrupos registrados---</div>";
                    }

                    selectSubgrupo.html(subgruposObtenidos);
                }
            });
        }

        //Funcion para obtener las lineas en los modals
        function obtenerLineasModals(codSubgrupo, selectLinea){

            $.ajax({
                url: 'obtenerLineasModalsServicio.php',
                type: 'GET',
                data: {subgrupo: codSubgrupo},

                success : function(lineas){

                    var lineasObtenidas = "";
                    var jsonLineas = JSON.parse(lineas);

                    if(jsonLineas.result == "full"){

                        lineasObtenidas = "<option disabled selected>---Seleccione una linea---</option>";

                        for(datos in jsonLineas.lineas){

                            lineasObtenidas += "<option value='"+jsonLineas.lineas[datos].codigo+"'>"+jsonLineas.lineas[datos].nombre+"</option>";
                        }
                    }
                    else{

                        lineasObtenidas = "<option disabled selected>---No hay lineas registradas---</div>";
                    }

                    selectLinea.html(lineasObtenidas);
                }
            });
        }

        //Funcion para obtener las sublineas en los modals
        function obtenerSublineasModals(codLinea, selectSublinea){

            $.ajax({
                url: 'obtenerSublineasModalsServicio.php',
                type: 'GET',
                data: {linea: codLinea},

                success : function(sublineas){

                    var sublineasObtenidas = "";
                    var jsonSublineas = JSON.parse(sublineas);

                    if(jsonSublineas.result == "full"){

                        sublineasObtenidas = "<option disabled selected>---Seleccione una linea---</option>";

                        for(datos in jsonSublineas.sublineas){

                            sublineasObtenidas += "<option value='"+jsonSublineas.sublineas[datos].codigo+"'>"+jsonSublineas.sublineas[datos].nombre+"</option>";
                        }
                    }
                    else{

                        sublineasObtenidas = "<option disabled selected>---No hay lineas registradas---</div>";
                    }

                    selectSublinea.html(sublineasObtenidas);
                }
            });   
        }

        //Comprobación del código anterior
        codigoAnteriorServicio.on("keyup", function(){

            $.ajax({
                url: 'comprobarCodigoAnteriorServicio.php',
                data: {codigoAnterior: $(this).val()},
            })
            .done(function(resultado){

                var jsonResultado = JSON.parse(resultado);

                switch (jsonResultado.result){
                    
                    case "vacio":
                        $("#txtCodigoAnteriorServicio2").val(1);
                        $("#mensajeErrorCodigoAnterior").text("");
                        break;
                    
                    case "full":
                        $("#txtCodigoAnteriorServicio2").val(0);
                        $("#mensajeErrorCodigoAnterior").text("El c\u00F3digo digitado ya se encuentra registrado. Intente con otro.");
                        break;
                    
                    default:
                        $("#txtCodigoAnteriorServicio2").val(1);
                        $("#mensajeErrorCodigoAnterior").text("");
                        break;
                }
            });
        });

        btnCrearServicio.on("click", function(){

            var errores = new Array();
            var precioFijo = 1; // Referente a checkbox precioFijoServicio
            var cita = 1; // Referente a checkbox citaServicio
            var domicilio = 1; // Referente a checkbox domicilioServicio
            var insumo=0;


            if((nombreServicio.val() != "") && (aliasServicio.val() != "") && ((comisionServicio.val() >= 0) && (comisionServicio.val() <= 100)) && (duracionServicio.val() != 0) && (grupoServicio.val() != null) && (subgrupoServicio.val() != null) && (lineaServicio.val() != null) && (sublineaServicio.val() != null) && (caracteristicaServicio.val() != null) && ($("#txtCodigoAnteriorServicio2").val() != "0" )){

                //Verificar si la opción Precio fijo se desactivó
                if(!checkPrecioFijoServicio.is(":checked")){

                    precioFijo = 0;
                }

                //Verificar si la opción Cita se desactivó
                if(!checkCitaServicio.is(":checked")){

                    cita = 0;
                }

                //Verificar si la opción Domicilio se desactivó
                if(!checkDomicilioServicio.is(":checked")){

                    domicilio = 0;
                }

                if($(".swins").is(":checked")){

                    insumo = 1;
                    console.log('ok');
                }

                if(imagenServicio[0].files[0] == null){

                    $.ajax({
                        url: 'insert_servicio.php',
                        type: 'POST',
                        data: { 
                            nombre: nombreServicio.val(),
                            codigoAnterior: codigoAnteriorServicio.val(),
                            alias: aliasServicio.val(),
                            duracion: duracionServicio.val(),
                            comision: comisionServicio.val(),
                            descripcion: descripcionServicio.val(),
                            caracteristica: caracteristicaServicio.val(),
                            precioFijo: precioFijo,
                            cita: cita,
                            domicilio: domicilio,
                            insumo: insumo,
                            categoria: categoria.val(),
                            cargo:cargo.val()
                        },
                        success : function(servicioCreado){

                            var jsonServicioCreado = JSON.parse(servicioCreado);

                            if(jsonServicioCreado.result == "creado"){

                                swal({
                                    title: "Servicio creado",
                                    type: "success",
                                },
                                function(){
                                    window.location.href='servicios.php';
                                });
                            }
                            else{

                                swal("", "Problemas al crear el servicio", "error");
                            }
                        }
                    });
                }
                else{

                    var imagen = imagenServicio[0].files[0];
                    var stringImagen = imagen["type"].split("/");
                    var tipoImagen = stringImagen[1];
                    var tamanoImagen = imagen["size"];

                    if((tipoImagen != "jpeg") && (tamanoImagen < 512000)){

                        $("#mensajeImagen").text("Debe subir una imagen con extensi\u00F3n .jpg").css("color", "red");
                    }
                    else if((tipoImagen == "jpeg") && (tamanoImagen > 512000)){

                        $("#mensajeImagen").text("Debe subir una imagen con tama\u00F1o menor a 500KB").css("color", "red");
                    }
                    else if((tipoImagen != "jpeg") && (tamanoImagen > 512000)){

                        $("#mensajeImagen").text("Debe subir una imagen con extensi\u00F3n .jpg. Debe subir una imagen con tama\u00F1o menor a 500KB").css("color", "red");
                    }
                    else{

                        var formData = new FormData();
                        formData.append("nombre", nombreServicio.val());
                        formData.append("codigoAnterior", codigoAnteriorServicio.val());
                        formData.append("alias", aliasServicio.val());
                        formData.append("duracion", duracionServicio.val());
                        formData.append('comision', comisionServicio.val());
                        formData.append("descripcion", descripcionServicio.val());
                        formData.append('caracteristica', caracteristicaServicio.val());
                        formData.append("imagen", imagen);
                        formData.append("precioFijo", precioFijo);
                        formData.append("cita", cita);
                        formData.append("domicilio", domicilio);
                        formData.append("categoria", categoria.val());
                        formData.append("cargo", cargo.val());

                        //console.log(formData);
                        $.ajax({
                            url: 'insert_servicio.php',
                            type: 'POST',
                            data: formData,
                            /*data: {
                                nombre: nombreServicio.val(),
                                alias: aliasServicio.val(),
                                duracion: duracionServicio.val(),
                                descripcion: descripcionServicio.val(),
                                imagen: imagen,
                                processData: false,
                                contentType: 'multipart/form-data',
                                caracteristica: caracteristicaServicio.val()
                            }*/
                            processData: false, 
                            contentType: false,
                            success : function(servicioCreado){

                                var jsonServicioCreado = JSON.parse(servicioCreado);

                                if(jsonServicioCreado.result == "creado"){

                                    swal({
                                        title: "Servicio creado",
                                        type: "success",
                                    },
                                    function(){
                                        window.location.href='servicios.php';
                                    });
                                }
                                else{

                                    swal("", "Problemas al crear el servicio", "error");
                                }
                            }
                        });
                    }
                }
            }
            else{

                var mensajeError = "";

                if(nombreServicio.val() == ""){

                    errores.push("Digite el nombre del servicio");
                }
                if($("#txtCodigoAnteriorServicio2").val() == 0){

                    errores.push("El c\u00F3digo anterior digitado ya se encuentra registrado");    
                }
                else if(($("#txtCodigoAnteriorServicio2").val() != 0) && (codigoAnteriorServicio.val() == "0")){
                    
                    errores.push("Aseg\u00FArese de digitar un c\u00F3digo anterior diferente a 0");
                }
                if(aliasServicio.val() == ""){

                    errores.push("Digite el alias del servicio");
                }
                if((duracionServicio.val() == 0) || (duracionServicio.val() == "")){

                    errores.push("Digite la duraci\u00F3n aproximada del servicio");
                }
                if((comisionServicio.val() == "") || (comisionServicio.val() < 0)){

                    errores.push("Digite la comisi\u00F3n del servicio");
                }
                if((comisionServicio.val() < 0) || (comisionServicio.val() > 100)){

                    errores.push("Digite una comisi\u00F3n entre 0 y 100");
                }
                if(grupoServicio.val() == null){

                    errores.push("Seleccione un grupo");
                }
                if(subgrupoServicio.val() == null){

                    errores.push("Seleccione un sub-grupo");
                }
                if(lineaServicio.val() == null){

                    errores.push("Seleccione una linea");
                }
                if(sublineaServicio.val() == null){

                    errores.push("Seleccione una sub-linea");
                }
                if(caracteristicaServicio.val() == null){

                    errores.push("Seleccione una caracteristica");
                }
                if(categoria.val()==''){
                     errores.push("Seleccione una categoria");
                }
                if(cargo.val()==null){
                    errores.push("Seleccione un cargo"); 
                }

                for(i = 0; i < errores.length; i++){

                    mensajeError += errores[i] + "\n";
                }

                swal("Error", mensajeError, "error");
            }
        });
    });
</script>
</body>
</html>