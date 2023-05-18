<?php
session_start();
if (!isset($_SESSION['trcdocumento'])) 
{
    header("Location: index.html"); 
} 
else 
{
    if ($_SESSION['trcdocumento'] != "BLOCKED") 
    {
        $_SESSION['PDVsession_bloqueada'] = $_SESSION['trcdocumento'];
        $_SESSION['trcdocumento'] = "BLOCKED";
    }else{
        $usuario = $_SESSION['PDVsession_bloqueada'];
    }
}
$usuario = $_SESSION['PDVsession_bloqueada'];

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>Beauty Soft ERP</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
   <link rel="shortcut icon" type="image/ico" href="imagenes/favicon.png" />

    <!-- Vendor styles -->
    <link rel="stylesheet" href="../lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../lib/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="../lib/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="../lib/vendor/sweetalert/lib/sweet-alert.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../lib/styles/style.css">

    <META HTTP-EQUIV="REFRESH" CONTENT="600;URL=bloquear_pantalla.php?url=<?php echo $_GET['url'];?>">

</head>
<body class="blank" onload="deshabilitaRetroceso()">

<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>Homer - Responsive Admin Theme</h1><p>Special Admin Theme for small and medium webapp with very clean and aesthetic style and feel. </p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->


<div class="lock-container">
    <div>
        <div class="hpanel">
            <div class="panel-body text-center">
                 <a href="logout.php" title="Cerrar sesion" class="pull-right"> <!-- <button class="form-control"> --><i class="fa fa-lg fa-sign-out text-danger"></i><!-- </button> --></a>
                <i class="pe-7s-lock big-icon text-info "></i>
                <br/>
                <h4>Pantalla bloqueada</h4>
                <p>Ingrese su contraseña para desbloquear la pantalla</p>
                <input type="hidden" id="modulo" value="<?php echo $_GET['url'] ?>">
                <form  role="form" class="m-t" id="formulario">
                    <div class="form-group">
                        <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario; ?>" >
                        <input type="password" name="pass" id="pass" required="" placeholder="Digite su contraseña" class="form-control" required>
                        <div id="info" class="col-lg-12 help-block text-danger"></div>
                    </div>
                    <button class="btn btn-success block full-width" id="btnDesbloquear" type="button">Desbloquear</button>
                    
                </form>
            </div>
        </div>


    </div>
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

<!-- App scripts -->
<script src="../lib/scripts/homer.js"></script>

<script type="text/javascript">
$('#formulario').on('submit', function(event) 
{
    event.preventDefault();
    var user = $('#usuario').val();
    console.log(user);
    if ($('#usuario').val() == "")
    {
        $('#info').html("Ingrese su clave.");
    } else {
        
        var clave = $('#pass').val();
        $.ajax({
            type: "POST",
            url: "desbloquear.php",
            data: {usuario: user , pass: clave},
            success: function(res) {
                if (res == "TRUE") {
                    var url = $('#modulo').val();
                    window.location = url;
                } else {
                    $('#info').html("Clave incorrecta");    
                }
            }
        });
    }
});

$(document).on('click', '#btnDesbloquear', function() 
{
    var user = $('#usuario').val();
    var clave = $('#pass').val();

    if (clave == "") 
    {
        swal("Digite su contraseña", "", "warning");
    }
    else
    {
        $.ajax({
            type: "POST",
            url: "desbloquear.php",
            data: {usuario: user, pass: clave},
            success: function(res) {
                if (res == "TRUE") {
                    var url = $('#modulo').val();
                    window.location = url;
                } 
                else 
                {
                    swal("Contraseña inválida", "", "error");    
                }
            }
        });
    }

});
function deshabilitaRetroceso(){
    //window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="no-back-button";}
}
</script>
</body>
</html>