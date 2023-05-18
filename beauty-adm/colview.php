<?php
include '../cnx_data.php';
    include 'head.php';

  VerificarPrivilegio("COLABORADORES", $_SESSION['tipo_u'], $conn);
?>


<meta charset="utf-8">
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
                    <li>
                        <span>Módulo Colaboradores</span>
                    </li>
                    <li class="active">
                        <a href="colview.php"><span><i class="fa fa-arrow-left"></i> Volver</span></a>
                    </li>
                </ol>
            </div>

             <!-- Modal SERVICIOS POR COLABORADOR ADD-->
<div class="modal fade" style="overflow-x: hidden;
  overflow-y: auto;" tabindex="-1" role="dialog"  id="modalServiciosAdd">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="TituloSalonBase" class="modal-title">Agregar(autorizar) servicios<!--  <a class="btn btn-lg" title="Volver" onclick="$('#modalServiciosAdd').modal('hide'); $('#modalServicios').modal('show'); "><i class="pe-7s-back text-info"></i></a> --></h4>
                <h4 id=""></h4>
            </div>
            <form >     
                <div class="modal-body">
                    <input type="text" name="txtbuscarserviciosAdd" id="txtbuscarserviciosAdd" class="form-control" placeholder="Filtrar por nombre"><div class="help-block"><a class="help-block" onclick="$('#filtrosAdd').attr('hidden', false);">+ filtros</a></div>
<div id="filtrosAdd" hidden>
<div class="row">
    <div class="form-group col-lg-4">
        <select id="selectGrupoAdd" class="form-control">
<?php //include 'conexion.php';
    $sql = "SELECT grucodigo, grunombre FROM btygrupo WHERE gruestado = 1 ORDER BY grunombre";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<option value='0'>--seleccione un grupo--</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['grucodigo']."'>".$row['grunombre']."</option>";
        }
    } else {
       echo "<option value=''>--No hay resultados--</option>"; 
    } ?>
</select>
    </div>
    <div class="form-group col-lg-4">
    <select id="selectSubgrupoAdd" class="form-control">
<?php //include 'conexion.php';
     $sql = "SELECT sbgcodigo, sbgnombre FROM btysubgrupo WHERE sbgestado = 1 ORDER BY sbgnombre";
    $result = $conn->query($sql);
    if(mysqli_query($conn, $sql)){ 
    if ($result->num_rows > 0) {
        echo "<option value='0'>--seleccione un subgrupo--</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['sbgcodigo']."'>".utf8_encode($row['sbgnombre'])."</option>";
        }
    } else {
       echo "<option value=''>--No hay resultados--</option>"; 
    }
    } ?>
</select></div>
    <div class="form-group col-lg-4">
        <select id="selectLineaAdd" class="form-control">
<?php //include 'conexion.php';
     $sql = "SELECT lincodigo, linnombre FROM btylinea WHERE linestado = 1 ORDER BY linnombre";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<option value='0'>--seleccione una linea--</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['lincodigo']."'>".utf8_encode($row['linnombre'])."</option>";
        }
    } else {
       echo "<option value=''>--No hay resultados--</option>"; 
    } ?>
</select> 
    </div>
        <div class="form-group col-lg-4">
        <select id="selectSublineaAdd" class="form-control">
<?php //include 'conexion.php';
     $sql = "SELECT sblcodigo, sblnombre FROM btysublinea WHERE sblestado = 1 ORDER BY sblnombre";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<option value='0'>--seleccione una sublinea--</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['sblcodigo']."'>".utf8_encode($row['sblnombre'])."</option>";
        }
    } else {
       echo "<option value=''>--No hay resultados--</option>"; 
    } ?>
</select>
    </div>
        <div class="form-group col-lg-4">
        <select id="selectCaracteristicaAdd" class="form-control">
<?php //include 'conexion.php';
     $sql = "SELECT crscodigo, crsnombre FROM btycaracteristica WHERE crsestado = 1 ORDER BY crsnombre";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<option value='0'>--seleccione una caracteristica--</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['crscodigo']."'>".utf8_encode($row['crsnombre'])."</option>";
        }
    } else {
       echo "<option value=''>--No hay resultados--</option>"; 
    } ?>
</select>
    </div>
</div>
</div>  <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive" id="divServiciosAdd"></div>
                
            </div>
        </div>
                                    
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="document.getElementById('form_NuevoSalonBase').reset();" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                   <!--  <button type="submit" class="btn btn-success">Guardar</button> -->
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


             <!-- Modal SERVICIOS POR COLABORADOR -->
<div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" id="modalServicios">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="TituloSalonBase" class="modal-title">Servicios autorizados <a class="btn btn-lg" title="Agregar mas servicios" onclick="agregar_servicios();"><i class="fa fa-plus-square-o text-info"></i></a></h4>
                <h4 id=""></h4>
            </div>
            <form >     
                <div class="modal-body">
                    <input type="text" name="txtbuscarservicios" id="txtbuscarservicios" class="form-control" placeholder="Filtrar por nombre"><div class="help-block"><a class="help-block" onclick="$('#filtros').attr('hidden', false);">+ filtros</a></div>
<div id="filtros" hidden>
<input type="hidden" id="txtcodigocolaborador" value="<?php echo $codigoColaborador ?>">
<div class="row">
    <div class="form-group col-lg-4">
        <select id="selectGrupoAutorizados" class="form-control">
<?php //include 'conexion.php';
    $sql = "SELECT grucodigo, grunombre FROM btygrupo WHERE gruestado = 1 ORDER BY grunombre";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<option value='0'>--seleccione un grupo--</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['grucodigo']."'>".$row['grunombre']."</option>";
        }
    } else {
       echo "<option value=''>--No hay resultados--</option>"; 
    } ?>
</select>
    </div>
    <div class="form-group col-lg-4">
    <select id="selectSubgrupoAutorizados" class="form-control">
<?php //include 'conexion.php';
     $sql = "SELECT sbgcodigo, sbgnombre FROM btysubgrupo WHERE sbgestado = 1 ORDER BY sbgnombre";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<option value='0'>--seleccione un subgrupo--</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['sbgcodigo']."'>".utf8_encode($row['sbgnombre'])."</option>";
        }
    } else {
       echo "<option value=''>--No hay resultados--</option>"; 
    } ?>
</select></div>
    <div class="form-group col-lg-4">
        <select id="selectLineaAutorizados" class="form-control">
<?php //include 'conexion.php';
     $sql = "SELECT lincodigo, linnombre FROM btylinea WHERE linestado = 1 ORDER BY linnombre";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<option value='0'>--seleccione una linea--</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['lincodigo']."'>".utf8_encode($row['linnombre'])."</option>";
        }
    } else {
       echo "<option value=''>--No hay resultados--</option>"; 
    } ?>
</select> 
    </div>
        <div class="form-group col-lg-4">
        <select id="selectSublineaAutorizados" class="form-control">
<?php //include 'conexion.php';
     $sql = "SELECT sblcodigo, sblnombre FROM btysublinea WHERE sblestado = 1 ORDER BY sblnombre";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<option value='0'>--seleccione una sublinea--</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['sblcodigo']."'>".utf8_encode($row['sblnombre'])."</option>";
        }
    } else {
       echo "<option value=''>--No hay resultados--</option>"; 
    } ?>
</select>
    </div>
        <div class="form-group col-lg-4">
        <select id="selectCaracteristicaAutorizados" class="form-control">
<?php //include 'conexion.php';
     $sql = "SELECT crscodigo, crsnombre FROM btycaracteristica WHERE crsestado = 1 ORDER BY crsnombre";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<option value='0'>--seleccione una caracteristica--</option>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='".$row['crscodigo']."'>".utf8_encode($row['crsnombre'])."</option>";
        }
    } else {
       echo "<option value=''>--No hay resultados--</option>"; 
    } ?>
</select>
    </div>
</div>  
</div>  
        <div class="table-responsive" id="divServicios">
            
        </div>

                                    
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="document.getElementById('form_NuevoSalonBase').reset();" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <!-- <button type="submit" class="btn btn-success">Guardar</button> -->
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal Salon_base_colaborador -->
             
<div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" id="Modal_SalonBase" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="TituloSalonBase" class="modal-title">Asignar salón base</h4>
                <h4 id="actual"></h4>
            </div>
            <form id="form_NuevoSalonBase" name="form_NuevoSalonBase" method="post" enctype="multipart/form-data">     
                <div class="modal-body">
                <div class="form-group">
                    <label>Sal&oacute;n</label>
                    <select name="selectSalonBase" id="selectSalonBase" class="form-control" required>
                        <?php 
                            //include 'conexion.php';
                            $sql = "SELECT slnnombre, slncodigo FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                // echo '<option value="" selected="selected" disabled>--Seleccione el nuevo Salón base--</option>';
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="'.$row['slncodigo'].'">'.$row['slnnombre'].'</option>';
                                    
                                }
                            } else {
                                echo "<option value=''>--No hay resultados--</option>";
                            }
                        ?>
                    </select>
                    <div id="infoSalon" class="help-block"> 
                        Seleccione nuevo salón base
                    </div>
                </div>
                <div class="form-group">
                    <label>Fecha inicio</label>
                    <input type="text" name="fechaDesde" id="fechaDesde" class="form-control fecha" required>
                    <div id="inf_fecha">
                </div>
                
                    
                </div>
                <div class="form-group">
                    <label>Observaciones</label>
                    <textarea name="observaciones" id="observaciones" class="form-control"></textarea>
                </div>
                <input type="hidden" name="txtSalonBase" id="txtSalonBase">
                <input type="hidden" name="txtFechaUltimo" id="txtFechaUltimo">
                <input type="hidden" name="txtColaborador" id="txtColaborador">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="borrar_fecha();" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--fin  Modal envio por correo -->
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



<!--fin  Modal envio por correo -->

             <!-- Modal Salon_base_colaborador -->
