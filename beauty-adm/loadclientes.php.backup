<?php 
include '../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
    case 'loadcli':
        $sql = mysqli_query($conn, "SELECT tdi.tdialias,c.trcdocumento, t.trcrazonsocial, if(c.clisexo='' or c.clisexo is null,'N/D',upper(c.clisexo)) as clisexo, t.trctelefonomovil, c.clifecharegistro, if(c.slncodigo=0,'N/D',s.slnnombre) as slnnombre, IF(c.clitiporegistro='INTERNO-PDF417','ESCANER',c.clitiporegistro) AS tiporeg
                    FROM btycliente c
                    JOIN btytercero t ON t.trcdocumento = c.trcdocumento
                    JOIN btytipodocumento tdi ON c.tdicodigo = tdi.tdicodigo
                    JOIN btysalon s on s.slncodigo=c.slncodigo
                    WHERE c.cliestado = 1
                    order by t.trcrazonsocial");

                $array = array();

            if(mysqli_num_rows($sql) > 0){
                
                while($data = mysqli_fetch_assoc($sql)){
                      $array['data'][] = $data;
                }        
             
                    $array= utf8_converter($array);
            
            }
            else{
                  $array=array('data'=>'');
            }
            echo json_encode($array);
    break;
    case 'detcli':
       mysqli_set_charset($conn,"utf8");
        $id=$_POST['id'];
        $sql="SELECT td.tdialias as td,t.trcdocumento as numdoc,t.trcnombres as nom,t.trcapellidos as ape, if(c.clisexo='','N/D', ifnull(c.clisexo,'N/D')) as sex,c.clifechanacimiento as fnac,t.trctelefonomovil as celu,c.cliemail as mail
                FROM btytercero t
                JOIN btytipodocumento td on td.tdicodigo=t.tdicodigo
                JOIN btycliente c ON c.trcdocumento=t.trcdocumento AND c.tdicodigo=t.tdicodigo
                where t.trcdocumento=$id";
        $res=$conn->query($sql);
        $row=$res->fetch_array();
        echo json_encode(array('td'=>$row['td'],'numdoc'=>$row['numdoc'],'nom'=>$row['nom'],'ape'=>$row['ape'],'sex'=>strtoupper($row['sex']),'fnac'=>$row['fnac'],'celu'=>$row['celu'],'mail'=>$row['mail']));
    break;
    case 'savecli':
        mysqli_set_charset($conn,"utf8");
        $cliced=$_POST['cliced'];
        $clinom=strtoupper($_POST['clinom']);
        $cliape=strtoupper($_POST['cliape']);
        $clifullname=$clinom.' '.$cliape;
        $clisex=strtoupper($_POST['clisex']);
        $clifna=$_POST['clifna'];
        $clitel=$_POST['clitel'];
        $climail=$_POST['climail'];
        $sql="UPDATE btytercero t
                JOIN btycliente c ON c.trcdocumento=t.trcdocumento AND c.tdicodigo=t.tdicodigo 
                SET t.trcnombres='$clinom', t.trcapellidos='$cliape', t.trcrazonsocial='$clifullname', c.clisexo='$clisex', c.clifechanacimiento='$clifna', t.trctelefonomovil='$clitel', c.cliemail='$climail' WHERE t.trcdocumento=$cliced";
        if($conn->query($sql)){
            echo 1;
        }else{
            echo 0;
        }
    break;
}
function utf8_converter($array){
    array_walk_recursive($array, function(&$item, $key){
        if(!mb_detect_encoding($item, 'utf-8', true))
        {
            $item = utf8_encode($item);
        }
    });

    return $array;
}
?>
