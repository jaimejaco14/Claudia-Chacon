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

//INICIO CORRECCION DE BIOMETRICO//
foreach ($salones as $salon){

	$cal="SELECT distinct(pc.prgfecha) as fecha 
			from btyprogramacion_colaboradores pc 
			where month(pc.prgfecha)=$mes and year(pc.prgfecha)=year(curdate())
			and pc.prgfecha<=(SELECT max(ab.abmfecha) from btyasistencia_biometrico ab where month(ab.abmfecha)=$mes and year(ab.abmfecha)=year(curdate()))
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
			where month(pc.prgfecha)=$mes and year(pc.prgfecha)=year(curdate())
			and pc.prgfecha <= (SELECT max(ab.abmfecha) from btyasistencia_biometrico ab where month(ab.abmfecha)=$mes and year(ab.abmfecha)=year(curdate()))
			order by pc.prgfecha asc";

	$rowcal=$conn->query($cal);

	while($dia=$rowcal->fetch_array()){//cada dia del mes 

		$querycol="SELECT distinct(pc.clbcodigo) as col from btyprogramacion_colaboradores pc where pc.slncodigo=$salon and pc.prgfecha='$dia[0]'";
		$rowcol=$conn->query($querycol);//busca colaboradores programados

		while($col=$rowcol->fetch_array()){
			//busca y relaciona registro biometrico con la programacion
	 		$sql11="SELECT col.clbcodigo,tn.trncodigo,col.horcodigo,ab.slncodigo, col.prgfecha,ab.abmcodigo, IF(tpr.tprlabora<>1,5,0) AS res,ab.abmnuevotipo,ab.abmhora, IF(ab.abmnuevotipo='ENTRADA',tn.trndesde, IF(ab.abmnuevotipo='SALIDA',tn.trnhasta, NULL)) AS horap, IF(ab.abmnuevotipo='ENTRADA', TIMEDIFF(ab.abmhora,(
					SELECT horap)), IF(ab.abmnuevotipo='SALIDA', TIMEDIFF((
					SELECT horap),ab.abmhora), NULL)) AS dif, IF((
					SELECT dif) > 0,0,1) AS sw, CASE WHEN ab.abmnuevotipo='ENTRADA' AND (
					SELECT sw)=0 THEN 2 ELSE CASE WHEN ab.abmnuevotipo='SALIDA' AND (
					SELECT sw)=0 THEN 3 ELSE 1 END END AS res2,(
					SELECT SEC_TO_TIME(ap.abmingresodespues*60)
					FROM btyasistencia_parametros ap) ing,
					(
					SELECT SEC_TO_TIME(ap.abmsalidaantes*60)
					FROM btyasistencia_parametros ap) sal, IF(ab.abmnuevotipo='ENTRADA', IF(TIMEDIFF((
					SELECT dif),(
					SELECT ing))<=0,1,2), IF(ab.abmnuevotipo='SALIDA', IF(TIMEDIFF((
					SELECT dif),(
					SELECT sal))<=0,1,3), NULL)) res3
					FROM btyprogramacion_colaboradores col 
					JOIN btytipo_programacion tpr ON tpr.tprcodigo=col.tprcodigo
					JOIN btyturno tn ON col.trncodigo=tn.trncodigo
					JOIN btyasistencia_biometrico ab ON col.clbcodigo=ab.clbcodigo AND col.prgfecha=ab.abmfecha
					WHERE col.prgfecha='$dia[0]' and ab.abmnuevotipo <> 'INVALIDO' AND ab.slncodigo=$salon AND ab.clbcodigo=$col[0]";
			$row=$conn->query($sql11);
			$cont=mysqli_num_rows($row);
	 		
			if($cont==0)//no tiene registros en el biometrico ese dia el colaborador (OSEA... no puso huella ese dia)
			{
				//busca si tiene programacion ese dia, y si la tiene busca las horas de entrada y salida
				$prog="SELECT pc.clbcodigo,pc.trncodigo,pc.horcodigo,pc.slncodigo,pc.prgfecha,t.trndesde,t.trnhasta
						FROM btyprogramacion_colaboradores pc
						JOIN btyturno t ON t.trncodigo=pc.trncodigo
					WHERE pc.clbcodigo=$col[0] AND pc.slncodigo=$salon AND pc.prgfecha='$dia[0]' AND pc.tprcodigo=1";
				$resp=$conn->query($prog);
				$contad=mysqli_num_rows($resp);
				if($contad>0){
					$progrow=$resp->fetch_array();
					//busca si el colab tiene permiso q justifique ausencia
					$sqlp="SELECT count(*) FROM btypermisos_colaboradores pc
							WHERE pc.clbcodigo=$col[0] AND ('$dia[0]' BETWEEN pc.perfecha_desde AND pc.perfecha_hasta)
							and ('$progrow[5]' between pc.perhora_desde and pc.perhora_hasta) and ('$progrow[6]' between pc.perhora_desde and pc.perhora_hasta) and pc.perestado_tramite='AUTORIZADO'";
					$resc=$conn->query($sqlp);
					$rowp=$resc->fetch_array();
					if($rowp[0]==0){
						//si no tiene permisos, busca en novedades
						$sqln="SELECT count(*) FROM btynovedades_programacion nc
								join btynovedades_programacion_detalle nd on nd.nvpcodigo=nc.nvpcodigo
								WHERE nd.clbcodigo=$col[0] AND ('$dia[0]' BETWEEN nc.nvpfechadesde AND nc.nvpfechahasta)
								and ('$progrow[5]' between nc.nvphoradesde and nc.nvphorahasta) and ('$progrow[6]' between nc.nvphoradesde and nc.nvphorahasta) and nc.nvpestado <> 'ELIMINADO'";
						$resn=$conn->query($sqln);
						$rown=$resn->fetch_array();
						if($rown[0]==0){
							//si no hay novedades, inserta el registro de ausencia
							$funpro1=validaregbio($progrow[0],$progrow[1],$progrow[2],$progrow[3],$dia[0],'null',4,$conn);
							if($funpro1=='ok'){
								$ins1="INSERT INTO btyasistencia_procesada (clbcodigo,trncodigo,horcodigo,slncodigo,prgfecha,abmcodigo,aptcodigo,apcvalorizacion,apcobservacion) 
										VALUES($progrow[0],$progrow[1],$progrow[2],$progrow[3],'$dia[0]',null,4,0,'')";
								//echo $ins1;
								$conn->query($ins1);
								valorizar($dia[0],$progrow[0],null,4,$conn);
							}
						}else{
							//si no tiene programacion ese dia, borra ausencia de procesada anterior (si la hubo)
							$que="DELETE from btyasistencia_procesada where prgfecha='$dia[0]' AND clbcodigo=$col[0] and aptcodigo=4";
							$conn->query($que);
						}
					}else{
						//si no tiene programacion ese dia, borra ausencia de procesada anterior (si la hubo)
						$que="DELETE from btyasistencia_procesada where prgfecha='$dia[0]' AND clbcodigo=$col[0] and aptcodigo=4";
						$conn->query($que);
					}
				}
				else
				{
					//si no tiene programacion ese dia, borra ausencia de procesada anterior (si la hubo)
					$que="DELETE from btyasistencia_procesada where prgfecha='$dia[0]' AND clbcodigo=$col[0] and aptcodigo=4";
					$conn->query($que);
				}
			}
			else if($cont==2)//se encontraron 2 registros ENTRADA y SALIDA
			{
				while($proc=$row->fetch_array()){

					//determinar el tipo de infraccion en caso de haberla
					$resapt=procesoapt($proc[0],$proc[1],$proc[2],$proc[3],$proc[4],$proc[5],$proc[6],$proc[7],$proc[8],$proc[9],$proc[10],$proc[11],$proc[15],$conn);
					$funpro2=validaregbio($proc[0],$proc[1],$proc[2],$proc[3],$proc[4],$proc[5],$resapt,$conn);
					if($funpro2=='ok')
					{
						$ins4="INSERT INTO btyasistencia_procesada (clbcodigo,trncodigo,horcodigo,slncodigo,prgfecha,abmcodigo,aptcodigo,apcvalorizacion,apcobservacion) 
								VALUES ($proc[0],$proc[1],$proc[2],$proc[3],'$proc[4]',$proc[5],$resapt,0,'')";
						$conn->query($ins4);
					}
					update($proc[0],$proc[1],$proc[2],$proc[3],$proc[4],$proc[5],$resapt,$conn);
					valorizar($proc[4],$proc[0],$proc[5],$resapt,$conn);
					
				}	
			}
			else if($cont==1)//no marcó la entrada o la salida, la faltante se rellena con abmcod null
			{
				$proc=$row->fetch_array();
				$resapt=procesoapt($proc[0],$proc[1],$proc[2],$proc[3],$proc[4],$proc[5],$proc[6],$proc[7],$proc[8],$proc[9],$proc[10],$proc[11],$proc[15],$conn);
				$funpro3=validaregbio($proc[0],$proc[1],$proc[2],$proc[3],$proc[4],$proc[5],$resapt,$conn);

				if($funpro3=='ok')
				{					
					if($resapt!=5){
						$ins3="INSERT INTO btyasistencia_procesada (clbcodigo,trncodigo,horcodigo,slncodigo,prgfecha,abmcodigo,aptcodigo,apcvalorizacion,apcobservacion) VALUES($proc[0],$proc[1],$proc[2],$proc[3],'$proc[4]',$proc[5],$resapt,0,''),($proc[0],$proc[1],$proc[2],$proc[3],'$proc[4]',null,6,0,'')";
					}else{
						$ins3="INSERT INTO btyasistencia_procesada (clbcodigo,trncodigo,horcodigo,slncodigo,prgfecha,abmcodigo,aptcodigo,apcvalorizacion,apcobservacion) VALUES($proc[0],$proc[1],$proc[2],$proc[3],'$proc[4]',$proc[5],$resapt,0,'')";
					}
					$conn->query($ins3);

				}
				update($proc[0],$proc[1],$proc[2],$proc[3],$proc[4],$proc[5],$resapt,$conn);
				valorizar($proc[4],$proc[0],$proc[5],$resapt,$conn);
				valorizar($proc[4],$proc[0],null,6,$conn);				
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
				END),0) AS val, ab.abmcodigo
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
function validaregbio ($codCol, $turno, $horario, $salon, $mes, $abmcod, $apt, $Db){
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
function procesoapt($codCol, $turno, $horario, $salon, $fecha, $abmcod, $apt, $abmtipo, $abmhora, $horatrn, $dif, $sw, $res, $Db){

	if($apt==5){
		$respuesta=5;
	}else{
		if($res==1){
			$respuesta=1;
		}else{
			if($abmtipo=='ENTRADA'){
				//busca si el colab tiene permiso q justifique llegada tarde
				$sqlp="SELECT COUNT(*)
						FROM btypermisos_colaboradores pc
						WHERE pc.clbcodigo=$codCol AND ('$fecha' BETWEEN pc.perfecha_desde AND pc.perfecha_hasta) AND ('$abmhora' BETWEEN pc.perhora_desde AND pc.perhora_hasta) AND pc.perestado_tramite ='AUTORIZADO'";
				$resc=$Db->query($sqlp);
				$rowp=$resc->fetch_array();
				if($rowp[0]==0){
					//si no tiene permisos, busca en novedades
					$sqln="SELECT COUNT(*)
							FROM btynovedades_programacion nc
							JOIN btynovedades_programacion_detalle nd ON nd.nvpcodigo=nc.nvpcodigo
							WHERE nd.clbcodigo=$codCol AND ('$fecha' BETWEEN nc.nvpfechadesde AND nc.nvpfechahasta) AND ('$abmhora' BETWEEN nc.nvphoradesde and nc.nvphorahasta) AND nc.nvpestado <> 'ELIMINADO'";
					$resn=$Db->query($sqln);
					$rown=$resn->fetch_array();
					if($rown[0]==0){
						//si no hay novedades, devuelve 2 (llegada tarde)
						$respuesta=2;
					}else{
						$respuesta=1;
					}
				}else{
					$respuesta=1;
				}
			}else if($abmtipo=='SALIDA'){
				//busca si el colab tiene permiso q justifique salida temprano 
				$sqlp="SELECT COUNT(*)
						FROM btypermisos_colaboradores pc
						WHERE pc.clbcodigo=$codCol AND ('$fecha' BETWEEN pc.perfecha_desde AND pc.perfecha_hasta) AND ('$abmhora' BETWEEN pc.perhora_desde AND pc.perhora_hasta) AND pc.perestado_tramite ='AUTORIZADO'";
				$resc=$Db->query($sqlp);
				$rowp=$resc->fetch_array();
				if($rowp[0]==0){
					//si no tiene permisos, busca en novedades
					$sqln="SELECT COUNT(*)
							FROM btynovedades_programacion nc
							JOIN btynovedades_programacion_detalle nd ON nd.nvpcodigo=nc.nvpcodigo
							WHERE nd.clbcodigo=$codCol AND ('$fecha' BETWEEN nc.nvpfechadesde AND nc.nvpfechahasta) AND ('$abmhora' BETWEEN nc.nvphoradesde and nc.nvphorahasta) AND nc.nvpestado <> 'ELIMINADO'";
					$resn=$Db->query($sqln);
					$rown=$resn->fetch_array();
					if($rown[0]==0){
						//si no hay novedades, devuelve 3 (salida temprano)
						$respuesta=3;
					}else{
						$respuesta=1;
					}
				}else{
					$respuesta=1;
				}
			}
		}
	}
	return $respuesta;
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
				where month(ab.prgfecha)='$mes' and year(ab.prgfecha)=year(curdate()) and ab.slncodigo='$salon'
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
								AND ap.slncodigo=".$salon." and month(ap.prgfecha)=".$mes." and year(ap.prgfecha)=year(curdate())
								union
								select apt.aptnombre,count(ap.aptcodigo) as cantidad
								from btyasistencia_procesada ap 
								join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
								where ap.clbcodigo=".$row['clbcodigo']." 
								and ap.aptcodigo = 3
								AND ap.slncodigo=".$salon." and month(ap.prgfecha)=".$mes." and year(ap.prgfecha)=year(curdate())
								union
								select apt.aptnombre,count(ap.aptcodigo) as cantidad
								from btyasistencia_procesada ap 
								join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
								where ap.clbcodigo=".$row['clbcodigo']."
								and ap.aptcodigo = 4
								AND ap.slncodigo=".$salon." and month(ap.prgfecha)=".$mes." and year(ap.prgfecha)=year(curdate())
								union
								select apt.aptnombre,count(ap.aptcodigo) as cantidad
								from btyasistencia_procesada ap 
								join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
								where ap.clbcodigo=".$row['clbcodigo']."
								and ap.aptcodigo = 6
								AND ap.slncodigo=".$salon." and month(ap.prgfecha)=".$mes." and year(ap.prgfecha)=year(curdate())
								union
								select apt.aptnombre,count(DISTINCT(ap.prgfecha)) as cantidad
								from btyasistencia_procesada ap 
								join btyasistencia_procesada_tipo apt on ap.aptcodigo=apt.aptcodigo
								where ap.clbcodigo=".$row['clbcodigo']."
								and ap.aptcodigo = 5
								AND ap.slncodigo=".$salon." and month(ap.prgfecha)=".$mes." and year(ap.prgfecha)=year(curdate())
								union
								select null,count(*) from btyasistencia_biometrico ab 
								where ab.abmerroneo=1 and ab.clbcodigo=".$row['clbcodigo']." 
								AND ab.slncodigo=".$salon." AND MONTH(ab.abmfecha)=".$mes." and year(ab.abmfecha)=year(curdate())";

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
	        url:'modalasistencia.php',
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
	        url:'modalasistencia.php',
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
	        url:'modalasistencia.php',
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
	        url:'modalasistencia.php',
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
	        url:'modalasistencia.php',
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
	        url:'modalasistencia.php',
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