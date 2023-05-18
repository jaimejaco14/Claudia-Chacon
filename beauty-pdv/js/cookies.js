

function guardarCookie(nombre,valor,fecha,txtCookie) 
	{
    	document.cookie = nombre+"="+valor+ txtCookie+";expires="+fecha+";";

    	if (fecha == '31 Dec 2012 23:59:59 GMT') 
    	{
      		swal('La Cookie ' +nombre + txtCookie+'  fue eliminada.', "", "success" );
    	}
    	else
    	{
      		if (valor == 0) 
      		{
      			swal("Aún no has seleccionado un salón", "", "warning");
      		}
      		else
      		{
            
      			swal('La Cookie fue registrada ' +nombre + txtCookie+'  ', "", "success");
      		}
    	}
 	}

  	var caduca = "31 Dec 2020 23:59:59 GMT";
  	
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
      var lista = document.cookie.split(";");
      var micookie;
        for (i in lista) 
        {
          var busca = lista[i].search(nombre);
          if (busca > -1) {micookie=lista[i]}
        }

      if (micookie == undefined) 
      {
        //leerCookie('Salon'); 
          swal("Este equipo no está registrado", "", "warning");
         
        return false;
      }
      else
      {

        var igual = micookie.indexOf("=");
        var valor = micookie.substring(igual+1);

        var t           = valor.search(";");
        var g           = valor.substring(t,1);
        var valorcookie = valor.substring(0,2);

        var m = valor.substring(2,24);

        $('#salon').html(m);
        $('#Codsalon').val(valorcookie.trim());
      }

    }


