

<?php 
include '../cnx_data.php';

$id_cliente = $_POST['id_cliente'];
  $result = $conn->query("SELECT c.trcdocumento, tdi.tdialias, t.trcdigitoverificacion, t.trcrazonsocial, c.clifechanacimiento, c.clifecharegistro, c.cliempresa, t.trcnombres, t.trcapellidos, o.ocunombre, c.clisexo, tdi.tdinombre, brr.brrnombre, l.locnombre, d.depombre, t.brrcodigo, l.loccodigo, d.depcodigo, t.trcdireccion, t.trctelefonofijo, t.trctelefonomovil, c.cliemail, c.clinotificacionemail, c.clinotificacionmovil FROM btycliente c INNER JOIN btytercero t ON t.trcdocumento = c.trcdocumento INNER JOIN btyocupacion o ON c.ocucodigo = o.ocucodigo INNER JOIN btytipodocumento tdi ON tdi.tdicodigo = c.tdicodigo INNER JOIN btybarrio brr ON t.brrcodigo = brr.brrcodigo INNER JOIN btylocalidad l ON brr.loccodigo = l.loccodigo INNER JOIN btydepartamento d ON d.depcodigo = l.depcodigo where c.trcdocumento =".$id_cliente);
 if ($result->num_rows > 0) {
     $cont = 0;
     while ($row = $result->fetch_assoc()) {
        $cliempresa = $row['cliempresa'];
        $alias = $row['tdialias'];
        $id = $row['clicodigo'];
        $ocu = $row['ocunombre'];
        $nombres = $row['trcnombres'];
        $Apellidos = $row['trcapellidos'];
        $Razon = $row['trcrazonsocial'];
        $sexo = $row['clisexo'];
        $fecha = $row['clifechanacimiento'];
        $Documento = $row['trcdocumento'];
        if (($row['clinotificacionmovil'] == "S") and ($row['clinotificacionemail'] == "S") ) {
            # code...
            $noti = "Notificaciones activas al correo y movil.";
        } else if ($row['clinotificacionmovil'] == "S") {
            $noti = "Notificaciones activas solo para movil.";

        } else if ($row['clinotificacionemail'] == "S") {
            $noti = "Notificaciones activas solo para correo.";
        } else {
            echo "Notificaciones desactivadas.";
        }
        if ($row['cliempresa']== "S"){
             $type = '<span class="label pull-right" style="background: blue">EMPRESA</span>';
         } else {
             $type = '<span class="label pull-right" style="background: #c9ad7d" >Persona</span>';
         }
         echo '<div class="row"> 
    <div class="col-lg-4">
        <div class="hpanel '.$hpanel.' contact-panel">
        <button class="btn btn-warning regresar">Regresar</button>
            <div class="panel-body">
            '.$type.'

                <img alt="logo" class="img-circle m-b m-t-md" src="../contenidos/imagenes/default.jpg">
                <h3>'.$row['trcrazonsocial'].'</h3>
                <div class="text-muted font-bold m-b-xs">'.$row['brrnombre'].'</div> 
            </div>
            <div class="panel-body">
                <address>
                    <strong>Tel&eacute;fonos</strong><br>
                    Fijo: '.$row['trctelefonofijo'].'<br>
                    M&oacute;vil: '.$row['trctelefonomovil'].'<br><br>
                    <strong>E-mail: </strong><br>
                    '.$row['cliemail'].'<br><br>
                    <strong>Direcci&oacute;n: </strong><br>
                    '.$row['trcdireccion'].'<br><br>
                    <strong>Notificaciones: </strong><br>
                    '.$noti.'
                </address>
            </div>


        </div>
    </div> ';
}

}


if ($cliempresa ==  "N"){
echo '<div class="col-lg-8">
        <div class="hpanel">
            <div class="hpanel">
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">';

                        
                        //echo '<p><button class="btn btn-info" type="button" onclick="editar('.$id_cliente.');">Actualizar datos</button></p>';
                        echo '<p>
                        <a class="btn btn-info" type="button" href="nuevo_cliente.php?operacion=update&id_cliente='.$id_cliente.'">Actualizar datos</a>
                        </p>';
                        echo $row['tdialias'];
                        

                        echo '<div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>

                                    
                                    <th>T.D.I</th>
                                    <th>Documento</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Ocupaci&oacute;n</th>
                                    <th>Tipo</th>
                                    <th>Sexo</th>
                                    <th>F. Nacimiento</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <thead>
                                <tr>';
                                     echo '<td>'.$alias.'</td>
                                    <td>'.$Documento.'</td>
                                    <td>'.$nombres.'</td>
                                    <td>'.$Apellidos.'</td>
                                    <td>'.$ocu.'</td>
                                    <td>'.$type.'</td>
                                    <td>'.$sexo.'</td>
                                    <td>'.$fecha.'</td>';
                            echo '
                                </tr>
                                </thead>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>

<br>';

} else {

?>

<div class="col-lg-8">
        <div class="hpanel">
            <div class="hpanel">
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">

                        <?php 
                        echo '<p>
                                <a class="btn btn-info" type="button" href="nuevo_cliente.php?operacion=update&id_cliente='.$id_cliente.'">Actualizar datos</a>
                            </p>';
                        echo $row['tdialias'];
                        ?>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>

                                    
                                    <th>T.D.I </th>
                                    <th>Documento</th>
                                    <th>Raz&oacute;n social</th>
                                    <th>Tipo</th>
                                    <th>Sexo</th>
                                    <th>F. Nacimiento</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <thead>
                                <tr>
                                    <?php echo '<td>'.$alias.'</td>
                                    <td>'.$Documento.'</td>
                                    <td>'.$Razon.'</td>
                                    <td>'.$type.'</td>
                                    <td>'.$sexo.'</td>
                                    <td>'.$fecha.'</td>';
                                    ?>
                                </tr>
                                </thead>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>

<br>



<?php

}