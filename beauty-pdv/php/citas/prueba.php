<?php
    //header("Content-Type : Application/Json");
    include("../../../cnx_data.php");

    $salon = $_GET["salon"];

    $queryCitas = "SELECT citcodigo, clbcodigo, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btycolaborador colaborador  ON tercero.trcdocumento = colaborador.trcdocumento WHERE colaborador.clbcodigo = btycita.clbcodigo) AS clbnombre, slncodigo, (SELECT slnnombre FROM btysalon WHERE slncodigo = btycita.slncodigo) AS slnnombre, (SELECT slndireccion  FROM btysalon WHERE slncodigo = btycita.slncodigo) AS slndireccion, sercodigo, (SELECT sernombre FROM btyservicio WHERE sercodigo = btycita.sercodigo) AS sernombre, (SELECT serduracion FROM btyservicio WHERE sercodigo = btycita.sercodigo) AS serduracion, clicodigo, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btycliente cliente ON tercero.trcdocumento = cliente.trcdocumento WHERE cliente.clicodigo = btycita.clicodigo) AS clinombre, usucodigo, (SELECT tercero.trcrazonsocial FROM btytercero tercero INNER JOIN btyusuario usuario ON tercero.trcdocumento = usuario.trcdocumento WHERE usuario.usucodigo = btycita.usucodigo) AS usunombre, citfecha, cithora, citobservaciones, citfecharegistro, cithoraregistro FROM btycita WHERE slncodigo = 9";    


    $resultadoQueryCitas = $conn->query($queryCitas);

    if($resultadoQueryCitas != false)
    {

        if(mysqli_num_rows($resultadoQueryCitas) > 0)
        {

            $lol = array();

            while($registros = mysqli_fetch_array($resultadoQueryCitas))
            {

                $codEstado   = 0;
                $nomEstado   = "";

                $f = "SELECT btyestado_cita.esccodigo, btyestado_cita.escnombre FROM btynovedad_cita NATURAL JOIN btyestado_cita WHERE citcodigo = '".$registros["citcodigo"]."' AND citfecha = (SELECT MAX(citfecha) FROM btynovedad_cita WHERE citcodigo = '".$registros["citcodigo"]."') AND cithora = (SELECT MAX(cithora) FROM btynovedad_cita WHERE citcodigo = '".$registros["citcodigo"]."')";

                //echo $f;

                $resultQuery = mysqli_query($conn, $f)or die(mysqli_error($conn));

                while($registros2 = mysqli_fetch_array($resultQuery))
                {
                    $codEstado = $registros2["esccodigo"];
                    $nomEstado = $registros2["escnombre"];
                }

                $lol[] = array(
                                "codigo"         => $registros["citcodigo"],
                                "codColaborador" => $registros["clbcodigo"],
                                "colaborador"    => $registros["clbnombre"],
                                "codSalon"       => $registros["slncodigo"],
                                "salon"          => $registros["slnnombre"],
                                "direccionSalon" => $registros["slndireccion"],
                                "codServicio"    => $registros["sercodigo"],
                                "servicio"       => $registros["sernombre"],
                                "duracion"       => $registros["serduracion"],
                                "codCliente"     => $registros["clicodigo"],
                                "cliente"        => $registros["clinombre"],
                                "codUsuario"     => $registros["usucodigo"],
                                "usuario"        => $registros["usunombre"],
                                "fecha"          => $registros["citfecha"],
                                "hora"           => $registros["cithora"],
                                "observaciones"  => utf8_decode($registros["citobservaciones"]),
                                "fechaRegistro"  => $registros["citfecharegistro"],
                                "horaRegistro"   => $registros["cithoraregistro"],
                                "codEstado"      => $codEstado,
                                "nomEstado"      => $nomEstado);
            }
                echo json_encode(array("no es vacio" => "asi es"));

                echo json_encode(array("citas" => $lol));
        }
        else
        {
            echo json_encode(array("result" => "vacio"));
        }
    }
    else
    {
        echo json_encode(array("result" => "error"));
    }

    mysqli_close($conn);
?>