<div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" id="modalFiltrosAvanzados">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="TituloSalonBase" class="modal-title">Búsqueda avanzada</h4>
                <h4 id="actual"></h4>
            </div>
            <form >     
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-3">
                            <label>Cargo</label>
                            <select id="FiltroCargo" class="form-control">
                                <?php
                                //include 'conexion.php';
                                $sql = "SELECT `crgcodigo`, `crgnombre`, `crgalias`, `crgincluircolaturnos`, `crgestado` FROM `btycargo` WHERE crgestado = 1 ORDER BY crgnombre";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    echo "<option value='0'>--Todos--</option>";
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='".$row['crgcodigo']."'>".utf8_encode($row['crgnombre'])."</option>";
                                    }
                                }

                                 ?>
                            </select>
                        </div>
                          <div class="form-group col-lg-3">
                            <label>Perfil</label>
                            <select id="FiltroPerfil" class="form-control">
                                <?php
                                $sql = "SELECT `ctccodigo`, `ctcnombre`, `ctccolor`, `ctcalias`, `ctcestado` FROM `btycategoria_colaborador` WHERE ctcestado = 1 and not ctccodigo = 0 ORDER BY ctcnombre";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    echo "<option value='0'>--Todos--</option>";
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='".$row['ctccodigo']."'>".utf8_encode($row['ctcnombre'])."</option>";
                                    }
                                }

                                 ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label>Salón actual</label>
                            <select id="FiltroSalon" class="form-control">
                            <?php
                                $sql = "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    echo "<option value='0'>--Todos--</option>";
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='".$row['slncodigo']."'>".utf8_encode($row['slnnombre'])."</option>";
                                    }
                                }
                            ?>
                            </select>
                        </div>

                        <div class="form-group col-lg-3">
                            <label>Estado</label>
                            <select id="FiltroEstado" class="form-control">
                            <?php
                                $sql = "SELECT distinct cletipo FROM btyestado_colaborador";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    echo "<option value='0'>--Todos--</option>";
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='".$row['cletipo']."'>".utf8_encode($row['cletipo'])."</option>";
                                    }
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="row" hidden>
                        <div class="form-group col-lg-8">
                            <label>Filtro antiguedad  <a onclick="$('#start').val(''); $('#end').val('');"><i class="fa fa-close text-danger"></i></a></label>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="input-sm form-control fecha" id="start" name="start"/>
                                <span class="input-group-addon">a</span>
                                <input type="text" class="input-sm form-control fecha" id="end" name="end"/>
                            </div>    
                        </div>
                    </div>

                    
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="rango();" class="btn btn-default" data-dismiss="modal">Listo</button> 
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

             <!-- Modal servicios_por_colaborador -->
    <div class="modal fadeIn" tabindex="-1" role="dialog"  aria-hidden="true" id="modal_ser_col">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" onclick="" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="title" class="modal-title">Servicios (colaborador)</h4>
                </div>
                <form id="form_ser_col" name="form_ser_col" method="post" enctype="multipart/form-data">
                     
                    <div class="modal-body">
                    <input type="hidden" name="id_colaborador" id="id_colaborador" value="">
                    <div class="form-group col-lg-6">
                        <label>Grupo</label>
                        <select  id="Grupo" class="form-control" placeholder="Filtrar por grupo" >
                            <?php
                                $sql = "SELECT grucodigo, grunombre FROM btygrupo WHERE gruestado = 1 ORDER BY grunombre";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    echo "<option value=''>--seleccione un grupo--</option>";
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='".$row['grucodigo']."'>".$row['grunombre']."</option>";
                                    }
                                } else {
                                   echo "<option value=''>--No hay resultados--</option>"; 
                                }
                             ?>
                        </select>  
                    </div>
                    <div class="form-group col-lg-6 ">
                        <label>Subgrupos:</label>
                        <select id="Subgrupos" class="js-example-basic-single form-control" placeholder="Filtrar por Subgrupo" >
                        <option value=""></option>
                        </select>   
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Linea:</label>
                        <select id="Linea" name="Linea" class="js-example-basic-single form-control" placeholder="Filtrar por Linea">
                        <option value="">  </option>
    

                        </select>  
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Sublinea:</label>
                        <select id="Sublinea" name="Sublinea" class="js-example-basic-single form-control" placeholder="Filtrar por Sublinea">
                        <option value=""></option>
                    
                        </select> 
                    </div> 
                    <div class="form-group col-lg-6">
                        <label>Caracteristica:</label>
                        <select id="Caracteristica" name="Caracteristica" class="js-example-basic-single form-control" placeholder="Filtrar por Caracteristica">
                        <option value=""></option>
                        </select> 
                    </div> 
                   <div class="form-group col-lg-6">
                   <label>Nombre</label>
                        <input class="form-control" type="tex" name="ser_name" id="ser_name" placeholder="Digite nombre del servicio">
                   </div>
                   <div class="row">
                   <div class="col-lg-12">
                    <div class="table table-responsive" id="table"></div>
                        
                        <?php //include "find_ser_col.php"; ?>
                        </div>
                    </div>
                    </div>
                <input type="hidden" id="codigo" name="codigo">
      <div class="modal-footer">
        <button type="button" onclick="document.getElementById('form_NuevoSalonBase').reset();" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Guardar</button>
       
      </div>
         </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal Estado Colaborador -->
<!-- <div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" id="Modal_estado_col">
    <div class="modal-dialog modal-lg modal_est" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="TituloSalonBase" class="modal-title">Estado de  Colaboradores</h4><button type="button" class="btn btn-success btn-xs pull-left" data-toggle="modal" data-target="#modal_add_new_est_col" title="Añadir estado de Colaborador"><i class="fa fa-plus"></i> </button>
                
            </div>               
            <div class="modal-body">
                <table class="table table-hover table-bordered table-responsive" id="tbl_listado_col" style="width: 100%;">
                    <thead>
                        <tr>
                            <th nowrap>Código</th>
                            <th nowrap>Colaborador</th>
                            <th nowrap>Observaciones</th>
                            <th nowrap>Tipo</th>
                            <th nowrap>Fecha</th>
                            <th nowrap>Estado</th>
                            <th nowrap>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>                
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>/.modal-content
</div>/.modal-dialog -->

<!-- Modal Add nuevo Estado Colaborador -->
<div class="modal fade" tabindex="-1" role="dialog"  aria-hidden="true" id="modal_add_new_est_col">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="TituloSalonBase" class="modal-title">Añadir Estado de Colaborador</h4>
                
            </div>               
            <div class="modal-body">
                <form>
                      <!-- <div class="form-group">
                        <label for="exampleInputEmail1">Colaborador</label>
                        <select id="sel_new_colab" name="selectColaborador" class="js-example-basic-single form-control" placeholder="Nombre del Colaborador" required>
                        </select>
                      </div> -->
                      <input type="hidden" id="codigo_col">
        <input type="hidden" id="consec" name="consec" class="form-control" disabled="" value='<?php $sqll= "SELECT * FROM btyestado_colaborador";
                                  if ($conn->query($sqll)){
                                  $sqlmax = "SELECT MAX(clecodigo) as m FROM `btyestado_colaborador`";
                                  $max = $conn->query($sqlmax);
                                  if ($max->num_rows > 0) {
                                    while ($row = $max->fetch_assoc()) {
                                      $cod = $row['m']+1;
                                    } 
                                  } else {
                                    $cod = 0;
                                    
                                  }
                                }
                                 echo $cod; ?>'>
                      <div class="form-group">
                        <div class="radio">
                         <label class="radio-inline">
                          <input type="radio" name="tipo_estado" value="VINCULADO"> VINCULADO
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="tipo_estado" value="DESVINCULADO"> DESVINCULADO
                        </label>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Fecha</label>
                        <input type="text" class="form-control" id="fecha_add">
                      </div>
                       <div class="form-group">
                        <label for="exampleInputPassword1">Observaciones</label>
                        <textarea name="" id="txt_observaciones" class="form-control" rows="3" required="required"></textarea>
                      </div>
                </form>
            </div>                
        <div class="modal-footer">
            <button type="button" id="guardar_estado_colab" class="btn btn-primary">Añadir</button>
            <button type="button" class="btn btn-default"  data-dismiss="modal" aria-label="Close">Cerrar</button>
        </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

            <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                    <div class="input-group">
                        <input class="form-control" type="text" id="inputbuscar" name="inputbuscar" placeholder="Nombre o documento del colaborador">
                        <div class="input-group-btn">                            
                            <button id="busca" name="busca" class="btn btn-default" title="Búsqueda avanzada" onclick="$('#modalFiltrosAvanzados').modal('show')"><i class="fa fa-search text-info"></i></button>

                            <a href="colaboradores.php"><button class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Nuevo colaborador"><i class="fa fa-plus-square-o text-info"></i>
                                </button></a>
                             <button class="btn btn-default" data-toggle="tooltip" id="btnModalBarcode" data-placement="top" title="Gestionar Colaborador con Lector">
                                <span class="fa fa-barcode text-info"></span>
                            </button>
                            <button class="btn btn-default" data-toggle="tooltip" id="btnReporteExcel" data-placement="top" title="Reporte en Excel">
                                <span class="fa fa-file-excel-o text-info"></span>
                            </button>
                            <button class="btn btn-default" data-toggle="tooltip" id="btnReportePdf" data-placement="bottom" title="Reporte en PDF">
                                <span class="fa fa-file-pdf-o text-info"></span>
                            </button>
                            <button class="btn btn-default" data-toggle="tooltip" id="btnEnvioreporte" data-placement="top" title="Enviar reporte" onclick="$('#modalenviocorreo').modal('show')">
                                <span class=" text-info glyphicon glyphicon-envelope fa-1x"></span>
                            </button>
                            <!-- <button type="button" class="btn btn-default" data-toggle="modal" data-tooltip="tooltip" data-target="#Modal_estado_col" data-toggle="modal" id="btn_estado" data-placement="top" title="Estado">
                                <span class=" text-info glyphicon glyphicon-ok-circle fa-1x"></span>
                            </button> -->



                        </div>
                        <div class="input-group">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

    <div id="find" class="content animate-panel">
        <div class="row">
            <?php  include "find.php";  ?>
        </div>
    </div>



    <!-- Right sidebar -->
    <div id="right-sidebar" class="animated fadeInRight">
        <div class="p-m">
            <button id="sidebar-close" class="right-sidebar-toggle sidebar-button btn btn-default m-b-md"><i class="pe pe-7s-close"></i>
            </button>
            <div>
                <span class="font-bold no-margins"> Analytics </span>
                <br>
                <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
            </div>
            <div class="row m-t-sm m-b-sm">
                <div class="col-lg-6">
                    <h3 class="no-margins font-extra-bold text-success">300,102</h3>

                    <div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
                </div>
                <div class="col-lg-6">
                    <h3 class="no-margins font-extra-bold text-success">280,200</h3>

                    <div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
                </div>
            </div>
            <div class="progress m-t-xs full progress-small">
                <div style="width: 25%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" role="progressbar"
                     class=" progress-bar progress-bar-success">
                    <span class="sr-only">35% Complete (success)</span>
                </div>
            </div>
        </div>
        <!-- <div class="p-m bg-light border-bottom border-top">
            <span class="font-bold no-margins"> Social talks </span>
            <br>
            <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
            <div class="m-t-md">
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="images/a1.jpg" alt="profile-picture">
                        </a>
        
                        <div class="media-body">
                            <span class="font-bold">John Novak</span>
                            <small class="text-muted">21.03.2015</small>
                            <div class="social-content small">
                                Injected humour, or randomised words which don't look even slightly believable.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="images/a3.jpg" alt="profile-picture">
                        </a>
        
                        <div class="media-body">
                            <span class="font-bold">Mark Smith</span>
                            <small class="text-muted">14.04.2015</small>
                            <div class="social-content">
                                Many desktop publishing packages and web page editors.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="images/a4.jpg" alt="profile-picture">
                        </a>
        
                        <div class="media-body">
                            <span class="font-bold">Marica Morgan</span>
                            <small class="text-muted">21.03.2015</small>
        
                            <div class="social-content">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="p-m">
            <span class="font-bold no-margins"> Sales in last week </span>
            <div class="m-t-xs">
                <div class="row">
                    <div class="col-xs-6">
                        <small>Today</small>
                        <h4 class="m-t-xs">$170,20 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                    <div class="col-xs-6">
                        <small>Last week</small>
                        <h4 class="m-t-xs">$580,90 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <small>Today</small>
                        <h4 class="m-t-xs">$620,20 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                    <div class="col-xs-6">
                        <small>Last week</small>
                        <h4 class="m-t-xs">$140,70 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                </div>
            </div>
            <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.
                Many desktop publishing packages and web page editors.
            </small>
        </div>

    </div>

    <!-- Footer-->


