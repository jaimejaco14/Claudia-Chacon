/*=============================
=            READY            =
=============================*/

$(document).ready(function() {
	//load_salones ();
});

/*=====  End of READY  ======*/


/*=============================
=            LOGIN            =
=============================*/


toastr.options = {
	"debug": false,
	"newestOnTop": false,
	"positionClass": "toast-top-right",
	"closeButton": true,
	"toastClass": "animated fadeInDown",
	"showEasing" : 'swing'
};

//toastr.options.onHidden = function() { alert('hello'); }

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
    var sw      = 0;
    if($("#rememb").is(":checked")){
        sw=1;
    }
    

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
            $('#btn_login').html('<i class="fa fa-spin fa-spinner"></i> Ingresando').attr('disabled',true);
            $.ajax({
                url: 'php/login/login_process.php',
                method: 'POST',
                data: {user: user, pass:pass, sw:sw},
                success: function (data) 
                {
                    if (data == 1) 
                    {
                        toastr.error("No se le ha asignado una clave.");
                    }
                    else
                    {
                        if (data == 2) 
                        {
                            toastr.error("Su contraseña no coincide. Intente de nuevo");
                        }
                        else
                        {
                            if (data == 3) 
                            {
                                window.location="inicio.php";
                            }
                            else
                            {
                                if (data == 4) 
                                {
                                    toastr.error("Usuario no existe, verifique!");
                                }
                                else
                                {
                                    if (data == 5) 
                                    {
                                        toastr.error("No puede acceder ya que su estado es desvinculado.");
                                    }
                                    else
                                    {
                                        if (data == 6) 
                                        {
                                            toastr.error("No tiene habilitado el acceso web");
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if(data!=3){
                        $('#btn_login').html('Ingresar').removeAttr('disabled');
                    }
                }
            });
        }
    }

});
/*=====  End of LOGIN  ======*/



