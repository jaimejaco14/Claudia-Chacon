<?php 
    include '../cnx_data.php';

    if ($id = $_POST['nombre']) 
    {
    
        $sql = "SELECT t.trcrazonsocial, c.trcdocumento, tdi.tdialias, c.cliempresa, o.ocunombre, b.brrnombre, c.clifecharegistro FROM btycliente c INNER JOIN btytercero t ON t.trcdocumento = c.trcdocumento INNER JOIN btyocupacion o on c.ocucodigo = o.ocucodigo INNER JOIN btybarrio b ON t.brrcodigo = b.brrcodigo INNER JOIN btytipodocumento tdi on c.tdicodigo = tdi.tdicodigo WHERE (t.trcdocumento like '".$id."%' OR t.trcrazonsocial like '%".$id."%') and cliestado = 1";
    } 
    else 
    {
    
        $sql =  "SELECT t.trcrazonsocial, c.trcdocumento, tdi.tdialias, c.cliempresa, o.ocunombre, b.brrnombre, c.clifecharegistro, c.cliimagen FROM btycliente c INNER JOIN btytercero t ON t.trcdocumento = c.trcdocumento INNER JOIN btyocupacion o on c.ocucodigo = o.ocucodigo INNER JOIN btybarrio b ON t.brrcodigo = b.brrcodigo INNER JOIN btytipodocumento tdi on c.tdicodigo = tdi.tdicodigo WHERE cliestado = 1 ";
    }
    
    $query_num_col = $sql;
 
    $result = $conn->query($query_num_col);
    $num_total_registros = $result->num_rows;
 
    $rowsPerPage = 8;
    $pageNum = 1;

    if(isset($_POST['page'])) 
    {
        $pageNum = $_POST['page'];
    }
    
    $offset = ($pageNum - 1) * $rowsPerPage;
    $total_paginas = ceil($num_total_registros / $rowsPerPage);
    $sql = $sql." ORDER BY t.trcrazonsocial limit $offset, $rowsPerPage";
    $result = $conn->query($sql);
  
    if ($result->num_rows > 0) 
    {
        //duplicacion de etiqueta, ya que la busqueda no se realiza como en los modulos previos, si no que por el contrario los parametros son pasados por una funcion hasta un nuevo archivo php.
    
          echo '<div class="row">
                    <div class="col-lg-12">  
                       <span class="label label-success pull-right"><h6>No. Registros: '.$num_total_registros.'</h6></span>    
                    </div>        
                </div> <br>';
     
            while ($row = $result->fetch_assoc()) 
            {
                if ($row['cliempresa']== "S")
                {
                    $type = '<span class="label pull-right" style="background: blue">EMPRESA</span>';
                } 
                else 
                {
                    $type = "";
                }

                $id = $row['tdialias'].": ".$row['trcdocumento'];
                $nom = substr($row['trcrazonsocial'], 0, 12);
                echo '<div class="row">
                        <div class="col-lg-3">
                            <a onclick="detalles('.$row['trcdocumento'].');">
                            <div class="hpanel hgreen contact-panel">
                                <div class="panel-body">
                                    '.$type.'
                                    <img alt="logo" class="img-circle m-b" src="../contenidos/imagenes/default.jpg">
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
                if ($row = $result->fetch_assoc()) 
                {
                    if ($row['cliempresa']== "S")
                    {
                        $type = '<span class="label pull-right" style="background: blue">EMPRESA</span>';
                    } 
                    else 
                    {
                        $type = "";
                    }

                    $nom = substr($row['trcrazonsocial'], 0, 12);
                    $id = $row['tdialias'].": ".$row['trcdocumento'];
                    echo '<div class="col-lg-3">
                            <a onclick="detalles('.$row['trcdocumento'].');"> 
                                <div class="hpanel hyellow contact-panel">
                                    <div class="panel-body">
                                    '.$type.'
                                        <img alt="logo" class="img-circle m-b" src="../contenidos/imagenes/default.jpg">
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


                if ($row = $result->fetch_assoc()) 
                {
                    if ($row['cliempresa']== "S")
                    {
                        $type = '<span class="label pull-right" style="background: blue">EMPRESA</span>';
                    } 
                    else 
                    {
                        $type = "";
                    }

                        $nom = substr($row['trcrazonsocial'], 0, 12);
                        $id = $row['tdialias'].": ".$row['trcdocumento'];
                        echo '<div class="col-lg-3">
                           <a onclick="detalles('.$row['trcdocumento'].');"> 
                                <div class="hpanel hviolet contact-panel">
                                    <div class="panel-body">
                                    '.$type.'
                                        <img alt="logo" class="img-circle m-b" src="../contenidos/imagenes/default.jpg">
                                        <h3>'.$nom.' </h3>
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
                        
                            $nom = substr($row['trcrazonsocial'], 0, 12);
                            $id = $row['tdialias'].": ".$row['trcdocumento'];
                                echo '<div class="col-lg-3">
                                <a onclick="detalles('.$row['trcdocumento'].');"> 
                                    <div class="hpanel hblue contact-panel">
                                        <div class="panel-body">
                                        '.$type.'
                                            <img alt="logo" class="img-circle m-b" src="../contenidos/imagenes/default.jpg">
                                            <h3>'.$nom.' </h3>
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
                        echo '<center><div class="col-lg-12"><div class="pagination">';
                        echo '<ul class="pagination pull-right"></ul>';
                            if ($pageNum != 1)
                                    echo '<li><a class="paginate" onclick="paginar('.($pageNum-1).');" data="'.($pageNum-1).'">Anterior</a></li>';
                                  if ($total_paginas == $pageNum){
                                      
                                  } else if ($total_paginas == 7) {
                                      $first = 3;


                                  }
                                for ($i=1;$i<=$total_paginas;$i++) {
                                    if ($pageNum == $i)
                                            //si muestro el índice de la página actual, no coloco enlace
                                            echo '<li class="active"><a onclick="paginar('.$i.');">'.$i.'</a></li>';
                                    else
                                            //si el índice no corresponde con la página mostrada actualmente,
                                            //coloco el enlace para ir a esa página
                                            echo '<li><a class="paginate" onclick="paginar('.$i.');" data="'.$i.'">'.$i.'</a></li>';
                            }
                            if ($pageNum != $total_paginas)
                                    echo '<li><a class="paginate" onclick="paginar('.($pageNum+1).');" data="'.($pageNum+1).'">Siguiente</a></li>';
                       echo '</ul>';
                       echo '</div> </div></center> ';
                    }

?>