</div>
</div>


<!-- Modal Editar estado col-->
<div class="modal fade" id="modalEditarEstColab" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editar Estado Colaborador</h4>
      </div>
      <div class="modal-body">
            <form>
                <input type="hidden" name="" id="est_cod" class="form-control" value="">
                <input type="hidden" id="estado_ini">
                <input type="hidden" id="codigo_cle">
              <div class="form-group">
                <div class="radio">
                 <label class="radio-inline">
                  <input type="radio" name="tipo" id="tip_vin" value="VINCULADO"> VINCULADO
                </label>
                <label class="radio-inline">
                  <input type="radio" name="tipo" id="tip_des" value="DESVINCULADO"> DESVINCULADO
                </label>
                </div>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Fecha</label>
                <input type="text" class="form-control" id="est_fecha" placeholder="">
              </div>
               <div class="form-group">
                <label for="exampleInputPassword1">Observaciones</label>
                <textarea name="" id="est_observaciones" class="form-control" rows="3" required="required"></textarea>
              </div>               
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btn_mod_estado">Guardar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Biometrico-->
<div class="modal fade" id="modalAddBiometrico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Añadir Código Biométrico</h4>
      </div>
      <div class="modal-body">
         <form action="" method="POST" role="form">

            <input type="hidden" id="cod_colaborador"> 
             <div class="form-group">
                 <input type="hidden" disabled class="form-control" id="codiasignado" placeholder="">
             </div>       
             <div class="form-group">
                 <input type="number" class="form-control" id="codbiometrico" placeholder="Digite código">
             </div>
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn_addbio" class="btn btn-primary">Añadir</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Documentos-->
<div id="modal_newdoc" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"">
    <div class="modal-dialog" role="document"> 
        <div class="modal-content" > 

            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                <h5 class="modal-title"><span class="fa fa-file"></span> Cargar Documento</h5> 
                
            </div> 
            <div class="modal-body">
                <div class="row carga">
                    <div class="col-md-10 col-md-push-1">
                        <button id="addti_doc" class="btn btn-info btn-sm pull-left" data-toggle="tooltip" data-placement="right" title="Agregar Tipo de documento"><span class="fa fa-plus"></span></button>
                    </div>
                    <form action="processadjuntocol.php" method="POST" enctype="multipart/form-data" role="form" id="formul" target="contenedor_subir_archivo"> 
                        <input type="hidden" id="codigocol" name="codigocol">
                         <input type="hidden" id="opc" name="opc" value="new">
                        <div class="oculgen carga">
                            <div class="col-md-10 col-md-push-1">
                                
                                <select class="form-control" id="seltidoc" name="seltidoc" required>
                                    <option value="">Seleccione tipo de documento</option>
                                        <?php
                                        //include 'conexion.php';
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
                        <div class="col-md-8 col-md-push-2 oculgen" style="display:none;" id="iconoPDF">
                            <div class="panel-body file-body">
                                <center><i class="fa fa-file-pdf-o text-center" style="color:red;"></i></center>
                            </div>
                            <div class="panel-footer">
                                <h4 id="nomarchivo" class="text-center"></h4>
                            </div>
                        </div>
                        <div id="divuploader" class="col-md-10 col-md-push-1">
                            <div id="area" class="area" style="align-items: center;border: 3px dashed #aaa;border-radius: 5px;color: #555;display: flex;flex-flow: column nowrap;font-size: 15px;justify-content: center;max-height: 200px;margin: 30px auto;overflow: auto;text-align: center;white-space: pre-line;width: 100%;">
                                <i class="fa fa-cloud-upload" style="font-size:40px;"></i>
                                <small id="msj1">Arrastre archivo PDF aquí</small>
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
                            <label class="col-md-4 control-label" for="textinput2">Observaciones/Comentarios</label>  
                            <textarea id="txtobserv" name="txtobserv" class="form-control" style="resize: none;" required></textarea>
                            <br>
                        </div>
                        <div class="col-md-10 col-md-push-1 oculgen carga">
                            <button id="subirarchivo" type="submit" class="btn btn-info pull-right" data-toggle="tooltip" data-placement="top" title="Guardar"><span class="fa fa-save"></span></button>
                            <button id="resetform" class="btn btn-danger pull-right" type="reset" data-toggle="tooltip" data-placement="top" title="Cancelar"><span class="fa fa-remove"></span></button>
                        </div>
                        <div class="col-md-10 col-md-push-1">
                            <h4 id="respuesta"></h4>
                        </div>
                        <iframe width="1" height="1" frameborder="0" name="contenedor_subir_archivo" style="display: none"></iframe>
                    </form>
                </div>
                <div class="row newtidocform" style="display:none;">
                    <div class="col-md-10 col-md-push-1">
                        <button id="btnback" class="btn btn-info"><span class="fa fa-arrow-left" data-toggle="tooltip" data-placement="right" title="Regresar"></span></button>
                    </div>
                    <div class="col-md-10 col-md-push-1">
                        <form class="form-horizontal" id="formnuca">
                            <fieldset>
                            <!-- Form Name -->
                                <legend>Nuevo tipo de documento adjunto</legend>
                                <!-- Text input-->
                                <div class="form-group">
                                  <label class="col-md-4 control-label" for="textinput1">Nombre tipo de adjunto</label>  
                                  <div class="col-md-8">
                                  <input id="textinput1" name="textinput1" type="text" placeholder="ej: Pagaré" class="form-control input-md">
                                  </div>
                                </div>
                                <!-- Text input-->
                                <div class="form-group">
                                  <label class="col-md-4 control-label" for="textinput2">Descripcion del adjunto</label>  
                                  <div class="col-md-8">
                                  <input id="textinput2" name="textinput2" type="text" placeholder="ej: compromiso de Pago" class="form-control input-md">
                                    
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
                <button type="button" class="btn btn-info" data-dismiss="modal" onclick="$('#resetform').click()">Cerrar</button>
            </div> 
        </div> 
    </div>
</div>
<!-- Fin Modal Documentos-->



<!-- Modal EDITAR Documentos-->
<div id="modal_newdoc2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"">
    <div class="modal-dialog" role="document"> 
        <div class="modal-content" > 

            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                <h5 class="modal-title"><span class="fa fa-file"></span> Editar Documento</h5> 
                
            </div> 
            <div class="modal-body">
                <div class="row carga">
                    <form action="processadjuntocol.php" method="POST" enctype="multipart/form-data" role="form" id="formul2" target="contenedor_subir_archivo"> 
                        <input type="hidden" id="daccol" name="daccol">
                         <input type="hidden" id="opc" name="opc" value="upd">
                        <div class="oculgen carga">
                            <div class="col-md-10 col-md-push-1">
                                
                                <select class="form-control" id="seltidoc2" name="seltidoc2" required>
                                    <option value="">Seleccione tipo de documento</option>
                                        <?php
                                        //include 'conexion.php';
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
<!-- FIN Modal EDITAR Documentos-->




