<?php 

    include("../../../cnx_data.php");

    $conn = mysqli_connect("localhost", "appbeauty", "bty_ERP@2017", "beauty_erp");
	if (!$conn) 
	{
    		die("Error al establecer conexión con la base de datos. " . mysqli_connect_error());
    }

    $cantidadBonos = 75;
    $valor = 14000;
    $empresa = 'Lean Marketing - Muebles Jamar';
    $servicios = 'Promo Manicure $14.000';
    $observaciones = 'Precio de Manicure a $14.000 valido hasta el 15 de JULIO 2021 para LEAN MARKETING - MUEBLES JAMAR';
    $cantBonosInvalidos = 0;

    for($i = 0; $i < $cantidadBonos; $i++){

        $bono = generarBono();

        $guardarBono = mysqli_query($conn, 'INSERT INTO beauty_erp.btybono (boncupon, bonempresa, bonvalorinicial, bonvaloractual, bonservicios, bonobservaciones, usucodigo) VALUES("' . $bono . '", "' . $empresa . '", "' . $valor . '", "' . $valor. '", "' . $servicios . '", "' . $observaciones . '", 3)');

        if(!$guardarBono){
            $cantBonosInvalidos++;
        }
    }

    echo $cantBonosInvalidos;

    function generarBono(){
        
        global $conn;
        $caracteresPermitidos = "0123456789abcdefghijklmnopqrstuvwxyz";
        $longitudCodigoBono = 10;
        
        while(true){
            
            $codigoBono = strtoupper(substr(str_shuffle($caracteresPermitidos), 0, $longitudCodigoBono));
            $bonoExistente = mysqli_query($conn, "SELECT * FROM beauty_erp.btybono WHERE boncupon = '" . $codigoBono . "'");

            if(mysqli_num_rows($bonoExistente) == 0){
                break;
            }
        }
        
        return $codigoBono;
    }
?>
