<?php
session_start();
if($_SESSION['codigoUsuario'] != 3){

    header('Location: https://www.claudiachacon.com');
    exit;
}
include 'head.php';
include "./librerias_js.php";

?>

<input type="text" value="<?php echo $_SESSION['codigoUsuario'];?>" id="codigoUsuario" readonly style="display: none;">

<div class="small-header">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="index.php">Inicio</a></li>
                    <li class="active"><span>Bonos</span></li>
                </ol>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="font-light m-b-xs">BONOS</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-6">
            <a href="#!" id="linkNuevoBono">
                <div class="hpanel hbgblue">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3 class="m-b-xs">VENTA BONOS</h3>
                            <div class="m">
                                <i class="pe-7s-cash fa-5x"></i>
                            </div>
                            <h5>Gesti&oacute;n de venta de bonos</h5>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!--<div class="col-md-6">
            <a href="#!" id="linkConsultaBono">
                <div class="hpanel hbgyellow">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3 class="m-b-xs">CONSULTA BONOS</h3>
                            <div class="m">
                                <i class="pe-7s-search fa-5x"></i>
                            </div>
                            <h5>Consulta estado de bonos bonos</h5>
                        </div>
                    </div>
                </div>
            </a>
        </div>-->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="hpanel">
                <div class="panel-body">
                    <h5>Listado de bonos</h5>
                    <div class="row">
                        <div class="col-md-2">
                            <input type="date" class="form-control input-sm" id="txtDesde"></div>
                        <div class="col-md-2">
                            <input type="date" class="form-control input-sm" id="txtHasta"></div>
                    </div>
                    <br>
                    <table id="tablaBonos" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">C&oacute;digo bono</th>
                                <!--<th class="text-center">Estado</th>-->
                                <th class="text-center">Valor inicial</th>
                                <th class="text-center">Valor actual</th>
                                <!--<th class="text-center">Caducidad</th>-->
                                <th class="text-center">Empresa</th>
                                <th class="text-center">Servicios</th>
                                <th class="text-center">Observaciones</th>
                                <th class="text-center">Fecha generaci&oacute;n</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Bono -->
<div class="modal fade" id="modalNuevoBono" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cerrarModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Nuevo Bono</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtFechaElaboracion">Fecha de elaboraci&oacute;n</label>
                            <input type="text" id="txtFechaElaboracion" disabled class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtValor">Valor*</label>
                            <input type="number" min="0" id="txtValor" placeholder="Valor" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtNombres">Nombres</label>
                            <input type="text" id="txtNombres" maxlength="30" class="form-control" placeholder="Nombres">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtApellidos">Apellidos</label>
                            <input type="text" id="txtApellidos" maxlength="30" class="form-control" placeholder="Apellidos">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtIdentificacion">Identificaci&oacute;n</label>
                            <input type="number" id="txtIdentificacion" placeholder="No. Identificaci&oacute;n" min="0" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtCorreo">Correo</label>
                            <input type="email" id="txtCorreo" placeholder="Correo" maxlength="30" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtCelular">Celular</label>
                            <input type="number" id="txtCelular" placeholder="Celular" min="0" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="txtEmpresa">Nombre de la empresa</label>
                            <input type="text" id="txtEmpresa" placeholder="Empresa" maxlength="100" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtServicios">Servicios</label>
                            <textarea id="txtServicios" rows="3" maxlength="500" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="txtObservaciones">Observaciones</label>
                            <textarea id="txtObservaciones" rows="3" maxlength="500" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span><small>(*) Campos obligatorios</small></span>
                <button class="btn btn-default cerrarModal" id="btnCerrarModal">Cerrar</button>
                <button class="btn btn-primary" id="btnGenerarBono">Generar bono</button>
            </div>
        </div>
    </div>
</div>

<script>

