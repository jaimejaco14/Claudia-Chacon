<?php
    include("./head.php");
    include '../cnx_data.php';

    VerificarPrivilegio("USUARIO", $_SESSION['tipo_u'], $conn);
    RevisarLogin();
?>
<div class="content">

<!-- MODAL VISTA -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_ver_datos">
    <div class="modal-dialog" role="document">
    <form id="form_update_user">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="title" class="modal-title">Informacion del usuario. <a onclick="editar ();" ><i class="pe-7s-note"></i> </a></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label>Nombres</label>
                        <input type="text" id="view_nombre" name="view_nombre" class="form-control text-uppercase" onchange="$(this).val() = $(this).val().toUpperCase();" required readonly>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Apellidos</label>
                        <input type="text" id="view_apellido" name="view_apellido" class="form-control text-uppercase" onchange="$(this).val() = $(this).val().toUpperCase();" required readonly>
                    </div>
                    <div id="tdi" class="form-group col-lg-6">
                        <label>Tipo documento</label>
                        <input type="text" id="view_tdi" name="view_tdi" class="form-control" required readonly>
                    </div>
                    <div id="tdi2" class="form-group col-lg-6" hidden>
                        <label>Tipo documento</label>
                        <select class="form-control" name="combo_tdi" id="combo_tdi">
                            <?php
                            $sql  = "select tdicodigo, tdinombre from btytipodocumento";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value=".$row['tdicodigo'].">".$row['tdinombre']."</option>";   
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>No. documento</label>
                        <input type="text" id="view_documento" name="view_documento" class="form-control" required readonly>
                        
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Tel&eacute;fono fijo</label>
                        <input type="text" id="view_fijo" name="view_fijo" class="form-control" required readonly>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Tel&eacute;fono m&oacute;vil</label>
                        <input type="text" id="view_movil" name="view_movil" class="form-control" required readonly>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Usuario</label>
                        <input type="text" name="view_usu" id="view_usu" id="view_usu" class="form-control" required readonly>
                        <div id="Infoviewuser" class="help-block with-errors"></div>
                    </div>
                    <div id="divtiu" class="form-group col-lg-6">
                        <label>Perfil</label>
                        <input type="text" id="view_tiu" name="view_tiu" class="form-control" required readonly>
                    </div>
                    <div id="tiu2" class="form-group col-lg-6" hidden>
                        <label>Perfil</label>
                        <select class="form-control" id="combo_tiu" name="combo_tiu">
                            <?php
                            $sql  = "select tiucodigo, tiunombre from btytipousuario";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value=".$row['tiucodigo'].">".$row['tiunombre']."</option>";   
                                }
                            }
                            ?>
                        </select>   
                    </div>
                    <div class="form-group col-lg-12">
                        <label>Email</label>
                        <input type="text" id="view_email" name="view_email" class="form-control text-uppercase" onchange="$(this).val() = $(this).val().toUpperCase();" required readonly>
                    </div>
                    <div class="form-group col-lg-6">
                        <label>Direcci&oacute;n</label>
                        <input type="text" id="view_dir" name="view_dir" class="form-control text-uppercase" onchange="$(this).val() = $(this).val().toUpperCase();" required readonly>
                    </div>
                    <div class="form-group col-lg-6" id="brr">
                        <label>Barrio</label>
                        <input type="text" id="view_brr" class="form-control" readonly>
                        <div hidden>
                            <select class="form-control" id="combo_brr" disabled>
                                <?php
                                    $sql  = "select brrcodigo, brrnombre from btybarrio";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value=".$row['brrcodigo'].">".$row['brrnombre']."</option>";   
                                        }
                                    }
                                ?>
                            </select>    
                        </div>
                    </div>
                    <div id="location" hidden>
                        <div class="form-group col-lg-12">
                            <label>Departamento</label>
                            <select class="form-control" id="combo_dep" required>
                                <?php
                                    $sql  = "select depcodigo, depombre from btydepartamento where depstado = 1 and not depcodigo = 0";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        $sw = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            if ($sw == 0) {
                                                $dep = $row['depcodigo'];
                                                $sw = 1;
                                            }
                                            echo "<option value=".$row['depcodigo'].">".$row['depombre']."</option>";   
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Ciudad</label>
                            <select class="form-control" id="combo_ciudad" require>
                                <?php
                                    $sql  = "select loccodigo, locnombre from btylocalidad where locstado = 1 and depcodigo = ".$dep." and not loccodigo = 0";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        $sw = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            if ($sw == 0) {
                                                $loc = $row['loccodigo'];
                                                $sw = 1;
                                            }
                                            echo "<option value=".$row['loccodigo'].">".$row['locnombre']."</option>";   
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Barrio</label>
                            <select class="form-control" id="combo_barrio" name="combo_barrio" required>
                                <?php
                                    $sql  = "select brrcodigo, brrnombre from btybarrio where brrstado = 1 and loccodigo = ".$loc." and not brrcodigo = 0";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        $sw = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            if ($sw == 0) {
                                                $loc = $row['depcodigo'];
                                                $sw = 1;
                                            }
                                            echo "<option value=".$row['brrcodigo'].">".$row['brrnombre']."</option>";   
                                        }
                                    }
                                ?>
                            </select>
                        </div> 
                    </div>
                </div>
            </div>
            <div id="foot" hidden class="modal-footer">
               <button type="submit" class="btn btn-success">Guardar</button> 
            </div>    
        </div>
        </form>
    </div>
