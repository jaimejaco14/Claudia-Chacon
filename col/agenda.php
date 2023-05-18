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
                        <span>Agenda</span>

                    </li>
                </ol>
            </div>
            <div class="col-md-12">
            	<h3>AGENDA <b><a href="javascript:void(0)" id="btnUpdate" title="Actualizar Listado"><i class="pe-7s-refresh"></i></a></b></h3>
	             <input class="form-control" style="width:100%" type="text" id="fecha" name="fecha" readonly placeholder="click para buscar una fecha">
            </div>
    </div>
</div>

<div class="container-fluid" >

	<div class="row" id="listaCitas">
	        
   	</div>
   	<div class="row">
   		<center><ul class="pagination" id="paginacion">

   		</ul></center>
   	</div>

</div>
<?php include 'footer.php'; ?>
<script src="js/agenda.js"></script>