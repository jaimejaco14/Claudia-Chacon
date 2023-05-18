<?php
include 'conexion.php';
include 'head.php';
include "librerias_js.php";
?>

<!-- Main Wrapper -->


<div id="">

      <div class="small-header">
        <div class="hpanel">
            <div class="panel-body">
                <div id="hbreadcrumb" class="pull-right">
                    <ol class="hbreadcrumb breadcrumb">
                        <li><a href="index.php">Inicio</a></li>
                        <li class="active">
                            <span>Biometrico</span>
                        </li>
                        <li class="active">
                            <span>Cargar CSV</span>
                        </li>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    Cargar Archivo CSV
                </h2>
            </div>
        </div>
    </div>

<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">
                <div class="panel-body">

                    <div class="text-center m-b-md" id="wizardControl">

                        <a class="btn btn-default" href="leercsv.php" id="p1" data-toggle="tooltip" data-placement="top" title="Click para regresar"><span class="fa fa-angle-double-left"></span> Paso 1 - Cargar archivo</a>
                        <a class="btn btn-primary btnpasos" id="p2">Paso 2 - Detalles del archivo</a>
                        <a class="btn btn-default" id="p3">Paso 3 - Resultado</a>
                    </div>

                    <div class="tab-content">
                      <div id="step1" class="p-m tab-pane"></div>
                      <div id="step2" class="p-m tab-pane active">
                          
                              <div class="col-xs-12">
                     
                            <div class="col-md-12">
              <div class="row" style="display:none;">
              <h4>En caso de encontrar errores, se resaltarán en amarillo.</h4><br>
                  <div class="col-lg-12">                           
                    <?php

                            $tipo = $_FILES['archivoCSV']['type'];
                            $html="";
                            $tamanio = $_FILES['archivoCSV']['size']; 
                            $archivotmp = $_FILES['archivoCSV']['tmp_name'];
                            $lineas = file($archivotmp);


function comprobar_csv($archivo) {
  $n = 0;
  
  $fh = @fopen($archivo, 'r');
  if ($fh === false) {
    /* Decidir qué hacer en caso de error de apertura */
    return false;
  }
  while (($datos = fgetcsv($fh, 1000, ',')) !== false && ++$n) {
    /* En caso de no tener 6 campos cerramos y salimos */
    if (count($datos) != 6) {
      fclose($fh);
      return false;
    }
  }
  fclose($fh);
  /* Comprobamos que tenga al menos una línea */
  return $n > 0;
}




