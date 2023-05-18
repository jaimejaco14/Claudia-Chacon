
/*=============================
=            LOGIN            =
=============================*/

$(document).on('click', '#btnSesion', function() 
{
    var usuario = $('#docIdentidad').val();
    var pass    = $('#contrasena').val();

    if (usuario == "") 
    {
        toastr.warning("Ingrese su usuario", "", "warning");
        $('#docIdentidad').focus();
    }
    else
    {
        if (pass == "") 
        {
            toastr.warning("Ingrese su contraseña", "", "warning");
            $('#contrasena').focus();
        }
        else
        {
            $.ajax({
                url: "citas/login.php",
                method: 'POST',
                data: {usuario: usuario, pass: pass},
                success: function (data) 
                {
                   switch (data) {
                       case '1':
                           window.location="agenda.php";
                           break;

                        case '2':
                            toastr.error("Contraseña Errada");
                           break;

                        case '3':
                            toastr.error("El usuario no está registrado");
                           break;
                       default:
                           // statements_def
                           break;
                   }
                }
            });
        }
    }
});




/*=====  End of LOGIN  ======*/