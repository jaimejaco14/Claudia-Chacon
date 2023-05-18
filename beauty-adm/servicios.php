<?php

    include 'head.php';
    include "../cnx_data.php";
     VerificarPrivilegio("SERVICIOS", $_SESSION['tipo_u'], $conn);
    include "librerias_js.php";

$queryGrupos      = "SELECT grucodigo AS codigoGrupo, grunombre AS nombreGrupo FROM btygrupo WHERE tpocodigo = 2 AND gruestado = 1";
$resulQueryGrupos = $conn->query($queryGrupos);
?>

<div>

<div class="normalheader transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <a class="small-header-action" href="">
                <div class="clip-header">
                    <i class="fa fa-arrow-up"></i>
                </div>
            </a>
            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    
                    <li><a href="index.php">Inicio</a></li>
                    <li class="active">
                        <span>Servicios</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <input class="form-control" type="text" id="inputbuscar" name="inputbuscar" placeholder="Nombre del servicio">
                            <div class="input-group-btn">
                                
                                <button id="busca" name="busca" class="btn btn-default"><i class="fa fa-search text-info"></i></button>
                                <a href="newservice.php"><button class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Nuevo servicio"><i class="fa fa-plus-square-o text-info"></i>
                                    </button></a>

                                <button class="btn btn-default" data-toggle="tooltip" id="btnEnvioreporte" data-placement="bottom" title="Enviar reporte" onclick="$('#modalenviocorreo').modal('show')">
                                <span class=" text-info glyphicon glyphicon-envelope fa-1x"></span>
                            </button>

                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
    
<!-- Modal de envio spor corrreo-->

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

                                <button onclick="adcc()" class="btn btn-default" type="button"><i class="glyphicon glyphicon-plus small"></i> </button>
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

