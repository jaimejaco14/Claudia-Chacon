<?php

    include("../../../cnx_data.php");
    
    global $conn;
    
    $response = "";

    switch ($_REQUEST['metodo']) {

        case 'generarBono':
        
            $valorBono = intval($_POST['valor']);
            $valorBonoValido = (isset($valorBono) && !empty($valorBono) && $valorBono >= 1000) ? true : false;

            if($valorBonoValido){

                $nombres = !empty($_POST['nombres']) ? $_POST['nombres'] : '';
                $apellidos = !empty($_POST['apellidos']) ? $_POST['apellidos'] : '';
                $identificacion = !empty($_POST['identificacion']) ? $_POST['identificacion'] : '';
                $correo = !empty($_POST['correo']) ? $_POST['correo'] : '';
                $celular = !empty($_POST['celular']) ? $_POST['celular'] : '';
                $empresa = !empty($_POST['empresa']) ? $_POST['empresa'] : '';
                $servicios = !empty($_POST['servicios']) ? $_POST['servicios'] : '';
                $observaciones = !empty($_POST['observaciones']) ? $_POST['observaciones'] : '';
                $codigoUsuario = $_POST['codigoUsuario'];
                $codigoBono = generarBono();

                if(guardarBono($codigoBono, $valorBono, $identificacion, $correo, $nombres, $apellidos, $empresa, $servicios, $observaciones, $codigoUsuario)){

                    $arrayBonoGenerado = [
                        'codigoBono' => $codigoBono,
                        'valorBono' => $valorBono,
                        'desc' => 'OK'
                    ];
    
                    echo json_encode(['data' => $arrayBonoGenerado]);
                }
                else{
                    echo json_encode(['data' => ['desc' => 'ERROR', 'mensaje' => 'Verifique que los datos otorgados sean correctos']]);
                }
            }
            else{
                echo json_encode(['data' => ['desc' => 'ERROR', 'mensaje' => 'Verifique que los datos otorgados sean correctos']]);
            }

            break;

        case 'listarBonos':

            //$sqlBonos = mysqli_query($conn, "SELECT b.boncodigo, b.boncupon, b.bonactivo, DATE_FORMAT(b.bonfechacaducidad, '%d/%m/%Y %h:%i:%s %p') AS bonfechacaducidad, DATE_FORMAT(b.bonfecharegistro, '%d/%m/%Y %h:%i:%s %p') AS bonfecharegistro, CONCAT('$', FORMAT(b.bonvalorinicial, 0, 'de_DE')) AS bonvalorinicial, CONCAT('$', FORMAT(b.bonvaloractual, 0, 'de_DE')) AS bonvaloractual FROM btybono b WHERE b.bonactivo = 1");

            $sqlBonos = mysqli_query($conn, "SELECT b.boncodigo, b.boncupon, b.bonactivo, b.bonempresa, b.bonservicios, b.bonobservaciones, DATE_FORMAT(b.bonfechacaducidad, '%d/%m/%Y %h:%i:%s %p') AS bonfechacaducidad, DATE_FORMAT(b.bonfecharegistro, '%d/%m/%Y %h:%i:%s %p') AS bonfecharegistro, CONCAT('$', FORMAT(b.bonvalorinicial, 0, 'de_DE')) AS bonvalorinicial, CONCAT('$', FORMAT(b.bonvaloractual, 0, 'de_DE')) AS bonvaloractual FROM btybono b");

                $array = array();

            if(mysqli_num_rows($sqlBonos) > 0){
                
                while($bono = mysqli_fetch_assoc($sqlBonos)){
                      $array['data'][] = $bono;
                }                    
            }
            else{
                  $array=array('data'=>'');
            }
            echo json_encode($array);
            break;

        case 'desactivarBono':

            if(isset($_POST['codigoBono']) && !empty($_POST['codigoBono'])){

                $sqlDesactivarBono = mysqli_query($conn, 'UPDATE btybono SET bonactivo = 0 WHERE boncodigo = ' . $_POST['codigoBono']);

                if($sqlDesactivarBono){
                    echo json_encode(['data' => ['desc' => 'OK', 'mensaje' => 'Se ha desactivado el bono']]);
                }
                else{
                    echo json_encode(['data' => ['desc' => 'ERROR', 'mensaje' => 'No pudo desactivarse el bono']]);
                }
            }
            else{
                echo json_encode(['data' => ['desc' => 'ERROR', 'mensaje' => 'Ocurrió un error al desactivar el bono']]);
            }
            break;

        case 'consultarBono':

            $codigoBono = $_GET['codigoBono'];

            if(isset($codigoBono) && !empty($codigoBono)){

                //$sqlBono = mysqli_query($conn, 'SELECT * FROM btybono WHERE boncupon = "' . $codigoBono .'" AND (bonactivo = 1 OR bonfechacaducidad >= CURDATE())');
                $sqlBono = mysqli_query($conn, 'SELECT * FROM btybono WHERE boncupon = "' . $codigoBono .'"');

                if(mysqli_num_rows($sqlBono) > 0){

                    while($datosBono = mysqli_fetch_assoc($sqlBono)){
                        
                        if($datosBono['bonactivo'] == 1){

                            $arrayBono['data'] = ['desc' => 'OK'];
                            $arrayBono['bono'] = $datosBono;
                        }
                        else{
                            $arrayBono['data'] = ['desc' => 'WARNING', 'mensaje' => 'El bono ya fue redimido'];
                        }
                    }
                    
                    echo json_encode($arrayBono);
                }
                else{
                    echo json_encode(['data' => ['desc' => 'ERROR', 'mensaje' => 'El bono no existe']]);
                }
            }
            else{

                echo json_encode(['data' => ['desc' => 'ERROR', 'mensaje' => 'Verifique el código del bono']]);
            }
            break;

        case 'redimirBono':
            
            $valorUsado = $_POST['valorUsado'];
            $codigoBono = $_POST['codigoBono'];
            $ordenServicio = $_POST['ordenServicio'];
            $tipoRedencion = $_POST['tipoRedencion'];
            $salon = $_POST['codigoSalon'];
            $usuario = $_POST['codigoUsuario'];
            //$salon = 1;
            //$usuario = 87;

            $bono = obtenerBono($codigoBono);

            $ordenServicioExistente = mysqli_query($conn, 'SELECT * FROM btytransaccionbono WHERE trbfactura = "' . $ordenServicio .'" AND slncodigo = ' . $salon);

            if(mysqli_num_rows($ordenServicioExistente) == 0){

                if(!$bono){
                    echo json_encode(['data' => ['desc' => 'ERROR', 'mensaje' => 'El bono ya fue usado en su totalidad o no existe']]);
                }
                else{
    
                    if($tipoRedencion == 'total'){
    
                        $sqlActualizarBono = mysqli_query($conn, 'UPDATE btybono SET bonactivo = 0, bonvaloractual = 0, bonfechamodificacion = CURRENT_TIMESTAMP() WHERE boncupon ="' . $codigoBono .'"');
                        $sqlTransaccionBono = mysqli_query($conn, 'INSERT INTO btytransaccionbono (trbfactura, trbfechatransaccion, trbvalorusado, boncodigo, slncodigo, usucodigo) VALUES ("' . $ordenServicio . '", CURRENT_TIMESTAMP(), "' . intval($valorUsado) . '", "' . $bono['boncodigo'] . '", "' . $salon . '", "'. $usuario .'")');
    
                        if($sqlActualizarBono && $sqlTransaccionBono){
                            //echo json_encode(['data' => ['desc' => 'OK', 'mensaje' => 'Bono redimido de manera exitosa por un valor de $'.number_format(intval($valorUsado), 0, ",", ".")]]);
                            echo json_encode(['data' => ['desc' => 'OK', 'mensaje' => 'Bono redimido de manera exitosa por un valor de $'.number_format(intval($valorUsado), 0, ",", ".")]]);  
                        }
                        else{
                            echo json_encode(['data' => ['desc' => 'ERROR', 'mensaje' => 'Ocurrió un error al redimir']]); 
                        }
    
                    }
                    else{ //Redencion Parcial
                        
                        if(intval($valorUsado) <= intval($bono['bonvaloractual'])){
        
                            if((intval($bono['bonvaloractual']) - intval($valorUsado) == 0)){
    
                                $sqlActualizarBono = mysqli_query($conn, 'UPDATE btybono SET bonactivo = 0, bonvaloractual = 0, bonfechamodificacion = CURRENT_TIMESTAMP() WHERE boncupon ="' . $codigoBono .'"');
                                $valorRestante = 0;
                            }
                            else{
    
                                $valorRestante = intval($bono['bonvaloractual']) - intval($valorUsado);
                                $sqlActualizarBono = mysqli_query($conn, 'UPDATE btybono SET bonvaloractual = ' . $valorRestante . ', bonfechamodificacion = CURRENT_TIMESTAMP() WHERE boncupon ="' . $codigoBono .'"');
                            }
    
                            $sqlTransaccionBono = mysqli_query($conn, 'INSERT INTO btytransaccionbono (trbfactura, trbfechatransaccion, trbvalorusado, boncodigo, slncodigo, usucodigo) VALUES ("' . $ordenServicio . '", CURRENT_TIMESTAMP(), "' . intval($valorUsado) . '", "' . $bono['boncodigo'] . '", "'. $salon .'", "'. $usuario .'")');
    
                            if($sqlActualizarBono && $sqlTransaccionBono){
                                echo json_encode(['data' => ['desc' => 'OK', 'mensaje' => 'Bono redimido de manera exitosa por un valor de $'.number_format($valorUsado, 0, ',', '.') . ' y queda un restante de $'. number_format($valorRestante, 0, ',', '.')]]);  
                            }
                            else{
                                echo json_encode(['data' => ['desc' => 'ERROR', 'mensaje' => 'Ocurrió un error al redimir el bono']]); 
                            }
                        }
                        else{
                            echo json_encode(['data' => ['desc' => 'ERROR', 'mensaje' => 'El valor de redención supera el valor disponible del bono']]);        
                        }
                    }
                }
            }
            else{
                echo json_encode(['data' => ['desc' => 'ERROR', 'mensaje' => 'Ya se realizó una redención asociado al número de servicio indicado']]); 
            }

            break;

        case 'imprimirUltimaRedencion':

            $codSalon = $_GET['codigoSalon'];
            
            $sqlUltimaTransaccion = mysqli_query($conn, 'SELECT b.boncodigo AS boncodigo, b.boncupon AS boncupon, t.trbvalorusado AS trbvalorusado, s.slnnombre AS slnnombre, (SELECT CONCAT(tr.trcnombres, " ", tr.trcapellidos) FROM btytercero tr LEFT JOIN btyusuario u ON u.trcdocumento = tr.trcdocumento WHERE u.usucodigo = t.usucodigo) AS usunombre, t.trbfactura AS trbfactura, t.trbfechatransaccion AS trbfechatransaccion FROM btybono b INNER JOIN btytransaccionbono t ON b.boncodigo = t.boncodigo INNER JOIN btysalon s ON t.slncodigo = s.slncodigo WHERE t.slncodigo = ' . $codSalon . ' ORDER BY t.trbfechatransaccion DESC LIMIT 1');

            if(mysqli_num_rows($sqlUltimaTransaccion) > 0){
                
                while($datosTransaccion = mysqli_fetch_assoc($sqlUltimaTransaccion)){

                    $arrayUltimaTransaccion['data'] = ['desc' => 'OK'];
                    $arrayUltimaTransaccion['transaccion'] = $datosTransaccion;
                }

                echo json_encode($arrayUltimaTransaccion);
            }
            else{
                echo json_encode(['data' => ['desc' => 'ERROR', 'mensaje' => 'No se han redimido bonos hasta el momento']]);
            }
                break;
    }

    function generarBono(){
        
        global $conn;
        $caracteresPermitidos = "0123456789abcdefghijklmnopqrstuvwxyz";
        $longitudCodigoBono = 10;
        
        while(true){
            
            $codigoBono = strtoupper(substr(str_shuffle($caracteresPermitidos), 0, $longitudCodigoBono));
            $bonoExistente = mysqli_query($conn, "SELECT * FROM btybono WHERE boncupon = '" . $codigoBono . "'");

            if(mysqli_num_rows($bonoExistente) == 0){
                break;
            }
        }
        
        return $codigoBono;
    }

    function guardarBono($codigo, $valor, $identificacionUsuario, $emailUsuario, $nombresUsuario, $apellidosUsuario, $empresa, $servicios, $observaciones, $codigoUsuario){
        
        global $conn;
        $guardarBono = mysqli_query($conn, 
            "INSERT INTO btybono (
                boncupon, bonvalorinicial, bonvaloractual, bonidentificacionusuario, 
                bonemailusuario, bonnombresusuario, bonapellidosusuario, bonempresa, bonservicios, bonobservaciones, usucodigo
            )
            VALUES (
                '$codigo', $valor, $valor, '$identificacionUsuario', '$emailUsuario', '$nombresUsuario', '$apellidosUsuario',
                '$empresa', '$servicios', '$observaciones', '$codigoUsuario'
            )");

        return $guardarBono; 
    }

    function obtenerBono($codigoBono){
        global $conn;
        $bono = false;
        $bonoExistente = mysqli_query($conn, "SELECT * FROM btybono WHERE boncupon = '" . $codigoBono . "' AND bonactivo = 1");

        if(mysqli_num_rows($bonoExistente) > 0){

            while($datosBono = mysqli_fetch_assoc($bonoExistente)){        
                $bono = $datosBono; 
            }
        }

        return $bono;
    }

    mysqli_close($conn);
?>