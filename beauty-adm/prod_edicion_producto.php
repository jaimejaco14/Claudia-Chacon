<?php 
	include '../cnx_data.php';


 if($_FILES["file_edit"]["name"] != ''){

    $id               = $_POST['idprod'];
    $idcaract         = $_POST['idcarac'];
    $idimpuesto       = $_POST['impuesto'];
    $idunimedida      = $_POST['unimedida'];
    $cod_ant          = $_POST['txt_cod_anterior'];
    $producto         = $_POST['txt_nombre'];
    $descrip          = $_POST['txt_descripcion'];
    $alias            = $_POST['txt_alias'];
    $precio_fijo      = $_POST['precio_fijo'];
    $control_ven      = $_POST['control_ven'];
    $porcionado       = $_POST['porcionado'];
    $tipo_comi        = $_POST['tipo_comision'];
    $comision         = $_POST['comision'];
    $activo           = $_POST['activo'];
    $costo_inicial    = $_POST['costo_inicial'];


    $grupo            = $_POST['idgrupo'];
    $subgrupo         = $_POST['subgrupo_edit'];
    $linea            = $_POST['linea_edit'];
    $sublinea         = $_POST['sublinea_edit'];
    $caract           = $_POST['caract_edit'];


if (empty($porcionado)) {
        $porcionado = 0;
    }else{
       $porcionado=$porcionado;
    }

if (empty($precio_fijo)) {
        $precio_fijo = 0;
    }else{
       $precio_fijo=$precio_fijo;
    }

if (empty($activo)) {
        $activo = 0;
    }else{
       $activo=$activo;
    }

if (empty($control_ven)) {
        $control_ven = 0;
    }else{
       $control_ven=$control_ven;
    }

 



//proultimaactualizacion => curdate()

    $img  = $_FILES['file_edit']['name'];
    $tipo = $_FILES['file_edit']['type'];
    $tam  = $_FILES['file_edit']['size'];
    $ext_permitidas = array('jpg');
    $partes_nombre = explode('.', $img);
    $extension = end( $partes_nombre );
    $ext_correcta = in_array($extension, $ext_permitidas);
    $limite = 1024 * 500;
    $tipo_correcto = preg_match('/^image\/(pjpeg|jpeg|gif|png)$/', $tipo);

    if (!( $ext_correcta)){
      echo 1;
    }else{

            if ($tam <= $limite){
                    $ruta       = "../contenidos/imagenes/producto/";
                    $img        = $_FILES['file_edit']['name'];
                    $archivo    = $_FILES['file_edit']['tmp_name']; 
                    $partes_nombre = explode('.', $img);
                    $extension = end( $partes_nombre );
                    move_uploaded_file($archivo,$ruta.$id.".".$extension);
                    $imagen = ($id).".".$extension;

                    $cons = mysqli_query($conn, "UPDATE btyproducto SET crscodigo = $idcaract, imvcodigo = $idimpuesto, umecodigo = $idunimedida, procodigoanterior = $cod_ant, pronombre = '".strtoupper($producto)."', prodescripcion = '".strtoupper($descrip)."', proimagen = '$imagen', proalias = '".strtoupper($alias)."', propreciofijo = $precio_fijo, procontrolvencimiento = $control_ven, proporcionado = $porcionado, protipocomision = '$tipo_comi', procomision = $comision, proultactualizacion = CURDATE(), proactivo = $activo, procostoinicial = $costo_inicial WHERE procodigo = $id ")or die(mysqli_error($conn));
                    if ($cons) {
                        echo 4;
                    }

            
            } else {
                echo 2;
            }
    }

     $consulta = mysqli_query($conn, "SELECT car.crscodigo, sbl.sblcodigo, lin.lincodigo, sgr.sbgcodigo, gru.grucodigo FROM btyproducto pro
JOIN btycaracteristica car ON pro.crscodigo=car.crscodigo JOIN btysublinea sbl ON sbl.sblcodigo=car.sblcodigo JOIN btylinea lin ON lin.lincodigo=sbl.lincodigo JOIN btysubgrupo sgr ON lin.sbgcodigo=sgr.sbgcodigo JOIN btygrupo gru ON sgr.grucodigo=gru.grucodigo WHERE pro.procodigo = $id");

    $fila = mysqli_fetch_array($consulta);

    if ($fila['crscodigo'] != $caract) {
         $edit_1  = mysqli_query($conn, "UPDATE btyproducto SET crscodigo = $caract WHERE procodigo = $id ");

    }else{
        if ($fila['sblcodigo'] != $sublinea) {
            $edit_2  = mysqli_query($conn, "UPDATE btycaracteristica SET crscodigo = $caract, sblcodigo = $sublinea WHERE crscodigo = $caract");           
        }else{
            if ($fila['lincodigo'] != $linea) {
                $edit_3  = mysqli_query($conn, "UPDATE btysublinea SET sblcodigo = $sublinea, lincodigo = $linea WHERE sblcodigo = $sublinea ");                
            }else{
                if ($fila['sbgcodigo'] != $subgrupo ) {
                    $edit_4  = mysqli_query($conn, "UPDATE btylinea SET lincodigo = $linea, sbgcodigo = $subgrupo  WHERE lincodigo = $linea "); 
                }else{
                    if ($fila['grucodigo'] != $grupo) {
                        $edit_5  = mysqli_query($conn, "UPDATE btysubgrupo SET sbgcodigo = $subgrupo , grucodigo = $grupo WHERE sbgcodigo = $subgrupo ");
                        //$edit_6  = mysqli_query($conn, "UPDATE btygrupo SET grucodigo = $grupo WHERE grucodigo = $grupo ");
                    }
                    
                }
            }
        }
    }


    }else{

    if ($_FILES['file_edit']['name'] == "") {

        $id               = $_POST['idprod'];
        $idcaract         = $_POST['idcarac'];
        $idimpuesto       = $_POST['impuesto'];
        $idunimedida      = $_POST['unimedida'];
        $cod_ant          = $_POST['txt_cod_anterior'];
        $producto         = $_POST['txt_nombre'];
        $descrip          = $_POST['txt_descripcion'];
        $alias            = $_POST['txt_alias'];
        $precio_fijo      = $_POST['precio_fijo'];
        $control_ven      = $_POST['control_ven'];
        $porcionado       = $_POST['porcionado'];
        $tipo_comi        = $_POST['tipo_comision'];
        $comision         = $_POST['comision'];
        $activo           = $_POST['activo'];
        $costo_inicial    = $_POST['costo_inicial'];

        $grupo            = $_POST['idgrupo'];
        $subgrupo         = $_POST['subgrupo_edit'];
        $linea            = $_POST['linea_edit'];
        $sublinea         = $_POST['sublinea_edit'];
        $caract           = $_POST['caract_edit'];



if (empty($porcionado)) {
        $porcionado = 0;
    }else{
       $porcionado=$porcionado;
    }

if (empty($precio_fijo)) {
        $precio_fijo = 0;
    }else{
       $precio_fijo=$precio_fijo;
    }

if (empty($activo)) {
        $activo = 0;
    }else{
       $activo=$activo;
    }

if (empty($control_ven)) {
        $control_ven = 0;
    }else{
       $control_ven=$control_ven;
    }



    $cons = mysqli_query($conn, "UPDATE btyproducto SET crscodigo = $idcaract, imvcodigo = $idimpuesto, umecodigo = $idunimedida, procodigoanterior = $cod_ant, pronombre = '".strtoupper($producto)."', prodescripcion = '".strtoupper($descrip)."', proimagen = 'default.jpg', proalias = '".strtoupper($alias)."', propreciofijo = $precio_fijo, procontrolvencimiento = $control_ven, proporcionado = $porcionado, protipocomision = '$tipo_comi', procomision = $comision, proultactualizacion = CURDATE(), proactivo = $activo, procostoinicial = $costo_inicial WHERE procodigo = $id ")or die(mysqli_error($conn));
                    if ($cons) {
                        echo 4;
                    }
        }
    }

    $consulta = mysqli_query($conn, "SELECT car.crscodigo, sbl.sblcodigo, lin.lincodigo, sgr.sbgcodigo, gru.grucodigo FROM btyproducto pro
JOIN btycaracteristica car ON pro.crscodigo=car.crscodigo JOIN btysublinea sbl ON sbl.sblcodigo=car.sblcodigo JOIN btylinea lin ON lin.lincodigo=sbl.lincodigo JOIN btysubgrupo sgr ON lin.sbgcodigo=sgr.sbgcodigo JOIN btygrupo gru ON sgr.grucodigo=gru.grucodigo WHERE pro.procodigo = $id");

    $fila = mysqli_fetch_array($consulta);

    if ($fila['crscodigo'] != $caract) {
         $edit_1  = mysqli_query($conn, "UPDATE btyproducto SET crscodigo = $caract WHERE procodigo = $id ");

    }else{
        if ($fila['sblcodigo'] != $sublinea) {
            $edit_2  = mysqli_query($conn, "UPDATE btycaracteristica SET crscodigo = $caract, sblcodigo = $sublinea WHERE crscodigo = $caract");           
        }else{
            if ($fila['lincodigo'] != $linea) {
                $edit_3  = mysqli_query($conn, "UPDATE btysublinea SET sblcodigo = $sublinea, lincodigo = $linea WHERE sblcodigo = $sublinea ");                
            }else{
                if ($fila['sbgcodigo'] != $subgrupo ) {
                    $edit_4  = mysqli_query($conn, "UPDATE btylinea SET lincodigo = $linea, sbgcodigo = $subgrupo  WHERE lincodigo = $linea "); 
                }else{
                    if ($fila['grucodigo'] != $grupo) {
                        $edit_5  = mysqli_query($conn, "UPDATE btysubgrupo SET sbgcodigo = $subgrupo , grucodigo = $grupo WHERE sbgcodigo = $subgrupo ");
                        $edit_6  = mysqli_query($conn, "UPDATE btygrupo SET grucodigo = $grupo WHERE grucodigo = $grupo ");
                    }
                    
                }
            }
        }
    }

    mysqli_close($conn);


 ?>

       
        