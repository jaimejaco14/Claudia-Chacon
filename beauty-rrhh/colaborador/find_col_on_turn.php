<?php
    //header("content-type: application/json");
   include '../../cnx_data.php';
    $id    = $_POST['id_turno'];
    $fecha = $_POST['fch'];
    $salon = $_POST['salon'];

    $sql = "SELECT t.trcdocumento, t.trcrazonsocial, cat.ctccodigo, cat.ctcnombre, turno.trnnombre, car.crgnombre, tp.tprnombre, c.clbcodigo, p.tprcodigo, pt.ptrnombre, IF(pt.ptrmultiple = 1, 'Si', 'No') AS multiple FROM btyprogramacion_colaboradores p JOIN btycolaborador c ON c.clbcodigo = p.clbcodigo JOIN btytercero t ON t.trcdocumento = c.trcdocumento JOIN btycargo car ON c.crgcodigo = car.crgcodigo JOIN btytipo_programacion tp ON p.tprcodigo = tp.tprcodigo JOIN btypuesto_trabajo pt ON pt.ptrcodigo = p.ptrcodigo JOIN btyturno turno ON p.trncodigo = turno.trncodigo JOIN  btycategoria_colaborador cat ON cat.ctccodigo=c.ctccodigo WHERE p.trncodigo = $id AND p.prgfecha = '$fecha' AND p.slncodigo=$salon AND turno.trnestado = 1 ORDER BY car.crgnombre, pt.ptrnombre"; 

   $listatipo = "SELECT `tprcodigo`, `tprnombre`, `tpralias`, `tprlabora`, `tprestado` FROM `btytipo_programacion` WHERE tprestado = 1 ORDER BY tprnombre";
   $lista = $conn->query($listatipo);

  
   while ($filas = $lista->fetch_assoc()) {
        $options_select = $options_select.'<option value="'.$filas['tprcodigo'].'">'.$filas['tprnombre'].'</option>';
    }                            
        $result = $conn->query($sql);
        if ($result->num_rows > 0) 
        {
                echo '
                            <table class="table table-hover table-bordered table-striped" id="tbl_listado">
                                <a data-toggle="modal" data-target="#VerCargosPeriles" class="btn-lg pull-left" title="Ver Conteo de Colaboradores" name="btnCopiar" id="btnVerCargos"><i class="fa fa-sort-numeric-asc text-info"></i> </a>
                                <a data-toggle="modal" data-target="#VerCargosEstados" class="btn-lg pull-left" title="Estados Colaboradores" name="btnCopiar" id="btnVerEstados"><i class="fa fa-users text-info"></i> </a>
                                <a data-toggle="modal" data-target="#VerPorcentaje" class="btn-lg pull-left" title="Ver Porcentaje" name="btnCopiar" id="btnPorcentaje"><i class="fa fa-percent text-info"></i> </a>
                                <a data-toggle="modal" data-target="#copySemana" class="btn-lg pull-right" type="button" id="btn_clean" title="Copiar Programación" name="btnCopiarSemana" ><i class="fa fa-clone text-info"></i> </a>
                                <a href="javascript:void(0)" id="btnDeleteProg" data-turno="'.$_POST['id_turno'].'" data-salon="'.$_POST['salon'].'" data-fecha="'.$_POST['fch'].'" class="btn-lg pull-right" type="button"  title="Eliminar toda la programación" name="" ><i class="fa fa-trash text-info"></i> </a>

                                <thead>
                                    <th>Cargo</th>
                                    <th colspan="2">Puesto</th>  
                                    <th>Categoría</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </thead> 
                                <tbody>';
                                while ($row = $result->fetch_assoc()) 
                                {               
                                    echo "<tr class='tbody'>"; 
                                        echo '<td style="display: none" id="td_codigo_col">'.$row['clbcodigo'].'</td>';               
                                        echo '<td>' . utf8_encode($row['crgnombre']) . '</td>';
                                        echo '<td><center>' . utf8_encode($row['ptrnombre']) . '</center></td>';
                                    
                                        if ($row['multiple'] == 'Si') 
                                        {
                                            echo '<td><center><i class="fa fa-users"></i></center></td>';

                                        }
                                        else
                                        {
                                            echo '<td><center><i class="fa fa-user"></i></center></td>';
                                        }
                                        echo '<td>' . utf8_encode($row['ctcnombre']) . '</td>';
                                        echo '<td>' . utf8_encode($row['trcrazonsocial']) . '</td>';

                                    
                                            echo '<td><a id="a'.$row['clbcodigo'].'" title="Doble click para cambiar estado" onDblClick="cambiar_tipo('.$row['clbcodigo'].', '.$row['tprcodigo'].'); this.hidden = true">' . utf8_encode($row['tprnombre']) . '</a><select onchange="actualizar_tipo ('.$row['clbcodigo'].', \''.$fecha.'\')" name="'.$row['clbcodigo'].'" hidden id="'.$row['clbcodigo'].'" >'.$options_select.'</select></td>';
                                            
                                            echo '<td><center><button class="btn btn-default" onclick="eliminar('.$row['clbcodigo'].', \''.$fecha.'\', this)" data-toggle="tooltip" data-placement="top" title="Quitar de programacion"><i class="pe-7s-trash text-info"></i></button>';
                                            
                                            echo '<button class="btn btn-default" id="btnDelRango" data-toggle="tooltip" data-placement="top" title="Eliminar programacion por rango" data-clbcodigo="'.$row['clbcodigo'].'"><i class="fa fa-times text-info"></i></button></td>';

    
                                    echo '</tr>';
                                }

            
        } 
        else 
        {
                            echo '<table class="table table-hover table-bordered table-striped" id="tbl_cero_reg">
                                    <tbody>
                                        <tr>
                                            <td>No hay resultados</td>
                                        </tr>
                    <!--</div>-->';
        }                   
        //$conn->close();
        ?>
    </tbody>
</table>
<style>
    th,td{
        white-space: nowrap;
        font-size: .8em;
    }
</style>

<script>
    $(document).on('click', '#btnDeleteProg', function() 
   {
       var fecha = $(this).data("fecha");
       var turno = $(this).data("turno");
       var salon = $(this).data("salon");

       swal({
            title: "¿Seguro desea eliminar la programación de este turno?",
            text: "",
            type: "warning",
            showCancelButton:  true,
            cancelButtonText:"No",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sí"
        },
        function () 
        {
            $.ajax({
                url: 'deleteAllProg.php',
                method: 'POST',
                data: {turno:turno, fecha:fecha, salon:salon},
                success: function (data) 
                {
                    if (data == 1) 
                    {
                        swal("Programación eliminada", "Exitoso", "success");                       
                        colaboradoresTurno ();
                        location.reload ();
                    }
                }
            });
        }); 
      
      
   });


</script>
