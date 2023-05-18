<?php
session_start();
include '../../cnx_data.php';
$mes=$_POST['mes'];
switch($mes){
	case 1:$txtmes='ENERO';
	break;
	case 2:$txtmes='FEBRERO';
	break;
	case 3:$txtmes='MARZO';
	break;
	case 4:$txtmes='ABRIL';
	break;
	case 5:$txtmes='MAYO';
	break;
	case 6:$txtmes='JUNIO';
	break;
	case 7:$txtmes='JULIO';
	break;
	case 8:$txtmes='AGOSTO';
	break;
	case 9:$txtmes='SEPTIEMBRE';
	break;
	case 10:$txtmes='OCTUBRE';
	break;
	case 11:$txtmes='NOVIEMBRE';
	break;
	case 12:$txtmes='DICIEMBRE';
	break;

}
if($_POST['salon']!='null'){
	$sln=$_POST['salon'];
}else{
	$consln4="SELECT group_concat(slncodigo order by slnnombre) from btysalon";
	$res4=$conn->query($consln4);
	$row4=$res4->fetch_array();
	$sln=$row4[0];
}
$salones=explode(',',$sln);
$curruser=$_SESSION['codigoUsuario'];
//LOGS DE PROCESO POR CADA SALON 1 REGISTRO
foreach ($salones as $salon){

	/*$sqllog="INSERT INTO btylog_biometrico_procesamiento  (lgbcodigo,lgbmes,lgbfecha,lgbhora,usucodigo,slncodigo) 
	VALUES ((SELECT if(MAX(c.lgbcodigo) is null,1,MAX(c.lgbcodigo)+1) from btylog_biometrico_procesamiento as c),
	'$txtmes',CURDATE(),CURTIME(),$curruser,$salon)";
	$conn->query($sqllog);*/

}


//FIN LOG DE PROCESO



