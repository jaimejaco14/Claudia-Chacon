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
            $nroProductos = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM btycita a WHERE a.clbcodigo = '".$_POST['codColaborador']."' ORDER BY a.citfecha DESC"));
            $nroLotes = 6;
            $nroPaginas = ceil($nroProductos/$nroLotes);
            $lista = '';
            $tabla = '';

                        if($paginaActual != 1){
                            $lista = $lista.'<li><a href="javascript:void(0)"; onclick="paginacion_art('.($paginaActual-1).', '.$_SESSION['clbcodigo'].');">Anterior</a></li>';
                                          
                        }
                        for($i=1; $i<=$nroPaginas; $i++){

                          /*
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
                          */
                            if($i == $paginaActual){
                                $lista = $lista.'<li class="active"><a href="javascript:void(0)"; onclick="paginacion_art('.$i.', '.$_SESSION['clbcodigo'].');">'.$i.'</a></li>';
                            }else if ($nroPaginas > ($i + 2) or $nroPaginas < $i -2 ) {
                                $lista = $lista.'<li><a href="javascript:void(0)"; onclick="paginacion_art('.$i.', '.$_SESSION['clbcodigo'].');">'.$i.'</a></li>';
                                                
                            }
                            else
                            {
                                 $lista = $lista.'<li><a href="javascript:void(0)"; onclick="paginacion_art('.$i.', '.$_SESSION['clbcodigo'].');">'.$i.'</a></li>';
                            }
                        }
                        if($paginaActual != $nroPaginas){
                            $lista = $lista.'<li><a href="javascript:void(0)"; onclick="paginacion_art('.($paginaActual+1).', '.$_SESSION['clbcodigo'].');">Siguiente</a></li>';
                        }
                      
                        if($paginaActual <= 1){
                          $limit = 0;
                        }else{
                          $limit = $nroLotes*($paginaActual-1);
                        }


           
                            mysqli_query($conn, "SET lc_time_names = 'es_CO'" );

                            $registro = mysqli_query($conn,"SELECT  p.citcodigo, p.clbcodigo, sln.slnnombre, ser.sernombre, t.trcrazonsocial, t2.trcrazonsocial as usuarioagenda, p.citfecha, TIME_FORMAT(p.cithora,'%H:%i')as cithora, p.citfecharegistro, p.cithoraregistro, p.citobservaciones, t3.trcrazonsocial as cliente, CONCAT(ser.serduracion, ' MIN')AS serduracion FROM btycita AS p, btycolaborador AS c, btytercero AS t1, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2, btysalon AS sln, btyservicio AS ser, btycliente AS cli, btytercero AS t3 WHERE p.usucodigo=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND p.usucodigo=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND cli.trcdocumento=t3.trcdocumento AND cli.tdicodigo=t3.tdicodigo AND cli.clicodigo=p.clicodigo AND ser.sercodigo=p.sercodigo AND sln.slncodigo=p.slncodigo AND p.clbcodigo = '".$_POST['codColaborador']."' ORDER BY p.citfecha DESC LIMIT $limit, $nroLotes")or die(mysqli_error($conn));

                            
                                while($registro2 = mysqli_fetch_array($registro)){

                                

                                 $tabla=$tabla.'<div class="col-lg-4" style="min-height: 400px!important">
                                        <div class="hpanel hblue contact-panel">
                                            <div class="panel-body">
                                                <div class="list-group">
                                                  <button type="button" class="list-group-item active">FECHA CITA: <span class="pull-right"><b>'.$registro2['citfecha'].'</b></span></button>
                                                  <button type="button" class="list-group-item"><b>SERVICIO:</b> '.$registro2['sernombre'].'</button>
                                                  <button type="button" class="list-group-item"><b>CLIENTE:</b> '.$registro2['cliente'].'</button>
                                                  <button type="button" class="list-group-item"><b>AGENDADO POR:</b> : '.$registro2['usuarioagenda'].'</button>
                                                  <button type="button" class="list-group-item"><b>'.utf8_decode('SALÓN POR').':</b> '.$registro2['slnnombre'].'</button>
                                                </div>
                                                
                                              
                                          </div>
                                          <div class="panel-footer contact-footer">
                                              <div class="row">
                                                  <div class="col-md-6 border-right"> <div class="contact-stat"><span>HORA CITA: </span> <strong>'.$registro2['cithora'].'</strong></div> </div>
                                                  <div class="col-md-6 border-right"> <div class="contact-stat"><span>'.utf8_decode('DURACIÓN:').' </span> <strong>'.$registro2['serduracion'].'</strong></div> </div>
                                                 
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
                          
                   

                    
            break;



    case 'searchApp':

            $paginaActual = $_POST['partida'];
            $art = $_POST['art'];
            $nroProductos = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM btycita a WHERE a.clbcodigo = '".$_POST['codColaborador']."' AND a.citfecha = '".$_POST['fecha']."'ORDER BY a.citfecha DESC"));
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


                         $registro = mysqli_query($conn,"SELECT  p.citcodigo, p.clbcodigo, sln.slnnombre, ser.sernombre, t.trcrazonsocial, t2.trcrazonsocial as usuarioagenda, p.citfecha, TIME_FORMAT(p.cithora,'%H:%i')as cithora, p.citfecharegistro, p.cithoraregistro, p.citobservaciones, t3.trcrazonsocial as cliente, CONCAT(ser.serduracion, ' MIN')AS serduracion FROM btycita AS p, btycolaborador AS c, btytercero AS t1, btytercero AS t2, btytercero AS t, btyusuario AS u1, btyusuario AS u2, btysalon AS sln, btyservicio AS ser, btycliente AS cli, btytercero AS t3 WHERE p.usucodigo=u1.usucodigo AND u1.tdicodigo=t1.tdicodigo AND u1.trcdocumento=t1.trcdocumento AND p.usucodigo=u2.usucodigo AND u2.tdicodigo=t2.tdicodigo AND u2.trcdocumento=t2.trcdocumento AND c.clbcodigo=p.clbcodigo AND t.tdicodigo=c.tdicodigo AND c.trcdocumento=t.trcdocumento AND cli.trcdocumento=t3.trcdocumento AND cli.tdicodigo=t3.tdicodigo AND cli.clicodigo=p.clicodigo AND ser.sercodigo=p.sercodigo AND sln.slncodigo=p.slncodigo AND p.clbcodigo = '".$_POST['codColaborador']."' AND p.citfecha = '".$_POST['fecha']."' ORDER BY p.citfecha DESC LIMIT $limit, $nroLotes")or die(mysqli_error($conn));

                            if (mysqli_num_rows($registro) > 0) 
                            {
                               
                                    while($registro2 = mysqli_fetch_array($registro))
                                    {

                                    

                                        $tabla=$tabla.'<div class="col-lg-4" >
                                            <div class="hpanel hblue contact-panel">
                                                <div class="panel-body">
                                                    <div class="list-group">
                                                      <button type="button" class="list-group-item active">FECHA CITA: <span class="pull-right"><b>'.$registro2['citfecha'].'</b></span></button>
                                                      <button type="button" class="list-group-item"><b>SERVICIO:</b> '.$registro2['sernombre'].'</button>
                                                      <button type="button" class="list-group-item"><b>CLIENTE:</b> '.$registro2['cliente'].'</button>
                                                      <button type="button" class="list-group-item"><b>AGENDADO POR:</b> : '.$registro2['usuarioagenda'].'</button>
                                                      <button type="button" class="list-group-item"><b>'.utf8_decode('SALÓN POR').':</b> '.$registro2['slnnombre'].'</button>
                                                    </div>
                                                    
                                                  
                                              </div>
                                              <div class="panel-footer contact-footer">
                                                  <div class="row">
                                                      <div class="col-md-6 border-right"> <div class="contact-stat"><span>HORA CITA: </span> <strong>'.$registro2['cithora'].'</strong></div> </div>
                                                      <div class="col-md-6 border-right"> <div class="contact-stat"><span>'.utf8_decode('DURACIÓN:').' </span> <strong>'.$registro2['serduracion'].'</strong></div> </div>
                                                     
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
                                              <button type="button" class="list-group-item active">NO HAY CITAS ASIGNADAS PARA LA FECHA '.$_POST['fecha'].' <span class="pull-right"><b></b></span></button>
                                             

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

