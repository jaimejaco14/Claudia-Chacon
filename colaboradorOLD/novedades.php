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
                        <span>Novedades</span>

                    </li>
                </ol>
            </div>
            <div class="col-md-6">
            	<h3>NOVEDADES <a href="javascript:void(0)" id="btnUpdate" title="Actualizar Listado"><i class="pe-7s-refresh"></i></a></h3>
	            <div class="input-group">
	                  <input class="form-control" type="text" id="fecha" name="fecha" placeholder="0000-00-00">
	                        <div class="input-group-btn">                            
	                            <button id="busca" name="busca" class="btn btn-default" title=""><i class="fa fa-search text-info"></i>
	                            </button>
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

<script src="js/novedades.js"></script>