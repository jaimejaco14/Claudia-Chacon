<?php 
session_start();
include '../../cnx_data.php'; 
//$granombre = $_POST['graname'];
if ($cod = $_POST['codigo']) {

   $str="";
    /////////////generalidades////////////
        $atcnombre = strtoupper($_POST['act_name']);
            $str.="actnombre='".$atcnombre."',";

        $marca = $_POST["marcas"];  
        if($marca!=0){
            $str.="marcodigo=".$marca.",";

        }
        $modl = $_POST["modelo"]; 
            $str.="actmodelo='".$modl."',";

        $espf = $_POST["especificaciones"];
            $str.="actespecificaciones='".$espf."',";

        if($_POST['generico']){
            $gen=1;
        }else{
            $gen=0;
        }   $str.="actgenerico=".$gen.",";

        if($_POST['serial']!=''){
            $serial = $_POST["serial"];
            $str.="actserial='".$serial."',";
        }else{
            $str.="actserial=null,";
        }

        $desc =strtoupper($_POST["marcadescripcion"]);
            $str.="actdescripcion='".$desc."',";
    ////////////datos compra//////////////

        if($_POST['marcafecha']!=''){
            $fecom = $_POST["marcafecha"];
            $str.="actfechacompra='".$fecom."',";
        }else{
            $str.="actfechacompra=null,";
        }

        if(($_POST['provdor']!='') || ($_POST['provdor']!=0)){
            $prove=$_POST['provdor'];
            $str.="prvcodigo=".$prove.",";
        }

        if($_POST['fabrica']!=0){
            $fabrica=$_POST['fabrica'];
            $str.="fabcodigo=".$fabrica.",";
        }

        if($_POST['pais']!=0){
            $pais=$_POST['pais'];
            $str.="paicodigo=".$pais.",";
        }

        if($_POST['fechainicio']!=''){
            $fechini="'".$_POST['fechainicio']."'";
            $str.="actfechainicio=".$fechini.",";
        }else{
            $str.="actfechainicio=null,";
        }  

        if($_POST['codigo_externo']!=''){
            $codex = $_POST["codigo_externo"];  
            $str.="actcodigoexterno='".$codex."',";
        }else{
            $str.="actcodigoexterno=null,";
        }

        $costo=$_POST['costobase'];
            $str.="actcosto_base='".$costo."',";

        $imp=$_POST['impuesto'];
            $str.="actcosto_impuesto='".$imp."',";
    /////////////clasificacion//////////////
        $gruactivo= $_POST["subgrupoactivo"];
        if($gruactivo!=0){
            $str.="sbgcodigo=".$gruactivo.",";
        }
    /////////////////mantenimiento//////////
        $prio=$_POST['prioridad'];
        if($prio!=0){
            $str.="pracodigo=".$prio.",";
        }
        if(($_POST['mttosw']) && ($_POST['freqmtto']!='') && ($_POST['freqmtto']!=0)){
            $swmtto=1;
            $valmtto=$_POST['freqmtto'];
            $str.="actreq_mant_prd=1,actfreq_mant='".$valmtto."',";
        }else{
            $swmtto=0;
            $valmtto=0;
            $str.="actreq_mant_prd=0,actfreq_mant='".$valmtto."',";
        }
        if(($_POST['revsw']) && ($_POST['freqrev']!='') && ($_POST['freqrev']!=0)){
            $swrev=1;
            $valrev=$_POST['freqrev'];
            $str.="actreq_rev_prd=1,actfreq_rev='".$valrev."',";
        }else{
            $swrev=0;
            $valrev=0;
            $str.="actreq_rev_prd=0,actfreq_rev='".$valrev."',";
        }
    ///////////////garantia/////////////////
        if(($_POST['garactsw']) && ($_POST['unitime']!=0) && ($_POST['timegar']!='') && ($_POST['timegar']!=0)){
            $garant=1;
            $unitime=$_POST['unitime'];
            $timegar=$_POST['timegar'];
            $str.="actgtia_tiempo=1,actgtia_tiempo_valor='".$timegar."',unacodigo_tiempo=".$unitime.",";
        }else if(!$_POST['garactsw']){
            $garant=0;
            $unitime=0;
            $timegar=0;
            $str.="actgtia_tiempo=0,actgtia_tiempo_valor=0,unacodigo_tiempo=0,";
        }
        if(($_POST['garactsw2']) && ($_POST['uniuso']!=0) && ($_POST['cantuso']!='') && ($_POST['cantuso']!=0)){
            $garanu=1;
            $uniuso=$_POST['uniuso'];
            $cantuso=$_POST['cantuso'];
            $str.="actgtia_uso=1,actgtia_uso_valor='".$cantuso."',unacodigo_uso=".$uniuso.",";
        }else if((!$_POST['garactsw2'])){

            $garanu=0;
            $uniuso=0;
            $cantuso=0;
            $str.="actgtia_uso=0,actgtia_uso_valor=0,unacodigo_uso=0,";
        }
        else{
        }
    //////////////insumos////////////////////
        if($_POST['insumos']){
            $str.="actreq_insumos=1,";
        }else{
            $str.="actreq_insumos=0,";
        }
    ////////////repuestos///////////////////
        if($_POST['swrepuesto']){
            $str.="actreq_repuestos=1";
        }else{
            $str.="actreq_repuestos=0";
        }




    $imagen = $_FILES['imagen']['name'];
    if ("" != $_FILES['imagen']['name']){

        $ruta = "../../contenidos/imagenes/activo/";
        $img_name = $_FILES['imagen']['name'];
       
        $archivo = $_FILES['imagen']['tmp_name']; 
        $partes_nombre = explode('.', $img_name);
        $extension =  strtolower(end( $partes_nombre ));
         move_uploaded_file($archivo,$ruta.$cod.".".$extension);
         $str.= ", actimagen= '".$cod.".".$extension."'";

    }  else {
        $str .= "";
    }
    $mypath="../../contenidos/activos/".$cod."";
        $sw=false;
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

        $sql = "UPDATE btyactivo SET ".$str." WHERE actcodigo = $cod";
        //echo $sql;
                if (mysqli_query($conn, $sql)) {
                    echo "TRUE";
                    //$conn->close();
                } else {
                    echo 'false';echo $sql;
                }
        }else{
            echo 'boom';
        }
}  
else if ($atcnombre = strtoupper($_POST['act_name'])) {
    $marca = $_POST["marcas"];  
    $gruactivo= $_POST["subgrupoactivo"];
    if($_POST["codigo_externo"]==''){
        $codex = 'null';     
    }else{
        $codex = "'". $_POST['codigo_externo']."'";
    }
    $modl = $_POST["modelo"]; 
    $espf = $_POST["especificaciones"];
    $desc = strtoupper($_POST["marcadescripcion"]);
    if($_POST["serial"]==''){
        $serial = 'null';
    }else{
         $serial ="'". $_POST['serial']."'";
    }
    if($_POST["marcafecha"]==''){    
        $fecom = 'null';
    }else{
       $fecom="'".$_POST['marcafecha']."'";
    }
    $imagen = $_FILES['imagen']['name'];
    if($_POST['selar']){
        $areanew=$_POST['selar'];
    }else{
        $areanew=0;
    }

    if($_POST['generico']){
        $gen=1;
    }else{
        $gen=0;
    }   
    $prove=$_POST['proveedor'];
    $fabrica=$_POST['fabrica'];
    $pais=$_POST['pais'];
    $costo=$_POST['costobase'];
    $imp=$_POST['impuesto'];
    $prio=$_POST['prioridad'];

    if($_POST['fechainicio']==''){
        $fechini='null';
    }else{
        $fechini="'".$_POST['fechainicio']."'";
    }

    if($_POST['garactsw']){
        $garant=1;
        $unitime=$_POST['unitime'];
        $timegar=$_POST['timegar'];
    }else{
        $garant=0;
        $unitime=0;
        $timegar=0;
    }
    if($_POST['garactsw2']){
        $garanu=1;
        $uniuso=$_POST['uniuso'];
        $cantuso=$_POST['cantuso'];
    }else{
        $garanu=0;
        $uniuso=0;
        $cantuso=0;
    }

    if($_POST['insumos']){
        $swins=1;
    }else{
        $swins=0;
    }
    if($_POST['rptos']){
        $rptos=1;
    }else{
        $rptos=0;
    }

    if(($_POST['mttosw']) && ($_POST['mttosw']=='on')){
        $swmtto=1;
        $valmtto=$_POST['freqmtto'];
    }else{
        $swmtto=0;
        $valmtto=0;
    }
    if(($_POST['revsw']) && ($_POST['revsw']=='on')){
        $swrev=1;
        $valrev=$_POST['freqrev'];
    }else{
        $swrev=0;
        $valrev=0;
    }



    $max ="SELECT MAX(actcodigo) as m FROM btyactivo";    
    $result = $conn->query($max);
    if ($result->num_rows > 0) {
         while($row = $result->fetch_assoc()) {
            $cod = $row["m"];
        }
    }
    $cod = $cod + 1;

    if ("" != $_FILES['imagen']['name']){

        $ruta = "../../contenidos/imagenes/activo/";
        $img_name = $_FILES['imagen']['name'];
       
        $archivo = $_FILES['imagen']['tmp_name']; 
        $partes_nombre = explode('.', $img_name);
        $extension = end( $partes_nombre );
         move_uploaded_file($archivo,$ruta.$cod.".".$extension);
         $img_name = $cod.".".$extension;
        } else {

            $img_name = "default.jpg";
        }
        $usureg=$_SESSION['codigoUsuario'];
        $usueje=$_SESSION['codigoUsuario'];

        $mypath="../../contenidos/activos/".$cod."";
        $sw=false;
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
            $query="INSERT INTO btyactivo (actcodigo, pracodigo, marcodigo, sbgcodigo, actcodigoexterno, actnombre, actmodelo, actespecificaciones, actdescripcion, actserial, actfechacompra, actcosto_base, actcosto_impuesto, prvcodigo, paicodigo, fabcodigo, actfechainicio, actgtia_tiempo, actgtia_tiempo_valor, unacodigo_tiempo, actgtia_uso, actgtia_uso_valor, unacodigo_uso, actimagen, actreq_mant_prd, actfreq_mant, actreq_rev_prd, actfreq_rev, actreq_insumos, actreq_repuestos, actgenerico, actestado) VALUES ($cod, $prio, $marca, $gruactivo, $codex, '$atcnombre', '$modl', '$espf', '$desc', $serial, $fecom, '$costo', '$imp', $prove, $pais, $fabrica, $fechini, $garant, $timegar, $unitime, $garanu, $cantuso, $uniuso, '$img_name', $swmtto, $valmtto, $swrev, $valrev, $swins, $rptos, $gen, 1)";
            if (mysqli_query($conn, $query)) {
                $selmax="SELECT if(MAX(c.mvaconsecutivo) is null,1,MAX(c.mvaconsecutivo)+1) FROM btyactivo_movimiento c";
                $resmax=$conn->query($selmax);
                $max=$resmax->fetch_array();

                $sqlmov="INSERT INTO btyactivo_movimiento (mvaconsecutivo,mvafecharegistro,mvahoraregistro,mvafechaejecucion,mvahoraejecucion,actcodigo,arecodigo_ant,arecodigo_nue,mvadescripcion,usucodigo_registro,usucodigo_ejecuta,mvaestado) VALUES($max[0],curdate(),curtime(),curdate(),curtime(),$cod,0,$areanew,'UBICACION INICIAL DEL ACTIVO',$usureg,$usueje,'EJECUTADO')";
                if($conn->query($sqlmov)){
                    $sqlubic="INSERT INTO btyactivo_ubicacion (actcodigo,arecodigo,ubcdesde,ubchasta,mvaconsecutivo) VALUES ($cod,$areanew,curdate(),null,$max[0])";
                    if($conn->query($sqlubic)){
                      echo "TRUE•".$cod;
                    }else{
                        echo "ubic•".$sqlubic;
                    }
                }else{
                    echo "mov•".$sqlmov;
                }
            } else {
                echo "insert•".$query;
            }
        }else{
            echo "error•".$mypath;
        }
}
?>