//INICIO CORRECCION DE BIOMETRICO//
foreach ($salones as $salon){

	$cal="SELECT distinct(pc.prgfecha) as fecha 
			from btyprogramacion_colaboradores pc 
			where month(pc.prgfecha)=$mes 
			and pc.prgfecha<=(SELECT max(ab.abmfecha) from btyasistencia_biometrico ab where month(ab.abmfecha)=$mes)
			order by pc.prgfecha asc";

	$rowcal=$conn->query($cal);

	while($dia=$rowcal->fetch_array()){//cada dia del mes 

		$querycol="SELECT distinct(pc.clbcodigo) as col from btyprogramacion_colaboradores pc where pc.slncodigo=$salon";
		$rowcol=$conn->query($querycol);

		while($col=$rowcol->fetch_array()){

			$sqlmm="SELECT MAX(ab.abmhora),MIN(ab.abmhora)
					FROM btyasistencia_biometrico ab
					WHERE ab.slncodigo=$salon AND ab.clbcodigo=$col[0] AND ab.abmfecha='$dia[0]'";
				$resmm=$conn->query($sqlmm);
				$rowmm=$resmm->fetch_array();
				if($rowmm[0]==$rowmm[1]){
					$sqlrd2="SELECT ab.abmcodigo, ab.abmtipo, ab.abmhora, tn.trndesde, tn.trnhasta,  
								if(ab.abmhora=(SELECT MIN(ab2.abmhora)
									FROM btyasistencia_biometrico ab2
									WHERE ab2.slncodigo=$salon AND ab2.clbcodigo=$col[0] AND ab2.abmfecha='$dia[0]' ),
								IF(TIMEDIFF(abmhora,trndesde) < TIMEDIFF(trnhasta,abmhora),'ENTRADA','SALIDA'),'INVALIDO' ) as nuevotipo
								FROM btyprogramacion_colaboradores pc
								NATURAL JOIN btyturno tn
								JOIN btyasistencia_biometrico ab ON ab.abmfecha=pc.prgfecha AND pc.clbcodigo=ab.clbcodigo
								WHERE pc.slncodigo=$salon AND pc.clbcodigo=$col[0] AND pc.prgfecha='$dia[0]'";
						$resrd=$conn->query($sqlrd2);
						while($rowrd=$resrd->fetch_array()){
							$sqlupd="UPDATE btyasistencia_biometrico ab SET ab.abmnuevotipo = 
										CASE
											WHEN ab.abmhora='$rowmm[1]' THEN '$rowrd[5]'
										ELSE 'INVALIDO'
										END,
										ab.abmerroneo=
										CASE
											WHEN '$rowrd[1]' = '$rowrd[5]' THEN 0
										ELSE 1
										END,
										ab.abmtipoerror=
										CASE
											WHEN '$rowrd[1]' = '$rowrd[5]' THEN 'NORMAL'
										ELSE 'MAL USO DEL BIOMETRICO'
										END
										WHERE ab.slncodigo=$salon AND ab.clbcodigo=$col[0] AND ab.abmfecha='$dia[0]' and ab.abmcodigo=$rowrd[0]";
							$conn->query($sqlupd);
						}
				}else{
					$ref=3600;
					$min=strtotime($rowmm[1]);
					$max=strtotime($rowmm[0]);
					$calc=$max-$min;
					if($calc>$ref){
						$sqlrd="SELECT ab.abmcodigo,ab.abmtipo, ab.abmhora,
								(CASE 
								WHEN ab.abmhora =(
									SELECT MAX(ab2.abmhora)
									FROM btyasistencia_biometrico ab2
									WHERE ab2.slncodigo=$salon AND ab2.clbcodigo=$col[0] AND ab2.abmfecha='$dia[0]') THEN 'SALIDA'
								WHEN ab.abmhora =(
									SELECT MIN(ab2.abmhora)
									FROM btyasistencia_biometrico ab2
									WHERE ab2.slncodigo=$salon AND ab2.clbcodigo=$col[0] AND ab2.abmfecha='$dia[0]') THEN 'ENTRADA'
								else 'INVALIDO' 
								END) as corregido,
								if((select corregido)<>abmtipo,1,0) as error ,
								if((select corregido)<>abmtipo,'MAL USO DEL BIOMETRICO','NORMAL') as tipoerror
								FROM btyasistencia_biometrico ab
								WHERE ab.slncodigo=$salon AND ab.clbcodigo=$col[0] AND ab.abmfecha='$dia[0]'";
						$resrd=$conn->query($sqlrd);
						while($rowrd=$resrd->fetch_array()){
							$sqlupd="UPDATE btyasistencia_biometrico ab SET ab.abmnuevotipo = 
										CASE
											WHEN ab.abmhora='$rowmm[1]' THEN 'ENTRADA'
											WHEN ab.abmhora='$rowmm[0]' THEN 'SALIDA'
										ELSE 'INVALIDO'
										END,
										ab.abmerroneo=$rowrd[4],ab.abmtipoerror='$rowrd[5]'
										WHERE ab.slncodigo=$salon AND ab.clbcodigo=$col[0] AND ab.abmfecha='$dia[0]' and ab.abmcodigo=$rowrd[0]";
							$conn->query($sqlupd);
								
						}
					}else{
						$sqlrd2="SELECT ab.abmcodigo, ab.abmtipo, ab.abmhora, tn.trndesde, tn.trnhasta,  
								if(ab.abmhora=(SELECT MIN(ab2.abmhora)
									FROM btyasistencia_biometrico ab2
									WHERE ab2.slncodigo=$salon AND ab2.clbcodigo=$col[0] AND ab2.abmfecha='$dia[0]' ),
								IF(TIMEDIFF(abmhora,trndesde) < TIMEDIFF(trnhasta,abmhora),'ENTRADA','SALIDA'),'INVALIDO' ) as nuevotipo
								FROM btyprogramacion_colaboradores pc
								NATURAL JOIN btyturno tn
								JOIN btyasistencia_biometrico ab ON ab.abmfecha=pc.prgfecha AND pc.clbcodigo=ab.clbcodigo
								WHERE pc.slncodigo=$salon AND pc.clbcodigo=$col[0] AND pc.prgfecha='$dia[0]'";
						$resrd=$conn->query($sqlrd2);
						while($rowrd=$resrd->fetch_array()){
							$sqlupd="UPDATE btyasistencia_biometrico ab SET ab.abmnuevotipo = 
										CASE
											WHEN ab.abmhora='$rowmm[1]' THEN '$rowrd[5]'
										ELSE 'INVALIDO'
										END,
										ab.abmerroneo=
										CASE
											WHEN '$rowrd[1]' = '$rowrd[5]' THEN 0
										ELSE 1
										END,
										ab.abmtipoerror=
										CASE
											WHEN '$rowrd[1]' = '$rowrd[5]' THEN 'NORMAL'
										ELSE 'MAL USO DEL BIOMETRICO'
										END
										WHERE ab.slncodigo=$salon AND ab.clbcodigo=$col[0] AND ab.abmfecha='$dia[0]' and ab.abmcodigo=$rowrd[0]";
							$conn->query($sqlupd);
							
						}
					}
				}
		}
	}
}
//FIN CORRECCION DE BIOMETRICO


