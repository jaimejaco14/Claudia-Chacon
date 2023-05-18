<?php 
include '../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'cumplehoy':
            $sqlcumphoy="SELECT distinct(t.trcrazonsocial),s.slnnombre
                        FROM btycolaborador c
                        JOIN btytercero t ON t.trcdocumento=c.trcdocumento
                        JOIN btysalon_base_colaborador sb ON sb.clbcodigo=c.clbcodigo
                        JOIN btysalon s ON s.slncodigo=sb.slncodigo
                        WHERE sb.slchasta IS NULL AND DAY(c.clbfechanacimiento )=DAY(NOW()) AND MONTH(c.clbfechanacimiento )=MONTH(NOW())
                        and bty_fnc_estado_colaborador(c.clbcodigo)='VINCULADO'
                        ORDER BY t.trcrazonsocial";
            $reshoy=$conn->query($sqlcumphoy);
            if($reshoy->num_rows>0){  
            $cont='';   
                while($rowhoy=$reshoy->fetch_array()){
                    $cont.='
                        <tr><td>'.utf8_encode($rowhoy[0]).'</td><td>'.$rowhoy[1].'</td></tr>';
                }
                echo $cont;
            }else{
                echo '<tr><td colspan="2" class="text-center">No hay cumpleaños el dia de hoy</td></tr>';
            }
	break;
	case 'cumplemes':
		$sqlcumpmes="SELECT t.trcrazonsocial,day(c.clbfechanacimiento) as dia, CASE WHEN bty_fnc_salon_colaborador(c.clbcodigo) IS NULL THEN '' ELSE bty_fnc_salon_colaborador(c.clbcodigo) end as slnnombre FROM btycolaborador c JOIN btytercero t ON t.trcdocumento=c.trcdocumento WHERE MONTH(c.clbfechanacimiento )= MONTH(CURDATE()) AND bty_fnc_estado_colaborador(c.clbcodigo)='vinculado' ORDER BY dia";
            $resmes=$conn->query($sqlcumpmes);
            if($resmes->num_rows>0){ 
        $cont='';    
            while($rowmes=$resmes->fetch_array()){
                $cont.='<tr><td class="text-center"> '.$rowmes[1].'</td>
                        <td> '.utf8_encode($rowmes[0]).'</td>
                        <td> '.$rowmes[2].'</td></tr>';
                
            }
                echo $cont;
        }else{
            echo '<tr><td colspan="3" class="text-center">No hay cumpleaños éste mes</td></tr>';
        }
	break;
	case 'cumplemes2':
		$sqlcumpmes="SELECT distinct(t.trcrazonsocial),day(c.clbfechanacimiento) as dia,sl.slnnombre
                                    FROM btycolaborador c
                                    JOIN btytercero t ON t.trcdocumento=c.trcdocumento
                                    join btysalon_base_colaborador sb on sb.clbcodigo=c.clbcodigo
                                    join btysalon sl on sl.slncodigo=sb.slncodigo
                                    WHERE MONTH(c.clbfechanacimiento)= IF(MONTH(CURDATE())+1=13,1,MONTH(CURDATE())+1)
                                    AND bty_fnc_estado_colaborador(c.clbcodigo)='VINCULADO'
                                    and sb.slchasta is null
                                    ORDER BY dia";
        $resmes=$conn->query($sqlcumpmes);
        if($resmes->num_rows>0){ 
        $cont='';    
            while($rowmes=$resmes->fetch_array()){
                $cont.='<tr><td class="text-center"> '.$rowmes[1].'</td>
                        <td> '.utf8_encode($rowmes[0]).'</td>
                        <td> '.$rowmes[2].'</td></tr>';
                
            }
                echo $cont;
        }else{
            echo '<tr><td colspan="3" class="text-center">No hay cumpleaños éste mes</td></tr>';
        }
	break;
	case 'detpermiso':
        $sql="SELECT 
                sl.slnnombre,count(*)
                FROM btypermisos_colaboradores as pc 
                join btysalon sl on sl.slncodigo=pc.slncodigo
                where  pc.perestado_tramite = 'REGISTRADO' and pc.perestado=1
                group by pc.slncodigo";
        $res=$conn->query($sql);
        while($row=$res->fetch_array()){
        ?>
            <tr>
                <td><?php echo $row[0];?></td>
                <td align="center"><?php echo $row[1];?></td>
            </tr>
            <?php 
        }
	break;
	case 'detcol':
        $totcol = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) FROM btycolaborador c WHERE c.clbestado=1"));
        $vincul = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) AS cant
                                        FROM (
                                        SELECT bty_fnc_estado_colaborador(c.clbcodigo)
                                        FROM btycolaborador AS c
                                        WHERE bty_fnc_estado_colaborador(c.clbcodigo) = 'VINCULADO') AS c"));
        $desvincul=intval($totcol[0])-intval($vincul[0]);    
        echo json_encode(array('total'=>$totcol[0],'vincu'=>$vincul[0],'desvin'=>$desvincul));
	break;
}
?>