<?php

include '../cnx_data.php';

$genero = $_POST['FiltroSexo'];

$query_num_col = "SELECT distinct t.trcrazonsocial, c.trcdocumento, tdi.tdialias, c.cliempresa, o.ocunombre, b.brrnombre, c.clifecharegistro, c.cliimagen FROM btycliente c INNER JOIN btytercero t ON t.trcdocumento = c.trcdocumento INNER JOIN btyocupacion o on c.ocucodigo = o.ocucodigo INNER JOIN btybarrio b ON t.brrcodigo = b.brrcodigo INNER JOIN btytipodocumento tdi on c.tdicodigo = tdi.tdicodigo where c.clisexo = '$genero'";

	$result = $conn->query($query_num_col);
  	$num_total_registros = $result->num_rows;
 
  	$rowsPerPage = 8;
    $pageNum = 1;

    if(isset($_POST['id'])) {
        sleep(1);
        $pageNum = $_POST['id'];
    }
  	
  	$offset = ($pageNum - 1) * $rowsPerPage;
    $total_paginas = ceil($num_total_registros / $rowsPerPage);

if($genero = $_POST['FiltroSexo']){

$sql = "SELECT distinct t.trcrazonsocial, c.trcdocumento, tdi.tdialias, c.cliempresa, o.ocunombre, b.brrnombre, c.clifecharegistro, c.cliimagen FROM btycliente c INNER JOIN btytercero t ON t.trcdocumento = c.trcdocumento INNER JOIN btyocupacion o on c.ocucodigo = o.ocucodigo INNER JOIN btybarrio b ON t.brrcodigo = b.brrcodigo INNER JOIN btytipodocumento tdi on c.tdicodigo = tdi.tdicodigo WHERE c.clisexo = '$genero' AND cliestado = 1 limit $offset, $rowsPerPage";

} else {
	$sql = "SELECT t.trcrazonsocial, c.trcdocumento, tdi.tdialias, c.cliempresa, o.ocunombre, b.brrnombre, c.clifecharegistro, c.cliimagen FROM btycliente c INNER JOIN btytercero t ON t.trcdocumento = c.trcdocumento INNER JOIN btyocupacion o on c.ocucodigo = o.ocucodigo INNER JOIN btybarrio b ON t.brrcodigo = b.brrcodigo INNER JOIN btytipodocumento tdi on c.tdicodigo = tdi.tdicodigo";
}
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
		   echo ' <div class="row">
		                        <div class="col-lg-12">  
		                       <span class="label label-success pull-right"><h6>No. Registros: '.$num_total_registros.'</h6></span>    
		                        </div>        
		                </div> <br>';
		     while ($row = $result->fetch_assoc()) {
		         if ($row['cliempresa']== "S"){
		             $type = '<span class="label pull-right" style="background: blue">EMPRESA</span>';
		         } else {
		             $type = "";
		         }
		         if ($row['cliimagen'] == "default.jpg") {
		            $src = $row['cliimagen'];
		         } else {
		          $src = "clientes/".$row['cliimagen'];
		         }
		         $id = $row['tdialias'].": ".$row['trcdocumento'];
		         $nom = $row['trcrazonsocial'];
		         
		         echo '<div class="row">
		                <div class="col-lg-3">
		                <a onclick="detalles('.$row['trcdocumento'].');">
		                    <div class="hpanel hgreen contact-panel">
		                        <div class="panel-body">
		                            '.$type.'
		                            <img alt="logo" class="img-circle m-b" src="imagenes/'.$src.'">
		                            <h3>'.$nom.'</h3>
		                            <div class="text-muted font-bold m-b-xs">'.$id.'</div>
		                            <p>
		                                
		                            </p>
		                        </div>
		                        <div class="panel-footer contact-footer">
		                            <div class="row">
		                                <div class="col-md-12 border-right"> <div class="contact-stat"><span>Cliente desde: </span> <strong>'.$row['clifecharegistro'].'</strong></div> </div>
		                            </div>
		                        </div>
		                    </div>
		                </a>
		              </div>';
		         if ($row = $result->fetch_assoc()) {
		            if ($row['cliempresa']== "S"){
		              $type = '<span class="label pull-right" style="background: blue">EMPRESA</span>';
		         } else {
		             $type = "";
		         }
		         $nom = $row['trcrazonsocial'];
		         $id = $row['tdialias'].": ".$row['trcdocumento'];
		         echo '<div class="col-lg-3">
		         <a onclick="detalles('.$row['trcdocumento'].');">
		            <div class="hpanel hyellow contact-panel">
		            <div class="panel-body">
		            '.$type.'
		                <img alt="logo" class="img-circle m-b" src="imagenes/'.$src.'">
		                <h3>'.$nom.'</h3>
		                <div class="text-muted font-bold m-b-xs">'.$id.'</div>
		                <p>
		                    
		                </p>
		            </div>
		            <div class="panel-footer contact-footer">
		                <div class="row">
		                    <div class="col-md-12 border-right"> <div class="contact-stat"><span>Cliente desde: </span> <strong>'.$row['clifecharegistro'].'</strong></div> </div>
		                    
		                </div>
		                </div>
		            </div>
		        </a>
		    </div>';
		         }
		         if ($row = $result->fetch_assoc()) {
		             if ($row['cliempresa']== "S"){
		              $type = '<span class="label pull-right" style="background: blue">EMPRESA</span>';
		         } else {
		             $type = "";
		         }
		         $nom = $row['trcrazonsocial'];
		         $id = $row['tdialias'].": ".$row['trcdocumento'];
		   echo '<div class="col-lg-3">
		          <a onclick="detalles('.$row['trcdocumento'].');">
		        <div class="hpanel hviolet contact-panel">
		            <div class="panel-body">
		            '.$type.'
		                <img alt="logo" class="img-circle m-b" src="imagenes/'.$src.'">
		                <h3>'.$nom.'</h3>
		                <div class="text-muted font-bold m-b-xs">'.$id.'</div>
		                <p>
		                    
		                </p>
		            </div>
		            <div class="panel-footer contact-footer">
		                <div class="row">
		                    <div class="col-md-12 border-right"> <div class="contact-stat"><span>Cliente desde: </span> <strong>'.$row['clifecharegistro'].'</strong></div> </div>
		                </div>
		            </div>
		        </div>
		        </a>
		    </div>';
		    }
		         if ($row = $result->fetch_assoc()) {
		             if ($row['cliempresa']== "S"){
		             $type = '<span class="label pull-right" style="background: blue">EMPRESA</span>';
		         } else {
		             $type = "";
		         }
		         $nom = $row['trcrazonsocial'];
		         $id = $row['tdialias'].": ".$row['trcdocumento'];
		    echo '<div class="col-lg-3">
		        <a onclick="detalles('.$row['trcdocumento'].');">
		        <div class="hpanel hblue contact-panel">
		            <div class="panel-body">
		            '.$type.'
		                <img alt="logo" class="img-circle m-b" src="imagenes/'.$src.'">
		                <h3>'.$nom.'</h3>
		                <div class="text-muted font-bold m-b-xs">'.$id.'</div>
		                <p>
		                   
		                </p>
		            </div>
		            <div class="panel-footer contact-footer">
		                <div class="row">
		                    <div class="col-md-12 border-right"> <div class="contact-stat"><span>Cliente desde: </span> <strong>'.$row['clifecharegistro'].'</strong></div> </div>
		                </div>
		            </div>
		        </div>
		        </a>
		    </div>
		</div>';
		         }
		  
		     }
		 }
