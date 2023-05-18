<?php 
include '../../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
	case 'loadtipoid':
		/*$sql="SELECT td.tdicodigo,td.tdinombre FROM btytipodocumento td WHERE td.tdiestado=1";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['tdicodigo'],'nom'=>$row['tdinombre']);
		}
		echo json_encode($array);*/
	break;
	case 'loadeps':
		$sql="SELECT epscodigo,epsnombre FROM btycolaborador_eps WHERE epsestado=1 ORDER BY epsnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['epscodigo'],'nom'=>utf8_encode($row['epsnombre']));
		}
		echo json_encode($array);
	break;
	case 'loadafp':
		$sql="SELECT afpcodigo,afpnombre FROM btycolaborador_afp WHERE afpestado=1 ORDER BY afpnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=array('cod'=>$row['afpcodigo'],'nom'=>$row['afpnombre']);
		}
		echo json_encode($array);
	break;
	case 'loadbarrio':
		$sql="SELECT b.brrcodigo,b.brrnombre FROM btybarrio b WHERE b.brrstado=1 order by b.brrnombre";
		$res=$conn->query($sql);
		while($row=$res->fetch_array()){
			$array[]=(array('cod'=>$row['brrcodigo'],'nom'=>utf8_encode($row['brrnombre'])));
		}
		echo json_encode($array);
	break;
	case 'veract':
		$clb=$_POST['clb'];
		$sql="SELECT (
				SELECT cdp.cdpfecha
				FROM btycolaborador_datosper cdp
				WHERE cdp.clbcodigo=$clb AND cdp.cdpaprobado=1 order by cdp.cdpfecha desc limit 1) AS cdp,
				(
				SELECT cs.csfecha
				FROM btycolaborador_salud cs
				WHERE cs.clbcodigo=$clb AND cs.csaprobado=1 order by cs.csfecha desc limit 1) AS cs,
				(
				SELECT cif.ciffecha
				FROM btycolaborador_infofa cif
				WHERE cif.clbcodigo=$clb AND cif.cifaprobado=1 order by cif.ciffecha desc limit 1) AS cif";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		$array=array('cdp'=>$row['cdp'],'cs'=>$row['cs'],'cif'=>$row['cif']);
		echo json_encode($array);
	break;
	case 'savecdp':
		$clb=$_POST['clb'];
		$add=$_POST['address'];
		$bar=$_POST['barrio'];
		$pho=$_POST['phone'];
		$mail=$_POST['mail'];
		mysqli_set_charset($conn, 'utf8');
		$upd="UPDATE btycolaborador_datosper SET cdpestado=0 WHERE clbcodigo=$clb";
		if($conn->query($upd)){
			$ins="INSERT INTO btycolaborador_datosper (clbcodigo,cdpdireccion,cdpbrrcodigo,cdpcelular,cdpmail,cdpfecha) VALUES ($clb,'$add',$bar,'$pho','$mail',now())";
			if($conn->query($ins)){
				echo 1;
			}else{
				echo $ins;
			}
		}else{
			echo 2;
		}
	break;
	case 'savesb':
		$clb=$_POST['clb'];
		//info general de salud
		$eps=$_POST['eps'];
		$afp=$_POST['afp'];
		$estsalud=$_POST['estsalud'];
		$enfer=$_POST['enfermedad'];
		$detenf=$_POST['detenf'];
		$rest=$_POST['restriccion'];
		$detrest=$_POST['detrest'];
		$ciru=$_POST['cirugia'];
		$detciru=$_POST['detcirugia'];
		$hosp=$_POST['hospital'];
		$dethosp=$_POST['dethosp'];
		$trata=$_POST['tratamto'];
		$dettra=$_POST['dettrata'];
		//contacto emergencia
		$nomem=$_POST['nomem'];
		$parem=$_POST['parem'];
		$direm=$_POST['direm'];
		$celem=$_POST['celem'];
		//dotacion
		$tcam=$_POST['tallacam'];
		$tpan=$_POST['tallapan'];
		$tgua=$_POST['tallagua'];
		//inf judicial
		$jud=$_POST['judicial'];
		$detjud=$_POST['detjud'];
		///////////////////////////////////////
		//se inserta el contacto de emergencia y se obtiene el id consecutivo
		mysqli_set_charset($conn, 'utf8');
		$sql="INSERT INTO btycolaborador_contacto (clbcodigo,cemnombre,cemparentesco,cemdireccion,cemtelefono,cemestado) VALUES ($clb,'$nomem','$parem','$direm','$celem',1)";
		if ($conn->query($sql)) {
		    $cemcod = mysqli_insert_id($conn);
		    //se inserta la información de salud
		    $upd2="UPDATE btycolaborador_salud SET csestado=0 WHERE clbcodigo=$clb";
			if($conn->query($upd2)){
			    $ins="INSERT INTO btycolaborador_salud (clbcodigo,afpcodigo,epscodigo,cemcodigo,csestsalud,csenfermedad,csdescenfermedad,csrestriccion,csdescrestriccion,cscirugia,csdesccirugia,cshospital,csdeschospital,cstratamiento,csdesctratamiento,cstcam,cstpan,cstgua,csjudi,csdetjudi,csfecha) VALUES ($clb,$afp,$eps,$cemcod,$estsalud,$enfer,'$detenf',$rest,'$detrest',$ciru,'$detciru',$hosp,'$dethosp',$trata,'$dettra','$tcam','$tpan','$tgua',$jud,'$detjud',now())";
			    if($conn->query($ins)){
			    	echo 1;
			    }else{
			    	echo $ins;
			    }
			}else{
				echo 4;
			}
		} else {
			echo 0;
		}
	break;
	case 'saveif':
		$clb=$_POST['clb'];
		//info estado civil
		$cvl=$_POST['civil'];
		$nomc=trim($_POST['detcivil']);
		$ocuc=trim($_POST['detcivil2']);
		$telc=trim($_POST['detcivil3']);
		//info hijos
		$son=$_POST['hijos'];
		$nomson=$_POST['nomhijo'];//array
		$datson=$_POST['nachijo'];//array
		//nucleo familiar
		$npadre=trim($_POST['nompadre']);
		$tpadre=trim($_POST['telpadre']);
		$nmadre=trim($_POST['nommadre']);
		$tmadre=trim($_POST['telmadre']);
		$dirpa=trim($_POST['dirpadres']);
		$brrpa=$_POST['barrio2'];
		//hermanos
		$bro=$_POST['brother'];
		$nombro=$_POST['nombro'];//array
		$ocubro=$_POST['ocubro'];//array
		$telbro=$_POST['telbro'];//array
		$agebro=$_POST['agebro'];//array
		/////////////////////////////////
		mysqli_set_charset($conn, 'utf8');
		$updif="UPDATE btycolaborador_infofa SET cifestado=0 WHERE clbcodigo=$clb";
		if($conn->query($updif)){
			$ifsql="INSERT INTO btycolaborador_infofa (clbcodigo,cifestadocivil,cifconyunom,cifconyuocu,cifconyutel,cifhijos,cifnompadre,ciftelpadre,cifnommadre,ciftelmadre,cifdireccpadres,cifbrrcodigo,cifhermanos,ciffecha) 
			VALUES ($clb,$cvl,'$nomc','$ocuc','$telc',$son,'$npadre','$tpadre','$nmadre','$tmadre','$dirpa',$brrpa,$bro,now())";
			if($conn->query($ifsql)){
				$cifcod = mysqli_insert_id($conn);
				//se inserta informacion de hijos si los hay.
				if($son==1){
					$tvec=count($nomson);
					for($i=0;$i<$tvec;$i++){
						if(($nomson[$i]!='') && ($datson[$i]!='')){
							$sql="INSERT INTO btycolaborador_hijos (clbcodigo,cifcodigo,chnombre,chfechana) VALUES ($clb,$cifcod,'$nomson[$i]','$datson[$i]')";
							if(!$conn->query($sql)){
								echo 'H';
								exit;
							}
						}else{
							echo 'H';
							exit;
						}
					}
				}
				//se inserta informacion de los hermanos si tiene.
				if($bro==1){
					$tvec=count($nombro);
					$upd="UPDATE btycolaborador_hermano SET cheestado=0 WHERE clbcodigo=$clb";
					if($conn->query($upd)){
						for($i=0;$i<$tvec;$i++){
							$sql="INSERT INTO btycolaborador_hermano (clbcodigo,cifcodigo,chenombre,cheocupacion,chetelefono,cheedad) VALUES ($clb,$cifcod,'$nombro[$i]','$ocubro[$i]','$telbro[$i]','$agebro[$i]')";
							if(!$conn->query($sql)){
								echo $sql;
								exit;
							}
						}
					}
				}
				echo 1;
			}else{
				echo $ifsql;
			}
		}
	break;
	case 'vcdp':
		$clb=$_POST['clb'];
		$sql="SELECT count(*)
				FROM btycolaborador_datosper cdp
				WHERE cdp.clbcodigo=$clb AND cdp.cdpaprobado=0 and cdp.cdpestado=1";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		if($row[0]==1){
			echo 1;
		}else{
			echo 0;
		}
	break;
	case 'vsb':
		$clb=$_POST['clb'];
		$sql="SELECT count(*)
				FROM btycolaborador_salud cs
				WHERE cs.clbcodigo=$clb AND cs.csaprobado=0 and cs.csestado=1";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		if($row[0]==1){
			echo 1;
		}else{
			echo 0;
		}
	break;
	case 'vif':
		$clb=$_POST['clb'];
		$sql="SELECT count(*)
				FROM btycolaborador_infofa cif
				WHERE cif.clbcodigo=$clb AND cif.cifaprobado=0 and cif.cifestado=1";
		$res=$conn->query($sql);
		$row=$res->fetch_array();
		if($row[0]==1){
			echo 1;
		}else{
			echo 0;
		}
	break;
}

?>