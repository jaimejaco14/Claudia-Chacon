<?php 
//session_start();
include '../cnx_data.php';
$cod = $_SESSION['documento']; 
   
if ($_POST['cargo'] != 0 and $_POST['cargo'] != "") {

} 

if($id = $_POST['nombre']) {

       $sql="SELECT c.clbcodigo, t.trcrazonsocial, t.trcdocumento, cr.crgnombre, ct.ctcnombre, c.cblimagen, td.tdialias, ct.ctccolor, ct.ctccodigo, cr.crgalias  FROM btycolaborador as c, btytercero as t, btytipodocumento as td, btycargo as cr, btycategoria_colaborador as ct WHERE c.trcdocumento=t.trcdocumento and c.tdicodigo=t.tdicodigo AND td.tdicodigo=c.tdicodigo AND cr.crgcodigo=c.crgcodigo AND ct.ctccodigo=c.ctccodigo AND c.clbestado='1' AND (c.trcdocumento LIKE '".$id."%' or t.trcrazonsocial LIKE '%".utf8_decode($id)."%') ";

}else{ 

      $sql="SELECT c.clbcodigo, t.trcrazonsocial, t.trcdocumento, cr.crgnombre, ct.ctcnombre, c.cblimagen, td.tdialias, ct.ctccolor, ct.ctccodigo, cr.crgalias  FROM btycolaborador as c, btytercero as t, btytipodocumento as td, btycargo as cr, btycategoria_colaborador as ct WHERE c.trcdocumento=t.trcdocumento AND c.tdicodigo=t.tdicodigo AND td.tdicodigo=c.tdicodigo AND cr.crgcodigo=c.crgcodigo AND ct.ctccodigo=c.ctccodigo AND c.clbestado='1'";

      if ($_POST['cargo'] != 0 ) { 
          $sql = $sql." AND cr.crgcodigo = ".$_POST['cargo'];
      }
      if ($_POST['perfil'] != 0 ) { 
          $sql = $sql." AND ct.ctccodigo = ".$_POST['perfil']; 
      } 
    
}

  $query_num_col = $sql;
 
  $result = $conn->query($query_num_col);
  $num_total_registros = $result->num_rows;
 
  $rowsPerPage = 8;
  $pageNum = 1;

      if(isset($_POST['page'])) {
        $pageNum = $_POST['page'];
      }
      
      $offset = ($pageNum - 1) * $rowsPerPage;
      $total_paginas = ceil($num_total_registros / $rowsPerPage);
      $sql = $sql." ORDER BY t.trcrazonsocial limit $offset, $rowsPerPage";
      $result = $conn->query($sql);

  

  if ($result->num_rows > 0) {
     $cont = 0;
     echo '<div class="row">
              <div class="col-lg-12">  
                <span class="label label-success pull-right"><h6>No. Registros: '.$num_total_registros.'</h6></span>    
              </div>        
          </div> <br>';


    while ($row = $result->fetch_assoc()) {
        $rut = "../contenidos/documentos/rut/".$_SESSION['Db']."/".$row['trcdocumento'].".pdf";
        $exists = is_file($rut);

        if ($exists == true) {    
            $file = "<a href='".$rut."' target='_blank' title='Ver RUT del colaborador' ><i class='fa fa-file-text-o'></i></a>";
        } else {
            $file = "";
        }
      


        $SqlSalonBase= mysqli_query($conn,"SELECT sb.slcdesde, sb.slchasta, s.slnnombre, c.clbcodigoswbiometrico FROM btysalon as s, btysalon_base_colaborador sb, btycolaborador as c where s.slncodigo=sb.slncodigo and c.clbcodigo=sb.clbcodigo and sb.slchasta is NULL and c.clbcodigo='".$row['clbcodigo']."'");       
        

        if (mysqli_num_rows($SqlSalonBase)>0){
            $QuSalonBase=mysqli_fetch_array($SqlSalonBase);
            $base = "<b>Salón actual</b>: <br>".ucwords(strtolower($QuSalonBase['slnnombre']));
        }else{
            $base = "<b>Salón actual</b>: <br> Sin asignar";
        }

        
        if ($QuSalonBase['clbcodigoswbiometrico'] == "" || $QuSalonBase['clbcodigoswbiometrico'] == null) 
        {
             $biometrico = "Sin asignar";
        }
        else
        {
             $biometrico = $QuSalonBase['clbcodigoswbiometrico'];
        }

      

        /*$SqlEstado= mysqli_query($conn,"SELECT e.cletipo from btycolaborador as c, btyestado_colaborador as e where e.cleestado='1' and c.clbcodigo='".$row['clbcodigo']."' and e.clefecha=(select max(e.clefecha) from btyestado_colaborador as e where e.cleestado='1' and e.clbcodigo='".$row['clbcodigo']."')");*/

        $SqlEstado= mysqli_query($conn,"SELECT e.cletipo from btycolaborador c join btyestado_colaborador e on c.clbcodigo=e.clbcodigo where e.cleestado='1' and c.clbcodigo='".$row['clbcodigo']."' and e.clefecha=(select max(e.clefecha) from btyestado_colaborador as e where e.cleestado='1' and e.clbcodigo='".$row['clbcodigo']."')"); 



        if (mysqli_num_rows($SqlEstado)>0){
            $QuEstado=mysqli_fetch_array($SqlEstado);
            $estado = "<b>Estado</b>: <br>".ucfirst(strtolower($QuEstado['cletipo'])); 
        }else{
            $estado = "<b>Estado</b>: <br>Sin definir"; 
        }
    

        if ($row['cblimagen'] != "default.jpg") {
            $img = "colaborador/".$_SESSION['Db']."/".$row['cblimagen'];
        }else{
            $img = $row['cblimagen'];
        }
    
        $color = $row['ctccolor'];
        $type = '<span class="label pull-right" style="background: #'.$row['ctccolor'].'">'.$row['ctcnombre'].'</span>';

         if ($row['ctccodigo']==1){
             $hpanel = "hyellow";
         } else if($row['ctccodigo']==2) {
             $hpanel = "hblue";
         } else if($row['ctccodigo']==3) {
             $hpanel = "hred";
         }
         
         $nom = $row['trcrazonsocial'];
         $idcol=$row['trcdocumento'];
         

        echo '<div class="col-lg-3 col-md-3 col-sm-6">
                  <a  onclick=detalles("'.$row['trcdocumento'].'");>
                    <div class="hpanel '.$hpanel.' contact-panel" style="max-height:370px;min-height:370px;">
                        <div class="panel-body"  style="min-height:200px;overflow-x: auto;">
                            '.$type.'
                            <img alt="logo" class="img-thumbnail m-b" onerror="this.src=\'../contenidos/imagenes/default.jpg\';" src="../contenidos/imagenes/'.$img.'">
                            <h6>'.utf8_encode($nom).'</h6>

                            <div class="text-muted font-bold m-b-xs">'.$row['tdialias'].': '.$row['trcdocumento'].' '.$file.'</div>
                              <h6><b>Cód Beauty:</b> '.$row['clbcodigo'].'</h6>
                              <h6><b>Cód Biométrico:</b> '.$biometrico.'</h6>
                              <h6>'.$base.'</h6>
                            <div class="font-bold m-b-xs"><h6>'.$estado.'</h6></div>                    
                        </div>
                        <div class="panel-footer contact-footer">
                          <div class="row">   
                            <div class="col-md-6 border-right"> <div class="contact-stat" style="text-align: left"><strong style="font-size: .8em;">'.$row['crgnombre'].'</strong></div> </div>
                                <div class="col-md-6 border-right"> <div class="contact-stat"> <a onclick="b('.$cod.' , 13, '.$row['clbcodigo'].')"> <button value="'.$row['clbcodigo'].'" title="Lista de servicios" class="btn btn-circle btn-default text-info" type="button"><i class="fa fa-scissors"></i></button></a> <button id="btnbio" onclick="biometricol('.$row['clbcodigo'].')" title="Ingresar Código Biométrico" class="btn btn-circle btn-default text-info" type="button"><i class="fa fa-hand-pointer-o"></i></button> <button id="btnaccweb" onclick="accesoweb('.$row['clbcodigo'].');" title="Habilitar Acceso Web" class="btn btn-circle btn-default text-info" type="button"><i class="fa fa-sign-in"></i></button></div></div>
                            </div>
                            <input type="hidden" value="'.$row['clbcodigo'].'" id="colaborador">
                          </div>
                        </div>
                  </a>
              </div>';        
    }
  }
  include "paginate.php";

?>




