<?php
include "../cnx_data.php";
if ($name = $_POST['nombre']) {
    $sql = "SELECT `tpocodigo`, `tponombre`, `tpoalias`, `tpodescripcion`, `tpoimagen`, (SELECT COUNT(*) FROM btygrupo WHERE tpocodigo = t.tpocodigo ) as cantidad FROM `btytipo` t WHERE tpoestado = 1 and (tponombre like '".$name."%' or tpocodigo = '$name') ORDER BY tponombre";
} else {
	$sql = "SELECT `tpocodigo`, `tponombre`, `tpoalias`, `tpodescripcion`, `tpoimagen`, (SELECT COUNT(*) FROM btygrupo WHERE tpocodigo = t.tpocodigo ) as cantidad FROM `btytipo` t WHERE tpoestado = 1 ORDER BY tponombre";

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
    $sql = $sql." limit $offset, $rowsPerPage";
 $result = $conn->query($sql);
 if ($result->num_rows > 0) {
    echo ' <div class="row">
                        <div class="col-lg-12">  
                       <span class="label label-success pull-right"><h6>No. Total de Registros: '.$num_total_registros.'</h6></span>    
                        </div>        
                </div> <br>';
     while ($row = $result->fetch_assoc()) {
        if ($row['tpoimagen'] != "default.jpg") {
            $img = "tipo/".$row['tpoimagen'];
        } else {
            $img = $row['tpoimagen'];
        }

         //$nom = substr($row['tponombre'], 0, 12);
         $nom = utf8_encode($row['tponombre']); //Editado por Jaime
         echo '<div class="row">
    <div class="col-lg-3">
    <a>
        <div class="hpanel hgreen contact-panel">
            <div class="panel-body">
                '.$type.'
               <img alt="logo" class="img-thumbnail m-b" src="../contenidos/imagenes/'.$img.'?id?12'.date('ymdHi').'" onerror=this.src="../contenidos/imagenes/default.jpg"><small class="pull-right">'.$row['cantidad'].' Grupo(s)</small>
                <h3>'.$nom.'</h3>
                <div class="text-muted font-bold m-b-xs"></div>
                <p>
                    
                </p>
            </div>
            <div class="panel-footer contact-footer">
                <div class="row">   
                    <div class="col-md-6 border-right"> <div class="contact-stat"><span>Acciones: </span> </div> </div>
                    <div class="col-md-6 border-right"> <div class="contact-stat"> <span> </span> <a onclick="b('.$cod.' , 13)"> <button value="'.$row['tpocodigo'].'" data-toggle="tooltip" data-placement="bottom" title="Editar" onclick="editar (this.value)" class="btn btn-circle btn-default text-info" type="button"><i class="pe-7s-note text-info"></i></button><button value="'.$row['tpocodigo'].'" data-toggle="tooltip" data-placement="bottom" title="Eliminar" class="btn btn-circle btn-default text-info" onclick="Eliminar (this.value, this)" type="button"><i class="pe-7s-trash text-info"></i></button> </a></div> </div>
                </div>
            </div>
        </div>
        </a>
    </div>';
         if ($row = $result->fetch_assoc()) {
                if ($row['tpoimagen'] != "default.jpg") {
            $img = "tipo/".$row['tpoimagen'];
        } else {
            $img = $row['tpoimagen'];
        }
         //$nom = substr($row['tponombre'], 0, 12);
         $nom = utf8_encode($row['tponombre']); //Editado por Jaime
         $id = $row['tdialias'].": ".$row['trcdocumento'];
         echo '<div class="col-lg-3">
         <a> 
        <div class="hpanel hyellow contact-panel">
            <div class="panel-body">
            '.$type.'
                <img alt="logo" class="img-thumbnail m-b" src="../contenidos/imagenes/'.$img.'?id?12'.date('ymdHi').'" onerror=this.src="../contenidos/imagenes/default.jpg"><small class="pull-right">'.$row['cantidad'].' Grupo(s)</small>
                <h3>'.$nom.'</h3>
                <div class="text-muted font-bold m-b-xs"></div>
                <p>
                    
                </p>
            </div>
            <div class="panel-footer contact-footer">
                <div class="row">   
                    <div class="col-md-6 border-right"> <div class="contact-stat"><span>Acciones: </span> </div> </div>
                    <div class="col-md-6 border-right"> <div class="contact-stat"> <span> </span> <a onclick="b('.$cod.' , 13)"> <button value="'.$row['tpocodigo'].'" data-toggle="tooltip" data-placement="bottom" title="Editar" onclick="editar (this.value)" class="btn btn-circle btn-default text-info" type="button"><i class="pe-7s-note text-info"></i></button><button value="'.$row['tpocodigo'].'" data-toggle="tooltip" data-placement="bottom" title="Eliminar" onclick="Eliminar (this.value, this)" class="btn btn-circle btn-default text-info" type="button"><i class="pe-7s-trash text-info"></i></button> </a></div> </div>
                </div>
            </div>
        </div>
        </a>
    </div>';
         }
         if ($row = $result->fetch_assoc()) {
                if ($row['tpoimagen'] != "default.jpg") {
            $img = "tipo/".$row['tpoimagen'];
        } else {
            $img = $row['tpoimagen'];
        }
             if ($row['cliempresa']== "S"){
              $type = '<span class="label pull-right" style="background: blue">EMPRESA</span>';
         } else {
             $type = "";
         }
         //$nom = substr($row['tponombre'], 0, 12);
         $nom = utf8_encode($row['tponombre']); //Editado por Jaime
         $id = $row['tdialias'].": ".$row['trcdocumento'];
   echo '<div class="col-lg-3">
   <a> 
        <div class="hpanel hviolet contact-panel">
            <div class="panel-body">
            '.$type.'
               <img alt="logo" class="img-thumbnail m-b" src="../contenidos/imagenes/'.$img.'?id?12'.date('ymdHi').'" onerror=this.src="../contenidos/imagenes/default.jpg"><small class="pull-right">'.$row['cantidad'].' Grupo(s)</small>
                <h3>'.$nom.' </h3>
                <div class="text-muted font-bold m-b-xs"></div>
                <p>
                    
                </p>
            </div>
            <div class="panel-footer contact-footer">
                <div class="row">   
                    <div class="col-md-6 border-right"> <div class="contact-stat"><span>Acciones: </span> </div> </div>
                    <div class="col-md-6 border-right"> <div class="contact-stat"> <span> </span> <a onclick="b('.$cod.' , 13)"> <button value="'.$row['tpocodigo'].'" data-toggle="tooltip" data-placement="bottom" title="Editar" onclick="editar (this.value)" class="btn btn-circle btn-default text-info" type="button"><i class="pe-7s-note text-info"></i></button><button value="'.$row['tpocodigo'].'" data-toggle="tooltip" data-placement="bottom" title="Eliminar" onclick="Eliminar (this.value, this)" class="btn btn-circle btn-default text-info" type="button"><i class="pe-7s-trash text-info"></i></button> </a></div> </div>
                </div>
            </div>
        </div>
        </a>
    </div>';
    }
         if ($row = $result->fetch_assoc()) {
                if ($row['tpoimagen'] != "default.jpg") {
            $img = "tipo/".$row['tpoimagen'];
        } else {
            $img = $row['tpoimagen'];
        }
             if ($row['cliempresa']== "S"){
             $type = '<span class="label pull-right" style="background: blue">EMPRESA</span>';
         } else {
             $type = "";
         }
         //$nom = substr($row['tponombre'], 0, 12);
         $nom = utf8_encode($row['tponombre']); //Editado por Jaime
         $id = $row['tdialias'].": ".$row['trcdocumento'];
    echo '<div class="col-lg-3">
    <a> 
        <div class="hpanel hblue contact-panel">
            <div class="panel-body">
            '.$type.'
                <img alt="logo" class="img-thumbnail m-b" src="../contenidos/imagenes/'.$img.'?id?12'.date('ymdHi').'" onerror=this.src="../contenidos/imagenes/default.jpg"><small class="pull-right">'.$row['cantidad'].' Grupo(s)</small>
                <h3>'.$nom.' </h3>
                <div class="text-muted font-bold m-b-xs"></div>
                <p>
                   
                </p>
            </div>
            <div class="panel-footer contact-footer">
                <div class="row">   
                    <div class="col-md-6 border-right"> <div class="contact-stat"><span>Acciones: </span> </div> </div>
                    <div class="col-md-6 border-right"> <div class="contact-stat"> <span> </span> <a onclick="b('.$cod.' , 13)"> <button value="'.$row['tpocodigo'].'" data-toggle="tooltip" data-placement="bottom" title="Editar" onclick="editar (this.value)" class="btn btn-circle btn-default text-info" type="button"><i class="pe-7s-note text-info"></i></button><button value="'.$row['tpocodigo'].'"  data-toggle="tooltip" data-placement="bottom" onclick="Eliminar (this.value, this)" title="Eliminar" class="btn btn-circle btn-default text-info" type="button"><i class="pe-7s-trash text-info"></i></button> </a></div> </div>
                </div>
            </div>
        </div>
        </a>
    </div>
</div>';
         }
        
  
     }
 }

include 'paginate.php';