</div>

<!-- MODAL VISTA -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal_ver_datos">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="title" class="modal-title"></h4>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>


<div>
</div>

<div class="content">
    <div class="">
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                    </div>
                    M&Oacute;DULO DE USUARIO
                </div>
                <div class="panel-body">
                    <div>

                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#divHorario" aria-controls="divHorario" role="tab" data-toggle="tab">USUARIO</a></li>
                        <li role="presentation"><a href="#divHorarioSalon" aria-controls="divHorarioSalon" role="tab" data-toggle="tab">CREAR NUEVO</a></li>
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="divHorario">
                            <br>
                            <div >
                                <br>
                                <div class="hpanel">
                                    <div class="panel-body">
                                        <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                        <div class="input-group">
                                                            <input type="text" name="input_buscar" id="input_buscar" class="form-control" value="" placeholder="Nombre, usuario o documento del usuario">
                                                            <div class="input-group-btn">
                                                                
                                                                  <a><button id="btn" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Buscar..."><i class="fa fa-search text-info"></i></button></a>
                                                             
                                                            </div>
                                                            <div class="input-group">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>          
                            </div>
                           
                                
                            <div id="contenido" >
                                <?php include "find_usuarios.php"; ?>   
                            </div>
                            
                        </div>
                    </div>  
                    <div role="tabpanel" class="tab-pane fade" id="divHorarioSalon">
                        <br>
                            <div class="row">
                                <div class="col-lg-10">
                                   <!--  <div class="hpanel">
                                        <div class="panel-heading">
                                            <div class="panel-tools">
                                                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                                                <a class="closebox"><i class="fa fa-times"></i></a>
                                            </div>
                                            Datos usuario
                                        </div> -->
                                        <!-- <div class="panel-body"> -->
                                            <form name="simpleForm" id="simpleForm"  onsubmit="return validate_password()" method="post">
                                                <div class="text-center m-b-md" id="wizardControl">

                                                    <a class="btn btn-default" href="#step1" data-toggle="tab"> 1 - Datos pernonales</a>
                                                    <a class="btn btn-default" href="#step2" data-toggle="tab"> 2 - Datos de usuario</a>
                                                </div>
                                                <div class="tab-content">
                                                    <div id="step1" class="p-m tab-pane active">
                                                        
                                                        <div class="row">
                                                            <div class="form-group col-lg-6">
                                                                <label>Tipo de Documento</label>
                                                                <select  class="form-control" name="tipo_documento" id="tipo_documento" data-error="Escoja una opcion" required="NIT, CC, TI, CE">
                                                                    <?php
                                                                        include '../cnx_data.php';
                                                                        $result = $conn->query("SELECT tdicodigo, tdialias FROM btytipodocumento");
                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) {                
                                                                                echo '<option value="'.$row['tdicodigo'].'">'.$row['tdialias'].'</option>';
                                                                            }
                                                                        }
                                                                        $conn->close();
                                                                    ?>
                                                                </select>
                                                                <div class="help-block with-errors"></div>
                                                            </div> <!-- TIPO DE DOCUMENTO -->
                                                            <div class="form-group col-lg-6 ">
                                                                <label>Numero de documento</label>
                                                                    <div class="input-group">
                                                                        <input   type="number" class="form-control" name="no_documento" id="no_documento" placeholder="Numero de documento" data-error="Este campo es obligatorio y solo debe contener numeros" required >
                                                                    <div class="input-group-btn">
                                                                        <input  style="width: 70px"  type="text" class="form-control" pattern="[0-9]" maxlength="1" name="dv" id="dv" data-error="Este campo es obligatorio y solo debe contener numeros" readonly required >
                                                                    </div>
                                                                        
                                                                    </div>
                                                                    <div id="Info" ></div>
                                                            </div>  
                                                        </div>
                                                         <div class="row">
                                                            <div class="form-group col-lg-6" id="divnombre" required>
                                                                <label>Nombres</label>
                                                                <input class="form-control text-uppercase" name="nombres" id="nombres" onchange="this.value=this.value.toUpperCase();" placeholder="Digite sus nombres" data-error="Campo obligatorio" required>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                            <div class="form-group col-lg-6" id="divapellido" required>
                                                                <label>Apellidos</label>
                                                                <input  class="form-control" name="apellidos"  id="apellidos" onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();" data-error="Campo obligatorio" placeholder="digite sus apellidos" required>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row"> 
                                                            <div class="form-group col-lg-12">
                                                                <label>Departamento</label>
                                                                <select  zize="30" class="form-control" name="dep" id="dep" data-error="Escoja una opcion" required>
                                                                    <?php
                                                                        include '../cnx_data.php';
                                                                        $result = $conn->query("SELECT depcodigo, depombre FROM btydepartamento");
                                                                        if ($result->num_rows > 0) {
                                                                            $sw = 0;
                                                                            while ($row = $result->fetch_assoc()) {
                                                                                if ($sw == 0) {
                                                                                    $depa = $row['depcodigo'];
                                                                                    $sw = 1;
                                                                                }  
                                                                                echo '<option value="'.$row['depcodigo'].'">'.$row['depombre'].'</option>';
                                                                            }
                                                                        }
                                                                        $conn->close();
                                                                    ?>
                                                                </select>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                            <div class="form-group col-lg-12">
                                                                <label> Ciudad </label>
                                                                <select  zize="30" class="form-control" name="ciudad" id="ciudad" data-error="Escoja una opcion" required>
                                                                    <?php
                                                                        include '../cnx_data.php';
                                                                        $result = $conn->query("SELECT loccodigo, locnombre FROM btylocalidad where depcodigo = $depa");
                                                                        if ($result->num_rows > 0) {
                                                                            $sw = 0;
                                                                            while ($row = $result->fetch_assoc()) { 
                                                                            if ($sw == 0) {
                                                                                    $ciu = $row['loccodigo'];
                                                                                    $sw = 1;
                                                                                }                 
                                                                                echo '<option value="'.$row['loccodigo'].'">'.$row['locnombre'].'</option>';
                                                                            }
                                                                        }
                                                                        $conn->close();
                                                                    ?>
                                                                </select>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                            <div class="form-group col-lg-12">
                                                                <label> Barrio </label>
                                                                    <select zize="30" class="form-control" name="barrio" id="barrio" data-error="Escoja una opcion" required>
                                                                        <?php
                                                                        include '../cnx_data.php';
                                                                        $result = $conn->query("SELECT brrcodigo, brrnombre FROM btybarrio where loccodigo = $ciu");
                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) { 
                                                                                echo '<option value="'.$row['brrcodigo'].'">'.$row['brrnombre'].'</option>';
                                                                            }
                                                                        }
                                                                        $conn->close();
                                                                        ?>
                                                                    </select>
                                                                    <div class="help-block with-errors"></div>
                                                            </div>
                                                            <div class="form-group col-lg-12">
                                                                <label>Direccion</label>
                                                                <input  class="form-control" name="direccion" id="direccion" onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ejemplo: CLL 01 kr 02 - 03" data-error="Campo obligatorio" required>
                                                                <div class="help-block with-errors"></div>
                                                            </div>                    
                                                            <div class="form-group col-lg-6">
                                                                <label>Telefono movil</label>
                                                                <input  class="form-control" type="number" name="telefono_movil" id="telefono_movil" placeholder="Ingrese numero de telefono" data-error="camp obligatorio" required>
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                            <div class="form-group col-lg-6">
                                                                <label>Telefono fijo</label>
                                                                <input  class="form-control" type="number" name="telefono_fijo" id="telefono_fijo" placeholder="Ingrese numero de telefono" required>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="text-right m-t-xs">   
                                                            <a class="btn btn-default next" href="#step2" data-toggle="tab">Siguiente</a>
                                                            <!--<button class="btn btn-success submitWizard" type="submit">Guardar</button>-->
                                                        </div>
                                                    </div>
                                                    <div id="step2" class="p-m tab-pane"> 
                                                        <div class="row">
                                                                                <!--<div class="col-lg-3 text-center">
                                                                                    
                                                                                   
                                                                                    <i class="pe-7s-user fa-5x text-muted"></i>
                                                                                    <p class="small m-t-md">
                                                                                        <strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.
                                                                                        <br/><br/>Lorem Ipsum has been the industry's dummy text of the printing and typesetting
                                                                                    </p>
                                                                                </div>-->
                                                            <div class="col-lg-12">
                                                                <div class="row">
                                                                    <div class="form-group col-lg-12">
                                                                        <label>Tipo usuario</label>
                                                                        <select  zize="30" class="form-control" name="tiu" id="tiu" data-error="Escoja una opcion" required>
                                                                            <?php
                                                                            include '../cnx_data.php';
                                                                            $result = $conn->query("SELECT tiucodigo, tiunombre FROM btytipousuario where tiuestado = 1");
                                                                            if ($result->num_rows > 0) {
                                                                                while ($row = $result->fetch_assoc()) {                
                                                                                    echo '<option value="'.$row['tiucodigo'].'">'.$row['tiunombre'].'</option>';
                                                                                }
                                                                            }
                                                                            $conn->close();
                                                                            ?>
                                                                        </select>
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                    <div class="form-group col-lg-12">
                                                                        <label>Usuario</label>
                                                                        <input maxlength="50" id="username" class="form-control" name="username" placeholder="username" required>
                                                                        <div id="Infouser" class="help-block with-errors"></div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="col-lg-6">
                                                                            <label>Contraseña</label>
                                                                            <input type="password"   class="form-control"  placeholder="******" id="password" name="password" required>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <label>confirmar</label>
                                                                            <input type="password"   class="form-control"  placeholder="******" id="confirmar" name="confirmar" required>
                                                                        </div>
                                                                        <div id="val" style="color:#f00;" class="help-block with-errors"></div>
                                                                        <div id="" ></div>
                                                                    </div>
                                                                    <div class="form-group col-lg-12">
                                                                        <label for="inputEmail" class="control-label">Email</label>
                                                                        <input  type="email" class="form-control" name="email" onchange="this.value=this.value.toUpperCase();"  pattern="[a-zA-Z0-9]+[.[a-zA-Z0-9_-]+]*@[a-z0-9][\\w\\.-]*[a-z0-9]\\.[a-z][a-z\\.]*[a-z]$" id="email" placeholder="Email" data-error="Ingrese un direccion de correo valida" required=".">
                                                                        <div class="help-block with-errors"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-right m-t-xs">
                                                            <a class="btn btn-default prev" href="#step1" data-toggle="tab">Anterior</a>
                                                           <button onclick="verif();" id="almacenar" class="btn btn-success submitWizard" type="submit">Guardar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="m-t-md">
                                            </div>
                                        <!-- </div> -->
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    </div>

     
            </div>