<!-- Modal Acceso Web-->
<div class="modal fade" id="modalAccesoWeb" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-globe" aria-hidden="true"></i>  Acceso Web </h4>
      </div>
      <div class="modal-body">
            <input type="hidden" id="accesocodweb">
            <ul class="list-group">                   
                <li class="list-group-item" id="divInput">
                    
                </li> 
                 <li class="list-group-item">
                    <span ><b>Generar Contraseña:</b></span><span id="txtpass"><b></b></span>
                    <div class="material-switch pull-right">
                        <button type="button" class="btn btn-warning pull-right btn-xs" id="btnGenPass"><i class="fa fa-key" aria-hidden="true"></i> </button>
                    </div>
                </li>                   
            </ul>
            </div>            
        </div>
    </div>
</div>

         <!-- <form action="" method="POST" role="form">
         
            <input type="hidden" id="cod_colaborador"> 
             <div class="form-group">
                 <input type="hidden" disabled class="form-control" id="codiasignado" placeholder="">
             </div>       
             <div class="form-group">
                 <input type="number" class="form-control" id="codbiometrico" placeholder="Digite código">
             </div>
         </form> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn_addbio" class="btn btn-primary">Añadir</button>
      </div>
    </div>
  </div>
</div> 

<!-- Modal ver/editar detalles de vinculacion-->
<div class="modal fade" id="modal_tipovinculacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tipo de vinculación</h4>
      </div>
      <div class="modal-body">
            <div class="hpanel">
                <ul class="nav nav-tabs">
                    <li class="active detvinc" ><a data-toggle="tab" id="detvinc" href="#tab-10">  Vinculación Actual</a></li>
                    <li class="newvinc" ><a data-toggle="tab" id="newvinc" href="#tab-20">  Editar vinculación</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div id="tab-10" class="tab-pane active">
                    <div class="panel-body" id="tb_vincactual"></div>
                </div>
                <div id="tab-20" class="tab-pane">
                    <div class="panel-body">
                        <form method="POST" role="form" id="form_vincu">
                            <input type="hidden" id="idcle" name="idcle">

                            <div class="input-group" id="divoldtivin">
                              <div class="input-group-btn"><a><button id="newtivin" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Agregar nuevo tipo de vinculacion"><i class="fa fa-plus-square text-info"></i></button></a></div><select name="seltipovinc" id="seltipovinc" class="form-control" required></select>
                            </div>
                            <div class="input-group col-md-12" style="display:none;" id="divnewtivin">
                                <input class="form-control" type="text" id="txtnewtivin" name="txtnewtivin" placeholder="Digite el nuevo tipo de vinculación y presione guardar...">
                                <div class="input-group-btn">
                                    <a><button id="canceltivin" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Cancelar"><i class="fa fa-times text-danger"></i></button></a>
                                    <a><button id="savetivin" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Guardar nuevo tipo de vinculación"><i class="fa fa-check text-info"></i></button></a>
                                </div>
                            </div>

                            <br>

                            <div class="input-group" id="divoldvin">
                              <div class="input-group-btn"><a><button id="newvin" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Agregar nuevo vinculador"><i class="fa fa-plus-square text-info"></i></button></a></div><select name="selvinculador" id="selvinculador" class="form-control" required></select>
                            </div>
                            <div class="input-group col-md-12" style="display:none;" id="divnewvin">  
                              <input class="form-control" type="text" id="txtnewvin" name="txtnewvin" placeholder="Escriba el nombre del nuevo vinculador y presione guardar...">
                                <div class="input-group-btn">
                                    <a><button id="cancelvin" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Cancelar"><i class="fa fa-times text-danger"></i></button></a>
                                    <a><button id="savevin" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Guardar nuevo vinculador"><i class="fa fa-check text-info"></i></button></a>
                                </div>
                            </div>
                            <br>

                            <div class="form-group" id="divsubmit">
                                 <button type="submit" class="btn btn-default btn-sm pull-right"><i class="fa fa-save text-info"></i></button>
                                 <button type="reset" data-dismiss="modal" class="btn btn-default btn-sm pull-right"><i class="fa fa-times text-danger"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalColabLector" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> Gestionar Colaborador</h4>
      </div>
      <div class="modal-body">
          <form action="" method="POST" role="form">  
                <input type="text" id="dataCaptureDoc" class="form-control" style=" /*border: none; border-color: transparent;color: transparent;*/">

                <div class="row">
                    <div class="col-md-6">                    
                        <div class="form-group">
                            <label for="">Documento</label>
                            <input type="text" class="form-control" readonly id="docColaborador" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="">Nombres</label>
                            <input type="text" class="form-control" readonly id="nomColaborador" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="">Apellidos</label>
                            <input type="text" class="form-control" readonly id="apeColaborador" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="">Fecha de Nacimiento</label>
                            <input type="text" class="form-control" readonly id="fechaColaborador" placeholder="">
                        </div>
                    </div>

                     <div class="col-md-6"> 
                        <div class="form-group">
                            <label for="">Sexo</label>
                            <input type="text" class="form-control" readonly id="sexoColaborador" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="">Tipo de Sangre</label>
                            <input type="text" class="form-control" readonly id="tiposanColaborador" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="">Cargo</label>
                            <select name="" id="cargoColaborador" class="form-control">
                                <option selected value="0">SELECCIONE CARGO</option>
                                <option value="NULL">N/D</option>
                                <?php 
                                    $sql = mysqli_query($conn, "SELECT a.crgcodigo, a.crgnombre FROM btycargo a WHERE a.crgestado = 1 ORDER BY a.crgnombre");

                                    while ($row = mysqli_fetch_array($sql)) 
                                    {
                                        echo '<option value="'.$row['crgcodigo'].'">'.utf8_encode($row['crgnombre']).'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Categoría</label>
                           <select name="" id="txtCatCol" class="form-control">
                                <option selected value="0">SELECCIONE CATEGORÍA</option>
                                <?php 
                                    $sql = mysqli_query($conn, "SELECT a.ctccodigo, a.ctcnombre FROM btycategoria_colaborador a WHERE a.ctcestado = 1 ORDER BY a.ctcnombre");

                                    while ($row = mysqli_fetch_array($sql)) 
                                    {
                                        echo '<option value="'.$row['ctccodigo'].'">'.utf8_encode($row['ctcnombre']).'</option>';
                                    }
                                ?>
                            </select>
                            <input type="text" id="txtCatColaborador" class="form-control" style="display: none">
                        </div>
                    </div>
                </div>
        
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarCol">Guardar</button>
      </div>
    </div>
  </div>
</div>


<style>

    th{
        text-align: center;
    }
    td{
        font-size: .8em!important;
    }

    .modal_est{
        width: 80%;
    }
</style>

<!-- Vendor scripts -->
<?php include "librerias_js.php"; ?>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
<script>
    function loadtivin(){
        $.ajax({
            url:'opervinculacion.php',
            type:'POST',
            data:'opc=loadtivincu',
            success:function(res){
                $("#seltipovinc").html(res);
            }
        })
    }

    function loadvinculador(){
        $.ajax({
            url:'opervinculacion.php',
            type:'POST',
            data:'opc=loadvinculador',
            success:function(res){
                $("#selvinculador").html(res);
            }
        })
    }

    var swhs=1,swhs1=1,swhs2=1;
    $("#newvin").click(function(e){
        e.preventDefault();
        $("#divsubmit").hide();
        $("#divoldvin").hide();
        $("#divnewvin").show();
        $("#txtnewvin").focus();
        swhs1=0;
    })
    $("#newtivin").click(function(e){
        e.preventDefault();
        $("#divsubmit").hide();
        $("#divoldtivin").hide();
        $("#divnewtivin").show();
        $("#txtnewtivin").focus();
        swhs2=0;
    })
    $("#canceltivin").click(function(e){
        e.preventDefault();
        swhs2=1;
        swhs=swhs1*swhs2;
        $("#divoldtivin").show();
        $("#divnewtivin").hide();
        $("#txtnewtivin").val('');
        if(swhs==1){
            $("#divsubmit").show();
        }
    })
    $("#cancelvin").click(function(e){
        e.preventDefault();
        swhs1=1;
        swhs=swhs1*swhs2;
        $("#divoldvin").show();
        $("#divnewvin").hide();
        $("#txtnewvin").val('');
        if(swhs==1){
            $("#divsubmit").show();
        }
    })
    //////////////////////////////////////////////
    $("#savetivin").click(function(e){
        e.preventDefault();
        $("#seltipovinc").empty();
        var tivin=$.trim($("#txtnewtivin").val());
        if(tivin.length>0){
            $.ajax({
                url:'opervinculacion.php',
                type:'POST',
                data:'opc=newtivin&txt='+tivin,
                success:function(res){
                    if(res=='false'){
                        swal('Oops!','Ha ocurrido un error inesperado, por favor refresque la página e intentelo nuevamente.','error');
                    }else{
                        $("#seltipovinc").html(res);
                        $("#canceltivin").click();
                    }
                }
            })
        }else{
            $("#txtnewtivin").focus();
        }
    })
    $("#savevin").click(function(e){
        e.preventDefault();
        $("#selvinculador").empty();
        var vin=$.trim($("#txtnewvin").val());
        if(vin.length>0){
            $.ajax({
                url:'opervinculacion.php',
                type:'POST',
                data:'opc=newvin&txt='+vin,
                success:function(res){
                    if(res=='false'){
                        swal('Oops!','Ha ocurrido un error inesperado, por favor refresque la página e intentelo nuevamente.','error');
                    }else{
                        $("#selvinculador").html(res);
                        $("#cancelvin").click();
                    }
                }
            })
        }else{
            $("#txtnewvin").focus();
        }
    })
    //////////////////////////////////////////////
    $("#modal_tipovinculacion").on("hidden.bs.modal", function () {
        $("#divoldtivin").show();
        $("#divnewtivin").hide();
        $("#divoldvin").show();
        $("#divnewvin").hide();
        $("#divsubmit").show();
        loadtivin();
        loadvinculador();
        swhs=1,swhs1=1,swhs2=1;
    });
</script>
<script>

    $("#form_vincu").submit(function(e){
        e.preventDefault();
        var formdata=$(this).serialize();
        $.ajax({
            url:'opervinculacion.php',
            type:'POST',
            data:'opc=addvincu&'+formdata,
            success:function(res){
                if(res==1){
                    $(".modal").modal('hide');
                }else{
                    swal('Oops!','Ha ocurrido un error inesperado, por favor refresque la página e intentelo nuevamente.','error');
                }
            }
        })


    });
    $("#modal_tipovinculacion").on("hidden.bs.modal", function () {
        $("#tab-20").removeClass('active');
        $("#tab-10").addClass('active');
        $(".newvinc").removeClass('active');
        $(".detvinc").addClass('active');
        $("#form_vincu")[0].reset();
    });
</script>
<script type="text/javascript">
  $('#side-menu').children('.active').removeClass("active");  
  $("#COLABORADORES").addClass("active");
  $("#COLABORADOR").addClass("active");
      $('.fecha').datetimepicker({
    format: "YYYY-MM-DD",
            locale: "es",
  });

    $('#est_fecha').datetimepicker({
        format: "YYYY-MM-DD",

        locale: "es",
    });

     $('#fecha_add').datetimepicker({
        format: "YYYY-MM-DD",
        locale: "es",
    });
</script>
<script type="text/javascript">
     var i=0;
       var arr1 = [];
    function nuevo_salon_base (clb_codigo) {
        $('#txtColaborador').val(clb_codigo);
        var dataString = "codigo="+clb_codigo;
        $.ajax({
            type: "POST",
            url: "get_lastbase.php",
            data: dataString,
            success: function (res) {
                if (res == "") {
                    $('#actual').html("Colaborador no tiene salón base asignado.");
                    $('#txtSalonBase').val(0);
                    $('#txtFechaUltimo').val(0);
                } else {
                    $('#txtSalonBase').val(res.split(",")[0]);
                    $('#txtFechaUltimo').val(res.split(",")[1]);
                    var salon = res.split(",")[2];
                    $('#actual').html("Salón Base: "+salon);
                }
            }
        });

        $('#Modal_SalonBase').modal('show');
    }

    function listar (colaborador) {
        var dato = "codigo="+colaborador;
        $.ajax({
            type: "POST",
            url: "listar_bases.php",
            data: dato,
            success: function (res) {
                $('#table_bases').html(res);
                $('#Modal_SalonBase').modal("hide");
                document.getElementById("form_NuevoSalonBase").reset();
            }
        });
    }


    function listar_estados_col (cod) {
        var cod = $('#codigo_del_col').val();
        var code = $('#est_cod').val();
        var code_col = $('#codigo_col').val();

        $.ajax({
            type: "POST",
            url: "listar_estados_col.php",
            data: {codigo:cod},
            success: function (res) {
                $('#table_estados_col').html(res);
                $('#Modal_SalonBase').modal("hide");
                //document.getElementById("form_NuevoSalonBase").reset();
            }
        });
    }

    function borrar_fecha(){
                    $('#fechaDesde').val("");
                    $('#inf_fecha').css('display', 'none');
                }

    $('#form_NuevoSalonBase').on("submit", function(event) {
        event.preventDefault();
        if ($('#txtFechaUltimo').val() == 0 || ($('#txtFechaUltimo').val() <= $('#fechaDesde').val() && $('#txtSalonBase').val() != $('#selectSalonBase').val())) {
            var datos = new FormData(document.getElementById("form_NuevoSalonBase"));
            $.ajax({
                type: "POST",
                url: "insert_salonBase.php",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (res) {
                    if (res == "TRUE") {
                        listar($('#txtColaborador').val());
                        swal("Nuevo Salón base asignado correctamente.");
                       
                    }
                }
            });
        } else if ($('#txtFechaUltimo').val() >= $('#fechaDesde').val()) {


           $('#inf_fecha').html("<p class='text-danger'>Esta fecha es anterior a la ultima asignacion de sal&oacute;n base para este colaborador.</p>");

        } else if ($('#selectSalonBase').val() == $('#txtSalonBase').val()) {
            $('#infoSalon').html("<p class='text-danger'>Este sal&oacute;n es actualmente el sal&oacute;n base para este colaborador.");

        }  
    });
            function filtrar () {
                $.ajax({
                    type: "POST",
                    url: "find.php",
                    data: {cargo: $('#FiltroCargo').val(), perfil: $('#FiltroPerfil').val(), salonBase: $('#FiltroSalon').val(), estado: $('#FiltroEstado').val(), start: $('#start').val(), end: $('#end').val()},
                    success: function (res) {
                        $('#find').html(res);
                    }
                });
            }
            
            function rango () {
                
            }
        $('#FiltroCargo').change(function() {
            filtrar();
        });
        $('#FiltroPerfil').change(function() {
            filtrar();
        });
        $('#FiltroSalon').change(function() {
            filtrar();
        });
        $('#FiltroEstado').change(function() {
            filtrar();
        });

        $('[data-toggle="modal"][title]').tooltip();
        function formReset () {
            document.getElementById("form_ser_col").reset();    
        }
        function find_gru (cod, tab) {
            $.ajax({
                type: "POST",
                url: "find_gru.php",
                data: {codi: cod, table: tab}
                }).done(function (html) {
                    //alert(html);
                    $('#Grupo').html(html);
                        find_sbg(cod, tab);
                }).fail(function () {
                    alert('Error al cargar modulo');
                });
        }
        function find_sbg (cod, tab){
            $.ajax({
                type: "POST",
                url: "find_sbg.php",
                data: {codi: cod, table: tab}
            }).done(function (html) {
                //alert(html);
                $('#Subgrupos').html(html);
                find_ser(cod, tab);
            }).fail(function () {
                alert('Error al cargar modulo');
                
            });
        }
        function find_ser (cod, tab) {
            var col = $('#id_colaborador').val();
            $.ajax({
                type: "POST",
                url: "find_ser_col.php",
                data: {codi: cod, table: tab, col: col}
            }).done(function (html) {
                //alert(html);
                $('#table').html(html);
            }).fail(function () {
                alert('Error al cargar modulo');
            });   
        }
        function ok () {
            swal({
                title: "servicios agregados correctamente",
                text: "",
                type: "success",
                confirmButtonText: "Aceptar"
            },
            function () {
                $('#table').html("");
            });
        }
        $('#Grupo').change(function () {
            find_ser($(this).val(), "gru");
        });
        $('#Subgrupo').change(function () {
            find_ser($(this).val(), "sbg");
        });
        $('#Linea').change(function () {
            find_ser($(this).val(), "lin");
        });
        $('#Sublinea').change(function () {
            find_ser($(this).val(), "sbl");
        });
        $('#Caracteristica').change(function () {
            find_ser($(this).val(), "crs");
        });
       $('#ser_name').keypress(function(){
             var a = $("#ser_name").val();
             find_ser(a, "NAME");
        }); 
        $("#form_ser_col").on("submit", function(event) {
            event.preventDefault();
            var formData = new FormData(document.getElementById("form_ser_col"));
            $.ajax({
                url: "insert_ser_col.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
                .done(function(res){
                   
                  if (res == "TRUE"){
                        ok ();
                        
                        }
                });
        });
        //Grupo keyup
        $('#s2id_autogen1_search').keyup(function(){
            var a = "grupo_name="+$(this).val();
            $.ajax({
                    type: "POST",
                    url: "find_gru.php",
                    data: a,
                }).done(function (html) {
                    $('#Grupo').html(html);
                    //find_ser(cod, tab);
                }).fail(function () {
                    alert('Error al cargar modulo'); 
                });
        });
        //keyup_subgrupo
        $('#s2id_autogen2_search').keyup(function(){
            var sbg = $(this).val();
            var gru = $('#Grupo').val();
            
            $.ajax({
                    type: "POST",
                    url: "find_sbg.php",
                    data: {subgrupo_name: sbg, grupo_codigo: gru}
                }).done(function (html) {
                    $('#Subgrupos').html(html);
                    //find_ser(cod, tab);
                }).fail(function () {
                    alert('Error al cargar modulo'); 
                });
        });
        //keyup_linea
        $('#s2id_autogen3_search').keyup(function(){
            var lin = $(this).val();
            var sbg = $('#Subgrupos').val();
            $.ajax({
                    type: "POST",
                    url: "find_lin.php",
                    data: {linea_name: lin, sbg_codigo: sbg}
                }).done(function (html) {
                    $('#Linea').html(html);
                    //find_ser(cod, tab);
                }).fail(function () {
                    alert('Error al cargar modulo'); 
                });
        });
        //keyup_sublinea
        $('#s2id_autogen4_search').keyup(function(){
            var lin = $(this).val();
            var sbg = $('#Linea').val();
            $.ajax({
                    type: "POST",
                    url: "find_sbl.php",
                    data: {sbl_name: lin, lin_codigo: sbg}
                }).done(function (html) {
                    $('#Sublinea').html(html);
                    //find_ser(cod, tab);
                }).fail(function () {
                    alert('Error al cargar modulo'); 
                });
        });
        $('.btn-circle').click(function(){
            $('#id_colaborador').val($(this).val());
        });       
</script>
<!-- BUSQUEDA AVANZADA -->

<script>
    //$('#table').jpaginate();

    function enpro (cod) {
        $.ajax({
            url: 'contents.php',
            method: 'GET',
            data: {cod: cod},
            success: function (data) {
                
            }
        });
    }


    function EnviarProgramacion (Email, codigo) {
        if (Email == 0){
            swal({
                title: "Error",
                text: "Colaborador no tiene dirección de correo.",
                type: "warning",
                confirmButtonText: "Aceptar"
                });
        }else{
            swal({
                  title: "Enviar programación",
                  text: "Correo de destino: "+Email,
                  type: "info",
                  showCancelButton: true,
                  confirmButtonText: "Enviar",
                  cancelButtonText: "Cancelar",
                  closeOnConfirm: true
            },
            function(){
                    $.ajax({
                        type: "POST",
                        url: "enviar_programacion.php",
                        data: {email: Email, colaborador: codigo},
                        success: function (res) {
                            if (res == 1 || res == "1") 
                            {
                                swal("Se ha enviado un e-mail a " + Email + " con la programación", "", "success");
                            }
                            else
                            {
                                swal("Hubo un error al enviar el correo. Contacte al administrador.", "", "error");
                            }
                        } 
                    });
            });

        }
    }

    /**/


    function biometricol (cod) 
    {
        $('#modalAddBiometrico').modal('show');
        $('#cod_colaborador').val(cod);

       $.ajax({
            url: 'ingresarBiometrico.php',
            method: 'POST',
            data: {cod:cod, opcion: 'comprobar'},
            success: function (data) 
            {
               var jsonbiometrico = JSON.parse(data);

                if(jsonbiometrico.resultado == "nulo")
                {
                    //$("#codbiometrico").prop("disabled", false);
                    $('#btn_addbio').html("Añadir");
                    $("#btn_addbio").prop("disabled", false);
                    $('#codbiometrico').val("");
                    $('#codiasignado').val("");

                }
                else
                {
                    $('#btn_addbio').html("Modificar");
                    $('#codiasignado').val(jsonbiometrico.bio);
                    $('#codbiometrico').val(jsonbiometrico.bio);
                    //$('#btn_addbio').attr("disabled", "disabled");
                }          

            }
        });
        
    }

    var control=0;
    $(document).on('blur', '#codbiometrico', function() 
    {
        var cod = $('#codbiometrico').val();
        $.ajax({
            url: 'ingresarBiometrico.php',
            method: 'POST',
            data: {codbio:cod, opcion: 'validar'},
            success: function (data) 
            {
               var jsondata = JSON.parse(data);
               if(jsondata.resultado=='exitoso'){
                    control=1;
                     swal("El código N° "+cod+" ya está asignado","", "warning");
               }else{
                    control=0;
               }
            }
        });      
    });

    $(document).on('click', '#btn_addbio', function()
    {
        var codcol = $('#cod_colaborador').val();
        var codbio = $('#codbiometrico').val();

        if(control==0){ 
            if (codbio == "" ) 
            {
                swal("Debe ingresar el código", "", "warning");
            }
            else
            {
                $.ajax({
                    url: 'ingresarBiometrico.php',
                    method: 'POST',
                    data: {codcol:codcol, codbio:codbio, opcion: 'ingreso'},
                    success: function (data) 
                    {
                        if (data == 1) 
                        {
                            swal("Operación Exitosa", "", "success");
                            location.reload();
                        }
                        else
                        {
                            swal("Hubo un error al ingresar el código.", "", "error");
                        }
                    }
                });
            }
        }else{
             swal("El código N° "+codbio+" ya está asignado","verifique que el codigo no esté en uso", "warning");
        }
    });
        
            


    function b (a, b, codigoCola){
        $.ajax({
            type: "POST",
            url: "verificar_acceso.php",
            data: {usu: b, cod_peti: a}
        }).done(function (html) {
          //alert(html);
           if (html == "TRUE"){
                var datos = "codigo="+codigoCola;
                $.ajax({
                    type: "POST",
                    url: "serviciosPorColaborador.php",
                    data: datos,
                    success: function (res) {
                        $('#divServicios').html(res);
                        $('#txtcodigocolaborador').val(codigoCola);
                        $('#modalServicios').modal('show');
                    }
                });
                
                //$('#modal_ser_col').modal('show');
            } else {
                swal({
                    title: "No tienes permiso de ingreso",
                    text: "",
                    type: "warning",
                    confirmButtonText: "Aceptar"
                });
            }
        }).fail(function () {
            alert('Error al cargar modulo');
        });
    }
    function agregar_servicios () {
        var datos = "codigo="+$('#txtcodigocolaborador').val();
        $.ajax({
            type: "POST",
            url: "servicioForColaborador.php",
            data: datos,
            success: function (res) {
                $('#divServiciosAdd').html(res);
                $('#modalServicios').modal('hide');
                $('#modalServiciosAdd').modal('show');
            }
        });
    }
    function detalles(id) {
        $.ajax({
            type: "POST",
            url: "perfil_colaborador.php",
            data: {operacion: 'update', id_colaborador: id}
        }).done(function (a) {
            $('#find').html(a);
        }).fail(function () {
            alert('Error al cargar modulo');
        });
    }



    function editar(id) {
        $.ajax({
            type: "POST",
            url: "update_col.php",
            data: {operacion: 'update', id_colaborador: id}
        }).done(function (a) {
            $('#find').html(a);
        }).fail(function () {
            alert('Error al cargar modulo');
        });
    }

    /****************************************/

    $(document).ready(function() {
       
        $(document).on('submit', '#form_edit_colab', function(e) {

            //formData.append(grupo, cat, tit, sub);
            e.preventDefault();
            var f = $(this);
            var formData = new FormData(document.getElementById("form_edit_colab"));

            //formData.append(f.attr("name"), $(this)[0].files[0]);
              $.ajax({
                  url: "actualizar_col.php",
                  type: "POST",
                  dataType: "html",
                  data: formData,
                  cache: false,
                  contentType: false,
                  processData: false,
                  //beforeSend: function() { },
                  //complete: function()   { },
                  success: function (data) {
                    //alert(data);
                  console.log(data);
                      if (data == 1) {
                          location.reload();
                      }else{
                        if (data == 2) {
                             swal("El formato no es pdf");
                        }
                      }
                  }
              });
        });          
    });




    /*******************************************/
    function paginar(id) {
        $.ajax({
            type: "POST",
            url: "find.php",
            data: {cargo: $('#FiltroCargo').val(), perfil: $('#FiltroPerfil').val(), salonBase: $('#FiltroSalon').val(), page: id},
        }).done(function (a) {
            $('#find').html(a);
        }).fail(function () {
            alert('Error al cargar modulo');
        });
    }
    $(document).ready(function() {
       $('#inputbuscar').keyup(function(){
            var username = $(this).val();        
            var dataString = 'nombre='+username;

            $.ajax({
                type: "POST",
                url: "find.php",
                data: dataString,
                success: function(data) {
                    $('#find').fadeIn(1000).html(data);
                }
            });
        });   
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {    
        $('#no_documento').blur(function(){
            $('#Info').html('').fadeOut(1000);
            var username = $(this).val();        
            var dataString = 'no_documento='+username;
            $.ajax({
                type: "POST",
                url: "check_colaborador.php",
                data: dataString,
                success: function(data) {
                    $('#Info').fadeIn(1000).html(data);
                }
            });
        });

        $("#btnReporteExcel").on("click", function(){

            window.open("./generarReporteColaboradores.php?dato=" + $("#inputbuscar").val() + "&tipoReporte=excel");
        });

        $("#btnReportePdf").on("click", function(){

            window.open("./generarReporteColaboradores.php?dato=" + $("#inputbuscar").val() + "&tipoReporte=pdf");
        });
    });    
</script>

<script type="text/javascript">
    function remover_servicio (codigoSer, codigoCola, este) {
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
                    url: "removerServicio.php",
                    data: {sercodigo: codigoSer, clbcodigo: codigoCola},
                    success: function (res) {
                        if (res == "TRUE") {
                            $(este).parent().parent().remove();
                        }
                    }
                });
            });
    }
    function agregar_servicio (codigoSer, codigoCola, este) {
        swal({
                title: "¿Seguro que desea autorizar este servicio?",
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
                    url: "AddServicioColaborador.php",
                    data: {sercodigo: codigoSer, clbcodigo: codigoCola},
                    success: function (res) {
                        if (res == "TRUE") {
                            $(este).parent().parent().remove();
                        }
                    }
                });
            });
    }
    function paginar_servicios(id, col) {
        $.ajax({
            type: "POST",
            url: "serviciosPorColaborador.php",
            data: {grupo: $('#selectGrupoAutorizados').val(), subgrupo: $('#selectSubgrupoAutorizados').val(), linea: $('#selectLineaAutorizados').val(), sublinea: $('#selectSublineaAutorizados').val(), caracteristica: $('#selectCaracteristicaAutorizados').val(), nombre: $('#txtbuscarservicios').val(), codigo: col, page: id},
            success: function (res) {
                $('#divServicios').html(res);
                $('#sPc').html(res);
            }
        });
    }
    function listar_linea () {
        var datos = "subgrupo="+$('#selectSubgrupoAutorizados').val();
        $.ajax({
            type: "POST",
            url: "filtros_clasificacion.php",
            data: datos,
            success: function (res) {
                $('#selectLineaAutorizados').html('<option>--Escoja un Linea--</option>');
                $('#selectLineaAutorizados').append(res);
                listar_sublinea();

            }
        });
    }
    function listar_sublinea() {
        var datos = "linea="+$('#selectLineaAutorizados').val();
        $.ajax({
            type: "POST",
            url: "filtros_clasificacion.php",
            data: datos,
            success: function (res) {
                $('#selectSublineaAutorizados').html('<option>--Escoja un Sublinea--</option>');
                $('#selectSublineaAutorizados').append(res);
                listar_caracteristicas();
            }
        });
    }
    function listar_caracteristicas () {
        var datos = "sublinea="+$('#selectSublineaAutorizados').val();
        $.ajax({
            type: "POST",
            url: "filtros_clasificacion.php",
            data: datos,
            success: function (res) {
                $('#selectCaracteristicaAutorizados').html('<option>--Escoja un Caracteristica--</option>');
                $('#selectCaracteristicaAutorizados').append(res);

            }
        });
    }
        $('#selectGrupoAutorizados').change(function () {
            var datos = "grupo="+$(this).val();
            $.ajax({
                type: "POST",
                url: "filtros_clasificacion.php",
                data: datos,
                success: function (res) {
                    $('#selectSubgrupoAutorizados').html('<option>--Escoja un subgrupo--</option>');
                    $('#selectSubgrupoAutorizados').append(res);
                        listar_linea();
                }
            });
            $.ajax({
                type: "POST",
                url: "serviciosPorColaborador.php",
                data: {codigo: $('#txtcodigocolaborador').val(), grupo: $(this).val()},
                success: function (res) {
                    $('#divServicios').html(res);
            }
            });
        });
        $('#selectSubgrupoAutorizados').change(function () {
            listar_linea();
            $.ajax({
                type: "POST",
                url: "serviciosPorColaborador.php",
                data: {codigo: $('#txtcodigocolaborador').val(), subgrupo: $(this).val()},
                success: function (res) {
                    $('#divServicios').html(res);
            }
            });
        });
        $('#selectLineaAutorizados').change(function () {
            listar_sublinea();
            $.ajax({
                type: "POST",
                url: "serviciosPorColaborador.php",
                data: {codigo: $('#txtcodigocolaborador').val(), linea: $(this).val()},
                success: function (res) {
                    $('#divServicios').html(res);
            }
            });
        });
        $('#selectSublineaAutorizados').change(function () {
            listar_caracteristicas();
            $.ajax({
                type: "POST",
                url: "serviciosPorColaborador.php",
                data: {codigo: $('#txtcodigocolaborador').val(), sublinea: $(this).val()},
                success: function (res) {
                    $('#divServicios').html(res);
            }
            });
        });
        $('#selectCaracteristicaAutorizados').change(function () {
            $.ajax({
                type: "POST",
                url: "serviciosPorColaborador.php",
                data: {codigo: $('#txtcodigocolaborador').val(), caracteristica: $(this).val()},
                success: function (res) {
                    $('#divServicios').html(res);
            }
            });
        });
        $('#txtbuscarservicios').keyup(function() {
            var dataString = "nombre="+$(this).val();
            $.ajax({
                type: "POST",
                url: "serviciosPorColaborador.php",
                data: {codigo: $('#txtcodigocolaborador').val(), nombre: $(this).val()},
                success: function (res) {
                    $('#divServicios').html(res);
                }
            });
        });
