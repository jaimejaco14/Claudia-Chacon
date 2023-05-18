<?php
    include("../../../cnx_data.php");
    $id    = $_POST['id_turno'];
    $fecha = $_POST['fch'];
    $salon = $_POST['salon'];

    $sql = "SELECT t.trcdocumento, t.trcrazonsocial, cat.ctccodigo, cat.ctcnombre, turno.trnnombre, car.crgnombre, tp.tprnombre, c.clbcodigo, p.tprcodigo, pt.ptrnombre, IF(pt.ptrmultiple = 1, 'Si', 'No') AS multiple FROM btyprogramacion_colaboradores p JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo JOIN btytercero t ON t.trcdocumento = c.trcdocumento JOIN btycargo car ON c.crgcodigo = car.crgcodigo JOIN btytipo_programacion tp ON p.tprcodigo = tp.tprcodigo JOIN btypuesto_trabajo pt ON pt.ptrcodigo = p.ptrcodigo JOIN btyturno turno ON p.trncodigo = turno.trncodigo JOIN btycategoria_colaborador cat ON cat.ctccodigo=c.ctccodigo WHERE p.trncodigo = $id AND p.prgfecha = '$fecha' AND p.slncodigo=$salon ORDER BY t.trcrazonsocial"; 
   // echo $sql;
   $listatipo = "SELECT `tprcodigo`, `tprnombre`, `tpralias`, `tprlabora`, `tprestado` FROM `btytipo_programacion` WHERE tprestado = 1 ORDER BY tprnombre";
   $lista = $conn->query($listatipo);


   while ($filas = $lista->fetch_assoc()) {
        $options_select = $options_select.'<option value="'.$filas['tprcodigo'].'">'.$filas['tprnombre'].'</option>';
    }                            
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo '<table class="table table-hover table-bordered table-striped">
                    <thead>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th colspan="2">Puesto</th>  
                    </thead> 
                    <tbody>';
            while ($row = $result->fetch_assoc()) 
            {               
                echo "<tr>";                
                echo '<td>' . utf8_encode($row['trcrazonsocial']) . '</td>';
                echo '<td>' . utf8_encode($row['crgnombre']) . '</td>';
                echo '<td>' . utf8_encode($row['ctcnombre']) . '</td>';
                echo '<td>' . utf8_encode($row['tprnombre']) . '</td>';
                echo '<td><center>' . utf8_encode($row['ptrnombre']) . '</center></td>';
                if ($row['multiple'] == 'Si') {
                    echo '<td><center><i class="fa fa-users"></i></center></td>';
                }else{
                     echo '<td><center><i class="fa fa-user"></i></center></td>';
                }
    
                echo '</tr>';
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
