<?php
include("./head.php");
    include '../cnx_data.php';
    VerificarPrivilegio("PROVEEDORES", $_SESSION['tipo_u'], $conn);
?>
<?php include "librerias_js.php"; ?>
        
           <div class="col-lg-8 col-lg-offset-2" id="datostercero" >
                <div class="hpanel">
                    <div class="panel-heading">
                        <div class="panel-tools">
                            <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                        </div>
                        Crear Proveedor
                    </div>
                    <div class="panel-body list">
                    <form id=" mi_form"> 
                         <div>
                          <br> <label>Documento</label>
                            <input  type="text"  id="idbq" class="form-control" >   
                          <br>
                        </div>
                           <div id="contenidoedit">
                           <!--  para mostrar los campos cuando sean encontrados por el documento que se digito  -->
                             <?php include"adicion_prove.php"; ?>
                              <!--  el boton de abajo adiciona un proveedor en caso de que se haya una coincidencia detercero  existente   -->
                                <button  id="bsq" name="bsq" class="btn btn-success pull-right" onclick="adcionprov($('#correoprv').val(), $('#idbq').val(),$('#tipo_doc').val())">
                                            Guardar
                                        </button>
                                        <!--  el boton de abajo adiciona un proveedor en caso de que el documento no se encuentre registardo como tercero  -->
                                        <button style="display: none" id="nuevog" name="nuevog" class="btn btn-success pull-right" onclick="addciones($('#idbq').val(),$('#tipo_doc').val(),$('#correoprv').val(), null, null, $('#dep').val(),$('#ciudad').val(), $('#barrio').val(),$('#direccion').val(), $('#telefono_movil').val(),$('#telefono_fijo').val(), $('#rzscl').val());">
                                            Guardar
                                        </button>
                                        </div>
                </div>
            </div>
            </div>
             
                                            
                                                
                                                
                                             
                                              
                                            
                                      


  <?php

 ?> 
    


<!-- Vendor scripts -->
<script type="text/javascript">
  $("#side-menu").children(".active").removeClass("active");  
  $("#INVENTARIO").addClass("active");
   $("#PROVEEDORES").addClass("active");
  $('.fecha').datetimepicker({
    format: "YYYY-MM-DD",
            locale: "es",
  });
</script>
<script>
//esta es la funcion para enviar los datos digitados en la seccion de documentos

window.onload = function() {
    document.getElementById("idbq").focus();
};
 $(document).ready(function() {

$('#idbq').keyup(function(){
    var user = $(this).val();        
        var dataString = 'no_documento='+user;
    $.ajax({
        type: "POST",
        url: "check_user_prove.php",
        data: dataString,
     success: function(data) {
                  console.log(data);
                  if (data=='EXIST') {
                    mostrard(user, 1);
                  }else if(data=='PROVEDOR'){
                    mostrard(user, 0);
                  }else if(data=='NOEXIST'){
                    mostrard(user, 2);

                          }
                 }
             });
});
});
 //esta funcion transfiere los datos el archivo adicon prove quien valida y muestra los datos en el respectivo campo
function mostrard(id, e) {
    $.ajax({
        type: "POST",
        url: "adicion_prove.php",
        data: {dni: id, exist: e}
    }).done(function (html) {
        $('#contenidoedit').html(html);
    }).fail(function () {
        alert('Error al cargar modulo');
    });
}
//esat funcion guarda los terceros que no se encontraron en la base de datos y se desean guardar como proveedores 
function addciones(docu,tipo,corr,nom,ape,dep,ciud,barr,direc,telm,telf,rz) {
 if (docu=="" || (tipo==1 && rz=="") || (tipo>=2 && ape=="" || nom=="") || corr=="" ||  dep=="" || ciud=="" || barr=="" || telm =="" & telf=="")
 {
        swal("¡No deje campos vacios!");
 }else{

    $.ajax({
        type: "POST",
        url: "insert_prove.php",
        data: { doc: docu, typo:tipo, correo: corr, nombre: nom, apellido: ape, barri:barr, direccion:direc, telmovil:telm, telfijo:telf, razon:rz},
         success: function(data) {
             if (data=='TRUETRUE') {
                 swal("Guardado correctamente");
                location.reload();
             }else{
               swal('error','Hubo una inconsistencia, no se pudo agregar el provedor '); 
             }
              
            }
    });
  }
}
// esta funcion adiciona los proveedores donde ya hay terceros existentes
 function adcionprov (coreo,doc,tip) {
    if (coreo =="" || doc=="") {
        swal('Por favor no deje campos vacios');
    }else{
        $.ajax({
            type: "POST",
            url: "insert_prove_ex.php",
            data: {correo: coreo, docu:doc, typo:tip},
            success: function(data) {
                if (data=='TRUE') {
                    swal("Guardado correctamente");
                    location.reload();
                }else {
                    swal('error','Hubo una inconsistencia, no se pudo agregar el provedor ');
                }
            }
        });
    }
}
//cambia los departamentos 
    $('#dep').change(function(){
        var depa = $(this).val();
        var depart = 'ciudad='+depa;
        $.ajax({
            type: "POST",
            url: "buscar_ciudad.php",
            data: depart,
            success: function(data) {
                $('#ciudad').html(data);
                brr ();
            }
        });
    });
//las ciudaddes
    $('#ciudad').change(function(){
        brr ();
    });
    function brr () {
        var cod_brr = $('#ciudad').val();
        var brr = 'barrio='+cod_brr;
        $.ajax({
            type: "POST",
            url: "buscar_barrio.php",
            data: brr,
            success: function(data) {
                $('#barrio').html(data);
            }
        });
    }
    //cambia el imput de tipo de tercero, por empresa o persona en el respectivo caso de en que lo dicte tipo de documento
    $('#tipo_doc').change(function(){
        if ($('#tipo_doc').val()!="") {

            if ($('#tipo_doc').val()==1) {
                $('#tipot').val('Empresa');
                $('#divnom').hide();
                $('#divape').hide();
                $('#divrz').show();
            }else{
                 $('#tipot').val('Persona');
                 $('#divnom').show();
                $('#divape').show();
                $('#divrz').hide();
            }
        }else{
            $('#tipot').val('');
        }
       
    });
</script>