<?php 
  header("Content-Type: Application/Json");
  //session_start();
  include '../../cnx_data.php';
  include '../php/funciones.php';

  $detallesBiometrico   = json_decode($_POST['datos'],true);
  $tam=count($detallesBiometrico);
  $cont=0;
  $noins=0;
  $actu=0;
  $error=0;



  if (is_array($detallesBiometrico) || is_object($detallesBiometrico))
  {

          foreach($detallesBiometrico as $obj)
          {
              
              $codbio       = $obj['codbio'];
              $codcol       = $obj['codcol'];
              $estado       = $obj['tipo'];
              $fecha        = $obj['fecha'];
              $hora         = trim($obj['hora']);
              $codsln       = $obj['codsal'];
              $nuevo        = $obj['esnuevo'];
              $eserror      = $obj['eserror'];
              $detalleerror = $obj['esdetalleerror'];

              $maximo = mysqli_query($conn, "SELECT MAX(abmcodigo) AS maxid FROM btyasistencia_biometrico");

              $res = mysqli_fetch_array($maximo);

              $maxid = $res[0] + 1;

               $colaborador = mysqli_query($conn, "SELECT DISTINCT a.clbcodigo, ter.trcrazonsocial FROM btyasistencia_biometrico a JOIN btycolaborador t ON t.clbcodigo=a.clbcodigo JOIN btytercero ter ON ter.trcdocumento=t.trcdocumento WHERE a.clbcodigo = $codcol GROUP BY a.clbcodigo, ter.trcrazonsocial");     
               $fila = mysqli_fetch_array($colaborador);  
                   
               $val=  validarRegistroBio($codcol, $fecha, $hora, $codsln, $nuevo, $conn);                      

                  if ($val=="true") 
                  {                     
                      /*$sql = "INSERT INTO btyasistencia_biometrico (abmcodigo, clbcodigo, slncodigo, abmtipo, abmfecha, abmhora, abmerroneo, abmnuevotipo, abmtipoerror) 
                      VALUES($maxid, $codcol, $codsln, '$estado', '$fecha', '$hora', '3', '', '')";*/

                      $sql = "INSERT INTO btyasistencia_biometrico (clbcodigo, slncodigo, abmtipo, abmfecha, abmhora, abmerroneo, abmnuevotipo, abmtipoerror) 
                      VALUES( $codcol, $codsln, '$estado', '$fecha', '$hora', '3', '', '')";

                      $query = mysqli_query($conn, $sql);
                      //echo $sql;
                      if($query)
                      {
                        $cont++;
                      }
                  }
                  else if($val=="false")
                  {

                      /*$sql="SELECT abmcodigo FROM btyasistencia_biometrico where clbcodigo=$codcol AND slncodigo=$codsln AND abmtipo='$estado' AND abmfecha='$fecha' AND abmhora='$hora'";
                      $res=$conn->query($sql);
                      $row=$res->fetch_assoc();
                      $codupd=$row['abmcodigo'];

                      $sql2="UPDATE btyasistencia_biometrico SET clbcodigo=$codcol, slncodigo=$codsln, abmtipo='$estado', abmfecha='$fecha', abmhora='$hora' where abmcodigo=$codupd";
                      if($conn->query($sql2)){*/
                        $actu++;
                      //}
                    

                  }   
                  else if($val=="error")
                  {
                    /*ARRAY QUE ACUMULA LOS REGISTROS QUE NO SE INSERTARON POR TENER ERRORES */
                          $vecerr[$noins][0]=$codcol;   
                          $vecerr[$noins][1]=$fila[1];  
                          $vecerr[$noins][2]=$codsln;   
                          if(!is_numeric($codcol))
                          {
                            $vecerr[$noins][3]="Colaborador sin codigo en Beauty"; 
                          }
                          else if($estado="NO DEFINIDO")
                          {
                            $vecerr[$noins][3]="Entrada/Salida NO definida"; 
                          }
                           
                          $noins++;$error++;            
                  }

          }

          /*FUNCION QUE HACE COMPATIBLE LOS CARACTERES ESPECIALES QUE PUEDAN CONTENER LOS REGISTROS*/
          function utf8_converters($array){
            array_walk_recursive($array, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
              }
            });
            return $array;
          }

          $vecerr= utf8_converters($vecerr);

          /******************************************************************************/
          /*FUNCION QUE ELIMINA LOS REGISTROS ERRONEOS QUE ESTEN REPETIDOS EN EL ARRAY QUE LOS ACUMULA*/
          function distincts($items) {
            $result=[];$j=0;$flag=0;$cont=1;
            $result[0]=$items[0];
            for($i=1;$i<count($items);$i++)
            {
                for($j=0;$j<count($result);$j++)
                {
                  if($items[$i][0]!=$result[$j][0]){
                    $flag=0;
                  }else{
                    $flag=1;
                    $j=count($result);
                  }
                
                }
                if($flag==0){
                  $result[$cont]=$items[$i];
                  $cont++;
                }
            }

            return $result;
          }
            $vector=distincts($vecerr);
            //$vector=$vecerr;



          /******************************************************************************/

          
          /******************************************************************************/
          
          if($tam==$cont){
            $resp= json_encode(array("RES"=>"TRUE","TINS"=>$cont,"TAM"=>$tam));
          }else if(($cont>0)||($actu>0)){
            $resp= json_encode(array("RES"=>"FALSE","ACTU"=>$actu,"TAM"=>$tam,"ERR"=>$error,"TINS"=>$cont,"VECERR"=>$vector));
          }else if(($cont==0)&&($actu==0)){
            $resp= json_encode(array("RES"=>"ERROR","ACTU"=>$actu,"TAM"=>$tam,"ERR"=>$error,"TINS"=>$cont));
          }
          //control de logs
          $coduser=$_SESSION['codigoUsuario'];
          $sqllogcons="SELECT if(max(lgbcodigo) is NULL,1,max(lgbcodigo)+1) from btylog_biometrico_cargacsv";
          $reslogcons=$conn->query($sqllogcons);
          $rowlogcons=$reslogcons->fetch_array();
          $consec=$rowlogcons[0];
          
          $sqllog="INSERT into btylog_biometrico_cargacsv (lgbcodigo,lgbfecha,lgbhora,usucodigo,lgbregistros_total,lgbregistros_insertados,lgbregistros_error) 
                        VALUES ($consec,curdate(),curtime(),$coduser,$tam,$cont,$error)";
          if($conn->query($sqllog)){
            echo $resp;
          }else{
            json_encode(array("RES"=> $sqllog));
          }
  }
  else
  {
    echo "No es arreglo u objeto";
  }
  //echo $length;
 
?>