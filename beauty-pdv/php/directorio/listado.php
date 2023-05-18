<?php 
  ob_start();
  session_start();
  header("content-type: application/json");
  include("../../../cnx_data.php");

    $paginaActual = $_POST['partida'];
    $contacto     = utf8_decode($_POST['contacto']);
    $nroProductos = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM btydirectorio_contactos a WHERE a.dicestado = 1 and a.slncodigo = '".$_SESSION['PDVslncodigo']."'"));
    $nroLotes = 9;
    $nroPaginas = ceil($nroProductos/$nroLotes);
    $lista = '';
    $tabla = '';

    if($paginaActual > 1){
        $lista = $lista.'<li><a href="javascript:void(0)"; onclick="paginacion_art('.($paginaActual-1).');">Anterior</a></li>';
                      
    }
    for($i=1; $i<=$nroPaginas; $i++){
        if($i == $paginaActual){
            $lista = $lista.'<li class="active"><a href="javascript:void(0)"; onclick="paginacion_art('.$i.');">'.$i.'</a></li>';
        }else{
            $lista = $lista.'<li><a href="javascript:void(0)"; onclick="paginacion_art('.$i.');">'.$i.'</a></li>';
                            
        }
    }
    if($paginaActual < $nroPaginas){
        $lista = $lista.'<li><a href="javascript:void(0)"; onclick="paginacion_art('.($paginaActual+1).');">Siguiente</a></li>';
    }
  
    if($paginaActual <= 1){
      $limit = 0;
    }else{
      $limit = $nroLotes*($paginaActual-1);
    }


