<?php  
include 'head.php';
include 'librerias_js.php';
?>
<style type="text/css" media="screen">
  #wrapper{
    background-color: white;
  }
  .inpfecha[readonly]{
    cursor:pointer;
    background-color: white;
  }
  .inpfecha2[readonly]{
    cursor:pointer;
    background-color: white;
  }
  
  td,th{
        font-size: .8em!important;
    }
    .table-cont{
    /**make table can scroll**/
    /* max-height: 400px;
    overflow: auto; */
    /** add some style**/
    /*padding: 2px;*/
    /* background: #ddd;
    margin: 20px 10px;
    box-shadow: 0 0 1px 3px #ddd;  */
  }
  .alltables thead{
    background-color: #ddd;
  }
</style>
<!-- Pantalla Ppal -->
<div id="opciones" class="content">
  <div class="row">
    <div class="col-md-4">
      <div id="swproce" class="hpanel hbgblue" style="cursor:pointer;">
          <div class="panel-body">
              <div class="text-center">
                  <h3>DATOS POR FECHA</h3>
                  <p class="text-big font-light"><i class="fa fa-calendar"></i></p>
                  <small>Permite buscar datos por rango de fechas</small>
              </div>
          </div>
      </div>
    </div>
    <div class="col-md-4">
      <div id="swcompa" class="hpanel hbgblue" style="cursor:pointer;">
          <div class="panel-body">
              <div class="text-center">
                  <h3>COMPARADOR</h3>
                  <p class="text-big font-light"><i class="fa fa-line-chart"></i></p>
                  <small>Permite comparar datos entre varios salones o periodos</small>
              </div>
          </div>
      </div>
    </div>
    <div class="col-md-4">
      <div id="swliqui" class="hpanel hbgblue" style="cursor:pointer;">
          <div class="panel-body">
              <div class="text-center">
                  <h3>REPORTES</h3>
                  <p class="text-big font-light"><i class="fa fa-money"></i></p>
                  <small>Generador de reportes</small>
              </div>
          </div>
      </div>
    </div> 
  </div>
</div>
<!-- procesador -->
<div id="procesador" class="l2 hidden">
  <button class="btn btn-default mepri"><i class="fa fa-back"></i>Menu principal</button>
  <div class="container">
    <div class="">
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="">Salón(es)</label>
            <h4 class="loadingsln"><i class="fa fa-spin fa-spinner"></i> Cargando salones...</h4>
            <select id="selsln" class="hidden selsln form-control filter" multiple title="Elija salón (Omitir para todos)"></select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="col-md-6">
            <label for="">F/Desde</label>
            <input class="form-control text-center filter inpfecha" id="fdesde" readonly placeholder="Fecha inicial">
          </div>
          <div class="col-md-6">
            <label for="">F/Hasta</label>
            <input class="form-control text-center filter inpfecha" id="fhasta" readonly placeholder="Fecha Final">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <br>
            <button id="calc" class="form-control btn btn-info">Procesar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="">
    <div class="row">
      <div id="result" class="col-md-3">
        <div class="table-responsive">
            <h6 class="loadmsj hidden"><i class="fa fa-spin fa-spinner"></i> Cargando, por favor espere...</h6>
            <table id="tbst1" class="table table-bordered table-hover hidden">
                <tr>
                  <th class="">Total servicios <button class="detsrv btn btn-default btn-xs pull-right hidden"><i class="fa fa-scissors"></i></button></th><td class="text-right"></td>
                </tr>
                <tr>
                  <th class="">Efectivo</th><td class="text-right"></td>
                </tr>
                <tr>
                  <th class="">Tarjetas <button class="dettrj btn btn-default btn-xs pull-right hidden"><i class="fa fa-credit-card"></i></button></th><td class="text-right"></td>
                </tr>
                <tr>
                  <th class="">Otros Pagos</th><td class="text-right"></td>
                </tr>
                <tr>
                  <th class="">Total Facturado <button class="detvta btn btn-default btn-xs pull-right hidden"><i class="fa fa-shopping-cart"></i></button></th><td class="text-right"></td>
                </tr>
            </table>
        </div>
      </div>
      <div class="col-md-9">
        <div id="tabdetalle" class="hidden" role="tabpanel">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
              <a href="#tab" aria-controls="tab" role="tab" data-toggle="tab">Por Colaborador</a>
            </li>
            <!-- <li role="presentation" >
              <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Por Factura</a>
            </li> -->
          </ul>
        
          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab">
              <h6 class="loadmsj3 hidden"><i class="fa fa-spin fa-spinner"></i> Cargando detalle de colaboradores. Esta operacion puede tardar en ejecutarse. por favor, sea paciente...</h6>
              <div id="dvtbdetcol" class="table-responsive table-cont">
                <table id="tbdetcol" class="alltables table table-hover table-bordered hidden">
                  <thead>
                    <tr>
                      <th class="text-center">Colaborador</th>
                      <th class="text-center">Cargo</th>
                      <th class="text-center">Servicios</th>
                      <th class="text-center">Productos</th>
                      <th class="text-center">Quimicos</th>
                      <th class="text-center">Tiquetes</th>
                      <th class="text-center">Insumos</th>
                      <th class="text-center">Descuentos</th>
                      <th class="text-center">Base Liq</th>
                      <th class="text-center">Detalles</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
                <!-- <button id="btndetcol" class="btn btn-info btn-xs">Cargar detalles</button> -->
              </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="home">
              <h6 class="loadmsj2 hidden"><i class="fa fa-spin fa-spinner"></i> Cargando detalle de ventas...</h6>
              <div id="detalles" class="table-cont table-responsive">
                <table id="tbdetvta" class="tbdetvta alltables table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th class="text-center">No Factura</th>
                      <th class="text-center">Cliente</th>
                      <th class="text-center">T. Servicios</th>
                      <th class="text-center">T. Productos</th>
                      <th class="text-center">T. Descuentos</th>
                      <th class="text-center">F. de Pago</th>
                      <th class="text-center">TOTAL</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- comparador -->
