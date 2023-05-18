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
                        <span>Interrupcion por ausencia</span>

                    </li>
                </ol>
            </div>
            <div class="col-md-6">
            	<h3>Interrupcion por ausencia</h3>
            </div>
    </div>
</div>


<div class="container-fluid">

<div class="row">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1">Listado </a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                      <div class="table-responsive">
                          <center>
                              <table class="table table-hover table-bordered" id="tbl_permisos" style="width: 100%">
                                  <thead>
                                      <tr>
                                          <th>Num</th>
                                          <th>Desde</th>
                                          <th>Hasta</th>
                                          <th>Registrado por:</th>
                                          <th>Revisado por:</th>
                                          <th>Estado</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                              </table>
                          </center>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
  th,td{
      font-size: .9em;
      white-space: nowrap;
  }
  .id{
    text-align: right;
  }

  .fecha{
      text-transform: uppercase!important;
  }
</style>
<?php include 'footer.php'; ?>
<script src="js/permisos.js"></script>