if(comprobar_csv($archivotmp)){

  $i=0;
  $sincod=0;
  $normal=0;
  $errtipo=0;

  $html.='
                        <table class="table table-bordered table-hover" id="tbl_csv">
                            <thead>
                            <tr>
                              <th colspan="8" class="text-center">ERRORES EN EL ARCHIVO CSV 
                              </th>
                            </tr>
                                <tr>
                                  <th class="text-center">COD BIOMÉTRICO</th>
                                  <th class="text-center">COD COLABORADOR</th>
                                  <th class="text-center">TIPO DE REGISTRO</th>
                                  <th class="text-center">FECHA</th>
                                  <th class="text-center">HORA</th>
                                  <th class="text-center">SALÓN</th>
                                  <th class="text-center">COD SALÓN</th>
                                  <th class="text-center">ERROR ENCONTRADO</th>
                                </tr>
                            </thead>
                            <tbody>'; 

                        $conterr=0;
                        
                        foreach ($lineas as $linea_num => $linea)
                        { 
                             $style="display:none;";
                             $tipo_correccion="";
                             $tipo_c="";
                             $tipo_err="";

                            if($i != 0) 
                            { 

                                  $datos       = explode(",",$linea);                                     
                                  $codigo      = utf8_encode($datos[0]);
                                  $fecha       = $datos[2];
                                  $nombrecol   = utf8_encode($datos[1]);
                                  $fecha_eve   = str_replace("/","-", $fecha);                                

                                  $fecha       = date_format(date_create(substr($fecha_eve,0, 10)), 'Y-m-d');

                                  $e5          = substr($fecha_eve, -5);
                                  $e9          = substr($se,0, 1);
                                 
                                  switch ($e5) {//a. m.
                                    case 'a. m.':
                                      $mer = 'am';
                                      break;

                                    case 'p. m.':
                                      $mer = 'pm';
                                      break;
                                    
                                    default:
                                      $mer="";
                                      break;
                                  }

                                  $hora        = date_format(date_create(substr($fecha_eve,11,8).' '.$mer),"H:i:s"); 
                                  $tipo        = strtoupper(utf8_encode($datos[3]));

                                  if(($tipo==null)||($tipo=='')){
                                    $tipo_correccion="tipo no definido";
                                    $style="";
                                  }
                                  //opcion para definir automaticamente todas las entrada/salida en funcion de la hora
                                  if($hora<'12:00:00'){
                                    $tipo_c='ENTRADA';
                                    if($tipo=="SALIDA"){
                                      $conterr++;
                                      $tipo_err=1;
                                      $tipo_correccion="MAL USO DEL BIOMETRICO (Corregido)";
                                      $style="";
                                    }
                                    else if($tipo==""){
                                      $conterr++;
                                      $tipo_err=1;
                                      $tipo_correccion="TIPO DE REGISTRO NO DEFINIDO (Corregido)";
                                      $style="";
                                    }
                                    else{
                                      $tipo_err=0;
                                      $tipo_correccion="NORMAL";
                                    }
                                  }
                                  else if ($hora>'15:00:00'){
                                    $tipo_c='SALIDA';
                                    if($tipo=="ENTRADA"){
                                      $conterr++;
                                      $tipo_err=1;
                                      $tipo_correccion="MAL USO DEL BIOMETRICO (Corregido)";
                                      $style="";
                                    }
                                    else if($tipo==""){
                                      $conterr++;
                                      $tipo_err=1;
                                      $tipo_correccion="TIPO DE REGISTRO NO DEFINIDO (Corregido)";
                                      $style="";
                                    }
                                    else{
                                      $tipo_err=0;
                                      $tipo_correccion="NORMAL";
                                    }
                                  }
                                  else{
                                    $tipo_c=$tipo;
                                    $tipo_err=0;
                                    $tipo_correccion="NORMAL";
                                  }               
                                  $salon       = utf8_encode($datos[4]);
                                  switch ($salon) 
                                  {
                                    case 'AMERICANO':
                                      $codSalon = 1;
                                      break;

                                    case 'JUMBO BUENAVISTA 2':
                                      $codSalon = 2;
                                      break;

                                    case 'MIRAMAR':
                                      $codSalon = 3;
                                      break;

                                    case 'SAO 93':
                                      $codSalon = 4;
                                      break;

                                    case 'EXITO 77':
                                      $codSalon = 5;
                                      break;

                                    case ' METRO SAN FRANCISCO':
                                      $codSalon = 6;
                                      break;

                                    case 'JUMBO PRADO':
                                      $codSalon = 7;
                                      break;

                                    case 'EXITO BUENAVISTA 1':
                                      $codSalon = 8;
                                      break;

                                    case 'PLAZA DEL PARQUE':
                                      $codSalon = 9;
                                      break;

                                    case 'VIVA BARRANQUILLA':
                                      $codSalon = 10;
                                      break;                                        

                                    case 'VILLA CAROLINA':
                                      $codSalon = 11;
                                      break;
                                    
                                    default:
                                       $codSalon ="";
                                      break;
                                  }

                                      $sd = mysqli_query($conn, "SELECT a.clbcodigoswbiometrico, a.clbcodigo FROM btycolaborador a JOIN btytercero b ON a.trcdocumento=b.trcdocumento WHERE clbcodigoswbiometrico =$codigo AND a.trcdocumento=b.trcdocumento AND a.tdicodigo=b.tdicodigo");
                                      $rows = mysqli_fetch_array($sd);
                                      if ($rows['clbcodigo'] == null || $rows['clbcodigo'] == "" || ($tipo==null) || ($tipo=='')) {
                                        $style="";
                                      }

                                   $html.='
                                        <tr style='.$style.'>
                                            <td style="text-align: right">'.$codigo.'</td>';
                                                  
                                               
                                                  if ($rows['clbcodigo'] == null || $rows['clbcodigo'] == "") 
                                                  {
                                                      $sincod++;
                                                      //$html.='<td style="text-align: right">'.$nombrecol.'</td>';
                                                      $html.='<td style="text-align: right;background-color:#ffff99;color:red;"><br><small>'.$nombrecol.'</small></td>';
                                                      $tipo_correccion="COLABORADOR SIN CODIGO EN BEAUTY";
                                                  }
                                                  else
                                                  {
                                                      //$normal++;
                                                       $html.='<td style="text-align: right;">'.$rows['clbcodigo'].'</td>';
                                                  }                                                  
                                                                                                                                  
                                                 
                                                    $html.='<td>'.$tipo.'</td>';
                                                  
                                                  


                                                 $html.='<td>'.$fecha.'</td>
                                                  <td>'.$hora.'</td>
                                                  <td>'.$salon.'</td>
                                                  <td style="text-align: right">'.$codSalon.'</td>
                                                  <td style="display:none;">'.$tipo_c.'</td>
                                                  <td style="display:none;">'.$tipo_err.'</td>
                                                  <td style="text-align: right;background-color:#ffff99;color:red;">'.$tipo_correccion.'</td>
                                        </tr>
                                   ';   
                              }

                                  $i++;  
                        }

  $html.='
    <tbody>
    </table>
    <br>
    
  ';

  //echo $html;
  $normal=$i-$errtipo-$sincod-1;
                ?>
  </div>
    </div>
  <div id="opciones">

          <?php
          if($i>0){?>

              <h2 class="text-center"><span class="fa fa-check" style="color:green;"></span>Archivo listo para procesar</h2>
              <h3 class="text-center">Registros encontrados:  <?php echo $i-1;?>.</h3><br>
              <!-- <h5><?php echo $normal;?> registros se insertarán correctamente.</h5><br>
              <h5 style="color:orange;"><i class="fa fa-warning"> </i> En <?php echo $conterr;?> registros se detectó mal uso del biométrico.<br>
              El tipo de registro (entrada o salida) fué corregido automaticamente.</h5><br> -->
              <?php
                if($sincod>0){
              ?>

                  <!-- <h5 style="color:red;"><i class="fa fa-ban"> </i> <?php echo $sincod;?> registros NO tienen codigo de colaborador en el sistema y por lo tanto NO se guardarán.</h5><small><b>pulse "ver registros con errores" para ver los errores</b></small><br><br> -->
              <?php
                }
              ?>
              <?php
                if($errtipo>0){
              ?>
                  <!-- <h5 style="color:orange;"><i class="fa fa-warning"> </i> <?php echo $errtipo;?> registros NO tienen definida entrada o salida.<br>debe editarlos antes de guardarlos. si no edita estos registros No se guardarán</h5>
                  <small><b>pulse "ver registros con errores" para editar los registros con errores.</b></small><br><br> -->
              <?php
                }
              ?>
                 <?php
                    if(($errtipo>0)||($sincod>0)){
                      $style4="";
                    }else{
                      $style4="display:none;";
                    }
                  ?>
                  
              <!-- <button class="btn btn-warning" id="verreg" style="<?php echo $style4;?>">Ver registros con errores</button>
              <button class="btn" id="ocultab" style="display: none;">Ocultar registros con errores</button> -->

              
          <?php
          }else{?>
              <h2>No se encontraron registros para insertar, intentelo nuevamente</h2><br>
              
          <?php
          }
          ?>
          <h2 id="dummy" class="text-right"><i class="fa fa-spinner fa-spin"></i> preparando...</h2>
          <button style="display:none;" class="btn btn-info pull-right" id="btn_insert" data-toggle="tooltip" data-placement="top" title="Procesar"><span class="fa fa-chevron-circle-right" style="font-size: 44px;"></span></button>
        </div>
        <div id="tabla1" style="display: none;"><br><br><br>
        <?php echo $html;?>
        <!-- <h4 id="instrucciones">Para guardar los registros pulse el botón "Insertar registros".</h4>
        <button class="btn btn-info btn-lg" id="btn_insert">Insertar registros</button> -->
        </div>

        </div>
        <div id="loading" style="display:none;">


            <center>
            <h2 id="insmsje">Insertando registros...</h2><br>
            <style>
            /*style para la animacion del engranaje pequeño en reversa*/

                .fa-spin2 {
                  transform: scaleX(-1);
                  animation: spin-reverse 2s infinite linear;
                }
                @keyframes spin-reverse {
                  0% {
                    transform: scaleX(-1) rotate(-360deg);
                  }
                  100% {
                    transform: scaleX(-1) rotate(0deg);
                  }
                }
            </style>
            <i class="fa fa-cog fa-spin" style="font-size:150px;color:lightblue"></i><i class="fa fa-cog fa-spin2" style="font-size:75px;color:#FA9B3C"></i>
            <br><i class="fa fa-cog fa-spin2" style="font-size:75px;color:#FFFF99;margin-top: -10px !important;"></i>
            <br>
            </center>
        </div>
        <div id="successful" style="display:none;">
          <br>  
            <h3 class="text-center"><span class="fa fa-info-circle text-info"></span> Ha finalizado la carga del archivo CSV</h3>
        </div><br>
        <!-- <h4 id="detalle"></h4> -->
        <div class="col-md-12" id="divtbinfo" style="font-size: large;display:none;">
        <div class="row">
          <div class="col-md-4 col-md-push-4">
            <table class="table table-striped" id="tbinfo" >
              <thead>
                <tr>
                  <th class="text-center">Registros</th>
                  <th class="text-center">Cantidad</th>
                </tr>  
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          </div>
          <div class="row">
            <!-- <h4 id="msjdupli" class="text-center">Algunos registros NO pudieron ser guardados por tener errores. Pulse 'Ver errores' para saber mas...</h4> -->
            <!-- <a href="#" class="btn btn-warning pull-right" id="verdupli" data-toggle="modal" data-target="#modalErrores">Ver errores</a> -->
            </div>
        </div>
        <div id="errores" style="display:none;"><br>
            
            
            <br><br>
              

              <form id="FormExport" action="csv_excel.php" method="POST">
                <input type="hidden" id="datos" name="datos">
              </form>
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

    </div>
    </div>
</div>
<?php
}else{?>
</div>
          </div>
  <h2 class="text-center"><span class="fa fa-ban" style="color:red;"></span>ERROR!<br><br>  El archivo CSV que ha cargado NO cumple con el standar establecido. verifique su archivo e intentelo nuevamente</h2>
  <script>
    swal('ERROR','','error');
  </script>
<?php
}