</script>

<!-- SETUP MODAL ADD -->
<script type="text/javascript">


        function paginar_serviciosAdd(id) {
        $.ajax({
            type: "POST",
            url: "servicioForColaborador.php",
            data: {grupo: $('#selectGrupoAdd').val(), subgrupo: $('#selectSubgrupoAdd').val(), linea: $('#selectLineaAdd').val(), sublinea: $('#selectSublineaAdd').val(), caracteristica: $('#selectCaracteristicaAdd').val(), nombre: $('#txtbuscarserviciosAdd').val(), codigo: $('#txtcodigocolaborador').val(),   page: id},
            success: function (res) {
                $('#divServiciosAdd').html(res);
            }
        });
    }
    function listar_lineaAdd () {
        var datos = "subgrupo="+$('#selectSubgrupoAdd').val();
        $.ajax({
            type: "POST",
            url: "filtros_clasificacion.php",
            data: datos,
            success: function (res) {
                $('#selectLineaAdd').html('<option>--Escoja un Linea--</option>');
                $('#selectLineaAdd').append(res);
                listar_sublineaAdd();

            }
        });
    }
    function listar_sublineaAdd() {
        var datos = "linea="+$('#selectLineaAdd').val();
        $.ajax({
            type: "POST",
            url: "filtros_clasificacion.php",
            data: datos,
            success: function (res) {
                $('#selectSublineaAdd').html('<option>--Escoja un Sublinea--</option>');
                $('#selectSublineaAdd').append(res);
                listar_caracteristicasAdd();
            }
        });
    }
    function listar_caracteristicasAdd () {
        var datos = "sublinea="+$('#selectSublineaAdd').val();
        $.ajax({
            type: "POST",
            url: "filtros_clasificacion.php",
            data: datos,
            success: function (res) {
                $('#selectCaracteristicaAdd').html('<option>--Escoja un Caracteristica--</option>');
                $('#selectCaracteristicaAdd').append(res);

            }
        });
    }
        $('#selectGrupoAdd').change(function () {
            var datos = "grupo="+$(this).val();
            $.ajax({
                type: "POST",
                url: "filtros_clasificacion.php",
                data: datos,
                success: function (res) {
                    $('#selectSubgrupoAdd').html('<option>--Escoja un subgrupo--</option>');
                    $('#selectSubgrupoAdd').append(res);
                        listar_lineaAdd();
                }
            });
            $.ajax({
                type: "POST",
                url: "servicioForColaborador.php",
                data: {codigo: $('#txtcodigocolaborador').val(), grupo: $(this).val()},
                success: function (res) {
                    $('#divServiciosAdd').html(res);
            }
            });
        });
        $('#selectSubgrupoAdd').change(function () {
            listar_lineaAdd();
            $.ajax({
                type: "POST",
                url: "servicioForColaborador.php",
                data: {codigo: $('#txtcodigocolaborador').val(), subgrupo: $(this).val()},
                success: function (res) {
                    $('#divServiciosAdd').html(res);
            }
            });
        });
        $('#selectLineaAdd').change(function () {
            listar_sublineaAdd();
            $.ajax({
                type: "POST",
                url: "servicioForColaborador.php",
                data: {codigo: $('#txtcodigocolaborador').val(), sublinea: $(this).val()},
                success: function (res) {
                    $('#divServiciosAdd').html(res);
            }
            });
        });
        $('#selectSublineaAdd').change(function () {
            listar_caracteristicasAdd();
            $.ajax({
                type: "POST",
                url: "servicioForColaborador.php",
                data: {codigo: $('#txtcodigocolaborador').val(), sublinea: $(this).val()},
                success: function (res) {
                    $('#divServiciosAdd').html(res);
            }
            });
        });
        $('#selectCaracteristicaAdd').change(function () {
            $.ajax({
                type: "POST",
                url: "servicioForColaborador.php",
                data: {codigo: $('#txtcodigocolaborador').val(), caracteristica: $(this).val()},
                success: function (res) {
                    $('#divServiciosAdd').html(res);
            }
            });
        });
        $('#txtbuscarserviciosAdd').keyup(function() {
            var dataString = "nombre="+$(this).val();
            $.ajax({
                type: "POST",
                url: "servicioForColaborador.php",
                data: {codigo: $('#txtcodigocolaborador').val(), nombre: $(this).val()},
                success: function (res) {
                    $('#divServiciosAdd').html(res);
                }
            });
        });
        

        //adicion de codigo romario 
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
     url: "enviar_por_correo_colaboradores.php",
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
                     url: "generarReporteColaboradores.php",
                     data: {envio: 1, dato:$("#inputbuscar").val()},
                     success: function(data) {
                      alert(data);
                     }
                    });
            }); 
          $('#rptx').on("click", function(){
               $.ajax({
                     async: false,
                     type: "POST",
                     url: "generarReporteColaboradores.php",
                     data: {enviox: 1, dato:$("#inputbuscar").val()},
                     success: function(data) {
                      alert(data);
                     }
                    });
            }); 
