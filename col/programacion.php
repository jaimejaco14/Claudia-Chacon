<?php 
	include("head.php");
	include("librerias_js.php");
?>

<link rel="stylesheet" type="text/css" href="js/select2-4.0.1.min.css">


<div class="normalheader transition  small-header">
  <div class="hpanel">
    <div class="panel-body">
      <div id="hbreadcrumb" class="pull-right m-t-lg">
        <ol class="hbreadcrumb breadcrumb">

          <li><a href="inicio.php">Inicio</a></li>
          <li class="active">
          <span>Programación</span>
          </li>
        </ol>
      </div>
      <div class="col-md-12">
        <h3>PROGRAMACIÓN</h3>
        <div class="row">
          <div class="">
            <input class="form-control" type="text" id="fecha" name="inputbuscar" placeholder="Buscar por fecha">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="container-fluid" >

    <div class="row" id="listadoProg">
          
    </div>
    <div class="row">
        <center><ul class="pagination" id="paginacion">

        </ul></center>
    </div>

</div>
<?php include 'footer.php'; ?>
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