?>

<!-- Modal -->
<div class="modal fade" id="modalErrores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-times-circle text-danger"></i> Registros con errores</h4>
      </div>
      <div class="modal-body">
        <table class="table table-hover table-bordered" id="tabdupli">
                <thead>
                <tr>
                  <th colspan="7" class="text-center">
                    
                  </th>
                </tr>
                  <tr>
                    <th>Colaborador</th>

                    <th>Tipo de error</th>
                  </tr>
                </thead>
                <tbody id="tbodydupli">
                  
                </tbody>

              </table>

              <button class="btn btn-default" id="expexcel" style="display: none;" data-toggle="tooltip" data-placement="right" title="Exportar a Excel"><span class="fa fa-file-excel-o" style="color:green;" ></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


                                  
                              
<script>
$("side-menu").children(".active").removeClass("active");  
$("#UTILIDADES").addClass("active");
$("#BIOMETRICO").addClass("active");
$(window).load(function() {
  deshabilitaRetroceso();
});
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
     $(document).ready(function() 
     {
        $('.normalheader').addClass('small-header');
        $("#btn_insert").show();
        $("#dummy").hide();

    });
  var indice = 0;
  frases = new Array();
    frases[0] = "Insertando Registros...";
    frases[1] = "Esta operación puede tardar dependiendo de la cantidad de registros a insertar.<br>Por favor espere...";
    frases[2] = "Los registros se están guardando. <br>Por favor espere...";
    frases[3] = "El procedimiento de inserción de registros continúa. <br>Por favor espere...";
    frases[4] = "Seguimos insertando los registros. <br>Por favor espere...";
    frases[5] = "Falta poco! <br>Por favor espere...";
    frases[6] = "Ya casi terminamos...";
    frases[7] = "En breve concluirá la operación.";
    frases[8] = "Inserción aún en progreso. <br>Por favor espere...";
    frases[9] = "Está tardando más de lo habitual, pero ya casi termina. <br>Por favor espere...";
  function rotar() {
    if (indice == 7) {indice = 0;}
    $("#insmsje").html(frases[indice]);
    indice++;
    setTimeout("rotar();",20000);
  }