<div id="comparador" class="l2 hidden">
  <button class="btn btn-default mepri"><i class="fa fa-back"></i>Menu principal</button>
  <div class="content">
    <section>
      <div class="row">
        <div class="col-md-4"> 
          <h2 class="text-center">Criterios a comparar</h2>
        </div>
         <div class="col-md-8"> 
          <h2 class="text-center">Salones y periodos a comparar</h2>
        </div>
        
    </div>
      <div class="row">
        <div class="col-md-2">
          <div class="input-group">
            <span class="input-group-addon"><input type="checkbox" id="cserv" checked></span>
            <input type="text" class="form-control" value="Total Servicios" readonly>
          </div>
        </div>
        <div class="col-md-2">
          <div class="input-group">
            <span class="input-group-addon"><input type="checkbox" id="cvta" checked></span>
            <input type="text" class="form-control" value="Total Ventas" readonly>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <h4 class="loadingsln"><i class="fa fa-spin fa-spinner"></i> Cargando salones...</h4>
            <select class="hidden form-control selsln" id="selsln2" multiple></select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="col-md-6">
            <input class="form-control text-center filter inpfecha" id="fdesde2" readonly placeholder="Fecha inicial">
          </div>
          <div class="col-md-6">
            <input class="form-control text-center filter inpfecha" id="fhasta2" readonly placeholder="Fecha Final">
          </div>
        </div>
        <div class="col-md-2">
          <button id="additem" class="btn btn-info"><i class="fa fa-plus"></i> Agregar</button>
        </div>
      </div>
    </section>
    <section>
      <div class="col-md-8"> 
        <table id="tbcompa" class="table table-hover table-bordered">
          <thead class="hidden"></thead>
          <tbody class="hidden"></tbody>
        </table>
      </div>
      <div class="btnproc col-md-4 hidden"> 
        <button class="goco btn btn-primary"><i class="fa fa-gear"></i> Comparar</button>
        <button class="reset btn btn-danger"><i class="fa fa-times"></i> Borrar</button>
      </div>
    </section>    
  </div>
