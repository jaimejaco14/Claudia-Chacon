<?php 
    include("../../../cnx_data.php");
    include("../funciones.php");
    
    //Librería PHPMailer para el envío de e-mails
    require '../../../lib/phpmailer/phpmailer/PHPMailerAutoload.php';
    
    function enviarEmail($nuevaAutorizacion, $asunto, $valores, $destinatarios){

        $email = new PHPMailer;
        $email->isSMTP();
        $email->SMTPDebug = 0;
        $email->Debugoutput = 'html';
        $email->Host = "smtp.gmail.com";
        $email->Port = 587;
        $email->SMTPAuth = true;
	$email->SMTPSecure = 'tls';
        $email->Username = "emails.claudiachacon.@gmail.com";
        $email->Password = "hfsvghitqumivmwm";
        $email->setFrom('info@claudiachacon.com', 'Beauty Soft');
        $email->Subject = utf8_decode($asunto);

        foreach($destinatarios as $destinatario){

            $email->addAddress($destinatario["email"], $destinatario["name"]);
        }

        $email->msgHTML(generarTablaHtml($nuevaAutorizacion, $valores));
        return $email->send();
    }

    function generarTablaHtml($nuevaAutorizacion, $valores){
        
        $html = '<table style="border: 2px solid black;">';

        if($nuevaAutorizacion){ //Nueva autorización

            $html .= '<tr>
                        <td colspan="2" style="background-color: #A3CEE0; text-align: center; padding: 0px 70px; border-bottom: 2px solid black;">
                            <span style="font-size: xx-large;"><b>BeautySoft - Autorizaciones</b></span>
                            <br><br>
                            <span style="color: grey; font-size: x-large;"><b>Autorizaci&oacute;n # '.$valores['autnum'].'</b></span>
                        </td>
                    </tr>';
        }
        else{ //Anulación de autorización

            $html .= '<tr>
                        <td colspan="2" style="background-color: red; text-align: center; padding: 0px 70px; border-bottom: 2px solid black;">
                            <span style="font-size: xx-large;"><b>BeautySoft - ANULACI&Oacute;N</b></span>
                            <br><br>
                            <span style="color: white; font-size: x-large;"><b>ANULACI&Oacute;N Autorizaci&oacute;n # 1</b></span>
                        </td>
                    </tr>';
        }

        $html .= '<tr>
                    <td style="border: 2px solid black; padding: 10px 0px; font-size: larger;"><b>Tipo</b></td>
                    <td style="border: 2px solid black; font-size: larger">'.$valores['auttpo'].'</td>
                </tr>
                <tr>
                    <td style="border: 2px solid black; padding: 10px 0px; font-size: larger;"><b>Subtipo</b></td>
                    <td style="border: 2px solid black; font-size: larger">'.$valores['autstpo'].'</td>
                </tr>
                <tr>
                    <td style="border: 2px solid black; padding: 10px 0px; font-size: larger;"><b>Fecha</b></td>
                    <td style="border: 2px solid black; font-size: larger">'.$valores['autdate'].'</td>
                </tr>
                <tr>
                    <td style="border: 2px solid black; padding: 10px 0px; font-size: larger;"><b>Sal&oacute;n</b></td>
                    <td style="border: 2px solid black; font-size: larger">'.$valores['autsln'].'</td>
                </tr>
                <tr>
                    <td style="border: 2px solid black; padding: 10px 0px; font-size: larger;"><b>Valor</b></td>
                    <td style="border: 2px solid black; font-size: larger">'.$valores['autvlr'].'</td>
                </tr>
                <tr>
                    <td style="border: 2px solid black; padding: 10px 0px; font-size: larger;"><b>Beneficiario</b></td>
                    <td style="border: 2px solid black; font-size: larger">'.$valores['autben'].'</td>
                </tr>
                <tr>
                    <td style="border: 2px solid black; padding: 10px 0px; font-size: larger;"><b>Concepto</b></td>
                    <td style="border: 2px solid black; font-size: larger">'.$valores['autcon'].'</td>
                </tr>
                <tr>
                    <td style="border: 2px solid black; padding: 10px 0px; font-size: larger;"><b>Aprobado por</b></td>
                    <td style="border: 2px solid black; font-size: larger">'.$valores['autapro'].'</td>
                </tr>
                <tr>
                    <td colspan="2" style="border: 2px solid black; text-align: center; padding-top: 10px; background-color: red; color: white;">
                        <h3>Esto es un correo autom&aacute;tico</h3>
                        <h2>Por favor, NO responda sobre este correo</h2>
                        <h3>BeautySoft 2022</h3>
                    </td>
                </tr>
            </table>';

        return $html;
    }

    switch ($_POST['opcion']) 
    {
        case 'loadColaborador':

                $f = "SELECT a.clbcodigo, b.trcrazonsocial FROM btycolaborador a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento JOIN btycargo c ON c.crgcodigo=a.crgcodigo WHERE bty_fnc_estado_colaborador(a.clbcodigo) = 'VINCULADO' ORDER BY trcrazonsocial";

                
                $sql = mysqli_query($conn,$f)or die(mysqli_error($conn));



                $array = array();

                while ($row = mysqli_fetch_array($sql)) 
                {  
                    $array[] = array('clbcodigo' => $row['clbcodigo'], 'colaborador' => $row['trcrazonsocial']);
                }

                    $array = utf8_converter($array);
                    echo json_encode(array("res" => "full", "json" => $array));
            break;

        case 'loadColaboradorAux':

                $f = "SELECT a.clbcodigo, b.trcrazonsocial FROM btycolaborador a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento JOIN btycargo c ON c.crgcodigo=a.crgcodigo WHERE bty_fnc_estado_colaborador(a.clbcodigo) = 'VINCULADO' AND c.crgincluircolaturnos = 0 ORDER BY trcrazonsocial";

                
                $sql = mysqli_query($conn,$f)or die(mysqli_error($conn));



                $array = array();

                while ($row = mysqli_fetch_array($sql)) 
                {  
                    $array[] = array('clbcodigo' => $row['clbcodigo'], 'colaborador' => $row['trcrazonsocial']);
                }

                    $array = utf8_converter($array);
                    echo json_encode(array("res" => "full", "json" => $array));
            break;
          

        case 'loadColaboradorAdm':

                $f = "(SELECT a.clbcodigo, b.trcrazonsocial, c.crgincluircolaturnos FROM btycolaborador a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento JOIN btycargo c ON c.crgcodigo=a.crgcodigo WHERE bty_fnc_estado_colaborador(a.clbcodigo) = 'VINCULADO' AND c.crgincluircolaturnos = 0) UNION (SELECT pman.prmcodigo, trc.trcrazonsocial, 'M' FROM btypersona_mantenimiento pman JOIN btytercero trc ON trc.tdicodigo=pman.tdicodigo AND trc.trcdocumento=pman.trcdocumento WHERE pman.prmestado = 1) UNION (SELECT pro.prvcodigo, trc.trcrazonsocial, 'P' FROM btyproveedor pro JOIN btytercero trc ON trc.tdicodigo=pro.tdicodigo AND  trc.trcdocumento=pro.trcdocumento WHERE pro.prvestado = 1) ORDER BY trcrazonsocial";

                
                $sql = mysqli_query($conn,$f);



                $array = array();

                while ($row = mysqli_fetch_array($sql)) 
                {  
                    $array[] = array('clbcodigo' => $row['clbcodigo'], 'colaborador' => $row['trcrazonsocial'], 'incluir' => $row['crgincluircolaturnos']);
                }

                    $array = utf8_converter($array);
                    echo json_encode(array("res" => "full", "json" => $array));
            break;

        case 'ingreso':
                $sqlmax = mysqli_query($conn, "SELECT MAX(autcodigo) FROM btyautorizaciones");
                $fetch = mysqli_fetch_array($sqlmax);
                $max = $fetch[0]+1;


                $sln = mysqli_query($conn, "SELECT slnemail, slnnombre FROM btysalon WHERE slncodigo = '".$_POST['sln']."' AND slnestado = 1");

                $salon = mysqli_fetch_array($sln);

                $usuario = mysqli_query($conn, "SELECT b.trcrazonsocial FROM btyusuario a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE a.usucodigo = '".$_SESSION['codigoUsuario']."' ");



                $usuarioFetch = mysqli_fetch_array($usuario);

                $usuarioAprueba = $usuarioFetch[0];


                $myArray = explode(',', $_POST['col']);

                if ($myArray[1] == null || $myArray == '') 
                {
                    $col = $myArray[0];
                }  

                //TIPO 5 MANTENIMIENTO
                if ($_POST['tipo'] == '5' ) 
                {

                    $myArray = explode(',', $_POST['col']);

                    if ($_POST['docTer'] == '' || $_POST['docTer'] == null) 
                    {

                        if ($myArray[1] == 'M') 
                        {
                            $colman = $myArray[0];//persona mantenimiento

                            $sql = mysqli_query($conn, "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, subtipo, slncodigo, clbcodigo, prmcodigo, usucodigo, observacion, autvalor, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite) VALUES('$max', '".$_POST['tipo']."', '".$_POST['subtipo']."', '".$_POST['sln']."', NULL, '".$colman."',  '".$_SESSION['codigoUsuario']."', '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['val']."', '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO')  ")or die(mysqli_error($conn));

                                $sqlCol = mysqli_query($conn, "SELECT c.trcrazonsocial,  CONCAT('$',FORMAT(a.autvalor,0))AS autvalor FROM btyautorizaciones a JOIN btypersona_mantenimiento b ON a.prmcodigo=b.prmcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.prmcodigo =  '".$colman."' AND a.autcodigo = $max");



                                $queryTipo = mysqli_query($conn, "SELECT a.nombre FROM btyautorizaciones_tipo a WHERE a.auttipo_codigo = '".$_POST['tipo']."' ");

                                $querySubtipo = mysqli_query($conn, "SELECT b.subtipo_nombre FROM btyautorizaciones_subtipo b WHERE b.subtipo = '".$_POST['subtipo']."' ");

                                $fetchSubtipo = mysqli_fetch_array($querySubtipo);
                                $subtipo = $fetchSubtipo[0];



                                $fetchTipo = mysqli_fetch_array($queryTipo);
                                

                                $fetchCol = mysqli_fetch_array($sqlCol);

                                if ($sql) 
                                {
                                    $destinatarios = [
                                        ['name' => 'Asistente Operaciones', 'email' => 'asistente.operaciones@claudiachacon.com'],
                                        ['name' => 'Coordinacion Administrativa', 'email' => 'coordinacion.administrativa@claudiachacon.com'],
                                        ['name' => 'Claudia Chacon Mantenimiento', 'email' => 'claudiachaconmantenimiento@gmail.com'],
                                        ['name' => 'BeautySoft', 'email' => $salon['slnemail']] 
                                    ];

                                    $asunto = 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  MANTENIMIENTO';

                                    $valores = [
                                        'autnum'  =>  $max,
                                        'auttpo'  =>  $fetchTipo[0],
                                        'autstpo' =>  $subtipo,
                                        'autdate' =>  $_POST['fec'],
                                        'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                        'autvlr'  =>  $fetchCol[1],
                                        'autben'  =>  ucwords(strtolower($fetchCol[0])),
                                        'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                        'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                    ];

                                    if(enviarEmail(true, $asunto, $valores, $destinatarios)){
                                        echo json_encode(array('res' => 1, 'codigo' => $max));
                                    }
                                    else{
                                        echo json_encode(array('res' => 0));
                                    }                                        
                                }
                        }
                        else
                        {

                            if ($myArray[1] == 'P') 
                        {
                            $proveedor = $myArray[0];//persona Proveedor

                            $sql = mysqli_query($conn, "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, subtipo, slncodigo, prvcodigo, usucodigo, observacion, autvalor, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite) VALUES('$max', '".$_POST['tipo']."', '".$_POST['subtipo']."', '".$_POST['sln']."', '".$proveedor."',  '".$_SESSION['codigoUsuario']."', '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['val']."', '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO')  ")or die(mysqli_error($conn));

                                $sqlCol = mysqli_query($conn, "SELECT c.trcrazonsocial,  CONCAT('$',FORMAT(a.autvalor,0))AS autvalor FROM btyautorizaciones a JOIN btyproveedor b ON a.prvcodigo=b.prvcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.prvcodigo = '".$proveedor."' AND a.autcodigo = $max");





                                $queryTipo = mysqli_query($conn, "SELECT a.nombre FROM btyautorizaciones_tipo a WHERE a.auttipo_codigo = '".$_POST['tipo']."' ");

                                $querySubtipo = mysqli_query($conn, "SELECT b.subtipo_nombre FROM btyautorizaciones_subtipo b WHERE b.subtipo = '".$_POST['subtipo']."' ");

                                $fetchSubtipo = mysqli_fetch_array($querySubtipo);
                                $subtipo = $fetchSubtipo[0];



                                $fetchTipo = mysqli_fetch_array($queryTipo);
                                

                                $fetchCol = mysqli_fetch_array($sqlCol);

                                if ($sql) 
                                {
                                    $destinatarios = [
                                        ['name' => 'Asistente Operaciones', 'email' => 'asistente.operaciones@claudiachacon.com'],
                                        ['name' => 'Coordinacion Administrativa', 'email' => 'coordinacion.administrativa@claudiachacon.com'],
                                        ['name' => 'Claudia Chacon Mantenimiento', 'email' => 'claudiachaconmantenimiento@gmail.com'],
                                        ['name' => 'BeautySoft', 'email' => $salon['slnemail']] 
                                    ];

                                    $asunto = 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  MANTENIMIENTO';

                                    $valores = [
                                        'autnum'  =>  $max,
                                        'auttpo'  =>  $fetchTipo[0],
                                        'autstpo' =>  $subtipo,
                                        'autdate' =>  $_POST['fec'],
                                        'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                        'autvlr'  =>  $fetchCol[1],
                                        'autben'  =>  ucwords(strtolower($fetchCol[0])),
                                        'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                        'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                    ];

                                    if(enviarEmail(true, $asunto, $valores, $destinatarios)){
                                        echo json_encode(array('res' => 1, 'codigo' => $max));
                                    }
                                    else{
                                        echo json_encode(array('res' => 0));
                                    }


                                    /*$dest=array(
                                        array('name' => 'Direccion Operaciones','email' => 'direccion.operaciones@claudiachacon.com'),
                                        array('name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'),
                                        array('name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                        array('name' => 'BeautySoft','email' => $salon['slnemail'])
                                    );
                                    $email = array(
                                        'subject' => 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  MANTENIMIENTO',
                                        'template'=>array(
                                            'id'=>'190022',
                                            'variables'=>array(
                                              'autnum'  =>  $max,
                                              'auttpo'  =>  $fetchTipo[0],
                                              'autstpo' =>  $subtipo,
                                              'autdate' =>  $_POST['fec'],
                                              'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                              'autvlr'  =>  $fetchCol[1],
                                              'autben'  =>  ucwords(strtolower($fetchCol[0])),
                                              'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                              'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                            ),
                                        ),
                                        'from' => array(
                                          'name' => 'Claudia Chacon - Belleza y Estetica',
                                          'email' => 'info@claudiachacon.com',
                                        ),
                                        'to' => $dest,
                                    );
                                    if ($SPApiClient->smtpSendMail($email))
                                    {
                                        echo json_encode(array('res' => 1, 'codigo' => $max));
                                    } 
                                    else 
                                    {
                                        echo json_encode(array('res' => 0));
                                    }*/ 
                                }
                        }
                        ////////////
                            $colclb = $myArray[0];// persona de clb

                            $sql = mysqli_query($conn, "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, subtipo, slncodigo, clbcodigo, prmcodigo, usucodigo, observacion, autvalor, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite) VALUES('$max', '".$_POST['tipo']."', '".$_POST['subtipo']."', '".$_POST['sln']."', '".$colclb."', NULL,  '".$_SESSION['codigoUsuario']."', '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['val']."', '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO')  ")or die(mysqli_error($conn));


                                $sqlCol = mysqli_query($conn, "SELECT c.trcrazonsocial, CONCAT('$',FORMAT(a.autvalor,0))AS autvalor FROM btyautorizaciones a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.clbcodigo =  '".$colclb."' AND a.autcodigo = $max ");

                                $queryTipo = mysqli_query($conn, "SELECT a.nombre FROM btyautorizaciones_tipo a WHERE a.auttipo_codigo = '".$_POST['tipo']."' ");

                                $querySubtipo = mysqli_query($conn, "SELECT b.subtipo_nombre FROM btyautorizaciones_subtipo b WHERE b.subtipo = '".$_POST['subtipo']."' ");

                                $fetchSubtipo = mysqli_fetch_array($querySubtipo);
                                $subtipo = $fetchSubtipo[0];



                                $fetchTipo = mysqli_fetch_array($queryTipo);
                                

                                $fetchCol = mysqli_fetch_array($sqlCol);

                                if ($sql) 
                                {

                                    $destinatarios = [
                                        ['name' => 'Asistente Operaciones', 'email' => 'asistente.operaciones@claudiachacon.com'],
                                        ['name' => 'Coordinacion Administrativa', 'email' => 'coordinacion.administrativa@claudiachacon.com'],
                                        ['name' => 'Claudia Chacon Mantenimiento', 'email' => 'claudiachaconmantenimiento@gmail.com'],
                                        ['name' => 'BeautySoft', 'email' => $salon['slnemail']] 
                                    ];

                                    $asunto = 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  MANTENIMIENTO';

                                    $valores = [
                                        'autnum'  =>  $max,
                                        'auttpo'  =>  $fetchTipo[0],
                                        'autstpo' =>  $subtipo,
                                        'autdate' =>  $_POST['fec'],
                                        'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                        'autvlr'  =>  $fetchCol[1],
                                        'autben'  =>  ucwords(strtolower($fetchCol[0])),
                                        'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                        'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                    ];

                                    if(enviarEmail(true, $asunto, $valores, $destinatarios)){
                                        echo json_encode(array('res' => 1, 'codigo' => $max));
                                    }
                                    else{
                                        echo json_encode(array('res' => 0));
                                    }


                                    
                                    /*$dest=array(
                                        array('name' => 'Direccion Operaciones','email' => 'direccion.operaciones@claudiachacon.com'),
                                        array('name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'),
                                        array('name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                        array('name' => 'BeautySoft','email' => $salon['slnemail'])
                                    );
                                    $email = array(
                                        'subject' => 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  MANTENIMIENTO',
                                        'template'=>array(
                                            'id'=>'190022',
                                            'variables'=>array(
                                              'autnum'  =>  $max,
                                              'auttpo'  =>  $fetchTipo[0],
                                              'autstpo' =>  $subtipo,
                                              'autdate' =>  $_POST['fec'],
                                              'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                              'autvlr'  =>  $fetchCol[1],
                                              'autben'  =>  ucwords(strtolower($fetchCol[0])),
                                              'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                              'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                            ),
                                        ),
                                        'from' => array(
                                          'name' => 'Claudia Chacon - Belleza y Estetica',
                                          'email' => 'info@claudiachacon.com',
                                        ),
                                        'to' => $dest,
                                    );
                                    if ($SPApiClient->smtpSendMail($email))
                                    {
                                        echo json_encode(array('res' => 1, 'codigo' => $max));
                                    } 
                                    else 
                                    {
                                        echo json_encode(array('res' => 0));
                                    }*/                          
                                    
                                }
                        }
                    }
                    else
                    {
                        

                        $docter = $_POST['docTer'];

                        $query = mysqli_query($conn, "SELECT prmcodigo FROM btypersona_mantenimiento WHERE trcdocumento  = '".$_POST['docTer']."' ");  

                        $s = mysqli_fetch_array($query);

                        $trcdocmante = $s[0]; 


                            $sqlmax = mysqli_query($conn, "SELECT MAX(autcodigo) FROM btyautorizaciones");
                            $fetch = mysqli_fetch_array($sqlmax);
                            $max = $fetch[0]+1;

                        //pregunto si esta en manteniiento
                        if (mysqli_num_rows($query) > 0) 
                        {
                            $d = "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, subtipo, slncodigo, prmcodigo, usucodigo, observacion, autvalor, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite) VALUES('$max', '".$_POST['tipo']."', '".$_POST['subtipo']."', '".$_POST['sln']."', '".$trcdocmante."',  '".$_SESSION['codigoUsuario']."', '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['val']."', '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO')  "; 

                            $sql = mysqli_query($conn, $d)or die("Error " . mysqli_error($conn));

                            if ($sql) 
                            {
                               

                                    $sln = mysqli_query($conn, "SELECT slnemail, slnnombre FROM btysalon WHERE slncodigo = '".$_POST['sln']."' AND slnestado = 1");

                                    $salon = mysqli_fetch_array($sln);

                                    $usuario = mysqli_query($conn, "SELECT b.trcrazonsocial FROM btyusuario a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE a.usucodigo = '".$_SESSION['codigoUsuario']."' ");



                                    $usuarioFetch = mysqli_fetch_array($usuario);

                                    $usuarioAprueba = $usuarioFetch[0];  


                                    $s = "SELECT c.trcrazonsocial,  CONCAT('$',FORMAT(a.autvalor,0))AS autvalor FROM btyautorizaciones a JOIN btypersona_mantenimiento b ON a.prmcodigo=b.prmcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.autcodigo = $max";


                                    //echo $s;

                                    $sqlCol = mysqli_query($conn, $s)or die(mysqli_error($conn));

                                    $fetchCol = mysqli_fetch_array($sqlCol);

                                     $querySubtipo = mysqli_query($conn, "SELECT b.subtipo_nombre FROM btyautorizaciones_subtipo b WHERE b.subtipo = '".$_POST['subtipo']."' ");

                                    $fetchSubtipo = mysqli_fetch_array($querySubtipo);
                                    $subtipo = $fetchSubtipo[0];



                                    $queryTipo = mysqli_query($conn, "SELECT a.nombre FROM btyautorizaciones_tipo a WHERE a.auttipo_codigo = '".$_POST['tipo']."' ");
                                    $fetchTipo = mysqli_fetch_array($queryTipo);

                                    $destinatarios = [
                                        ['name' => 'Asistente Operaciones', 'email' => 'asistente.operaciones@claudiachacon.com'],
                                        ['name' => 'Coordinacion Administrativa', 'email' => 'coordinacion.administrativa@claudiachacon.com'],
                                        ['name' => 'Claudia Chacon Mantenimiento', 'email' => 'claudiachaconmantenimiento@gmail.com'],
                                        ['name' => 'BeautySoft', 'email' => $salon['slnemail']] 
                                    ];

                                    $asunto = 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  MANTENIMIENTO';

                                    $valores = [
                                        'autnum'  =>  $max,
                                        'auttpo'  =>  $fetchTipo[0],
                                        'autstpo' =>  $subtipo,
                                        'autdate' =>  $_POST['fec'],
                                        'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                        'autvlr'  =>  $fetchCol['autvalor'],
                                        'autben'  =>  ucwords(strtolower($fetchCol['trcrazonsocial'])),
                                        'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                        'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                    ];

                                    if(enviarEmail(true, $asunto, $valores, $destinatarios)){
                                        echo json_encode(array('res' => 1, 'codigo' => $max));
                                    }
                                    else{
                                        echo json_encode(array('res' => 0));
                                    }

                                    
                                    /*$dest=array(
                                        array('name' => 'Direccion Operaciones','email' => 'direccion.operaciones@claudiachacon.com'),
                                        array('name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'),
                                        array('name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                        array('name' => 'BeautySoft','email' => $salon['slnemail'])
                                    );
                                    $email = array(
                                        'subject' => 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  MANTENIMIENTO',
                                        'template'=>array(
                                            'id'=>'190022',
                                            'variables'=>array(
                                              'autnum'  =>  $max,
                                              'auttpo'  =>  $fetchTipo[0],
                                              'autstpo' =>  $subtipo,
                                              'autdate' =>  $_POST['fec'],
                                              'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                              'autvlr'  =>  $fetchCol['autvalor'],
                                              'autben'  =>  ucwords(strtolower($fetchCol['trcrazonsocial'])),
                                              'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                              'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                            ),
                                        ),
                                        'from' => array(
                                          'name' => 'Claudia Chacon - Belleza y Estetica',
                                          'email' => 'info@claudiachacon.com',
                                        ),
                                        'to' => $dest,
                                    );
                                    if ($SPApiClient->smtpSendMail($email))
                                    {
                                        echo json_encode(array('res' => 1, 'codigo' => $max));
                                    } 
                                    else 
                                    {
                                        echo json_encode(array('res' => 0));
                                    }*/                             
                                
                            }

                            
                        } 
                        else
                        {
                            $queryPro = mysqli_query($conn, "SELECT prvcodigo FROM btyproveedor WHERE trcdocumento  = '".$_POST['docTer']."' ");

                            $fetchPro = mysqli_fetch_array($queryPro);

                            $proveedor = $fetchPro['prvcodigo'];

                            if (mysqli_num_rows($queryPro) > 0) 
                            {

                                    $d = "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, subtipo, slncodigo, prvcodigo, usucodigo, observacion, autvalor, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite) VALUES('$max', '".$_POST['tipo']."', '".$_POST['subtipo']."', '".$_POST['sln']."', '".$proveedor."',  '".$_SESSION['codigoUsuario']."', '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['val']."', '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO')  ";

                                    //echo $d;

                                    $sql = mysqli_query($conn, $d)or die('Error ' .mysqli_error($conn));

                                    if ($sql) 
                                    {
                                        
                                            $sln = mysqli_query($conn, "SELECT slnemail, slnnombre FROM btysalon WHERE slncodigo = '".$_POST['sln']."' AND slnestado = 1");

                                            $salon = mysqli_fetch_array($sln);

                                            $usuario = mysqli_query($conn, "SELECT b.trcrazonsocial FROM btyusuario a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE a.usucodigo = '".$_SESSION['codigoUsuario']."' ");



                                            $usuarioFetch = mysqli_fetch_array($usuario);

                                            $usuarioAprueba = $usuarioFetch[0];  


                                            $s = "SELECT c.trcrazonsocial,  CONCAT('$',FORMAT(a.autvalor,0))AS autvalor FROM btyautorizaciones a JOIN btyproveedor b ON a.prvcodigo=b.prvcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.autcodigo = $max";


                                   //5 echo $s;

                                    $sqlCol = mysqli_query($conn, $s)or die(mysqli_error($conn));

                                    $fetchCol = mysqli_fetch_array($sqlCol);

                                     $querySubtipo = mysqli_query($conn, "SELECT b.subtipo_nombre FROM btyautorizaciones_subtipo b WHERE b.subtipo = '".$_POST['subtipo']."' ");

                                    $fetchSubtipo = mysqli_fetch_array($querySubtipo);
                                    $subtipo = $fetchSubtipo[0];



                                    $queryTipo = mysqli_query($conn, "SELECT a.nombre FROM btyautorizaciones_tipo a WHERE a.auttipo_codigo = '".$_POST['tipo']."' ");
                                    $fetchTipo = mysqli_fetch_array($queryTipo);

                                    $destinatarios = [
                                        ['name' => 'Asistente Operaciones', 'email' => 'asistente.operaciones@claudiachacon.com'],
                                        ['name' => 'Coordinacion Administrativa', 'email' => 'coordinacion.administrativa@claudiachacon.com'],
                                        ['name' => 'Claudia Chacon Mantenimiento', 'email' => 'claudiachaconmantenimiento@gmail.com'],
                                        ['name' => 'BeautySoft', 'email' => $salon['slnemail']] 
                                    ];

                                    $asunto = 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  MANTENIMIENTO';

                                    $valores = [
                                        'autnum'  =>  $max,
                                        'auttpo'  =>  $fetchTipo[0],
                                        'autstpo' =>  $subtipo,
                                        'autdate' =>  $_POST['fec'],
                                        'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                        'autvlr'  =>  $fetchCol['autvalor'],
                                        'autben'  =>  ucwords(strtolower($fetchCol['trcrazonsocial'])),
                                        'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                        'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                    ];

                                    if(enviarEmail(true, $asunto, $valores, $destinatarios)){
                                        echo json_encode(array('res' => 1, 'codigo' => $max));
                                    }
                                    else{
                                        echo json_encode(array('res' => 0));
                                    }

                                    /*$dest=array(
                                        array('name' => 'Direccion Operaciones','email' => 'direccion.operaciones@claudiachacon.com'),
                                        array('name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'),
                                        array('name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                        array('name' => 'BeautySoft','email' => $salon['slnemail'])
                                    );
                                    
                                    $email = array(
                                        'subject' => 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  MANTENIMIENTO',
                                        'template'=>array(
                                            'id'=>'190022',
                                            'variables'=>array(
                                              'autnum'  =>  $max,
                                              'auttpo'  =>  $fetchTipo[0],
                                              'autstpo' =>  $subtipo,
                                              'autdate' =>  $_POST['fec'],
                                              'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                              'autvlr'  =>  $fetchCol['autvalor'],
                                              'autben'  =>  ucwords(strtolower($fetchCol['trcrazonsocial'])),
                                              'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                              'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                            ),
                                        ),
                                        'from' => array(
                                          'name' => 'Claudia Chacon - Belleza y Estetica',
                                          'email' => 'info@claudiachacon.com',
                                        ),
                                        'to' => $dest,
                                    );
                                    if ($SPApiClient->smtpSendMail($email))
                                    {
                                        echo json_encode(array('res' => 1, 'codigo' => $max));
                                    } 
                                    else 
                                    {
                                        echo json_encode(array('res' => 0));
                                    }*/                                       
                                        
                                }
                            } 
                        }                                                


                      
                    }

                }
               ///tipo 3  p prod
                elseif ($_POST['tipo'] == '3') 
                {

                    $sqlmax = mysqli_query($conn, "SELECT MAX(autcodigo) FROM btyautorizaciones");
                    $fetch = mysqli_fetch_array($sqlmax);
                    $max = $fetch[0]+1;


                    $sln = mysqli_query($conn, "SELECT slnemail, slnnombre FROM btysalon WHERE slncodigo = '".$_POST['sln']."' AND slnestado = 1");

                    $salon = mysqli_fetch_array($sln);

                    $usuario = mysqli_query($conn, "SELECT b.trcrazonsocial FROM btyusuario a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE a.usucodigo = '".$_SESSION['codigoUsuario']."' ");



                        $usuarioFetch = mysqli_fetch_array($usuario);

                        $usuarioAprueba = $usuarioFetch[0];


                        $fetchCol = mysqli_fetch_array($sqlCol);

                        //echo " Este " . $fetchCol['trcrazonsocial'];

                                $queryTipo = mysqli_query($conn, "SELECT a.nombre FROM btyautorizaciones_tipo a WHERE a.auttipo_codigo = '".$_POST['tipo']."' ");

                                $querySubtipo = mysqli_query($conn, "SELECT b.subtipo_nombre FROM btyautorizaciones_subtipo b WHERE b.subtipo = '".$_POST['subtipo']."' ");

                                $fetchSubtipo = mysqli_fetch_array($querySubtipo);
                                $subtipo = $fetchSubtipo[0];



                                $fetchTipo = mysqli_fetch_array($queryTipo);                                




                        $sql = mysqli_query($conn, "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, subtipo, slncodigo, clbcodigo, usucodigo, observacion, autporcentaje, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite) VALUES('$max', '".$_POST['tipo']."', '".$_POST['subtipo']."', '".$_POST['sln']."', '".$_POST['col']."', '".$_SESSION['codigoUsuario']."', '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['por']."', '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO')  ")or die("Error: " . mysqli_error($conn));

                    if ($sql) 
                    {
                        

                                 $s = "SELECT c.trcrazonsocial,  CONCAT(a.autporcentaje,'%')AS autporcentaje FROM btyautorizaciones a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.clbcodigo =  '".$_POST['col']."' AND a.autcodigo = $max";
                                    //echo $s;

                                    $sqlCol = mysqli_query($conn, $s)or die(mysqli_error($conn));

                                    $fetchCol = mysqli_fetch_array($sqlCol);

                                $destinatarios = [
                                        ['name' => 'Asistente Gestion Humana','email' => 'asistente.gestionhumana@claudiachacon.com'],
                                        ['name' => 'Gestion Humana','email' => 'gestionhumana@claudiachacon.com'],
                                        ['name' => 'Coordinacion Administrativa','email' => 'coordinacion.administrativa@claudiachacon.com'],
                                        ['name' => 'Asistente Gerencia','email' => 'asistente.gerencia@claudiachacon.com'],
                                        ['name' => 'BeautySoft', 'email' => $salon['slnemail']] 
                                    ];

                                $asunto = 'Nueva Autorizacion #'.$max.' | Beauty Soft - PAGO PRODUCCION';

                                $valores = [
                                    'autnum'  =>  $max,
                                    'auttpo'  =>  utf8_encode($fetchTipo[0]),
                                    'autstpo' =>  utf8_encode($subtipo),
                                    'autdate' =>  $_POST['fec'],
                                    'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                    'autvlr'  =>  $_POST['por'].'%',
                                    'autben'  =>  ucwords(strtolower(utf8_encode($fetchCol['trcrazonsocial']))),
                                    'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                    'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                ];

                                if(enviarEmail(true, $asunto, $valores, $destinatarios)){
                                    echo json_encode(array('res' => 1, 'codigo' => $max));
                                }
                                else{
                                    echo json_encode(array('res' => 0));
                                }

                                /*$dest=array(
                                    array('name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                    array('name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'),
                                    array('name' => 'Asistente Gestion Humana','email' => 'asistente.gestionhumana@claudiachacon.com'),
                                    array('name' => 'BeautySoft','email' => $salon['slnemail'])
                                );
                                $email = array(
                                    'subject' => 'Nueva Autorizacion #'.$max.' | Beauty Soft - PAGO PRODUCCION',
                                    'template'=>array(
                                        'id'=>'190022',
                                        'variables'=>array(
                                          'autnum'  =>  $max,
                                          'auttpo'  =>  utf8_encode($fetchTipo[0]),
                                          'autstpo' =>  utf8_encode($subtipo),
                                          'autdate' =>  $_POST['fec'],
                                          'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                          'autvlr'  =>  $_POST['por'].'%',
                                          'autben'  =>  ucwords(strtolower(utf8_encode($fetchCol['trcrazonsocial']))),
                                          'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                          'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                        ),
                                    ),
                                    'from' => array(
                                      'name' => 'Claudia Chacon - Belleza y Estetica',
                                      'email' => 'info@claudiachacon.com',
                                    ),
                                    'to' => $dest,
                                );
                                if ($SPApiClient->smtpSendMail($email))
                                {
                                    echo json_encode(array('res' => 1, 'codigo' => $max));
                                } 
                                else 
                                {
                                    echo json_encode(array('res' => 0));
                                }*/                                 
                        
                    }
                }// pagos diarios
                elseif ($_POST['tipo'] == '2') 
                {
                    $sqlmax = mysqli_query($conn, "SELECT MAX(autcodigo) FROM btyautorizaciones");
                    $fetch = mysqli_fetch_array($sqlmax);
                    $max = $fetch[0]+1;


                    $sln = mysqli_query($conn, "SELECT slnemail, slnnombre FROM btysalon WHERE slncodigo = '".$_POST['sln']."' AND slnestado = 1");

                    $salon = mysqli_fetch_array($sln);

                    $usuario = mysqli_query($conn, "SELECT b.trcrazonsocial FROM btyusuario a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE a.usucodigo = '".$_SESSION['codigoUsuario']."' ");



                        $usuarioFetch = mysqli_fetch_array($usuario);

                        $usuarioAprueba = $usuarioFetch[0];

                       $s = "SELECT c.trcrazonsocial, CONCAT('$',FORMAT(a.autvalor,0))AS autvalor FROM btyautorizaciones a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.clbcodigo =  '".$_POST['col']."' AND a.autcodigo = $max";

                       
                        //echo $s;

                        $sqlCol = mysqli_query($conn, $s)or die(mysqli_error($conn));

                        $fetchCol = mysqli_fetch_array($sqlCol);

                        //echo " Este " . $fetchCol['trcrazonsocial'];

                                $queryTipo = mysqli_query($conn, "SELECT a.nombre FROM btyautorizaciones_tipo a WHERE a.auttipo_codigo = '".$_POST['tipo']."' ");

                                $querySubtipo = mysqli_query($conn, "SELECT b.subtipo_nombre FROM btyautorizaciones_subtipo b WHERE b.subtipo = '".$_POST['subtipo']."' ");

                                $fetchSubtipo = mysqli_fetch_array($querySubtipo);
                                $subtipo = $fetchSubtipo[0];



                                $fetchTipo = mysqli_fetch_array($queryTipo);                                




                        $sql = mysqli_query($conn, "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, subtipo, slncodigo, clbcodigo, usucodigo, observacion, autvalor, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite) VALUES('$max', '".$_POST['tipo']."', '".$_POST['subtipo']."', '".$_POST['sln']."', '".$_POST['col']."', '".$_SESSION['codigoUsuario']."', '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['val']."', '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO')  ")or die("Error: " . mysqli_error($conn));

                    if ($sql) 
                    {
                        //echo $subtipo;

                                $s = "SELECT c.trcrazonsocial, CONCAT('$',FORMAT(a.autvalor,0))AS autvalor FROM btyautorizaciones a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.clbcodigo =  '".$_POST['col']."' AND a.autcodigo = $max";
                                    //echo $s;

                                    $sqlCol = mysqli_query($conn, $s)or die(mysqli_error($conn));

                                    $fetchCol = mysqli_fetch_array($sqlCol);

                                $destinatarios = [
                                    ['name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'],
                                    ['name' => 'Asistente Gestion Humana', 'email' => 'asistente.gestionhumana@claudiachacon.com'],
                                    ['name' => 'Gestion Humana','email' => 'gestionhumana@claudiachacon.com'],
                                    ['name' => 'Coordinacion Administrativa', 'email' => 'coordinacion.administrativa@claudiachacon.com'],
                                    ['name' => 'Asistente Gerencia', 'email' => 'asistente.gerencia@claudiachacon.com'],
                                    ['name' => 'BeautySoft', 'email' => $salon['slnemail']] 
                                ];

                                $asunto = 'Nueva Autorizacion #'.$max.' | Beauty Soft - PAGO DIARIO';

                                $valores = [
                                    'autnum'  =>  $max,
                                    'auttpo'  =>  $fetchTipo[0],
                                    'autstpo' =>  $subtipo,
                                    'autdate' =>  $_POST['fec'],
                                    'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                    'autvlr'  =>  $fetchCol[1],
                                    'autben'  =>  ucwords(strtolower(utf8_encode($fetchCol[0]))),
                                    'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                    'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                ];

                                if(enviarEmail(true, $asunto, $valores, $destinatarios)){
                                    echo json_encode(array('res' => 1, 'codigo' => $max));
                                }
                                else{
                                    echo json_encode(array('res' => 0));
                                }
                                
                                /*$dest=array(
                                    array('name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                    array('name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'),
                                    array('name' => 'Gestion Humana','email' => 'gestionhumana@claudiachacon.com'),
                                    array('name' => 'BeautySoft','email' => $salon['slnemail'])
                                );
                                $email = array(
                                    'subject' => 'Nueva Autorizacion #'.$max.' | Beauty Soft - PAGO DIARIO',
                                    'template'=>array(
                                        'id'=>'190022',
                                        'variables'=>array(
                                          'autnum'  =>  $max,
                                          'auttpo'  =>  $fetchTipo[0],
                                          'autstpo' =>  $subtipo,
                                          'autdate' =>  $_POST['fec'],
                                          'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                          'autvlr'  =>  $fetchCol[1],
                                          'autben'  =>  ucwords(strtolower(utf8_encode($fetchCol[0]))),
                                          'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                          'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                        ),
                                    ),
                                    'from' => array(
                                      'name' => 'Claudia Chacon - Belleza y Estetica',
                                      'email' => 'info@claudiachacon.com',
                                    ),
                                    'to' => $dest,
                                );
                                if ($SPApiClient->smtpSendMail($email))
                                {
                                    echo json_encode(array('res' => 1, 'codigo' => $max));
                                } 
                                else 
                                {
                                    echo json_encode(array('res' => 0));
                                }*/                                
                        
                    }
                }//fin pagos diarios
                // bono especial
                elseif ($_POST['tipo'] == '4') 
                {

                    //print_r($_POST);
                    $sqlmax = mysqli_query($conn, "SELECT MAX(autcodigo) FROM btyautorizaciones");
                    $fetch = mysqli_fetch_array($sqlmax);
                    $max = $fetch[0]+1;


                    $sln = mysqli_query($conn, "SELECT slnemail, slnnombre FROM btysalon WHERE slncodigo = '".$_POST['sln']."'");

                    $salon = mysqli_fetch_array($sln);

                    $usuario = mysqli_query($conn, "SELECT b.trcrazonsocial FROM btyusuario a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE a.usucodigo = '".$_SESSION['codigoUsuario']."' ");



                        $usuarioFetch = mysqli_fetch_array($usuario);

                        $usuarioAprueba = $usuarioFetch[0];

                       $s = "SELECT a.beneficiario, CONCAT('$',FORMAT(a.autvalor,0))AS autvalor FROM btyautorizaciones a WHERE a.autcodigo = $max";
                       
                        //echo $s;

                        $sqlCol = mysqli_query($conn, $s)or die(mysqli_error($conn));

                        $fetchCol = mysqli_fetch_array($sqlCol);

                        //echo " Este " . $fetchCol['trcrazonsocial'];

                                $queryTipo = mysqli_query($conn, "SELECT a.nombre FROM btyautorizaciones_tipo a WHERE a.auttipo_codigo = '".$_POST['tipo']."' ");

                                $querySubtipo = mysqli_query($conn, "SELECT b.subtipo_nombre FROM btyautorizaciones_subtipo b WHERE b.subtipo = '".$_POST['subtipo']."' ");

                                $fetchSubtipo = mysqli_fetch_array($querySubtipo);
                                $subtipo = $fetchSubtipo[0];



                                $fetchTipo = mysqli_fetch_array($queryTipo);                                




                        $sql = mysqli_query($conn, "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, subtipo, slncodigo, beneficiario, usucodigo, observacion, autvalor, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite) VALUES('$max', '".$_POST['tipo']."', '".$_POST['subtipo']."', '".$_POST['sln']."', '".$_POST['cli']."', '".$_SESSION['codigoUsuario']."', '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['val']."', '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO')  ")or die("Error: " . mysqli_error($conn));

                    if ($sql) 
                    {
                       
                        //echo $subtipo;

                               $s = "SELECT a.beneficiario, CONCAT('$',FORMAT(a.autvalor,0))AS autvalor FROM btyautorizaciones a WHERE a.autcodigo = $max";
                                    //echo $s;

                                    $sqlCol = mysqli_query($conn, $s)or die(mysqli_error($conn));

                                    $fetchCol = mysqli_fetch_array($sqlCol);

                                $destinatarios = [
                                    ['name' => 'Direccion Administrativa', 'email' => 'direccion.administrativa@claudiachacon.com'],
                                    ['name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'] 
                                ];

                                if($_POST['sln']!=0){

                                    array_push($destinatarios, ['name' => 'BeautySoft','email' => $salon['slnemail']]);
                                }

                                /*******ADICION DE CORREOS DEPENDIENDO DE SUBTIPO PROVISIONAL POR ODONTOLOGÍA y OPTOMETRÏA********/
                                if($_POST['subtipo']=='52'){//ODONTOLOGIA
                                    
                                    array_push($destinatarios, ['name'=> 'DentClass', 'email' => 'dent.class@hotmail.com']);
                                     
                                }else if($_POST['subtipo']=='53'){//OPTOMETRIA
                                    
                                    array_push($destinatarios, ['name'=> 'OptiCaribe', 'email' => 'opticaribesa@yahoo.com']);
                                }

                                $asunto = 'Nueva Autorizacion #'.$max.' | Beauty Soft - BONO ESPECIAL';

                                $valores = [
                                    'autnum'  =>  $max,
                                    'auttpo'  =>  $fetchTipo[0],
                                    'autstpo' =>  $subtipo,
                                    'autdate' =>  $_POST['fec'],
                                    'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                    'autvlr'  =>  $fetchCol[1],
                                    'autben'  =>  ucwords(strtolower(utf8_encode($fetchCol[0]))),
                                    'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                    'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                ];

                                if(enviarEmail(true, $asunto, $valores, $destinatarios)){
                                    echo json_encode(array('res' => 1, 'codigo' => $max));
                                }
                                else{
                                    echo json_encode(array('res' => 0));
                                }
                                
                                
                                /*$dest=array(
                                    array('name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'),
                                    array('name' => 'Asistente Gerencia','email' => 'asistente.gerencia@claudiachacon.com'),
                                    array('name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                                      
                                );
                                if($_POST['sln']!=0){
                                    array_push($dest, array('name' => 'BeautySoft','email' => $salon['slnemail']));
                                }*/

                                /*******ADICION DE CORREOS DEPENDIENDO DE SUBTIPO PROVISIONAL POR ODONTOLOGÍA y OPTOMETRÏA********/
                                /*if($_POST['subtipo']=='52'){//ODONTOLOGIA
                                    array_push($dest, array('name' => 'DentClass','email' => 'dent.class@hotmail.com'),
                                                       array('name' => 'Gestion Humana','email' => 'gestionhumana@claudiachacon.com'),
                                                       array('name' => 'Asistente Gestion Humana','email' => 'asistente.gestionhumana@claudiachacon.com'));
                                     
                                }else if($_POST['subtipo']=='53'){//OPTOMETRIA
                                    array_push($dest, array('name' => 'OptiCaribe','email' => 'opticaribesa@yahoo.com'),
                                                       array('name' => 'Gestion Humana','email' => 'gestionhumana@claudiachacon.com'),
                                                       array('name' => 'Asistente Gestion Humana','email' => 'asistente.gestionhumana@claudiachacon.com'));
                                }*/
                                /************************************************************************************/     
                                /*$email = array(
                                    'subject' => 'Nueva Autorizacion #'.$max.' | Beauty Soft - BONO ESPECIAL',
                                    'template'=>array(
                                        'id'=>'190022',
                                        'variables'=>array(
                                          'autnum'  =>  $max,
                                          'auttpo'  =>  $fetchTipo[0],
                                          'autstpo' =>  $subtipo,
                                          'autdate' =>  $_POST['fec'],
                                          'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                          'autvlr'  =>  $fetchCol[1],
                                          'autben'  =>  ucwords(strtolower(utf8_encode($fetchCol[0]))),
                                          'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                          'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                        ),
                                    ),
                                    'from' => array(
                                      'name' => 'Claudia Chacon - Belleza y Estetica',
                                      'email' => 'info@claudiachacon.com',
                                    ),
                                    'to' => $dest,
                                );
                                if ($SPApiClient->smtpSendMail($email))
                                {
                                    echo json_encode(array('res' => 1, 'codigo' => $max));
                                } 
                                else 
                                {
                                    echo json_encode(array('res' => 0));
                                }*/
                        
                    }
                }//fin pagos diarios
                //pagos reembolosos
                elseif ($_POST['tipo'] == '1') 
                {

                    //print_r($_POST);
                    $sqlmax = mysqli_query($conn, "SELECT MAX(autcodigo) FROM btyautorizaciones");
                    $fetch = mysqli_fetch_array($sqlmax);
                    $max = $fetch[0]+1;


                    $sln = mysqli_query($conn, "SELECT slnemail, slnnombre FROM btysalon WHERE slncodigo = '".$_POST['sln']."' AND slnestado = 1");

                    $salon = mysqli_fetch_array($sln);

                    $usuario = mysqli_query($conn, "SELECT b.trcrazonsocial FROM btyusuario a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE a.usucodigo = '".$_SESSION['codigoUsuario']."' ");



                        $usuarioFetch = mysqli_fetch_array($usuario);

                        $usuarioAprueba = $usuarioFetch[0];

                                $queryTipo = mysqli_query($conn, "SELECT a.nombre FROM btyautorizaciones_tipo a WHERE a.auttipo_codigo = '".$_POST['tipo']."' ");

                                $querySubtipo = mysqli_query($conn, "SELECT b.subtipo_nombre FROM btyautorizaciones_subtipo b WHERE b.subtipo = '".$_POST['subtipo']."' ");

                                $fetchSubtipo = mysqli_fetch_array($querySubtipo);
                                $subtipo = $fetchSubtipo[0];



                                $fetchTipo = mysqli_fetch_array($queryTipo);                                




                        $sql = mysqli_query($conn, "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, subtipo, slncodigo, clbcodigo, usucodigo, observacion, autvalor, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite) VALUES('$max', '".$_POST['tipo']."', '".$_POST['subtipo']."', '".$_POST['sln']."', '".$_POST['col']."', '".$_SESSION['codigoUsuario']."', '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['val']."', '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO')  ")or die("Error: " . mysqli_error($conn));

                    if ($sql) 
                    {
                       

                              $s = "SELECT c.trcrazonsocial, CONCAT('$',FORMAT(a.autvalor,0))AS autvalor FROM btyautorizaciones a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.clbcodigo =  '".$_POST['col']."' AND a.autcodigo = $max";
                                    //echo $s;

                                $sqlCol = mysqli_query($conn, $s)or die(mysqli_error($conn));

                                $fetchCol = mysqli_fetch_array($sqlCol);

                                $destinatarios = [
                                    ['name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'],
                                    ['name' => 'Contador','email' => 'contador@claudiachacon.com'],
                                    ['name' => 'BeautySoft', 'email' => $salon['slnemail']] 
                                ];

                                $asunto = 'Nueva Autorizacion #'.$max;

                                $valores = [
                                    'autnum'  =>  $max,
                                    'auttpo'  =>  $fetchTipo[0],
                                    'autstpo' =>  $subtipo,
                                    'autdate' =>  $_POST['fec'],
                                    'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                    'autvlr'  =>  $fetchCol[1],
                                    'autben'  =>  ucwords(strtolower(utf8_encode($fetchCol[0]))),
                                    'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                    'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                ];

                                if(enviarEmail(true, $asunto, $valores, $destinatarios)){
                                    echo json_encode(array('res' => 1, 'codigo' => $max));
                                }
                                else{
                                    echo json_encode(array('res' => 0));
                                }

                                /*$dest=array(
                                    array('name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                    array('name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'),
                                    array('name' => 'Asistente Contable','email' => 'asistente.contable1@claudiachacon.com'),
                                    array('name' => 'BeautySoft','email' => $salon['slnemail'])
                                );
                                $email = array(
                                    'subject' => 'Nueva Autorizacion #'.$max,
                                    'template'=>array(
                                        'id'=>'190022',
                                        'variables'=>array(
                                          'autnum'  =>  $max,
                                          'auttpo'  =>  $fetchTipo[0],
                                          'autstpo' =>  $subtipo,
                                          'autdate' =>  $_POST['fec'],
                                          'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                          'autvlr'  =>  $fetchCol[1],
                                          'autben'  =>  ucwords(strtolower(utf8_encode($fetchCol[0]))),
                                          'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                          'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                        ),
                                    ),
                                    'from' => array(
                                      'name' => 'Claudia Chacon - Belleza y Estetica',
                                      'email' => 'info@claudiachacon.com',
                                    ),
                                    'to' => $dest,
                                );
                                if ($SPApiClient->smtpSendMail($email))
                                {
                                      echo json_encode(array('res' => 1, 'codigo' => $max));
                                } 
                                else 
                                {     
                                      echo json_encode(array('res' => 0));
                                }*/                         
                        
                    }
                }
                //TIPO 6 caja menor
                if ($_POST['tipo'] == '6' ) 
                {

                    $myArray = explode(',', $_POST['col']);

                    if ($_POST['docTer'] == '' || $_POST['docTer'] == null) 
                    {

                        if ($myArray[1] == 'M') 
                        {
                            $colman = $myArray[0];//persona mantenimiento

                            $sql = mysqli_query($conn, "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, subtipo, slncodigo, clbcodigo, prmcodigo, usucodigo, observacion, autvalor, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite) VALUES('$max', '".$_POST['tipo']."', '".$_POST['subtipo']."', '".$_POST['sln']."', NULL, '".$colman."',  '".$_SESSION['codigoUsuario']."', '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['val']."', '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO')  ")or die(mysqli_error($conn));

                                $sqlCol = mysqli_query($conn, "SELECT c.trcrazonsocial,  CONCAT('$',FORMAT(a.autvalor,0))AS autvalor FROM btyautorizaciones a JOIN btypersona_mantenimiento b ON a.prmcodigo=b.prmcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.prmcodigo =  '".$colman."' AND a.autcodigo = $max");



                                $queryTipo = mysqli_query($conn, "SELECT a.nombre FROM btyautorizaciones_tipo a WHERE a.auttipo_codigo = '".$_POST['tipo']."' ");

                                $querySubtipo = mysqli_query($conn, "SELECT b.subtipo_nombre FROM btyautorizaciones_subtipo b WHERE b.subtipo = '".$_POST['subtipo']."' ");

                                $fetchSubtipo = mysqli_fetch_array($querySubtipo);
                                $subtipo = $fetchSubtipo[0];



                                $fetchTipo = mysqli_fetch_array($queryTipo);
                                

                                $fetchCol = mysqli_fetch_array($sqlCol);

                                if ($sql) 
                                {                                   

                                    $destinatarios = [
                                        ['name' => 'Direccion Operaciones','email' => 'direccion.operaciones@claudiachacon.com'],
                                        ['name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'],
                                        ['name' => 'Contador','email' => 'contador@claudiachacon.com'],
                                        ['name' => 'Claudia Chacon Mantenimiento','email' => 'claudiachaconmantenimiento@gmail.com'],
                                        ['name' => 'BeautySoft', 'email' => $salon['slnemail']] 
                                    ];
    
                                    $asunto = 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  CAJA MENOR';
    
                                    $valores = [
                                        'autnum'  =>  $max,
                                        'auttpo'  =>  $fetchTipo[0],
                                        'autstpo' =>  $subtipo,
                                        'autdate' =>  $_POST['fec'],
                                        'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                        'autvlr'  =>  $fetchCol[1],
                                        'autben'  =>  ucwords(strtolower($fetchCol[0])),
                                        'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                        'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                    ];
    
                                    if(enviarEmail(true, $asunto, $valores, $destinatarios)){
                                        echo json_encode(array('res' => 1, 'codigo' => $max));
                                    }
                                    else{
                                        echo json_encode(array('res' => 0));
                                    }

                                    /*$dest=array(
                                        array('name' => 'Direccion Operaciones','email' => 'direccion.operaciones@claudiachacon.com'),
                                        array('name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'),
                                        array('name' => 'Asistente Contable','email' => 'asistente.contable1@claudiachacon.com'),
                                        array('name' => 'BeautySoft','email' => $salon['slnemail'])
                                    );
                                    $email = array(
                                        'subject' => 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  CAJA MENOR',
                                        'template'=>array(
                                            'id'=>'190022',
                                            'variables'=>array(
                                              'autnum'  =>  $max,
                                              'auttpo'  =>  $fetchTipo[0],
                                              'autstpo' =>  $subtipo,
                                              'autdate' =>  $_POST['fec'],
                                              'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                              'autvlr'  =>  $fetchCol[1],
                                              'autben'  =>  ucwords(strtolower($fetchCol[0])),
                                              'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                              'autapro' =>  utf8_decode($usuarioAprueba)
                                            ),
                                        ),
                                        'from' => array(
                                          'name' => 'Claudia Chacon - Belleza y Estetica',
                                          'email' => 'info@claudiachacon.com',
                                        ),
                                        'to' => $dest,
                                    );
                                    if ($SPApiClient->smtpSendMail($email)){
                                        echo json_encode(array('res' => 1, 'codigo' => $max));
                                    }else{
                                        echo json_encode(array('res' => 0));
                                    }*/
                                }
                        }
                        else
                        {

                            if ($myArray[1] == 'P') 
                        {
                            $proveedor = $myArray[0];//persona Proveedor

                            $sql = mysqli_query($conn, "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, subtipo, slncodigo, prvcodigo, usucodigo, observacion, autvalor, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite) VALUES('$max', '".$_POST['tipo']."', '".$_POST['subtipo']."', '".$_POST['sln']."', '".$proveedor."',  '".$_SESSION['codigoUsuario']."', '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['val']."', '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO')  ")or die(mysqli_error($conn));

                                $sqlCol = mysqli_query($conn, "SELECT c.trcrazonsocial,  CONCAT('$',FORMAT(a.autvalor,0))AS autvalor FROM btyautorizaciones a JOIN btyproveedor b ON a.prvcodigo=b.prvcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.prvcodigo = '".$proveedor."' AND a.autcodigo = $max");





                                $queryTipo = mysqli_query($conn, "SELECT a.nombre FROM btyautorizaciones_tipo a WHERE a.auttipo_codigo = '".$_POST['tipo']."' ");

                                $querySubtipo = mysqli_query($conn, "SELECT b.subtipo_nombre FROM btyautorizaciones_subtipo b WHERE b.subtipo = '".$_POST['subtipo']."' ");

                                $fetchSubtipo = mysqli_fetch_array($querySubtipo);
                                $subtipo = $fetchSubtipo[0];



                                $fetchTipo = mysqli_fetch_array($queryTipo);
                                

                                $fetchCol = mysqli_fetch_array($sqlCol);

                                if ($sql) 
                                {

                                    $destinatarios = [
                                        ['name' => 'Direccion Operaciones','email' => 'direccion.operaciones@claudiachacon.com'],
                                        ['name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'],
                                        ['name' => 'Contador','email' => 'contador@claudiachacon.com'],
                                        ['name' => 'Claudia Chacon Mantenimiento','email' => 'claudiachaconmantenimiento@gmail.com'],
                                        ['name' => 'BeautySoft', 'email' => $salon['slnemail']] 
                                    ];
    
                                    $asunto = 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  CAJA MENOR';
    
                                    $valores = [
                                        'autnum'  =>  $max,
                                        'auttpo'  =>  $fetchTipo[0],
                                        'autstpo' =>  $subtipo,
                                        'autdate' =>  $_POST['fec'],
                                        'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                        'autvlr'  =>  $fetchCol[1],
                                        'autben'  =>  ucwords(strtolower($fetchCol[0])),
                                        'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                        'autapro' =>  ucwords(strtolower(utf8_decode($usuarioAprueba)))
                                    ];
    
                                    if(enviarEmail(true, $asunto, $valores, $destinatarios)){
                                        echo json_encode(array('res' => 1, 'codigo' => $max));
                                    }
                                    else{
                                        echo json_encode(array('res' => 0));
                                    }

                                    /*$dest=array(
                                        array('name' => 'Direccion Operaciones','email' => 'direccion.operaciones@claudiachacon.com'),
                                        array('name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'),
                                        array('name' => 'Asistente Contable','email' => 'asistente.contable1@claudiachacon.com'),
                                        array('name' => 'BeautySoft','email' => $salon['slnemail'])
                                    );
                                    $email = array(
                                        'subject' => 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  CAJA MENOR',
                                        'template'=>array(
                                            'id'=>'190022',
                                            'variables'=>array(
                                              'autnum'  =>  $max,
                                              'auttpo'  =>  $fetchTipo[0],
                                              'autstpo' =>  $subtipo,
                                              'autdate' =>  $_POST['fec'],
                                              'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                              'autvlr'  =>  $fetchCol[1],
                                              'autben'  =>  ucwords(strtolower($fetchCol[0])),
                                              'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                              'autapro' =>  utf8_decode($usuarioAprueba)
                                            ),
                                        ),
                                        'from' => array(
                                          'name' => 'Claudia Chacon - Belleza y Estetica',
                                          'email' => 'info@claudiachacon.com',
                                        ),
                                        'to' => $dest,
                                    );
                                    if ($SPApiClient->smtpSendMail($email)){
                                        echo json_encode(array('res' => 1, 'codigo' => $max));
                                    }else{
                                        echo json_encode(array('res' => 0));
                                    }*/
                                }
                        }
                        ////////////
                            $colclb = $myArray[0];// persona de clb

                            $sql = mysqli_query($conn, "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, subtipo, slncodigo, clbcodigo, prmcodigo, usucodigo, observacion, autvalor, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite) VALUES('$max', '".$_POST['tipo']."', '".$_POST['subtipo']."', '".$_POST['sln']."', '".$colclb."', NULL,  '".$_SESSION['codigoUsuario']."', '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['val']."', '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO')  ")or die(mysqli_error($conn));


                                $sqlCol = mysqli_query($conn, "SELECT c.trcrazonsocial, CONCAT('$',FORMAT(a.autvalor,0))AS autvalor FROM btyautorizaciones a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.clbcodigo =  '".$colclb."' AND a.autcodigo = $max ");

                                $queryTipo = mysqli_query($conn, "SELECT a.nombre FROM btyautorizaciones_tipo a WHERE a.auttipo_codigo = '".$_POST['tipo']."' ");

                                $querySubtipo = mysqli_query($conn, "SELECT b.subtipo_nombre FROM btyautorizaciones_subtipo b WHERE b.subtipo = '".$_POST['subtipo']."' ");

                                $fetchSubtipo = mysqli_fetch_array($querySubtipo);
                                $subtipo = $fetchSubtipo[0];



                                $fetchTipo = mysqli_fetch_array($queryTipo);
                                

                                $fetchCol = mysqli_fetch_array($sqlCol);

                            if ($sql) 
                            {

                                $destinatarios = [
                                    ['name' => 'Direccion Operaciones','email' => 'direccion.operaciones@claudiachacon.com'],
                                    ['name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'],
                                    ['name' => 'Contador','email' => 'contador@claudiachacon.com'],
                                    ['name' => 'Claudia Chacon Mantenimiento','email' => 'claudiachaconmantenimiento@gmail.com'],
                                    ['name' => 'BeautySoft', 'email' => $salon['slnemail']] 
                                ];

                                $asunto = 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  CAJA MENOR';

                                $valores = [
                                    'autnum'  =>  $max,
                                    'auttpo'  =>  $fetchTipo[0],
                                    'autstpo' =>  $subtipo,
                                    'autdate' =>  $_POST['fec'],
                                    'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                    'autvlr'  =>  $fetchCol[1],
                                    'autben'  =>  ucwords(strtolower($fetchCol[0])),
                                    'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                    'autapro' =>  ucwords(utf8_decode($usuarioAprueba))
                                ];

                                if(enviarEmail(true, $asunto, $valores, $destinatarios)){
                                    echo json_encode(array('res' => 1, 'codigo' => $max));
                                }
                                else{
                                    echo json_encode(array('res' => 0));
                                }

                                /*$dest=array(
                                    array('name' => 'Direccion Operaciones','email' => 'direccion.operaciones@claudiachacon.com'),
                                    array('name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'),
                                    array('name' => 'Asistente Contable','email' => 'asistente.contable1@claudiachacon.com'),
                                    array('name' => 'BeautySoft','email' => $salon['slnemail'])
                                );
                                $email = array(
                                    'subject' => 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  CAJA MENOR',
                                    'template'=>array(
                                        'id'=>'190022',
                                        'variables'=>array(
                                          'autnum'  =>  $max,
                                          'auttpo'  =>  $fetchTipo[0],
                                          'autstpo' =>  $subtipo,
                                          'autdate' =>  $_POST['fec'],
                                          'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                          'autvlr'  =>  $fetchCol[1],
                                          'autben'  =>  ucwords(strtolower($fetchCol[0])),
                                          'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                          'autapro' =>  utf8_decode($usuarioAprueba)
                                        ),
                                    ),
                                    'from' => array(
                                      'name' => 'Claudia Chacon - Belleza y Estetica',
                                      'email' => 'info@claudiachacon.com',
                                    ),
                                    'to' => $dest,
                                );
                                if ($SPApiClient->smtpSendMail($email)){
                                    echo json_encode(array('res' => 1, 'codigo' => $max));
                                }else{
                                    echo json_encode(array('res' => 0));
                                }*/                         
                            }
                        }
                    }
                    else
                    {
                        

                        $docter = $_POST['docTer'];

                        $query = mysqli_query($conn, "SELECT prmcodigo FROM btypersona_mantenimiento WHERE trcdocumento  = '".$_POST['docTer']."' ");  

                        $s = mysqli_fetch_array($query);

                        $trcdocmante = $s[0]; 


                            $sqlmax = mysqli_query($conn, "SELECT MAX(autcodigo) FROM btyautorizaciones");
                            $fetch = mysqli_fetch_array($sqlmax);
                            $max = $fetch[0]+1;

                        //pregunto si esta en manteniiento
                        if (mysqli_num_rows($query) > 0) 
                        {
                            $d = "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, subtipo, slncodigo, prmcodigo, usucodigo, observacion, autvalor, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite) VALUES('$max', '".$_POST['tipo']."', '".$_POST['subtipo']."', '".$_POST['sln']."', '".$trcdocmante."',  '".$_SESSION['codigoUsuario']."', '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['val']."', '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO')  "; 

                            $sql = mysqli_query($conn, $d)or die("Error " . mysqli_error($conn));

                            if ($sql) 
                            {
                               

                                    $sln = mysqli_query($conn, "SELECT slnemail, slnnombre FROM btysalon WHERE slncodigo = '".$_POST['sln']."' AND slnestado = 1");

                                    $salon = mysqli_fetch_array($sln);

                                    $usuario = mysqli_query($conn, "SELECT b.trcrazonsocial FROM btyusuario a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE a.usucodigo = '".$_SESSION['codigoUsuario']."' ");



                                    $usuarioFetch = mysqli_fetch_array($usuario);

                                    $usuarioAprueba = $usuarioFetch[0];  


                                    $s = "SELECT c.trcrazonsocial,  CONCAT('$',FORMAT(a.autvalor,0))AS autvalor FROM btyautorizaciones a JOIN btypersona_mantenimiento b ON a.prmcodigo=b.prmcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.autcodigo = $max";


                                    //echo $s;

                                    $sqlCol = mysqli_query($conn, $s)or die(mysqli_error($conn));

                                    $fetchCol = mysqli_fetch_array($sqlCol);

                                     $querySubtipo = mysqli_query($conn, "SELECT b.subtipo_nombre FROM btyautorizaciones_subtipo b WHERE b.subtipo = '".$_POST['subtipo']."' ");

                                    $fetchSubtipo = mysqli_fetch_array($querySubtipo);
                                    $subtipo = $fetchSubtipo[0];



                                    $queryTipo = mysqli_query($conn, "SELECT a.nombre FROM btyautorizaciones_tipo a WHERE a.auttipo_codigo = '".$_POST['tipo']."' ");
                                        $fetchTipo = mysqli_fetch_array($queryTipo);

                                        $destinatarios = [
                                            ['name' => 'Direccion Operaciones','email' => 'direccion.operaciones@claudiachacon.com'],
                                            ['name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'],
                                            ['name' => 'Contador','email' => 'contador@claudiachacon.com'],
                                            ['name' => 'Claudia Chacon Mantenimiento','email' => 'claudiachaconmantenimiento@gmail.com'],
                                            ['name' => 'BeautySoft', 'email' => $salon['slnemail']] 
                                        ];
    
                                    $asunto = 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  CAJA MENOR';
    
                                    $valores = [
                                        'autnum'  =>  $max,
                                        'auttpo'  =>  $fetchTipo[0],
                                        'autstpo' =>  $subtipo,
                                        'autdate' =>  $_POST['fec'],
                                        'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                        'autvlr'  =>  $fetchCol['autvalor'],
                                        'autben'  =>  ucwords(strtolower($fetchCol['trcrazonsocial'])),
                                        'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                        'autapro' =>  utf8_decode($usuarioAprueba)
                                    ];
    
                                    if(enviarEmail(true, $asunto, $valores, $destinatarios)){
                                        echo json_encode(array('res' => 1, 'codigo' => $max));
                                    }
                                    else{
                                        echo json_encode(array('res' => 0));
                                    }

                                    /*$dest=array(
                                        array('name' => 'Direccion Operaciones','email' => 'direccion.operaciones@claudiachacon.com'),
                                        array('name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'),
                                        array('name' => 'Asistente Contable','email' => 'asistente.contable1@claudiachacon.com'),
                                        array('name' => 'BeautySoft','email' => $salon['slnemail'])
                                    );
                                    $email = array(
                                        'subject' => 'Nueva Autorizacion #'.$max.' - '.$salon['slnnombre'].' -  CAJA MENOR',
                                        'template'=>array(
                                            'id'=>'190022',
                                            'variables'=>array(
                                              'autnum'  =>  $max,
                                              'auttpo'  =>  $fetchTipo[0],
                                              'autstpo' =>  $subtipo,
                                              'autdate' =>  $_POST['fec'],
                                              'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                              'autvlr'  =>  $fetchCol['autvalor'],
                                              'autben'  =>  ucwords(strtolower($fetchCol['trcrazonsocial'])),
                                              'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                              'autapro' =>  utf8_decode($usuarioAprueba)
                                            ),
                                        ),
                                        'from' => array(
                                          'name' => 'Claudia Chacon - Belleza y Estetica',
                                          'email' => 'info@claudiachacon.com',
                                        ),
                                        'to' => $dest,
                                    );
                                    if ($SPApiClient->smtpSendMail($email)){
                                        echo json_encode(array('res' => 1, 'codigo' => $max));
                                    }else{
                                        echo json_encode(array('res' => 0));
                                    }*/       
                            }

                            
                        } 
                        else
                        {
                            $queryPro = mysqli_query($conn, "SELECT prvcodigo FROM btyproveedor WHERE trcdocumento  = '".$_POST['docTer']."' ");

                            $fetchPro = mysqli_fetch_array($queryPro);

                            $proveedor = $fetchPro['prvcodigo'];

                            if (mysqli_num_rows($queryPro) > 0) 
                            {

                                    $d = "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, subtipo, slncodigo, prvcodigo, usucodigo, observacion, autvalor, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite) VALUES('$max', '".$_POST['tipo']."', '".$_POST['subtipo']."', '".$_POST['sln']."', '".$proveedor."',  '".$_SESSION['codigoUsuario']."', '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['val']."', '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO')  ";

                                    //echo $d;

                                    $sql = mysqli_query($conn, $d)or die('Error ' .mysqli_error($conn));

                                    if ($sql) 
                                    {
                                        
                                            $sln = mysqli_query($conn, "SELECT slnemail, slnnombre FROM btysalon WHERE slncodigo = '".$_POST['sln']."' AND slnestado = 1");

                                            $salon = mysqli_fetch_array($sln);

                                            $usuario = mysqli_query($conn, "SELECT b.trcrazonsocial FROM btyusuario a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE a.usucodigo = '".$_SESSION['codigoUsuario']."' ");



                                            $usuarioFetch = mysqli_fetch_array($usuario);

                                            $usuarioAprueba = $usuarioFetch[0];  


                                            $s = "SELECT c.trcrazonsocial,  CONCAT('$',FORMAT(a.autvalor,0))AS autvalor FROM btyautorizaciones a JOIN btyproveedor b ON a.prvcodigo=b.prvcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento WHERE a.autcodigo = $max";


                                       //5 echo $s;

                                        $sqlCol = mysqli_query($conn, $s)or die(mysqli_error($conn));

                                        $fetchCol = mysqli_fetch_array($sqlCol);

                                         $querySubtipo = mysqli_query($conn, "SELECT b.subtipo_nombre FROM btyautorizaciones_subtipo b WHERE b.subtipo = '".$_POST['subtipo']."' ");

                                        $fetchSubtipo = mysqli_fetch_array($querySubtipo);
                                        $subtipo = $fetchSubtipo[0];



                                        $queryTipo = mysqli_query($conn, "SELECT a.nombre FROM btyautorizaciones_tipo a WHERE a.auttipo_codigo = '".$_POST['tipo']."' ");
                                        $fetchTipo = mysqli_fetch_array($queryTipo);
       
                                        $destinatarios = [
                                            ['name' => 'Direccion Operaciones','email' => 'direccion.operaciones@claudiachacon.com'],
                                            ['name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'],
                                            ['name' => 'Contador','email' => 'contador@claudiachacon.com'],
                                            ['name' => 'Claudia Chacon Mantenimiento','email' => 'claudiachaconmantenimiento@gmail.com'],
                                            ['name' => 'BeautySoft', 'email' => $salon['slnemail']] 
                                        ];
        
                                        $asunto = 'Nueva Autorizacion #'.$max.' | Beauty Soft - CAJA MENOR';
        
                                        $valores = [
                                            'autnum'  =>  $max,
                                            'auttpo'  =>  $fetchTipo[0],
                                            'autstpo' =>  $subtipo,
                                            'autdate' =>  $_POST['fec'],
                                            'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                            'autvlr'  =>  $fetchCol['autvalor'],
                                            'autben'  =>  ucwords(strtolower($fetchCol['trcrazonsocial'])),
                                            'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                            'autapro' =>  utf8_decode($usuarioAprueba)
                                        ];
        
                                        if(enviarEmail(true, $asunto, $valores, $destinatarios)){
                                            echo json_encode(array('res' => 1, 'codigo' => $max));
                                        }
                                        else{
                                            echo json_encode(array('res' => 0));
                                        }

                                        /*$dest=array(
                                            array('name' => 'Direccion Operaciones','email' => 'direccion.operaciones@claudiachacon.com'),
                                            array('name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'),
                                            array('name' => 'Asistente Contable','email' => 'asistente.contable1@claudiachacon.com'),
                                            array('name' => 'BeautySoft','email' => $salon['slnemail'])
                                        );
                                        $email = array(
                                            'subject' => 'Nueva Autorizacion #'.$max.' | Beauty Soft - CAJA MENOR',
                                            'template'=>array(
                                                'id'=>'190022',
                                                'variables'=>array(
                                                  'autnum'  =>  $max,
                                                  'auttpo'  =>  $fetchTipo[0],
                                                  'autstpo' =>  $subtipo,
                                                  'autdate' =>  $_POST['fec'],
                                                  'autsln'  =>  ucwords(strtolower(utf8_encode($salon['slnnombre']))),
                                                  'autvlr'  =>  $fetchCol['autvalor'],
                                                  'autben'  =>  ucwords(strtolower($fetchCol['trcrazonsocial'])),
                                                  'autcon'  =>  ucwords(strtolower(utf8_decode($_POST['obs']))),
                                                  'autapro' =>  utf8_decode($usuarioAprueba)
                                                ),
                                            ),
                                            'from' => array(
                                              'name' => 'Claudia Chacon - Belleza y Estetica',
                                              'email' => 'info@claudiachacon.com',
                                            ),
                                            'to' => $dest,
                                        );  
                                        if ($SPApiClient->smtpSendMail($email))
                                        {
                                            echo json_encode(array('res' => 1, 'codigo' => $max));
                                        } 
                                        else 
                                        {
                                            echo json_encode(array('res' => 0));
                                        }*/                         
                                    }
                            } 
                        }                                                


                      
                    }

                }
            break;

        case 'load':


                $s = "SELECT a.autcodigo, d.nombre, sln.slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) as colaborador, aut.trcrazonsocial as usuarioaprueba, prove.trcrazonsocial as proveedor, per.trcrazonsocial as persona_mante, a.slncodigo, a.prmcodigo, a.usucodigo, a.beneficiario, a.observacion, CONCAT('$',FORMAT(a.autvalor,0)) AS autvalor, a.autporcentaje, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo left JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo left JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento left JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo left JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento left JOIN  btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo left JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento WHERE a.autestado_tramite = 'RADICADO' AND a.autestado = 1 ORDER BY autcodigo DESC LIMIT 8";

                $sql = mysqli_query($conn, $s);

                $arrayLista = array();

                if (mysqli_num_rows($sql) > 0) 
                {
                    while ($row = mysqli_fetch_array($sql)) 
                    {
                        $arrayLista[] = array(
                            'cod' => $row['autcodigo'],
                            'nom' => $row['nombre'],
                            'col' => ucwords(strtolower(utf8_encode($row['colaborador']))),
                            'usu' => ucwords(strtolower(utf8_encode($row['usuarioaprueba']))),
                            'sln' => $row['slnnombre'],
                            'obs' => ucwords(strtolower(utf8_encode($row['observacion']))),
                            'val' => $row['autvalor'],
                            'por' => $row['autporcentaje'],
                            'fec' => $row['autfecha_autorizacion']
                        );
                    }

                    $arrayLista = utf8_converter($arrayLista);

                    echo json_encode(array('res' => 'full', 'json' => $arrayLista));
                    
                }
                else
                {
                    echo json_encode(array('res' => 'empty'));
                }
            break;


        case 'loadUlt':

                $s = "SELECT a.autcodigo, d.nombre, sln.slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) as colaborador, aut.trcrazonsocial as usuarioaprueba, prove.trcrazonsocial as proveedor, per.trcrazonsocial as persona_mante, a.slncodigo, a.prmcodigo, a.usucodigo, a.beneficiario, a.observacion, CONCAT('$',FORMAT(a.autvalor,0)) AS autvalor, a.autporcentaje, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo left JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo left JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento left JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo left JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento left JOIN  btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo left JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento WHERE a.autestado_tramite = 'RADICADO' AND a.autestado = 1 ORDER BY autcodigo DESC LIMIT 1";
                $sql = mysqli_query($conn, $s);

                $arrayLista = array();

                //echo $s;

                if (mysqli_num_rows($sql) > 0) 
                {
                    while ($row = mysqli_fetch_array($sql)) 
                    {
                        $arrayLista[] = array(
                            'cod' => $row['autcodigo'],
                            'nom' => $row['nombre'],
                            'sub' => $row['subtipo_nombre'],
                            'ali' => $row['alias'],
                            'col' => ucwords(strtolower(utf8_encode($row['colaborador']))),
                            'usu' => ucwords(strtolower(utf8_encode($row['usuarioaprueba']))),
                            'sln' => $row['slnnombre'],
                            'obs' => ucwords(strtolower(utf8_encode($row['observacion']))),
                            'val' => $row['autvalor'],
                            'por' => $row['autporcentaje'],
                            'fec' => $row['autfecha_autorizacion']
                        );
                    }

                    $arrayLista = utf8_converter($arrayLista);

                    echo json_encode(array('res' => 'full', 'json' => $arrayLista));
                    
                }
                else
                {
                    echo json_encode(array('res' => 'empty'));
                }
            break;

        case 'loadCod':


                 $r = "SELECT a.autcodigo, d.nombre, sln.slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) as colaborador, aut.trcrazonsocial as usuarioaprueba, prove.trcrazonsocial as proveedor, per.trcrazonsocial as persona_mante, a.slncodigo, a.prmcodigo, a.usucodigo, a.beneficiario, a.observacion, CONCAT('$',FORMAT(a.autvalor,0)) AS autvalor, a.autporcentaje, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo left JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo left JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento left JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo left JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento left JOIN  btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo left JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento WHERE a.autestado_tramite = 'RADICADO' AND a.autestado = 1 AND a.autcodigo = '".$_POST['codigo']."' ";
                 //echo $r;

            
                    $sql = mysqli_query($conn,$r);

                    $arrayLista = array();

                    while ($row = mysqli_fetch_array($sql)) 
                    {
                        $arrayLista[] = array(
                            'cod' => $row['autcodigo'],
                            'nom' => $row['nombre'],
                            'sub' => $row['subtipo_nombre'],
                            'ali' => $row['alias'],
                            'col' => ucwords(strtolower(utf8_encode($row['colaborador']))),
                            'usu' => ucwords(strtolower(utf8_encode($row['usuarioaprueba']))),
                            'sln' => $row['slnnombre'],
                            'obs' => ucwords(strtolower(utf8_encode($row['observacion']))),
                            'val' => $row['autvalor'],
                            'por' => $row['autporcentaje'],
                            'fec' => $row['autfecha_autorizacion']
                        );
                    }

                    $arrayLista = utf8_converter($arrayLista);

                    echo json_encode(array('res' => 'full', 'json' => $arrayLista));
            break;

        case 'search':

                $codigoBen = $_POST['codigoBen'];

                $sql = "SELECT a.autcodigo, d.nombre, sln.slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, aut.trcrazonsocial AS usuarioaprueba, prove.trcrazonsocial AS proveedor, per.trcrazonsocial AS persona_mante, a.slncodigo, a.prmcodigo, a.usucodigo, a.beneficiario, a.observacion, CONCAT('$', FORMAT(a.autvalor,0)) AS autvalor, a.autporcentaje, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento WHERE a.autestado_tramite = 'RADICADO' AND a.autestado = 1 AND (a.autcodigo LIKE '%".$codigoBen."%' OR colab.trcrazonsocial LIKE '%".utf8_decode($codigoBen)."%' OR per.trcrazonsocial LIKE '%".utf8_decode($codigoBen)."%' OR prove.trcrazonsocial LIKE '%".utf8_decode($codigoBen)."%' OR per.trcrazonsocial LIKE '%".utf8_decode($codigoBen)."%' OR a.beneficiario LIKE '%".utf8_decode($codigoBen)."%' )";

            
                $query_num_col = $sql;
 
                $result = $conn->query($query_num_col)or die(mysqli_error($conn));
                $num_total_registros = $result->num_rows;
             
                $rowsPerPage = 9;
                $pageNum = 1;

                if(isset($_POST['page'])) 
                {
                    $pageNum = $_POST['page'];
                }
      
                $offset = ($pageNum - 1) * $rowsPerPage;
                $total_paginas = ceil($num_total_registros / $rowsPerPage);
                $sql = $sql." ORDER BY a.autcodigo DESC limit $offset, $rowsPerPage";
                $result = $conn->query($sql);

  

                if ($result->num_rows > 0) 
                {
    
                        while ($row = $result->fetch_assoc()) 
                        {
                              


                               echo '<div class="panel-body note-link">
                                        <a href="#note'.$row['autcodigo'].'" data-toggle="tab" onclick="fnLoadAut('.$row['autcodigo'].')">
                                            <small class="pull-right text-muted">'.$row['autfecha_autorizacion'].'</small>
                                                <h5>#'.$row['autcodigo'].'</h5>
                                                <div class="small">'.utf8_encode($row['nombre']).' <b>['.utf8_encode($row['colaborador']).']</b></div>
                                        </a>
                                    </div>';        
                        }
                }
                else
                {
                    echo '<div class="panel-body note-link">
                            <a href="#" data-toggle="tab">
                                <small class="pull-right text-muted"></small>
                                    <h5></h5>
                                    <div class="small"><b>No hay registros coincidentes</b></div>
                            </a>
                        </div>';

                }
                    
                    include "../../colaborador/paginate.php";
            break;  

        case 'searchtipo':

                $tipo = $_POST['tipo'];

                 $sql = "SELECT a.autcodigo, d.nombre, sln.slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) as colaborador, aut.trcrazonsocial as autoriza, prove.trcrazonsocial as proveedor, per.trcrazonsocial as persona_mante, a.slncodigo, a.prmcodigo, a.usucodigo, a.beneficiario, a.observacion, a.autvalor, a.autporcentaje, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo left JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo left JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento left JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo left JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento left JOIN  btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo left JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento WHERE a.autestado_tramite = 'RADICADO' AND a.auttipo_codigo = '".$tipo."' ";

            
                $query_num_col = $sql;
 
                $result = $conn->query($query_num_col)or die(mysqli_error($conn));
                $num_total_registros = $result->num_rows;
             
                $rowsPerPage = 9;
                $pageNum = 1;

                if(isset($_POST['page'])) 
                {
                    $pageNum = $_POST['page'];
                }
      
                $offset = ($pageNum - 1) * $rowsPerPage;
                $total_paginas = ceil($num_total_registros / $rowsPerPage);
                $sql = $sql." ORDER BY a.autcodigo DESC limit $offset, $rowsPerPage";
                $result = $conn->query($sql);

  

                if ($result->num_rows > 0) 
                {
    
                        while ($row = $result->fetch_assoc()) 
                        {
                             


                               echo '<div class="panel-body note-link">
                                        <a href="#note'.$row['autcodigo'].'" data-toggle="tab" onclick="fnLoadAut('.$row['autcodigo'].')">
                                            <small class="pull-right text-muted">'.$row['autfecha_autorizacion'].'</small>
                                                <h5>#'.$row['autcodigo'].'</h5>
                                                <div class="small">'.utf8_encode($row['nombre']).' <b>['.utf8_encode($row['colaborador']).']</b></div>
                                        </a>
                                    </div>';        
                        }
                }
                else
                {
                    echo '<div class="panel-body note-link">
                            <a href="#" data-toggle="tab">
                                <small class="pull-right text-muted"></small>
                                    <h5></h5>
                                    <div class="small"><b>No hay registros coincidentes</b></div>
                            </a>
                        </div>';

                }
                    
                    include "../../colaborador/paginate.php";
            break;

        case 'anular':

                    $f = "SELECT a.autcodigo, a.auttipo_codigo, a.subtipo, d.nombre, sln.slncodigo, sln.slnemail, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.observacion, CONCAT('$',FORMAT(a.autvalor, 0))AS autvalor, CONCAT(a.autporcentaje, '%')AS autporcentaje, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN CONCAT(UCASE(LEFT('TERCEROS',1)), LCASE(SUBSTRING('TERCEROS',2))) ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END AS cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autcodigo = '".$_POST['idaut']."' ";

                    $sql = mysqli_query($conn, $f);
                    if ($sql) 
                    {

                            $row = mysqli_fetch_array($sql);

                            $update = mysqli_query($conn, "UPDATE btyautorizaciones SET autestado_tramite = 'ANULADA', usucodigo = '".$_SESSION['codigoUsuario']."' WHERE autcodigo = '".$_POST['idaut']."' ");

                            switch($row['auttipo_codigo']){

                                case 1:
                                    $destinatarios = [
                                        ['name' => 'Asistente Contable','email' => 'asistente.contable1@claudiachacon.com'],
                                        ['name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'],
                                        ['name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'],
                                        ['name' => 'BeautySoft', 'email' => $row['slnemail']],
                                        ['name' => 'Sistemas','email' => 'sistemas@claudiachacon.com']
                                    ];
                                    break;

                                case 2:
                                    $destinatarios = [
                                        ['name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'],
                                        ['name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'],
                                        ['name' => 'Gestion Humana','email' => 'gestionhumana@claudiachacon.com'],
                                        ['name' => 'BeautySoft', 'email' => $row['slnemail']],
                                    ];
                                    break;

                                case 3:
                                    $destinatarios = [
                                        ['name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'],
                                        ['name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'],
                                        ['name' => 'Asistente Gestion Humana','email' => 'asistente.gestionhumana@claudiachacon.com'],
                                        ['name' => 'BeautySoft', 'email' => $row['slnemail']],
                                    ];
                                    break;

                                case 4:
                                    $destinatarios = [
                                        ['name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'],
                                        ['name' => 'Asistente Gerencia','email' => 'asistente.gerencia@claudiachacon.com'],
                                        ['name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'],
                                    ];

                                    if($row['slncodigo']!=0){

                                        array_push($destinatarios, ['name' => 'BeautySoft', 'email' => $row['slnemail']]);
                                    }

                                    /*******ADICION DE CORREOS DEPENDIENDO DE SUBTIPO PROVISIONAL POR ODONTOLOGÍA y OPTOMETRÏA********/
                                    if($row['subtipo']=='52'){//ODONTOLOGIA
                                        
                                        array_push($destinatarios, ['name' => 'DentClass', 'email' => 'dent.class@hotmail.com']);
                                         
                                    }else if($row['subtipo']=='53'){//OPTOMETRIA
                                        
                                        array_push($destinatarios, ['name' => 'OptiCaribe', 'email' => 'opticaribesa@yahoo.com']);
                                    }

                                    array_push($destinatarios,
                                        ['name' => 'Gestion Humana', 'email' => 'gestionhumana@claudiachacon.com'],
                                        ['name' => 'Asistente Gestion Humana', 'email' => 'asistente.gestionhumana@claudiachacon.com']
                                    );
                                    break;
                                
                                case 5:
                                    $destinatarios = [
                                        ['name' => 'Direccion operaciones','email' => 'direccion.operaciones@claudiachacon.com'],
                                        ['name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'],
                                        ['name' => 'BeautySoft', 'email' => $row['slnemail']],
                                    ];
                                    break;

                                case 6:
                                    $destinatarios = [
                                        ['name' => 'Direccion operaciones','email' => 'direccion.operaciones@claudiachacon.com'],
                                        ['name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'],
                                        ['name' => 'Asistente Contable','email' => 'asistente.contable1@claudiachacon.com'],
                                        ['name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'],
                                        ['name' => 'BeautySoft', 'email' => $row['slnemail']],
                                    ];
                                    break;

                                default:

                                    $destinatarios = [
                                        ['name' => 'Direccion operaciones','email' => 'direccion.operaciones@claudiachacon.com'],
                                        ['name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'],
                                        ['name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'],
                                        ['name' => 'BeautySoft', 'email' => $row['slnemail']],
                                    ];
                                    break;
                            }

                            $asunto = 'ANULACION AUTORIZACIoN #'.$row[0].'ANULADA!!!';

                            $valores = [
                                'autnum'  =>  $row[0],
                                'auttpo'  =>  $row['nombre'],
                                'autstpo' =>  '-',
                                'autdate' =>  $row['autfecha_autorizacion'],
                                'autsln'  =>  ucwords(strtolower(utf8_encode($row['slnnombre']))),
                                'autvlr'  =>  $row['autvalor'],
                                'autben'  =>  ucwords(strtolower($row['colaborador'])),
                                'autcon'  =>  strtolower(utf8_decode($row['observacion'])),
                                'autapro' =>  ucwords(strtolower(utf8_decode($row['autoriza'])))
                            ];


                            if(enviarEmail(false, $asunto, $valores, $destinatarios)){
                                echo json_encode(array('res' => 1, 'codigo' => $max));
                            }
                            else{
                                echo json_encode(array('res' => 0));
                            }

                            /*if ($row['auttipo_codigo'] == 1) 
                            {
                                $dest=array(
                                    array('name' => 'Asistente Contable','email' => 'asistente.contable1@claudiachacon.com'),
                                    array('name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                    array('name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'),
                                    array('name' => 'BeautySoft','email' => $row['slnemail']),
				                    array('name' => 'Sistemas', 'email' => 'sistemas@claudiachacon.com')
                                );
                            }
                            elseif ($row['auttipo_codigo'] == 2) 
                            {
                                $dest=array(
                                    array('name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                    array('name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'),
                                    array('name' => 'Gestion Humana','email' => 'gestionhumana@claudiachacon.com'),
                                    array('name' => 'BeautySoft','email' => $row['slnemail'])
                                );
                            }
                            elseif ($row['auttipo_codigo'] == 3) 
                            {
                                $dest=array(
                                    array('name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                    array('name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'),
                                    array('name' => 'Asistente Gestion Humana','email' => 'asistente.gestionhumana@claudiachacon.com'),
                                    array('name' => 'BeautySoft','email' => $row['slnemail'])
                                );
                            }
                            elseif ($row['auttipo_codigo'] == 4)
                            {
                                $dest=array(
                                    array('name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'),
                                    array('name' => 'Asistente Gerencia','email' => 'asistente.gerencia@claudiachacon.com'),
                                    array('name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                );
                                if($row['slncodigo']!=0){
                                    array_push($dest, array('name' => 'BeautySoft','email' => $row['slnemail']));
                                }*/

                                /*******ADICION DE CORREOS DEPENDIENDO DE SUBTIPO PROVISIONAL POR ODONTOLOGÍA y OPTOMETRÏA********/
                                /*if($row['subtipo']=='52'){//ODONTOLOGIA
                                    array_push($dest, array('name' => 'DentClass','email' => 'dent.class@hotmail.com'),
                                                       array('name' => 'Gestion Humana','email' => 'gestionhumana@claudiachacon.com'),
                                                       array('name' => 'Asistente Gestion Humana','email' => 'asistente.gestionhumana@claudiachacon.com'));
                                     
                                }else if($row['subtipo']=='53'){//OPTOMETRIA
                                    array_push($dest, array('name' => 'OptiCaribe','email' => 'opticaribesa@yahoo.com'),
                                                       array('name' => 'Gestion Humana','email' => 'gestionhumana@claudiachacon.com'),
                                                       array('name' => 'Asistente Gestion Humana','email' => 'asistente.gestionhumana@claudiachacon.com'));
                                }
                            }
                            elseif ($row['auttipo_codigo'] == 5)
                            {
                                $dest=array(
                                    array('name' => 'Direccion operaciones','email' => 'direccion.operaciones@claudiachacon.com'),
                                    array('name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'),
                                    array('name' => 'BeautySoft','email' => $row['slnemail'])
                                );
                            }
                            elseif ($row['auttipo_codigo'] == 6)
                            {
                                $dest=array(
                                    array('name' => 'Direccion operaciones','email' => 'direccion.operaciones@claudiachacon.com'),
                                    array('name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'),
                                    array('name' => 'Asistente Contable','email' => 'asistente.contable1@claudiachacon.com'),
                                    array('name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'),
                                    array('name' => 'BeautySoft','email' => $row['slnemail'])
                                );
                            }
                            else
                            {
                                $dest=array(
                                    array('name' => 'Direccion operaciones','email' => 'direccion.operaciones@claudiachacon.com'),
                                    array('name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                    array('name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'),
                                    array('name' => 'BeautySoft','email' => $row['slnemail'])
                                );
                            }
                           

                            $email = array(
                                'subject' => 'ANULACION AUTORIZACIoN #'.$row[0].'ANULADA!!!',
                                'template'=>array(
                                    'id'=>'190082',
                                    'variables'=>array(
                                      'autnum'  =>  $row[0],
                                      'auttpo'  =>  $row['nombre'],
                                      'autstpo' =>  '-',
                                      'autdate' =>  $row['autfecha_autorizacion'],
                                      'autsln'  =>  ucwords(strtolower(utf8_encode($row['slnnombre']))),
                                      'autvlr'  =>  $row['autvalor'],
                                      'autben'  =>  ucwords(strtolower($row['colaborador'])),
                                      'autcon'  =>  strtolower(utf8_decode($row['observacion'])),
                                      'autapro' =>  ucwords(strtolower(utf8_decode($row['autoriza'])))
                                    ),
                                ),
                                'from' => array(
                                  'name' => 'Claudia Chacon - Belleza y Estetica',
                                  'email' => 'info@claudiachacon.com',
                                ),
                                'to' => $dest,
                            );
                            if ($SPApiClient->smtpSendMail($email))
                            {
                                echo json_encode(array('res' => 1, 'codigo' => $row[0]));
                            } 
                            else 
                            {
                                echo json_encode(array('res' => 0));
                            }*/     
                    }
            break;  
              

        case 'reporte':

           
            if($_POST['sln']!=0){$csalon=" AND a.slncodigo = '".$_POST['sln']."' ";}else{$csalon='';}
            if($_POST['tipo']!=0){$ctipo=" AND a.auttipo_codigo = '".$_POST['tipo']."' ";}else{$ctipo='';}
            
      
            if ( $_POST['col'] != '0')
            {
                if ($_POST['tipoU'] == 'M') 
                {

                    $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.slncodigo, a.observacion, COALESCE(CONCAT('$', FORMAT(a.autvalor,0)), CONCAT(a.autporcentaje,'%'))AS autvalor, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN 'TERCEROS'  ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END as cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN  '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' ".$csalon.$ctipo." AND a.prmcodigo = '".$_POST['col']."' ORDER BY autcodigo ";
                }
                elseif ($_POST['tipoU'] == 'P') 
                {
                    $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.slncodigo, a.observacion, COALESCE(CONCAT('$', FORMAT(a.autvalor,0)), CONCAT(a.autporcentaje,'%'))AS autvalor, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN 'TERCEROS'  ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END as cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN  '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' ".$csalon.$ctipo." AND a.prvcodigo = '".$_POST['col']."' ORDER BY autcodigo ";
                }
                elseif ($_POST['tipoU'] == '0' || $_POST['tipoU'] == '1') 
                {
                     $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.slncodigo, a.observacion, COALESCE(CONCAT('$', FORMAT(a.autvalor,0)), CONCAT(a.autporcentaje,'%'))AS autvalor, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN 'TERCEROS'  ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END as cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN  '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' ".$csalon.$ctipo." AND a.clbcodigo = '".$_POST['col']."' ORDER BY autcodigo ";
                }
            }
            /*elseif ($_POST['tipo'] != '0' AND $_POST['sln'] == '0' AND $_POST['col'] != '0')
            {
                if ($_POST['tipoU'] == 'M') 
                {
                    $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.slncodigo, a.observacion, COALESCE(CONCAT('$', FORMAT(a.autvalor,0)), CONCAT(a.autporcentaje,'%'))AS autvalor, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN 'TERCEROS'  ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END as cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN  '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.prmcodigo = '".$_POST['col']."'  AND a.auttipo_codigo = '".$_POST['tipo']."' ORDER BY autcodigo ";
                }
                elseif ($_POST['tipoU'] == 'P') 
                {
                     $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.slncodigo, a.observacion, COALESCE(CONCAT('$', FORMAT(a.autvalor,0)), CONCAT(a.autporcentaje,'%'))AS autvalor, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN 'TERCEROS'  ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END as cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN  '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.prvcodigo = '".$_POST['col']."'  AND a.auttipo_codigo = '".$_POST['tipo']."' ORDER BY autcodigo ";
                }
                elseif ($_POST['tipoU'] == '0' || $_POST['tipoU'] == '1' ) 
                {
                     $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.slncodigo, a.observacion, COALESCE(CONCAT('$', FORMAT(a.autvalor,0)), CONCAT(a.autporcentaje,'%'))AS autvalor, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN 'TERCEROS'  ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END as cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN  '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.clbcodigo = '".$_POST['col']."'  AND a.auttipo_codigo = '".$_POST['tipo']."' ORDER BY autcodigo ";
                }
            }*/
            else
            {
               
                $sql = "SELECT a.autcodigo, d.nombre, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.slncodigo, a.observacion, COALESCE(CONCAT('$', FORMAT(a.autvalor,0)), CONCAT(a.autporcentaje,'%'))AS autvalor, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN 'TERCEROS'  ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END as cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN  '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' ".$csalon.$ctipo." ORDER BY autcodigo ";

            }

           

            $array = array();

            $d = mysqli_query($conn, $sql);
            $conteo = mysqli_query($conn, $count);

            $f = mysqli_fetch_array($conteo);
            $de = $f[0];

            if (mysqli_num_rows($d) > 0) 
            {
                while($data = mysqli_fetch_assoc($d))
                {
                        $array['data'][] = $data;

                }

                    
            

                $array = utf8_converter($array);

            }
            else
            {
                 $array=array('data'=>'');
            }
                echo json_encode($array);

//echo $sql;

           
            break;

    case 'statistics':


            if ($_POST['tipo'] == '0') 
            {
                if ($_POST['sln'] == '0') 
                {

                    $sql = "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial AS beneficiario, g.trcrazonsocial AS usuarioaprueba, a.beneficiario AS cliente, CONCAT('$', FORMAT(a.autvalor,0)) AS autvalor, CONCAT(a.autporcentaje, '', '%') AS autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre, crg.crgnombre, (SELECT CONCAT('$', FORMAT(SUM(a.autvalor),0)) FROM btyautorizaciones a WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' ) AS total FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo LEFT JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo LEFT JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btyusuario f ON f.usucodigo=a.usucodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo LEFT JOIN btycargo crg ON crg.crgcodigo=d.crgcodigo WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' ORDER BY autcodigo";

                    $count = "SELECT SUM(a.autvalor) FROM btyautorizaciones a WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' ORDER BY autcodigo";
                }
                else
                {
                    $sql = "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial AS beneficiario, g.trcrazonsocial AS usuarioaprueba, a.beneficiario AS cliente, CONCAT('$', FORMAT(a.autvalor,0)) AS autvalor, CONCAT(a.autporcentaje, '', '%') AS autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre, crg.crgnombre, (SELECT CONCAT('$', FORMAT(SUM(a.autvalor),0)) FROM btyautorizaciones a WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.slncodigo IN ('".$_POST['sln']."') ORDER BY autcodigo ) AS total FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo LEFT JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo LEFT JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btyusuario f ON f.usucodigo=a.usucodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo LEFT JOIN btycargo crg ON crg.crgcodigo=d.crgcodigo WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.slncodigo IN ('".$_POST['sln']."') ORDER BY autcodigo";

                    $count = "SELECT SUM(a.autvalor) FROM btyautorizaciones a WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.slncodigo IN ('".$_POST['sln']."') ORDER BY autcodigo";
                }

            }
            else
            {
                if ($_POST['sln'] == '0') 
                {
                    $sql = "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial AS beneficiario, g.trcrazonsocial AS usuarioaprueba, a.beneficiario AS cliente, CONCAT('$', FORMAT(a.autvalor,0)) AS autvalor, CONCAT(a.autporcentaje, '', '%') AS autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre, crg.crgnombre, (SELECT CONCAT('$', FORMAT(SUM(a.autvalor),0)) FROM btyautorizaciones a WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.auttipo_codigo IN('".$_POST['tipo']."') ORDER BY autcodigo ) AS total FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo LEFT JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo LEFT JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btyusuario f ON f.usucodigo=a.usucodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo LEFT JOIN btycargo crg ON crg.crgcodigo=d.crgcodigo WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.auttipo_codigo IN('".$_POST['tipo']."') ORDER BY autcodigo";

                    $count = "SELECT SUM(a.autvalor) FROM btyautorizaciones a WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.auttipo_codigo IN('".$_POST['tipo']."') ORDER BY autcodigo";
                }
                else
                {
                   $sql = "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial AS beneficiario, g.trcrazonsocial AS usuarioaprueba, a.beneficiario AS cliente, CONCAT('$', FORMAT(a.autvalor,0)) AS autvalor, CONCAT(a.autporcentaje, '', '%') AS autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre, crg.crgnombre, (SELECT CONCAT('$', FORMAT(SUM(a.autvalor),0)) FROM btyautorizaciones a WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.slncodigo IN ('".$_POST['sln']."') AND a.auttipo_codigo IN('".$_POST['tipo']."') ORDER BY autcodigo ) AS total FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo LEFT JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo LEFT JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btyusuario f ON f.usucodigo=a.usucodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo LEFT JOIN btycargo crg ON crg.crgcodigo=d.crgcodigo WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.slncodigo IN ('".$_POST['sln']."') AND a.auttipo_codigo IN('".$_POST['tipo']."') ORDER BY autcodigo";

                    $count = "SELECT SUM(a.autvalor) FROM btyautorizaciones a WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.slncodigo IN ('".$_POST['sln']."') AND a.auttipo_codigo IN('".$_POST['tipo']."') ORDER BY autcodigo";

                }
            }

            //echo $sql;

            $array = array();

            $d = mysqli_query($conn, $sql);
            $conteo = mysqli_query($conn, $count);

            $f = mysqli_fetch_array($conteo);
            $de = $f[0];

            if (mysqli_num_rows($d) > 0) 
            {
                while($row = mysqli_fetch_array($d))
                {
                    $array[] = array(
                        'cod' => $row['autcodigo'],
                        'tip' => $row['nombre'],
                        'ali' => $row['alias'],
                        'ben' => $row['beneficiario'],
                        'usu' => $row['usuarioaprueba'],
                        'cli' => $row['cliente'],
                        'val' => $row['autvalor'],
                        'por' => $row['autporcentaje'],
                        'obs' => $row['observacion'],
                        'fec' => $row['autfecha_autorizacion'],
                        'sln' => $row['slnnombre'],
                        'tot' => $row['total'],
                    );
                }

                    
            

                $array = utf8_converter($array);

                echo json_encode(array('res' => 'full', 'json' => $array, 'conteo' => $de));
            }
            else
            {
                echo json_encode(array('res' => 'empty'));
            }

        break;

        case 'cargarSubtipo':

                $f = "SELECT sub.subtipo, sub.subtipo_nombre FROM btyautorizaciones_subtipo sub WHERE sub.auttipo_codigo = '".$_POST['tipo']."' AND sub.subestado = 1";
           
                $sql = mysqli_query($conn,$f);

                if (mysqli_num_rows($sql) > 0) 
                {
                    while ($row = mysqli_fetch_array($sql)) 
                    {  
                        echo '<option value="'.$row['subtipo'].'">'.utf8_encode($row['subtipo_nombre']).'</option>';
                    }
                }
                else
                {
                        echo '<option value="0">No hay subtipos asociados a este tipo</option>';
                }


                

        break;

        case 'newSubtipo':

                $d = mysqli_query($conn, "SELECT MAX(subtipo) FROM btyautorizaciones_subtipo");

                $count = mysqli_fetch_array($d);

                $maxid = $count[0]+1;

                $f = "INSERT INTO btyautorizaciones_subtipo (subtipo, auttipo_codigo, subtipo_nombre, subdescripcion, subestado) VALUES('".$maxid."', '".$_POST['tipo']."', '".utf8_decode($_POST['subtipo'])."', '".utf8_decode($_POST['desc'])."', 1)";

                $sql = mysqli_query($conn,$f);

                if ($sql) 
                {
                    echo 1;
                    
                }              

        break;


        case 'cargarNuevoSubtipo':

                $d = mysqli_query($conn, "SELECT MAX(subtipo) FROM btyautorizaciones_subtipo WHERE auttipo_codigo = '".$_POST['tipo']."' ");

                $count = mysqli_fetch_array($d);

                $maxid = $count[0];

                $sql = mysqli_query($conn, "SELECT subtipo, subtipo_nombre  FROM btyautorizaciones_subtipo WHERE auttipo_codigo = '".$_POST['tipo']."'  ");


                while($row = mysqli_fetch_array($sql))
                {
                    if ($row['subtipo'] == $maxid) 
                    {
                         echo '<option value="'.$row['subtipo'].'" selected>'.utf8_encode($row['subtipo_nombre']).'</option>';
                    }
                    else
                    {
                        echo '<option value="'.$row['subtipo'].'">'.utf8_encode($row['subtipo_nombre']).'</option>';                       
                    }
                }              

        break;


       case 'nuevaPersona':


            $cedula = $_POST['documento'];
            $primos =  array(3, 7, 13,17,19,23,29,37,41,43);
            $sum = 0;
            $j = strlen($cedula) - 1;

            for($i=0;$i<strlen($cedula);$i++)
            { 
                $sum = $sum+ ($primos[$j]*$cedula[$i]);
                $j = $j - 1;
            } 

            $dv = $sum % 11;

            if ($dv != 1 and $dv !=0)
                $dv = 11 - $dv;
                                         
            
            $checkTrc = mysqli_query($conn, "SELECT trcdocumento FROM btytercero WHERE trcdocumento = '".$_POST['documento']."' ");

            if (mysqli_num_rows($checkTrc) > 0) 
            {
                $checkPerMan = mysqli_query($conn, "SELECT trcdocumento FROM btypersona_mantenimiento WHERE trcdocumento = '".$_POST['documento']."' ");

                if (mysqli_num_rows($checkPerMan) > 0) 
                {
                    echo 3;
                } 
                else
                {
                    $sqlmax = mysqli_query($conn, "SELECT MAX(prmcodigo) FROM btypersona_mantenimiento");

                    $maxPer = mysqli_fetch_array($sqlmax);

                    $maxid = $maxPer[0] + 1;

                    $r = "INSERT INTO btypersona_mantenimiento (prmcodigo, tdicodigo, trcdocumento, prmfecha_nacimiento, prm_email, prmfecha_registro, prmhora_registro, usucodigo) VALUES('".$maxid."', '".$_POST['tdicodigo']."', '".$_POST['documento']."', '".$_POST['fecha']."', '".$_POST['email']."', CURDATE(), CURTIME(), '".$_SESSION['codigoUsuario']."' )";

                    $insert_perman = mysqli_query($conn, $r)or die(mysqli_error($conn));

                    if ($insert_perman) 
                    {
                         $sql = mysqli_query($conn, "SELECT * FROM btytercero a WHERE a.trcdocumento = '".$_POST['documento']."' ");

                        $array = array();

                        $row = mysqli_fetch_array($sql);

                        $array[] = array(
                            'trcdocumento'      => $row['trcdocumento'],
                            'trcnombres'        => $row['trcnombres'],
                            'trcapellidos'      => $row['trcapellidos'],
                        );

                        $array = utf8_converter($array);

                        echo json_encode(array('res' => 'fullname', 'json' => $array));
                    }
                }  
            }
            else
            {
                $sqlMax = mysqli_query($conn, "SELECT MAX(prmcodigo) FROM btypersona_mantenimiento");

                $maxPer = mysqli_fetch_array($sqlMax);

                $maxid = $maxPer[0] + 1;

                $t = "INSERT INTO btytercero (tdicodigo, trcdocumento, trcdigitoverificacion, trcnombres, trcapellidos, trcrazonsocial, trcdireccion, trctelefonofijo, trctelefonomovil, trcestado) VALUES('".$_POST['tdicodigo']."', '".$_POST['documento']."', '".$dv."', '".utf8_encode($_POST['nombres'])."', '".utf8_encode($_POST['apellidos'])."', '".utf8_converter($_POST['nombres']. ' ' . $_POST['apellidos']) . "', '".$_POST['direccion']."', '".$_POST['fijo']."', '".$_POST['movil']."', 1)";

                //echo $t;

                $insert_trc = mysqli_query($conn, $t)or die(mysqli_error($conn));

                if ($insert_trc) 
                {
                    $insert_perman = mysqli_query($conn, "INSERT INTO btypersona_mantenimiento (prmcodigo, tdicodigo, trcdocumento, prmfecha_nacimiento, prm_email, prmfecha_registro, prmhora_registro, usucodigo) VALUES('".$maxid."', '".$_POST['tdicodigo']."', '".$_POST['documento']."', '".$_POST['fecha']."', '".$_POST['email']."', CURDATE(), CURTIME(), '".$_SESSION['codigoUsuario']."' )")or die(mysqli_error($conn)); 

                    if ($insert_perman) 
                    {
                        $sql = mysqli_query($conn, "SELECT * FROM btytercero a WHERE a.trcdocumento = '".$_POST['documento']."' ");

                        $array = array();

                        $row = mysqli_fetch_array($sql);

                        $array[] = array(
                            'trcdocumento'      => $row['trcdocumento'],
                            'trcnombres'        => $row['trcnombres'],
                            'trcapellidos'      => $row['trcapellidos'],
                        );

                        $array = utf8_converter($array);

                        echo json_encode(array('res' => 'fullname', 'json' => $array));
                    }                   
                }

            }

            break;


        case 'validarDoc':
            
                $valDoc = mysqli_query($conn, "SELECT trcdocumento FROM btytercero WHERE trcdocumento =  '".$_POST['documento']."' ");

                if (mysqli_num_rows($valDoc) > 0) 
                {
                    $checkPerMan = mysqli_query($conn, "SELECT trcdocumento FROM btypersona_mantenimiento WHERE trcdocumento = '".$_POST['documento']."' ");

                    if (mysqli_num_rows($checkPerMan) > 0) 
                    {

                        $sql = mysqli_query($conn, "SELECT * FROM btytercero a JOIN btytipodocumento  b ON a.tdicodigo=b.tdicodigo WHERE a.trcdocumento = '".$_POST['documento']."' ");

                        $array = array();

                        $row = mysqli_fetch_array($sql);

                        $array[] = array(
                            'trcdocumento'      => $row['trcdocumento'],
                            'trcnombres'        => $row['trcnombres'],
                            'trcapellidos'      => $row['trcapellidos'],
                        );

                        $array = utf8_converter($array);

                        echo json_encode(array('res' => 'fullname', 'json' => $array));
                    }
                    else
                    {
                        $sql = mysqli_query($conn, "SELECT * FROM btytercero a JOIN btytipodocumento  b ON a.tdicodigo=b.tdicodigo WHERE a.trcdocumento = '".$_POST['documento']."' ");

                        $array = array();

                        $row = mysqli_fetch_array($sql);

                        $array[] = array(
                            'tdicodigo'         => $row['tdicodigo'],
                            'trcdocumento'      => $row['trcdocumento'],
                            'trcnombres'        => $row['trcnombres'],
                            'trcapellidos'      => $row['trcapellidos'],
                            'trcdireccion'      => $row['trcdireccion'],
                            'trctelefonofijo'   => $row['trctelefonofijo'],
                            'trctelefonomovil'  => $row['trctelefonomovil'],
                            'fecha_nacimiento'  => $row['prmfecha_nacimiento'],
                            'tdinombre'         => $row['tdinombre']
                        );

                        $array = utf8_converter($array);

                        echo json_encode(array('res' => 'full', 'json' => $array));
                    }
                }
                else
                {
                    echo json_encode(array("res" => "No tiene ningun registro", "desc" => 0));
                }

            break;

        case 'addProveedor':


                    $cedula = $_POST['documentoPro'];
                    $primos =  array(3, 7, 13,17,19,23,29,37,41,43);
                    $sum = 0;
                    $j = strlen($cedula) - 1;

                    for($i=0;$i<strlen($cedula);$i++)
                    { 
                        $sum = $sum+ ($primos[$j]*$cedula[$i]);
                        $j = $j - 1;
                    } 

                    $dv = $sum % 11;

                    if ($dv != 1 and $dv !=0)
                        $dv = 11 - $dv;


                        $MaxPro = mysqli_query($conn, "SELECT MAX(prvcodigo) FROM btyproveedor");

                        $fetchMax = mysqli_fetch_array($MaxPro);

                        $maxProv = $fetchMax[0] + 1;

                        
                        $d = "SELECT trcdocumento FROM btytercero WHERE trcdocumento = '".$_POST['documentoPro']."' ";

                            $sqlTer = mysqli_query($conn, $d);

                        if (mysqli_num_rows($sqlTer) > 0) 
                        {

                            $sqlPro = mysqli_query($conn, "SELECT trcdocumento FROM btyproveedor WHERE trcdocumento = '".$_POST['documentoPro']."' ");

                            if (mysqli_num_rows($sqlPro) > 0) 
                            {
                                echo "Ya esta registrado en tercero y proveedores";                        
                            }
                            else
                            {
                                

                                $queryProveReg = mysqli_query($conn, "INSERT INTO btyproveedor (prvcodigo, trcdocumento, tdicodigo, prvemail, prvfechacreacion) VALUES($maxProv, '".$_POST['documentoPro']."', '".$_POST['tdicodigoPro']."', '".$_POST['emailPro']."', CURDATE()) ");

                                if ($queryProveReg) 
                                {
                                        
                                            $queryTercero = mysqli_query($conn, "SELECT a.trcdocumento, a.trcrazonsocial FROM btytercero a WHERE a.trcdocumento = '".$_POST['documentoPro']."' ");

                                            $array = array();

                                            $fetch = mysqli_fetch_array($queryTercero);

                                            $array[] = array('doc' => $fetch['trcdocumento'], 'nombre' => $fetch['trcrazonsocial']);

                                            $array = utf8_converter($array);

                                            echo json_encode(array('res' => 'full', 'json' => $array));


                                            // Registro ok en proveedores
                                                                          
                                }
                                
                            }
                        }
                        else
                        {
                            //echo "NO EXISTE en tercero. falta llevarlo a tercero y a proveedor";

                             $t = "INSERT INTO btytercero (tdicodigo, trcdocumento, trcdigitoverificacion, trcnombres, trcapellidos, trcrazonsocial, trcdireccion, trctelefonofijo, trctelefonomovil, trcestado) VALUES('".$_POST['tdicodigoPro']."', '".$_POST['documentoPro']."', '".$dv."', '".utf8_encode($_POST['nombresPro'])."', '".utf8_encode($_POST['apellidosPro'])."', '".utf8_converter($_POST['nombresPro']. ' ' . $_POST['apellidosPro']) . "', '".$_POST['direccionPro']."', '".$_POST['fijoPro']."', '".$_POST['movilPro']."', 1)";

                             $sql = mysqli_query($conn, $t);

                                if ($sql) 
                                {
                                    $queryProveReg = mysqli_query($conn, "INSERT INTO btyproveedor (prvcodigo, trcdocumento, tdicodigo, prvemail, prvfechacreacion) VALUES($maxProv, '".$_POST['documentoPro']."', '".$_POST['tdicodigoPro']."', '".$_POST['emailPro']."', CURDATE()) ");

                                    if ($queryProveReg) 
                                    {
                                            
                                        $queryTercero = mysqli_query($conn, "SELECT a.trcdocumento, a.trcrazonsocial FROM btytercero a WHERE a.trcdocumento = '".$_POST['documentoPro']."' ");

                                        $array = array();

                                        $fetch = mysqli_fetch_array($queryTercero);

                                        $array[] = array('doc' => $fetch['trcdocumento'], 'nombre' => $fetch['trcrazonsocial']);

                                        $array = utf8_converter($array);

                                        echo json_encode(array('res' => 'full', 'json' => $array));

                                                // Registro ok en proveedores                                                                              
                                    }
                                }
                        }           


            break;


            case 'reenviar':
                    //$SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());
                    $sql = "SELECT a.autcodigo, d.nombre, a.auttipo_codigo, CONCAT(UCASE(LEFT(sln.slnnombre,1)), LCASE(SUBSTRING(sln.slnnombre,2))) AS slnnombre, sln.slnemail, c.subtipo_nombre, COALESCE(colab.trcrazonsocial, per.trcrazonsocial, prove.trcrazonsocial, per.trcrazonsocial, a.beneficiario) AS colaborador, CONCAT(UCASE(LEFT(aut.trcrazonsocial,1)), LCASE(SUBSTRING(aut.trcrazonsocial,2))) AS autoriza, a.slncodigo, a.observacion, COALESCE(CONCAT('$', FORMAT(a.autvalor,0)), CONCAT(a.autporcentaje,'%')) AS autvalor, a.autfecha_autorizacion, a.autfecha_registro, a.authora_registro, a.autestado_tramite, CASE WHEN a.auttipo_codigo = '5' THEN CONCAT(UCASE(LEFT('MANTENIMIENTO',1)), LCASE(SUBSTRING('MANTENIMIENTO',2))) WHEN a.auttipo_codigo = '4' THEN 'TERCEROS' ELSE CONCAT(UCASE(LEFT(crg.crgnombre,1)), LCASE(SUBSTRING(crg.crgnombre,2))) END AS cargo FROM btyautorizaciones a JOIN btyautorizaciones_subtipo c ON a.subtipo =c.subtipo JOIN btyautorizaciones_tipo d ON d.auttipo_codigo=c.auttipo_codigo JOIN btysalon sln ON sln.slncodigo=a.slncodigo LEFT JOIN btycolaborador clb ON clb.clbcodigo=a.clbcodigo LEFT JOIN btytercero colab ON colab.tdicodigo=clb.tdicodigo AND colab.trcdocumento=clb.trcdocumento JOIN btyusuario usu ON usu.usucodigo=a.usucodigo JOIN btytercero aut ON aut.tdicodigo=usu.tdicodigo AND aut.trcdocumento=usu.trcdocumento LEFT JOIN btyproveedor pro ON pro.prvcodigo=a.prvcodigo LEFT JOIN btytercero prove ON prove.tdicodigo=pro.tdicodigo AND prove.trcdocumento=pro.trcdocumento LEFT JOIN btypersona_mantenimiento pman ON pman.prmcodigo=a.prmcodigo LEFT JOIN btytercero per ON per.tdicodigo=pman.tdicodigo AND per.trcdocumento=pman.trcdocumento LEFT JOIN btycargo crg ON crg.crgcodigo=clb.crgcodigo WHERE a.autestado_tramite = 'RADICADO' AND a.autcodigo = '".$_POST['idaut']."' ORDER BY autcodigo ";

                    $queryReenvio = mysqli_query($conn, $sql);

                    $fetchReenvio = mysqli_fetch_array($queryReenvio);


                    switch($fetchReenvio['auttipo_codigo']){

                        case '1':
                            $destinatarios = [
                                ['name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'],
                                ['name' => 'Contador','email' => 'contador@claudiachacon.com'],
                                ['name' => 'BeautySoft', 'email' => $fetchReenvio['slnemail']],
                            ];
                            $asunto='REEMBOLSOS Y PAGOS MISCELANEOS';
                            break;

                        case '2':
                            $destinatarios = [
                                ['name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'],
                                ['name' => 'Asistente Gestion Humana', 'email' => 'asistente.gestionhumana@claudiachacon.com'],
                                ['name' => 'Gestion Humana','email' => 'gestionhumana@claudiachacon.com'],
                                ['name' => 'Coordinacion Administrativa', 'email' => 'coordinacion.administrativa@claudiachacon.com'],
                                ['name' => 'Asistente Gerencia', 'email' => 'asistente.gerencia@claudiachacon.com'],
                                ['name' => 'BeautySoft', 'email' => $fetchReenvio['slnemail']] 
                            ];
                            $asunto='PAGO DIARIO';
                            break;

                        case '3':
                            $destinatarios = [
                                ['name' => 'Asistente Gestion Humana','email' => 'asistente.gestionhumana@claudiachacon.com'],
                                ['name' => 'Gestion Humana','email' => 'gestionhumana@claudiachacon.com'],
                                ['name' => 'Coordinacion Administrativa','email' => 'coordinacion.administrativa@claudiachacon.com'],
                                ['name' => 'Asistente Gerencia','email' => 'asistente.gerencia@claudiachacon.com'],
                                ['name' => 'BeautySoft', 'email' => $fetchReenvio['slnemail']] 
                            ];
                            $asunto='PAGO PRODUCCION';
                            break;

                        case '4':
                            $destinatarios = [
                                ['name' => 'Direccion Administrativa', 'email' => 'direccion.administrativa@claudiachacon.com'],
                                ['name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'] 
                            ];
                            
                            if($fetchReenvio['slnemail']!=0){

                                array_push($destinatarios, ['name' => 'BeautySoft','email' => $fetchReenvio['slnemail']]);
                            }
                            
                            $asunto='BONO ESPECIAL';
                            break;

                        case '5':
                            $destinatarios = [
                                ['name' => 'Asistente Operaciones', 'email' => 'asistente.operaciones@claudiachacon.com'],
                                ['name' => 'Coordinacion Administrativa', 'email' => 'coordinacion.administrativa@claudiachacon.com'],
                                ['name' => 'Claudia Chacon Mantenimiento', 'email' => 'claudiachaconmantenimiento@gmail.com'],
                                ['name' => 'BeautySoft', 'email' => $fetchReenvio['slnemail']] 
                            ];
                            $asunto='MANTENIMIENTO';
                            break;

                        case '6':
                            $destinatarios = [
                                ['name' => 'Direccion Operaciones','email' => 'direccion.operaciones@claudiachacon.com'],
                                ['name' => 'Asistente Operaciones','email' => 'asistente.operaciones@claudiachacon.com'],
                                ['name' => 'Contador','email' => 'contador@claudiachacon.com'],
                                ['name' => 'Claudia Chacon Mantenimiento','email' => 'claudiachaconmantenimiento@gmail.com'],
                                ['name' => 'BeautySoft', 'email' => $fetchReenvio['slnemail']] 
                            ];
                            $asunto='CAJA MENOR';
                            break;
                    }

                    $valores = [
                        'autnum'  =>  $fetchReenvio['autcodigo'],
                        'auttpo'  =>  utf8_encode($fetchReenvio['nombre']),
                        'autstpo' =>  utf8_encode($fetchReenvio['subtipo_nombre']),
                        'autdate' =>  $fetchReenvio['autfecha_autorizacion'],
                        'autsln'  =>  utf8_encode($fetchReenvio['slnnombre']),
                        'autvlr'  =>  $fetchReenvio['autvalor'],
                        'autben'  =>  utf8_encode($fetchReenvio['colaborador']),
                        'autcon'  =>  utf8_encode($fetchReenvio['observacion']),
                        'autapro' =>  utf8_encode($fetchReenvio['autoriza'])
                    ];

                    if(enviarEmail(true, $asunto, $valores, $destinatarios)){
                        echo json_encode(array('res' => 1, 'codigo' => $row[0]));
                    }
                    else{
                        echo json_encode(array('res' => 0));
                    }

                    /*if ($fetchReenvio['auttipo_codigo'] == '1') 
                    {
                        $dest=array(
                            array('name' => 'Asistente Contable','email' => 'asistente.contable1@claudiachacon.com'),
                            array('name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                            array('name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'),
                            array('name' => 'BeautySoft','email' => $fetchReenvio['slnemail'])
                        );
                        $tpaut='REEMBOLSOS Y PAGOS MISCELANEOS';
                    }
                    elseif ($fetchReenvio['auttipo_codigo'] == '2') 
                    {
                        $dest=array(
                            array('name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                            array('name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'),
                            array('name' => 'Gestion Humana','email' => 'gestionhumana@claudiachacon.com'),
                            array('name' => 'BeautySoft','email' => $fetchReenvio['slnemail'])
                        );
                        $tpaut='PAGO DIARIO';
                    }
                    elseif ($fetchReenvio['auttipo_codigo'] == '3') 
                    {
                        $dest=array(
                            array('name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                            array('name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'),
                            array('name' => 'Asistente Gestion Humana','email' => 'asistente.gestionhumana@claudiachacon.com'),
                            array('name' => 'BeautySoft','email' => $fetchReenvio['slnemail'])
                        );
                        $tpaut='PAGO PRODUCCION';
                    }
                    elseif ($fetchReenvio['auttipo_codigo'] == '4') 
                    {
                        $mail->addAddress('app@claudiachacon.com', ''); 
                        $mail->addAddress('asistente.operaciones@claudiachacon.com', 'Richard Mendoza');
                        $mail->addAddress('direccion.administrativa@claudiachacon.com', 'Rosa Macias');
                        $mail->addAddress($fetchReenvio['slnemail'], 'Beauty Soft');
                        $dest=array(
                            array('name' => 'Direccion operaciones','email' => 'direccion.operaciones@claudiachacon.com'),
                            array('name' => 'Asistente Gerencia','email' => 'asistente.gerencia@claudiachacon.com'),
                            array('name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'),
                            array('name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'),
                            array('name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                            array('name' => 'BeautySoft','email' => $fetchReenvio['slnemail'])
                        );
                        $tpaut='BONO ESPECIAL';
                    }
                    elseif ($fetchReenvio['auttipo_codigo'] == '5') 
                    {
                        $dest=array(
                            array('name' => 'Direccion operaciones','email' => 'direccion.operaciones@claudiachacon.com'),
                            array('name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'),
                            array('name' => 'BeautySoft','email' => $fetchReenvio['slnemail'])
                        );
                        $tpaut='MANTENIMIENTO';
                    }
                    elseif ($fetchReenvio['auttipo_codigo'] == '6') 
                    {
                        $dest=array(
                            array('name' => 'Direccion operaciones','email' => 'direccion.operaciones@claudiachacon.com'),
                            array('name' => 'Direccion Administrativa','email' => 'direccion.administrativa@claudiachacon.com'),
                            array('name' => 'Mantenimiento','email' => 'inprodco.arquitectura@gmail.com'),
                            array('name' => 'Asistente Contable','email' => 'asistente.contable1@claudiachacon.com'),
                            array('name' => 'BeautySoft','email' => $fetchReenvio['slnemail'])
                        );
                        $tpaut='CAJA MENOR';
                    }*/

                    /****************************************************************************/
                    
                    /*$email = array(
                        'subject' => 'Reenvio Autorizacion # '.$fetchReenvio['autcodigo'].' | Beauty Soft - '.utf8_encode($tpaut),
                        'template'=>array(
                            'id'=>'190022',
                            'variables'=>array(
                              'autnum'  =>  $fetchReenvio['autcodigo'],
                              'auttpo'  =>  utf8_encode($fetchReenvio['nombre']),
                              'autstpo' =>  utf8_encode($fetchReenvio['subtipo_nombre']),
                              'autdate' =>  $fetchReenvio['autfecha_autorizacion'],
                              'autsln'  =>  utf8_encode($fetchReenvio['slnnombre']),
                              'autvlr'  =>  $fetchReenvio['autvalor'],
                              'autben'  =>  utf8_encode($fetchReenvio['colaborador']),
                              'autcon'  =>  utf8_encode($fetchReenvio['observacion']),
                              'autapro' =>  utf8_encode($fetchReenvio['autoriza'])
                            ),
                        ),
                        'from' => array(
                          'name' => 'Claudia Chacon - Belleza y Estetica',
                          'email' => 'info@claudiachacon.com',
                        ),
                        'to' => $dest,
                    );
                    if ($SPApiClient->smtpSendMail($email))
                    {
                        echo json_encode(array('res' => 1, 'codigo' => $row[0]));
                    } 
                    else 
                    {
                        echo json_encode(array('res' => 0));
                    }*/ 

                   


                break;

        
                default:
                 # code...
                 break;
    }
 ?>