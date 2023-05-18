<?php 
include '../../cnx_data.php';
$opc=$_POST['opc'];
switch($opc){
    case 'loadsln':
        $sql = mysqli_query($conn, "SELECT s.slncodigo, s.slnnombre, CONCAT(s.slntelefonofijo,' - ', s.slnextensiontelefonofijo) AS slntelefonoext,s.slntelefonomovil, s.slnimagen FROM btysalon s WHERE s.slnestado=1");

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
