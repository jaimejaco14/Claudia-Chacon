<?php 
include '../cnx_data.php'; 
//se verifica si el post obtiene el vaciado de filtros de datos 
if ($_POST['vaciar']=='si') {
    $_SESSION['fch']="";
    $_SESSION['fc']="";
    $_SESSION['nave']="";
    $_SESSION['dispo']="";
    $_SESSION['nnom']="";
    $_SESSION['sesip']="";
    $_SESSION['actvv']="false";
    $_SESSION['fall']="false";
    $_SESSION['desc']="";
     $_SESSION['contt']="";
}
//se verifica que la fecha de incio del rango no este vacia y si esta vacia se le sera asignado el valor que se guardo en la sesion cuando no estaba vacia
if ($_POST['fchi'] != "") {
    $time = strtotime($_POST['fchi']);
    $fch = date('Y-m-d',$time);
    $_SESSION['fch']=$fch;
}else{
    $fch =$_SESSION['fch'];
}
//se verifica que la fecha final del rango no este vacia y si esta vacia se le sera asignado el valor que se guardo en la sesion cuando no estaba vacia
if ($_POST['fchf']!="") {
    $time1= strtotime($_POST['fchf']);
$fc = date('Y-m-d',$time1);
$_SESSION['fc']=$fc;
}else{
     $fc =$_SESSION['fc'];
}
// la adicion de este codigo permite que la pginacion se pueda hacer cuando una busqueda genera mas de 8 registros, como funciona:
// pregunta si lo que viene pasado por parametro POST no viene vacio, si es asi, entonces se le asignara a una variable de sesion, y cuando el post venga vacio se le asiganara al post 
// la variable de sesion, asi hasta que se limpien los filtros, de igual forma funciona con los parametros posteriores, hasta terminar los parametros de als busqeudas
if ($_POST['nav']!="" and $_POST['nav']!='0') {
   $_SESSION['nave']=$_POST['nav'];
}else if ($_POST['nav']=='0' ){
     $_POST['nav']="";
     $_SESSION['nave']="";
}else{
    $_POST['nav'] =$_SESSION['nave'];
}
if ($_POST['disp']!="" and $_POST['disp']!='0') {
   $_SESSION['dispo']=$_POST['disp'];
}elseif ($_POST['disp']=='0' ){
     $_POST['disp']="";
     $_SESSION['dispo']="";
}else{
    $_POST['disp'] =$_SESSION['dispo'];
}
if ($_POST['nom'] != "") {
       $_SESSION['nnom']=$_POST["nom"];
    }else {
        $_POST["nom"]=$_SESSION['nnom']; 
    }
    if ($_POST['ip'] != "") {
       $_SESSION['sesip']=$_POST["ip"];
    }else {
        $_POST["ip"]=$_SESSION['sesip']; 
    }
    if ($_POST['act'] !="") {
      $_SESSION['actvv']=$_POST['act'];
    }else{
        $_POST['act']=$_SESSION['actvv'];
    }
     if ( $_POST['fall'] != "" ) {
        $_SESSION['fall']=$_POST['fall'];
    }else{
        $_POST['fall']=$_SESSION['fall'];
    }
    if ( $_POST['desc'] != "" ) {
         $_SESSION['desc']=$_POST['desc'];
    }else{
        $_POST['desc']=$_SESSION['desc'];
    }
    if ( $_POST['cont'] != "" ) {
         $_SESSION['contt']=$_POST['cont'];
    }else{
        $_POST['cont']=$_SESSION['contt'];
    }
    
