<?php 
	include("../../../cnx_data.php");
    include("../funciones.php");

    use Sendpulse\RestApi\ApiClient;
    use Sendpulse\RestApi\Storage\FileStorage;
    require("../../../lib/sendpulseAPI/src/ApiInterface.php");
    require("../../../lib/sendpulseAPI/src/ApiClient.php");
    require("../../../lib/sendpulseAPI/src/Storage/TokenStorageInterface.php");
    require("../../../lib/sendpulseAPI/src/Storage/FileStorage.php");
    require("../../../lib/sendpulseAPI/src/Storage/SessionStorage.php");
    require("../../../lib/sendpulseAPI/src/Storage/MemcachedStorage.php");
    require("../../../lib/sendpulseAPI/src/Storage/MemcacheStorage.php");
    define('API_USER_ID', 'da52a4ac5c4f3bc970862d017c6527dd');
    define('API_SECRET', '4d6b5a2445166632cbe4530826c68def');
    define('PATH_TO_ATTACH_FILE', __FILE__);

	switch ($_POST['opcion']) 
	{
		case 'loadColaborador':

                $f = "SELECT a.clbcodigo, b.trcrazonsocial FROM btycolaborador a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE (b.trcrazonsocial LIKE '%".utf8_decode($_POST['datoColaborador'])."%') and  (bty_fnc_estado_colaborador(a.clbcodigo) = 'VINCULADO')";

                
                $sql = mysqli_query($conn,$f);



                $array = array();

                while ($row = mysqli_fetch_array($sql)) 
                {  
                    $array[] = array('clbcodigo' => $row['clbcodigo'], 'colaborador' => $row['trcrazonsocial']);
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

                $tipo = mysqli_query($conn, "SELECT a.nombre, a.alias FROM btyautorizaciones_tipo a WHERE a.auttipo_codigo = '".$_POST['tipo']."' ");
                $tipoFetch = mysqli_fetch_array($tipo);
                $tipoAut = $tipoFetch[0];

                if ($_POST['tipo'] == '1' OR $_POST['tipo'] == '2') 
                {
                    $sql = mysqli_query($conn, "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, slncodigo, clbcodigo, usucodigo, beneficiario, observacion, autvalor, autporcentaje, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite, autestado) VALUES('$max', '".$_POST['tipo']."', '".$_POST['sln']."', '".$_POST['col']."', '".$_SESSION['codigoUsuario']."', NULL, '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['val']."', NULL, '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO', 1)  ")or die(mysqli_error($conn));
                }
                elseif ($_POST['tipo'] == '3') 
                {
                    $sql = mysqli_query($conn, "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, slncodigo, clbcodigo, usucodigo, beneficiario, observacion, autvalor, autporcentaje, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite, autestado) VALUES('$max', '".$_POST['tipo']."', '".$_POST['sln']."', '".$_POST['col']."', '".$_SESSION['codigoUsuario']."', NULL, '".strtoupper(utf8_decode($_POST['obs']))."', NULL, '".$_POST['por']."', '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO', 1)  ")or die(mysqli_error($conn));
                }
                elseif ($_POST['tipo'] == '4') 
                {
                    $sql = mysqli_query($conn, "INSERT INTO btyautorizaciones (autcodigo, auttipo_codigo, slncodigo, clbcodigo, usucodigo, beneficiario, observacion, autvalor, autporcentaje, autfecha_autorizacion, autfecha_registro, authora_registro, autestado_tramite, autestado) VALUES('$max', '".$_POST['tipo']."', '".$_POST['sln']."', NULL, '".$_SESSION['codigoUsuario']."', '".strtoupper(utf8_decode($_POST['cli']))."', '".strtoupper(utf8_decode($_POST['obs']))."', '".$_POST['val']."', NULL, '".$_POST['fec']."', CURDATE(), CURTIME(), 'RADICADO', 1)  ")or die(mysqli_error($conn));
                }

                if ($sql) 
                {
                        /*require dirname(__FILE__).'../../../../lib/phpmailer/phpmailer/PHPMailerAutoload.php';
                        $mail = new PHPMailer;
                        $mail->isSMTP();
                        $mail->SMTPDebug = 0;
                        $mail->Debugoutput = 'html';
                        $mail->Host = "smtpout.secureserver.net";
                        $mail->Port = 25;
                        $mail->SMTPAuth = true;
                        $mail->Username = "app@claudiachacon.com";
                        $mail->Password = "AppBTY.18";
                        $mail->setFrom('app@claudiachacon.com', ''.utf8_decode('Beauty Soft')).'';
                        $mail->addReplyTo('app@claudiachacon.com', ''.utf8_decode('Beauty Soft').'');*/

                        if ($_POST['tipo'] == 1) 
                        {
                            /*$mail->addAddress('direccion.administrativa@claudiachacon.com', 'Viviana Gandara');
                            $mail->addAddress('asistente.operaciones@claudiachacon.com', 'Asistente operaciones');                            
                            $mail->addAddress('asistente.contable1@claudiachacon.com', 'Asistente Contable');
                            $mail->addAddress($salon['slnemail'], 'Beauty Soft');*/


                            $dest=array(
                                array('name' => 'Viviana Gandara','email' => 'direccion.administrativa@claudiachacon.com'),
                                array('name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                array('name' => 'Asistente Contable','email' => 'asistente.contable1@claudiachacon.com'),
                                array('name' => 'BeautySoft','email' => $salon['slnemail'])
                            );
                        }
                        elseif ($_POST['tipo'] == 2) 
                        {
                            /*$mail->addAddress('asistente.operaciones@claudiachacon.com', 'Asistente operaciones');
                            $mail->addAddress('gestionhumana@claudiachacon.com', 'Elaine Tapia');
                            $mail->addAddress($salon['slnemail'], 'Beauty Soft');*/

                            $dest=array(
                                array('name' => 'Elaine Tapia','email' => 'gestionhumana@claudiachacon.com'),
                                array('name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                array('name' => 'BeautySoft','email' => $salon['slnemail'])
                            );
                        }
                        elseif ($_POST['tipo'] == 3) 
                        {
                            /*$mail->addAddress('asistente.operaciones@claudiachacon.com', 'Asistente Operaciones');
                            $mail->addAddress('asistente.gestionhumana@claudiachacon.com', 'Asistente Gestión Humana');
                            $mail->addAddress($salon['slnemail'], 'Beauty Soft');*/

                            $dest=array(
                                array('name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                array('name' => 'Asistente Gestión Humana','email' => 'asistente.gestionhumana@claudiachacon.com'),
                                array('name' => 'BeautySoft','email' => $salon['slnemail'])
                            );
                        }
                        else
                        {
                           /* $mail->addAddress('asistente.operaciones@claudiachacon.com', 'Silfredo Machado');
                            $mail->addAddress('direccion.administrativa@claudiachacon.com', 'Viviana Gandara');
                            $mail->addAddress('direccion.comercial@claudiachacon.com', 'Adiela Castro');
                            $mail->addAddress($salon['slnemail'], 'Beauty Soft');*/

                            $dest=array(
                                array('name' => 'Viviana Gandara','email' => 'direccion.administrativa@claudiachacon.com'),
                                array('name' => 'Adiela Castro','email' => 'direccion.comercial@claudiachacon.com'),
                                array('name' => 'Asistente operaciones','email' => 'asistente.operaciones@claudiachacon.com'),
                                array('name' => 'BeautySoft','email' => $salon['slnemail'])
                            );
                        }

                        /*$message = '<html><style>th{font-size: .9em;}</style>
                                <head>
                                
                                <meta charset="utf-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <link rel="stylesheet" href="http://beauty.claudiachacon.com/beauty/lib/vendor/fontawesome/css/font-awesome.css" />

                                </head>
                                <body>';

                                $message .= '<table cellpadding="5" cellspacing="5" border="1">
                                <thead>
                                    <tr style="background-color: #d2e3fc">
                                      <th colspan="2"><center>BEAUTY SOFT | AUTORIZACIONES</center></th>
                                    </tr>
                                    <tr style="background-color: #c9ffc4">
                                        <th colspan="2">Autorizaci&oacute;n '.$tipoFetch[1].' # '.$max.'</th>
                                    </tr>
                                    
                                </thead>
                                <tbody>';*/

                                if ($_POST['col'] != '0') 
                                {                    
                                    $colaborador = mysqli_query($conn, "SELECT b.trcrazonsocial FROM btycolaborador a JOIN btytercero b ON a.tdicodigo=b.tdicodigo AND a.trcdocumento=b.trcdocumento WHERE a.clbcodigo = '".$_POST['col']."' ");

                                    $beneFetch = mysqli_fetch_array($colaborador);

                                    $beneficiario = $beneFetch[0];
                                }
                                else
                                {
                                    $beneficiario = $_POST['cli'];
                                }



                                if ($_POST['tipo'] == '1' OR $_POST['tipo'] == '2' OR $_POST['tipo'] == '4') 
                                {
                                    $valorAut = '$'.$_POST['val2'];
                                }
                                elseif ($_POST['tipo'] == '3') 
                                {
                                    $valorAut = $_POST['por'].'%';
                                }
                            

                                /*$message.='
                                    <tr>
                                        <th>TIPO:</th>
                                        <th style="text-align: left;">'.$tipoAut.'</th>
                                    </tr>
                                    <tr>
                                        <th>FECHA:</th>
                                        <th style="text-align: left;">'.$_POST['fec'].'</th>
                                    </tr>
                                    <tr>
                                        <th>SAL&Oacute;N:</th>
                                        <th style="text-align: left;">'.$salon['slnnombre'].'</th>  
                                    </tr>
                                    <tr>
                                        <th>VALOR:</th>
                                        <th style="text-align: left;">'.$valorAut.'</th>
                                    </tr>
                                    <tr>
                                        <th>BENEFICIARIO:</th>
                                        <th style="text-align: left;">'.strtoupper($beneficiario) .'</th>
                                    </tr>
                                    <tr>
                                        <th>POR CONCEPTO DE:</th>
                                        <th style="text-align: left;">'.strtoupper(utf8_decode($_POST['obs'])).'</th>
                                    </tr>
                                    <tr>
                                        <th>APROBADO POR:</th>
                                        <th style="text-align: left;">'.utf8_decode($usuarioAprueba).'</th>
                                    </tr>
                                </tbody></table>
                                ';*/


                        //echo $message;
                        $email = array(
                            'subject' => 'Nueva Autorización #'.$autnum,
                            'template'=>array(
                                'id'=>'190022',
                                'variables'=>array(
                                  'autnum'  =>  $max,
                                  'auttpo'  =>  $tipoAut,
                                  'autstpo' =>  $autstpo,
                                  'autdate' =>  $_POST['fec'],
                                  'autsln'  =>  $salon['slnnombre'],
                                  'autvlr'  =>  $valorAut,
                                  'autben'  =>  strtoupper($beneficiario),
                                  'autcon'  =>  strtoupper(utf8_decode($_POST['obs'])),
                                  'autapro' =>  utf8_decode($usuarioAprueba)
                                ),
                            ),
                            'from' => array(
                              'name' => 'Claudia Chacon - Belleza y Estetica',
                              'email' => 'info@claudiachacon.com',
                            ),
                            'to' => $dest,
                            );

                        /*$mail->Subject = utf8_decode('Nueva Autorización # '.$max.' | Beauty Soft');
                        $mail->msgHTML($message, dirname(__FILE__));
                        $mail->AltBody = '';*/
                        if ($SPApiClient->smtpSendMail($email))
                        {
                              echo json_encode(array('res' => 0));
                        } 
                        else 
                        {
                            echo json_encode(array('res' => 1, 'codigo' => $max));
                        }
                }
            break;

        case 'load':
            
                $s = "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial as beneficiario, g.trcrazonsocial as usuarioaprueba, a.beneficiario as cliente, CONCAT('$',FORMAT(a.autvalor,0))AS autvalor, a.autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo LEFT JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo LEFT JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btyusuario f ON f.usucodigo=a.usucodigo LEFT JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' ORDER BY autcodigo DESC LIMIT 8";

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
                            'ali' => $row['alias'],
                            'col' => $row['beneficiario'],
                            'usu' => $row['usuarioaprueba'],
                            'cli' => $row['cliente'],
                            'sln' => $row['slnnombre'],
                            'obs' => $row['observacion'],
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
            
                $s = "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial as beneficiario, g.trcrazonsocial as usuarioaprueba, a.beneficiario as cliente, CONCAT('$',FORMAT(a.autvalor,0))AS autvalor, a.autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo LEFT JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo LEFT JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btyusuario f ON f.usucodigo=a.usucodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' ORDER BY autcodigo DESC LIMIT 1 ";
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
                            'ali' => $row['alias'],
                            'col' => $row['beneficiario'],
                            'usu' => $row['usuarioaprueba'],
                            'cli' => $row['cliente'],
                            'sln' => $row['slnnombre'],
                            'obs' => $row['observacion'],
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


                 $r = "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial AS beneficiario, g.trcrazonsocial AS usuarioaprueba, CONCAT('$', FORMAT(a.autvalor,0)) AS autvalor, a.beneficiario AS bene_cliente, a.autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre, IFNULL(a.clbcodigo, 'clbcodigo')as '' FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo left JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo left JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento left JOIN btyusuario f ON f.usucodigo=a.usucodigo left JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autcodigo = '".$_POST['codigo']."'";
                 //echo $r;

            
                    $sql = mysqli_query($conn,$r);

                    $arrayLista = array();

                    while ($row = mysqli_fetch_array($sql)) 
                    {
                        $arrayLista[] = array(
                            'cod' => $row['autcodigo'],
                            'nom' => $row['nombre'],
                            'ali' => $row['alias'],
                            'col' => $row['beneficiario'],
                            'usu' => $row['usuarioaprueba'],
                            'cli' => $row['bene_cliente'],
                            'sln' => $row['slnnombre'],
                            'obs' => $row['observacion'],
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

                $sql =  "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial as beneficiario, g.trcrazonsocial as usuarioaprueba, CONCAT('$',FORMAT(a.autvalor,0))AS autvalor, a.autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre, a.beneficiario as bene_cliente FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btyusuario f ON f.usucodigo=a.usucodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND (a.autcodigo LIKE '%".$codigoBen."%' or e.trcrazonsocial LIKE '%".utf8_decode($codigoBen)."%') ";

            
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
                $sql = $sql." ORDER BY e.trcrazonsocial limit $offset, $rowsPerPage";
                $result = $conn->query($sql);

  

                if ($result->num_rows > 0) 
                {
    
                        while ($row = $result->fetch_assoc()) 
                        {
                            if ($row['beneficiario'] == '') 
                            {
                                $beneficiario = $row['bene_cliente'];
                            }
                            else
                            {
                                 $beneficiario = $row['beneficiario'];
                            }   


                               echo '<div class="panel-body note-link">
                                        <a href="#note'.$row['autcodigo'].'" data-toggle="tab" onclick="fnLoadAut('.$row['autcodigo'].')">
                                            <small class="pull-right text-muted">'.$row['autfecha_autorizacion'].'</small>
                                                <h5>#'.$row['autcodigo'].'</h5>
                                                <div class="small">'.utf8_encode($row['nombre']).' <b>['.utf8_encode($beneficiario).']</b></div>
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

                $sql =  "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial as beneficiario, g.trcrazonsocial as usuarioaprueba, CONCAT('$',FORMAT(a.autvalor,0))AS autvalor, a.autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre, a.beneficiario as bene_cliente FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo LEFT JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo LEFT JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btyusuario f ON f.usucodigo=a.usucodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.auttipo_codigo = '".$tipo."' ";

            
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
                $sql = $sql." ORDER BY a.autfecha_autorizacion limit $offset, $rowsPerPage";
                $result = $conn->query($sql);

  

                if ($result->num_rows > 0) 
                {
    
                        while ($row = $result->fetch_assoc()) 
                        {
                            if ($row['beneficiario'] == '') 
                            {
                                $beneficiario = $row['bene_cliente'];
                            }
                            else
                            {
                                 $beneficiario = $row['beneficiario'];
                            }   


                               echo '<div class="panel-body note-link">
                                        <a href="#note'.$row['autcodigo'].'" data-toggle="tab" onclick="fnLoadAut('.$row['autcodigo'].')">
                                            <small class="pull-right text-muted">'.$row['autfecha_autorizacion'].'</small>
                                                <h5>#'.$row['autcodigo'].'</h5>
                                                <div class="small">'.utf8_encode($row['nombre']).' <b>['.utf8_encode($beneficiario).']</b></div>
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
                


                    $f = "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial as beneficiario, a.beneficiario as bene_cliente, g.trcrazonsocial as usuarioaprueba, CONCAT('$',FORMAT(a.autvalor,0))AS autvalor, a.autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre, a.beneficiario as bene_cliente, h.slnemail, a.auttipo_codigo FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo LEFT JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo LEFT JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btyusuario f ON f.usucodigo=a.usucodigo LEFT JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo WHERE a.autcodigo = '".$_POST['idaut']."' ";

                    $sql = mysqli_query($conn, $f);
                    if ($sql) 
                    {

                            $row = mysqli_fetch_array($sql);

                            $update = mysqli_query($conn, "UPDATE btyautorizaciones SET autestado_tramite = 'ANULADA', usucodigo = '".$_SESSION['codigoUsuario']."' WHERE autcodigo = '".$_POST['idaut']."' ");

                            require dirname(__FILE__).'../../../../lib/phpmailer/phpmailer/PHPMailerAutoload.php';

                            $mail = new PHPMailer;

                            $mail->isSMTP();

                            $mail->SMTPDebug = 0;

                            $mail->Debugoutput = 'html';

                            $mail->Host = "smtpout.secureserver.net";

                            $mail->Port = 25;

                            $mail->SMTPAuth = true;

                            $mail->Username = "app@claudiachacon.com";

                            $mail->Password = "AppBTY.18";

                            $mail->setFrom('app@claudiachacon.com', ''.utf8_decode('Beauty Soft')).'';

                            $mail->addReplyTo('app@claudiachacon.com', ''.utf8_decode('Beauty Soft').'');


                            if ($row['auttipo_codigo'] == 1) 
                            {
                                $mail->addAddress('direccion.administrativa@claudiachacon.com', 'Viviana Gandara');
                                $mail->addAddress('asistente.operaciones@claudiachacon.com', 'Silfredo Machado');
                                $mail->addAddress('asistente.contable1@claudiachacon.com', 'Alvaro Coronado');                                
                                $mail->addAddress($row['slnemail'], 'Beauty Soft');
                            }
                            elseif ($row['auttipo_codigo'] == 2) 
                            {
                                $mail->addAddress('asistente.operaciones@claudiachacon.com', 'Silfredo Machado');
                                $mail->addAddress('gestionhumana@claudiachacon.com', 'Elaine Tapia');
                                $mail->addAddress($row['slnemail'], 'Beauty Soft');
                            }
                            elseif ($row['auttipo_codigo'] == 3) 
                            {
                                $mail->addAddress('asistente.operaciones@claudiachacon.com', 'Silfredo Machado');
                                $mail->addAddress('asistente.gestionhumana@claudiachacon.com', 'Laura Merino');
                                $mail->addAddress($row['slnemail'], 'Beauty Soft');
                            }
                            else
                            {
                                $mail->addAddress('asistente.operaciones@claudiachacon.com', 'Silfredo Machado');
                                $mail->addAddress('direccion.administrativa@claudiachacon.com', 'Viviana Gandara');
                                $mail->addAddress('direccion.comercial@claudiachacon.com', 'Adiela Castro');
                                $mail->addAddress($row['slnemail'], 'Beauty Soft');
                            }



                            //$mail->addAddress($_SESSION['email'], 'Sil');
                            //$mail->addAddress('asistente.operaciones@claudiachacon.com', 'Beauty Soft');

                            $message = '<html><style>th{font-size: .9em;}</style>
                                    <head>
                                    
                                    <meta charset="utf-8">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <link rel="stylesheet" href="http://beauty.claudiachacon.com/beauty/lib/vendor/fontawesome/css/font-awesome.css" />

                                    </head>
                                    <body>';

                                    $message .= '<table cellpadding="5" cellspacing="5" border="1">
                                    <thead>
                                        <tr style="background-color: #d2e3fc">
                                          <th colspan="2"><center>BEAUTY SOFT | AUTORIZACIONES</center></th>
                                        </tr>
                                        <tr style="background-color: #e91414";>
                                            <th colspan="2" style="color: #fff">Autorizaci&oacute;n #'.$row[0].' ANULADA</th>
                                        </tr>
                                        
                                    </thead>
                                    <tbody>';

                                    if ($row['beneficiario'] == '') 
                                    {                    

                                        $beneficiario = $row['bene_cliente'];
                                    }
                                    else
                                    {
                                        $beneficiario = $row['beneficiario'];
                                    }



                                    if ($row[6] != '') 
                                    {
                                        $valorAut = $row[6];
                                    }
                                    else
                                    {
                                        $valorAut = $row[7].'%';
                                    }


                                    $message.='
                                        <tr>
                                            <th>TIPO:</th>
                                            <th style="text-align: left;">'.$row['nombre'].'</th>
                                        </tr>
                                        <tr>
                                            <th>FECHA:</th>
                                            <th style="text-align: left;">'.$row['autfecha_autorizacion'].'</th>
                                        </tr>
                                        <tr>
                                            <th>SAL&Oacute;N:</th>
                                            <th style="text-align: left;">'.$row['slnnombre'].'</th>
                                        </tr>
                                        <tr>
                                            <th>VALOR:</th>
                                            <th style="text-align: left;">'.$valorAut.'</th>
                                        </tr>
                                        <tr>
                                            <th>BENEFICIARIO:</th>
                                            <th style="text-align: left;">'.strtoupper(utf8_encode($beneficiario)).'</th>
                                        </tr>
                                        <tr>
                                            <th>POR CONCEPTO DE:</th>
                                            <th style="text-align: left;">'.strtoupper(utf8_encode($row['observacion'])).'</th>
                                        </tr>
                                        <tr>
                                            <th>APROBADO POR:</th>
                                            <th style="text-align: left;">'.utf8_decode($row['usuarioaprueba']).'</th>
                                        </tr>
                                    </tbody></table>
                                    ';


                                    //echo $message;


                                    $mail->Subject = utf8_decode('Autorizacion # '.$row[0].' Anulada | Beauty Soft');

                                    $mail->msgHTML($message, dirname(__FILE__));
                                    
                                    $mail->AltBody = '';

                                    if (!$mail->send()) 
                                    {
                                          echo 0;
                                    } 
                                    else 
                                    {
                                        echo json_encode(array('res' => 1, 'codigo' => $row[0]));
                                    }
                    }
            break;	
		      

        case 'reporte':

            if ($_POST['tipo'] == '0') 
            {
                if ($_POST['sln'] == '0') 
                {

                    $sql = "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial AS beneficiario, g.trcrazonsocial AS usuarioaprueba, a.beneficiario AS cliente, CONCAT('$', FORMAT(a.autvalor,0)) AS autvalor, CONCAT(a.autporcentaje, '', '%') AS autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre, crg.crgnombre, a.autestado_tramite FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo LEFT JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo LEFT JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btyusuario f ON f.usucodigo=a.usucodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo LEFT JOIN btycargo crg ON crg.crgcodigo=d.crgcodigo WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' ORDER BY autcodigo";
                }
                else
                {
                    $sql = "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial AS beneficiario, g.trcrazonsocial AS usuarioaprueba, a.beneficiario AS cliente, CONCAT('$', FORMAT(a.autvalor,0)) AS autvalor, CONCAT(a.autporcentaje, '', '%') AS autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre, crg.crgnombre, a.autestado_tramite FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo LEFT JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo LEFT JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btyusuario f ON f.usucodigo=a.usucodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo LEFT JOIN btycargo crg ON crg.crgcodigo=d.crgcodigo WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.slncodigo IN ('".$_POST['sln']."') ORDER BY autcodigo";
                }

            }
            else
            {
                if ($_POST['tipo'] == 'anulados') 
                {
                    if ($_POST['sln'] == '0') 
                    {
                        $sql = "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial AS beneficiario, g.trcrazonsocial AS usuarioaprueba, a.beneficiario AS cliente, CONCAT('$', FORMAT(a.autvalor,0)) AS autvalor, CONCAT(a.autporcentaje, '', '%') AS autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre, crg.crgnombre, a.autestado_tramite FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo LEFT JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo LEFT JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btyusuario f ON f.usucodigo=a.usucodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo LEFT JOIN btycargo crg ON crg.crgcodigo=d.crgcodigo WHERE a.autestado = 1 AND a.autestado_tramite = 'ANULADA' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' ORDER BY autcodigo";

                        
                    }
                    else
                    {
                        $sql = "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial AS beneficiario, g.trcrazonsocial AS usuarioaprueba, a.beneficiario AS cliente, CONCAT('$', FORMAT(a.autvalor,0)) AS autvalor, CONCAT(a.autporcentaje, '', '%') AS autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre, crg.crgnombre, a.autestado_tramite FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo LEFT JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo LEFT JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btyusuario f ON f.usucodigo=a.usucodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo LEFT JOIN btycargo crg ON crg.crgcodigo=d.crgcodigo WHERE a.autestado = 1 AND a.autestado_tramite = 'ANULADA' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.slncodigo IN ('".$_POST['sln']."') ORDER BY autcodigo";

                    }
                    
                }
                else
                {

                    if ($_POST['sln'] == '0') 
                    {
                        $sql = "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial AS beneficiario, g.trcrazonsocial AS usuarioaprueba, a.beneficiario AS cliente, CONCAT('$', FORMAT(a.autvalor,0)) AS autvalor, CONCAT(a.autporcentaje, '', '%') AS autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre, crg.crgnombre, a.autestado_tramite FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo LEFT JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo LEFT JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btyusuario f ON f.usucodigo=a.usucodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo LEFT JOIN btycargo crg ON crg.crgcodigo=d.crgcodigo WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.auttipo_codigo IN('".$_POST['tipo']."') ORDER BY autcodigo";
                    }
                    else
                    {
                       $sql = "SELECT a.autcodigo, b.nombre, b.alias, e.trcrazonsocial AS beneficiario, g.trcrazonsocial AS usuarioaprueba, a.beneficiario AS cliente, CONCAT('$', FORMAT(a.autvalor,0)) AS autvalor, CONCAT(a.autporcentaje, '', '%') AS autporcentaje, a.observacion, a.autfecha_autorizacion, h.slnnombre, crg.crgnombre, a.autestado_tramite FROM btyautorizaciones a JOIN btyautorizaciones_tipo b ON a.auttipo_codigo=b.auttipo_codigo JOIN btysalon c ON c.slncodigo=a.slncodigo LEFT JOIN btycolaborador d ON d.clbcodigo=a.clbcodigo LEFT JOIN btytercero e ON e.tdicodigo=d.tdicodigo AND e.trcdocumento=d.trcdocumento JOIN btyusuario f ON f.usucodigo=a.usucodigo JOIN btytercero g ON g.tdicodigo=f.tdicodigo AND g.trcdocumento=f.trcdocumento JOIN btysalon h ON h.slncodigo=a.slncodigo LEFT JOIN btycargo crg ON crg.crgcodigo=d.crgcodigo WHERE a.autestado = 1 AND a.autestado_tramite = 'RADICADO' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.slncodigo IN ('".$_POST['sln']."') AND a.auttipo_codigo IN('".$_POST['tipo']."') ORDER BY autcodigo";

                        //$count = "SELECT SUM(a.autvalor) FROM btyautorizaciones a WHERE a.autestado = 1 AND a.autestado_tramite = 'ANULADA' AND a.autfecha_autorizacion BETWEEN '".$_POST['fecha1']."' AND '".$_POST['fecha2']."' AND a.slncodigo IN ('".$_POST['sln']."') AND a.auttipo_codigo IN('".$_POST['tipo']."') ORDER BY autcodigo";

                    }
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
                while($data = mysqli_fetch_assoc($d))
                {
                        $array['data'][] = $data;

                }

                    
            

                $array = utf8_converter($array);

                //echo json_encode(array('res' => 'full', 'json' => $array, 'conteo' => $de));
                echo json_encode($array);
            }
            else
            {
                echo json_encode(array('res' => 'empty'));
            }



           
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
                default:
			     # code...
			     break;
	}
 ?>