//INICIO PROCESAMIENTO DE BIOMETRICO
foreach ($salones as $salon){

	$cal="SELECT distinct(pc.prgfecha) as fecha 
			from btyprogramacion_colaboradores pc 
			where month(pc.prgfecha)=$mes 
			and pc.prgfecha<=(SELECT max(ab.abmfecha) from btyasistencia_biometrico ab where month(ab.abmfecha)=$mes)
			order by pc.prgfecha asc";

	$rowcal=$conn->query($cal);

	while($dia=$rowcal->fetch_array()){//cada dia del mes 

		$querycol="SELECT distinct(pc.clbcodigo) as col from btyprogramacion_colaboradores pc where pc.slncodigo=$salon";
		$rowcol=$conn->query($querycol);

		while($col=$rowcol->fetch_array()){

	 		$sql11="SELECT col.clbcodigo,tn.trncodigo,col.horcodigo,ab.slncodigo, col.prgfecha,ab.abmcodigo, IF(tpr.tprlabora<>1,5,(CASE WHEN(CASE WHEN (TIME_TO_SEC(SUBTIME(tn.trndesde,ab.abmhora))<-(ap.abmingresodespues*60)) THEN '2' WHEN (TIME_TO_SEC(SUBTIME(tn.trndesde,ab.abmhora))>(ap.abmingresoantes*60)) THEN '1' ELSE '1' END)=2 THEN IF(tn.trndesde BETWEEN (
					SELECT np.nvphoradesde
					FROM btynovedades_programacion np
					NATURAL JOIN btynovedades_programacion_detalle d
					WHERE d.clbcodigo=$col[0] AND np.nvpfecha='$dia[0]') AND(
					SELECT np.nvphorahasta
					FROM btynovedades_programacion np
					NATURAL JOIN btynovedades_programacion_detalle d
					WHERE d.clbcodigo=$col[0] AND np.nvpfecha='$dia[0]'), IF(ab.abmhora <(
					SELECT ADDTIME(np.nvphorahasta,sec_to_time(apmt.abmingresodespues*60))
					FROM btynovedades_programacion np
					join btyasistencia_parametros apmt
					NATURAL JOIN btynovedades_programacion_detalle d
					WHERE d.clbcodigo=$col[0] AND np.nvpfecha='$dia[0]' limit 0,1),1,2)
										,'2') ELSE '1' END)) AS res
					FROM btyasistencia_parametros ap
					JOIN btyprogramacion_colaboradores col
					JOIN btytipo_programacion tpr ON tpr.tprcodigo=col.tprcodigo
					JOIN btyturno tn ON col.trncodigo=tn.trncodigo
					JOIN btyasistencia_biometrico ab ON col.clbcodigo=ab.clbcodigo AND col.prgfecha=ab.abmfecha
					WHERE col.prgfecha='$dia[0]' AND ab.abmnuevotipo='ENTRADA' AND ab.slncodigo=$salon AND ab.clbcodigo=$col[0] AND ab.abmcodigo NOT IN(
					SELECT n1.abmcodigo
					FROM btyasistencia_biometrico n1, btyasistencia_biometrico n2
					WHERE n1.clbcodigo = n2.clbcodigo AND n1.abmnuevotipo=n2.abmnuevotipo AND n1.abmfecha=n2.abmfecha AND n1.abmhora > n2.abmhora AND n1.abmnuevotipo='ENTRADA' AND n1.slncodigo=$salon)
					union
					SELECT col.clbcodigo,tn.trncodigo,col.horcodigo,ab.slncodigo, col.prgfecha,ab.abmcodigo, IF(tpr.tprlabora<>1,5,(CASE WHEN(CASE WHEN (TIME_TO_SEC(SUBTIME(ab.abmhora,tn.trnhasta))<-(ap.abmsalidaantes*60)) THEN '3' WHEN (TIME_TO_SEC(SUBTIME(ab.abmhora,tn.trnhasta))>(ap.abmsalidadespues*60)) THEN '1' ELSE '1' END)=3 THEN IF(tn.trnhasta BETWEEN (
					SELECT np.nvphoradesde
					FROM btynovedades_programacion np
					NATURAL JOIN btynovedades_programacion_detalle d
					WHERE d.clbcodigo=$col[0] AND np.nvpfecha='$dia[0]') AND(
					SELECT np.nvphorahasta
					FROM btynovedades_programacion np
					NATURAL JOIN btynovedades_programacion_detalle d
					WHERE d.clbcodigo=$col[0] AND np.nvpfecha='$dia[0]'), IF(ab.abmhora <(
					SELECT SUBTIME(np.nvphoradesde,sec_to_time(apmt.abmsalidaantes*60))
					FROM btynovedades_programacion np
					join btyasistencia_parametros apmt
					NATURAL JOIN btynovedades_programacion_detalle d
					WHERE d.clbcodigo=$col[0] AND np.nvpfecha='$dia[0]' limit 0,1),3,1)
										, 3) ELSE '1' END)) AS res
					FROM btyasistencia_parametros ap
					JOIN btyprogramacion_colaboradores col
					JOIN btytipo_programacion tpr ON tpr.tprcodigo=col.tprcodigo
					JOIN btyturno tn ON col.trncodigo=tn.trncodigo
					JOIN btyasistencia_biometrico ab ON col.clbcodigo=ab.clbcodigo AND col.prgfecha=ab.abmfecha
					WHERE col.prgfecha='$dia[0]' AND ab.abmnuevotipo='SALIDA' AND ab.slncodigo=$salon AND ab.clbcodigo=$col[0] AND ab.abmcodigo NOT IN(
					SELECT n1.abmcodigo
					FROM btyasistencia_biometrico n1, btyasistencia_biometrico n2
					WHERE n1.clbcodigo = n2.clbcodigo AND n1.abmnuevotipo=n2.abmnuevotipo AND n1.abmfecha=n2.abmfecha AND n1.abmhora < n2.abmhora AND n1.abmnuevotipo='SALIDA' AND n1.slncodigo=$salon)";
			$row=$conn->query($sql11);
			$cont=mysqli_num_rows($row);
			//echo $sql11;
			//echo $cont;
			if($cont==0)//no tiene registros en el biometrico en ese dia ese colaborador
			{
				$prog="SELECT * FROM btyprogramacion_colaboradores pc
						WHERE pc.clbcodigo=$col[0] AND pc.slncodigo=$salon AND pc.prgfecha='$dia[0]' AND pc.tprcodigo=1
						and pc.clbcodigo NOT IN(select d.clbcodigo from btynovedades_programacion np 
												natural join btynovedades_programacion_detalle d
												where d.clbcodigo=pc.clbcodigo and np.nvpfecha=pc.prgfecha)";
				$resp=$conn->query($prog);
				$contad=mysqli_num_rows($resp);
				if($contad>0){
					$progrow=$resp->fetch_array();
					$funpro1=procesarbiometrico($progrow[0],$progrow[1],$progrow[2],$progrow[3],$dia[0],'null',4,$conn);
					//echo $funpro;
					if($funpro1=='ok'){
						$ins1="INSERT INTO btyasistencia_procesada (clbcodigo,trncodigo,horcodigo,slncodigo,prgfecha,abmcodigo,aptcodigo,apcvalorizacion,apcobservacion) 
								VALUES($progrow[0],$progrow[1],$progrow[2],$progrow[3],'$dia[0]',null,4,0,'')";
						//echo $ins1;
						$conn->query($ins1);
						valorizar($dia[0],$progrow[0],null,4,$conn);
					}
				}
				else
				{
					$que="DELETE from btyasistencia_procesada where prgfecha='$dia[0]' AND clbcodigo=$col[0] and aptcodigo=4";
					$conn->query($que);
				}
			}
			else if($cont==2)//se encontraron 2 registros ENTRADA y SALIDA
			{
				while($proc=$row->fetch_array()){
					$funpro2=procesarbiometrico($proc[0],$proc[1],$proc[2],$proc[3],$proc[4],$proc[5],$proc[6],$conn);
					//echo $funpro;
					if($funpro2=='ok')
					{
						$ins2="INSERT INTO btyasistencia_procesada (clbcodigo,trncodigo,horcodigo,slncodigo,prgfecha,abmcodigo,aptcodigo,apcvalorizacion,apcobservacion) VALUES($proc[0],$proc[1],$proc[2],$proc[3],'$proc[4]',$proc[5],$proc[6],0,'')";
						$conn->query($ins2);
						
					}
					
						update($proc[0],$proc[1],$proc[2],$proc[3],$proc[4],$proc[5],$proc[6],$conn);
						valorizar($proc[4],$proc[0],$proc[5],$proc[6],$conn);

				}
			}
			else if($cont==1)//no marcó la entrada o la salida, la faltante se rellena con abmcod null
			{
				while($proc=$row->fetch_array()){
					$funpro3=procesarbiometrico($proc[0],$proc[1],$proc[2],$proc[3],$proc[4],$proc[5],$proc[6],$conn);

						if($funpro3=='ok')
						{
							if($proc[6]!=5){

								$ins3="INSERT INTO btyasistencia_procesada (clbcodigo,trncodigo,horcodigo,slncodigo,prgfecha,abmcodigo,aptcodigo,apcvalorizacion,apcobservacion) VALUES($proc[0],$proc[1],$proc[2],$proc[3],'$proc[4]',$proc[5],$proc[6],0,''),($proc[0],$proc[1],$proc[2],$proc[3],'$proc[4]',null,6,0,'')";
							}else{
								$ins3="INSERT INTO btyasistencia_procesada (clbcodigo,trncodigo,horcodigo,slncodigo,prgfecha,abmcodigo,aptcodigo,apcvalorizacion,apcobservacion) VALUES($proc[0],$proc[1],$proc[2],$proc[3],'$proc[4]',$proc[5],$proc[6],0,'')";
							}
							$conn->query($ins3);
						}
							update($proc[0],$proc[1],$proc[2],$proc[3],$proc[4],$proc[5],$proc[6],$conn);
							valorizar($proc[4],$proc[0],$proc[5],$proc[6],$conn);
							valorizar($proc[4],$proc[0],null,6,$conn);
				}
			}
			$anull="SELECT COUNT(*) FROM btyasistencia_procesada where clbcodigo='$col[0]' and slncodigo='$salon' and prgfecha='$dia[0]'";
			$conreg=$conn->query($anull);
			$nreg=$conreg->fetch_array();
			if($nreg[0]>2){
				$delt="DELETE FROM btyasistencia_procesada WHERE clbcodigo='$col[0]' and slncodigo='$salon' and prgfecha='$dia[0]' AND abmcodigo is null";
				$conn->query($delt);
			}
		}
	}
	$sqllog="INSERT INTO btylog_biometrico_procesamiento  (lgbcodigo,lgbmes,lgbfecha,lgbhora,usucodigo,slncodigo) 
	VALUES ((SELECT if(MAX(c.lgbcodigo) is null,1,MAX(c.lgbcodigo)+1) from btylog_biometrico_procesamiento as c),
	'$txtmes',CURDATE(),CURTIME(),$curruser,$salon)";
	if($conn->query($sqllog)){

	}else{
		echo $sqllog;
	}
}
//FIN PROCESAMIENTO DE BIOMETRICO