//se verifica que las fechas no esten vacias para poder hacer el filtro de los datos apartir de un rango o se traen todos los registros de la tabla
if ($fch!="" && $fc!="" ) {
       $sql = "SELECT sescodigo, usucodigo, seslogin, sesdireccionipv4wan, sestipodispotivo, sesnavegador, sesfechainicio, seshorainicio, sesfechafin, seshorafin, sesfallida, sesestado FROM btysesiones WHERE (sesfechainicio >='".$fch."' AND sesfechafin <= '".$fc."')";
          }else{
         $sql = "";
                                        	}

    //este es el codigo para adicionar a la consulta las busquedas especiales o avanzadas, es funcional tanto se se ha realizado una busqueda, como si no se ha     realizado ninguna.
    //los codigos de cada uno de los caracteres de busqueda solo varian en sus clasificaciones de variable vacia.
   
    if ($_POST['nav'] != 'null' and $_POST['nav'] !="" ) {
         $sql=$sql." AND ( ";
         $explorer= explode(',',$_POST['nav']);
       for ($i=0;$i<count($explorer)-1;$i++) { 
             $sql=$sql."sesnavegador ='".$explorer[$i]."' OR "; 
             } 
              $sql=$sql."sesnavegador ='".$explorer[$i]."')"; 
    }
    if ($_POST['disp'] != 'null' and $_POST['disp'] !="" ) {
        $sql=$sql." AND ( ";
         $dptivo= explode(',',$_POST['disp']);
       for ($i=0;$i<count($dptivo)-1;$i++) { 
             $sql=$sql."sestipodispotivo ='".$dptivo[$i]."' OR "; 
             } 
              $sql=$sql."sestipodispotivo ='".$dptivo[$i]."')"; 
    }
    if ($_POST['nom'] != "" ) {
        $sql=$sql." AND seslogin like '%".$_POST["nom"]."%'";
    }
    if ($_POST['ip'] != "" ) {
        $sql=$sql." AND sesdireccionipv4wan like '%".$_POST["ip"]."%'";
    }

    if ($_POST['fall'] != 'false' and $_POST['fall'] !="" and $_POST['act'] != 'false' and $_POST['act'] !="" and $_POST['desc'] != 'false' and $_POST['desc'] !="" and $_POST['cont'] != 'false' and $_POST['cont'] !="") {

    }else if ($_POST['fall'] != 'false' and $_POST['fall'] !="" and $_POST['act'] != 'false' and $_POST['act'] !="" and $_POST['desc'] != 'false' and $_POST['desc'] !=""  ) {
       $sql=$sql." AND (sesestado  = 1 OR sesfallida = 1 OR (sesestado  = 0 AND sesfallida = 0))";
     
    }else if ($_POST['fall'] != 'false' and $_POST['fall'] !="" and $_POST['act'] != 'false' and $_POST['act'] !="" and $_POST['cont'] != 'false' and $_POST['cont'] !="") {
      $sql=$sql." AND (sesestado  = 1 OR sesfallida = 1 OR usucodigo  is NULL )";
    }else if ($_POST['desc'] != 'false' and $_POST['desc'] !="" and $_POST['fall'] != 'false' and $_POST['fall'] !="" and $_POST['cont'] != 'false' and $_POST['cont'] !="") {
     $sql=$sql." AND (sesfallida = 1 or (sesestado  = 0 AND sesfallida = 0) OR usucodigo  is NULL ) ";
    }else if ($_POST['desc'] != 'false' and $_POST['desc'] !="" and $_POST['act'] != 'false' and $_POST['act'] !="" and $_POST['cont'] != 'false' and $_POST['cont'] !="") {
      $sql=$sql." AND (sesestado = 1 or (sesestado  = 0 AND sesfallida = 0) OR usucodigo  is NULL ) ";
    }else if($_POST['desc'] != 'false' and $_POST['desc'] !="" and $_POST['act'] != 'false' and $_POST['act'] !="") {
       $sql=$sql." AND (sesestado = 1 or (sesestado  = 0 AND sesfallida = 0) )";
    }else if ($_POST['desc'] != 'false' and $_POST['desc'] !="" and $_POST['fall'] != 'false' and $_POST['fall'] !="") {
      $sql=$sql." AND (sesfallida = 1 or (sesestado  = 0 AND sesfallida = 0) )";
    }else if ($_POST['fall'] != 'false' and $_POST['fall'] !="" and $_POST['act'] != 'false' and $_POST['act'] !="") {
       $sql=$sql." AND (sesestado  = 1 OR sesfallida = 1)";
    }else if ($_POST['desc'] != 'false' and $_POST['desc'] !="" and $_POST['cont'] != 'false' and $_POST['cont'] !="" ) {
      $sql=$sql." AND (usucodigo  is NULL  OR (sesestado  = 0 AND sesfallida = 0))";
    }else if ( $_POST['act'] != 'false' and $_POST['act'] !="" and $_POST['cont'] != 'false' and $_POST['cont'] !="") {
       $sql=$sql." AND (usucodigo  is NULL  OR sesestado  = 1)";
    }else if ($_POST['fall'] != 'false' and $_POST['fall'] !="" and $_POST['cont'] != 'false' and $_POST['cont'] !="") {
      $sql=$sql." AND (usucodigo  is NULL  OR sesfallida = 1)";
    }else{
      if ($_POST['desc'] != 'false' and $_POST['desc'] !="") {
        $sql=$sql." AND (sesestado  = 0 AND sesfallida = 0) ";
      }else if($_POST['fall'] != 'false' and $_POST['fall'] !=""){
         $sql=$sql." AND sesfallida = 1 ";
      }else if ($_POST['act'] != 'false' and $_POST['act'] !="") {
        $sql=$sql." AND sesestado = 1 ";
      }else if($_POST['cont'] != 'false' and $_POST['cont'] !="") {
        $sql=$sql." AND usucodigo  is NULL ";
      }
    }


 
  
    
 ?>
 <div  class="animate-panel">

                <div class="hpanel">
                <div class="panel-heading">
                
                <!--etiqueta que cuenta el numero de registros que se tienen por busqueda o totales-->
                 <span class="label label-success pull-right"> <?php 
                                                               $query_num_colum = $sql; 
                                                               $resul = $conn->query($query_num_colum); $registros = $resul->num_rows; 
                                                               $_SESSION['numrows']= $registros;
                                                               echo " <h6>No. Total de Registros: ".$registros."</h6>";?></span>
                    <h3 class="panel-title">Listado de Sesiones</h3>
                     <?php  
                    //if($fch!="" && $fc!="" ){
                    //    echo "<button class='  btn btn-info btn-sm'  type='' onclick='quitar()'>Remover Filtros</button>";
                   // }
                   // if ($fch=="" && $fc=="" && ($_SESSION['nnom']!="" || $_SESSION['sesip']!="" || $_SESSION['actvv']!="false" && $_SESSION['actvv']!="" || $_SESSION['fall'] !='false' && //$_SESSION['fall'] !="" || $_SESSION['nave']!="" || $_SESSION['dispo']!="" )) {
                    //    echo "<button class='  btn btn-info btn-sm'  type='' onclick='quitar()'>Remover Filtros</button>";
                  //  }
                    ?>
                    <br>
                </div>
                <div class="panel-body">
                    <div class="table-responsive"> 
                    <table class="table table-hover table-bordered table-striped">
                    <!-- inicio de las etiquetas que contiene la tabla -->
                        <thead>
                        <th>No.</th>
                        <th>Usuario</th>
                        <th>Direccion IP</th>
                        <th>Dispositivo</th> 
                        <th>Navegador</th> 
                        <th>Inicio </th>     
                        <th>Fin </th>
                        <th>Estado</th>
                        </thead>
                        <tbody></tbody>
                        <tbody>
                            <?php
                                          
                                            //verificamos el numero de columnas que tengo 
                                            $query_num_col = $sql;
                                            //se conmutan los resultados pertinentes con la varibale de concexion y el metodo disponible.
                                            $result = $conn->query($query_num_col);
                                            $num_total_registros = $result->num_rows;
            
                                            $rowsPerPage = 8;
                                             $pageNum = 1;
                                            //verificacion de que paginacion no esta vacio
                                            if(isset($_POST['page'])) {
                                                $pageNum = $_POST['page'];
                                            }
                                            $offset = ($pageNum - 1) * $rowsPerPage;
                                            $total_paginas = ceil($num_total_registros / $rowsPerPage);
                                            $_SESSION['sqlsesiones']=$sql;
                                          $sql = $sql." order by sescodigo desc limit $offset, $rowsPerPage ";

                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                echo "<script> 
                                                    var b='si';
                                                </script>";
                                                while ($row = $result->fetch_assoc()) {  
                                                //incio de la visualizacion de resultados obtenidos de la consulta.      
                                                    echo "<tr>";
                                echo '<td>' .($row['sescodigo']) . '</td>';
                                echo '<td>' .  strtoupper($row['seslogin']) . '</td>';
                                echo '<td>' . $row['sesdireccionipv4wan'] . '</td>';
                                //estos echo funcionan para añadir las imagenes y los simbolos que se muestran en el formulario
                                if ($row['sestipodispotivo']=="WINDOWS") {
                                    echo '<td class="text-center"><img data-toggle="tooltip" title="WINDOWS" src="imagenes/varios/S.O_windows.png" alt="WINDOWS" width="20px" height="20px"></td>';
                                }else if($row['sestipodispotivo']=="LINUX"){
                                    echo '<td class="text-center"><img data-toggle="tooltip" title="LINUX"src="imagenes/varios/S.O_linux.png" alt="LINUX" width="20px" height="20px"></td>';
                                }else if($row['sestipodispotivo']=="MAC"){
                                    echo '<td class="text-center"><img data-toggle="tooltip" title="MAC" src="imagenes/varios/S.O_mac.png" alt="MAC" width="20px" height="20px"></td>';
                                }else if ($row['sestipodispotivo']=="ANDROID"){
                                    echo '<td class="text-center"><img data-toggle="tooltip" title="ANDROID" src="imagenes/varios/S.O_android.png" alt="ANDROID" width="20px" height="20px"></td>';
                                }else if ($row['sestipodispotivo']=="BLACKBERRY"){
                                    echo '<td class="text-center"><img data-toggle="tooltip" title="BLACKBERRY" src="imagenes/varios/S.O_blackberry.png" alt="BLACKBERRY" width="20px" height="20px"></td>';
                                }else if ($row['sestipodispotivo']=="IPHONE"){
                                    echo '<td class="text-center"><img data-toggle="tooltip" title="IPHONE" src="imagenes/varios/S.O_iphone.png" alt="IPHONE" width="20px" height="20px"></td>';
                                }else{
                                    echo '<td class="text-center"><img data-toggle="tooltip" title="OTHER" src="imagenes/varios/S.O_other.png" alt="OTRO" width="20px" height="20px"></td>';
                                }
                                if ($row['sesnavegador']=="IE") {
                                    echo '<td class="text-center"><img data-toggle="tooltip" title="INTERNET EXPLORER" src="imagenes/varios/nav_ie.png" alt="INTERNET EXPLORER" width="20px" height="20px"></td>';
                                }elseif ($row['sesnavegador']=="OPERA") {
                                   echo '<td class="text-center"><img data-toggle="tooltip" title="OPERA" src="imagenes/varios/nav_opera.png" alt="OPERA" width="20px" height="20px"></td>';
                                }elseif ($row['sesnavegador']=="MOZILLA") {
                                    echo '<td class="text-center"><img data-toggle="tooltip" title="FIRE FOX" src="imagenes/varios/nav_mozilla.png" alt="MOZILLA" width="25px" height="20px"></td>';
                                }elseif ($row['sesnavegador']=="NETSCAPE") {
                                    echo '<td class="text-center"><img data-toggle="tooltip" title="NETSCAPE" src="imagenes/varios/nav_netscape.png" alt="NETSCAPE" width="20px" height="20px"></td>';
                                }elseif ($row['sesnavegador']=="FIREFOX") {
                                   echo '<td class="text-center"><img data-toggle="tooltip" title="FIRE FOX" src="imagenes/varios/nav_mozilla.png" alt="FIREFOX" width="29px" height="20px"></td>';
                                }elseif ($row['sesnavegador']=="SAFARI") {
                                    echo '<td class="text-center"><img data-toggle="tooltip" title="SAFARI" src="imagenes/varios/nav_safari.png" alt="SAFARI" width="20px" height="20px"></td>';
                                }elseif ($row['sesnavegador']=="CHROME") {
                                    echo '<td class="text-center"><img data-toggle="tooltip" title="CHROME" src="imagenes/varios/nav_chrome.png" alt="CHROME" width="20px" height="20px"></td>';
                                }else{
                                     echo '<td class="text-center"><img data-toggle="tooltip" title="OTHER" src="imagenes/varios/nav_other.png" alt="OTRO" width="20px" height="20px"></td>';
                                }
                                
                                echo '<td>' .  $row['sesfechainicio'].' / '.$row['seshorainicio'] . '</td>';
                                echo '<td>' . $row['sesfechafin']. ' / '. $row['seshorafin']. '</td>';
                              
                               if ($row['sesfallida'] == 1 && $row['sesestado'] == 0) {
                                    echo '<td class="text-center"  > <span data-toggle="tooltip" title="¡INTENTO FALLIDO!" class=" text-danger glyphicon glyphicon-ban-circle fa-1x"></span> </td>';
                                }else if ($row['sesfallida'] == 0 && $row['sesestado'] == 1) {
                                    echo '<td class="text-center"  > <span data-toggle="tooltip" title="USUARIO ACTIVO"  class=" text-info glyphicon glyphicon-ok-circle fa-1x"></span> </td>';
                                }else{
                                    echo '<td class="text-center" > <span  data-toggle="tooltip" title="DESCONECTADO" class=" text-warning glyphicon glyphicon-remove-circle fa-1x"></span> </td>';
                                }
                          
                                  
                          
                                echo '</tr>';
                                $con++;
 
                                                }
                                            }else{
                                                echo "<script> 
                                                    var b='no';
                                                </script>";
                                            }
                                          
                                            ?>
                        </tbody>
                        
                    </table>
                    <?php                  
                    include "paginate.php";
                    ?>

                </div>
                </div>
                </div>
                </div>
<script>
     $('[data-toggle="tooltip"]').tooltip();
</script>