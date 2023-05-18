<link href="CSS/usuarios_css.css" rel="stylesheet" type="text/css"/>  
 <link rel="stylesheet" href="vendor/metisMenu/dist/metisMenu.css" />

<?php 
function tiempoTranscurridoFechas($fechaInicio,$fechaFin)
{
    $fecha1 = new DateTime($fechaInicio);
    $fecha2 = new DateTime($fechaFin);
    $fecha = $fecha1->diff($fecha2);
    $tiempo = "";
         
    //años
    if($fecha->y > 0)
    {
        $tiempo .= $fecha->y;
             
        if($fecha->y == 1)
            $tiempo .= " año, ";
        else
            $tiempo .= " años, ";
    }
         
    //meses
    if($fecha->m > 0)
    {
        $tiempo .= $fecha->m;
             
        if($fecha->m == 1)
            $tiempo .= " mes";
        else
            $tiempo .= " meses";
    }
    return $tiempo;
}
include '../cnx_data.php';
header('Content-Type: text/html; charset=utf-8');
$id_colaborador = $_POST['id_colaborador'];
  $result = $conn->query("SELECT c.cblimagen, c.clbfechaingreso, c.trcdocumento, a.ctcnombre, a.ctccolor, c.clbcodigo, c.`tdicodigo`, tdi.tdinombre, tdi.tdialias, trc.trcdigitoverificacion, trc.trcdireccion, trc.brrcodigo, brr.brrnombre, trc.trctelefonofijo, trc.trctelefonomovil, trc.trcnombres, trc.trcapellidos, trc.trcrazonsocial, car.crgnombre, c.`clbsexo`, c.`crgcodigo`, c.`ctccodigo`, ctc.ctcnombre, c.`clbemail`, c.`clbfechanacimiento`, c.`clbnotificacionemail`, c.`clbnotificacionmovil` FROM `btycolaborador` c INNER JOIN btytercero trc ON c.trcdocumento = trc.trcdocumento INNER JOIN btycargo car ON car.crgcodigo = c.crgcodigo INNER JOIN btycategoria_colaborador ctc ON ctc.ctccodigo = c.ctccodigo INNER JOIN btytipodocumento tdi ON tdi.tdicodigo = c.tdicodigo INNER JOIN btybarrio brr ON trc.brrcodigo = brr.brrcodigo INNER JOIN btycategoria_colaborador a ON c.ctccodigo = a.ctccodigo where c.trcdocumento =".$id_colaborador);
 if ($result->num_rows > 0) {
     $cont = 0;
     while ($row = $result->fetch_assoc()) {
        $alias = $row['tdialias'];
        $id = $row['clbcodigo'];
        $nombres = $row['trcnombres'];
        $Apellidos = $row['trcapellidos'];
        $sexo = $row['clbsexo'];
        $fecha = $row['clbfechanacimiento'];
        $cargo = $row['crgnombre'];
        $Documento = $row['trcdocumento'];
        $img = $row['cblimagen'];


         if ($row['ctccodigo']== 0){
             $type = "N/A";
             $hpanel = "";
         } else {
             $color = $row['ctccolor'];
             $type = '<span class="label pull-right" style="background: #'.$row['ctccolor'].'">'.$row['ctcnombre'].'</span>';
             if ($row['ctccodigo']==1){
                 $hpanel = "hyellow";
             } else if($row['ctccodigo']==2) {
                 $hpanel = "hblue";
             } else if($row['ctccodigo']==3) {
                 $hpanel = "hred";
             }
         }
         $fecha1 = str_replace("/","-",$fecha);
        $fecha1 = date('Y/m/d',strtotime($fecha1));
        $hoy = date('Y/m/d');
        $edad = $hoy - $fecha1;
        $today = date("Y-m-d");
        $tiempo = tiempoTranscurridoFechas($row['clbfechaingreso'], $today);
         echo '<div class="row">
    <div class="col-lg-4">
        <div class="hpanel '.$hpanel.' contact-panel">
            <div class="panel-body">

                <img alt="logo" class="img-circle m-b m-t-md" onerror="this.src=\'../contenidosimagenes/default.jpg\';" src="../contenidos/imagenes/colaborador/'.$img.'">
                <h3>'.utf8_encode($row['trcrazonsocial']).'</h3>
                <div class="text-muted font-bold m-b-xs">'.utf8_encode($row['brrnombre']).'</div>
                <p>
                    Lorem '.$row['clbcodigo'].' ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan.
                </p>
                
            </div>
            <div class="panel-body">
                <dl>
                    
                     <dt>Telefono movil</dt>
                        <dd>  - '.$row['trctelefonomovil'].'</dd>
                    <dt>Email</dt>
                        <dd> - '.$row['clbemail'].'</dd>
                        <dt>Direccion</dt>
                    <dd>-'.$row['trcdireccion'].'</dd>
                </dl>
            </div>
            <div class="panel-footer contact-footer">
                <div class="row">
                    <div class="col-md-4 border-right">
                        <div class="contact-stat"><span>Fecha ingreso: </span> <strong>'.$row['clbfechaingreso'].'</strong></div>
                    </div>
                    <div class="col-md-4 border-right">
                        <div class="contact-stat"><span>Tiempo en la empresa: </span> <strong>'.$tiempo.'</strong></div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-stat"><span>Edad: </span> <strong>'.$edad.' años</strong></div>
                    </div>
                </div>
            </div>

        </div>
    </div> ';
}

}