function valorizar($fecha,$codcol,$abmcod,$aptcod,$conn){

	if(($aptcod==2)||($aptcod==3)){
		$sqlval="SELECT if(cg.crgincluircolaturnos=1,(CASE 
				WHEN apt.aptcodigo=2 THEN
					(CEIL(TIME_TO_SEC(SUBTIME(ab.abmhora,tn.trndesde))/900))*(ROUND(((IF(msc.mtatipo='PORCENTAJE',(msc.mtavalor*(SELECT msc2.mtavalor FROM btymeta_salon_cargo msc2
						WHERE msc2.mtapuntoreferencia=1 AND msc2.mtames= MONTH(ap.prgfecha) AND msc2.slncodigo=sl.slncodigo))/100,msc.mtavalor)*apt.aptfactor)/4)/2,0)) 
				WHEN apt.aptcodigo=3 THEN 
				(CEIL(TIME_TO_SEC(SUBTIME(tn.trnhasta,ab.abmhora))/900))*(ROUND(((IF(msc.mtatipo='PORCENTAJE',(msc.mtavalor*(SELECT msc2.mtavalor FROM btymeta_salon_cargo msc2
						WHERE msc2.mtapuntoreferencia=1 AND msc2.mtames= MONTH(ap.prgfecha) AND msc2.slncodigo=sl.slncodigo))/100,msc.mtavalor)*apt.aptfactor)/4)/2,0))
				END),0) AS val,ab.abmcodigo
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_biometrico ab ON ab.abmcodigo=ap.abmcodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				JOIN btysalon sl ON sl.slncodigo=ap.slncodigo
				JOIN btycolaborador col ON ap.clbcodigo=col.clbcodigo
				JOIN btycargo cg on col.crgcodigo=cg.crgcodigo
				JOIN btymeta_salon_cargo msc ON col.crgcodigo=msc.crgcodigo AND msc.slncodigo=sl.slncodigo AND msc.mtames= MONTH(ap.prgfecha)
				WHERE ap.prgfecha ='$fecha' AND ap.clbcodigo=$codcol and ab.abmcodigo=$abmcod";
		$resval=$conn->query($sqlval);
		$rowval=$resval->fetch_array();
		$sqlup="UPDATE btyasistencia_procesada SET apcvalorizacion='$rowval[0]' where abmcodigo=$rowval[1]"; 
		$conn->query($sqlup);
	}else if($aptcod==4){
		$sqlval="SELECT if(cg.crgincluircolaturnos=1,
				ROUND(((IF(msc.mtatipo='PORCENTAJE',(msc.mtavalor*(SELECT msc2.mtavalor FROM btymeta_salon_cargo msc2
						WHERE msc2.mtapuntoreferencia=1 AND msc2.mtames= MONTH(ap.prgfecha) AND msc2.slncodigo=sl.slncodigo))/100,msc.mtavalor)*apt.aptfactor))/2,0),0)
				 AS val
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				JOIN btysalon sl ON sl.slncodigo=ap.slncodigo
				JOIN btycolaborador col ON ap.clbcodigo=col.clbcodigo
				JOIN btycargo cg on col.crgcodigo=cg.crgcodigo
				JOIN btymeta_salon_cargo msc ON col.crgcodigo=msc.crgcodigo AND msc.slncodigo=sl.slncodigo AND msc.mtames= MONTH(ap.prgfecha)
				WHERE ap.prgfecha ='$fecha' AND ap.clbcodigo=$codcol and apt.aptcodigo=4";
		$resval=$conn->query($sqlval);
		$rowval=$resval->fetch_array();
		$sqlup="UPDATE btyasistencia_procesada SET apcvalorizacion='$rowval[0]' where prgfecha='$fecha' and clbcodigo=$codcol and aptcodigo=4"; 
		$conn->query($sqlup);
	}else if($aptcod==6){
		$sqlval="SELECT IF(cg.crgincluircolaturnos=1, ROUND(((IF(msc.mtatipo='PORCENTAJE',(msc.mtavalor*(
				SELECT msc2.mtavalor
				FROM btymeta_salon_cargo msc2
				WHERE msc2.mtapuntoreferencia=1 AND msc2.mtames= MONTH(ap.prgfecha) AND msc2.slncodigo=sl.slncodigo))/100,msc.mtavalor)*apt.aptfactor))/2,0),0) AS val
				FROM btyasistencia_procesada ap
				JOIN btyturno tn ON tn.trncodigo=ap.trncodigo
				JOIN btyasistencia_procesada_tipo apt ON apt.aptcodigo=ap.aptcodigo
				JOIN btysalon sl ON sl.slncodigo=ap.slncodigo
				JOIN btycolaborador col ON ap.clbcodigo=col.clbcodigo
				JOIN btycargo cg ON col.crgcodigo=cg.crgcodigo
				JOIN btymeta_salon_cargo msc ON col.crgcodigo=msc.crgcodigo AND msc.slncodigo=sl.slncodigo AND msc.mtames= MONTH(ap.prgfecha)
				WHERE ap.prgfecha ='$fecha' AND ap.clbcodigo=$codcol AND apt.aptcodigo=6";
		$resval=$conn->query($sqlval);
		$rowval=$resval->fetch_array();
		$sqlup="UPDATE btyasistencia_procesada SET apcvalorizacion='$rowval[0]' where prgfecha='$fecha' and clbcodigo=$codcol and aptcodigo=6"; 
		$conn->query($sqlup);
	}	
}
function update($col,$trn,$hor,$sln,$fecha,$abmcod,$aptcod,$db){

	$sql="SELECT aptcodigo from btyasistencia_procesada 
				where  clbcodigo =  $col
                and   trncodigo =  $trn
                and   horcodigo =  $hor
                and   slncodigo =  $sln
                and   prgfecha  =  '$fecha'
                and   abmcodigo =  $abmcod";
    $res=$db->query($sql);
    $row=$res->fetch_array();
    if($row[0]!=$aptcod){
    	$sql2="UPDATE btyasistencia_procesada SET aptcodigo=$aptcod, apcvalorizacion=0
    			where  clbcodigo =  $col
                and   trncodigo =  $trn
                and   horcodigo =  $hor
                and   slncodigo =  $sln
                and   prgfecha  =  '$fecha'
                and   abmcodigo =  $abmcod";
        $db->query($sql2);
    }
}
function procesarbiometrico ($codCol, $turno, $horario, $salon, $mes, $abmcod, $apt, $Db)
{
    $resp="";
    if($abmcod=='null'){
        $query="SELECT COUNT(*) FROM btyasistencia_procesada 
            where clbcodigo =  $codCol
            and   trncodigo =  $turno
            and   horcodigo =  $horario
            and   slncodigo =  $salon
            and   prgfecha  =  '$mes'
            and   aptcodigo =  $apt";
        $res=$Db->query($query);
        $numrow=$res->fetch_array();
        
        if ($numrow[0]==0)
        {           
            $resp="ok";
        }
        else
        {
            $resp="no";
        }
    }else{
            $query2="SELECT COUNT(*) FROM btyasistencia_procesada 
                where clbcodigo =  $codCol
                and   trncodigo =  $turno
                and   horcodigo =  $horario
                and   slncodigo =  $salon
                and   prgfecha  =  '$mes'
                and   abmcodigo =  $abmcod";
            $res2=$Db->query($query2);
            $numrow2=$res2->fetch_array();
            
            if ($numrow2[0]==0)
            {           
                $resp="ok";
            }
            else
            {
                $resp="no";
            }
        
    }
	return $resp;
}