</div>
<!-- REPORTES -->
<div id="reportes" class="l2 hidden">
  <button class="btn btn-default mepri"><i class="fa fa-back"></i>Menu principal</button>
  <h3 class="text-center">Generador de Reportes</h3>
  <div class="content">
    <div class="row">
      <div class="col-md-2 divbtn"><button id="btnxcol" class="btn btn-info btn-lg btn-block btntrp"><i class="fa fa-user"></i><br>Por Colaborador</button></div>
      <div class="col-md-2 divbtn"><button id="btnxsln" class="btn btn-info btn-lg btn-block btntrp"><i class="fa fa-university"></i><br>Por Salón</button></div>
      <div class="col-md-2 divbtn"><button id="btnxser" class="btn btn-info btn-lg btn-block btntrp"><i class="fa fa-scissors"></i><br>Por Servicio</button></div>
      <div class="col-md-2 divbtn"><button id="btnxpro" class="btn btn-info btn-lg btn-block btntrp"><i class="fa fa-tint"></i><br>Por Producto</button></div>

      <div class="col-md-4 divsel divselcol hidden">
        <select id="rpselcol" class="selcol selitem form-control" multiple></select>
      </div>
      <div class="col-md-3 divsel divselsln hidden">
        <h4 class="loadingsln"><i class="fa fa-spin fa-spinner"></i> Cargando salones...</h4>
        <select id="rpselsln" class="hidden selsln selitem form-control" multiple title="Elija salón (Omitir para todos)"></select>
      </div>
      <div class="col-md-3 divsel divselsrv hidden">
        <select id="rpselser" class="selsrv selitem form-control" multiple title="Elija Servicio(s)"></select>
      </div>
      <div class="col-md-3 divsel divselpro hidden">
        <h4 id="loadingpro"><i class="fa fa-spin fa-spinner"></i> Cargando Productos...</h4>
        <select id="rpselpro" class="hidden selpro selitem form-control" multiple title="Buscar y seleccionar Producto"></select>
      </div>
      <div class="col-md-3 divdate hidden">
        <div class="col-md-6">
          <input class="form-control text-center rptctrl inpfecha2" id="rpfdesde" readonly placeholder="Desde">
        </div>
        <div class="col-md-6">
          <input class="form-control text-center rptctrl inpfecha2" id="rpfhasta" readonly placeholder="Hasta">
        </div>
      </div>
      <div class="col-md-2 divcancel hidden pull-right">
        <input type="hidden" id="genopt">
        <button id="btncancel" class="btn btn-danger btnprocess btn-sm"><i class="fa fa-times"></i> Cancelar</button>
        <button id="btngen" class="btn btn-info btnprocess btn-sm"><i class="fa fa-gear"></i> Generar</button>
      </div>
    </div>
    <div class="container">
      <div id="tbloading" class="hidden"><br><br><h5><i class="fa fa-spin fa-spinner"></i> Cargando datos...</h5></div>
      <div id="divtbres" class="table-responsive hidden">
        <h4 id="tbrestitle" class="text-center"></h4>
        <table id="tbres" class="table table-hover">
          <thead><tr></tr></thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- MODALES -->

  <!-- Modal detalle de servicios -->
  <div class="modal fade" id="modal-detserv">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="fa fa-scissors"></i> Servicios prestados</h4>
        </div>
        <div class="modal-body">
          <div id="tbdetser" class="table-cont">
            <table  class="tbdetser alltables table table-hover">
              <thead>
                <tr>
                  <th class="text-center">Servicio</th>
                  <th class="text-center">Cantidad</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal detalle tarjetas -->
  <div class="modal fade" id="modal-dettrj">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="fa fa-credit-card"></i> Distribución de pagos con tarjeta</h4>
        </div>
        <div class="modal-body">
          <table class="tbdettrj table table-hover">
            <thead>
              <tr>
                <th class="text-center">Tarjeta</th>
                <th class="text-center">Valor</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal detalle factura -->
  <div class="modal fade" id="modal-detfact" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="fa fa-file-text-o"></i> Detalle de factura <b class="dfnum"></b></h4>
        </div>
        <div class="modal-body">
          <div class="loadingdetfact"><h4><i class="fa fa-spin fa-spinner"></i> Cargando datos...</h4></div>
          <div class="resdetfact hidden">
            <div class="form-group">
              <h5>Cliente: <b class="dfcli"></b></h5>
              <h5>Fecha: <b class="dfdate"></b></h5>
            </div>
            <div class="table-responsive">
              <table class="tbdetfact alltables table table-hover">
                <thead>
                  <tr>
                    <th class="text-center">Servicio/Producto</th>
                    <th class="text-center">Colaborador</th>
                    <th class="text-center">Valor</th>
                    <th class="text-center">Descuento</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                  <tr>
                    <th class="text-right" colspan="3">Efectivo</th><td class="tefe text-right"></td>
                  </tr>
                  <tr>
                    <th class="text-right" colspan="3">Tarjeta<b class="dettrjt"></b></th><td class="ttrj text-right"></td>
                  </tr>
                  <tr>
                    <th class="text-right" colspan="3">Total Factura</th><td class="tfact text-right"></td>
                  </tr>
                  
                </tfoot>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal liquidacion colaborador -->
  <div class="modal fade" id="modal-liqcol" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="fa fa-user"></i> Liquidación de colaborador</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <h5>Colaborador: <b class="nomcol"></b></h5>
            <h5>Cargo: <b class="crgcol"></b></h5>
            <h5>Fecha: <b class="fchcol"></b></h5>
          </div>
          <div id="dvtbliqcol" class="table-cont">
            <table id="tbliqcol" class="tbliqcol alltables table table-hover">
              <thead>
                <tr>
                  <th class="text-center">Fecha</th>
                  <th class="text-center">No Fact</th>
                  <th class="text-center">Servicios</th>
                  <th class="text-center">Productos</th>
                  <th class="text-center">Quimicos</th>
                  <th class="text-center">Tiquete</th>
                  <th class="text-center">Insumos</th>
                  <th class="text-center">Descuentos</th>
                  <th class="text-center">Base Liq</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>
