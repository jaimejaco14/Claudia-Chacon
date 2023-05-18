<?php
include("../../../cnx_data.php");
    $id = $_POST['id_turno'];
    $fecha = $_POST['fch'];
    $sql = "SELECT t.trcdocumento, t.trcrazonsocial, car.crgnombre, tp.tprnombre, c.clbcodigo, p.tprcodigo, pt.ptrnombre, IF(pt.ptrmultiple = 1, 'Si', 'No') AS multiple FROM  btyprogramacion_colaboradores p INNER JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo INNER JOIN btytercero t ON t.trcdocumento = c.trcdocumento INNER JOIN btycargo car ON c.crgcodigo = car.crgcodigo INNER JOIN btytipo_programacion tp ON p.tprcodigo = tp.tprcodigo INNER JOIN btypuesto_trabajo pt ON pt.ptrcodigo = p.ptrcodigo WHERE p.trncodigo = $id and p.prgfecha = '$fecha' ORDER BY pt.ptrnombre"; 
   // echo $sql;
   $listatipo = "SELECT `tprcodigo`, `tprnombre`, `tpralias`, `tprlabora`, `tprestado` FROM `btytipo_programacion` WHERE tprestado = 1 ORDER BY tprnombre";
   $lista = $conn->query($listatipo);
   $options_select = '<option value="" selected disabled>--Cambiar estado--</option>';
   while ($filas = $lista->fetch_assoc()) {
        $options_select = $options_select.'<option value="'.$filas['tprcodigo'].'">'.$filas['tprnombre'].'</option>';
    }                            
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo '<table class="table table-hover table-bordered table-striped">
                <a data-toggle="modal" data-target="#copy" class="btn-lg pull-right" title="Copiar programaci&oacute;n" name="btnCopiar" id="btnCopia"><i class="pe-7s-copy-file text-info"></i> </a>
                    <thead>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th colspan="2">Puesto</th>

                    <th>Estado</th>
                    <th>Acciones</th>
                    </thead> 
                    <tbody>';
            while ($row = $result->fetch_assoc()) {        
                echo "<tr>";
                echo '<td>' . utf8_encode($row['trcrazonsocial']) . '</td>';
                echo '<td>' . utf8_encode($row['crgnombre']) . '</td>';
                echo '<td><center>' . utf8_encode($row['ptrnombre']) . '</center></td>';
                if ($row['multiple'] == 'Si') {
                    echo '<td><center><i class="fa fa-users"></i></center></td>';
                }else{
                     echo '<td><center><i class="fa fa-user"></i></center></td>';
                }
                echo '<td><a id="a'.$row['clbcodigo'].'" title="Doble click para cambiar estado" onDblClick="cambiar_tipo('.$row['clbcodigo'].', '.$row['tprcodigo'].'); this.hidden = true">' . utf8_encode($row['tprnombre']) . '</a><select onchange="actualizar_tipo ('.$row['clbcodigo'].', \''.$fecha.'\')" name="'.$row['clbcodigo'].'" hidden id="'.$row['clbcodigo'].'" >'.$options_select.'</select></td>';
                echo '<td><button class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Quitar de programacion" onclick="eliminar('.$row['clbcodigo'].', \''.$fecha.'\', this)"><i class="pe-7s-trash text-info"></i></button></td>';
                echo '</tr>';
            	$con++;
            }
        } else {
            echo '<table class="table table-hover table-bordered table-striped">
                    <tbody>
                    <tr>
                    <td>No hay resultados</td>
                    </tr>';
        }                   
        $conn->close();
        ?>
    </tbody>
</table>
<style>
    th,td{
        white-space: nowrap;
        font-size: .8em;
    }
</style>
<script type="text/javascript">

</script>