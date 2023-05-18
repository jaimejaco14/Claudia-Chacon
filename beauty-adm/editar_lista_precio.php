<?php 
include '../cnx_data.php';

	$cod = $_POST['cod'];
	$cod_salon = $_POST['cod_salon'];
	$html = "";

	$sql = mysqli_query($conn, "SELECT a.lprcodigo, a.slncodigo, a.lpsobservaciones, a.lpsdesde, a.lpshasta, b.lprtipo FROM  btylista_precios_salon a JOIN btylista_precios b ON a.lprcodigo=b.lprcodigo WHERE b.lprcodigo = $cod AND a.slncodigo = $cod_salon");

	if (mysqli_num_rows($sql) > 0) {
		$row = mysqli_fetch_array($sql);
		
		$html.='
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">								
							<select class="form-control" id="sel_lista_precio" disabled name="sel_lista_precio">';	

								$con_ = mysqli_query($conn, "SELECT lprcodigo, lprnombre FROM btylista_precios");

									while ($fil_ = mysqli_fetch_array($con_)) {
										if ($fil_[0] == $row['lprcodigo']) {
											
											$html.='
												<option value='.$fil_['lprcodigo'].' selected>'.$fil_['lprnombre'].'</option>';
										}else{
											
											$html.='
												<option value='.$fil_['lprcodigo'].'>'.$fil_['lprnombre'].'</option>';
										}
									}
						
			$html.='
							</select>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<select name="sel_lista_salon" id="sel_lista_salon" disabled class="form-control">';

								$con = mysqli_query($conn, "SELECT slncodigo, slnnombre FROM btysalon");
						
									while ($fila = mysqli_fetch_array($con)) {
										if ($fila[0] == $row['slncodigo']) {
										
											$html.='
												<option value='.$fila['slncodigo'].' selected>'.$fila['slnnombre'].'</option>';

										}else{
							
											$html.='
												<option value='.$fila['slncodigo'].'>'.$fila['slnnombre'].'</option>';
										}
									}

			$html.='
							</select>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<select name="sel_lista_salon" id="sel_tipo" disabled class="form-control">';
								if ($row['lprtipo'] == "SERVICIOS") {
								  $html.='<option value="SERVICIOS" selected>SERVICIOS</option>
								          <option value="PRODUCTOS">PRODUCTOS</option>';						
															
								}else{
									if ($row['lprtipo'] == "PRODUCTOS") {
										$html.='<option value="PRODUCTOS" selected>PRODUCTOS</option>
										       <option value="SERVICIOS">SERVICIOS</option>';
									}
								}							


			$html.='
							</select>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<div class="input-group date">
                            <input type="text" class="form-control" value="'.$row['lpsdesde'].'" id="fecha_desde"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
					</div>

					<div class="col-sm-6">
						<div class="input-group date ins">
                            <input type="text" class="form-control" value="'.$row['lpshasta'].'" id="fecha_hasta"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<textarea name="observaciones" id="observaciones" rows="3" class="form-control">'.$row['lpsobservaciones'].'</textarea>
						</div>
					</div>
				</div>';

  echo $html;
	}else{
		echo "No hay datos disponibles.";
	}

	mysqli_close($conn);
?>
<script>
$(document).ready(function() {
	$('.date').datepicker({
    	format: 'yyyy-mm-dd'
	});	
	$('.ins').datepicker({
    	format: 'yyyy-mm-dd'
	});	

});
</script>