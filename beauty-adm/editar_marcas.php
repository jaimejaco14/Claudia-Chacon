
<?php


//include '../cnx_data.php';




  
  $mar_codigo=$_POST['marcodigo'];

  $query="SELECT * FROM btymarca_activo WHERE marcodigo='$mar_codigo'";
  $resultado = $conn->query($query);

 if ($resultado->num_rows > 0) {
             while ($row = $resultado->fetch_assoc()) { 

            $nom = $row["marnombre"];
            $idmarcodigo=$row['marcodigo'];


           

                 
             }
         }




         
?>







<div class="content animate-panel">

<div>

    

    <div class="row">
    <!-- formulario de  marcas-->

        <form role="form" name="form" method="post"  action="modi_marcas.php">
        <div class="col-lg-7">
        <div class="hpanel">
        <div class="panel-heading">
            <div class="panel-tools">
                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                <a class="closebox"><i class="fa fa-times"></i></a>
            </div>
            Datos de la marca
        </div>
        <div class="panel-body">

        <!-- formualrio marca
 -->
                                        
     <br>
       <div class="form-group ">
                                        
                                      
                                       <div class="form-inline">
                                       
                                            
                                        
                                        
                                        
                                    </div>
                                    </div>                                        


                                        
                                   
                            <div class="form-group">



                            <input type="text" hidden="true" name="idmarca" value="<?php echo $mar_codigo;?>">

                              <input type="text" hidden="true" name="frmgracodigo" value="<?php echo $testgracodigo;?>">

              <label>Nombre</label>


              <input class="form-control" id="nombres" name="nombres" maxlength="50" type="text" required value="<?php echo $nom; ?>"/>

                                                 


                            <label>Nombre</label>
                            <input  class="form-control" type="text" name="nombr" value="<?php echo $nom;?>">
                            <div class="help-block with-errors"></div>
                            </div>
                                    



                                   
                                    
                                    
                                    <button type="submit" id="guardar" name="guardar" class="btn btn-lg btn-success">
                                        Modificar Registro
                                    </button>
                                    
            
            
        </div>
        </div>
        </div>
        

        </form>
        
    </div>
    
    




</div>

    <!-- Right sidebar -->
    <div id="right-sidebar" class="animated fadeInRight">

        

    </div>
<!-- Footer-->
    <footer class="footer">
        <span class="pull-right">
            Example text
        </span>
        Company 2015-2020
    </footer>

</div>
<!-- Vendor scripts -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="vendor/iCheck/icheck.min.js"></script>
<script src="vendor/sparkline/index.js"></script>

<!-- App scripts -->
<script src="scripts/homer.js"></script>






<script type="text/javascript">
$(document).ready(function() {    
    $('#no_documento').blur(function(){

        $('#Info').html('<img src="loader.gif" alt="" />').fadeOut(1000);

        var username = $(this).val();        
        var dataString = 'no_documento='+username;

        $.ajax({
            type: "POST",
            url: "check_colaborador.php",
            data: dataString,
            success: function(data) {
                $('#Info').fadeIn(1000).html(data);
            }
        });
    });   
    
    
});    


</script>

<script>
jQuery('#dep').change(function () {
$('#barrio').find('option').remove().end();
var numero =document.getElementById("dep").value; // valor de la id de Provincias
//alert( "Handler for .change() called."+numero );
var poblacio = jQuery(this).attr("ciudadattri"); // este es el atributo que nos ayuda a encontrar la poblaci�n cuando modificamos  el contenido
//var to=document.getElementById("Buscando");//
//to.innerHTML="buscando....";
 var depart = 'ciudad='+numero;
jQuery.ajax({
type: "POST", 
url: "buscar_ciudad.php",
data: depart, // enviamos la id de la Porvincia + la id de la poblaci�n
success: function(a) {
jQuery('#ciudad').html(a);// el resultado de la busqueda la mostramos en  #poblacionList
//var to=document.getElementById("Buscando");
to.innerHTML="";

swbarrio();

//cambiar barrio tambien//
}
});
var numero1 =document.getElementById("ciudad").value; // valor de la id de Provincias
//alert( "Handler for .change() barrio called."+numero1 );
var poblacio = jQuery(this).attr("barrioattri"); // este es el atributo que nos ayuda a encontrar la poblaci�n cuando modificamos  el contenido
//var to=document.getElementById("Buscando");//
//to.innerHTML="buscando....";
 var ciudad = 'barrio='+numero1;
jQuery.ajax({
type: "POST", 
url: "buscar_barrio.php",
data: ciudad, // enviamos la id de la Porvincia + la id de la poblaci�n
success: function(a) {
jQuery('#barrio').html(a);// el resultado de la busqueda la mostramos en  #poblacionList
//var to=document.getElementById("Buscando");
to.innerHTML="";
}
});
})
.change();