</script>


<script>
    $(document).ready(function() {
        $(".js-example-basic-single").select2();
        $('#s2id_autogen5_search').keyup(function(){
            $.ajax({
                type: "POST",
                url: "load_col_estado.php",
                success: function (res) {
                    $('#sel_new_colab').html(res);
                }
            });
        });



    $(document).on('click', '#btn_edit_col', function() {
        var cod = $(this).data("id");
        var fecha = $(this).data("fecha");
        var cod_oculto = $(this).parents("tr").find("td").eq(0).text();
            $('#codigo_del_col').val(cod);

          $.ajax({
            url: 'editar_estado_colaborador.php',
            method: 'POST',
            data: {cod: cod, fecha: fecha,cod_oculto:cod_oculto},
            success: function (data) {
              var array = eval(data);
            console.log(array);
                    for(var i in array){
                      $("#tip_vin").prop('checked', false);
                      $("#tip_des").prop('checked', false);
                      $('#est_cod').val(array[i].cod);
                      $('#est_fecha').val(array[i].fec);
                      $('#est_observaciones').val(array[i].obs);
                      $('#codigo_cle').val(array[i].codigo);
                      if (array[i].tip == 'VINCULADO') {
                            $("#tip_vin").prop("checked", true);
                      }else{
                            $('#tip_des').prop("checked", true);
                      }
                    }
            }
          });
     });

    $(document).on('click', '#btn_mod_estado', function() {
         var cod            = $('#est_cod').val(); 
         var fecha          = $('#est_fecha').val();
         var obser          = $('#est_observaciones').val();
         var tipo           = $('input[name="tipo"]:checked').val();
         var estado         = $('#estado_ini').val();
         var codigo_cle     = $('#codigo_cle').val();
         var codigo_del_col = $('#codigo_del_col').val();

         $.ajax({
            url: 'update_estado_colaborador.php',
            method: 'POST',
            data: {c: cod, f:fecha, o:obser, t: tipo, estado:estado, codigo_cle:codigo_cle},
            success: function (data) {            
                var array = eval(data);
                for(var i in array){
                    if (array[i].query == 1) {
                        listar_estados_col(array[i].codigo);
                        swal("Estado de colaborador actualizado", "", "success");                    
                        $('#modalEditarEstColab').modal("hide");
                    }
                }

                
            }
         });

    });

    $(document).on('click', '#btn_add_new_col', function(e) {
            var cod = $(this).data("id");
            //alert(cod);
            $('#codigo_del_col').val(cod);
            $('#codigo_col').val(cod);  

    });

    $(document).on('click', '#btn_newdoc', function(e) {
            var cod = $(this).data("id");
            $('#codigocol').val(cod);
      

    });



    $(document).on('click', '#guardar_estado_colab', function(event) {
           // var consec  = $('#consec').val();
            var cod     = $('#codigo_col').val();
            var tipo    = $('input[name="tipo_estado"]:checked').val();
            var fecha   = $('#fecha_add').val();
            var obser   = $('#txt_observaciones').val();

            if (!$('input[name="tipo_estado"]').is(':checked')) {
                    alert('Seleccione uno');
            } else {
               
                if (fecha == "") {
                    swal("Ingrese la fecha");
                    $('#fecha_add').focus();
                }else{
                        $.ajax({
                            url: 'add_nuevo_colaborador_est.php',
                            method: 'POST',
                            data: {cod: cod, f:fecha, o:obser, tipo:tipo},
                            success: function (data) {
                                if (data == 1) {
                                    swal("Ya existe un estado registrado para la fecha registrada.");
                                }else{
                                    swal("Ingreso correcto");
                                    $('#modal_add_new_est_col').modal("hide");
                                    listar_estados_col(cod);

                                }
                            }
                        });
                }
            }
    });


    $(document).on('click', '#btn_elim_col', function() {
        var id    = $(this).data("id");
        var fecha = $(this).data("fecha");
        var cod   = $(this).data("id");



        swal({
           title: "¿Desea eliminar estado del colaborador?",
           type: "warning",
           showCancelButton: true,
           confirmButtonColor: "#DD6B55",
           confirmButtonText: "Eliminar",
           closeOnConfirm: false,
           cancelButtonText: "Cancelar"
        },
          function(){
              console.log(id + fecha);
                $.ajax({
                    url: 'eliminar_estado_col.php',
                    method: 'POST',
                    data: {id:id, fecha:fecha},
                    success: function (data) {
                        if (data == 1) {
                            listar_estados_col(id,cod);            
                            swal("Eliminado!", "Se ha eliminado el estado", "success");   
                        }
                    }
                });
         });
    });



    $(document).on('click', '.btn_cod_c_', function() {
                var id = $(this).data("cod_col");
                $('#txtColaborador').val(id);
    });


    });//fin ready


    /***********************************/


    function accesoweb (codcol) 
    {
        $('#accesocodweb').val(codcol);
        $.ajax({
            url: 'accessColWeb/process.php',
            method: 'POST',
            data: {opcion: "loadSwitch", codcol:codcol},
            success: function (data) 
            {
                $('#txtpass').html("");
                $('#divInput').empty();
                if (data == 1) 
                {
                    $('#divInput').append('<span id="habaccess"><b>Acceso Deshabilitado</b></span><div class="material-switch pull-right"><input id="checkaccess" name="someSwitchOption001" type="checkbox"/><label for="checkaccess" class="label-primary"></label></div>');                
                }
                else
                {
                    $('#divInput').append('<span id="habaccess"><b>Accesso Habilitado</b></span><div class="material-switch pull-right"><input id="checkaccess" name="someSwitchOption001" type="checkbox" checked/><label for="checkaccess" class="label-primary"></label></div>');
                }
            }
        });
        $('#modalAccesoWeb').modal("show");
    }


    /*$(document).on('click', '#btnaccweb', function() 
    {

    });*/

    $(document).on('change', '#checkaccess', function() 
    {
        var codcol = $('#accesocodweb').val();
        if ($(this).is(':checked')) 
        {
            $.ajax({
                url: 'accessColWeb/process.php',
                method: 'POST',
                data: {opcion: "changeState", codcol:codcol},
                success: function (data) 
                {
                    $('#habaccess').html('');
                    if (data == 1) 
                    {
                        $('#habaccess').html("<b>Acceso Habilitado</b>");
                    }
                    else
                    {
                        $('#habaccess').html("<b>Accesso Deshabilitado</b>");
                    }
                }
            });
        }
        else
        {
            $.ajax({
                url: 'accessColWeb/process.php',
                method: 'POST',
                data: {opcion: "changeState", codcol:codcol},
                success: function (data) 
                {
                    $('#habaccess').html('');
                    if (data == 2) 
                    {
                        $('#habaccess').html("<b>Accesso Deshabilitado</b>");
                    }
                    else
                    {
                        $('#habaccess').html("<b>Acceso Habilitado</b>");
                    }
                }
            });
        }
    });



    $(document).on('click', '#btnGenPass', function() 
    { 
        var codcol = $('#accesocodweb').val();

        $.ajax({
            url: 'accessColWeb/process.php',
            method: 'POST',
            data: {opcion: "genPass", codcol:codcol},
            success: function (data) 
            {
                var jsonPass = JSON.parse(data);

                $('#txtpass').html('<span style="color: #149dff"><b> '+jsonPass.des+'</b></span> ');
            }
        });
    });


    /**
     *
     * NUEVO COLABORADOR LECTOR DOC
     *
     */


