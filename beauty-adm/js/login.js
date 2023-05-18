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
		url: 'cargar_salones_usuario.php',
		success: function (data) {
			$('#sel_salones').html(data);
		}
	});
}*/

$(document).on('click', '#btn_login', function() 
{
	var user = $('#username').val();
	var pass = $('#password').val();
	var db  = $('#Db').val();
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
				url: 'login_process.php',
				method: 'POST',
				data: {user: user, pass:pass, db:db, dbname:dbname},
				success: function (data) 
				{
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
    							window.location="index.php";
    						}
    						else
    						{
    							if (data == 4) 
    							{
    								swal("Usuario incorrecto", "", "error");
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



