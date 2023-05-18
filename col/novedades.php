<?php 
	include("head.php");
	include("librerias_js.php");
?>


<div class="normalheader small-header">
    <div class="hpanel">
        <div class="panel-body">
           <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="inicio.php">Inicio</a></li>
                    <li class="active">
                        <span>Novedades</span>

                    </li>
                </ol>
            </div>
            <div class="col-md-6">
            	<h3>NOVEDADES</h3>
              <input class="form-control" type="text" id="fecha" name="fecha" placeholder="Elija Fecha" readonly>
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
                    <table class="table table-bordered table-hover" id="tblNovedades" style="width: 100%">
                    <!-- <span class="pull-right" id="counNov"></span> -->
                      <thead>
                        <tr>
                          <th>CÓDIGO</th>
                          <th>TIPO NOVEDAD</th>
                          <th>OBSERVACIONES</th>
                          <th>FECHA</th>
                          <th>DE</th>
                          <th>HASTA</th>
                          <th>ESTADO</th>
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
  .idnovedad{
    text-align: right;
  }

  .fecha{
      text-transform: uppercase!important;
  }
</style>
<?php include 'footer.php'; ?>
<script src="js/novedades.js"></script>