$(document).on('click', '#btnModalBarcode', function() 
 {
        $('#modalColabLector').modal('show');
});
    
$('#modalColabLector').on('shown.bs.modal', function () 
{
    $('#dataCaptureDoc').focus();
}); 

$(document).on('keydown','#dataCaptureDoc',function (e) {
    var code = (e.which);
        if(code===13)
        {

            var str = $('#dataCaptureDoc').val();

            var co=0;
            var j=0;
            var c=str.length;


            for(i=0;i<c;i++)
            {
                j=i+1;
                if(str.substring(i,j)=='@')
                {
                    co++;
                }
            }

    

            if (co != 8 || co != '8') 
            {
                alert("Error en la lectura. " + "\n" + "Intente desconectar/conectar el lector.");    
            }
            else
            {
                var rese = str.split("@");

                var doc = parseInt(rese[1]);

                var anio = rese[7].substring(0, 4);
                var mes  = rese[7].substring(4, 6);
                var dia  = rese[7].substring(6, 8);
                var cumple = anio + "-"+ mes + "-" + dia;

                if (rese[6] == 'M') 
                {
                    var sexo = 'MASCULINO';
                }
                else
                {
                    sexo = 'FEMENINO';
                }
                

                $('#docColaborador').val(doc);
                $('#nomColaborador').val(rese[4].trim() + " " + rese[5].trim());
                $('#apeColaborador').val(rese[2].trim() + " " + rese[3].trim());
                $('#fechaColaborador').val(cumple);
                $('#sexoColaborador').val(sexo);
                $('#tiposanColaborador').val(rese[8]);

            }
      }
}); 