if ($contacto == "") {
        mysqli_query( $conn, "SET lc_time_names = 'es_CO'" );

        $registro = mysqli_query($conn,"SELECT * FROM btydirectorio_contactos a WHERE a.dicestado = 1 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' ORDER BY a.dicnombre ASC LIMIT $limit, $nroLotes")or die(mysqli_error($conn));

        if (mysqli_num_rows($registro) > 0) 
        {
        
               
              while($registro2 = mysqli_fetch_array($registro)){
                 $tabla=$tabla.'<div class="col-lg-4">
            	<div class="hpanel hblue contact-panel">
                	<div class="panel-body">
                  <button type="button" class="btn btn-danger btn-xs pull-right btneliminar" title="Eliminar Contacto" data-codcontacto="'.$registro2['diccodigo'].'"><i class="fa fa-times"></i></button>
                	<button type="button" class="btn btn-info btn-xs pull-right btneditar" title="Editar Contacto" style="margin-right: 9px" data-codcontacto="'.$registro2['diccodigo'].'"><i class="fa fa-edit"></i></button>
                    <h4><a href="">'.utf8_encode($registro2['dicnombre']).'</a></h4>
                    <ul class="list-group">
    				  	<li class="list-group-item list-group-item-danger">
        					<span class="pull-right">'.utf8_encode($registro2['dictelefonomovil']).'</span>
        				MOVIL
      					</li>
      					<li class="list-group-item list-group-item-success">
        					<span class="pull-right">'.utf8_encode($registro2['dictelefonofijo']).'</span>
        				FIJO
      					</li>
      					<li class="list-group-item list-group-item-warning">
        					<span class="pull-right">'.$registro2['cliemail'].'</span>
        				E-MAIL
      					</li>
    				</ul>
                    
                </div>
                <div class="panel-footer contact-footer">
                    <div class="row">
                        <div class="col-md-6 border-right"> <div class="contact-stat"><span>Creado: </span> <strong>'.$registro2['dicfechacreacion'].'</strong></div> </div>
                        <div class="col-md-6 border-right"> <div class="contact-stat"><span>Última Actual: </span> <strong>'.$registro2['dicfechaultactualizacion'].'</strong></div> </div>
                    </div>
                </div>
            </div>
        </div>';
          }

      }
      else
      {
        $tabla=$tabla.'<div class="col-lg-4">
              <div class="hpanel hblue contact-panel">
                  <div class="panel-body">                 
                    <h4><a href="">No hay contacto registrado...</a></h4>                   
                </div>
               
            </div>
        </div>';
      }
        


      $array = array(0 => $tabla, 1 => $lista);

      function utf8_converter($array){
         array_walk_recursive($array, function(&$item, $key){
          if(!mb_detect_encoding($item, 'utf-8', true)){
                  $item = utf8_encode($item);
          }
         });
   
          return $array;
       }

     $array= utf8_converter($array);

      echo json_encode($array);
      
}
else
{

     $registro = mysqli_query($conn,"SELECT * FROM btydirectorio_contactos a WHERE a.dicnombre LIKE '%".$contacto."%' AND a.dicestado = 1 AND a.slncodigo = '".$_SESSION['PDVslncodigo']."' ORDER BY a.dicnombre ASC LIMIT $limit, $nroLotes")or die(mysqli_error($conn));


     if (mysqli_num_rows($registro) > 0) 
     {
              
          while($registro2 = mysqli_fetch_array($registro)){
             $tabla=$tabla.'<div class="col-lg-4">
        		<div class="hpanel hblue contact-panel">
            		<div class="panel-body">
            		    <button type="button" class="btn btn-danger btn-xs pull-right btneliminar" title="Eliminar Contacto" data-codcontacto="'.$registro2['diccodigo'].'"><i class="fa fa-times"></i></button>
              <button type="button" class="btn btn-info btn-xs pull-right btneditar" title="Editar Contacto" style="margin-right: 9px" data-codcontacto="'.$registro2['diccodigo'].'"><i class="fa fa-edit"></i></button>
                		<h4><a href="">'.utf8_encode($registro2['dicnombre']).'</a></h4>
			                <ul class="list-group">
							  	<li class="list-group-item list-group-item-danger">
			    					<span class="pull-right">'.utf8_encode($registro2['dictelefonomovil']).'</span>
			    				MOVIL
			  					</li>
			  					<li class="list-group-item list-group-item-success">
			    					<span class="pull-right">'.utf8_encode($registro2['dictelefonofijo']).'</span>
			    				FIJO
			  					</li>
			  					<li class="list-group-item list-group-item-warning">
			    					<span class="pull-right">'.$registro2['cliemail'].'</span>
			    				E-MAIL
			  					</li>
							</ul>
                
            		</div>
		            <div class="panel-footer contact-footer">
		                <div class="row">
		                    <div class="col-md-6 border-right"> <div class="contact-stat"><span>Creado: </span> <strong>'.$registro2['dicfechacreacion'].'</strong></div> </div>
		                    <div class="col-md-6 border-right"> <div class="contact-stat"><span>Última Actual: </span> <strong>'.$registro2['dicfechaultactualizacion'].'</strong></div> </div>
		                </div>
		            </div>
        		</div>
    		</div>';
      }
        


      $array = array(0 => $tabla, 1 => $lista);

      function utf8_converter($array){
         array_walk_recursive($array, function(&$item, $key){
          if(!mb_detect_encoding($item, 'utf-8', true)){
                  $item = utf8_encode($item);
          }
         });
   
          return $array;
       }

     $array= utf8_converter($array);

      echo json_encode($array);
    }
    else
    {
        $tabla=$tabla.'<div class="col-lg-4">
              <div class="hpanel hblue contact-panel">
                  <div class="panel-body">                 
                    <h5><a href="">No hay coincidencias con esta búsqueda...</a></h5>                   
                </div>
               
            </div>
        </div>';

        $array = array(0 => $tabla, 1 => $lista);

      function utf8_converter($array){
         array_walk_recursive($array, function(&$item, $key){
          if(!mb_detect_encoding($item, 'utf-8', true)){
                  $item = utf8_encode($item);
          }
         });
   
          return $array;
       }

     $array= utf8_converter($array);

      echo json_encode($array);
    }

}

      mysqli_close($conn);
      ob_end_flush();
?>