<!-- Modal de envio spor corrreo-->

    
<div class="content animated-panel">
    <div class="col-lg-12">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li class="active lista"><a data-toggle="tab" href="#tab-1" id="listaser"> Servicios</a></li>
                <li class="deta" style="display:none;"><a data-toggle="tab" id="detaser" href="#tab-2">  Detalle servicio</a></li>
                <li class="ins" style="display:none;"><a data-toggle="tab" id="insumos" href="#tab-3">  Insumos</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <div class="form-group">
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
                           <!-- <input type="checkbox" name="repdet" id="repdet" autocomplete="off" /> -->
                           <div class="pull-right" data-toggle="tooltip" data-placement="top" title="Detallado">

                            <!-- <input type="checkbox" name="repdet" id="repdet"  data-toggle="toggle" data-off=" " data-on=" " data-style="ios"> -->
                            <div class="TriSea-technologies-Switch col-md-2">
                                <input id="repdet" name="repdet" class="repdet" type="checkbox"/>
                                <label for="repdet" class="label-primary"></label>
                            </div>
                           </div>
                           
                            <button class="btn btn-default pull-right" data-toggle="tooltip" id="btnReporteExcel" data-placement="top" title="Reporte en Excel">
                                        <i class="fa fa-file-excel-o text-info"></i>
                            </button>
                            <button class="btn btn-default pull-right" data-toggle="tooltip" id="btnReportePdf" data-placement="bottom" title="Reporte en PDF">
                                <span class="fa fa-file-pdf-o text-danger"></span>
                            </button>
                        </div>
                        <div id="contenido">
                          <?php include "find_ser.php"; ?>
                        </div> 
                    </div>
                </div>

                <div  id="tab-2" class="tab-pane">
                    <div class="panel-body">
                         <div class="content">
                            <form id="formEditarServicio">
                                <div class="row" style="display: none">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">Codigo del servicio</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <span class="fa fa-pencil"></span>
                                                </div>
                                                <input type="number" id="txtCodigoServicio" name="txtCodigoServicio" required class="form-control text-uppercase" placeholder="Nombre del servicio">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="col-xs-9 col-sm-12 col-xs-offset-1 col-sm-offset-3 col-md-offset-0">
                                            <img src="../contenidos/imagenes/default.jpg"  id="imgServicio" class="img-rounded img-responsive" onerror="this.src='../contenidos/imagenes/default.jpg';">
                                        </div>

                                        <!-- <div class="col-sm-12" style="margin: 15px 0">
                                            <input type="file" name="iflImagenServicio" id="iflImagenServicio">
                                        </div> -->
                                    </div>

                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-8">
                                                <div class="form-group">
                                                    <label class="control-label">Nombre del servicio</label>
                                                    <input type="text" maxlength="50" id="txtNombreServicio" name="txtNombreServicio" required class="form-control text-uppercase" placeholder="Nombre del servicio">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">C&oacute;digo anterior</label>
                                                    <input type="number" id="txtCodigoAnteriorServicio" name="txtCodigoAnteriorServicio" min="1" placeholder="C&oacute;digo anterior" class="form-control text-uppercase">
                                                    <small class="text-danger" id="mensajeErrorCodigoAnterior"></small>
                                                    <input  type="number" style="display: none" name="txtCodigoAnteriorServicio2" id="txtCodigoAnteriorServicio2">
                                                    <input  type="number" style="display: none" name="txtCodigoAnteriorServicio3" value="1" min="0" id="txtCodigoAnteriorServicio3">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Alias</label>
                                                    <input type="text" maxlength="10" class="form-control text-uppercase" placeholder="Alias del servicio" required id="txtAliasServicio" name="txtAliasServicio">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Duraci&oacute;n del servicio</label>
                                                    <div class="input-group">
                                                        <input type="number" min="1" class="form-control" placeholder="0" id="txtDuracionServicio" name="txtDuracionServicio" required>
                                                        <div class="input-group-addon">
                                                            <span>min.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Porcentaje de comisi&oacute;n</label>
                                                    <div class="input-group">
                                                        <input type="number" name="txtComisionServicio" min="0" max="100" id="txtComisionServicio" class="form-control">
                                                        <div class="input-group-addon">
                                                            <span class="fa fa-percent"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="file" name="iflImagenServicio" id="iflImagenServicio">
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-offset-2 col-md-2">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="checkPrecioFijoServicio" id="checkPrecioFijoServicio"> Precio fijo
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-2">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label data-toggle="tooltip" data-placement="top" title="Permitir que se pueda agendar mediante citas">
                                                    <input type="checkbox" name="checkCitaServicio" id="checkCitaServicio"> Cita
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-2">
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label data-toggle="tooltip" data-placement="top" title="Permitir que se pueda programar su realizaci&oacute;n a domicilio">
                                                    <input type="checkbox" name="checkDomicilioServicio" id="checkDomicilioServicio"> Domicilio
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Descripci&oacute;n del servicio</label>
                                            <textarea name="txtDescripcionServicio" id="txtDescripcionServicio" placeholder="Descripci&oacute;n del servicio" rows="2" maxlength="500" class="form-control text-uppercase" style="resize: none;"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4" >
                                        <input type="hidden" id="switchcat" value='0'>
                                        <label for="txtcategoria">Categoria del Servicio</label><br>
                                        <div id="oldcat">
                                            <a id="editcat"><i class="fa fa-edit"></i>Editar categoría</a>
                                            <input class="form-control" type="text" id="txtcategoria" readonly> 
                                        </div>
                                        <div id="newcat" style="display:none;">    
                                            <a id="caneditcat"><i class="fa fa-times"></i>Cancelar edición</a>
                                            <select name="" id="ctcservicio" class="form-control" required="required">
                                                <option value="">Seleccione Categoría</option>
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
                                    </div>      
                                    <div class="col-md-4">
                                            <input type="hidden" id="switchcrg" value='0'>
                                            <label for="selcargo">Cargo(s) asociados al servicio </label><br> 
                                            <a id="editcrg"><i class="fa fa-edit"></i>Editar Cargo</a>
                                            <a id="caneditcrg" style="display:none;"><i class="fa fa-times"></i>Cancelar Edición</a>                                 
                                            <select class="form-control" name="selcargo" id="selcargo" data-error="Escoja una opcion" multiple="multiple">
                                                <!-- <option value="0">Todos los cargos</option> -->
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
                                <div class="row" id="rowTablaCategorias">
                                    <div class="col-sm-12">
                                        <a id="linkEditarCategorias"><p class="small"><span class="fa fa-edit"></span> Editar Clasificación</p></a>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Grupo</th>
                                                        <th>Subgrupo</th>
                                                        <th>L&iacute;nea</th>
                                                        <th>Subl&iacute;nea</th>
                                                        <th>Caracter&iacute;stica</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="contenidoTabla"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="col-sm-6 col-md-4">
                                            <input type="number" style="display: none;" min="0" id="txtCodGrupo" placeholder="C&oacute;digo grupo">
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <input type="number" style="display: none;" min="0" id="txtCodSubgrupo" placeholder="C&oacute;digo subgrupo">
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <input type="number" style="display: none;" min="0" id="txtCodLinea" placeholder="C&oacute;digo l&iacute;nea">
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <input type="number" style="display: none;" min="0" id="txtCodSublinea" placeholder="C&oacute;digo subl&iacute;nea">
                                        </div>
                                        <div class="col-sm-6 col-md-4">
                                            <input type="number" style="display: none;" min="0" id="txtCodCaracteristica" placeholder="C&oacute;digo caracter&iacute;stica">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="rowCategorias" style="display: none">
                                    <div class="col-sm-12">
                                        <a id="linkOcultarCategorias"><p class="small"><span class="fa fa-close"></span> Ocultar CLasificación</p></a>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Grupo</label>
                                            <select name="selectGrupoServicio" id="selectGrupoServicio" required class="form-control input-sm">
                                                <?php 
                                                    /*if(mysqli_num_rows($resulQueryGrupos) > 0){

                                                        echo "<option selected disabled>---Seleccione un grupo---</option>";

                                                        while($registrosGrupos = $resulQueryGrupos->fetch_array()){

                                                            echo "<option value='".$registrosGrupos["codigoGrupo"]."'>".$registrosGrupos["nombreGrupo"]."</option>";
                                                        }
                                                    }*/
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Subgrupo</label>
                                            <select name="selectSubgrupoServicio" id="selectSubgrupoServicio" required class="form-control input-sm">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">L&iacute;nea</label>
                                            <select name="selectLineaServicio" id="selectLineaServicio" required class="form-control input-sm">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Subl&iacute;nea</label>
                                            <select name="selectSublineaServicio" id="selectSublineaServicio" required class="form-control input-sm">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Caracter&iacute;stica</label>
                                            <select name="selectCaracteristicaServicio" id="selectCaracteristicaServicio" required class="form-control input-sm">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label">Valores en lista de precios</label>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-condensed table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Lista de precio</th>
                                                        <th>Valor</th>
                                                        <th>Ult. Actualizaci&oacute;n</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tablaListaPrecios"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Fecha de creaci&oacute;n</label>
                                            <input type="date" name="txtFechaCreacionServicio" id="txtFechaCreacionServicio" readonly class="form-control input-sm"> 
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Fecha de &uacute;ltima actualizaci&oacute;n</label>
                                            <input type="date" name="txtFechaActualizacionServicio" id="txtFechaActualizacionServicio" readonly class="form-control input-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-group">
                          
                                           <div class="pull-left" data-toggle="tooltip" data-placement="right" title="seleccione si el servicio requiere de insumos">
                                           <label class="control-label">Requiere Insumos</label><br>
                                            <div class="TriSea-technologies-Switch col-md-2">
                                                <input id="swinsedt" name="swinsedt" class="swinsedt" type="checkbox"/>
                                                <label for="swinsedt" class="label-primary"></label>
                                            </div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <div class="pull-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="$('#listaser').click()">Cerrar</button>
                            <button type="button" class="btn btn-success" id="btnEditarServicio">Guardar</button>
                        </div>
                    </div>
                </div></div>

                <div id="tab-3" class="tab-pane">
                    <div class="panel-body">
                
                       <div class="content">
                           <h4 class="text-center">Agregar insumos a servicio: </h4><b><h4 class="titulo text-center"></h4></b>
                           <div class="content">
                               <form id="formaddserpro">
                                       <input type="hidden" name="selser" id="selser">
                                   <div class="form-group col-md-6">
                                       <label for="selpro">Elija Insumo</label>
                                       <select name="selpro" id="selpro" class="form-control" required>
                                            <option value="0" selected disabled>Seleccione insumo</option>
                                       </select>
                                   </div>
                                   <div class="col-md-2">
                                   <label for="cant">Cantidad</label>
                                       <input class="form-control numero" type="number" name="cant" id="cant"  placeholder="0.000" min="0" max="999" step="0.001" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46 || event.charCode == 0 ">                               
                                   </div>
                                   <!-- <div class="form-group col-md-3" data-toggle="tooltip" data-placement="top" title="seleccione si el servicio requiere cantidad al facturar">
                                        <center>
                                        <label for="reqcant">Requiere Cantidad</label><br>
                                            <input type="checkbox" name="reqcant" id="reqcant"  data-toggle="toggle" data-off="NO" data-on="SI" >
                                            </center>
                                   </div> -->
                                   <div class="form-group col-md-3" >
                                   <label class="control-label">Requiere Cantidad</label><br><br>
                                    <div class="TriSea-technologies-Switch col-md-2 col-md-push-1" data-toggle="tooltip" data-placement="bottom" title="seleccione si el servicio requiere cantidad al facturar">
                                        <input id="reqcant" name="reqcant" class="reqcant" type="checkbox"/>
                                        <label for="reqcant" class="label-primary"></label>
                                    </div>
                                   </div>

                                   <div class="form-group col-md-1" style="padding-top:0.6%;">
                                   <br>
                                       <button id="addserpro" class="btn btn-info btn-sm pull-left" data-toggle="tooltip" data-placement="top" title="Agregar Insumo"><span class="fa fa-plus"></span></button>                              
                                   </div> 
                                </form>
                            </div>
                           <div class="content">
                               <br> 
                               <h4 class="text-center">Insumos actualmente asignados al servicio</h4>
                               <div class="col-md-4">
                                   <input id="search" type="text" class="form-control" placeholder="Buscar en insumos asignados...">
                               </div>
                           </div>
                           <div class="content" id="tbserpro">
                               
                           </div>
                       </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ****************************************************************************************************************************************************************************************** -->