$('#modalColabLector').on('show.bs.modal', function (e) {
    $('#txtCatCol').css("display", "block");
   $('#txtCatCol option:contains("SELECCIONE CATEGORÍA")').prop('selected',true);
});

$('#modalColabLector').on('hidden.bs.modal', function (e) {
    $('#docColaborador').val('');
    $('#nomColaborador').val('');
    $('#apeColaborador').val('');
    $('#fechaColaborador').val('');
    $('#sexoColaborador').val('');
    $('#tiposanColaborador').val('');
    $('#cargoColaborador option:contains("SELECCIONE CARGO")').prop('selected',true);
    $('#txtCatColaborador').css('display', 'none');
    $('#txtCatCol option:contains("SELECCIONE CATEGORÍA")').prop('selected',true);
    $('#dataCaptureDoc').val('');
});



$(document).on('change', '#cargoColaborador', function() 
{
   var crg = $('#cargoColaborador').val();

       if (crg == 'NULL') 
       {
           $('#txtCatCol').css('display', 'none');
           $('#txtCatColaborador').css('display', 'block');
           $('#txtCatColaborador').val('N/D');
           $('#txtCatColaborador').attr('readonly', true);
       }
       else
       {
           $('#txtCatCol').css('display', 'block');
           $('#txtCatColaborador').css('display', 'none');
           $('#txtCatColaborador').val('');
           $('#txtCatCol option:contains("SELECCIONE CATEGORÍA")').prop('selected',true);
       }
}); 


/**
 *
 * GUARDAR COLABORADOR
 *
 */

$(document).on('click', '#btnGuardarCol', function() 
{
    var documento = $('#docColaborador').val();
    var nombres   = $('#nomColaborador').val();
    var apellidos = $('#apeColaborador').val();
    var fecha     = $('#fechaColaborador').val();
    var sexo      = $('#sexoColaborador').val();
    var tiposan   = $('#tiposanColaborador').val();

        if ($('#cargoColaborador').val() != 'NULL') 
        {
            var cargo = $('#cargoColaborador').val();
        }
        else
        {
             cargo = null;
        }

        if ($('#txtCatCol').val() != 'NULL') 
        {
            var cate = $('#txtCatCol').val();
        }
        else
        {
            cate = null;
        }
});


    /*************************/


$(document).ready(function() {
    conteoPermisos ();
});
     
</script>


</body>
</html>

<style>
        .material-switch > input[type="checkbox"] {
            display: none!important;   
            }

    .material-switch > label {
        cursor: pointer!important;
        height: 0px!important;
        position: relative!important; 
        width: 40px!important;  
    }

    .material-switch > label::before {
        background: rgb(0, 0, 0)!important;
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5)!important;
        border-radius: 8px!important;
        content: '';
        height: 16px!important;
        margin-top: -8px!important;
        position:absolute!important;
        opacity: 0.3!important;
        transition: all 0.4s ease-in-out!important;
        width: 40px!important;
    }
    .material-switch > label::after {
        background: rgb(255, 255, 255)!important;
        border-radius: 16px!important;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3)!important;
        content: '';
        height: 24px!important;
        left: -4px!important;
        margin-top: -8px!important;
        position: absolute!important;
        top: -4px!important;
        transition: all 0.3s ease-in-out!important;
        width: 24px!important;
    }
    .material-switch > input[type="checkbox"]:checked + label::before {
        background: inherit!important;
        opacity: 0.5!important;
    }
    .material-switch > input[type="checkbox"]:checked + label::after {
        background: inherit!important;
        left: 20px!important;
    }
</style>