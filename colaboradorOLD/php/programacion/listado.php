<?php 
    session_start();
    ob_start();
    header("content-type: application/json");
  include '../../../cnx_data.php';

    switch ($_POST['opcion']) 
    {
        case 'listado':


            $paginaActual = $_POST['partida'];
            $art = $_POST['art'];
            $nroProductos = mysqli_num_rows(mysqli_query($conn,"SELECT a.prgfecha, d.trnnombre, d.trndesde, d.trnhasta, e.tprnombre, f.slnnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento JOIN btyturno d ON d.trncodigo=a.trncodigo JOIN btytipo_programacion e ON e.tprcodigo=a.tprcodigo JOIN btysalon f ON f.slncodigo=a.slncodigo WHERE a.clbcodigo = '".$_POST['codColaborador']."' AND MONTH(a.prgfecha) = MONTH(CURDATE()) ORDER BY a.prgfecha DESC"));

              $nroLotes = 9;
              $nroPaginas = ceil($nroProductos/$nroLotes);
              $lista = '';
              $tabla = '';

                        if($paginaActual > 1)
                        {
                            $lista = $lista.'<li><a href="javascript:void(0)"; onclick="paginacion_art('.($paginaActual-1).', '.$_SESSION['clbcodigo'].');">Anterior</a></li>';
                                          
                        }

                        for($i=1; $i<=$nroPaginas; $i++)
                        {
                            if($i == $paginaActual)
                            {
                                $lista = $lista.'<li class="active"><a href="javascript:void(0)"; onclick="paginacion_art('.$i.', '.$_SESSION['clbcodigo'].');">'.$i.'</a></li>';
                            }
                            else
                            {
                                $lista = $lista.'<li><a href="javascript:void(0)"; onclick="paginacion_art('.$i.', '.$_SESSION['clbcodigo'].');">'.$i.'</a></li>';                                                
                            }
                        }


                        if($paginaActual < $nroPaginas)
                        {
                            $lista = $lista.'<li><a href="javascript:void(0)"; onclick="paginacion_art('.($paginaActual+1).', '.$_SESSION['clbcodigo'].');">Siguiente</a></li>';
                        }

                      
                        if($paginaActual <= 1)
                        {
                          $limit = 0;
                        }
                        else
                        {
                          $limit = $nroLotes*($paginaActual-1);
                        }


           
                            mysqli_query($conn, "SET lc_time_names = 'es_CO'" );

                            $registro = mysqli_query($conn,"SELECT a.prgfecha, DATE_FORMAT(a.prgfecha, '%d de %M de %Y')AS prgfecha2,  d.trnnombre, TIME_FORMAT(d.trndesde, '%H:%i') AS trndesde, TIME_FORMAT(d.trnhasta, '%H:%i')AS trnhasta, e.tprnombre, f.slnnombre, DAYNAME(a.prgfecha) as dia FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento JOIN btyturno d ON d.trncodigo=a.trncodigo JOIN btytipo_programacion e ON e.tprcodigo=a.tprcodigo JOIN btysalon f ON f.slncodigo=a.slncodigo WHERE a.clbcodigo = '".$_POST['codColaborador']."' AND MONTH(a.prgfecha) = MONTH(CURDATE()) ORDER BY a.prgfecha ASC LIMIT $limit, $nroLotes")or die(mysqli_error($conn));

                              if (mysqli_num_rows($registro) > 0) 
                              {
                                while($registro2 = mysqli_fetch_array($registro))
                                {                                

                                     $tabla=$tabla.'<div class="col-lg-4" >
                                            <div class="hpanel hblue contact-panel">
                                                <div class="panel-body">
                                                    <div class="list-group">
                                                      <button type="button" class="list-group-item active"><b>FECHA <span class="pull-right" style="text-transform: uppercase!important;">'. $registro2['dia'] . " " . $registro2['prgfecha2'].'</b></span></button>
                                                      <button type="button" class="list-group-item"><b>TURNO:</b> <span class="pull-right">'.$registro2['trnnombre'].'</span></button>
                                                      <button type="button" class="list-group-item"><b>DE:</b> <span class="pull-right">'.$registro2['trndesde'].'</span></button>
                                                      <button type="button" class="list-group-item"><b>HASTA:</b> <span class="pull-right">'.$registro2['trnhasta'].'</span></button>
                                                      <button type="button" class="list-group-item"><b>TIPO PROG:</b> <span class="pull-right">'.$registro2['tprnombre'].'</span></button>
                                                      <button type="button" class="list-group-item"><b>'.utf8_decode('SALÓN:').'</b> <span class="pull-right">'.$registro2['slnnombre'].'</span></button>
                                                    </div>
                                                    
                                                  
                                              </div>                                         
                                            </div>
                                        </div>';
                                }
                                
                              }
                              else
                              {
                                   $tabla=$tabla.'
                                                  <div class="col-lg-4" >
                                                    <div class="hpanel hblue contact-panel">
                                                        <div class="panel-body">
                                                            <div class="list-group">
                                                              <button type="button" class="list-group-item active"><b>NO HAY PROGRAMACIÓN ASIGNADA </button>                                                     
                                                            </div>                                       
                                                        </div>                                         
                                                    </div>
                                                  </div>';
                              }

                            
                            


                              $array = array(0 => $tabla, 1 => $lista);

                              function utf8_converter($array)
                              {
                                 array_walk_recursive($array, function(&$item, $key)
                                 {
                                    if(!mb_detect_encoding($item, 'utf-8', true)){
                                            $item = utf8_encode($item);
                                    }
                                 });
                           
                                  return $array;
                              }

                              $array= utf8_converter($array);

                              echo json_encode($array);    
                     break;

          case 'searchApp':
             mysqli_query($conn, "SET lc_time_names = 'es_CO'" );
            $paginaActual = $_POST['partida'];
            $art = $_POST['art'];
            $nroProductos = mysqli_num_rows(mysqli_query($conn,"SELECT a.prgfecha, DATE_FORMAT(a.prgfecha, '%d de %M de %Y')AS prgfecha2,  d.trnnombre, TIME_FORMAT(d.trndesde, '%H:%i') AS trndesde, TIME_FORMAT(d.trnhasta, '%H:%i')AS trnhasta, e.tprnombre, f.slnnombre, DAYNAME(a.prgfecha) as dia FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento JOIN btyturno d ON d.trncodigo=a.trncodigo JOIN btytipo_programacion e ON e.tprcodigo=a.tprcodigo JOIN btysalon f ON f.slncodigo=a.slncodigo WHERE a.clbcodigo = '".$_POST['codColaborador']."' AND MONTH(a.prgfecha) = MONTH(CURDATE()) ORDER BY a.prgfecha ASC LIMIT $limit, $nroLotes"));
            $nroLotes = 9;
            $nroPaginas = ceil($nroProductos/$nroLotes);
            $lista = '';
            $tabla = '';


                        if($paginaActual > 1){
                            $lista = $lista.'<li><a href="javascript:void(0)"; onclick="paginacion_art('.($paginaActual-1).', '.$_SESSION['clbcodigo'].');">Anterior</a></li>';
                                          
                        }
                        for($i=1; $i<=$nroPaginas; $i++){
                            if($i == $paginaActual){
                                $lista = $lista.'<li class="active"><a href="javascript:void(0)"; onclick="paginacion_art('.$i.', '.$_SESSION['clbcodigo'].');">'.$i.'</a></li>';
                            }else{
                                $lista = $lista.'<li><a href="javascript:void(0)"; onclick="paginacion_art('.$i.', '.$_SESSION['clbcodigo'].');">'.$i.'</a></li>';
                                                
                            }
                        }
                        if($paginaActual < $nroPaginas){
                            $lista = $lista.'<li><a href="javascript:void(0)"; onclick="paginacion_art('.($paginaActual+1).', '.$_SESSION['clbcodigo'].');">Siguiente</a></li>';
                        }
                      
                        if($paginaActual <= 1){
                          $limit = 0;
                        }else{
                          $limit = $nroLotes*($paginaActual-1);
                        }


                        $f = "SELECT a.prgfecha, DATE_FORMAT(a.prgfecha, '%d de %M de %Y')AS prgfecha2,  d.trnnombre, TIME_FORMAT(d.trndesde, '%H:%i') AS trndesde, TIME_FORMAT(d.trnhasta, '%H:%i')AS trnhasta, e.tprnombre, f.slnnombre, DAYNAME(a.prgfecha) as dia FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.trcdocumento=b.trcdocumento JOIN btyturno d ON d.trncodigo=a.trncodigo JOIN btytipo_programacion e ON e.tprcodigo=a.tprcodigo JOIN btysalon f ON f.slncodigo=a.slncodigo WHERE a.clbcodigo = '".$_POST['codColaborador']."' AND a.prgfecha = '".$_POST['fecha']."' ORDER BY a.prgfecha ASC LIMIT $limit, $nroLotes";


                         $registro = mysqli_query($conn,$f)or die(mysqli_error($conn));

                            if (mysqli_num_rows($registro) > 0) 
                            {
                               
                                    while($registro2 = mysqli_fetch_array($registro))
                                    {

                                    

                                       $tabla=$tabla.'<div class="col-lg-4" >
                                            <div class="hpanel hblue contact-panel">
                                                <div class="panel-body">
                                                    <div class="list-group">
                                                      <button type="button" class="list-group-item active"><b>FECHA <span class="pull-right" style="text-transform: uppercase!important;">'. $registro2['dia'] . " " . $registro2['prgfecha2'].'</b></span></button>
                                                      <button type="button" class="list-group-item"><b>TURNO:</b> <span class="pull-right">'.$registro2['trnnombre'].'</span></button>
                                                      <button type="button" class="list-group-item"><b>DE:</b> <span class="pull-right">'.$registro2['trndesde'].'</span></button>
                                                      <button type="button" class="list-group-item"><b>HASTA:</b> <span class="pull-right">'.$registro2['trnhasta'].'</span></button>
                                                      <button type="button" class="list-group-item"><b>TIPO PROG:</b> <span class="pull-right">'.$registro2['tprnombre'].'</span></button>
                                                      <button type="button" class="list-group-item"><b>'.utf8_decode('SALÓN:').'</b> <span class="pull-right">'.$registro2['slnnombre'].'</span></button>
                                                    </div>
                                                    
                                                  
                                              </div>                                         
                                            </div>
                                        </div>';
                                    }
                            }
                            else
                            {
                                $tabla=$tabla.'<center><div class="col-md-6" >
                                    <div class="hpanel hblue contact-panel">
                                        <div class="panel-body">
                                            <div class="list-group">
                                              <button type="button" class="list-group-item active">NO HAY PROGRAMACIÓN PARA LA FECHA SELECCIONADA '.$_POST['fecha'].' <span class="pull-right"><b></b></span></button>
                                             

                                            </div>
                                            
                                          
                                      </div>

                                      </div>
                                    </div>
                                    </div></center>';
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

        break;
        
        default:
            # code...
            break;
    }

   
 

      mysqli_close($conn);
      ob_end_flush();
?>

