<?php 

    include '../../cnx_data.php';

    $salon = $_POST['salon'];
    $fecha = $_POST['fecha'];
    $turno = $_POST['turno'];

    switch ($_POST['opcion']) 
    {
        case '1':
            
            $ol = mysqli_query($conn, "SELECT COUNT(cat.ctccodigo) AS cantidad, CASE WHEN cat.ctccodigo = 0 THEN 'N/D' WHEN cat.ctccodigo = 1 THEN 'JUNIOR' WHEN cat.ctccodigo = 2 THEN 'SENIOR' WHEN cat.ctccodigo = 3 THEN 'GOLD' WHEN cat.ctccodigo = 4 THEN 'PLATINUM' END AS categoria, cr.crgnombre FROM btyprogramacion_colaboradores pc JOIN btycolaborador col ON pc.clbcodigo=col.clbcodigo JOIN btycategoria_colaborador cat ON cat.ctccodigo=col.ctccodigo JOIN btycargo cr ON cr.crgcodigo=col.crgcodigo JOIN btytipo_programacion tipo ON tipo.tprcodigo=pc.tprcodigo WHERE pc.trncodigo = $turno AND pc.prgfecha = '$fecha' AND pc.slncodigo= $salon AND tipo.tprlabora = 1 GROUP BY cat.ctccodigo, cr.crgcodigo ORDER BY cr.crgnombre");

        $conteo = mysqli_num_rows($ol);

    while($filas = mysqli_fetch_array($ol))
    {
        $info="";
        switch ($filas['categoria']) 
        {
            case 'N/D':
                $info = '<span class="badge badge-success">'.$filas['cantidad'].'</span>';
                break;

            case 'JUNIOR':
                 $info = '<span class="badge badge-primary">'.$filas['cantidad'].'</span>';
                break;

            case 'SENIOR':
                 $info = '<span class="badge badge-danger">'.$filas['cantidad'].'</span>';
                break;

            case 'GOLD':
                 $info = '<span class="badge badge-warning">'.$filas['cantidad'].'</span>';
                break;

            case 'PLATINUM':
                 $info = '<span class="badge badge-info">'.$filas['cantidad'].'</span>';
                break;
            
            default:
                $categoria = "";
                break;
        }
               echo '          


                    <li class="list-group-item">
                        '.$info.'
                        '.$filas['crgnombre']. " " .$filas['categoria'] .'

                    </li>       
               ';
       
    }
            break;

    case '2':
       $SqlEstados = mysqli_query($conn, "SELECT COUNT(b.tprcodigo)AS cantidad, CASE WHEN b.tprcodigo = 1 THEN 'LABORA' WHEN b.tprcodigo = 2 THEN 'DESCANSO' WHEN b.tprcodigo = 3 THEN 'INCAPACIDAD' WHEN b.tprcodigo = 4 THEN 'CAPACITACION' WHEN b.tprcodigo = 5 THEN 'META' WHEN b.tprcodigo = 6 THEN 'PERMISO' WHEN b.tprcodigo = 7 THEN 'VACACIONES' END AS estado FROM btytipo_programacion a JOIN btyprogramacion_colaboradores b ON a.tprcodigo=b.tprcodigo WHERE b.prgfecha = '$fecha' AND b.slncodigo = $salon AND b.trncodigo = $turno GROUP BY estado ORDER BY estado");

        $jsonestados = array();
            while($SqlDescanso = mysqli_fetch_array($SqlEstados))
            {
                $jsonestados[] = array('cantidad' => $SqlDescanso["cantidad"], 'estado' => $SqlDescanso["estado"]);
            }
    
                echo json_encode(array("estados" => $jsonestados));

   
        break;
        
        default:
            # code...
            break;
    }   

    mysqli_close($conn);
?>