<!-- scripts de Inicio -->
  <script type="text/javascript">
    $(document).ready(function() {
      loadpro();
      loadsln();
      loadclb();
      loadsvc();
      $(".inpfecha").datepicker({
        format:'yyyy-mm-dd',
        autoclose: true,
        startView: 1
      });
      $(".inpfecha2").datepicker({
        format:'yyyy-mm',
        minViewMode: "months",
        autoclose: true,
        startView: 1
      });
      /*$('#rpselpro').selectpicker({
        liveSearch: true,
        title:'Buscar y seleccionar producto(s)...'
      });*/
    });
    $(".mepri").click(function(e){
      $(".l2").addClass('hidden');
      $("#opciones").removeClass('hidden');
    })
    $("#swproce").click(function(e){
      $("#opciones").addClass('hidden');
      $("#procesador").removeClass('hidden');
    });
    $("#swcompa").click(function(e){
      $("#opciones").addClass('hidden');
      $("#comparador").removeClass('hidden');
    });
    $("#swliqui").click(function(e){
      $("#opciones").addClass('hidden');
      $("#reportes").removeClass('hidden');
    });
    function loadsln(){
      $.ajax({
        url:'estadistica/process.php',
        type:'POST',
        data:{opc:'listsln'},
        success:function(res){
          var dt=JSON.parse(res);
          var i=0;
          var opc='<optgroup class="opttpo optcls" label="Por tipo de salón">';
          for(var i in dt.tipo){
            opc+='<option class="opttpo optcls" data-sw="tpo" value="t-'+dt.tipo[i].cod+'">'+dt.tipo[i].nom+'</option>';
          }
          opc+='</optgroup><optgroup class="optsln optcls" label="Por Salón">';
          for(var i in dt.sln){
            opc+='<option class="optsln optcls" data-sw="sln" value="s-'+dt.sln[i].cod+'">'+dt.sln[i].nom+'</option>';
          }
          opc+='</optgroup>';
          $(".selsln").html(opc).select2({
            placeholder:"Elija salones (Omitir para todos)",
            closeOnSelect: false,
            allowClear: true
          });
          $(".loadingsln").addClass('hidden');
          $(".selsln").removeClass('hidden');
        }
      })
    }
    function loadclb(){
      $.ajax({
        url:'estadistica/process.php',
        type:'POST',
        data:{opc:'loadcol'},
        success:function(res){
          var dt=JSON.parse(res);
          var i=0;
          var opc='';
          for(var i in dt){
            opc+='<option value="'+dt[i].cod+'">'+dt[i].nom+'</option>';
          }
          $("#rpselcol").html(opc).select2({
            placeholder:"Seleccione colaborador(es)...",
          });
        }
      })
    }
    function loadsvc(){
      $.ajax({
        url:'estadistica/process.php',
        type:'POST',
        data:{opc:'loadsvc'},
        success:function(res){
          var dt=JSON.parse(res);
          var i=0;
          var opc='';
          for(var i in dt){
            opc+='<option value="'+dt[i].cod+'">'+dt[i].nom+'</option>';
          }
          $("#rpselser").html(opc).select2({
            placeholder:"Elija servicios (omitir para todos)...",
          });
        }
      })
    }
    function loadpro(){
      $.ajax({
          url: 'estadistica/process.php',
          type: 'POST',
          data:'opc=loadpro',
          success: function(data){
            if(data){
              var json = JSON.parse(data);
              var opcs = "";
              for(var i in json){
                  opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+"</option>";
              }
              $("#rpselpro").html(opcs).select2({
                placeholder:"Elija Producto(s) (Omitir para todos)",
                closeOnSelect: false,
                allowClear: true
              });
              $("#loadingpro").addClass('hidden');
              $("#rpselpro").removeClass('hidden');
            }
          }
      }); 
    }
    $(".selsln").change(function(){
      var item=$(this).val();
      var cls=$(".selsln").find(':selected').data('sw');
      if(cls=='sln'){
        $(".opttpo").addClass('hidden');
      }else{
        $(".optsln").addClass('hidden');
      }
      if(item==null){
        $(".optcls").removeClass('hidden');
      }
    });
    /*$('#rpselpro').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('algo');
        $('.algo .form-control').attr('id', 'fucker');
    });
    $(document).on('keyup', '#fucker', function(event) {
        var seek = $(this).val();
        if(seek.length>=4){
          $.ajax({
              url: 'estadistica/process.php',
              type: 'POST',
              data:'opc=loadpro&txt='+seek,
              success: function(data){
                if(data){
                  var json = JSON.parse(data);
                  var opcs = "";
                  for(var i in json){
                      opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+"</option>";
                  }
                  $("#rpselpro").html(opcs).selectpicker('refresh');
                }
              }
          }); 
        }
    });*/

  </script>
