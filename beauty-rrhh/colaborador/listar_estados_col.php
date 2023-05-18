<table class="table table-hover table-bordered table-striped">
<thead>
    <th style="display: none;"></th>
    <th>Tipo</th>
    <th>Fecha</th>
    <th>Observaciones</th>
    <th>Opciones</th>
</thead>
<tbody>
    <?php 
        include '../../cnx_data.php';
        $cod_colaborador = $_POST['codigo'];

        $sql = "SELECT clecodigo,clefecha, clbcodigo, cleobservaciones, cletipo, cleestado FROM btyestado_colaborador WHERE clbcodigo = $cod_colaborador AND cleestado = 1 ORDER BY clefecha DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row= $result->fetch_assoc()) { 

                    echo "<td style='display:none'>".$row['clecodigo']."</td>";
                    echo "<td>".$row['cletipo']."</td>";
                    echo "<td>".$row['clefecha']."</td>";
                    echo "<td>".$row['cleobservaciones']."</td>";
                   if($row['cletipo']=='VINCULADO'){
                        echo "<td><center>
                        <button type='button' data-clecod=".$row['clecodigo']." id='detvincu' title='Ver/Editar detalles de vinculacion' class='btn btn-xs text-info'><i class='fa fa-eye'></i></button>
                        <button type='button' data-id=".$row['clbcodigo']." data-cod=".$row['clecodigo']." data-fecha=".$row['clefecha']."  id='btn_edit_col' class='btn btn-xs text-info' data-toggle='modal' data-target='#modalEditarEstColab'><i class='fa fa-edit'></i></button> 
                        <button type='button' data-id=".$row['clbcodigo']." data-fecha=".$row['clefecha']." id='btn_elim_col' title='Eliminar estado' class='btn btn-xs text-info'><i class='fa fa-times'></i></button></center></td>";
                    }else{
                        echo "<td><center><button type='button' data-id=".$row['clbcodigo']." data-cod=".$row['clecodigo']." data-fecha=".$row['clefecha']."  id='btn_edit_col' class='btn btn-xs text-info' data-toggle='modal' data-target='#modalEditarEstColab'><i class='fa fa-edit'></i></button> <button type='button' data-id=".$row['clbcodigo']." data-fecha=".$row['clefecha']." id='btn_elim_col' title='Eliminar estado' class='btn btn-xs text-info'><i class='fa fa-times'></i></button></center></td>";
                    }
                echo "</tr>";

            }
        } else {
            echo "<tr>
                    <td colspan='5'><center>No tiene estado actualmente.</center></td>
                </tr>";
        }
    ?>
</tbody>
</table>