jQuery(document).ready(function ($) {

    //BLOQUEAR FECHA CITA
    let fechaActualCita = new Date().toISOString().slice(0, 10);
    $('#select-date-cita').attr('min', fechaActualCita);
  
      //BLOQUEAR FECHA ANTERIOR
      let fechaActualDomicilio = new Date().toISOString().slice(0, 10);
      $('#select-date-domicilio').attr('min', fechaActualDomicilio);
    // Get the Salone`s data
    obtenerSalones();
  
    /*=========VARIABLES GLOBALES======== */
  
    let client_id;
  
    //SI EL SALON ID NO SE LLAMA, SE DA POR HECHO QUE ES UN DOMILICIO
  
    let salonDomicilio = 18;
  
    var salonId;
  
    ternario_salon_id = salonId ? salonId : 18;
  
    let fechaCita;
    let fechaCitaString;
    let horaCita;
    let servicioCita;
    let valorNota = "Sin Nota";
    var colaboradorDisponible;
    var salon_disponible;
    var servicio_disponible;
    let tipo_documento = 2;
    var numero_documento;
    var nombre_cliente;
    var apellido_cliente;
    var telefono_cliente;
    var correo_cliente;
    let dia_nacimiento;
    let mes_nacimiento;
    let direccion_cliente = "no";
  
    var fechaDomicilio;
    var horaDomicilio;
    var servicioDomicilio;
  
    /*=====EVENTOS CHANGE PARA OBTENER LOS DATOS DE LOS INPUTS======== */
  
  
  
  
    document.getElementById('estoy_registrado').addEventListener('submit', function(evento){
      evento.preventDefault();
  
      var nameClientValue = $('#name-client').text();
  
      if(nameClientValue == 'Cliente no registrado'){
        $('#name-client').text('');
      alertify.error('El cliente no se encuentra registrado');
      return false;
    }
  
      let documento = document.getElementById('document-client').value;
  
      if(!documento){
        $('#name-client').text('');
  
        alertify.error('Por favor ingrese un documento');
        return false;
      }
  
    
      obtenerCliente(documento);
  
  
  
      return false;
    });
  
  
    /*=====CITAS======== */

    function getDateLength(date) {
        return Math.abs(date - new Date()) / 1000;
      }
      
  
    $("#salon-list-cita").change(function () {
      var salon_seleccionado = $(this).val();
      salonId = salon_seleccionado;
        ternario_salon_id = salonId ? salonId : 18;      
      let parseDate = Date.parse(fechaCitaString);
      let resultFunction = getDateLength(parseDate);
      if(resultFunction > 0){
        obtenerTurnosDelSalon(ternario_salon_id);
        servicios(ternario_salon_id);
      }

   });
    
    $("#select-date-cita").change(function () {
      let fecha_selecionada = $(this).val();
      fechaCita= fecha_selecionada;
      fechaCitaString = fecha_selecionada;
      obtenerTurnosDelSalon(ternario_salon_id);
      servicios(ternario_salon_id);
    });
  
    $("#hour_salon_cita").change(function () {
      let hora_selecionada = $(this).val();
      horaCita= hora_selecionada;
  
    });
  
    $("#services-list-cita").change(function () {
      let servicio_selecionado = $(this).val();
      servicioCita= servicio_selecionado;
    });
  
    
  
    /*=====DOMICILIO======== */
  
    $("#select-date-domicilio").change(function () {
      var fechaDomicilio_ = $(this).val();
      fechaDomicilio = fechaDomicilio_;
      
      obtenerTurnosDelSalon(salonDomicilio);
  
      servicios(salonDomicilio);
    });
  
    $("#hour_salon_domicilio").change(function () {
      var horaCitaDomicilio_ = $(this).val();
      horaDomicilio = horaCitaDomicilio_;
    });
  
    $("#services-list-domicilio").change(function () {
      var servicio_list_domicilio = $(this).val();
      servicioDomicilio = servicio_list_domicilio;
    });
  
    /*=====CREAR CLIENTES======== */
  $("#tipo-documento").change(function () {
      let tipo_documento_cliente = $(this).val();
      tipo_documento = tipo_documento_cliente;
    });
  
     $("#documento-cliente").change(function () {
      let documento_cliente = $(this).val();
      numero_documento = documento_cliente;
    });
  
      $("#nombre-cliente").change(function () {
      let nombre_cliente_ = $(this).val();
      nombre_cliente = nombre_cliente_;
    });
  
    $("#apellido-cliente").change(function () {
      let apellido_cliente_ = $(this).val();
      apellido_cliente = apellido_cliente_;
    });
  
      $("#day").change(function () {
      let dia_nacimiento_ = $(this).val();
      dia_nacimiento = dia_nacimiento_;
    });
  
    $("#month").change(function () {
      let mes_nacimiento_ = $(this).val();
      mes_nacimiento = mes_nacimiento_;
    });
  
     $("#telefono-cliente").change(function () {
      let telefono_cliente_ = $(this).val();
      telefono_cliente = telefono_cliente_;
    });
  
  $("#email-cliente").change(function () {
      let correo_cliente_ = $(this).val();
      correo_cliente = correo_cliente_;
    });
  
    $("#direccion-domicilio").change(function () {
      let direccion_cliente_ = $(this).val();
      direccion_cliente = direccion_cliente_;
    });
  
  
    /* ===============FUNCIONES PARA OBTENER DATOS==========  */
    //CREAR UN CLIENTE
    function crearCliente() {
      $.ajax({
        type: "GET",
        url: "https://claudiachacon.com/beauty/beauty-pdv/newapi/controller/crearCliente.php?token=CludiaCh4con",
        dataType: "json",
        data: { tdicodigo: tipo_documento, trcdocumento: numero_documento, trcnombres: nombre_cliente, trcapellidos: apellido_cliente, trctelefono: telefono_cliente, trcemail: correo_cliente, dia_nacimiento: dia_nacimiento, mes_nacimiento: mes_nacimiento },
        success: function (data) {
          $.each(data, function (index, value) {
            if (value.res == "OK") {
              document.getElementById("crear-cliente-form").reset();
              alertify.success('Cliente Creado');
            } else {
              alertify.error('Error al crear el cliente');
            }
          });
        },
        error: function (data) {
          alertify.error('Cliente ya creado');
        }
      });
    } 
  
   // Get the client's data
    function obtenerCliente(num_document_client) {
      let num_documento = num_document_client;
      $.ajax({
        type: "GET",
        url: "https://claudiachacon.com/beauty/beauty-pdv/newapi/controller/cliente.php?token=CludiaCh4con",
        dataType: "json",
        data: { documento: num_documento },
        success: function (data) {
          $.each(data, function (index, value) {
            if (value.razonsocial == undefined) {
              $("#name-client").text("Cliente no registrado");
            } else {
              client_id = value.cliente_id;
              $("#name-client").text("Bienvenido, " + value.razonsocial + " por favor continúa al paso 2");
            }
          });
        },
      });
    }
  
    // Get the Salone`s data

    function obtenerSalones() {
      $.ajax({
        type: "GET",
        url: "https://claudiachacon.com/beauty/beauty-pdv/newapi/controller/salones.php?token=CludiaCh4con",
        dataType: "json",
        success: function (data) {
  
          if(ternario_salon_id == 18){
            let select_lista_salones = $('#salon-list-domicilio');
  
            $.each(data, function (index, value) {
              select_lista_salones.append('<option value="'+value.salon_id+'">'+value.nombre_salon+'</option>');
            });
          }
  
          let select_lista_salones = $('#salon-list-cita');
  
          $.each(data, function (index, value) {
            select_lista_salones.append('<option value="'+value.salon_id+'">'+value.nombre_salon+'</option>');
          });
          
        },
      });
    }
  
    // Get the Date`s data
    function obtenerTurnosDelSalon(salon) {
      $.ajax({
        type: "GET",
        url: "https://claudiachacon.com/beauty/beauty-pdv/newapi/controller/turnos.php?token=CludiaCh4con",
        dataType: "json",
        data: { slncodigo: salon },
        success: function (data) {
          for(let i = 0; i < data.length; i++){
            let horaInicial = data[i].desde
            let horaFinal = data[i].hasta
            let dia = data[i].dia
  
            if(salon == 18){
              let diaSemana = obtenerDiaSemanaDomicilio(fechaDomicilio);
              if(diaSemana === dia){
                horasMenuDomicilio(horaInicial, horaFinal);
              }
            }else{
              let diaSemana = obtenerDiaSemana(fechaCita);
              if(diaSemana === dia){
                horasMenu(horaInicial, horaFinal);
              }
            }
          }
        },
      });
    }
  
    //get service data
    function servicios(salon_id){
  $('#loading').show("slow");
      $.ajax({
        type: "GET",
        url: "https://claudiachacon.com/beauty/beauty-pdv/newapi/controller/servicio.php?token=CludiaCh4con",
        dataType: "json",
        data: { slncodigo: salon_id },
        success: function (data) {
  
          if(salon_id == salonDomicilio){

            let select_lista_servicios = $('#services-list-domicilio');

            $("#services-list-domicilio").val('');

            $.each(data, function (index, value) {
              select_lista_servicios.append('<option value="'+value.codigo_id+'">'+value.nombre_servicio+'</option>');
            });
            $("#loading").hide(1000)
          }else{

            let select_lista_servicios = $('#services-list-cita');

            $("#services-list-cita").val('');

          $.each(data, function (index, value) {
            select_lista_servicios.append('<option value="'+value.codigo_id+'">'+value.nombre_servicio+'</option>');
          });
            $("#loading").hide(1000)
          }
           
        },
      });
    }
  
        //CREAR CITA
        function crearCita(clbcodigo, slncodigo, sercodigo){
          $.ajax({
            type: "GET",
            url: "https://claudiachacon.com/beauty/beauty-pdv/newapi/controller/crearCita.php?token=CludiaCh4con",
            dataType: "json",
            data: { clbcodigo: clbcodigo, slncodigo: slncodigo, sercodigo: sercodigo, clicodigo: client_id, citfecha: fechaCita, 
            cithora:  horaCita, citobservaciones:  valorNota
          },
            success: function (data) {
              alertify.success('Cita Agendada');
            },
            error: function (data) {
              alertify.error('No se pudo agendar la cita');
            }
          });
        }
  
        //CREAR CITA
        function crearDomicilio(clbcodigo, slncodigo, sercodigo){
          let nota = valorNota + " " + direccion_cliente;
            $.ajax({
            type: "GET",
            url: "https://claudiachacon.com/beauty/beauty-pdv/newapi/controller/crearDomicilio.php?token=CludiaCh4con",
            dataType: "json",
            data: { clbcodigo: clbcodigo, slncodigo: 18, sercodigo: sercodigo, clicodigo: client_id, citfecha: fechaDomicilio, 
            cithora:  horaDomicilio, citobservaciones:  nota
          },
            success: function (data) {  
              alertify.success('Domicilio Agendado');
            },
            error: function (data) {
              alertify.error('No se pudo agendar el domicilio');
            }
          });
        }
    //obtener colaborador disponible
    function obtenerColaboradorDisponible(){  
  
   if(ternario_salon_id == salonDomicilio){
    hora = horaDomicilio;
    servicio = servicioDomicilio;
    fecha = fechaDomicilio;
   }else{
    hora = horaCita;
    servicio = servicioCita;
    fecha = fechaCita;
   }
  
   $.ajax({
        type: "GET",
        url: "https://claudiachacon.com/beauty/beauty-pdv/newapi/controller/cita.php?token=CludiaCh4con",
        dataType: "json",
        data: { sercodigo: servicio, slncodigo: ternario_salon_id, citfecha: '"' + fecha + '"', cithora: '"' + hora + '"'},
        success: function (data) {
          for(let cita of data){
            colaboradorDisponible = cita.colaborador_id
            salon_disponible = cita.salon_id;
            servicio_disponible = cita.servicio_id;
          }
  
          if(ternario_salon_id == salonDomicilio){
            crearDomicilio(colaboradorDisponible, salon_disponible, servicio_disponible);
          }else{
            crearCita(colaboradorDisponible, salon_disponible, servicio_disponible);
  
          }
        },
        error: function (data) {
          alertify.error('No hay colaborador disponible para esa hora');
        }
      });
    }
  
  
    document.getElementById('form-citas').addEventListener('submit', function(evento){
      evento.preventDefault();
  
      
      var nameClientValue = $('#name-client').text();
  
      if(nameClientValue == 'Cliente no registrado'){
        $('#name-client').text('');
      alertify.error('El cliente no se encuentra registrado');
      return false;
    }
  
      let documento = document.getElementById('document-client').value;
  
      if(!documento){
        $('#name-client').text('');
        alertify.error('Por favor ingrese un documento');
        return false;
      }
  
      let salon = document.getElementById('salon-list-cita').value;
      let fecha = document.getElementById('select-date-cita').value;
      let hora = document.getElementById('hour_salon_cita').value;
      let servicio = document.getElementById('services-list-cita').value;
  
      if(!salon){
        alertify.error('Seleccione un salon');
        return false;
      }
      if(!fecha){
        alertify.error('Seleccione una fecha');
        return false;
      }
      if(!hora){
        alertify.error('Seleccione una hora');
        return false;
      }
      if(!servicio){
        alertify.error('Seleccione un servicio');
        return false;
      }
  
      obtenerColaboradorDisponible();
  
  
      return false;
    });
      
    
   
    document.getElementById('form-domicilio').addEventListener('submit', function(evento){
      evento.preventDefault();
  
      var nameClientValue = $('#name-client').text();
  
      if(nameClientValue == 'Cliente no registrado'){
        $('#name-client').text('');
      alertify.error('El cliente no se encuentra registrado');
      return false;
    }
  
      let documento = document.getElementById('document-client').value;
  
      if(!documento){
        alertify.error('Por favor ingrese un documento');
        return false;
      }
  
      let direccion_domicilio = document.getElementById('direccion-domicilio').value;
      let fecha_domicilio = document.getElementById('select-date-domicilio').value;
      let hora_domicilio= document.getElementById('hour_salon_domicilio').value;
      let servicio_domicilio = document.getElementById('services-list-domicilio').value;
  
      if(!direccion_domicilio){
        alertify.error('Ingrese una direccion');
        return false;
      }
      if(!fecha_domicilio){
        alertify.error('Seleccione una fecha');
        return false;
      }
      if(!hora_domicilio){
        alertify.error('Seleccione una hora');
        return false;
      }
      if(!servicio_domicilio){
        alertify.error('Seleccione un servicio');
        return false;
      }
  
      obtenerColaboradorDisponible();
  
    });
  
  
    document.getElementById('crear-cliente-form').addEventListener('submit', function(evento){
      evento.preventDefault();
  
      let documento_crear_cliente = document.getElementById('documento-cliente').value;
      let nombre = document.getElementById('nombre-cliente').value;
      let apellido = document.getElementById('apellido-cliente').value;
      let dia = document.getElementById('day').value;
      let mes = document.getElementById('month').value;
      let telefono = document.getElementById('telefono-cliente').value;
      let email = document.getElementById('email-cliente').value;
  
      if(!documento_crear_cliente){
        alertify.error('Ingrese un documento');
        return false;
      }
      if(!nombre){
        alertify.error('Ingrese un nombre');
        return false;
      }
      if(!apellido){
        alertify.error('Ingrese un apellido');
        return false;
      }
      if(!dia){
        alertify.error('Ingrese una fecha de nacimiento');
        return false;
      }
      if(!mes){
        alertify.error('Ingrese una fecha de nacimiento');
        return false;
      }
      if(!telefono){
        alertify.error('Ingrese un telefono');
        return false;
      }
      if(!email){
        alertify.error('Ingrese un email');
        return false;
      }
  
  
      crearCliente();
      return false;
    });
    /*====== LOGICA PARA LAS FUNCIONES ======= */
    function obtenerDiaSemana(fechaCita) {
      let diaSemana;
      let arrayFecha = fechaCita.split('-');
      let anio = arrayFecha[0];
      let mes = arrayFecha[1];
      let dia = arrayFecha[2];
      let fecha = new Date(anio, mes - 1, dia);
      let dias = ['DOMINGO', 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO'];
      diaSemana = dias[fecha.getDay()];
      return diaSemana;
    }
    function horasMenu(horaInicial, horaFinal) {
        let minHora = horaInicial.split(":", 3);
        let maxHora = horaFinal.split(":", 3);
        let minHoraNum = Number(minHora[0]);
        let maxHoraNum = Number(maxHora[0]);
        
        let select = document.createElement("select");
        
        $('#hour_salon_cita').html('');
        
        // Agregar el valor default al select
        $('#hour_salon_cita').prepend("<option style='cursor:pointer' selected disabled>Selecciona una hora</option>");
        
        // Obtener la fecha actual
        let date = new Date();
        let currentHour = date.getHours();
        let currentDay = date.getDate();
        let fechaCita = new Date($('#select-date-cita').val());
        
        //Obtener la fecha de la cita
        let fechaCitaString = fechaCita.toISOString().split('T')[0];
        
        for (let i = minHoraNum; i <= maxHoraNum; i++) {
          // Ocultar las horas que ya han pasado
          if (i < currentHour && currentDay === minHoraNum) continue;
          // Ocultar las horas que ya han pasado
          
          //DIA ACTUAL
          let fechaActual = new Date().toISOString().split('T')[0];
        
          if(fechaCitaString == fechaActual){
            if (i < currentHour && currentDay !== minHoraNum) continue;
          }
          
          let hora = i < 10 ? "0" + i : i;
          $('#hour_salon_cita').append("<option style='cursor:pointer' value='" + hora + ":00:00'>" + hora + ":00</option>");
          
          if (i !== maxHoraNum) {
            let mediaHora = i < 10 ? "0" + (i) : i;
            $('#hour_salon_cita').append("<option style='cursor:pointer' value='" + mediaHora + ":30:00'>" + mediaHora + ":30</option>");
          }
        }
      }
      
      
      
      
      
      
      
      
    function obtenerDiaSemanaDomicilio(fechaCita) {
      let diaSemana;
      let arrayFecha = fechaCita.split('-');
      let anio = arrayFecha[0];
      let mes = arrayFecha[1];
      let dia = arrayFecha[2];
      let fecha = new Date(anio, mes - 1, dia);
      let dias = ['DOMINGO', 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO'];
      diaSemana = dias[fecha.getDay()];
      return diaSemana;
    }
    function horasMenuDomicilio(horaInicial, horaFinal) {
        let minHora = horaInicial.split(":", 3)
        let maxHora = horaFinal.split(":", 3)
        let minHoraMin = Number(minHora[1])
        let maxHoraMin = Number(maxHora[1])
      
        var minutos
      
        if (maxHoraMin === 0) minutos = 1
        else minutos = 30
      
        let minHoraNum = Number(minHora[0])
        let maxHoraNum = Number(maxHora[0])
      
        let select = document.createElement("select")
      
        $('#hour_salon_domicilio').html('');
        
        // Obtener la fecha actual
       // Obtener la fecha actual
    let date = new Date()
    let currentHour = date.getHours()
    let currentDay = date.getDate()
    let fechaCita = new Date($('#select-date-domicilio').val());
    
    //Obtener la fecha de la cita
    let fechaCitaString = fechaCita.toISOString().split('T')[0];
    
    for (let i = minHoraNum; i <= maxHoraNum; i++) {
      // Ocultar las horas que ya han pasado
      if (i < currentHour && currentDay === minHoraNum) {
        minHoraMin = date.getMinutes()
        $('#hour_salon_domicilio').append("<option style='cursor:pointer' value='" + i + ":" + minHoraMin + ":00'>" + i + ":" + minHoraMin + ":00</option>");
      }
      // Ocultar las horas que ya han pasado
    
      //DIA ACTUAL
      let fechaActual = new Date().toISOString().split('T')[0];
    
      if(fechaCitaString == fechaActual){
        if (i < currentHour && currentDay !== minHoraNum) continue
      }
      
      if (minHoraMin === 0) {
        $('#hour_salon_domicilio').append("<option style='cursor:pointer' value='" + i + ":00:00'>" + i + ":00:00</option>");
        minHoraMin = minutos
      } else {
        $('#hour_salon_domicilio').append("<option style='cursor:pointer' value='" + i + ":00:00'>" + i + ":00:00</option>");
        minHoraMin = 0
      }
    }
    }
  
  
    $(document).ready(function(){
      $('.spinner').animate({
          opacity: '1',
      }, 1000);
    });
  });
  
  
  


