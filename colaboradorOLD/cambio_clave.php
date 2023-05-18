<?php 
    session_start(); 
    include("./php/funciones.php");
     include '../cnx_data.php';  
 ?> 


<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>Beauty Soft ERP | Cambiar Contraseña</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="../lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../lib/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="../lib/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../lib/styles/style.css">
    <link rel="stylesheet" href="../lib/vendor/toastr/build/toastr.min.css" />
    <link rel="stylesheet" href="../lib/vendor/sweetalert/lib/sweet-alert.css" />

</head>
<body class="blank">

<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>Homer - Responsive Admin Theme</h1><p>Special Admin Theme for small and medium webapp with very clean and aesthetic style and feel. </p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="color-line"></div>

<div class="login-container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
                <h3>CAMBIAR CONTRASEÑA</h3>
               <!--  <small>Please fill the form to recover your password</small> -->
            </div>
            <div class="hpanel">
                <div class="panel-body">
                        <form action="#" id="loginForm">
                            <input type="hidden" id="user" value="<?php echo $_SESSION['trcdocumento'] ?>">
                            <div class="form-group">
                                <label class="control-label" for="username">Digite su contraseña actual</label>
                                <input type="password" placeholder="*******" title="Por favor ingrese su contraseña actual" required="" value="" name="username" id="currentpass" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="username">Digite su nueva contraseña</label>
                                <input type="password" placeholder="Ejemplo: Clave123" title="Por favor ingrese su nueva contraseña"  maxlength="8" id="new_pass" class="form-control">
                                <span class="help-block small text-danger" id="sugerencia" style="display: none">La contraseña debe ser alfanumérica, máximo 8 caracteres y debe contener al menos una mayúscula.</span>
                            </div>

                             <div class="form-group">
                                <label class="control-label" for="username">Confirme su nueva contraseña</label>
                                <input type="password" placeholder="*******" title="Por favor confirme su contraseña" required="" value="" name="" id="old_pass" class="form-control">                                
                            </div>

                            <button class="btn btn-success btn-block" type="button" id="btnChanPass">Enviar </button>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-md-12 text-center">
            <strong>HOMER</strong> - Responsive WebApp <br/> 2015 Copyright Company Name
        </div>
    </div> -->
</div>


<!-- Vendor scripts -->
<script src="../lib/vendor/jquery/dist/jquery.min.js"></script>
<script src="../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="../lib/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../lib/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="../lib/vendor/iCheck/icheck.min.js"></script>
<script src="../lib/vendor/sparkline/index.js"></script>

<script src="../lib/vendor/sweetalert/lib/sweet-alert.min.js"></script> 
<script src="../lib/vendor/toastr/build/toastr.min.js"></script>

<!-- App scripts -->
<script src="../lib/scripts/homer.js"></script>

</body>
</html>

<script>
    $(document).on('blur', '#currentpass', function() 
    {
        var actual = $('#currentpass').val();

        $.ajax({
            url: 'php/cambioclave/process.php',
            method: 'POST',
            data: {actual: actual, opcion: "validar"},
            success: function (data) 
            {
                if (data != 1) 
                {
                    toastr.error("La contraseña no coincide");
                    $('#currentpass').focus().select();
                }
            }
        });
    });

function valida(tx)
{   var nMay = 0, nMin = 0, nNum = 0;
    var t1 = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    var t2 = "abcdefghijklmnñopqrstuvwxyz";
    var t3 = "0123456789";

    for (i=0;i<tx.length;i++) 
    {
        if ( t1.indexOf(tx.charAt(i)) != -1 ) {nMay++;}
        if ( t2.indexOf(tx.charAt(i)) != -1 ) {nMin++;}
        if ( t3.indexOf(tx.charAt(i)) != -1 ) {nNum++;}
    }
    if ( nMay>0 && nMin>0 && nNum>0 ) 
        { 
            return true; 
        }
    else 
    { 
        return false; 
    }
}



$(document).on('keydown', '#new_pass', function() 
{
    if ($('#currentpass').val() == "") 
    {
        toastr.error("Debes ingresar la contraseña actual");
        $('#currentpass').val('');
        $('#currentpass').focus();
    }
    else
    {
        $('#sugerencia').css("display", "block");        
    }
});


/*$(document).on('blur', '#new_pass', function() 
{
    var newpass = $('#new_pass').val();
    if (valida(newpass) != true) 
    {
        swal("Error", "Las nueva contraseña no cumple con las indicaciones descritas", "error");
        $('#new_pass').focus().select();        
    }
   

});*/

    $(document).on('click', '#btnChanPass', function() 
    {
        var new_pass    = $('#new_pass').val();
        var old_pass    = $('#old_pass').val();

        if (new_pass != old_pass) 
        {
            swal("Error", "Las contraseñas no coinciden. Intente de nuevo", "error");
            $('#old_pass').focus().select();
        }
        else
        {

                swal({
                      title: "Se enviará un e-mail confirmando el cambio de clave",
                      type: "info",
                      showCancelButton: true,
                      closeOnConfirm: false,
                      cancelButtonText: 'Cancelar',
                      showLoaderOnConfirm: true
                    }, function () {
                        setTimeout(function () {
                                sendemail ();                             
                        }, 1500);
                    });
           
        }


 
    });

    function sendemail () 
    {
        var new_pass    = $('#new_pass').val();
        var old_pass    = $('#old_pass').val();
        $.ajax({
            url: 'php/cambioclave/process.php',
            method: 'POST',
            data: {new_pass:new_pass, opcion: "nueva"},
            success: function (data) 
            {
                if (data == 1) 
                {
                    
                    swal("¡Mensaje enviado correctamente!");                    
                    $('#currentpass').val('');
                    $('#new_pass').val('');
                    $('#old_pass').val('');
                    $('#sugerencia').css("display", "none");
                    setTimeout(function(){ window.location="index.html";}, 1000);

                }
            }
        });
    }
</script>