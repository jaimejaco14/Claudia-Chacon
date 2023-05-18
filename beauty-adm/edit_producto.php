<?php 
include '../cnx_data.php';

$id = $_POST['cod_prod'];
//print_r($_POST);
$array=array();

$sql=mysqli_query($conn,"SELECT *, IF(pro.proporcionado = 1, '1','0') AS porcionado, IF(pro.proimagen = 'default.jpg', '../contenidos/imagenes/default.jpg', CONCAT('../contenidos/imagenes/producto/', pro.proimagen)) as imagen, car.crsnombre, car.crscodigo, sli.sblnombre, lin.linnombre, sgr.sbgnombre, gru.grunombre,gru.grucodigo,sgr.sbgcodigo, lin.lincodigo, sli.sblcodigo, imp.imvnombre, uni.umenombre, pro.procostoinicial FROM btyproducto pro JOIN btycaracteristica car ON pro.crscodigo=car.crscodigo
JOIN btysublinea sli ON car.sblcodigo=sli.sblcodigo JOIN btylinea lin ON sli.lincodigo=lin.lincodigo JOIN btysubgrupo sgr ON lin.sbgcodigo=sgr.sbgcodigo JOIN btygrupo gru ON sgr.grucodigo=gru.grucodigo JOIN btyimpuesto_ventas imp ON pro.imvcodigo=imp.imvcodigo JOIN btyunidad_medida uni ON pro.umecodigo=uni.umecodigo WHERE procodigo = $id AND proestado = 1")or die(mysqli_error($conn));

if (mysqli_num_rows($sql) > 0) {
    while ($row = mysqli_fetch_object($sql)) {
        $array[] = array(
            'producto'    => $row->pronombre,
            'pro_codigo'  => $row->procodigo,
            'descripcion' => $row->prodescripcion,
            'imagen'      => $row->imagen,
            'alias'       => $row->proalias,
            'cod_anter'   => $row->procodigoanterior,
            'preciof'     => $row->propreciofijo,
            'ctrl_venc'   => $row->procontrolvencimiento,
            'porcionado'  => $row->porcionado,
            'tipo_comis'  => $row->protipocomision,
            'comision'    => $row->procomision,
            'creacion'    => $row->procreacion,
            'actualiz'    => $row->proultactualizacion,
            'activo'      => $row->proactivo,
            'estado'      => $row->proestado,
            'caract'      => $row->crsnombre,
            'cod_carac'   => $row->crscodigo,
            'linea'       => $row->linnombre,
            'cod_line'    => $row->lincodigo,           
            'sublinea'    => $row->sblnombre,
            'cod_subline' => $row->sblcodigo,
            'subgrupo'    => $row->sbgnombre,
            'cod_subgru'  => $row->sbgcodigo,
            'grupo'       => $row->grunombre,
            'cod_grupo'   => $row->grucodigo,
            'impuesto'    => $row->imvnombre,
            'cod_impue'   => $row->imvcodigo,
            'unimedida'   => $row->umenombre,
            'cod_unimed'  => $row->umecodigo,
            'costo_ini'   => $row->procostoinicial

        );
    }


    echo json_encode($array);
}else{
    $array[] = array('info' => 'No hay datos disponibles');
    echo json_encode($array);
}


mysqli_close($conn);

 
 ?>