<?php 
include '../head.php';
 VerificarPrivilegio("COSTEO", $_SESSION['tipo_u'], $conn);
include '../librerias_js.php';
?>
<style type="text/css" media="screen">
	.fecha[readonly]{
		cursor:pointer;
		background-color: white;
	}
</style>
<div class="content">
  <div class="row"><h3 class="text-center">COSTEO DE COLABORADORES</h3></div>
	<div class="row">
		<div class="col-md-4">
			<select id="selcol" class="form-control"></select>
		</div>
		<div class="col-md-2">
			<input class="fecha form-control text-center fdesde frmctrl" placeholder="Desde" readonly>
		</div>
		<div class="col-md-2">
			<input class="fecha form-control text-center fhasta frmctrl" placeholder="Hasta" readonly>
		</div>
		<div class="col-md-2">
			<input class="money form-control text-right frmctrl" data-type="currency" placeholder="$. Costo a Prorratear">
		</div>
		<div class="col-md-2">
			<button id="btnproc" class="btn btn-info"><i class="fa fa-gear"></i> Generar</button>
		</div>
	</div>
  <div class="diverror hidden">
    <h4><i class="fa fa-times"></i> Oops! ha ocurrido un error, comuníquese al dpto de sistemas...</h4>
  </div>
	<div class="loading hidden">
		<h4><i class="fa fa-spin fa-spinner"></i> Calculando, por favor espere...</h4>
	</div><br>
	<div class="divres table-responsive hidden col-md-7 col-md-push-2">
    <button id="expexcel" class="btn btn-default"><i class="fa fa-file-excel-o" style="color:green;"></i> Exportar a Excel</button>
    <!-- <button id="reset" class="btn btn-default pull-right"><i class="fa fa-reload" style="color:blue;"></i> Recargar</button> -->
		<table id="tbres" class="tbres table table-hover">
			<thead>
        <tr><th>Colaborador:</th><td id="thcol" class="text-right" colspan="3"></td></tr>
        <tr><th>Periodo:</th><td id="thdate" class="text-right" colspan="3"></td></tr>
        <tr><th  colspan="2">Costo prorrateado:</th><td id="thmoney" class="text-right" colspan="2"></td></tr>
				<tr>
					<th>Salón</th>
					<th class="text-center">Dias programados</th>
          <th class="text-center">Ausencias</th>
					<th class="text-center">Valor</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#selcol').selectpicker({
		    liveSearch: true,
		    title:'Buscar y seleccionar colaborador...'
		});
		$(".fecha").datepicker({
			format:'yyyy-mm-dd',
        	autoclose: true,
          startView: 1,
		});
	});
	$('#selcol').on('show.bs.select', function (e) {
        $('.bs-searchbox').addClass('algo');
        $('.algo .form-control').attr('id', 'fucker');
  });
  $(document).on('keyup', '#fucker', function(event) {
    var seek = $(this).val();
    $.ajax({
        url: 'costeo/process.php',
        type: 'POST',
        data:'opc=loadcol&txt='+seek,
        success: function(data){
        	if(data){
              var json = JSON.parse(data);
              var opcs = "";
              for(var i in json){
                  opcs += "<option value='"+json[i].cod+"'>"+json[i].nom+"</option>";
              }
              $("#selcol").html(opcs).selectpicker('refresh');
        	}
        }
    }); 
  });
  $("#btnproc").click(function(e){
    $(".divres").addClass('hidden');
  	var clb=$("#selcol").val();
  	var fd=$(".fdesde").val();
  	var fh=$(".fhasta").val();
  	var predif=new Date(fh)-new Date(fd);
  	var dias=predif/(1000*60*60*24)+1;
  	var money=parseInt($(".money").val().replace(/\./g,''));
    if(clb!=''){
      if(fd<fh){
        if((money!='') && (money>0)){
        	$(".loading").removeClass('hidden');
          var valdia=(money/dias).toFixed();
          $("#thcol").html($( "#selcol option:selected" ).text().toUpperCase());
          $("#thdate").html(fd+' a '+fh);
          $("#thmoney").html('$'+$(".money").val());
          $("#expexcel").attr('data-clb',clb);
          $("#expexcel").attr('data-fd',fd);
          $("#expexcel").attr('data-fh',fh);
          $("#expexcel").attr('data-money',money);
          $("#expexcel").attr('data-valdia',valdia);
          $.ajax({
            url:'costeo/process.php',
            type:'POST',
            data:{opc:'calcular',clb:clb,fd:fd,fh:fh},
            success:function(res){
              var dt=JSON.parse(res);
              var i=0;
              var tb='';
              for(i in dt){
                tb+='<tr><td>'+dt[i].sln+'</td><td class="text-center">'+dt[i].cd+'</td><td class="text-center">'+dt[i].au+'</td><td class="text-right">$'+formatNumber(((dt[i].cd-dt[i].au)*valdia).toString())+'</td></tr>';
              }
              $(".tbres tbody").html(tb);
            },
            error:function(){
              $(".diverror").removeClass('hidden');
            }
          });
          $(".frmctrl").val('');
          $("#selcol").val('default').selectpicker("refresh");
          $(".loading").addClass('hidden');
          $(".divres").removeClass('hidden');
        }else{
          swal('Debe digitar el valor a prorratear','','warning');
        }
      }else{
        swal('Rango de fechas No Válido','','warning');
      }
    }else{
      swal('Seleccione un colaborador','','warning');
    }
  })
</script>
<script type="text/javascript">
  $("input[data-type='currency']").on({
      keyup: function() {
        formatCurrency($(this));
      },
      blur: function() { 
        formatCurrency($(this), "blur");
      }
  });


  function formatNumber(n) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
  }


  function formatCurrency(input, blur) {
    var input_val = input.val();
    if (input_val === "") { return; }
    var original_len = input_val.length;
    var caret_pos = input.prop("selectionStart");
    if (input_val.indexOf(",") >= 0) {
      var decimal_pos = input_val.indexOf(",");
      var left_side = input_val.substring(0, decimal_pos);
      var right_side = input_val.substring(decimal_pos);
      left_side = formatNumber(left_side);
      right_side = formatNumber(right_side);
      if (blur === "blur") {
        right_side += "00";
      }
      right_side = right_side.substring(0, 2);
      input_val =  left_side + "," + right_side;

    } else {
      input_val = formatNumber(input_val);
      input_val = input_val;
      if (blur === "blur") {
        input_val;
      }
    }
    input.val(input_val);
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
  }
</script>

<script type="text/javascript">
 // $("#expexcel").click(function () {
  $(document).on('click','#expexcel',function(){
    var clb=$(this).attr('data-clb');
    var fd=$(this).attr('data-fd');
    var fh=$(this).attr('data-fh');
    var money=$(this).attr('data-money');
    var valdia=$(this).attr('data-valdia');
    window.open('costeo/export.php?clb='+clb+'&fd='+fd+'&fh='+fh+'&money='+money+'&valdia='+valdia);
  });
</script>


