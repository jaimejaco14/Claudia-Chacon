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
          <span>Servicios</span>
          </li>
        </ol>
      </div>
      <div class="col-md-9">
        <div class="row">
          <div class="col-lg-12">
              <h3>SERVICIOS</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="content">
  <div class="row">
    <div class="col-lg-12">
        <div class="hpanel">
            <div class="panel-body">
               <div class="panel panel-info">
                 <div class="panel-heading">
                   <h3 class="panel-title">LISTADO
                      <?php 
                          $Query = mysqli_query($conn, "SELECT a.sercodigo, a.sernombre, a.serdescripcion, CONCAT(a.serduracion, ' MIN') AS serduracion, b.crsnombre FROM btyservicio_colaborador c JOIN btyservicio a ON c.sercodigo=a.sercodigo JOIN btycaracteristica b ON a.crscodigo=b.crscodigo WHERE c.clbcodigo = '".$_SESSION['clbcodigo']."' ORDER BY a.sernombre ");

                          $count = mysqli_num_rows($Query);

                          echo '<span class="pull-right"><b>'.$count.' SERVICIOS AUTORIZADOS</b></span>';
                       ?>
                   </h3>
                 </div>
                 <div class="panel-body">
                   <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tblServicios">
                      <thead>
                        <tr>
                          <th style="display: none">SERVICIO</th>
                          <th>SERVICIO</th>
                          <th>DESCRIPCIÓN</th>
                          <th>DURACIÓN</th>
                          <th>CARACTERÍSTICA</th>
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

<script src="js/servicios.js"></script>
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