/*******************************************************************************************************************************/
//INICIO CREACION DE TABLA DE RESULTADOS
foreach ($salones as $salon){

		$sqlns="SELECT sln.slnnombre FROM btysalon sln WHERE sln.slncodigo=$salon";
		$resns=$conn->query($sqlns);
		$slnnom=$resns->fetch_array();

		$sql0="SELECT distinct(ab.clbcodigo), t.trcrazonsocial, cg.crgnombre
				from btyasistencia_procesada ab
				join btycolaborador c on c.clbcodigo=ab.clbcodigo
				join btytercero t on t.trcdocumento=c.trcdocumento
				join btycargo cg on cg.crgcodigo=c.crgcodigo
				where month(ab.prgfecha)='$mes' and ab.slncodigo='$salon'
				order by t.trcrazonsocial asc";
		$res=$conn->query($sql0);
		?>
		<style>
		 .table-fixed thead {
		  width: 99%;
		 }
		 .table-fixed tbody {
		  height: 250px;
		  overflow-y: auto;
		  width: 100%;
		  white-space: nowrap;
		 }
		 .table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
		  display: block;
		 }
		 .table-fixed tbody td, .table-fixed thead > tr> th {
		  float: left;
		  border-bottom-width: 0;
		 }  
		</style>
		<h4 class="text-center" id="encabezado">Reporte preeliminar <?php echo $slnnom[0];?></h4>

		<table class="table table-hover  tablesorter" id="listado">
			<thead style="cursor: pointer;" id="tablehead">
				<tr>
					<th class="text-center col-xs-4 colnombre"> Nombre colaborador</th>
					<th class="text-center  coldatos"> Llegadas tarde</th>
					<th class="text-center  coldatos"> Salidas temprano</th>
					<th class="text-center  coldatos"> Ausencias</th>
					<th class="text-center  coldatos"> Incompletos</th>
					<th class="text-center  coldatos">Presencia NO programada</th>
					<th class="text-center  coldatos"> Errores</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$numrow=mysqli_num_rows($res);
			if($numrow>0){
				while($row=$res->fetch_assoc()){
						$sql3="SELECT apt.aptnombre,count(ap.aptcodigo) as cantidad
								from btyasistencia_procesada ap 
								join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
								where ap.clbcodigo=".$row['clbcodigo']." 
								and ap.aptcodigo = 2
								AND ap.slncodigo=".$salon." and month(ap.prgfecha)=".$mes." 
								union
								select apt.aptnombre,count(ap.aptcodigo) as cantidad
								from btyasistencia_procesada ap 
								join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
								where ap.clbcodigo=".$row['clbcodigo']." 
								and ap.aptcodigo = 3
								AND ap.slncodigo=".$salon." and month(ap.prgfecha)=".$mes." 
								union
								select apt.aptnombre,count(ap.aptcodigo) as cantidad
								from btyasistencia_procesada ap 
								join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
								where ap.clbcodigo=".$row['clbcodigo']."
								and ap.aptcodigo = 4
								AND ap.slncodigo=".$salon." and month(ap.prgfecha)=".$mes." 
								union
								select apt.aptnombre,count(ap.aptcodigo) as cantidad
								from btyasistencia_procesada ap 
								join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
								where ap.clbcodigo=".$row['clbcodigo']."
								and ap.aptcodigo = 6
								AND ap.slncodigo=".$salon." and month(ap.prgfecha)=".$mes." 
								union
								select apt.aptnombre,count(DISTINCT(ap.prgfecha)) as cantidad
								from btyasistencia_procesada ap 
								join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
								where ap.clbcodigo=".$row['clbcodigo']."
								and ap.aptcodigo = 5
								AND ap.slncodigo=".$salon." and month(ap.prgfecha)=".$mes." 
								union
								select null,count(*) from btyasistencia_biometrico ab 
								where ab.abmerroneo=1 and ab.clbcodigo=".$row['clbcodigo']." 
								AND ab.slncodigo=".$salon." AND MONTH(ab.abmfecha)=".$mes;

						$res3=$conn->query($sql3);
						$detalle="";
						while($deta=$res3->fetch_array()){
							$detalle.=$deta[1].",";
						}
						$det=explode(',',$detalle);
						?>
						<tr>
							<td class="col-xs-4 nombrecol"><?php echo utf8_encode($row['trcrazonsocial'])." (".$row['crgnombre'].")";?></td>
							<td class="text-center">
								<a href="#" class="btntarde" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle" ><span class="label label-success tddatos" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Llegadas tarde"><?php if($det[0]==''){echo "0";}else{echo $det[0];}?></span></a>
							</td>
							<td class="text-center">
								<a href="#" class="btntemprano" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle"><span class="label label-info" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Salidas temprano"><?php if($det[1]==''){echo "0";}else{echo $det[1];}?></span></a>
							</td>
							<td class="text-center">
								<a href="#" class="btnausencia" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle"><span class="label label-primary" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Ausencias"><?php if($det[2]==''){echo "0";}else{echo $det[2];}?></span></a>
							</td>
							<td class="text-center">
								<a href="#" class="btnnomark" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle"><span class="label label-warning" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Registros Incompletos"><?php if($det[3]==''){echo "0";}else{echo $det[3];}?></span></a>
							</td>
							<td class="text-center">
								<a href="#" class="btnnoprog" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle"><span class="label label-danger" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Presencia NO programada"><?php if($det[4]==''){echo "0";}else{echo $det[4];}?></span></a>
							</td>
							<td class="text-center">
								<a href="#" class="btnerror" data-toggle="modal" data-id="<?php echo $row['clbcodigo'];?>" data-target="#modaldetalle"><span class="label label-danger" style="font-size:small" data-toggle="tooltip" data-placement="left" title="Registros erroneos"><?php if($det[5]==''){echo "0";}else{echo $det[5];}?></span></a>
							</td>
						</tr>
						<?php

				}
			}else{
				?>
				<tr><td colspan="6" class="text-center col-xs-12">No hay datos para mostrar</td></tr>
				<?php
			}
			?>
			</tbody>
		</table>