<!-- Modal -->
<div class="modal fade" id="modalLoginusuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Acceso de usuarios a salones</h4>
      </div>
      <div class="modal-body">
        <form>
            <input type="hidden" id="codigo_usuario">
          <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
         Asignar hora
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
         <form>
            <input type="hidden" id="codigo_usuario">
          <div class="form-group">
            <label for="exampleInputPassword1">Seleccione Salón</label>
            <select name="" id="sel_salones_acceso" class="form-control">
                <option value=""></option>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputFile">Desde</label>
            <input type="text" id="fecha_desde" class="form-control">
          </div>
          <div class="form-group">
            <label for="exampleInputFile">Hasta</label>
            <input type="text" id="fecha_hasta" class="form-control">
          </div>
          <div class="checkbox">
            <label>
              <input type="checkbox" id="fecha_indefinida" value="null"> Infefinido
            </label>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Ver histórico
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
       <hr>
         <table class="table table-hover table-bordered" id="tbl_login_acceso" style="width: 100%!important">
          <thead>
              <tr>
                  <th style="display:none">cod_usu</th>
                  <th style="display:none">cod_sln</th>
                  <th nowrap>Salón</th>
                  <th nowrap>Desde</th>
                  <th nowrap>Hasta</th>
                  <th style="display:none">estado</th>
                  <th nowrap>Opciones</th>
              </tr>
          </thead>
          <tbody>
              
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>
        </form>
        
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn_guardar_acceso_usu" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>

