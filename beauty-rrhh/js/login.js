
toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

$(document).ready(function() {
    $("#username").focus();
});

$("#username").keypress(function(e) 
{
    if(e.which == 13) 
    {
        $("#btn_login").click();
        e.preventDefault();       
    }
});

$("#password").keypress(function(e) 
{
    if(e.which == 13) 
    {
        $("#btn_login").click();
        e.preventDefault();       
    }
});

$(document).on('click', '#btn_login', function() 
{
    var user    = $('#username').val();
    var pass    = $('#password').val();


    if (user == "") 
    {
        toastr.warning("Ingrese su usuario");
        $('#user').focus();
    }
    else
    {
        if (pass == "") 
        {
            toastr.warning("Ingrese su contraseña");
            $('#pass').focus();
        }
        else
        {
            $.ajax({
                url: 'php/login/login_process.php',
                method: 'POST',
                data: {user: user, pass:pass},
                success: function (data) 
                {
                    if (data == 1) 
                    {
                        toastr.error("Usuario no existe!");
                        $('#user').focus();
                    }
                    else if(data == 2)
                    {
                        toastr.error("Contraseña Incorrecta!");
                        $('#pass').focus();
                    }
                    else if(data == 3){
                        window.location='inicio.php';
                    }
                    else if(data == 4){
                        toastr.error("Usted NO tiene privilegios de acceso a este modulo!");
                    }
                }
            });
        }
    }
});