<!-- SCRIPTS DE PROCESAMIENTO -->
  <script type="text/javascript">
    //function tbscroll(table){
      function scrollHandle (e){
        var scrollTop = this.scrollTop;
        this.querySelector('thead').style.transform = 'translateY(' + scrollTop + 'px)';
      }
      
      //table.addEventListener('scroll',scrollHandle);
   // }
  </script>
  <script type="text/javascript">
    $("#calc").click(function(e){
      $(".loadmsj").removeClass('hidden');
      var selsln = $("#selsln").val();
      if(selsln!=null){
        for(var i = 0, len = selsln.length; i < len; i++) {
            selsln[i] = selsln[i].replace(/^t-/, '');
            selsln[i] = selsln[i].replace(/^s-/, '');
        }
      }
      var ts=$("#selsln").find(':selected').data('sw');
      var fdesde = $("#fdesde").val();
      var fhasta = $("#fhasta").val();
      if(fhasta >= fdesde){
        $("#calc").html('<i class="fa fa-spin fa-spinner"></i>').attr('disabled', true);
        $("#tbst1 td").html('<i class="fa fa-spin fa-spinner"></i>');
        $.ajax({
          url:'estadistica/process.php',
          type:'POST',
          data:{opc:'stat1',selsln:selsln,fdesde:fdesde,fhasta:fhasta,ts:ts},
          success:function(res){
            var dt=JSON.parse(res);
            $("#tbst1").removeClass('hidden');
            $(".loadmsj").addClass('hidden');
            $("#tbst1 td:eq(0)").html(dt.tcsc);
            if(dt.tcsc>0){
              $(".detsrv").removeClass('hidden');
            }else{
              $(".detsrv").addClass('hidden');
            }
            if(dt.ttrj!=0){ 
              $(".dettrj").removeClass('hidden');
            }else{
              $(".dettrj").addClass('hidden');
            }
            if(dt.tvlr!=0){ 
              $(".detvta").removeClass('hidden');
            }else{
              $(".detvta").addClass('hidden');
            }
            $("#tbst1 td:eq(1)").html('$ '+dt.teft);
            $("#tbst1 td:eq(2)").html('$ '+dt.ttrj);
            $("#tbst1 td:eq(3)").html('$ '+dt.totr);
            $("#tbst1 td:eq(4)").html('$ '+dt.tvlr);
            $("#calc").html('Procesar').removeAttr('disabled');
            $(".optcls").removeClass('hidden');
          }
        });
      }else{
        swal('Fechas inválidas','El rango de fechas es incorrecto','warning');
      }
    });

    $(".detsrv").click(function(e){
      $btn=$(this);
      var selsln = $("#selsln").val();
      var fdesde = $("#fdesde").val();
      var fhasta = $("#fhasta").val();
      if(selsln!=null){
        for(var i = 0, len = selsln.length; i < len; i++) {
            selsln[i] = selsln[i].replace(/^t-/, '');
            selsln[i] = selsln[i].replace(/^s-/, '');
        }
      }
      $btn.attr('disabled','disabled');
      $.ajax({
        url:'estadistica/process.php',
        type:'POST',
        data:{opc:'detsvc',selsln:selsln,fdesde:fdesde,fhasta:fhasta},
        success:function(res){
          var dt=JSON.parse(res);
          var tb='';
          var i=0;
          for (i in dt){
            tb+='<tr><td>'+dt[i].nser+'</td><td class="text-center">'+dt[i].cant+'</td></tr>';
          }
          $(".tbdetser tbody").html(tb);
          var tableCont = document.querySelector('#tbdetser');
          tableCont.addEventListener('scroll',scrollHandle);
          $("#modal-detserv").modal('show');
          $btn.removeAttr('disabled');
        }
      })
    });
    $(".dettrj").click(function(e){
      $btn=$(this);
      var selsln = $("#selsln").val();
      var fdesde = $("#fdesde").val();
      var fhasta = $("#fhasta").val();
      if(selsln!=null){
        for(var i = 0, len = selsln.length; i < len; i++) {
            selsln[i] = selsln[i].replace(/^t-/, '');
            selsln[i] = selsln[i].replace(/^s-/, '');
        }
      }
      $btn.attr('disabled','disabled');
      $.ajax({
        url:'estadistica/process.php',
        type:'POST',
        data:{opc:'dettrj',selsln:selsln,fdesde:fdesde,fhasta:fhasta},
        success:function(res){
          var dt=JSON.parse(res);
          var tb='';
          var i=0;
          for (i in dt){
            tb+='<tr><td>'+dt[i].ntrj+'</td><td class="text-right">'+dt[i].vtrj+'</td></tr>';
          }
          $(".tbdettrj tbody").html(tb);
          $("#modal-dettrj").modal('show');
          $btn.removeAttr('disabled');
        }
      })
    });
    $(".detvta").click(function(e){
      $("#tabdetalle").removeClass('hidden');
      var selsln = $("#selsln").val();
      var fdesde = $("#fdesde").val();
      var fhasta = $("#fhasta").val();
      if(selsln!=null){
        for(var i = 0, len = selsln.length; i < len; i++) {
            selsln[i] = selsln[i].replace(/^t-/, '');
            selsln[i] = selsln[i].replace(/^s-/, '');
        }
      }
      //$("#detalles").addClass('hidden');
      //$(".loadmsj2").removeClass('hidden');
     /* $.ajax({
        url:'estadistica/process.php',
        type:'POST',
        data:{opc:'detvta',selsln:selsln,fdesde:fdesde,fhasta:fhasta},
        success:function(res){
          var dt=JSON.parse(res);
          var tb='';
          var i=0;
          for (i in dt){
           tb+='<tr><td>'+dt[i].ndocu+'<a class="detfact btn btn-info btn-xs pull-right" data-nfact="'+dt[i].ndocu+'"><i class="fa fa-search"></i></a></td><td>'+dt[i].nombre+'</td><td class="text-right">$ '+dt[i].serv+'</td><td class="text-right">$ '+dt[i].prod+'</td><td class="text-right">$ '+dt[i].dct+'</td><td class="text-center">'+dt[i].medpag+'</td><td class="text-right"><b>$ '+dt[i].total+'</b></td></tr>';
          }
          $(".tbdetvta tbody").html(tb);
          $(".loadmsj2").addClass('hidden');
          var tableCont = document.querySelector('#detalles');
          tableCont.addEventListener('scroll',scrollHandle);
          $("#detalles").removeClass('hidden');
          loaddetcol();
        }
      })*/
      /*$('#tbdetvta').DataTable({
             "bProcessing": true,
             "serverSide": true,
             "ajax":{
              url :'estadistica/process.php',
              type: "POST", 
              data:{opc:'detvta',selsln:selsln,fdesde:fdesde,fhasta:fhasta},
              error: function(){
                $(".tbdetvta_processing").css("display","none");
              }
          }
      });*/
      loaddetcol();   
    });

    $(document).on('click' , '.detfact', function(e){
      $(".resdetfact").addClass('hidden');
      $(".loadingdetfact").removeClass('hidden');
      $("#modal-detfact").modal('show');
      var nfact=$(this).data('nfact');
      $(".dfnum").html(nfact);
      $.ajax({
        url:'estadistica/process.php',
        type:'POST',
        data:{opc:'detfact',nfact,nfact},
        success:function(res){
          var dt=JSON.parse(res);
          var tb='';
          var i=0;
          for(i in dt.detfact){
            tb+='<tr><td>'+dt.detfact[i].nomser+'</td><td>'+dt.detfact[i].nomesti+'</td><td class="text-right">$ '+dt.detfact[i].valor+'</td><td class="text-right">$ '+dt.detfact[i].tdct+'</td></tr>';
          }
          $(".dfcli").html(dt.infofact.cliente);
          $(".tfact").html('<b>$ '+dt.infofact.total+'</b>');
          $(".dfdate").html(dt.infofact.fecha+' | '+dt.infofact.hora);
          $(".tefe").html('$ '+dt.infofact.efectivo);
          $(".ttrj").html('$ '+dt.infofact.valortare);
          if(parseInt(dt.infofact.valortare)>0){
            $(".dettrjt").html(' ['+dt.infofact.tarjeta+']');
          }else{
            $(".dettrjt").empty();
          }
          $(".tbdetfact tbody").html(tb);
          $(".loadingdetfact").addClass('hidden');
          $(".resdetfact").removeClass('hidden');
        }
      })
    });
  
    var  loaddetcol  = function() { 
      var selsln = $("#selsln").val();
      var fdesde = $("#fdesde").val();
      var fhasta = $("#fhasta").val();
      if(selsln!=null){
        for(var i = 0, len = selsln.length; i < len; i++) {
            selsln[i] = selsln[i].replace(/^t-/, '');
            selsln[i] = selsln[i].replace(/^s-/, '');
        }
      }
      $("#tbdetcol").removeClass('hidden');
      var listado = $('#tbdetcol').DataTable({
        "ajax": {
        "method": "POST",
        "url": "estadistica/process.php",
        "data":{opc:'detcol',selsln:selsln,fdesde:fdesde,fhasta:fhasta},
        },
        dom: 'Bfrtip',
          buttons: [ 
              {
                extend:    'excel',
                text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
                titleAttr: 'Exportar a Excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                },
                title:'BeautySoft - Liquidación de Colaboradores del '+fdesde+' al '+fhasta,
              }
          ],
        "columns":[
          {"data": "nomesti"},
          {"data": "crgnombre"},
          {"data": "serv", render: $.fn.dataTable.render.number('.', ',', 0, '$')},
          {"data": "prod", render: $.fn.dataTable.render.number('.', ',', 0, '$')},
          {"data": "qcos", render: $.fn.dataTable.render.number('.', ',', 0, '$')},
          {"data": "tqt",  render: $.fn.dataTable.render.number('.', ',', 0, '$')},
          {"data": "ins",  render: $.fn.dataTable.render.number('.', ',', 0, '$')},
          {"data": "dct",  render: $.fn.dataTable.render.number('.', ',', 0, '$')},
          {"data": "bliq", render: $.fn.dataTable.render.number('.', ',', 0, '$')},  
          {"render": function (data, type, JsonResultRow, meta) { 
                return '<button class="liqcol btn btn-default btn-xs text-info" data-idcol="'+JsonResultRow.estilista+'" title="Ver mas datos"><i class="fa fa-eye"></i></button>'; 
               } 
          },  
        ],
        "language":{
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "info": "Página _PAGE_ de _PAGES_",
            "infoEmpty": "",
            "infoFiltered": "(filtrada de _MAX_ registros)",
            "loadingRecords": "<h4><i class='fa fa-spin fa-spinner'></i> Cargando, por favor espere.\n Esta operación puede tardar varios minutos, sea paciente...</h4>",
            "processing":     "Procesando...",
            "search": "_INPUT_",
            "searchPlaceholder":"Buscar...",
            "zeroRecords":    "No se encontraron registros coincidentes",
            "paginate": {
              "next":       "Siguiente",
              "previous":   "Anterior"
            } 
          },  
          "columnDefs":[
            {className:"text-right","targets":[2]},
            {className:"text-right","targets":[3]},
            {className:"text-right","targets":[4]},
            {className:"text-right","targets":[5]},
            {className:"text-right","targets":[6]},
            {className:"text-right","targets":[7]},
            {className:"text-right","targets":[8]},
            {className:"text-center","targets":[9]},
          ],  
          "order": [[0, "asc"]],
          "bDestroy": true,
          "pageLength":10,
      });
    }

    $(document).on('click' , '.liqcol', function(e){
      var selsln = $("#selsln").val();
      var fdesde = $("#fdesde").val();
      var fhasta = $("#fhasta").val();
      var idcol=$(this).data('idcol');
      var nomcol=$(this).closest('tr').find('td:eq(0)').html();
      var cargo=$(this).closest('tr').find('td:eq(1)').html();
      var rfch=$("#fdesde").val()+' a '+$("#fhasta").val();
      $(".nomcol").html(nomcol);
      $(".crgcol").html(cargo);
      $(".fchcol").html(rfch);
      if(selsln!=null){
        for(var i = 0, len = selsln.length; i < len; i++) {
            selsln[i] = selsln[i].replace(/^t-/, '');
            selsln[i] = selsln[i].replace(/^s-/, '');
        }
      }
      var liqcol = $('#tbliqcol').DataTable({
        "ajax": {
        "method": "POST",
        "url": "estadistica/process.php",
        "data":{opc:'liqcol',selsln:selsln,fdesde:fdesde,fhasta:fhasta,idcol:idcol},
        },
        dom: 'Bfrtip',
          buttons: [ 
              {
                extend:    'excel',
                text:      '<i class="fa fa-file-excel-o" style="color:green;"></i>',
                titleAttr: 'Exportar a Excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                },
                title:'BeautySoft - Detalle facturación '+nomcol+' ['+cargo+'] del '+fdesde+' al '+fhasta,
              }
          ],
        "columns":[
          {"data": "fecha"},
          /*{"data": "ndocu"},*/
          {"render": function (data, type, JsonResultRow, meta) { 
                return '<button class="detfact btn btn-default btn-xs text-info" data-nfact="'+JsonResultRow.ndocu+'" title="Ver detalle de factura">'+JsonResultRow.ndocu+'</button>'; 
               } 
          }, 
          {"data": "serv", render: $.fn.dataTable.render.number('.', ',', 0, '$')},
          {"data": "prod", render: $.fn.dataTable.render.number('.', ',', 0, '$')},
          {"data": "qcos", render: $.fn.dataTable.render.number('.', ',', 0, '$')},
          {"data": "tqt",  render: $.fn.dataTable.render.number('.', ',', 0, '$')},
          {"data": "ins",  render: $.fn.dataTable.render.number('.', ',', 0, '$')},
          {"data": "dct",  render: $.fn.dataTable.render.number('.', ',', 0, '$')},
          {"data": "bliq", render: $.fn.dataTable.render.number('.', ',', 0, '$')},  
        ],
        "language":{
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "info": "Página _PAGE_ de _PAGES_",
            "infoEmpty": "",
            "infoFiltered": "(filtrada de _MAX_ registros)",
            "loadingRecords": "<h4><i class='fa fa-spin fa-spinner'></i> Cargando... por favor espere.<br> Esta operación puede tardar varios minutos, sea paciente.</h4>",
            "processing":     "Procesando...",
            "search": "_INPUT_",
            "searchPlaceholder":"Buscar...",
            "zeroRecords":    "No se encontraron registros coincidentes",
            "paginate": {
              "next":       "Siguiente",
              "previous":   "Anterior"
            } 
          },  
          "columnDefs":[
            {className:"text-center","targets":[0]},
            {className:"text-center","targets":[1]},
            {className:"text-right","targets":[2]},
            {className:"text-right","targets":[3]},
            {className:"text-right","targets":[4]},
            {className:"text-right","targets":[5]},
            {className:"text-right","targets":[6]},
            {className:"text-right","targets":[7]},
            {className:"text-right","targets":[8]},
          ],  
          "order": [[0, "asc"]],
          "bDestroy": true,
          "pageLength":10,
      });
      $("#modal-liqcol").modal('show');
    });
    ///////////////////////////////////////////////////////////
    $(".filter").change(function(e){
      $("#tbst1").addClass('hidden');
      //$(".loadmsj").removeClass('hidden');
      $("#tabdetalle").addClass('hidden');
      //$(".loadmsj3").removeClass('hidden');
      $("#tbdetcol").addClass('hidden');
    });
    ///////////////////////////////////////////////////////////
    $(document).on('show.bs.modal', '.modal', function () {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });
    $(document).on('hidden.bs.modal', '.modal', function () {
        $('.modal:visible').length && $(document.body).addClass('modal-open');
    });
  </script>
