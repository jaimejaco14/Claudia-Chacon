/*============================
=            MAIN            =
============================*/

/**
 *
 * AGENDA
 *
 */

 toastr.options = {
	"debug": false,
	"newestOnTop": false,
	"positionClass": "toast-top-center",
	"closeButton": true,
	"toastClass": "animated fadeInDown",
	"showEasing" : 'swing'
};


 $(document).on('click', '#btnAgenda', function() 
 {
 	window.location="agenda.php";
 });


$(document).on('click', '#btnVerServicios', function() 
{
 	window.location="servicios.php";
});

$(document).on('click', '#btnVerProg', function() 
{
	window.location="programacion.php";
});

$(document).on('click', '#alerta', function() 
{
	toastr.error("No tienes agenda asignada");
});

$(document).on('click', '#alerta2', function() 
{
	toastr.error("No tienes servicios autorizados");
});

$(document).on('click', '#btnVerNov', function() 
{
	window.location="novedades.php";
});

$(document).on('click', '#btnVerPermisos', function() 
{
	window.location="permisos.php";
});

$(document).on('click', '#btnVerBio', function() 
{
	window.location="biometrico.php";
});











  


 


/*=====  End of MAIN  ======*/
