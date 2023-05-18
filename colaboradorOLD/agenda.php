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
                        <span>Agenda</span>

                    </li>
                </ol>
            </div>
            <div class="col-md-6">
            	<h3>AGENDA <b><a href="javascript:void(0)" id="btnUpdate" title="Actualizar Listado"><i class="pe-7s-refresh"></i></a></b></h3>
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

<div class="content animate-panel" >

	<div class="row" id="listaCitas">
	        
   	</div>
   	<div class="row">
   		<center><ul class="pagination" id="paginacion">

   		</ul></center>
   	</div>

</div>

<script src="js/agenda.js"></script>