if ($total_paginas > 1) {
                        echo '<br><center><div class="col-lg-12"><div class="pagination">';
                        echo '<ul class="pagination pull-right"></ul>';
                            if ($pageNum != 1) {
                                echo '<li><a class="paginate" onclick="paginar('.($pageNum-1).');" data="'.($pageNum-1).'">Anterior</a></li>';
                            }
                                for ($i=1;$i<=$total_paginas;$i++) {
                                    if ($pageNum == $i) {
                                        //si muestro el índice de la página actual, no coloco enlace
                                        echo '<li class="active"><a onclick="paginar('.$i.');">'.$i.'</a></li>';
                                    } else if ($pageNum > ($i + 2) or $pageNum < $i - 2) {
                                        //echo '<li hiddenn><a class="paginate" onclick="paginar('.$i.');" data="'.$i.'">'.$i.'</a></li>';

                                    } else {
                                        //si el índice no corresponde con la página mostrada actualmente,
                                        //coloco el enlace para ir a esa página
                                        echo '<li><a class="paginate" onclick="paginar('.$i.');" data="'.$i.'">'.$i.'</a></li>';
                                    }
                                }
                            if ($pageNum != $total_paginas) {
                                echo '<li><a class="paginate" onclick="paginar('.($pageNum+1).');" data="'.($pageNum+1).'">Siguiente</a></li>';    
                            }
                       echo '</ul>';
                       echo '</div> </div></center> <br>';
                    }
$conn->close();