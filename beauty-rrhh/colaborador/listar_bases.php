<table class="table table-hover table-bordered table-striped">
<thead>
    <th>Salón</th>
    <th>Desde</th>
    <th>Hasta</th>
    <th>Observaciones</th>
    <th>Eliminar</th>
</thead>
<tbody>
    <?php 
        $codigo_incremental = $_POST['codigo'];
        include '../../cnx_data.php';
        $sql = "SELECT base.`clbcodigo`, base.`slncodigo`, s.slnnombre, `slcobservaciones`, `slcdesde`, `slchasta`, `slccreacion` FROM `btysalon_base_colaborador` base INNER JOIN btysalon s ON base.slncodigo = s.slncodigo WHERE clbcodigo = $codigo_incremental ORDER BY base.slcdesde desc";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row= $result->fetch_assoc()) {
                if ($row['slchasta'] == null) {
                    echo "<tr class='success'>";
                    $f_fin = "Base actual";
                } else {
                    echo "<tr>";
                    $f_fin = $row['slchasta'];
                }
                    echo "<td><center>".$row['slnnombre']."</center></td>";
                    echo "<td><center>".$row['slcdesde']."</center></td>";
                    echo "<td><center>".$f_fin."</center></td>";
                    echo "<td>".$row['slcobservaciones']."</td>";
                    echo "<td><center><button type='button' id='btn_eliminar_est' class='btn btn-xs btn-link' data-colab='".$row['clbcodigo']."' data-salon='".$row['slncodigo']."' data-fe_desde='".$row['slcdesde']."'><i class='fa fa-trash text-info'></i></button></center></td>";
                echo "</tr>";

            }
        } else {
            echo "<tr>
                    <td colspan='5'><center>No Tiene salon base asignado actualmente.</center></td></td>
                </tr>";
        }
    ?>
</tbody>
</table>

<style>
    td{
        white-space: nowrap;
    }
</style>