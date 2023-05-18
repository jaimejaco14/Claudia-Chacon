<?php
    include '../head.php';

  	VerificarPrivilegio("AUTORIZACIONES", $_SESSION['tipo_u'], $conn);
?>
<?php include "../librerias_js.php"; ?>
<div class="content">
	<div class="row">
        <div class="col-md-2">
            <div class="hpanel panel-group">
                <div class="panel-body">
                    <div class="text-center text-muted font-bold">Filtrar</div>

                </div>
                <div class="panel-section">
					<form action="" method="POST" role="form">
                    <div class="form-group">
                    	<label for="">Fecha Inicial</label>
                         <input type="text" name="" id="fechaUnoReporte" class="form-control" value="" placeholder="0000-00-00" pattern="" title="">
                    </div>

                    <div class="form-group">
                    	<label for="">Fecha Final</label>
                         <input type="text" name="" id="fechaDosReporte" class="form-control" value="" placeholder="0000-00-00" pattern="" title="">
                    </div>

                    

                    <div class="form-group">
                    	<label for="">Seleccionar Tipo</label>                    	
                        <select name="" id="selTipoReporte" class="form-control">
                        	<option value="0">Todos</option>
                            <!-- <option value="anulados">Anulados</option> -->
		          			<?php 
                        		$sql = mysqli_query($conn, "SELECT auttipo_codigo, nombre FROM btyautorizaciones_tipo WHERE autestado = 1 ORDER BY nombre");

                        		while ($row = mysqli_fetch_array($sql)) 
                        		{
                        			echo '<option value="'.$row['auttipo_codigo'].'">'.utf8_encode($row['nombre']).'</option>';
                        		}
                        	?>
          				</select>
                    </div>

                    <div class="form-group">
                    	<label for="">Seleccionar Salón</label>                    	
                        <select name="" id="selSlnReporte" class="form-control" name="salones[]">
                        	<option value="0">Todos</option>
		          			<?php 
		          				$sql = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado = 1 ORDER BY slnnombre");

		          				while ($row = mysqli_fetch_array($sql)) 
		          				{
		          					echo '<option value="'.$row['slncodigo'].'">'.ucwords(strtolower(utf8_encode($row['slnnombre']))).'</option>';
		          				}
		          			?>
          				</select>
                    </div>

                    <div class="form-group">
                    	<label for="">Seleccionar Colaborador</label>
                        <select name="" id="selColaboradorReporte">
                        	<option value="0" selected data-tipo="all">Todos</option>
                        	<?php 
                        		$sql = mysqli_query($conn, "(SELECT a.clbcodigo, b.trcrazonsocial, c.crgincluircolaturnos as tusuario FROM btycolaborador a
JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento JOIN btycargo c ON c.crgcodigo=a.crgcodigo WHERE bty_fnc_estado_colaborador(a.clbcodigo) = 'VINCULADO') UNION (SELECT pman.prmcodigo, trc.trcrazonsocial, 'M' FROM btypersona_mantenimiento pman JOIN btytercero trc ON  trc.tdicodigo=pman.tdicodigo AND trc.trcdocumento=pman.trcdocumento) UNION (SELECT pro.prvcodigo, trc.trcrazonsocial, 'P' FROM btyproveedor pro JOIN btytercero trc ON trc.tdicodigo=pro.tdicodigo AND trc.trcdocumento=pro.trcdocumento) ORDER BY trcrazonsocial");

                        		while ($row = mysqli_fetch_array($sql)) 
                        		{
                        			echo '<option value="'.$row['clbcodigo'].'" data-tipo="'.$row['tusuario'].'">'.utf8_encode($row['trcrazonsocial']).'</option>';
                        		}
                        	?>
                        </select>


                    </div>

                    <div class="form-group">
                    	<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Reporte" id="btnReporte">Buscar</button>
                    </div>
                    </form>
                </div>

                <div id="" class="collapse">              
                    
                </div>



            </div>
        </div>
        <div class="col-md-10">
            <div class="hpanel">

                <div class="panel-body">
                	<div class="text-center text-muted font-bold"><span><button class="btn btn-info pull-left" id="btnBack" data-toggle="tooltip" data-placement="top" title="Volver"><i class="fa fa-arrow-left" aria-hidden="true"></i></button></span> Reporte <span><button class="btn btn-warning pull-right" id="btnExport" data-toggle="tooltip" data-placement="top" title="Exportar a Excel"><i class="fa fa-file-excel-o"></i></button></span></div>
                    <hr>
                	<table class="table table-hover table-bordered" id="tblReporte">
                		<thead>
                			<tr>
                				<th>#</th>
                                <th>Tipo</th>
                				<th>Beneficiario</th>
                				<th>Cargo</th>
                				<th>Fecha</th>
                				<th>Aprobado por</th>
                                <th>Valor/Porcentaje</th>
                                <th>Concepto</th>
                                <th>Salón</th>
                                <th>Estado</th>
                			</tr>
                		</thead>
                		<tbody>
                			
                		</tbody>
                	</table>
                    <hr>
                    <!-- <table class="table table-hover table-bordered" id="statistics">               
                        
                    </table> -->
                </div>

            </div>
        </div>
    </div>
</div>


<style>
    #tblReporte td{
        font-size: .8em!important;
    }

    #tblReporte
    {
        white-space: none!important;
    }

    .valor{
        text-align: center;
    }

    /* .estado{
        background-color: lime;
    } */
</style>

<script src="js/author223.js"></script>