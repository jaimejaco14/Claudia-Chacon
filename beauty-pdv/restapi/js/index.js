let salon_id_save = ""
let hora_save = ""
let valorIngresado = ""
let cliente_id = ""
let colaborador_id_save = ""
jQuery(document).ready(function ($) {

  document
    .getElementById("select-date")
    .addEventListener("change", function () {
      valor_hour_cita = this.value
      fechaTurno(valor_hour_cita)
    })

  document.getElementById("salon-list").addEventListener("click", function () {
    salon_id = this.value
  })

  document.getElementById("hour_salon").addEventListener("change", function () {
    hora_save = this.value
    console.log(hora_save)
  })

  document.getElementById("salon-list").addEventListener("change", function () {
    salon_id_save = this.value
    getColaboradores(this.value)
  })
  // document
  //   .getElementById("services-list")
  //   .addEventListener("change", function () {
  //     servicio_id = this.value
  //     //saveConsulta(this.value)
  //   })

  document
    .getElementById("document-client")
    .addEventListener("input", function () {
      valorIngresado = document.getElementById("document-client").value

      if (valorIngresado.length > 4) {
        $("#client-list").html("")
        console.log(valorIngresado);
        obtenerClient(valorIngresado)
      } else {
        $("#client-list").html("")
      }
    })
  function obtenerClient(cedula) {
    console.log("cedula", cedula)
    $.ajax({
      type: "GET",
      url: "https://claudiachacon.com/beauty/beauty-pdv/restapi/items/cliente.php",
      data: { documento: cedula },
      success: function (data) {
        $("#client-list").html("")
        for (let i = 0; i < data.length; i++) {
          console.log(data[i].cliente_id)
          $("#client-list").append(
            `<option style='cursor:pointer' value='` +
              data[i].documento +
              `' onclick='guardarNombre("` +
              data[i].razonsocial +
              `","` +
              data[i].cliente_id +
              `")'>` +
              data[i].razonsocial +
              "</option>"
          )
        }
      },
    })
  }



  $('#send-cita').click(function(){
    saveConsulta()
  });

})

function guardarNombre(nombre, id) {
  cliente_id = id
  console.log(cliente_id)
  document.querySelector("#client-list").innerHTML = ""
  document.getElementById("name-client").innerHTML = nombre
}

function servicios(colaboradores) {
  xhr = new XMLHttpRequest()
  xhr.open(
    "GET",
    "https://claudiachacon.com/beauty/beauty-pdv/restapi/items/servicios.php?colaborador_id=" +
      colaboradores +
      ""
  )
  xhr.send()
  xhr.responseType = "json"
  xhr.onload = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const data = xhr.response

      document.querySelector("#services-list").innerHTML = ""

      for (let i = 1; i < data.length; i++) {
        document.querySelector("#services-list").innerHTML +=
          `<option style='cursor:pointer' value='` +
          data[i].servicio_id +
          `'>` +
          data[i].nombre_servicio +
          "</option>"
      }
    } else {
    }
  }
}

function getColaboradores(id) {
  console.log("click colaboradores")
  xhr = new XMLHttpRequest()
  xhr.open(
    "GET",
    "https://claudiachacon.com/beauty/beauty-pdv/restapi/items/colaboradores.php?salon_id=" +
      id +
      ""
  )
  xhr.send()
  xhr.responseType = "json"
  xhr.onload = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const data = xhr.response

      let array_colaborador = []

      for (let i = 0; i < data.length; i++) {
        array_colaborador.push(data[i].colaborador_id)
      }

      colaborador_id_save = array_colaborador

      console.log("col", array_colaborador)
      servicios(id_colaborador)
    } else {
    }
  }
}
function horasMenu(horaInicial, horaFinal, intervalo, dia) {
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

  document.querySelector("#hour_salon").innerHTML = ""

  for (let i = minHoraNum; i <= maxHoraNum; i++) {
    if (minHoraMin === 0) {
      document.querySelector("#hour_salon").innerHTML +=
        "<option style='cursor:pointer' value='" +
        i +
        ":00:00'>" +
        i +
        ":00:00</option>"
      minHoraMin = 30
    } else {
      document.querySelector("#hour_salon").innerHTML +=
        "<option style='cursor:pointer' value='" +
        i +
        ":30:00'>" +
        i +
        ":30:00</option>"
      minHoraMin = 0
    }
  }

  return select
}



