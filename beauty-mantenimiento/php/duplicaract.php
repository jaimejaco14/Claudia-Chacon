<?php 
session_start();
include '../../cnx_data.php';
$idact=$_POST['idact'];

$sql2="SELECT IF(MAX(c.actcodigo) IS NULL,1, MAX(c.actcodigo)+1) FROM btyactivo AS c";
$res=$conn->query($sql2);
$row=$res->fetch_array();
$maxcod=$row[0];
$sw=false;
$mypath="../../contenidos/activos/".$maxcod."";
if (!file_exists($mypath)) {
    if(mkdir($mypath, 0777)){
        $sw=true;
    }else{
        $sw=false;
    }
}else{
    $sw=true;
}

if($sw){
	$sql="INSERT INTO btyactivo (actcodigo, pracodigo, marcodigo, sbgcodigo, actcodigoexterno, actnombre, actmodelo, actespecificaciones, actdescripcion, actserial, actfechacompra, actcosto_base, actcosto_impuesto, prvcodigo, paicodigo, fabcodigo, actfechainicio, actgtia_tiempo, actgtia_tiempo_valor, unacodigo_tiempo, actgtia_uso, actgtia_uso_valor, unacodigo_uso, actimagen, actreq_mant_prd, actfreq_mant, actreq_rev_prd, actfreq_rev, actreq_insumos, actreq_repuestos, actgenerico, actestado)	SELECT (SELECT IF(MAX(c.actcodigo) IS NULL,1, MAX(c.actcodigo)+1) FROM btyactivo AS c),a.pracodigo,a.marcodigo,a.sbgcodigo, NULL,a.actnombre,a.actmodelo,a.actespecificaciones,a.actdescripcion, NULL,a.actfechacompra,a.actcosto_base,a.actcosto_impuesto,a.prvcodigo,a.paicodigo,a.fabcodigo,a.actfechainicio,a.actgtia_tiempo,a.actgtia_tiempo_valor,a.unacodigo_tiempo,a.actgtia_uso,a.actgtia_uso_valor,a.unacodigo_uso,'default.jpg',a.actreq_mant_prd,a.actfreq_mant,a.actreq_rev_prd,a.actfreq_rev,a.actreq_insumos,a.actreq_repuestos,a.actgenerico,1
		FROM btyactivo a
		WHERE actcodigo=$idact";

	if($conn->query($sql)){
		$sqlla="SELECT m.arecodigo_nue
				FROM btyactivo_movimiento m
				WHERE m.actcodigo=$idact
				and m.mvaconsecutivo=(select max(ma.mvaconsecutivo) from btyactivo_movimiento ma where ma.actcodigo=$idact and ma.mvaestado='EJECUTADO')";
		$resla=$conn->query($sqlla);
		$lugareact=$resla->fetch_array();
		if($lugareact[0]!=null){
			$area=$lugareact[0];
		}else{
			$area=0;
		}

		$selmax="SELECT if(MAX(c.mvaconsecutivo) is null,1,MAX(c.mvaconsecutivo)+1) FROM btyactivo_movimiento c";
        $resmax=$conn->query($selmax);
        $mov=$resmax->fetch_array();
        $usureg=$_SESSION['codigoUsuario'];
        $usueje=$_SESSION['codigoUsuario'];

        $sqlmov="INSERT INTO btyactivo_movimiento (mvaconsecutivo,mvafecharegistro,mvahoraregistro,mvafechaejecucion,mvahoraejecucion,actcodigo,arecodigo_ant,arecodigo_nue,mvadescripcion,usucodigo_registro,usucodigo_ejecuta,mvaestado) VALUES ($mov[0],curdate(),curtime(),curdate(),curtime(),$maxcod,0,$area,'UBICACION INICIAL DEL ACTIVO',$usureg,$usueje,'EJECUTADO')";
        if($conn->query($sqlmov)){
        	$sw2=true;
            $sqlubic="INSERT INTO btyactivo_ubicacion (actcodigo,arecodigo,ubcdesde,ubchasta,mvaconsecutivo) VALUES ($maxcod,$area,curdate(),null,$mov[0])";
            if($conn->query($sqlubic)){
				$sql3="SELECT * FROM btyactivo_insumo_detalle WHERE actcodigo=$idact AND indestado=1";
				$res3=$conn->query($sql3);
				if($res3->num_rows>0){
					while($row3=$res3->fetch_array()){
						$codins=$row3['inscodigo'];
						$cant=$row3['indcantidad'];
						$sql4="INSERT INTO btyactivo_insumo_detalle (inscodigo,actcodigo,indcantidad,indestado) values ($codins,$maxcod,$cant,1)";
						if($conn->query($sql4)){
							$sw2=true;
						}else{
							$error.= 'err-dupl-ins•';
						}
					}
				}
				$sql5="SELECT * FROM btyactivo_repuesto_detalle WHERE actcodigo=$idact AND redestado=1";
				$res5=$conn->query($sql5);
				if($res5->num_rows>0){
					while($row5=$res5->fetch_array()){
						$codrep=$row5['repcodigo'];
						$cant=$row5['redcantidad'];
						$sql6="INSERT INTO btyactivo_repuesto_detalle (repcodigo,actcodigo,redcantidad,redestado) values ($codrep,$maxcod,$cant,1)";
						if($conn->query($sql6)){
							$sw2=true;
						}else{
							$error.= 'err-dupl-rep•';
						}
					}
				}

				if($sw2){
					echo 'true';
				}else{
					echo $error;
				}
            }else{
                echo "ubic•".$sqlubic;
            }
        }else{
            echo "mov•".$sqlmov;
        }

	}else{
		echo 'error-insert';
	}
}else{
	echo 'error-carpeta';
}

?>