<!-- SCRIPTS DE COMPARACION -->
  <script type="text/javascript">
    $("#additem").click(function(e){
      var sln=$("#selsln2").val();
      var fdesde=$("#fdesde2").val();
      var fhasta=$("#fhasta2").val();
      if(sln!=null){
        if((fdesde!='') & (fhasta!='')){
          if($("#tbcompa thead").hasClass('hidden')){
            $('#tbcompa thead').append('<tr><th>Salones / Periodo</th>');
            if($('#cserv').prop('checked')){
              $('#tbcompa thead tr').append('<th class="text-center">T. Servicios</th>');
            }
            if($('#cvta').prop('checked')){
              $('#tbcompa thead tr').append('<th class="text-center">T. Ventas</th>');
            }
            $('#tbcompa thead tr').append('<th class="text-center">Opciones</th></tr>')
            $('#tbcompa thead').removeClass('hidden');
          }
          var arrsln=[];
          var sln=$("#selsln2").val();
          for(var i = 0, len = sln.length; i < len; i++) {
            sln[i] = sln[i].replace(/^t-/, '');
            sln[i] = sln[i].replace(/^s-/, '');
          }
          var selsln=$("#selsln2").select2('data');
          for(i in selsln){
            arrsln.push(selsln[i].text);
          }
          var row='<tr>';
          row+='<td>'+arrsln.toString()+' / De: '+fdesde+' a '+fhasta+'</td>';
          if($('#cserv').prop('checked')){
              row+='<td class="rserv text-center">Esperando procesamiento</td>';
          }
          if($('#cvta').prop('checked')){
            row+='<td class="rvta text-right">Esperando procesamiento</td>';
          }
          row+='<td class="datarow text-center" data-sln="'+sln+'" data-fdesde="'+fdesde+'" data-fhasta="'+fhasta+'"><a class="btn btn-default delrow"><i class="fa fa-times text-danger"></i></a></td>';
          row+='</tr>';
          $('#tbcompa tbody').append(row);
          $('#tbcompa tbody').removeClass('hidden');
          $('.btnproc').removeClass('hidden');
          $(".inpfecha").val('');
          $(".selsln").select2("val", "");
        }else{
          swal('Elija Rango de fechas','','warning');
        }
      }else{
        swal('Elija Salon(es)','','warning');
      }
    })
    $(document).on('click','.delrow',function(){
      $(this).closest('tr').remove();
    });
  </script>
  <script type="text/javascript">
    $(".goco").click(function(e){
      $(".datarow").each(function(){
        var cell=$(this);
        var desde=$(this).data('fdesde');
        var hasta=$(this).data('fhasta');
        var sln=$(this).data('sln');
        var ts=0;
        var tv=0;
        if($('#cserv').prop('checked')){
          ts=1;
        }
        if($('#cvta').prop('checked')){
          tv=1;
        }
        $.ajax({
          url:'estadistica/process.php',
          type:'POST',
          data:{opc:'comp',desde:desde,hasta:hasta,sln:sln,ts:ts,tv:tv},
          success:function(res){
            var dt=JSON.parse(res);
            if(ts==1){
              cell.closest('tr').find('.rserv').html(dt.tsvc);
            }
            if(tv==1){
              cell.closest('tr').find('.rvta').html('$'+dt.tvta);
            }
            $(".optcls").removeClass('hidden');
          }
        })
      });
    });
    $(".reset").click(function(e){
      $('#tbcompa tbody').html('').addClass('hidden');
      $('#tbcompa thead').html('').addClass('hidden');
      $(".btnproc").addClass('hidden');
    })
  </script>