</script> 
<script>
jQuery('#dep').blur(function () {
$('#barrio').find('option').remove().end();

var numero1 =document.getElementById("ciudad").value; // valor de la id de Provincias
//alert( "Handler for .change() barrio called."+numero1 );
var poblacio = jQuery(this).attr("barrioattri"); // este es el atributo que nos ayuda a encontrar la poblaci�n cuando modificamos  el contenido
//var to=document.getElementById("Buscando");//
//to.innerHTML="buscando....";
 var ciudad = 'barrio='+numero1;
jQuery.ajax({
type: "POST", 
url: "buscar_barrio.php",
data: ciudad, // enviamos la id de la Porvincia + la id de la poblaci�n
success: function(a) {
jQuery('#barrio').html(a);// el resultado de la busqueda la mostramos en  #poblacionList
//var to=document.getElementById("Buscando");
to.innerHTML="";
}
});
})
.change();
</script> 

 <script>
jQuery('#ciudad').change(function () {

var numero1 =document.getElementById("ciudad").value; // valor de la id de Provincias
//alert( "Handler for .change() barrio called."+numero1 );
var poblacio = jQuery(this).attr("barrioattri"); // este es el atributo que nos ayuda a encontrar la poblaci�n cuando modificamos  el contenido
//var to=document.getElementById("Buscando");//
//to.innerHTML="buscando....";
 var ciudad = 'barrio='+numero1;
jQuery.ajax({
type: "POST", 
url: "buscar_barrio.php",
data: ciudad, // enviamos la id de la Porvincia + la id de la poblaci�n
success: function(a) {
jQuery('#barrio').html(a);// el resultado de la busqueda la mostramos en  #poblacionList
//var to=document.getElementById("Buscando");
to.innerHTML="";
}
});
})
.change();

$(document).ready(function swbarrio() {

var numero1 =document.getElementById("ciudad").value; // valor de la id de Provincias
//alert( "Handler for .change() barrio called."+numero1 );
var poblacio = jQuery(this).attr("barrioattri"); // este es el atributo que nos ayuda a encontrar la poblaci�n cuando modificamos  el contenido
//var to=document.getElementById("Buscando");//
//to.innerHTML="buscando....";
 var ciudad = 'barrio='+numero1;
jQuery.ajax({
type: "POST", 
url: "buscar_barrio.php",
data: ciudad, // enviamos la id de la Porvincia + la id de la poblaci�n
success: function(a) {
jQuery('#barrio').html(a);// el resultado de la busqueda la mostramos en  #poblacionList
//var to=document.getElementById("Buscando");
to.innerHTML="";
}
});
});
</script>

<script type="text/javascript" language="javascript">
function validateform(){
var captcha_response = grecaptcha.getResponse();
if(captcha_response.length == 0)
{
    // Captcha is not Passed
    $("captcha").html("ldsfljf");
    return false;
     
}
else
{
    // Captcha is Passed
    return true;
}
}
// ]]>
    

 $('#imagen').change(function(){  
    var formData = new FormData();
formData.append('imagen', $('#imagen')[0].files[0]);

$.ajax({
       url : 'check_img.php',
       type : 'POST',
       data : formData,
       processData: false,  // tell jQuery not to process the data
       contentType: false,  // tell jQuery not to set contentType
       success : function(data) {
           console.log(data);
           $('#InfoImg').html(data);
       }
});
 });







</script>





</body>
</html>