<style>
 .sorting_1, .salon, .estado{
    display: none;
 }
 td{
    font-size: 11px;
    white-space: nowrap;
 }
</style>        


<?php
include "librerias_js.php";
?>
<script>
    $('#side-menu').children('.active').removeClass("active");
    $("#USUARIOS").addClass("active");
    $("#USUARIO").addClass("active");

</script>
<script src="scripts/privilegios.js"></script>
<script type="text/javascript">
<!--
$('[title]').tooltip();
function validate_password() {
    //Cogemos los valores actuales del formulario
    pasNew1=document.simpleForm.password;
    pasNew2=document.simpleForm.confirmar;
    //Cogemos los id's para mostrar los posibles errores
    id_epassActual=document.getElementById("epasswordActual");
    id_epassNew=document.getElementById("epasswordNew1");

    //Patron para los numeros
    var patron1=new RegExp("[0-9]+");
    //Patron para las letras
    var patron2=new RegExp("[a-zA-Z]+");

    var patron3=new RegExp("[A-Z]+");
    if(pasNew1.value==pasNew2.value && pasNew1.value.length >= 8 &&  pasNew1.value.search(patron1) >=0 && pasNew1.value.search(patron2) >=0 && pasNew1.value.search(patron3)>=0 ){
        //Todo correcto!!!
        return true;
    }else{
        if(pasNew1.value.length<8) {
            $('#val').html("La longitud mínima tiene que ser de 8 caracteres"); 
        } else if(pasNew1.value != pasNew2.value) {
            $('#val').html("La copia de la nueva contraseña no coincide");
        } else if(pasNew1.value.search(patron1) < 0 || pasNew1.value.search(patron2)<0) {
            $('#val').html("La contraseña tiene que tener numeros y letras");
        } else if(pasNew1.value.search(patron3)<0) {
            $('#val').html("La contraseña tiene que tener mayusculas");
        }
        return false;
    }
}
-->
function estado_usuario (code, action) {
    var texto = "Usuario activado.";
    if (action == 0) {
        texto = "Usuario desactivado."
    }
    $.ajax({
        type: "POST",
        url: "switch_user.php",
        data: {sw: action, codigo: code},
        success: function(res) {
            if (res == "TRUE") {
                ok(texto);
            }
        }
    });
}
    $('#combo_dep').change(function(){
        var depa = $(this).val();
        var depart = 'ciudad='+depa;
        $.ajax({
            type: "POST",
            url: "buscar_ciudad.php",
            data: depart,
            success: function(data) {
                $('#combo_ciudad').html(data);
                brr_1 ();
            }
        });
    });
    $('#combo_ciudad').change(function(){
        brr_1 ();
    });
    function brr_1 () {
        var cod_brr = $('#combo_ciudad').val();
        var brr = 'barrio='+cod_brr;
        $.ajax({
            type: "POST",
            url: "buscar_barrio.php",
            data: brr,
            success: function(data) {
                $('#combo_barrio').html(data);
            }   
        });
    }