<?php 
}
//FIN CREACION DE TABLA DE RESULTADOS
?>
<div id="modaldetalle" class="modal fade" tabindexditarm="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content"> 

            <div class="modal-header"> 
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                <h5 class="modal-title" id="titulomodal"></h5> 
                <h5 id="colab"></h5> 
            </div> 
            <div class="modal-body">
                <div id="detallemodal"></div>
            </div>
            <div class="modal-footer"> 
                <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
            </div> 
        </div> 
    </div>
</div>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
/*$("#tablehead").click(function(e){
	$('[data-toggle="tooltip"]').tooltip('hide')
});*/
$(document).ready(function() 
    { 
        $("#listado").tablesorter(); 
    } 
);
$(".btntarde").click(function(e){
    e.preventDefault();
    $("#colab").html(nombre(this));
    var id=$(this).data('id');
    $("#detallemodal").html('');
    $.ajax({
        url:'biometrico/modalasistencia.php',
        type:'GET',
        data:'id='+id+'&opc=1&mes=<?php echo $mes;?>',
        dataType:'html',
        success:function(data){
            $("#titulomodal").html('<i class="fa fa-sign-in text-success"></i> LLEGADAS TARDE');
            $("#detallemodal").empty();
            $("#detallemodal").html(data);
        }

    });
});
$(".btntemprano").click(function(e){
    e.preventDefault();
    $("#colab").html(nombre(this));
    var id=$(this).data('id');
    $("#detallemodal").html('');
    $.ajax({
        url:'biometrico/modalasistencia.php',
        type:'GET',
        data:'id='+id+'&opc=2&mes=<?php echo $mes;?>',
        dataType:'html',
        success:function(data){
            $("#titulomodal").html('<i class="fa fa-sign-out text-info"></i> SALIDAS ANTES DE TIEMPO');
            $("#detallemodal").empty();
            $("#detallemodal").html(data);
        }

    });
});
$(".btnnomark").click(function(e){
    e.preventDefault();
    $("#colab").html(nombre(this));
    var id=$(this).data('id');
    $("#detallemodal").html('');
    $.ajax({
        url:'biometrico/modalasistencia.php',
        type:'GET',
        data:'id='+id+'&opc=3&mes=<?php echo $mes;?>',
        dataType:'html',
        success:function(data){
            $("#titulomodal").html('<i class="fa fa-clock-o text-warning"></i> REGISTROS INCOMPLETOS');
            $("#detallemodal").empty();
            $("#detallemodal").html(data);
            $("#col3").hide();
           	$(".colth").removeClass('col-xs-2').addClass('col-xs-3');
           	$(".coltd").removeClass('col-xs-2').addClass('col-xs-3');
        }

    });
});
$(".btnausencia").click(function(e){
    e.preventDefault();
    $("#colab").html(nombre(this));
    var id=$(this).data('id');
    $("#detallemodal").html('');
    $.ajax({
        url:'biometrico/modalasistencia.php',
        type:'GET',
        data:'id='+id+'&opc=4&mes=<?php echo $mes;?>',
        dataType:'html',
        success:function(data){
            $("#titulomodal").html('<i class="fa fa-user-times text-primary"></i> AUSENCIAS');
            $("#detallemodal").empty();
            $("#detallemodal").html(data);
            $("#col2").hide();
            $("#col3").hide();
            $(".colth").removeClass('col-xs-2').addClass('col-xs-4');
           	$(".coltd").removeClass('col-xs-2').addClass('col-xs-4');
        }

    });
});
$(".btnerror").click(function(e){
    e.preventDefault();
    $("#colab").html(nombre(this));
    var id=$(this).data('id');
    $("#detallemodal").html('');
    $.ajax({
        url:'biometrico/modalasistencia.php',
        type:'GET',
        data:'id='+id+'&opc=5&mes=<?php echo $mes;?>',
        dataType:'html',
        success:function(data){
            $("#titulomodal").html('<i class="fa fa-times-circle text-danger"></i> USO INCORRECTO DEL BIOMÉTRICO');
            $("#detallemodal").empty();
            $("#detallemodal").html(data);
        }

    });
});
$(".btnnoprog").click(function(e){
    e.preventDefault();
    $("#colab").html(nombre(this));
    var id=$(this).data('id');
    $("#detallemodal").html('');
    $.ajax({
        url:'biometrico/modalasistencia.php',
        type:'GET',
        data:'id='+id+'&opc=6&mes=<?php echo $mes;?>',
        dataType:'html',
        success:function(data){
            $("#titulomodal").html('<i class="fa fa-times-circle text-danger"></i> PRESENCIA NO PROGRAMADA');
            $("#detallemodal").empty();
            $("#detallemodal").html(data);
            $("#col2").hide();
            $("#col3").hide();
        }

    });
});
function nombre(este){
	var nombrecol=" • ";
    nombrecol+=$(este).parents("tr").find(".nombrecol").html();
	return nombrecol;
}

</script>