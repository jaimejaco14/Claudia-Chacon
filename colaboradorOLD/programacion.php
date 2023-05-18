<?php 
	include("head.php");
	include("librerias_js.php");
?>

<link rel="stylesheet" type="text/css" href="js/select2-4.0.1.min.css">


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

          <li><a href="inicio.php">Inicio</a></li>
          <li class="active">
          <span>Programación</span>
          </li>
        </ol>
      </div>
      <div class="col-md-6">
        <h3>PROGRAMACIÓN</h3>
        <div class="row">
          <div class="input-group">
                <input class="form-control" type="text" id="fecha" name="inputbuscar" placeholder="Buscar por fecha">
                <div class="input-group-btn">           
                    <button id="busca" name="busca" class="btn btn-default"><i class="fa fa-search text-info"></i></button>
                </div>
                <div class="input-group">
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="content animate-panel" >

    <div class="row" id="listadoProg">
          
    </div>
    <div class="row">
        <center><ul class="pagination" id="paginacion">

        </ul></center>
    </div>

</div>

<script src="js/programacion.js"></script>
<script src="js/select2-4.0.1.min.js"></script>

<style>
  .select2-no-results 
  {
      display: none !important;
  }

  .idservicio{
    display: none;
  }
</style>