function Reset_pass (code) {
        swal({
          title: "¿Desea restablecer la contraseña de este usuario?",
          text: "",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Sí",
          closeOnConfirm: false
        },
    function(){
        var dataString = "cod="+code;
        $.ajax({
            type: "POST",
            url: "reset_pass.php",
            data: dataString,
            success: function(data) {
                if(data=='NOAUT'){ 
                    swal("NO AUTORIZADO", "Su usuario no tiene privilegios para cambiar claves de otros usuarios", "error");
                }else{
                    swal("Clave restablecida.", "La nueva clave para el usuario es "+data.split(",")[1], "success");
                }
            }
        });
    });
}
function Visualizar_datos (code) {
    var dataString = "codigo="+code;
    $.ajax({
        type: "POST",
        url: "get_users.php",
        data: dataString,
        success: function (res){
            //definier esstado de los controles
                $('#view_nombre').attr("readonly",true);
                $('#view_apellido').attr("readonly",true);
                $('#view_usu').attr("readonly",true);
                $('#view_dir').attr("readonly",true);
                $('#view_fijo').attr("readonly",true);
                $('#view_movil').attr("readonly",true);
                $('#view_email').attr("readonly",true);
                $('#divtiu').attr("hidden",false);
                $('#tiu2').attr("hidden",true);
                $('#location').attr("hidden",true);
                $('#brr').attr("hidden",false);
                $('#foot').attr("hidden",true);

            $('#view_nombre').val(res.split(",")[1]);
            $('#view_apellido').val(res.split(",")[2]);
            $('#view_documento').val(res.split(",")[4]);
            $('#view_tdi').val($('#combo_tdi option[value="'+res.split(",")[3]+'"]').text());
            $('#combo_tdi option[value="'+res.split(",")[3]+'"]').attr('selected', 'selected');
            $('#view_brr').val($('#combo_brr option[value="'+res.split(",")[6]+'"]').text());
            $('#view_tiu').val($('#combo_tiu option[value="'+res.split(",")[10]+'"]').text());
            $('#combo_tiu option[value="'+res.split(",")[10]+'"]').attr('selected', 'selected');
            $('#view_usu').val(res.split(",")[5]);
            $('#view_dir').val(res.split(",")[7]);
            $('#view_fijo').val(res.split(",")[8]);
            $('#view_movil').val(res.split(",")[9]);
            $('#view_email').val(res.split(",")[11]);
            $('#modal_ver_datos').modal("show");

        }
    });
}
function editar() {
    $('#view_nombre').attr("readonly",true);
    $('#view_apellido').attr("readonly",true);
    $('#view_usu').attr("readonly",false);
    $('#view_dir').attr("readonly",false);
    $('#view_fijo').attr("readonly",false);
    $('#view_movil').attr("readonly",false);
    $('#view_email').attr("readonly",false);
    $('#divtiu').attr("hidden",true);
    $('#tiu2').attr("hidden",false);
    $('#location').attr("hidden",false);
    $('#brr').attr("hidden",true);
    $('#foot').attr("hidden",false);

}
function call_editar (codigo) {
    Visualizar_datos(codigo);
    editar();

}
$('#form_update_user').on("submit", function(event) {
    event.preventDefault();
    var formData = new FormData(document.getElementById("form_update_user"));
    $.ajax({
        url: "actualizar_usuario.php",
        type: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (res) {
            if (res == "TRUE") {
                ok("Usuario actualizado.");
            }
        }
    });
});
   $('#view_usu').keyup(function(){
        var user = $(this).val();        
        var dataString = 'usulogin='+user;
        $.ajax({
            type: "POST",
            url: "check_usuario.php",
            data: dataString,
            success: function(data) {
                if (data) {
                $('#foot').hide();
                $('#Infoviewuser').html(data);
                }else{
                $('#Infoviewuser').html(data);
                $('#foot').show();
            }
            }
        });
    });