function getHorasOcupadas(params, horaInicial, horaFinal) {
  let day = params.fecha_cita.getDate() + 1
  let month = params.fecha_cita.getMonth() + 1
  let year = params.fecha_cita.getFullYear()
  const newDate = `${year}-${month}-${day}`

  const xhr = new XMLHttpRequest()

  xhr.open(
    "GET",
    `https://claudiachacon.com/beauty/beauty-pdv/restapi/items/disponibilidad.php?salon_id=${params.salon_id}&fecha_id="${newDate}"`
  )

  xhr.send()
  xhr.responseType = "json"

  xhr.onload = () => {
    if (Array.isArray(xhr.response)) {
      const horas = xhr.response.map((item) => item.hora_ocupada)
      intervaloHoras(horas, horaInicial, horaFinal)
    } else {
      intervaloHoras([], horaInicial, horaFinal)
    }
  }
}

function intervaloHoras(horas, horaInicial, horaFinal) {
  const horaIni = horaInicial.split(":")
  const horaFin = horaFinal.split(":")

  let seg = "00"
  let hora = parseInt(horaIni[0])
  let min = parseInt(horaIni[1])
  const finHora = parseInt(horaFin[0])
  const finMin = parseInt(horaFin[1])
  const finSeg = parseInt(horaFin[2])
  let intervalo = [
    {
      value: "",
      text: "",
    },
  ]
  if (finMin == 0 && finSeg == 0) {
    while (hora <= finHora) {
      //intervalo.push(`${hora}:00:00`);
      intervalo.push({
        value: `${hora < 10 ? "0" + hora : hora}:00:00`,
        text: `${hora}:00:00`,
      })
      hora++
    }
  } else {
    while (hora < finHora || min < finMin || seg < finSeg) {
      //intervalo.push(`${hora}:${min < 10 ? '0'+ min : min}:${0 < 10 ? '0' + 0 : 0}`);
      intervalo.push({
        value: `${hora < 10 ? "0" + hora : hora}:${
          min < 10 ? "0" + min : min
        }:${0 < 10 ? "0" + 0 : 0}`,
        text: `${hora}:${min < 10 ? "0" + min : min}:${0 < 10 ? "0" + 0 : 0}`,
      })
      min += 30
      if (min > 59) {
        hora++
        min = 0
      }
      seg = 0
    }
  }
  intervalo.push({ value: horaFinal, text: horaFinal })

  document.querySelector("#hour_salon").innerHTML = ""

  for (let i = 1; i < intervalo.length; i++) {
    if (!horas.includes(intervalo[i].value.toString())) {
      document.querySelector("#hour_salon").innerHTML +=
        "<option style='cursor:pointer' value=" +
        intervalo[i].value +
        ">" +
        intervalo[i].text +
        "</option>"
    }
  }
  intervalo = []
  return intervalo
}



function fechaTurno(fecha) {
  var fecha = new Date(fecha)
  var diasSemana = [
    "LUNES",
    "MARTES",
    "MIERCOLES",
    "JUEVES",
    "VIERNES",
    "SABADO",
    "DOMINGO",
  ]
  var diaActual = diasSemana[fecha.getDay()]

  const xhr = new XMLHttpRequest()

  xhr.open(
    "GET",
    "https://claudiachacon.com/beauty/beauty-pdv/restapi/items/turnos.php?salon_id=" +
      salon_id +
      ""
  )
  xhr.send()
  xhr.responseType = "json"
  xhr.onload = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const data = xhr.response
      for (let i = 0; i < data.length; i++) {
        if (data[i].dia == diaActual) {
          getHorasOcupadas(
            { fecha_cita: fecha, salon_id },
            data[i].desde,
            data[i].hasta
          )
        }
      }
    } else {
    }
  }
  return diaActual
}

function salones() {
  const xhr = new XMLHttpRequest()

  xhr.open(
    "GET",
    "https://claudiachacon.com/beauty/beauty-pdv/restapi/items/salones.php"
  )
  xhr.send()
  xhr.responseType = "json"
  xhr.onload = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const data = xhr.response
      for (let i = 0; i < data.length; i++) {
        document.querySelector("#salon-list").innerHTML +=
          `<option style="cursor:pointer"  value="` +
          data[i].salon_id +
          `">` +
          data[i].nombre_salon +
          "</option>"
      }
    } else {
    }
  }
}

salones()

function saveConsulta() {
  console.log("entroooooo")
  //params = JSON.parse(params)
  const message = document.getElementById("asunto-salon").value

  let servicio_id = document.getElementById("services-list").value

  
  console.log(colaborador_id_save, servicio_id, cliente_id, valor_hour_cita, hora_save)

  const paramsUrl = `?colaborador_id=${
    colaborador_id_save
  }&salon_id=${salon_id_save}&servicio_id=${
    servicio_id
  }&cliente_id=${cliente_id}&fecha_cita=${valor_hour_cita}&hora_cita=${hora_save}$asunto=${message}`
  console.log(paramsUrl)


  xhr.open(
    "GET",
    `https://claudiachacon.com/beauty/beauty-pdv/restapi/items/crearCita.php${paramsUrl}`
  )

  xhr.send()
  xhr.responseType = "json"
  xhr.onload = () => {}
}


