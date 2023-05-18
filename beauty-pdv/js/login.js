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

/*function load_salones () {
	$.ajax({
		url: 'php/login/cargar_salones_usuario.php',
		success: function (data) {
			$('#sel_salones').html(data);
		}
	});
}*/

/*toastr.options = {
	"debug": false,
	"newestOnTop": false,
	"positionClass": "toast-top-center",
	"closeButton": true,
	"toastClass": "animated fadeInDown",
	"showEasing" : 'swing'
};*/

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
    var db      = $('#Db').val();
    var sln     = $('#Codsalon').val();
    var dbname  = $('#Db option:selected').text();


    if (user == "") 
    {
        swal("Ingrese su usuario", "", "warning");
        $('#user').focus();
    }
    else
    {
        if (pass == "") 
        {
            swal("Ingrese su contraseña", "", "warning");
            $('#pass').focus();
        }
        else
        {
            $.ajax({
                url: 'php/login/login_process.php',
                method: 'POST',
                data: {user: user, pass:pass, db:db, slncodigo:sln, dbname: dbname},
                success: function (data) 
                {
                    //alert(data);
                    if (data == 1) 
                    {
                        swal("La contraseña no coincide. Intente de nuevo.", "", "error");
                    }
                    else
                    {
                        if (data == 2) 
                        {
                            swal("Su permiso ha expirado para este salón.", "", "warning");
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
                                    swal("Usuario incorrecto", "", "error");
                                }
                                else
                                {
                                    if (data == 5) 
                                    {
                                        swal("No tiene autorización para entrar al salón.", ""+$('#salon').html()+"", "error");
                                    }
                                    else
                                    {
                                        if (data == 6) 
                                        {
                                            swal("Autorización Vencida", "La fecha asignada para el salón "+$('#salon').html()+" se ha vencido", "error");
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            });
        }
    }

});
/*=====  End of LOGIN  ======*/



