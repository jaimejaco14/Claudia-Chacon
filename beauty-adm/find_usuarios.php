<?php
include '../cnx_data.php';
if ($_POST['name'] != "") {
	$name = $_POST['name'];
	$sql = "SELECT u.usucodigo, u.`usulogin`, u.`usuestado`, t.trcrazonsocial, tu.tiunombre FROM btyusuario u INNER JOIN btytercero t ON t.trcdocumento = u.trcdocumento AND u.tdicodigo = t.tdicodigo INNER JOIN btytipousuario tu ON tu.tiucodigo = u.tiucodigo WHERE t.trcrazonsocial LIKE '%".$name."%' OR u.usulogin LIKE '%".$name."%' OR u.trcdocumento LIKE '$name%'";
} else {
	$sql = "SELECT u.usucodigo, u.`usulogin`, u.`usuestado`, t.trcrazonsocial, tu.tiunombre FROM btyusuario u INNER JOIN btytercero t ON t.trcdocumento = u.trcdocumento AND u.tdicodigo = t.tdicodigo INNER JOIN btytipousuario tu ON tu.tiucodigo = u.tiucodigo";
}
?>


 <div class="panel-heading">
                 <span class="label label-success pull-right"> <?php 
                                                               $query_num_colum = $sql; 
                                                               $resul = $conn->query($query_num_colum); $registros = $resul->num_rows; 
                                                               echo " <h6>No. Registros: ".$registros."</h6>";?></span>
                    <h3 class="panel-title">Usuarios</h3>
                    <br>
                </div>
 <div class="table-responsive"> 
<table class="table table-hover table-bordered table-striped table-responsive">
    <thead>
    	<th>Nombre</th>
    	<th>Login</th>
    	<th>Perfil</th>
    	<th>Estado</th> 
    	<th>Acciones</th>               
    </thead>
    <tbody></tbody>
    <tbody>
        <?php
	       
	        $query_num_col = $sql;
	        $result = $conn->query($query_num_col);
	        $num_total_registros = $result->num_rows;
	        $rowsPerPage = 8;
	         $pageNum = 1;
	        if(isset($_POST['page'])) {
	            $pageNum = $_POST['page'];
	        }
	        $offset = ($pageNum - 1) * $rowsPerPage;
	        $total_paginas = ceil($num_total_registros / $rowsPerPage);
	        $sql = $sql." limit $offset, $rowsPerPage";
	        $result = $conn->query($sql);
	        if ($result->num_rows > 0) {
             
                while ($row = $result->fetch_assoc()) {
                	$estado = "Activo";
		        	$clase = "pe-7s-unlock";
		        	$color = "primary";
		        	$state = 0;
                	if ($row['usuestado'] != 1) {
                		$estado = "Inactivo";
                		$clase = "pe-7s-lock";
                		$color = "danger";
                		$state = 1;
                	}         
                    echo "<tr>";
                    echo '<td>' . utf8_encode($row['trcrazonsocial']) . '</td>';
                    echo '<td>' . $row['usulogin'] . '</td>';
                    echo '<td>' . $row['tiunombre'] . '</td>';
                    echo '<td><center><a title="Cambiar estado"onclick="estado_usuario ('.$row['usucodigo'].', '.$state.' );"><span class="label label-'.$color.'"> ' . $estado . ' <i class="'.$clase.'"></i></span><a/></center></td>';
                    echo '<td><center><button title="Editar" class="btn btn-default btn-sm" onclick="call_editar ('.$row['usucodigo'].');"><i class="pe-7s-note text-info"></i> </button> <button title="Ver mas..." onclick="Visualizar_datos('.$row['usucodigo'].');" class="btn btn-default btn-sm"><i class="fa fa-search-plus text-info"></i></button> <button title="Restablecer contraseña" onclick="Reset_pass('.$row['usucodigo'].');" class="btn btn-default btn-sm"><i class="pe-7s-key text-info"></i></button><button title="Acceso a Salones" data-cod_usuario="'.$row['usucodigo'].'"  id="btn_acceso_salones" class="btn btn-default btn-sm btn_load_modal_sal"><i class="fa fa-sign-in text-info"></i></button></center></td>';
                    //echo '<td><button class="btn btn-danger btn-sm" onclick="eliminar('.$row['sercodigo'].', this)">Eliminar</button></td>';
                    echo '</tr>';
                                $con++;
                                //onclick="eliminar('.$row['sercodigo'].', this)"
                                                }
                                            }
                           
                                            //$conn->close();
                                            ?>
                        </tbody>

                    </table>
                    <?php                  
                    include "paginate.php";
                    ?>
                    </div>
                   
            

                    