</script>
<script type="text/javascript">
function ok(titulo) {
    // "Usuario creado correctamente"
    swal({
        title: titulo,
        text: "",
        type: "success",
        confirmButtonText: "Aceptar"
    },
    function () {
        window.location = "new_usuario.php";
    });
}
 function verif () {
    
     if ($('#no_documento').val()=="" || $('#nombres').val()=="" || $('#apellidos').val()=="" || $('#direccion').val()=="" || $('#telefono_movil').val()=="" || $('#telefono_fijo').val()=="")
     {
        swal("Error", "Has dejado campos vacios", "error");
     } 
     
 }
$("#simpleForm").on("submit", function(event) {
            event.preventDefault();
            if (validate_password() == true) {
            var f = $(this);
            var formData = new FormData(document.getElementById("simpleForm"));
            formData.append("dato", "valor");
            //formData.append(f.attr("name"), $(this)[0].files[0]);
            $.ajax({
                url: "insert_usuario.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            }).done(function(res){
                  if (res == "TRUE"){
                    
                          ok ("Usuario creado.");
                        }
                }).false(function () {
                alert('Error al cargar modulo'); 
            });
                
            } else {
            }

            });
    $('#no_documento').blur(function(){
        var user = $(this).val();        
        var dataString = 'user_cod='+user;
        $.ajax({
            type: "POST",
            url: "check_usuario.php",
            data: dataString,
            success: function(data) {
                if (data == "TRUE") {
                      $('#nombres').attr('readonly', true);
                        $('#apellidos').attr('readonly', true);
                        $('#tipo_documento').attr('disabled', true);
                        $('#barrio').attr('disabled', true);
                        $('#ciudad').attr('disabled', true);
                        $('#dep').attr('disabled', true);
                        $('#direccion').attr('readonly', true);
                        $('#telefono_movil').attr('readonly', true);
                        $('#telefono_fijo').attr('readonly', true); 
                        $('#almacenar').hide();
                    $('#Info').html('<div id="Error" > <input tipo="text" hidden required /> <font color="red"> Ya existe un usuario con este documento</font></div>');
                } else if (data[0] > 0) {
                        $('#Info').html('');
                        $('#nombres').val(data.split(",")[3]);
                        $('#nombres').attr('readonly', true);
                        $('#apellidos').attr('readonly', true);
                        $('#apellidos').val(data.split(",")[4]); //
                        $('#tipo_documento option[value="'+data.split(",")[0]+'"]').attr('selected', 'selected');
                        $('#tipo_documento').attr('disabled', true);
                        $('#barrio option[value="'+data.split(",")[9]+'"]').attr('selected', 'selected');
                        $('#barrio').attr('disabled', true);
                        $('#ciudad').attr('disabled', true);
                        $('#dep').attr('disabled', true);
                        $('#direccion').attr('readonly', true);
                        $('#direccion').val(data.split(",")[6]);
                        $('#telefono_movil').val(data.split(",")[8]);
                        $('#telefono_fijo').val(data.split(",")[7]);
                        $('#telefono_movil').attr('readonly', true);
                        $('#telefono_fijo').attr('readonly', true);               
                        $('#Info').html("");
                        $('#almacenar').show();
                } else if (data == "FALSE") {
                    $('#Info').html('');
                    $('#nombres').attr('readonly', false);
                    $('#apellidos').attr('readonly', false);
                    $('#barrio').attr('disabled', false);
                    $('#ciudad').attr('disabled', false);
                    $('#dep').attr('disabled', false);
                    $('#telefono_movil').attr('readonly', false);
                    $('#telefono_fijo').attr('readonly', false);
                    $('#direccion').attr('readonly', false);
                    $('#tipo_documento').attr('disabled', false);
                    $('#nombres').val("");
                    $('#apellidos').val("");
                    $('#telefono_movil').val("");
                    $('#telefono_fijo').val("");
                    $('#direccion').val("");
                    $('#almacenar').show();


                }else{
                      $('#Info').html('');
                    $('#nombres').attr('readonly', false);
                    $('#apellidos').attr('readonly', false);
                    $('#barrio').attr('disabled', false);
                    $('#ciudad').attr('disabled', false);
                    $('#dep').attr('disabled', false);
                    $('#telefono_movil').attr('readonly', false);
                    $('#telefono_fijo').attr('readonly', false);
                    $('#direccion').attr('readonly', false);
                    $('#tipo_documento').attr('disabled', false);
                    $('#nombres').val("");
                    $('#apellidos').val("");
                    $('#telefono_movil').val("");
                    $('#telefono_fijo').val("");
                    $('#direccion').val("");
                    $('#almacenar').show();

                }
            }
        });
        $.ajax({
            type: "POST",
            url: "dv.php",
            data: dataString,
            success: function(data) {
                $('#dv').val(data);
            }
        });
    });
    $('#username').blur(function(){
        var user = $(this).val();        
        var dataString = 'usulogin='+user;
        $.ajax({
            type: "POST",
            url: "check_usuario.php",
            data: dataString,
            success: function(data) {
                if (data) {
                $('#almacenar').hide();
                $('#Infouser').html(data);
                }else{
                $('#Infouser').html(data);
                $('#almacenar').show();
            }
                
            }
        });
    });
    $('#dep').change(function(){
        var depa = $(this).val();
        var depart = 'ciudad='+depa;
        $.ajax({
            type: "POST",
            url: "buscar_ciudad.php",
            data: depart,
            success: function(data) {
                $('#ciudad').html(data);
                brr ();
            }
        });
    });
    $('#ciudad').change(function(){
        brr ();
    });
    function brr () {
        var cod_brr = $('#ciudad').val();
        var brr = 'barrio='+cod_brr;
        $.ajax({
            type: "POST",
            url: "buscar_barrio.php",
            data: brr,
            success: function(data) {
                $('#barrio').html(data);
            }
        });
    }
    $('#input_buscar').keyup(function() {
        var dataString = "name="+$(this).val();
        $.ajax({
            type: "POST",
            url: "find_usuarios.php",
            data: dataString,
            success: function(res) {
                $('#contenido').html(res);
            }
        });
    });
    function paginar(id) {
    $.ajax({
        type: "POST",
        url: "find_usuarios.php",
        data: {operacion: 'update', page: id}
    }).done(function (a) {
        $('#contenido').html(a);
    }).false(function () {
        alert('Error al cargar modulo');
    });
}

