<?php 
include '../../cnx_data.php'; 
$opc=$_POST['opc'];
switch($opc){
    case 'loadactivo':
        $sql = "SELECT ac.actcodigo, ac.actnombre, ac.actimagen, al.lugnombre
                FROM btyactivo ac
                JOIN btyactivo_ubicacion au on au.actcodigo=ac.actcodigo 
                JOIN btyactivo_area aa on aa.arecodigo=au.arecodigo
                JOIN btyactivo_lugar al on al.lugcodigo=aa.lugcodigo
                WHERE ac.actestado = 1 and au.ubchasta is null
                ORDER BY ac.actnombre";
        $res=$conn->query($sql);
        if($res->num_rows>0){
            while($data = mysqli_fetch_assoc($res)){
                $array['data'][] = $data;
            }
        }else{
            $array=array('data'=>'');
        }
        echo json_encode($array);
    break;
}
?>

