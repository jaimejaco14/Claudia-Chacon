<?php 
    session_start();
    include '../cnx_data.php';

function get_real_ip(){

    if (isset($_SERVER["HTTP_CLIENT_IP"]))
    {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
    {
        return $_SERVER["HTTP_X_FORWARDED"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED"]))
    {
        return $_SERVER["HTTP_FORWARDED"];
    }
    else
    {
        return $_SERVER["REMOTE_ADDR"];
    }
}
$ipaddress= get_real_ip();
$sql="SELECT slncodigo,slnnombre,slnscreen FROM btysalon where slnipaddress='$ipaddress'";
$res=$conn->query($sql);
if($res->num_rows>0){
    $row=$res->fetch_array();
    $slncod=$row['slncodigo'];
    $slnnombre=$row['slnnombre'];
    $_SESSION['PVDscreen']  = $row['slnscreen'];
}else{
    header('location:http://www.claudiachacon.com');
}
?>


<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#c9ad7d" />

    <!-- Page title -->
    <title>Beauty Soft ERP</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
   <link rel="shortcut icon" type="image/ico" href="../contenidos/imagenes/favicon.png" />


    <!-- Vendor styles -->
    <link rel="stylesheet" href="../lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../lib/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="../lib/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="../lib/vendor/bootstrap/dist/css/bootstrap.css" />
    <link rel="shortcut icon" type="image/ico" href="../lib/imagenes/favicon.png" />

    <!-- App styles -->
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../lib/styles/style.css">
    <link rel="stylesheet" href="../lib/vendor/toastr/build/toastr.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    
   

</head>
<body class="blank">


<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>Beauty Soft ERP - INVELCON SAS</h1><p>Software de gestión integrada de recursos para negocios de servicios de belleza y estética</p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div>
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->


<div class="color-line"></div>

<div class="login-container" style="padding-top: 2%!important">
    <div class="row">
        <div class="col-md-12">
            <div class="hpanel">
                <div class="panel-body">
                    <a href="../"><img class="img-responsive" src="../contenidos/images/logo_beauty_horizontal.png"></a>                  
                        <div class="form-group">
                            <label class="control-label" for="username">Usuario</label>
                            <input type="text" placeholder="Usuario" title="Ingrese su usuario" required name="username" id="username" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">                                
                            <label class="control-label" for="password">Contraseña</label>
                            <input type="password" title="Ingrese su contraseña" placeholder="******" required name="password" id="password" class="form-control" autocomplete="off">
                        </div>
                         <div class="form-group"> 
                            <label class="control-label" id="slnnom">Salón</label>          
                        </div>
                         <div class="input-group m-b"><span class="input-group-btn">
                            <input type="hidden" name="Codsalon" id="Codsalon" value="<?php echo $slncod;?>">
                            <button type="button" class="btn btn-primary" id="salon"><?php echo $slnnombre;?></button> </span> 
                            <select id="Db" name="Db" class="form-control">
                                <?php
                                if($slncod==0){
                                    $sql="SELECT slncodigo,slnnombre FROM btysalon WHERE slnestado=1 ORDER BY slnnombre";
                                    $res=$conn->query($sql);
                                    $opc='<option value="">Seleccione salón</option>';
                                    while($row=$res->fetch_array()){
                                        $opc.='<option value="'.$row[0].'">'.$row[1].'</option>';
                                    }
                                    echo $opc;
                                }else{
                                    include("conexionxml.php");
                                }
                                ?>
                            </select>
                        </div>
                       <br>
                       <div class="form-group">
                            <button id="btn_login" type="button" class="btn btn-success btn-block">Ingresar</button><br> 
                       </div>                      
                        <div class="col-md-12" style="text-align: center;">
                            <button type="button" id="btn_recovery_pass" class="btn btn-success" data-toggle="modal" data-target="#modal_login_recovery_pass">¿Olvidó su contraseña?</button> 
                        </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-md-12 text-center">
            <br><strong>Copyright ©<script>var f = new Date(); document.write(f.getFullYear())</script> INVELCON S.A.S </strong><br/> <a href="http://www.claudiachacon.com">www.claudiachacon.com </a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="../lib/vendor/toastr/build/toastr.min.js"></script>
<!-- App scripts -->
<script src="../lib/scripts/homer.js"></script>   
<script src="js/login.js"></script> 
<script src="js/cookies.js"></script> 
</body>
</html>

<script>
    document.cookie = "Salon="+$("#Codsalon").val()+' '+ $("#salon").html()+";expires=31 Dec 2020 23:59:59 GMT";
    $(document).on('click', '#btn_recovery_pass', function() 
    {

        swal({
            title: "Recuperar Contraseña",
            text: "Ingrese su E-mail",
            type: "input",
            closeOnConfirm: false,
            animation: "slide-from-top",
            inputPlaceholder: "Por favor ingrese su e-mail",
        },
        function(inputValue)
        {
            var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
            var Db    = $('#Db').val();

            if (inputValue === false) return false;
          
            if (inputValue === "") {
                swal.showInputError("Debe ingresar su e-mail");
                return false;
            }
            else
            { 
                if (!regex.test(inputValue.trim())) 
                {
                     swal.showInputError("Ingrese un e-mail válido");
                }
                else
                {
                    $.ajax({
                        url: 'recoverypass.php',
                        method: 'POST',
                        data: {email:inputValue, Db:Db},
                        success: function (data) 
                        {
                            if (data == 1) 
                            {   
                                swal("Aviso", "Te enviaremos una nueva contraseña a tu correo electronico.", "success");
                            }
                            else
                            {
                                swal("Atención","Este e-mail no se encuentra registrado. Intente de nuevo", "error");
                            }
                        }
                    });  
                   
                }
            }
        });
        
    });


    $(document).ready(function() {
        //leerCookie_Traslado();
    });
</script>
<script type="text/javascript">
    $("#Db").change(function(e){
        var slncod=$(this).val();
        var slnnom=$("#Db option:selected").text();
        $("#Codsalon").val(slncod);
        $("#salon").html(slnnom);
    });
</script>



                   