$(document).ready(function() {
  
  
    $(document).on('click', '#btn_insert', function() 
    { 
      $("#btn_insert").hide();
      var count=0;
        var datos = [];
        $('#tbl_csv tbody tr').each(function () { 
                  var itemCom = {};
                  
                  var tds = $(this).find("td");
                  itemCom.codbio    = tds.filter(":eq(0)").text();
                  itemCom.codcol    = tds.filter(":eq(1)").text();
                  itemCom.tipo      = tds.filter(":eq(2)").text();
                  itemCom.fecha     = tds.filter(":eq(3)").text();
                  itemCom.hora      = tds.filter(":eq(4)").text();
                  itemCom.codsal    = tds.filter(":eq(6)").text();
                  itemCom.esnuevo    = tds.filter(":eq(7)").text();
                  itemCom.eserror    = tds.filter(":eq(8)").text();
                  itemCom.esdetalleerror    = tds.filter(":eq(9)").text();
                  datos.push(itemCom);
                  count++; 
        });
        //console.log("enviados="+count);
        var data = JSON.stringify(datos);
        //console.log(data);
        $("#tabla1").hide();
        $("#opciones").hide();
        $("#loading").show();
        $("#p1").removeAttr('href');
        rotar();
        $.ajax({
            url: 'biometrico/guardarRepBiometrico.php',
            method: 'POST',
            data: {datos:data},
            beforeSend: function() 
            {
              $.blockUI({ message: null });
            },
            success: function (res) 
            {
              //console.log(res);
              
              $("#loading").hide();
              $("#divtbinfo").fadeIn();
              var data=JSON.parse(res);
              if (data.RES=="TRUE") 
              {
                //swal("Operación Ejecutada", "Todos los registros se insertaron exitosamente", "success");
                console.log("insertados="+data.TINS);
                console.log("recibidos="+data.TAM);
                $("#p2").removeClass('btn-primary');
                $("#p2").addClass('btn-default');
                $("#p3").removeClass('btn-default');
                $("#p3").addClass('btn-primary');
                //$("#detalle").html('<i class="fa fa-check" style="color:green;"></i> Todos los registros se insertaron correctamente.');
                $("#tbinfo").append('<tr><td><i class="fa fa-check" style="color:green;"></i><b> Insertados: </b></td><td class="text-center">'+data.TINS+'</td></tr>');
              }
              else if (data.RES=="FALSE") 
              {
                //swal("Operación ejecutada","Registros nuevos guardados: "+data.TINS+"\n"+"Registros actualizados: "+data.ACTU+"\n"+"Registros con errores: "+data.ERR,"success");
                $("#p2").removeClass('btn-primary');
                $("#p2").addClass('btn-default');
                $("#p3").removeClass('btn-default');
                $("#p3").addClass('btn-primary');
                if(data.VECERR!=''){
                  tabla(data.VECERR);
                }
                
                //$("#detalle").html("<i class='fa fa-check' style='color:green;'></i> Se insertaron "+data.TINS+" registros nuevos<br><i class='fa fa-refresh' style='color:blue;'></i> "+data.ACTU+" registros ya existen y NO se insertaron.<br><i class='fa fa-ban' style='color:red;'></i> Se encontraron "+data.ERR+" registros con errores.");

                $("#tbinfo").append('<tr><td><i class="fa fa-check" style="color:green;"></i><b> Insertados: </b></td><td class="text-center">'+data.TINS+'</td></tr>');
                $("#tbinfo").append('<tr><td><i class="fa fa-refresh" style="color:blue;"></i><b> Existentes: </b></td><td class="text-center">'+data.ACTU+'</td></tr>');
                $("#tbinfo").append('<tr><td><i class="fa fa-times-circle" style="color:red;"><a id="verdupli" data-toggle="modal" data-target="#modalErrores" data-toggle="tooltip" data-placement="left" title="Click para ver errores"></i><b> Errores:  </b></td><td class="text-center">'+data.ERR+'</a></td></tr>');
                if(data.ERR>0){
                    $("#errores").fadeIn();
                }
                
                console.log("recibidos="+data.TAM);
                console.log("insertados="+data.TINS);
                console.log("actualizados="+data.ACTU);
                console.log("ERRORES="+data.ERR);
              }
              else if(data.RES=="ERROR")
              {
                swal("NO SE GUARDÓ NINGÚN REGISTRO!","Registros nuevos guardados: "+data.TINS+"\n"+"Registros actualizados: "+data.ACTU+"\n"+"Registros con errores: "+data.ERR,"error");
              }
              $(document).ajaxStop($.unblockUI);
              $("#p1").attr('href','leercsv.php');
              $("#successful").show();
            }
        }).fail( function( jqXHR, textStatus, errorThrown ) {
          $(document).ajaxStop($.unblockUI);
          $("#loading").hide();
          $("#successful").html('');
          $("#successful").append('<h2 class="text-center"><i class="fa fa-frown-o"></i><br>Ha ocurrido un error, recargue la página e intentelo nuevamente</h2>');
          $("#successful").show();
      });
    });
    $("#verreg").click(function(e){
      e.preventDefault();
        $("#tabla1").show();
        $("#verreg").hide();
        $("#ocultab").show();
    });
    $("#ocultab").click(function(e){
      e.preventDefault();
        $("#tabla1").hide();
        $("#verreg").show();
        $("#ocultab").hide();
    });
    $("#verdupli").click(function(e){
      e.preventDefault();
      //$("#msjdupli").hide();
      //$("#detalle").show();
      $("#tabdupli").fadeIn();
      //$(this).hide();
      $("#modalErrores").show();
      $("#expexcel").show();
    });
    $("#expexcel").click(function(e){
      $("#datos").val( $("<div>").append( $("#tabdupli").eq(0).clone()).html());
      $("#FormExport").submit();
      $("#errores").hide();
    });

    $(document).on({
          mouseenter: function () {
              $("#p1").removeClass('btn-default');
              $("#p1").addClass('btn-info');
          },
          mouseleave: function () {
              $("#p1").removeClass('btn-info');
              $("#p1").addClass('btn-default');
        }
    }, "#p1");
});


$(".cambest").change(function(e){
  var este=$(this).find('option:selected').text();
  $(this).val('0');
  $(this).parents("tr").find("td").eq(2).html(este);
  $(this).parents("tr").find("td").css("background-color", "");;
});


function tabla(array){

    for(var i in array) {
          $("#tbodydupli").append(
          "<tr><td>"+array[i][0]+

          "</td><td>"+array[i][3]+
          "</td></tr>"
          );
    }
  
}
function deshabilitaRetroceso(){
    //window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="no-back-button";}
}

  
    /*******************************************************************************************/
    $(".btnpasos").bind('click', false);
    $(".prevnext").bind('click', false);


/******************************************************************************************************/


    
</script>

</body>
</html>