<!-- SCRIPTS DE REPORTES -->
  <script type="text/javascript">
    //BOTONES DE NAVEGACION Y OPCIONES
      $(".btntrp").click(function(){
        $btn=$(this);
        $btn.attr('disabled', 'disabled').removeClass('btn-lg').addClass('btn-sm');
        $(".divbtn").addClass('hidden');
        $btn.parent().removeClass('hidden');
        $(".divcancel").removeClass('hidden');
        $(".divdate").removeClass('hidden');
        var opc=$btn.attr('id');
        switch(opc){
          case 'btnxsln':
            $(".divselsln").removeClass('hidden');
            $("#genopt").val('xsln');
          break;
          case 'btnxcol':
            $(".divselcol").removeClass('hidden');
            $("#genopt").val('xcol');
          break;
          case 'btnxser':
            $(".divselsrv").removeClass('hidden');
            $("#genopt").val('xsrv');
          break;
          case 'btnxpro':
            $(".divselsln").removeClass('hidden');
            $(".divselpro").removeClass('hidden');
            $("#genopt").val('xpro');
          break;
        }
      });
      $("#btncancel").click(function(){
        btncancelar();
      });
      function btncancelar(){
        $('.divcancel').addClass('hidden');
        $('.divdate').addClass('hidden');
        $('.divsel').addClass('hidden');
        $(".btntrp").removeAttr('disabled').removeClass('btn-sm').addClass('btn-lg');
        $(".divbtn").removeClass('hidden');
        $(".rptctrl").val('');
        $("#genopt").val('');
        $(".selitem").select2("val", "");
        $("#tbloading").addClass('hidden');
        $("#divtbres").addClass('hidden');
        $("#tbres thead tr").empty();
        $("#tbres tbody").empty();
      }
    //generacion de reporte
      function lastday(mes, año) {
        return new Date(año, mes, 0).getDate();
      }
      $("#btngen").click(function(){
        $("#divtbres").addClass('hidden');
        var fh=$("#rpfhasta").val();
        var fd=$("#rpfdesde").val();
        var tipo=$("#genopt").val();
        var sw1=false;
        var sw2=false;
        var contb='';
        var ts='';
        switch(tipo){
          case 'xsln':
            var selitem=$("#rpselsln").val();
            for(var i = 0, len = selitem.length; i < len; i++) {
              selitem[i] = selitem[i].replace(/^t-/, '');
              selitem[i] = selitem[i].replace(/^s-/, '');
            }
            ts=$("#rpselsln").find(':selected').data('sw');
            sw1=true;
            $("#tbrestitle").html('Reporte general por salón del: '+fd+' al '+fh);
            $("#tbres thead tr").empty().html('<th>SALON</th><th>Servicios</th><th>Efectivo</th><th>Tarjeta</th><th>Otros p.</th><th>Total Facturado</th>');
          break;
          case 'xcol':
            var selitem=$("#rpselcol").val();
            sw1=selitem!=null?true:false;
            $("#tbrestitle").html('Reporte general por colaborador del: '+fd+' al '+fh);
            $("#tbres thead tr").empty().html('<th>Colaborador</th><th>Servicios</th><th>Total Facturado</th>');
          break;
          case 'xsrv':
            var selitem=$("#rpselser").val();
            sw1=true;
          break;
        }
        if((fd!='') && (fh!='') && (fh>=fd)){
          $(".btnprocess").attr('disabled','disabled');
          var fdesde=fd+'-01';
          var fhasta=fh+'-'+lastday(fh.split('-')[1],fh.split('-')[0]);
          if(sw1){
            $("#tbloading").removeClass('hidden');
            $.ajax({
              url:'estadistica/process.php',
              type:'POST',
              data:{opc:'rpgen',tipo:tipo,selitem:selitem,fdesde:fdesde,fhasta:fhasta,ts:ts},
              success:function(res){
                var ans=JSON.parse(res);
                if(ans[0].info==1){
                  for(var i=0 in ans){
                    switch(tipo){
                      case 'xsln':
                        contb+='<tr><td>'+ans[i].sln+'</td><td>'+ans[i].tsrv+'</td><td>$'+ans[i].tefc+'</td><td>$'+ans[i].ttrj+'</td><td>$'+ans[i].totr+'</td><td>$'+ans[i].tvta+'</td></tr>';
                      break;
                      case 'xcol':
                        contb+='<tr><td>'+ans[i].col+'</td><td>'+ans[i].tsrv+'</td><td>$ '+ans[i].tfact+'</td></tr>';
                      break;
                      case 'xsrv':
                        
                      break;
                    }
                  }
                  $("#tbres tbody").empty().html(contb);
                  $("#divtbres").removeClass('hidden');
                  $("#tbloading").addClass('hidden');
                  $(".btnprocess").removeAttr('disabled');
                }else{
                  swal('Sin resultados!','No hay datos para mostrar','warning');
                  $("#tbloading").addClass('hidden');
                  $(".btnprocess").removeAttr('disabled');
                }
              }
            })
          }else{
            swal('Faltan Datos!','Verifique que todos los campos cumplan las condiciones necesarias para generar el reporte.','error');
          }
        }else{
          swal('Fechas Erradas!','','error');
        }
      });

  </script>
