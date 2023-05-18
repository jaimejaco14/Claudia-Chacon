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
                        <span>Permisos</span>

                    </li>
                </ol>
            </div>
            <div class="col-md-6">
            	<h3>PERMISOS <a href="javascript:void(0)" id="btnUpdate" title="Actualizar Listado"><i class="pe-7s-refresh"></i></a></h3>
            </div>
    </div>
</div>


<div class="content animate-panel">

<div class="row">
    <div class="col-md-12">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1">Registro </a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <div class="col-md-12">
                  <div class="hpanel hblue">
                      <div class="panel-heading hbuilt">
                          <div class="panel-tools">
                              <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                              <a class="closebox"><i class="fa fa-times"></i></a>
                          </div>
                          Permisos
                      </div>
                        <div class="panel-body">
                            <div class="col-md-12"> 
                                <div class="table-responsive">
                                    <center>
                                        <table class="table table-hover table-bordered" id="tbl_permisos" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>CONSECUTIVO</th>
                                                    <th>COLABORADOR</th>
                                                    <th>DESDE</th>
                                                    <th>HASTA</th>
                                                    <th>REGISTRADO POR</th>
                                                    <th>AUTORIZADO POR</th>
                                                    <th>ESTADO</th>
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

<script src="js/permisos.js"></script>