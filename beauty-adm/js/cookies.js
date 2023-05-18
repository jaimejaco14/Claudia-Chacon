

function guardarCookie(nombre,valor,fecha,txtcookie) 
{
    document.cookie = nombre+"="+valor+ ' '+ txtcookie+";expires="+fecha+"; path=/";

    if (fecha == '31 Dec 2012 23:59:59 GMT') 
    {
        swal('La Cookie ' +nombre +'  fue eliminada.', "", "success" );
    }
    else
    {
        if (valor == 0) 
        {
            swal("Aún no has seleccionado un salón", "", "warning");
        }
        else
        {
          console.log(nombre);
            console.log(valor);
            console.log(txtcookie);
            swal('La Cookie fue registrada ' +nombre + " "+ txtcookie+'  ', "", "success");
        }
    }
}

    var caduca = "31 Dec 2030 23:59:59 GMT";
    
function guardar(nombre,id, txtCookie) 
{
  var tuCookie   = nombre;
  var tuValor    = $('#'+id).val();
  var txtCookie  = $('#salones option:selected').text();
  guardarCookie(tuCookie,tuValor,caduca, txtCookie);  
}


function leerCookie(nombre) 
{
  var lista = document.cookie.split(";");
  var micookie;
  
      for (i in lista) 
      {
          var busca = lista[i].search(nombre);
          if (busca > -1) {micookie=lista[i]}
      }

      if (micookie == undefined) 
      {
        swal('No hay '+nombre+ ' registrado', "", "info"); 
        return false; 
      }

    var igual = micookie.indexOf("=");
    var valor = micookie.substring(igual+1);
    swal("La cookie creada con el nombre " + nombre + " tiene el valor de " + valor, "", "success");
}


function borrar_coo(nombre) 
{
  var caduca = "31 Dec 2012 23:59:59 GMT";

    if ($('#Salon').val() == '') 
    {
        alert('Escriba la caja que desesa borrar');
        return false;
    }

    var tuCookie = nombre;
    var tuValor = 0;
    guardarCookie(tuCookie,tuValor,caduca);
}



function leerCookie_Traslado(nombre) 
{
    var lista = document.cookie.split(",");
    var micookie;
    for (var i in lista) 
    {
      var busca = lista[i].search(nombre);
      if (busca > -1) {micookie=lista[i]}
    }

    if (micookie == undefined) 
    {
   
        swal({
                title: "Este equipo no está registrado",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-info",
                confirmButtonText: "Registrar",
                closeOnConfirm: false,
                cancelButtonText: 'Cancelar'
            },
            function()
            {
               window.open("../html/guardar_cookies.php");
            });
            return false;
    }
    else
    {

            var igual = micookie.indexOf("=");
            var valor = micookie.substring(igual+1);

            $.ajax({
                    type: "POST",
                    url: "php/cookies/validar_cookies.php",
                    data: {slncodigo:valor},
                    method: 'POST',
                    success: function(data)
                    {
                        if (data == '' || data == null) 
                        {
                          swal('Código asignado no corresponde a ningún salón', '', 'error');
                          
                        } 
                        else
                        {                          
                              $('#salon').html(valor + ","+micookie);               
                        }  
                    }
            });
    }
}