<div class="modal fade" id="modaleditserpro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit" aria-hidden="true"></i>  Editar insumos </h4>
            </div>
            <div class="modal-body">
                <form id="formeditsp">
                    <div class="col-md-12">
                        <label for="nomser">Servicio</label>
                        <input type="text" id="nomser" class="form-control" readonly>
                        <input type="hidden" name="selseredt" id="selseredt">
                    </div>
                    <div class="col-md-12">
                    <input type="hidden" name="oldpro" id="oldpro">
                        <label for="selproedt">Insumo</label>
                        <select name="selproedt" id="selproedt" class="form-control">
                     
                            <?php
                            $sqlpro="SELECT p.procodigo,p.pronombre  FROM btyproducto p where p.proestado=1 order by p.pronombre asc";
                            $respro=$conn->query($sqlpro);
                            while($rowpro=$respro->fetch_array()){
                                ?>
                                <option value="<?php echo $rowpro[0];?>"><?php echo utf8_encode($rowpro[1]);?></option>
                                option
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                    <label for="cantedt">Cantidad</label> 
                        <input class="form-control numero" type="number" name="cantedt" id="cantedt"  placeholder="0.000" min="0" max="999" step="0.001" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46 || event.charCode == 0 ">                                      
                    </div>
                   
                                   <div class="pull-left"  >
                                   <label class="control-label">Requiere Cantidad</label><br><br>
                                    <div class="TriSea-technologies-Switch col-md-2 col-md-push-1" data-toggle="tooltip" data-placement="bottom" title="seleccione si el servicio requiere cantidad al facturar">
                                        <input id="reqcantedt" name="reqcantedt" class="reqcantedt" type="checkbox"/>
                                        <label for="reqcantedt" class="label-primary"></label>
                                    </div>
                                   </div>
                    <div class="col-md-12">
                        <button id="btnactsp" type="submit" class="btn btn-info pull-right" data-toggle="tooltip" data-placement="top" title="Guardar cambios"><span class="fa fa-save"></span></button>
                        <button id="" class="btn btn-danger pull-right" type="reset" data-toggle="tooltip" data-placement="top" title="Cancelar" data-dismiss="modal"><span class="fa fa-remove"></span></button>
                    </div>
                </form>
            </div>  
            <div class="modal-footer"> 
                
            </div>           
        </div>
    </div>
</div>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css" /> -->

<script>  
    $('#side-menu').children('.active').removeClass("active");  
    $("#INVENTARIO").addClass("active");
    $("#SERVICIOS").addClass("active");
    /*$("#selpro").select2({
    });*/
    $("#selproedt").select2().select2("val", null);


    $(document).ready(function() {
        $('#selpro').selectpicker({
            liveSearch: true,
            showSubtext: true
        });
        $("#selcargo").select2({placeholder:"Elija cargo(s)"});
    });

    $('#selpro').on('show.bs.select', function (e) {
      $('.bs-searchbox').addClass('algo');
      $('.algo .form-control').attr('id', 'fucker');
    });

    $(document).on('keyup', '#fucker', function(event) 
    {
      var seek = $(this).val();
      $.ajax({
      url: 'serprooper.php',
      type: 'POST',
      data:'opc=llen&key='+seek,

      success: function(data){

          var json = JSON.parse(data);
              var prods = "";

              for(var i in json){

                  prods += "<option value='"+json[i].id+"'>"+json[i].name+"</option>";
              }

              $("#selpro").html(prods);
              $("#selpro").selectpicker('refresh');

      }
      }); 
    });

    
    //$("#selpro").select2().select2("val", null);
    //$("#selproedt").select2().select2("val", null);

    $('.numero').keydown( function(e){
        if ($(this).val().length >= 4) { 
            $(this).val($(this).val().substr(0, 4));
        }
    });
</script>
<script>
        var i=0;
        var arr1=[];
        $(document).ready(function () {
            
            var sw=false;

            $(".repdet").change(function() {
                sw=false;
                if (this.checked) {
                   sw=true;
                }
            });
            
            $("#btnReporteExcel").on("click", function(){
                var det;
                if(sw){det='on'}else{det='off'}
                window.open("./generarReporteServicios.php?sw="+det+"&dato=" + $("#inputbuscar").val() + "&tipo=XLS");
            });

            $("#btnReportePdf").on("click", function(){
                var det;
                if(sw){det='on'}else{det='off'}
                window.open("./generarReporteServicios.php?sw="+det+"&dato=" + $("#inputbuscar").val() + "&tipo=PDF");
            });
            $('[data-toggle="tooltip"]').tooltip();

            $('#btn_usuarios').click(function () {
                $.ajax({
                    url: "usuarios.php"
                }).done(function (html) {
                    $('#contenido').html(html);
                }).fail(function () {
                    alert('Error al cargar modulo');
                });
            });

            var grupoServicio          = $("#selectGrupoServicio");
            var subgrupoServicio       = $("#selectSubgrupoServicio");
            var lineaServicio          = $("#selectLineaServicio");
            var sublineaServicio       = $("#selectSublineaServicio");
            var caracteristicaServicio = $("#selectCaracteristicaServicio");
            var btnActualizarServicio  = $("#btnEditarServicio");

            //Llenar select de subgrupos al escoger un grupo
            grupoServicio.on("change", function(){

                /*subgrupoServicio.attr("disabled", false);
                lineaServicio.attr("disabled", true);
                sublineaServicio.attr("disabled", true);
                caracteristicaServicio.attr("disabled", true);*/
                $("#btnEditarServicio").attr("disabled", true);
                subgrupoServicio.val(0);
                lineaServicio.val(0);
                sublineaServicio.val(0);
                caracteristicaServicio.val(0);
                lineaServicio.html("");
                sublineaServicio.html("");
                caracteristicaServicio.html("");

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

                /*lineaServicio.attr('disabled', false);
                sublineaServicio.attr("disabled", true);
                caracteristicaServicio.attr("disabled", true);*/
                $("#btnEditarServicio").attr("disabled", true);
                lineaServicio.val(0);
                sublineaServicio.val(0);
                caracteristicaServicio.val(0);
                sublineaServicio.html("");
                caracteristicaServicio.html("");

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

                /*ublineaServicio.attr("disabled", false);
                caracteristicaServicio.attr("disabled", true);*/
                $("#btnEditarServicio").attr("disabled", true);
                sublineaServicio.val(0);
                caracteristicaServicio.val(0);
                sublineaServicio.html("");
                caracteristicaServicio.html("");

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

                // caracteristicaServicio.attr("disabled", false);
                $("#btnEditarServicio").attr("disabled", true);
                caracteristicaServicio.val(0);

                $.ajax({
                    url: 'categoriasNuevoServicio.php',
                    type: 'GET',
                    data: {codigoSublinea: sublineaServicio.val()},

                    success : function(dataCaracteristicas){

                        var resultCaracteristicasServicio = "";
                        var jsonCaracteristicasServicio = JSON.parse(dataCaracteristicas);

                        if(jsonCaracteristicasServicio.result == "full"){

                            resultCaracteristicasServicio += "<option selected disabled value='0'>---Seleccione una caracter&iacute;stica--</option>";

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

            //Al seleccionar caracteristica
            caracteristicaServicio.on("change", function(){

                $("#btnEditarServicio").attr("disabled", false);
            });

            //Comprobacion del nombre anterior
            $("#txtCodigoAnteriorServicio").on("keyup", function(){

                $.ajax({
                    url: 'comprobarCodigoAnteriorServicio.php',
                    data: {codigoAnterior: $(this).val()},
                })
                .done(function(resultado){

                    var jsonResultado = JSON.parse(resultado);

                    switch (jsonResultado.result){
                            
                        case "vacio":
                            $("#txtCodigoAnteriorServicio3").val(1);
                            $("#mensajeErrorCodigoAnterior").text("");
                            break;
                        
                        case "full":

                            if($("#txtCodigoAnteriorServicio").val() == $("#txtCodigoAnteriorServicio2").val()){

                                $("#txtCodigoAnteriorServicio3").val(1);
                                $("#mensajeErrorCodigoAnterior").text("");
                            }
                            else if($("#txtCodigoAnteriorServicio").val() == 0){

                                $("#txtCodigoAnteriorServicio3").val(0);
                            }
                            else{

                                $("#txtCodigoAnteriorServicio3").val(0);
                                $("#mensajeErrorCodigoAnterior").text("El c\u00F3digo digitado ya se encuentra registrado. Intente con otro.");
                            }
                            break;
                        
                        default:
                            $("#txtCodigoAnteriorServicio3").val(1);
                            $("#mensajeErrorCodigoAnterior").text("");
                            break;
                    }
                });
                
            });

            $(".swinsedt").click(function() {
                var id=$("#txtCodigoServicio").val();
                if(!this.checked) {
                    $.ajax({
                        url:'serprooper.php',
                        type:'POST',
                        data:'opc=chk&id='+id,
                        success:function(res){
                            if(res=='true'){
                                swal('No se puede desactivar','Este servicio tiene insumos asignados, debe quitarlos antes de desactivar esta casilla','error');
                                 $(".swinsedt").prop('checked', true).change();
                            }else if(res=='false'){

                            }else{
                                swal('Algo ha salido mal...','Refresque la pagina e intentelo nuevamente','error');
                            }
                        }
                    })
                }
            });

            //Al hacer click en Guardar (Modal editar servicio)
            btnActualizarServicio.on("click", function(){
                
                var codigo          = $("#txtCodigoServicio");  
                var nombre          = $("#txtNombreServicio");
                var codigoAnterior  = $("#txtCodigoAnteriorServicio");
                var imagen          = $("#iflImagenServicio");
                var alias           = $("#txtAliasServicio");
                var duracion        = $("#txtDuracionServicio");
                var comision        = $("#txtComisionServicio");
                var descripcion     = $("#txtDescripcionServicio");
                var sw              = $("#switchcat").val();
                var sw2             = $("#switchcrg").val();

                    var categoria   = $("#ctcservicio").val();
         

   
                    var cargo       = $("#selcargo").val();
    


                var caracteristica  = $("#selectCaracteristicaServicio");
                var checkPrecioFijo = $("#checkPrecioFijoServicio");
                var checkCita       = $("#checkCitaServicio");
                var checkDomicilio  = $("#checkDomicilioServicio");
                var errores         = new Array();
                var precioFijo      = 1;
                var cita            = 1;
                var domicilio       = 1;
                var insumo          = 0;

                //console.log(cargo+'*');
           

                    if(($.trim(nombre.val()) != "") && (duracion.val() != "" && duracion.val() != 0) && ((codigoAnterior.val() >= 0)) && ((comision.val() >= 0) && (comision.val() <= 100)   && (comision.val() != "")) ) {

                        if(!checkPrecioFijo.is(":checked")){

                            precioFijo = 0;
                        }

                        if(!checkCita.is(":checked")){

                            cita = 0;
                        }

                        if(!checkDomicilio.is(":checked")){

                            domicilio = 0;
                        }

                        if($(".swinsedt").is(":checked")){

                            insumo = 1;
                        }

                        if(imagen[0].files[0] == null){

                            $.ajax({

                                url: "actualizarServicio.php",
                                type: "POST",
                                data: {
                                    codigo: codigo.val(),
                                    nombre: nombre.val(),
                                    codigoAnterior: codigoAnterior.val(),
                                    alias: alias.val(),
                                    duracion: duracion.val(),
                                    comision: comision.val(),
                                    descripcion: descripcion.val(),
                                    categoria: categoria,
                                    cargo:cargo,
                                    caracteristica: caracteristica.val(),
                                    precioFijo: precioFijo,
                                    cita: cita,
                                    domicilio: domicilio,
                                    insumo: insumo
                                }
                            })
                            .done(function(servicioActualizado){

                                var jsonServicioActualizado = JSON.parse(servicioActualizado);
                                //$("#modalEditarServicio").modal("hide");

                                if(jsonServicioActualizado.result == "actualizado"){

                                    swal("Servicio actualizado", "", "success");
                                    $("#formEditarServicio")[0].reset();
                                    //cerrarModal();
                                    location.reload();
                                   
                                }
                                else{


                                    swal("Error", "Problemas al actualizar el servicio", "error");
                                    $("#formEditarServicio")[0].reset();
                                    cerrarModal();
                                }
                            });    
                        }
                        else{

                            var nuevaImagen = imagen[0].files[0];
                            var stringImagen = nuevaImagen["type"].split("/");
                            var tipoImagen = stringImagen[1];
                            var tamanoImagen = nuevaImagen["size"];

                            if((tipoImagen != "jpeg") && (tamanoImagen < 512000)){

                                swal("Error", "Debe subir una imagen con extensi\u00F3n .jpg", "error");
                                //$("#mensajeImagenGrupo").text("Debe subir una imagen con extensi\u00F3n .jpg").css("color", "red");
                            }
                            else if((tipoImagen == "jpeg") && (tamanoImagen > 512000)){

                                swal("Error", "Debe subir una imagen con tama\u00F1o menor a 500KB", "error");
                                //$("#mensajeImagenGrupo").text("Debe subir una imagen con tama\u00F1o menor a 500KB").css("color", "red");
                            }
                            else if((tipoImagen != "jpeg") && (tamanoImagen > 512000)){

                                swal("Error", "Debe subir una imagen con extensi\u00F3n .jpg. Debe subir una imagen con tama\u00F1o menor a 500KB", "error");
                                //$("#mensajeImagenGrupo").text("Debe subir una imagen con extensi\u00F3n .jpg. Debe subir una image con tama\u00F1o menor a 500KB").css("color", "red");
                            }
                            else{

                                var formData = new FormData();
                                formData.append("codigo", codigo.val());
                                formData.append("nombre", nombre.val());
                                formData.append("codigoAnterior", codigoAnterior.val());
                                formData.append("alias", alias.val());
                                formData.append("duracion", duracion.val());
                                formData.append("comision", comision.val());
                                formData.append("descripcion", descripcion.val());
                                formData.append("categoria", categoria);
                                formData.append("cargo", cargo);
                                formData.append("caracteristica", caracteristica.val());
                                formData.append("precioFijo", precioFijo);
                                formData.append("cita", cita);
                                formData.append("domicilio", domicilio);
                                formData.append("imagen", nuevaImagen);

                                $.ajax({

                                    url: "actualizarServicio.php",
                                    type: "POST",
                                    data: formData,
                                    processData: false, 
                                    contentType: false,
                                    /*data: {
                                        codigo: codigo.val(),
                                        nombre: nombre.val(),
                                        alias: alias.val(),
                                        duracion: duracion.val(),
                                        descripcion: descripcion.val(),
                                        caracteristica: caracteristica.val(),
                                        precioFijo: precioFijo
                                    }*/
                                })
                                .done(function(servicioActualizado){

                                    var jsonServicioActualizado = JSON.parse(servicioActualizado);
                                    $("#modalEditarServicio").modal("hide");

                                    if(jsonServicioActualizado.result == "actualizado"){

                                        swal("Servicio actualizado", "", "success");
                                        $("#formEditarServicio")[0].reset();
                                        //cerrarModal();
                                        location.reload();
                                       
                                    }
                                    else{

                                        swal("Error", "Problemas al actualizar el servicio", "error");
                                        $("#formEditarServicio")[0].reset();
                                        cerrarModal();
                                    }
                                });
                            }
                        }
                    }
                    else{

                        if($.trim(nombre.val()) == ""){

                            errores.push("Indique el nombre del servicio");
                        }
                        if(($("#txtCodigoAnteriorServicio3").val() == 0) && ($("#mensajeErrorCodigoAnterior").text() != "")){

                            errores.push("El c\u00F3digo anterior digitado ya se encuentra registrado");
                        }
                        else if((codigoAnterior.val() <= 0) && ($("#txtCodigoAnteriorServicio3").val() != 0)){
                                
                            errores.push("Aseg\u00FArese de digitar un c\u00F3digo anterior mayor a 0");
                        }
                        else if((codigoAnterior.val() == 0) && ($("#txtCodigoAnteriorServicio3").val() == 0)){

                            errores.push("Aseg\u00FArese de digitar un c\u00F3digo diferente a 0");
                        }
                        if((duracion.val() == "") && (duracion.val() == 0)){

                            errores.push("Indique la duraci\u00F3n del servicio");
                        }
                        if(comision.val() == ""){

                            errores.push("Digite la comisi\u00F3n del servicio")
                        }
                        if((comision.val() < 0) || (comision.val() > 100)){

                            errores.push("Digite una comisi\u00F3n entre 0 y 100");
                        }
                       

                        var i            = 0;
                        var mensajeError = "";

                        for(i = 0; i < errores.length; i++){

                            mensajeError += errores[i] + "\n";
                        }

                        $("#modalEditarServicio").modal("hide");
                        
                        swal({
                            title: "Faltan campos por diligenciar",
                            text: mensajeError,
                            type: "error"
                        }, function(){

                            $("#modalEditarServicio").modal("show");
                        });
                    }
               
            });
        });

        //Al seleccionar una imagen a cargar
        $("#iflImagenServicio").on("change", function(){

            mostrarImagen(this);
        });


        function mostrarImagen(input) {

            var imagen = input.files[0];
            var stringImagen = imagen["type"].split("/");
            var tipoImagen = stringImagen[1];
            var tamanoImagen = imagen["size"];

            if((tipoImagen != "jpeg") && (tamanoImagen < 512000)){

                swal("Error", "Debe subir una imagen con extensi\u00F3n .jpg", "error");
                //$("#mensajeImagenGrupo").text("Debe subir una imagen con extensi\u00F3n .jpg").css("color", "red");
            }
            else if((tipoImagen == "jpeg") && (tamanoImagen > 512000)){

                swal("Error", "Debe subir una imagen con tama\u00F1o menor a 500KB", "error");
                //$("#mensajeImagenGrupo").text("Debe subir una imagen con tama\u00F1o menor a 500KB").css("color", "red");
            }
            else if((tipoImagen != "jpeg") && (tamanoImagen > 512000)){

                swal("Error", "Debe subir una imagen con extensi\u00F3n .jpg. Debe subir una imagen con tama\u00F1o menor a 500KB", "error");
                //$("#mensajeImagenGrupo").text("Debe subir una imagen con extensi\u00F3n .jpg. Debe subir una image con tama\u00F1o menor a 500KB").css("color", "red");
            }
            else{

                if (input.files && input.files[0]) {
                  
                    var reader = new FileReader();
                  
                    reader.onload = function (e) {
                        $('#imgServicio').attr('src', e.target.result);
                    }
                  
                    reader.readAsDataURL(input.files[0]);
                }
            }
        }

        //Cerrar modal al presionar Esc
        $(document).bind('keydown',function(e){
            
            if(e.which == 27){
                
                cerrarModal();
            }                
        });

        function cerrarModal(){

            $("#rowTablaCategorias").css("display", "block");
            $("#rowCategorias").css("display", "none");
            $("#formEditarServicio")[0].reset();
            $("#selectSubgrupoServicio").val(0);
            $("#selectLineaServicio").val(0);
            $("#selectSublineaServicio").val(0);
            $("#selectCaracteristicaServicio").val(0);
            /*$("#selectSubgrupoServicio").attr("disabled", true);
            $("#selectLineaServicio").attr("disabled", true);
            $("#selectSublineaServicio").attr("disabled", true);
            $("#selectCaracteristicaServicio").attr("disabled", true);
            $("#btnEditarServicio").attr("disabled", false);*/
            $("#contenido").html('');
            $("#contenido").load('find_ser.php');
            $("#listaser").click();
        } 

        //Al hacer click en Editar servicio
        function editarServicio(codServicio) {
            
            var nombreServicio             = $("#txtNombreServicio");
            var codigoAnteriorServicio     = $("#txtCodigoAnteriorServicio");
            var aliasServicio              = $("#txtAliasServicio");
            var duracionServicio           = $("#txtDuracionServicio");
            var comisionServicio           = $("#txtComisionServicio");
            var descripcionServicio        = $("#txtDescripcionServicio");
            var precioFijoServicio         = $("#checkPrecioFijoServicio");
            var citaServicio               = $("#checkCitaServicio");
            var domicilioServicio          = $("#checkDomicilioServicio");
            var fechaCreacionServicio      = $("#txtFechaCreacionServicio");
            var fechaActualizacionServicio = $("#txtFechaActualizacionServicio");
            var categoria                  = $("#txtcategoria");

            //Obtener datos del servicio seleccionado
            $.ajax({
                url: 'obtenerDatosServicio.php',
                type: 'GET',
                data: {codigoServicio: codServicio}
            })
            .done(function(datosServicio){

                var jsonDatosServicio = JSON.parse(datosServicio);

                if(jsonDatosServicio.result == "full"){

                    var tablaDatos        = "";
                    var tablaListaPrecios = "";
                    
                    for(i in jsonDatosServicio.data){

                        $("#txtCodigoServicio").val(jsonDatosServicio.data[i].codigo);
                        nombreServicio.val(jsonDatosServicio.data[i].nombre);
                        codigoAnteriorServicio.val(jsonDatosServicio.data[i].codigoAnterior);
                        $("#txtCodigoAnteriorServicio2").val(jsonDatosServicio.data[i].codigoAnterior);
                        aliasServicio.val(jsonDatosServicio.data[i].alias);
                        duracionServicio.val(jsonDatosServicio.data[i].duracion);
                        comisionServicio.val(jsonDatosServicio.data[i].comision);
                        descripcionServicio.val(jsonDatosServicio.data[i].descripcion);
                        categoria.val(jsonDatosServicio.data[i].categoria);
                        var cargos=jsonDatosServicio.data[i].cargo;
                        $("#selcargo").select2('val',"");
                        if(cargos!=null){
                            var dd=cargos.split(',');
                            $("#selcargo").select2('val',dd);
                        }
                        $("#selcargo").select2("readonly", true);
                        $("#caneditcat").click();
                        $("#caneditcrg").click();
                        fechaCreacionServicio.val(jsonDatosServicio.data[i].fechaCreacion);
                        fechaActualizacionServicio.val(jsonDatosServicio.data[i].fechaActualizacion);
                        $("#txtCodGrupo").val(jsonDatosServicio.data[i].codGrupo);
                        $("#txtCodSubgrupo").val(jsonDatosServicio.data[i].codSubgrupo);
                        $("#txtCodLinea").val(jsonDatosServicio.data[i].codLinea);
                        $("#txtCodSublinea").val(jsonDatosServicio.data[i].codSublinea);
                        $("#txtCodCaracteristica").val(jsonDatosServicio.data[i].codCaracteristica);
                        var rutaImagen = "";

                        if(jsonDatosServicio.data[i].precioFijo == 1){

                            precioFijoServicio.prop('checked', "checked");
                        }


                        if(jsonDatosServicio.data[i].insumo == 1){

                            $(".swinsedt").prop('checked', true).change();
                        }else{
                            $(".swinsedt").prop('checked', false).change();
                        }

                        if(jsonDatosServicio.data[i].cita == 1){

                            citaServicio.prop("checked", "checked");
                        }

                        if(jsonDatosServicio.data[i].domicilio == 1){

                            domicilioServicio.prop("checked", "checked");
                        }

                        if((jsonDatosServicio.data[i].imagen == "default.jpg") || (jsonDatosServicio.data[i].imagen == "")){

                            rutaImagen = "../contenidos/imagenes/default.jpg";
                        }
                        else{

                            rutaImagen = "../contenidos/imagenes/servicio/" + jsonDatosServicio.data[i].imagen+"?<?php echo time();?>";
                        }

                        $("#imgServicio").attr("src", rutaImagen);
                        tablaDatos += "<tr><td>" + jsonDatosServicio.data[i].nomGrupo + "</td><td>" + jsonDatosServicio.data[i].nomSubgrupo + "</td><td>" + jsonDatosServicio.data[i].nomLinea + "</td><td>" + jsonDatosServicio.data[i].nomSublinea + "</td><td>" + jsonDatosServicio.data[i].nomCaracteristica + "</td></tr>";
                    }

                    for(i in jsonDatosServicio.listaPrecios){

                        tablaListaPrecios += "<tr><td>" + jsonDatosServicio.listaPrecios[i].nomLista + "</td><td>" + jsonDatosServicio.listaPrecios[i].valor + "</td><td>" + moment(jsonDatosServicio.listaPrecios[i].actualizacion).format("DD/MM/YYYY") + "</td></tr>";
                    }

                    $("#contenidoTabla").html(tablaDatos);
                    $("#tablaListaPrecios").html(tablaListaPrecios);
                }
                else{

                    swal({
                        title: "Error",
                        text: "Ocurri\u00F3 un problema al obtener datos del servicio seleccionado",
                        type: "error",
                        confirmButtonText: "Aceptar",
                    }, function(){

                        //$("#modalEditarServicio").modal("hide");
                    });
                }
            });

            //$("#modalEditarServicio").modal("show");
        }

        function eliminar(id, este) {
            swal({
                title: "¿Seguro que desea eliminar este servicio?",
                text: "",
                type: "warning",
                showCancelButton:  true,
                cancelButtonText:"No",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sí"
            },
            function () {
                $.ajax({
                type: "POST",
                url: "delete_serv.php",
                data: {id_servicio: id, operacion: "delete"}
                }).done(function (msg) {
                    //$(este).parent().parent().remove();
                    $("#contenido").html('');
                    $("#contenido").load('find_ser.php');
                }).fail(function () {
                    alert("Error enviando los datos. Intente nuevamente");
                });
            });
        }

        $("#linkEditarCategorias").on("click", function(){
            
            obtenerGrupoServicio();
            obtenerSubgrupoServicio($("#txtCodGrupo").val());
            obtenerLineaServicio($("#txtCodSubgrupo").val());
            obtenerSublineaServicio($("#txtCodLinea").val());
            obtenerCaracteristicaServicio($("#txtCodSublinea").val());

            $("#btnEditarServicio").attr("disabled", true);
            $("#rowTablaCategorias").css("display", "none");
            $("#rowCategorias").css("display", "block");
        });

        $("#linkOcultarCategorias").on("click", function(){

            $("#btnEditarServicio").attr("disabled", false);
            $("#rowTablaCategorias").css("display", "block");
            $("#rowCategorias").css("display", "none");
        });

        function obtenerGrupoServicio(){

            $.ajax({
                url: 'obtenerCategoriasEditarServicio.php',
                data: {categoria: "grupo"},
            })
            .done(function(grupos){
                
                var jsonGrupos = JSON.parse(grupos);
                var grupos = "";

                if(jsonGrupos.result == "full"){

                    for(i in jsonGrupos.grupos){

                        if(jsonGrupos.grupos[i].codGrupo == $("#txtCodGrupo").val()){

                            grupos += "<option selected value='"+jsonGrupos.grupos[i].codGrupo+"'>"+jsonGrupos.grupos[i].nomGrupo+"</option>";
                        }
                        else{

                            grupos += "<option value='"+jsonGrupos.grupos[i].codGrupo+"'>"+jsonGrupos.grupos[i].nomGrupo+"</option>";
                        }
                    }
                } 
                else{

                    grupos = "<option disabled selected>--- No hay grupos ---</option>";
                }
                
                $("#selectGrupoServicio").html(grupos);
            });
        }

        function obtenerSubgrupoServicio(codGrupo){

            $.ajax({
                url: 'obtenerCategoriasEditarServicio.php',
                data: {categoria: "subgrupo", codGrupo: codGrupo},
            })
            .done(function(subgrupos){
                
                var jsonSubgrupos = JSON.parse(subgrupos);
                var subgrupos     = "";

                if(jsonSubgrupos.result == "full"){

                    for(i in jsonSubgrupos.subgrupos){

                        if(jsonSubgrupos.subgrupos[i].codSubgrupo == $("#txtCodSubgrupo").val()){

                            subgrupos += "<option selected value='"+jsonSubgrupos.subgrupos[i].codSubgrupo+"'>"+jsonSubgrupos.subgrupos[i].nomSubgrupo+"</option>";
                        }
                        else{

                            subgrupos += "<option value='"+jsonSubgrupos.subgrupos[i].codSubgrupo+"'>"+jsonSubgrupos.subgrupos[i].nomSubgrupo+"</option>";
                        }
                    }
                } 
                else{

                    subgrupos = "<option disabled selected>--- No hay subgrupos ---</option>";
                }
                
                $("#selectSubgrupoServicio").html(subgrupos);
            });
        }

        function obtenerLineaServicio(codSubgrupo){

            $.ajax({
                url: 'obtenerCategoriasEditarServicio.php',
                data: {categoria: "linea", codSubgrupo: codSubgrupo},
            })
            .done(function(lineas){
                
                var jsonLineas = JSON.parse(lineas);
                var lineas     = "";

                if(jsonLineas.result == "full"){

                    for(i in jsonLineas.lineas){

                        if(jsonLineas.lineas[i].codLinea == $("#txtCodLinea").val()){

                            lineas += "<option selected value='"+jsonLineas.lineas[i].codLinea+"'>"+jsonLineas.lineas[i].nomLinea+"</option>";
                        }
                        else{

                            lineas += "<option value='"+jsonLineas.lineas[i].codLinea+"'>"+jsonLineas.lineas[i].nomLinea+"</option>";
                        }
                    }
                } 
                else{

                    lineas = "<option disabled selected>--- No hay lineas ---</option>";
                }
                
                $("#selectLineaServicio").html(lineas);
            });
        }

        function obtenerSublineaServicio(codLinea){

            $.ajax({
                url: 'obtenerCategoriasEditarServicio.php',
                data: {categoria: "sublinea", codLinea: codLinea},
            })
            .done(function(sublineas){
                
                var jsonSublineas = JSON.parse(sublineas);
                var sublineas     = "";

                if(jsonSublineas.result == "full"){

                    for(i in jsonSublineas.sublineas){

                        if(jsonSublineas.sublineas[i].codSublinea == $("#txtCodSublinea").val()){

                            sublineas += "<option selected value='"+jsonSublineas.sublineas[i].codSublinea+"'>"+jsonSublineas.sublineas[i].nomSublinea+"</option>";
                        }
                        else{

                            sublineas += "<option value='"+jsonSublineas.sublineas[i].codSublinea+"'>"+jsonSublineas.sublineas[i].nomSublinea+"</option>";
                        }
                    }
                } 
                else{

                    sublineas = "<option disabled selected>--- No hay sublineas ---</option>";
                }
                
                $("#selectSublineaServicio").html(sublineas);
            });
        }

        function obtenerCaracteristicaServicio(codSublinea){

            $.ajax({
                url: 'obtenerCategoriasEditarServicio.php',
                data: {categoria: "caracteristica", codSublinea: codSublinea},
            })
            .done(function(caracteristicas){
                
                var jsonCaracteristicas = JSON.parse(caracteristicas);
                var caracteristicas     = "";

                if(jsonCaracteristicas.result == "full"){

                    for(i in jsonCaracteristicas.caracteristicas){

                        if(jsonCaracteristicas.caracteristicas[i].codCaracteristica == $("#txtcodCaracteristica").val()){

                            caracteristicas += "<option selected value='"+jsonCaracteristicas.caracteristicas[i].codCaracteristica+"'>"+jsonCaracteristicas.caracteristicas[i].nomCaracteristica+"</option>";
                        }
                        else{

                            caracteristicas += "<option value='"+jsonCaracteristicas.caracteristicas[i].codCaracteristica+"'>"+jsonCaracteristicas.caracteristicas[i].nomCaracteristica+"</option>";
                        }
                    }
                } 
                else{

                    caracteristicas = "<option disabled selected>--- No hay caracteristicas ---</option>";
                }

                $("#selectCaracteristicaServicio").html(caracteristicas);
            });
        }

        function paginar(id) {
            $.ajax({
                type: "POST",
                url: "find_ser.php",
                data: {operacion: 'update', page: id}
            }).done(function (a) {
                $('#contenido').html(a);
            }).fail(function () {
                alert('Error al cargar modulo');
            });
        }

        function paginar2(id) {
            $('#tbserpro').html('');
            $.ajax({
                type: "POST",
                url: "tbserpro.php",
                data: 'page='+id,
            }).done(function (a) {
                $('#tbserpro').html(a);
            }).fail(function () {
                alert('Error al cargar modulo');
            });
        }

        $(document).ready(function () {
            $('#alerta').hide();
            $('#guardar').click(function (event) {
                event.preventDefault();

                var ope = 'insert';
                var id_u = '';
                if ($('#id_usuario').length > 0) {
                    if ($('#id_usuario').val() !== '') {
                        ope = 'update';
                        id_u = $('#id_usuario').val();
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "Cud_usuario.php",
                    data: {nombre: $('#nombre').val(), descripcion: $('#descripcion').val(),
                        alias: $('#alias').val(), imagen: $('#imagen').val(), nivel:$('#nivel').val(), operacion: ope, id_usuario: id_u}
                }).done(function (msg) {
                    
                    if (msg == 'Usuario Actualizado') {
                        $.ajax({
                            url: "usuarios.php"
                        }).done(function (html) {
                            $('#contenido').html(html);
                        }).fail(function () {
                            alert('Error al cargar modulo');
                        });
                    } else {
                        $('#alerta').hide();
                        $('#nombre').val('');
               
                    $("#rowCategorias").css("display", "block");         
                    $('#direccion').val('');
                    $('#telefono').val('');
                    $('#email').val('');
                    $('#pwd').val('');
                    $('#pwd2').val('');
                    }
                }).fail(function () {
                    alert("Error enviando los datos. Intente nuevamente");
                });
            });
        });

        $(document).ready(function() {
           
           $('#inputbuscar').keyup(function(){
                var username = $(this).val();        
                var dataString = 'nombre='+username;

                $.ajax({
                    type: "POST",
                    url: "find_ser.php",
                    data: dataString,
                    success: function(data) {
                        $('#contenido').html(data);
                    }
                });
            });   
        });
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
             url: "enviar_por_correo_servicio.php",
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
          
            },

            function(){
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
                         url: "generarReporteServicios.php",
                         data: {
                             envio: 1, dato: $("#inputbuscar").val()
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
                 url: "generarReporteServicios.php",
                 data: {
                     enviox: 1, dato: $("#inputbuscar").val()
                 },
                 success: function(data) {
                  console.log(data);
                 }
                });
        }); 
</script>
<script>
    $(document).ready(function() {
        $(".reqcant").change(function() {
            $("#cant").val('');
            $("#cant").removeAttr('disabled','disabled');
            if (this.checked) {
                $("#cant").attr('disabled','disabled');
                $("#cant").val('0.000');
            }
        });

        $(".reqcantedt").change(function() {
            $("#cantedt").val('');
            $("#cantedt").removeAttr('disabled','disabled');
            if (this.checked) {
                $("#cantedt").attr('disabled','disabled');
                $("#cantedt").val('0.000');
            }
        });
    });

    $("#listaser").click(function(e){
         $(".deta").hide();
         $(".ins").hide();
    });

    $("#addserpro").click(function(e){
            e.preventDefault();
            var ser=$("#selser").val();
            var pro=$("#selpro").val();
            var cant=$("#cant").val();
            var formdata=$("#formaddserpro").serialize();
            if(pro!=null && cant!='' ){
                $.ajax({
                    url:'serprooper.php',
                    type:'POST',
                    data:'opc=add&'+formdata,
                    dataType:'HTML',
                    success:function(res){
                        if(res=='true'){
                            $("#fucker").val('');
                            $('#selpro').find('option').remove();
                            $('#selpro').append('<option value="0" selected disabled>Seleccione insumo</option>');
                            $("#selpro").selectpicker('refresh');
                            $("#cant").removeAttr('disabled','disabled');
                            $("#reqcant").prop('checked', false).change();
                            $("#formaddserpro")[0].reset();
                            $("#tbserpro").html('');
                            $("#tbserpro").load('tbserpro.php?idser='+ser);
                        }else if(res=='dup'){
                            swal('Error','Este producto ya fue agregado anteriormente! verifique.','error');
                        }
                        else{
                            swal('Error','Ha ocurrido un error inesperado, refresque la página e intentelo nuevamente','error');
                        }
                    }
                });
            }else{
                swal('Atención','Todos los campos son obligatorios para ejecutar esta acción. verifique e intentelo nuevamente.','warning');
            }
    });

    $("#search").keyup(function(e) {
        var txt=$(this).val();
        var ser=$("#selser").val();
        $('#tbserpro').html('');
        $.ajax({
            type: "GET",
            url: "tbserpro.php",
            data: 'idser='+ser+'&filtro='+txt,
        }).done(function (a) {
            $('#tbserpro').html(a);
        }).fail(function () {
            alert('Error al cargar modulo');
        });
    });

    $("#btnactsp").click(function(e){
        e.preventDefault();
        var formdata=$("#formeditsp").serialize();
        var pro=$("#selproedt").val();
        var cant=$("#cantedt").val();
        if(pro!=null && cant!='' ){
            $.ajax({
                url:'serprooper.php',
                data:'opc=upd&'+formdata,
                type:'POST',
                dataType:'HTML',
                success:function(res){
                    if(res=='true'){
                        $("#modaleditserpro").modal('toggle');
                        $("#insumos").click();
                        
                    }else if(res=='dup'){
                            swal('Error','El insumo elegido ya se encuentra relacionado con este servicio, por favor verifique.','error');
                        }
                    else{
                        swal('ERROR','Ha ocurrido un error inesperado, por favor recargue la página e intentelo nuevamente.','error');
                    }
                }
            })
        }else{
            swal('Atención','Todos los campos son obligatorios para ejecutar esta acción. verifique e intentelo nuevamente.','warning');
        }
    });

    $("#insumos").click(function(e){
        var idser=$("#selser").val();
        //$("#selpro").select2('val',null)
        $("#tbserpro").load('tbserpro.php?idser='+idser);
    });

    $('#modaleditserpro').on('hidden.bs.modal', function () {
        $("#formeditsp")[0].reset();
        $("#insumos").click();    
    });
</script>
<script>
    $("#editcat").click(function(e){
        e.preventDefault();
        $("#oldcat").hide();
        $("#newcat").fadeIn();
        $("#switchcat").val(1);
    });
    $("#caneditcat").click(function(e){
        e.preventDefault();
        $("#newcat").hide();
        $("#oldcat").fadeIn();
        $("#switchcat").val(0);
    });

    $("#editcrg").click(function(e){
        e.preventDefault();
        $("#editcrg").hide();
        $("#caneditcrg").fadeIn();
        $("#switchcrg").val(1);
        $("#selcargo").select2("readonly", false);
    });
    $("#caneditcrg").click(function(e){
        e.preventDefault();
        $("#caneditcrg").hide();
        $("#editcrg").fadeIn();
        $("#switchcrg").val(0);
        $("#selcargo").select2("readonly", true);
    });
</script>
</body>
</html>