<?php 
	include("head.php");
	include("librerias_js.php");
?>


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
                    <li><a href="inicio.php">Inicio</a></li>
                    <li class="active">
                        <span>Biométrico</span>

                    </li>
                </ol>
            </div>
            <div class="col-md-12">
            	<h3>BIOMÉTRICO <a href="javascript:void(0)" id="btnUpdate" title="Actualizar Listado"><i class="pe-7s-refresh"></i></a></h3>

                <div class="row">
                  <div class="col-md-6">
	                  	<input class="form-control" type="text" id="fechaIni" name="fecha" placeholder="0000-00-00">                    
                  </div>
                </div>
                <br>
                 <div class="row">
                  <div class="col-md-6">
                      <input class="form-control" type="text" id="fechaFin" name="fecha" placeholder="0000-00-00">                  
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-6">
                      <select name="" id="selTipo" class="form-control" required="required">
                            <option value="0" selected>SELECCIONE TIPO DE NOVEDAD</option>
                            <option value="X">TODOS</option>
                            <?php 
                              $sql = mysqli_query($conn, "SELECT a.aptcodigo, a.aptnombre FROM btyasistencia_procesada_tipo a WHERE a.aptestado = 1 ORDER BY a.aptnombre ");

                              while ($row = mysqli_fetch_array($sql)) 
                              {
                                echo '<option value="'.$row['aptcodigo'].'">'.utf8_encode($row['aptnombre']).'</option>';
                              }
                            ?>
                      </select>                 
                  </div>
                </div>       
                  
            </div>
    </div>
</div>


<div class="content animate-panel">
  <div class="row">
    <div class="col-lg-12">
        <div class="hpanel">
            <div class="panel-body">
               <div class="panel panel-info">
                 <div class="panel-heading">
                   <h3 class="panel-title" id="listCount">LISTADO

                      
                   </h3>
                 </div>
                 <div class="panel-body">
                   <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tblBiometrico" style="width: 100%">
                    <!-- <span class="pull-right" id="counNov"></span> -->
                      <thead>
                        <tr>
                          <th>TIPO NOVEDAD</th>
                          <th>TURNO</th>
                          <th>FECHA</th>
                          <th>HORA</th>
                          <th>DIFERENCIA</th>
                          <th>COSTO</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                      </tbody>
                    </table>
               </div>
                 </div>
               </div>
            </div>
        </div>
    </div>
</div>
</div>

<style>
  td{
      font-size: .9em;
      white-space: nowrap;
  }
  
</style>

<script src="js/biometrico.js"></script>