/*============================================
=            USUARIO LOGIN ACCESO            =
============================================*/

$(document).ready(function() {
    load_sln_acceso ();
    tbl_login_acceso();
    $('#tbl_login_acceso_length label').css("font-size: .8em");
});




function load_sln_acceso () {
    $.ajax({
        url: 'cargar_sln_acceso.php',
        success: function (data) {
            $('#sel_salones_acceso').html(data);
        }
    });
}

$('#fecha_desde').datetimepicker({
     locale: 'es',
     format: 'YYYY-MM-DD',
      minDate:new Date()
});

$('#fecha_hasta').datetimepicker({
     locale: 'es',
     format: 'YYYY-MM-DD',
     minDate:new Date()
});

$("#fecha_indefinida").on( 'change', function() {
    if( $(this).is(':checked') ) {
       $('#fecha_hasta').css("display", "none");
       $('#fecha_hasta').val("");
    }
});

$(document).on('click', '#btn_guardar_acceso_usu', function() {
     var cod_usuario        = $('#codigo_usuario').val();
     var salon              = $('#sel_salones_acceso').val();   
     var fecha_desde        = $('#fecha_desde').val();
     var fecha_hasta        = $('#fecha_hasta').val();
     $('#fecha_hasta').css("display", "block");

      //$("#tbl_login_acceso tbody .odd").find("td:eq(2)").css( "display", "none" );
     
    if( $('#fecha_indefinida').is(':checked') ) {
         $('#fecha_hasta').css("display", "none");
         $('#fecha_hasta').val("");
         var fecha_indefinida = $('#fecha_indefinida').val();
    }else{
         //$('#fecha_hasta').css("display", "none");
    }

    if (salon == 0) {
        swal("Seleccione el salón");
    }

    $.ajax({
        url: 'guardar_usuario_acceso.php',
        method: 'POST',
        data: {cod_usuario:cod_usuario, salon: salon, fecha_desde:fecha_desde, fecha_hasta: fecha_hasta, fecha_indefinida:fecha_indefinida},
        success: function (data) {
           if (data == 0) {
               swal("Ya tiene una asignación en curso en este salon.", "Verifique de nuevo", "error");
               //$('#modalLoginusuario').modal("hide");
               $('#sel_salones_acceso').val("Seleccione");
               $('#fecha_desde').val("");
               $('#fecha_hasta').val("");
               $('input:checkbox').removeAttr('checked');
           }else{
              if (data == 1) {
                swal("Ya hay una asignacion dentro de este rango de fechas", "Debe eliminar fecha", "error");
                $('#modalLoginusuario').modal("hide");
                $('#sel_salones_acceso').val("Seleccione");
                $('#fecha_desde').val("");
                $('#fecha_hasta').val("");
                $('input:checkbox').removeAttr('checked');
              }else{
                 if (data == 2) {
                     swal("Se ha ingresado rango de fecha", "Exitoso", "success");
                        //$('#modalLoginusuario').modal("hide");
                        $('#sel_salones_acceso').val("Seleccione");
                        $('#fecha_desde').val("");
                        $('#fecha_hasta').val("");
                        $('input:checkbox').removeAttr('checked');
                        $('#fecha_hasta').css("display", "block");
                     tbl_login_acceso ();
                 }else{
                      if (data == 3) {
                        swal("Se ha ingresado un rango de fecha", "Exitoso", "success");
                        //$('#modalLoginusuario').modal("hide");
                        $('#sel_salones_acceso').val("Seleccione");
                        $('#fecha_desde').val("");
                        $('#fecha_hasta').val("");
                        $('input:checkbox').removeAttr('checked'); 
                        $('#fecha_hasta').css("display", "block");
                        tbl_login_acceso ();
                      }
                 }
              }
           } 
        }
    });



});