$.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            
            fechaDesde = $('#txtDesde').val();
            diaDesde = parseInt(fechaDesde.substring(8, 10)) - 1;
            mesDesde = parseInt(fechaDesde.substring(5, 7)) - 1;
            anoDesde = parseInt(fechaDesde.substring(0, 4));
            fechaDesde = new Date(anoDesde, mesDesde, diaDesde).getTime();
            
            fechaHasta = $('#txtHasta').val();
            diaHasta = parseInt(fechaHasta.substring(8, 10)) - 1;
            mesHasta = parseInt(fechaHasta.substring(5, 7)) - 1;
            anoHasta = parseInt(fechaHasta.substring(0, 4));
            fechaHasta = new Date(anoHasta, mesHasta, diaHasta).getTime();
            
            diaBono = parseInt(data[6].substring(0, 2)) - 1;
            mesBono = parseInt(data[6].substring(3, 5)) - 1;
            anoBono = parseInt(data[6].substring(6, 10));
            fechaBono = new Date(anoBono, mesBono, diaBono).getTime();

            if(
                (isNaN(fechaDesde) && isNaN(fechaHasta)) ||
                (isNaN(fechaDesde) && fechaBono <= fechaHasta) ||
                (fechaDesde <= fechaBono && isNaN(fechaHasta)) || 
                (fechaDesde <= fechaBono && fechaBono <= fechaHasta)
            ){
                return true;
            }

            return false;
        }
    );

    $(document).ready(function(){

        var expRegLetras = /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\s]+$/;
        var expRegEmails = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
        var expRegNumeros = /^[0-9]+$/;
        var listadoBonos = listarBonos();
        
        $('#txtDesde, #txtHasta').on('change', function(){

            listadoBonos.draw();
        });
        
        $('#linkNuevoBono').on('click', function(){

            fecha = new Date();
            dia = fecha.getDate();
            mes = fecha.getMonth() + 1;
            fecha = (dia < 10 ? '0' : '') + dia + '/' + (mes < 10 ? '0' : '') + mes + '/' + fecha.getFullYear();
            $('#txtFechaElaboracion').val(fecha);
            $('#modalNuevoBono').modal('show');
        });

        $('#btnGenerarBono').on('click', function(){

            nombres = $('#txtNombres').val().trim();
            apellidos = $('#txtApellidos').val().trim();
            identificacion = $('#txtIdentificacion').val().trim();
            correo = $('#txtCorreo').val().trim();
            celular = $('#txtCelular').val().trim();
            empresa = $('#txtEmpresa').val().trim();
            valor = $('#txtValor').val().trim();
            servicios = $('#txtServicios').val().trim();
            observaciones = $('#txtObservaciones').val().trim();
            codigoUsuario = $('#codigoUsuario').val().trim();
            errores = validarDatos(nombres, apellidos, identificacion, correo, celular, empresa, valor);
            
            if(errores.length > 0){
                
                mensajesError = '';

                $.each(errores, function (i, error) { 
                     mensajesError += '-' + error + '\n';
                });

                swal("Error", mensajesError, "error");
            }
            else{

                $.ajax({
                    type: "POST",
                    url: "php/bonos/process.php",
                    data: {
                        nombres: nombres,
                        apellidos: apellidos,
                        identificacion: identificacion,
                        correo: correo,
                        celular: celular,
                        empresa: empresa,
                        valor: parseInt(valor),
                        servicios: servicios,
                        observaciones: observaciones,
                        metodo: "generarBono",
                        codigoUsuario: codigoUsuario
                    },
                    dataType: "json",
                    success: function (res) {
                        
                        if(res.data.desc == "OK"){

                            swal("Bono con código " + res.data.codigoBono + " generado con éxito", "Valor: $" + formatearMiles(res.data.valorBono), 'success');
                            $('#modalNuevoBono').modal('hide');
                            borrarDatosModal();
                            $('#tablaBonos').DataTable().ajax.reload();
                        }
                        else{
                            
                            swal("ERROR", res.data.mensaje, 'error');
                        }
                    },
                    error: function (res) { 

                        swal("Ocurrió un error al generar el bono", '', 'error');
                        console.log('Error 1');
                        console.log(res);
                    }
                });
            }
        });

        $('.cerrarModal').on('click', function(){
            $('#modalNuevoBono').modal('hide');
            borrarDatosModal();
        });
        
        function borrarDatosModal(){
            $('#txtNombres').val('');
            $('#txtApellidos').val('');
            $('#txtIdentificacion').val('');
            $('#txtCorreo').val('');
            $('#txtCelular').val('');
            $('#txtEmpresa').val('');
            $('#txtValor').val('');
            $('#txtServicios').val('');
            $('#txtObservaciones').val('');
        }

        function validarDatos(nombres, apellidos, identificacion, correo, celular, empresa, valor){

            errores = [];

            if(nombres.length > 0 && !nombres.match(expRegLetras)){
                errores.push('Nombres debe tener sólo letras');
            }

            if(apellidos.length > 0 && !apellidos.match(expRegLetras)){
                errores.push('Apellidos debe tener sólo letras');
            }

            if(identificacion.length > 0 && !identificacion.match(expRegNumeros)){
                errores.push('Identificacion debe tener sólo números');
            }
            else if(identificacion.length > 0 && identificacion.length < 7){
                errores.push('Identificación inválida');
            }

            if(correo.length > 0 && !correo.match(expRegEmails)){
                errores.push('Correo debe tener un formato válido');
            }

            if(celular.length > 0 && !celular.match(expRegNumeros)){
                errores.push('Celular debe tener sólo números');
            }
            else if(celular.length > 0 && celular.length < 10){
                errores.push('Numero de celular inválido');
            }
            
            if(valor.length == 0){
                errores.push('Valor no puede estar vacío');
            }
            else if(!valor.match(expRegNumeros)){
                errores.push('Valor no puede tener caracteres especiales');
            }
            
            return errores;
        }

        function formatearMiles(numero){
            
            return parseInt(numero).toLocaleString('de-DE', {minimumFractionDigits: 0});
        }

        function listarBonos(){
            
            return $('#tablaBonos').DataTable({
                ajax: {
                    method: 'GET',
                    url: 'php/bonos/process.php',
                    data: {
                        metodo: 'listarBonos'
                    }
                },
                dom: 'Bfrtlp',
                buttons: [{
                    extend:    'pdfHtml5',
                    text:      '<i class="fa fa-file-pdf-o text-danger"></i>',
                    titleAttr: 'Exportar como PDF'
                },
                {
                    extend:    'excel',
                    text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
                    titleAttr: 'Exportar como Excel'
                }],
                columns: [
                    {data: 'boncupon'},
                    //{data: 'bonactivo'},
                    {data: 'bonvalorinicial'},
                    {data: 'bonvaloractual'},
                    {data: 'bonempresa'},
                    {data: 'bonservicios'},
                    {data: 'bonobservaciones'},
                    //{data: 'bonfechacaducidad'},
                    {data: 'bonfecharegistro'},
                    {render: function(data, type, JsonResultRow, meta){
                        //return '<button class="btn btn-default">Detalle</button><button class="btn btn-default" title="Eliminar"><i class="fa fa-ban text-info"></i></button>'
                        if(JsonResultRow.bonactivo == 1){
                            return '<button class="btn btn-default" title="Desactivar bono" onclick="desactivarBono(' + JsonResultRow.boncodigo + ')"><i class="fa fa-ban text-info"></i></button>';
                        }
                        else{
                            return '';
                        }
                    }}
                ],
                language: {
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    info: 'Mostrando página _PAGE_ de _PAGES_',
                    infoEmpty: 'No hay registros disponibles',
                    loadingRecords: 'Cargando...',
                    processing: 'Procesando...',
                    search: '_INPUT_',
                    infoFiltered: "(filtrada de _MAX_ registros)",
                    searchPlaceholder: 'Buscar bono...',
                    zeroRecords: 'No se encontraron registros coincidentes',
                    paginate: {
                        previous: 'Anterior',
                        next: 'Siguiente' 
                    }
                },
                order: [[6, 'desc']],
                bDestroy: true,
                lengthMenu: [[7, 15, 30], [7, 15, 30]],
                columnDefs: [
                    {className:"text-center","targets":[0]},
                    {className:"text-center","targets":[1]},
                    {className:"text-center","targets":[2]},
                    {className:"text-center","targets":[6]},
                    {className:"text-center","targets":[7]},
                ],
            });
        }
    });

    function desactivarBono(codigoBono){
            $.ajax({
                type: "POST",
                url: "php/bonos/process.php",
                data: {
                    metodo: 'desactivarBono',
                    codigoBono: codigoBono
                },
                success: function (res){
                    
                    res = JSON.parse(res);

                    if(res.data.desc == 'OK'){
                        swal(res.data.mensaje, '', 'success');
                        $('#tablaBonos').DataTable().ajax.reload();
                    }
                    else{
                        swal(res.data.mensaje, '', 'error');
                    }
                },
                error: function(res){
                    swal('No se pudo desactivar el bono', '', 'danger');
                }
            });
        }

</script> 
</body>
</html>
