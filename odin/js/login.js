
toastr.options = {
	"debug": false,
	"newestOnTop": false,
	"positionClass": "toast-top-right",
	"closeButton": true,
	"toastClass": "animated fadeInDown",
	"showEasing" : 'swing'
};

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