?>  

    <div class="col-lg-8">
        <div class="hpanel">
            <div class="hpanel">

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1">programaci&oacute;n</a></li>
                <li class=""><a data-toggle="tab" href="#tab-2">Servicios</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <div id="calendar"></div>
                        <button class="btn-success pull-right">Enviar</button>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane">
                    <div class="panel-body no-padding">


                        <div class="chat-discussion" style="height: auto">

                            <div class="chat-message">
                                <img class="message-avatar" src="images/a1.jpg" alt="" >
                                <div class="message">
                                    <a class="message-author" href="#"> Michael Smith </a>
                                    <span class="message-date"> Mon Jan 26 2015 - 18:39:23 </span>
                                            <span class="message-content">
                                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                                            </span>

                                    <div class="m-t-md">
                                        <a class="btn btn-xs btn-default"><i class="fa fa-thumbs-up"></i> Like </a>
                                        <a class="btn btn-xs btn-success"><i class="fa fa-heart"></i> Love</a>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-message">
                                <img class="message-avatar" src="images/a4.jpg" alt="" >
                                <div class="message">
                                    <a class="message-author" href="#"> Karl Jordan </a>
                                    <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
                                            <span class="message-content">
                                            Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover.
                                            </span>
                                    <div class="m-t-md">
                                        <a class="btn btn-xs btn-default"><i class="fa fa-thumbs-up"></i> Like </a>
                                        <a class="btn btn-xs btn-default"><i class="fa fa-heart"></i> Love</a>
                                        <a class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Message</a>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-message">
                                <img class="message-avatar" src="images/a2.jpg" alt="" >
                                <div class="message">
                                    <a class="message-author" href="#"> Michael Smith </a>
                                    <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
                                            <span class="message-content">
                                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration.
                                            </span>
                                </div>
                            </div>
                            <div class="chat-message">
                                <img class="message-avatar" src="images/a5.jpg" alt="" >
                                <div class="message">
                                    <a class="message-author" href="#"> Alice Jordan </a>
                                    <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
                                            <span class="message-content">
                                            All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.
                                                It uses a dictionary of over 200 Latin words.
                                            </span>
                                    <div class="m-t-md">
                                        <a class="btn btn-xs btn-default"><i class="fa fa-thumbs-up"></i> Like </a>
                                        <a class="btn btn-xs btn-warning"><i class="fa fa-eye"></i> Nudge</a>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-message">
                                <img class="message-avatar" src="images/a6.jpg" alt="" >
                                <div class="message">
                                    <a class="message-author" href="#"> Mark Smith </a>
                                    <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
                                            <span class="message-content">
                                            All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.
                                                It uses a dictionary of over 200 Latin words.
                                            </span>
                                    <div class="m-t-md">
                                        <a class="btn btn-xs btn-default"><i class="fa fa-thumbs-up"></i> Like </a>
                                        <a class="btn btn-xs btn-success"><i class="fa fa-heart"></i> Love</a>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-message">
                                <img class="message-avatar" src="images/a4.jpg" alt="" >
                                <div class="message">
                                    <a class="message-author" href="#"> Karl Jordan </a>
                                    <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
                                            <span class="message-content">
                                            Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover.
                                            </span>
                                    <div class="m-t-md">
                                        <a class="btn btn-xs btn-default"><i class="fa fa-thumbs-up"></i> Like </a>
                                        <a class="btn btn-xs btn-default"><i class="fa fa-heart"></i> Love</a>
                                        <a class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Message</a>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-message">
                                <img class="message-avatar" src="images/a2.jpg" alt="" >
                                <div class="message">
                                    <a class="message-author" href="#"> Michael Smith </a>
                                    <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
                                            <span class="message-content">
                                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration.
                                            </span>
                                </div>
                            </div>
                            <div class="chat-message">
                                <img class="message-avatar" src="images/a5.jpg" alt="" >
                                <div class="message">
                                    <a class="message-author" href="#"> Alice Jordan </a>
                                    <span class="message-date">  Fri Jan 25 2015 - 11:12:36 </span>
                                            <span class="message-content">
                                            All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.
                                                It uses a dictionary of over 200 Latin words.
                                            </span>
                                    <div class="m-t-md">
                                        <a class="btn btn-xs btn-default"><i class="fa fa-thumbs-up"></i> Like </a>
                                        <a class="btn btn-xs btn-default"><i class="fa fa-heart"></i> Love</a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            </div>
        </div>
    </div>

                        


