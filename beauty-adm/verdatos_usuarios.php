<?php
include '../cnx_data.php';
$sql = "SELECT u.`usucodigo`, u.`trcdocumento`, u.`tdicodigo`, u.`tiucodigo`, u.`usuemail`, u.`usulogin`, t.trcnombres, t.trcapellidos, t.trcdireccion, t.trctelefonofijo, t.trctelefonomovil, t.brrcodigo FROM `btyusuario` u INNER JOIN btytercero t ON t.trcdocumento = u.trcdocumento AND u.tdicodigo =t.tdicodigo WHERE u.usucodigo = ".$_POST['codigo'];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
                	$estado = "Activo";
		        	$clase = "pe-7s-lock";
		        	$color = "primary";
		        	$state = 0;
                	if ($row['usuestado'] != 1) {
                		$estado = "Inactivo";
                		$clase = "pe-7s-unlock";
                		$color = "danger";
                		$state = 1;
                	}         
                    echo "<tr>";
                    echo '<td>' . $row['trcrazonsocial'] . '</td>';
                    echo '<td>' . $row['usulogin'] . '</td>';
                    echo '<td>' . $row['tiunombre'] . '</td>';
                    echo '<td><center><a title="Cambiar estado"onclick="estado_usuario ('.$row['usucodigo'].', '.$state.' );"><span class="label label-'.$color.'"> ' . $estado . ' <i class="'.$clase.'"></i></span><a/></center></td>';
                    echo '<td><center><button title="Editar" class="btn btn-default btn-sm" onclick="img (\'' .$row['actimagen'] .'\')"><i class="pe-7s-note text-info"></i> </button> <button title="Ver mas..." onclick="Visualizar_datos('.$row['usucodigo'].');" class="btn btn-default btn-sm"><i class="fa fa-search-plus text-info"></i></button></center></td>';
                    //echo '<td><button class="btn btn-danger btn-sm" onclick="eliminar('.$row['sercodigo'].', this)">Eliminar</button></td>';
                    echo '</tr>';
                                $con++;
                                //onclick="eliminar('.$row['sercodigo'].', this)"
                                                }
                                            }
                           
                                            $conn->close();
                                            ?>
<table class="table table-hover table-bordered table-striped">
    <thead>
        <th>Nombre</th>
        <td>Nom</td>              
    </thead>
    <tbody>
        
    </tbody>
    <tbody>
    </tbody>                 
</table>