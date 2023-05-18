<?php 
include '../cnx_data.php';
include 'head.php';
VerificarPrivilegio("COOKIES", $_SESSION['tipo_u'], $conn);
    include "librerias_js.php";
 ?>
<script src="js/cookies.js"></script>
 <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="hpanel">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        <a class="closebox"><i class="fa fa-times"></i></a>
                    </div>
                    Configuración de Cookies
                </div>
                <div class="panel-body">
                <form method="get" class="form-horizontal">
                <div class="form-group"><label class="col-sm-2 control-label">Salón</label>
                    <div class="col-sm-10">
                    	<select name="" id="salones" class="form-control">
                    		<option value="0">Seleccione salón</option>
                    	<?php 
                    		//include("conexion.php");

                    		$sql = mysqli_query($conn, "SELECT * FROM btysalon");

                    		while ($row = mysqli_fetch_array($sql)) 
                    		{
                    			echo '<option value='.$row['slncodigo'].'>'.utf8_encode($row['slnnombre']).'</option>';
                    		}
                    	 ?>
                    	</select>
                	</div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group"><label class="col-sm-2 control-label">Opciones</label>

                    <div class="col-sm-10">
                    	<button type="button" class="btn btn-success" onclick="guardar('Salon','salones', 'txtcookie')">Registrar</button> 
						<button type="button" class="btn btn-info" onclick="leerCookie('Salon')">Ver</button> 
						<button type="button" class="btn btn-default" onclick="borrar_coo('Salon')">Eliminar</button> 
                    </div>
                </div>
                    <div class="hr-line-dashed"></div>
                </form>
                </div>
            </div>
        </div>
</div>

<script>
    
 $(document).ready(function() {
        conteoPermisos ();
});



</script>