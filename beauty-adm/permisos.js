function privilegio(user, peticion) 
{
    $.ajax({
        type: "POST",
        url: "verificar_acceso.php",
        data: {usu: peticion, cod_peti: user},
        success: function (html) 
        {
          console.log(html);
            if (html == "TRUE")
            {
                direccionar (peticion);  

            } 
            else 
            {
              ko();
            }
       }
    });
}


function direccionar (a) 
{
    switch (a) 
    {
      
      case 2: window.location  = "cambio_clave.php"; break;    
      case 3: window.location  = "servicios.php"; break;
      case 4: window.location  = "cliview.php"; break;
      case 5: window.location  = "colview.php"; break;
      case 6: window.location  = "salon.php"; break;
      case 7: window.location  = "new_usuario.php"; break;
      case 8: window.location  = "privilegios_perfil.php"; break;
      case 9: break;
      case 10: window.location = "marcaview.php"; break;
      case 11: window.location = "activo.php"; break;
      case 12: window.location = "horarios_salon.php"; break;
      case 14: window.location = "puestos_de_trabajo.php"; break;
      case 15: window.location = "programacion.php"; break;
      case 16: window.location = "tipo_turno.php"; break;
      case 17: window.location = "citas.php"; break;
      case 20: window.location = "tipo.php"; break;
      case 21: window.location = "grupo.php"; break;
      case 22: window.location = "subgrupo.php"; break;
      case 23: window.location = "linea.php"; break;
      case 24: window.location = "sublinea.php"; break;
      case 25: window.location = "caracteristica.php"; break;
      case 27: window.location = "turnos.php"; break;
      case 28: window.location = "listaPrecios.php"; break;
      case 29: window.location = "sesiones.php"; break;
      case 36: window.location = "unidad.php"; break;
      case 37: window.location = "proveedores.php"; break;
      case 38: window.location = "iva.php"; break;
      case 39: window.location = "bodega.php"; break;
      case 40: window.location = "productos.php"; break;
      case 41: window.location = "fechas_especiales.php"; break;
      case 42: window.location = "sube_baja.php"; break;
      case 43: window.location = "pdv_programacion.php"; break;
      case 44: window.location = "citas.php"; break;
      case 46: window.location = "permisos.php"; break;
      case 47: window.location = "permisos.php"; break;
      case 50: window.location = "tipo_puesto.php"; break;
      case 51: window.location = "tipo_programacion.php"; break;
      case 52: window.location = "meta_salon.php"; break;
      case 53: window.location = "parametro_asistencia.php"; break;

    }
}


function ko () 
{
  swal({
    title: "No tienes permiso de ingreso",
    text: "",
    type: "warning",
    confirmButtonText: "Aceptar"
  });
}