//$('#tbl_login_acceso tbody .odd').find("td").eq(1).css( "display", "none" );

$(document).on('click', '#btn_acceso_salones', function() {
        var codigo_usuario = $(this).data("cod_usuario");
        $('#modalLoginusuario').modal("show");
        //$('body').removeClass("modal-open");
        //$('body').removeAttr("style");
        $('#codigo_usuario').val(codigo_usuario);
        tbl_login_acceso();
});

var  tbl_login_acceso  = function() { 
//$("#tbl_login_acceso tbody tr td:nth-child(1)").css( "display", "none" );
//$("#tbl_login_acceso tbody .odd").find("td:eq(2)").css( "display", "none" );
    var id = $('#codigo_usuario').val();
   
       var tbl_est = $('#tbl_login_acceso').DataTable({
        "ajax": {
          "method": "POST",
          "data": {id:id},
          "url": "listado_acceso_salon.php",
          },
          "columns":[
            {"data": "usucodigo"},
            {"data": "slncodigo"},
            {"data": "slnnombre"},
            {"data": "fec_des",
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {                    
                $(nTd).html("<center><span class='label label-success'>"+oData.fec_des+"</span></center>");       
            }
            },
            {"data": "fec_has",
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    if (oData.fec_has == null) {
                         $(nTd).html("<center><span class='label label-primary'>Indefinido</span></center>");
                    }else{
                         $(nTd).html("<center><span class='label label-warning'>"+oData.fec_has+"</span></center>");
                    }
            }
            },
            {"data": "ussestado"},
            {"defaultContent": "<button class='btn btn-danger btn-xs' id='btn_elim_asig' type='button' title='Eliminar Aignación' style='margin-right: 7px'><i class='fa fa-trash text-info' style='color: #FFF'></i></button><button class='btn btn-info btn-xs' id='btn_terminar_asig' type='button' title='Finalizar Asignación'><i class='fa fa-check text-info' style='color: #FFF'></i></button>"},

          ],"language":{
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrada de _MAX_ registros)",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search": "Buscar:",
            "zeroRecords":    "No se encontraron registros coincidentes",
            "paginate": {
              "next":       "Siguiente",
              "previous":   "Anterior"
            } 
            },  
                 
            "order": [[0, "desc"]],
             "bDestroy": true,

            "columnDefs": [
                { className: "salon", "targets": [1] },
                { className: "estado", "targets": [5] }
            ]
      });
};

$(document).on('click', '#btn_elim_asig', function() {
    var $row = $(this).closest("tr");    // Find the row
    var $id = $row.find(".sorting_1").text(); // Find the text
    var $cod_sal = $row.find(".salon").text();
    var cod_sal = $cod_sal;
    var cod_usu = $id;
    swal({
          title: "¿Desea eliminar asignación?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Eliminar",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm){
          if (isConfirm) {
            $.ajax({
                url: 'asignacion_eliminar.php',
                method: 'POST',
                data: {cod_sal:cod_sal, cod_usu:cod_usu},
                success: function (data) {
                    if (data == 1) {
                        swal("Eliminado!", "Se ha eliminado la asignación.", "success");
                        tbl_login_acceso();
                        //$('#modalLoginusuario').modal("hide");
                    }
                }
            });
          }else{
            swal("Cancelado");
          } 
        });
 });

$('#tbl_login_acceso tbody').on('click', '#btn_terminar_asig', function() {
       var $row = $(this).closest("tr");    // Find the row
       var $id = $row.find(".salon").text(); // Find the text

       var $usu = $row.find(".sorting_1").text(); // Find the text
       
       var usu = $usu;
       var cod = $id;

       $.ajax({
            url: 'finalizar_asignacion_salon_usuario.php',
            method: 'POST',
            data: {usu: usu, cod: cod},
            success: function (data) {
                if (data == 1) {
                    swal("Se ha finalizado el permiso al salón.");
                    tbl_login_acceso();
                }
            }
       });
    
});











/*=====  End of USUARIO LOGIN ACCESO  ======*/




</script>
</body>
</html>