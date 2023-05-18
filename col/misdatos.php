<?php 
	include("head.php");
	include("librerias_js.php");
?>
<style>
	textarea{
		resize: none;
	}
</style>
<div class="container-fluid">
	<legend><b>Formato de actualización de datos</b></legend>
	<h5>Presione sobre la categoría que desea actualizar</h5><br>
	<!-- Formulario Acordeón -->
	<div class="panel-group" id="profile-accordion" role="tablist" aria-multiselectable="true">
	    <div class="panel panel-default">
	        <div class="panel-heading" role="tab" id="infogen" data-toggle="collapse" data-parent="#profile-accordion" href="#infogen-son">
	            <h4 class="panel-title">
	                <span class=""><i class="dir fa fa-angle-double-right"></i> Información General </span><br><br><small class="infogen_alt pull-right"></small>
	            </h4>
	        </div>
	        <input type="hidden" id="sw1" value="0">
	        <div id="infogen-son" class="panel-collapse collapse " role="tabpanel">
		        <div class="panel-body">
			        <div class="load1">
			        	<h6><i class="fa fa-spin fa-spinner"></i> Cargando...</h6>
			        </div>
		        	<form id="formcdp" class="hidden" autocomplete="off">
		            		<div class="form-group">
		            			<div class="input-group">
				            		<span class="input-group-addon">Dirección</span>
				            		<input maxlength="50" name="address" id="address" class="form-control" placeholder="Calle / Kra xx # xx-xx" minlength=5 required oninvalid="this.setCustomValidity('Debe suministrar una dirección válida!')" oninput="this.setCustomValidity('')">
		            			</div>
			            	</div>
			            	<div class="form-group">
			            		<div class="input-group">
			            			<span class="input-group-addon">Barrio</span>
			            			<select id="barrio" name="barrio" class="barrio form-control"></select>
			            		</div>
			            	</div>
			            	<div class="form-group">
			            		<div class="input-group">
			            			<span class="input-group-addon">Celular</span>
			            			<input oninput="numberOnly(this.id);" id="phone" name="phone" type="text" placeholder="10 digitos..." class="form-control">
			            		</div>
			            	</div>
			            	<div class="form-group">
			            		<div class="input-group">
				            		<span class="input-group-addon">E-mail</span>
				            		<input maxlength="50" id="mail" type="email" name="mail" class="form-control" placeholder="Escriba su correo..." required>
			            		</div>
			            	</div>
					        <div class="form-group">
					        	<button type="submit" class="sbmt1 btn btn-info pull-right">Guardar</button>
					        </div>
					        <small>Guarde los cambios antes de continuar</small>
		        	</form>
			        <div class="infpdte1 hidden">
			        	<h5><i class="fa fa-warning text-warning"></i> Ud tiene una revisión de datos pendiente.</h5>
			        	<small>Tan pronto Gestión Humana apruebe o rechaze la revisión podrá actualizar sus datos nuevamente</small>
			        </div>
		        </div>
	        </div>
	    </div>
	    <!-- <div class="panel panel-default">
	        <div class="panel-heading collapsed" role="tab" id="saludbi" data-toggle="collapse" data-parent="#profile-accordion" href="#saludbi-son">
	            <h4 class="panel-title">
	                <span ><i class="dir fa fa-angle-double-right"></i> Salud y Bienestar </span><br><br><small class="saludbi_alt pull-right"></small>
	            </h4>
	        </div>
	        <input type="hidden" id="sw2" value="0">
	        <div id="saludbi-son" class="panel-collapse collapse" role="tabpanel">
	    			    <div class="panel-body">
	    					<div class="load2">
	    			        	<h6><i class="fa fa-spin fa-spinner"></i> Cargando...</h6>
	    			        </div>
	    		        	<form id="formsb" class="hidden" autocomplete="off">
	    			            	<div class="form-group">
	    			            		<div class="input-group">
	    				            		<span class="input-group-addon">EPS</span>
	    				            		<select id="eps" name="eps" class="form-control" required></select>
	    			            		</div>
	    			            	</div> 
	    			            	<div class="form-group">
	    			            		<div class="input-group">
	    				            		<span class="input-group-addon">F. de pensión</span>
	    				            		<select id="afp" name="afp" class="form-control" required></select>
	    			            		</div>
	    			            	</div>  
	    			            	<div class="form-group">
	    			            		<div class="input-group">
	    				            		<label>Como considera su estado de salud a la fecha?</label>
	    				            		<select id="estsalud" name="estsalud" class="form-control" required>
	    				            			<option value="" selected disabled>Elija una opción</option>
	    				            			<option value="1">Excelente</option>
	    				            			<option value="2">Bueno</option>
	    				            			<option value="3">Regular</option>
	    				            			<option value="4">Malo</option>
	    				            		</select>
	    			            		</div>
	    			            	</div>   
	    			            	<div class="form-group">
	    			            		<div class="input-group">
	    				            		<label for="enfermedad">Sufre de alguna enfermedad?</label>
	    				            		<select id="enfermedad" name="enfermedad" class="form-control" required>
	    				            			<option value="" selected disabled>Elija una opción</option>
	    				            			<option value="1">SI</option>
	    				            			<option value="0">NO</option>
	    				            		</select>
	    			            		</div>
	    			            	</div>   
	    			            	<div class="form-group detenf hidden">
	    			            		<label for="detenf">Cual?</label>
	    			            		<textarea id="detenf" name="detenf" class="form-control"></textarea>
	    			            	</div> 
	    			            	<div class="form-group">
	    			            		<div class="input-group">
	    				            		<label for="restriccion">Tiene alguna restricción médica?</label>
	    				            		<select id="restriccion" name="restriccion" class="form-control" required>
	    				            			<option value="" selected disabled>Elija una opción</option>
	    				            			<option value="1">SI</option>
	    				            			<option value="0">NO</option>
	    				            		</select>
	    			            		</div>
	    			            	</div>   
	    			            	<div class="form-group detrest hidden">
	    			            		<label for="detrest">Cual?</label>
	    			            		<textarea id="detrest" name="detrest" class="form-control"></textarea>
	    			            	</div> 
	    			            	<div class="form-group">
	    			            		<div class="input-group">
	    				            		<label for="cirugia">Ha sido intervenido quirurgicamente en los últimos 6 meses?</label>
	    				            		<select id="cirugia" name="cirugia" class="form-control" required>
	    				            			<option value="" selected disabled>Elija una opción</option>
	    				            			<option value="1">SI</option>
	    				            			<option value="0">NO</option>
	    				            		</select>
	    			            		</div>
	    			            	</div>   
	    			            	<div class="form-group detcirugia hidden">
	    			            		<label for="detcirugia">Motivo?</label>
	    			            		<textarea id="detcirugia" name="detcirugia" class="form-control"></textarea>
	    			            	</div>
	    			            	<div class="form-group">
	    			            		<div class="input-group">
	    				            		<label for="hospital">Ha sido hospitalizado en los últimos 2 años?</label>
	    				            		<select id="hospital" name="hospital" class="form-control" required>
	    				            			<option value="" selected disabled>Elija una opción</option>
	    				            			<option value="1">SI</option>
	    				            			<option value="0">NO</option>
	    				            		</select>
	    			            		</div>
	    			            	</div>   
	    			            	<div class="form-group dethosp hidden">
	    			            		<label for="dethosp">Motivo?</label>
	    			            		<textarea id="dethosp" name="dethosp" class="form-control"></textarea>
	    			            	</div> 
	    			            	<div class="form-group">
	    			            		<div class="input-group">
	    				            		<label for="tratamto">Actualmente se encuentra en algún tratamiento?</label>
	    				            		<select id="tratamto" name="tratamto" class="form-control" required>
	    				            			<option value="" selected disabled>Elija una opción</option>
	    				            			<option value="1">SI</option>
	    				            			<option value="0">NO</option>
	    				            		</select>
	    			            		</div>
	    			            	</div>   
	    			            	<div class="form-group dettrata hidden">
	    			            		<label for="dettrata">Descríbalo</label>
	    			            		<textarea id="dettrata" name="dettrata" class="form-control"></textarea>
	    			            	</div> 
	    			            	<legend></legend>
	    			            	<h4 class="text-center">Contacto en caso de emergencia</h4>
	    			            	<h6>Esta información reemplazará cualquier dato anterior de contacto</h6>
	    			            	<div class="form-group">
	    			            		<div class="input-group">
	    				            		<span class="input-group-addon">Nombre</span>
	    				            		<input id="nomem" name="nomem" class="form-control" required>
	    			            		</div>
	    			            	</div>
	    			            	<div class="form-group">
	    			            		<div class="input-group">
	    				            		<span class="input-group-addon">Parentesco</span>
	    				            		<input id="parem" name="parem" class="form-control" required>
	    			            		</div>
	    			            	</div> 
	    			            	<div class="form-group">
	    			            		<div class="input-group">
	    				            		<span class="input-group-addon">Dirección</span>
	    				            		<input id="direm" name="direm" class="form-control" required>
	    			            		</div>
	    			            	</div>
	    			            	<div class="form-group">
	    			            		<div class="input-group">
	    				            		<span class="input-group-addon">Celular</span>
	    				            		<input id="celem" name="celem" oninput="numberOnly(this.id);" class="form-control" required>
	    			            		</div>
	    			            	</div>   
	    			            	<legend></legend>
	    			            	<h4 class="text-center">Dotación</h4>
	    			            	<div class="form-group">
	    			            		<div class="input-group">
	    				            		<span class="input-group-addon">Talla de Camisa/Blusa</span>
	    				            		<select id="tallacam" name="tallacam" class="form-control" required>
	    				            			<option value="" selected disabled>Elija talla</option>
	    				            			<option value="XS">XS</option>
	    				            			<option value="S">S</option>
	    				            			<option value="M">M</option>
	    				            			<option value="L">L</option>
	    				            			<option value="XL">XL</option>
	    				            			<option value="XXL">XXL</option>
	    				            			<option value="Otra">Otra</option>
	    				            		</select>
	    			            		</div>
	    			            	</div> 
	    			            	<div class="form-group">
	    			            		<div class="input-group">
	    				            		<span class="input-group-addon">Talla de Pantalón</span>
	    				            		<select id="tallapan" name="tallapan" class="form-control" required>
	    				            			<option value="" selected disabled>Elija talla</option>
	    				            			<optgroup label="Tallas femeninas">
	    					            			<option value="4">4</option>
	    					            			<option value="6">6</option>
	    					            			<option value="8">8</option>
	    					            			<option value="10">10</option>
	    					            			<option value="12">12</option>
	    					            			<option value="14">14</option>
	    					            			<option value="16">16</option>
	    					            			<option value="O">Otra</option>
	    				            			</optgroup>
	    				            			<optgroup label="Tallas Masculinas">
	    					            			<option value="28">28</option>
	    					            			<option value="30">30</option>
	    					            			<option value="32">32</option>
	    					            			<option value="34">34</option>
	    					            			<option value="36">36</option>
	    					            			<option value="38">38</option>
	    					            			<option value="40">40</option>
	    				            				<option value="O">Otra</option>
	    				            			</optgroup>
	    				            		</select>
	    			            		</div>
	    			            	</div>
	    			            	<div class="form-group">
	    			            		<div class="input-group">
	    				            		<span class="input-group-addon">Talla de Guantes</span>
	    				            		<select id="tallagua" name="tallagua" class="form-control" required>
	    				            			<option value="" selected disabled>Elija talla</option>
	    				            			<option value="XS">XS</option>
	    				            			<option value="S">S</option>
	    				            			<option value="M">M</option>
	    				            			<option value="L">L</option>
	    				            			<option value="XL">XL</option>
	    				            			<option value="XXL">XXL</option>
	    				            		</select>
	    			            		</div>
	    			            	</div>
	    			            	<legend></legend>
	    			            	<h4 class="text-center">Información Judicial</h4>
	    			            	<div class="form-group">
	    			            		<label for="judicial">Ha tenido usted problemas Judiciales?</label>
	    			            		<select id="judicial" name="judicial" class="form-control" required>
	    			            			<option value="" selected disabled>Elija una opción</option>
	    			            			<option value="1">SI</option>
	    			            			<option value="0">NO</option>
	    			            		</select>
	    			            	</div>  
	    			            	<div class="form-group detjud hidden">
	    			            		<label for="detjud">Motivo?</label>
	    			            		<textarea id="detjud" name="detjud" class="form-control" placeholder="Describa lugar, momento (fecha) y motivo del suceso" rows="4"></textarea>
	    			            	</div> 
	    			            	<div class="form-group">
	    					        	<button class="sbmt2 btn btn-info pull-right">Guardar</button>
	    					        </div>
	    		        	</form>
	    					<div class="infpdte2 hidden">
	    			        	<h5><i class="fa fa-warning text-warning"></i> Ud tiene una revisión de datos pendiente.</h5>
	    			        	<small>Tan pronto Gestión Humana apruebe o rechaze la revisión podrá actualizar sus datos nuevamente</small>
	    			        </div>
	            </div>
	        </div>
	    </div> -->
	    <div class="panel panel-default">
	        <div class="panel-heading collapsed" role="tab" id="infofami" data-toggle="collapse" data-parent="#profile-accordion" href="#infofami-son">
	            <h4 class="panel-title">
	                <span><i class="dir fa fa-angle-double-right"></i> Información Familiar </span><br><br><small class="infofami_alt pull-right"></small>
	            </h4>
	        </div>
	        <input type="hidden" id="sw3" value="0">
	        <div id="infofami-son" class="panel-collapse collapse" role="tabpanel">
		        <div class="panel-body">
		        	<div class="load3">
			        	<h6><i class="fa fa-spin fa-spinner"></i> Cargando...</h6>
			        </div>
		        	<form id="formif" autocomplete="off">
			                <div class="form-group">
			                	<div class="input-group">
				            		<span class="input-group-addon">Estado Civil</span>
				            		<select id="civil" name="civil" class="form-control" required>
				            			<option value="" selected disabled>Elija una opción</option>
				            			<option value="0">Soltero</option>
				            			<option value="1">Casado</option>
				            			<option value="2">Unión Libre</option>
				            			<option value="3">Separado</option>
				            			<option value="4">Divorciado</option>
				            			<option value="5">Viudo(a)</option>
				            		</select>
			                	</div>
			            	</div>   
			            	<div class="form-group detcivil hidden">
			            		<label for="detcivil">Nombre conyuge o compañero(a)</label>
			            		<input id="detcivil" name="detcivil" class="form-control">
			            	</div> 
			            	<div class="form-group detcivil hidden">
			            		<label for="detcivil2">Ocupación del conyuge o compañero(a)</label>
			            		<input id="detcivil2" name="detcivil2" class="form-control">
			            	</div>
			            	<div class="form-group detcivil hidden">
			            		<label for="detcivil3">Teléfono del conyuge o compañero(a)</label>
			            		<input id="detcivil3" name="detcivil3" class="form-control" oninput="numberOnly(this.id);">
			            	</div> 
			            	<div class="form-group">
			            		<div class="input-group">
				            		<span class="input-group-addon">Hijos</span>
				            		<select id="hijos" name="hijos" class="form-control" required>
				            			<option value="" selected disabled>Elija una opción</option>
				            			<option value="1">SI</option>
				            			<option value="0">NO</option>
				            		</select>
			            		</div>
			            	</div>
			            	<section id="datahijo" class="hidden">
			            		<h5>Información de los hijos</h5>
				            	<div class="arrayhijos">
					            	<div class="form-group addedson">
					            		<input class="form-control nomhijo infson" name="nomhijo[]" placeholder="Nombre">
					            		<div class="input-group">
					            			<input class="form-control nachijo infson" name="nachijo[]" placeholder="Fecha de nacimiento*" readonly>
											<span class="input-group-addon delson"><i class="fa fa-times text-danger"></i> Eliminar</span>
					            		</div>
					            	</div>                     
				            	</div>
				            	<div class="form-group">
			            			<a class="addson btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Agregar otro hijo</a>
			            			<small>*Use las flechas << - >> para cambiar año o mes</small>
			            		</div>
			            	</section>
			            	<legend></legend>
			            	<h4 class="text-center">Núcleo Familiar</h4>
			            	<div class="form-group">
								<div class="input-group">
				            		<span class="input-group-addon">Nombre del Padre</span>
				            		<input id="nompadre" name="nompadre" class="form-control" required>
				            	</div>
				            	<div class="input-group">
				            		<span class="input-group-addon">Teléfono</span>
				            		<input id="telpadre" name="telpadre" class="form-control" oninput="numberOnly(this.id);">
				            	</div> 
			            	</div>
			            	<div class="form-group">
								<div class="input-group">
				            		<span class="input-group-addon">Nombre de la Madre</span>
				            		<input id="nommadre" name="nommadre" class="form-control" required>
				            	</div>
				            	<div class="input-group">
				            		<span class="input-group-addon">Teléfono</span>
				            		<input id="telmadre" name="telmadre" class="form-control" oninput="numberOnly(this.id);">
				            	</div> 
			            	</div>
			            	<div class="form-group">
			            		<div class="input-group">
				            		<span class="input-group-addon">Direccion Padres</span>
				            		<input id="dirpadres" name="dirpadres" class="form-control" required>
				            	</div>
				            	<div class="input-group">
				            		<span class="input-group-addon">Barrio</span>
				            		<select id="barrio2" name="barrio2" class="barrio form-control"></select>
				            	</div> 
			            	</div>
			            	<div class="form-group">
			            		<div class="input-group">
				            		<span class="input-group-addon">Hermanos</span>
				            		<select id="brother" name="brother" class="form-control" required>
				            			<option value="" selected disabled>Elija una opción</option>
				            			<option value="1">SI</option>
				            			<option value="0">NO</option>
				            		</select>
			            		</div>
			            	</div>
			            	<section id="databrother" class="hidden">
			            		<h5>Información de los hermanos</h5>
				            	<div class="arraybrother">
					            	<div class="form-group addedbro">
					            		<div class="input-group">
											<span class="input-group-addon">Nombre</span>
					            			<input class="form-control nombro infbro" name="nombro[]">
					            		</div>
					            		<div class="input-group">
											<span class="input-group-addon">Ocupación</span>
					            			<input class="form-control ocubro infbro" name="ocubro[]">
					            		</div>
					            		<div class="input-group">
											<span class="input-group-addon">Teléfono</span>
					            			<input class="form-control telbro infbro" name="telbro[]">
					            		</div>
					            		<div class="input-group">
											<span class="input-group-addon">Edad</span>
					            			<input class="form-control agebro infbro" type="number" name="agebro[]">
					            			<span class="input-group-addon delbro"><i class="fa fa-times text-danger"></i>Eliminar</span>
					            		</div>
					            	</div>                     
				            	</div>
				            	<div class="form-group">
			            			<a class="addbro btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> Agregar otro hermano</a>
			            		</div>
			            	</section>
			            	<legend></legend>
			            	<br>
			            	<div class="form-group">
			            		<div class="input-group">
			            			<span class="input-group-addon"><input type="checkbox" id="veraz" required oninvalid="this.setCustomValidity('Marque esta casilla si toda la información dada en este formulario es veraz')" oninput="this.setCustomValidity('')"></span>	
			            			<input class="form-control" value="Toda la info dada aquí es veraz" readonly>
			            		</div>
			            	</div>
			            	<div class="form-group">
			            		<small>Al dar click en 'Guardar' se reemplazará TODA la información que anteriormente había suministrado</small>
					        	<button class="sbmt3 btn btn-info pull-right">Guardar</button>
					        </div>
		        	</form>
		        	<div class="infpdte3 hidden">
			        	<h5><i class="fa fa-warning text-warning"></i> Ud tiene una revisión de datos pendiente.</h5>
			        	<small>Tan pronto Gestión Humana apruebe o rechaze la revisión podrá actualizar sus datos nuevamente</small>
			        </div>
		        </div>
	        </div>
	    </div>
	</div>

</div>
<?php include 'footer.php';?>
<script type="text/javascript">
	$(document).ready(function(){
		verifultact();
		loadbarrio();
		loadeps();
		loadafp();
		$(".panel-heading").click(function(e){
			$('.panel-heading').find('.fa').removeClass('fa-angle-double-down').addClass('fa-angle-double-right');
			$(this).find('.fa').removeClass('fa-angle-double-right').addClass('fa-angle-double-down');
		});
		$(".nachijo").datepicker({
			format:'yyyy-mm-dd',
			autoclose:true,
			startView: 2,
			orientation: "auto top",
		});
	});
	/////////////////////////////////////////////////////////
	$("#infogen").click(function(e){
		var clb=$("#codColaborador").val();
		var sw=$("#sw1").val();
		if(sw==0){
			$.ajax({
				url:'php/datos/proccess.php',
				type:'POST',
				data:{opc:'vcdp',clb:clb},
				success:function(res){
					$(".load1").addClass('hidden');
					$("#sw1").val('1');
					if(res==0){
						$("#formcdp").removeClass('hidden');
						$(".infpdte1").addClass('hidden');
					}else{
						$("#formcdp").addClass('hidden');
						$(".infpdte1").removeClass('hidden');
						$("#sw1").val('0');
					}
				}
			})
		}
	})
	$("#saludbi").click(function(e){
		var clb=$("#codColaborador").val();
		var sw=$("#sw2").val();
		if(sw==0){
			$.ajax({
				url:'php/datos/proccess.php',
				type:'POST',
				data:{opc:'vsb',clb:clb},
				success:function(res){
					$(".load2").addClass('hidden');
					$("#sw2").val('1');
					if(res==0){
						$("#formsb").removeClass('hidden');
						$(".infpdte2").addClass('hidden');
					}else{
						$("#formsb").addClass('hidden');
						$(".infpdte2").removeClass('hidden');
						$("#sw2").val('0');
					}
				}
			})
		}
	})
	$("#infofami").click(function(e){
		var clb=$("#codColaborador").val();
		var sw=$("#sw3").val();
		if(sw==0){
			$.ajax({
				url:'php/datos/proccess.php',
				type:'POST',
				data:{opc:'vif',clb:clb},
				success:function(res){
					$(".load3").addClass('hidden');
					$("#sw3").val('1');
					if(res==0){
						$("#formif").removeClass('hidden');
						$(".infpdte3").addClass('hidden');
					}else{
						$("#formif").addClass('hidden');
						$(".infpdte3").removeClass('hidden');
						$("#sw3").val('0');
					}
				}
			})
		}
	})
	/////////////////////////////////////////////////////////
	$("#formcdp").submit(function(e){
		e.preventDefault();
		var tel=$('#phone').val();
		var brr=$("#barrio").val();
		if(brr!=''){
			if(celular(tel)){
				$(".sbmt1").attr('disabled',true).html('<i class="fa fa-spin fa-spinner"></i>');
				var clb=$("#codColaborador").val();
				var formdata=$(this).serialize();
				$.ajax({
					url:'php/datos/proccess.php',
					type:'POST',
					data:'opc=savecdp&clb='+clb+'&'+formdata,
					success:function(res){
						if(res==1){
							verifultact();
							$("#infogen-son").removeClass('in');
							$("#formcdp").addClass('hidden');
							$("#sw1").val('0');
							swal('Datos Personales actualizados','Esta información está sujeta a la revisión y aprobación de gestión humana','success');
						}else{
							swal('Error SQL','Comuníquese con el departamento de sistemas para solucionar este error','error');
						}
						$(".sbmt1").removeAttr('disabled').html('Guardar');
					}
				})
			}else{
				swal('Verifique celular','El número celular debe tener 10 digitos!','error');
			}
		}else{
			swal('Seleccione barrio','Debe seleccionar un barrio!','error');
		}
	});
	$("#formsb").submit(function(e){
		e.preventDefault();
		var tel=$('#celem').val();
		if(celular(tel)){
			$(".sbmt2").attr('disabled',true).html('<i class="fa fa-spin fa-spinner"></i>');
			var clb=$("#codColaborador").val();
			var formdata=$(this).serialize();
			$.ajax({
				url:'php/datos/proccess.php',
				type:'POST',
				data:'opc=savesb&clb='+clb+'&'+formdata,
				success:function(res){
					if(res==1){
						verifultact();
						$("#sw2").val('0');
						$("#formsb").addClass('hidden');
						$("#saludbi-son").removeClass('in');
						swal('Información Enviada','Esta información está sujeta a la revisión y aprobación de gestión humana','success');
					}else{
						swal('Error SQL','Comuníquese con el departamento de sistemas para solucionar este error','error');
					}
					$(".sbmt2").removeAttr('disabled').html('Guardar');
				}
			})
		}else{
			swal('Verifique celular','El número celular de su contacto de emergencia debe tener 10 digitos!','error');
		}
	});
	$("#formif").submit(function(e){
		e.preventDefault();
		var clb=$("#codColaborador").val();
		////validaciones antes de enviar/////////
		var cont=1;
		if($("#hijos").val()==1){
			$(".infson").each(function(e){
				var nh=$(this).val().trim().length;
				cont*=nh;
			})
		}
		var cont2=1;
		if($("#brother").val()==1){
			$(".infbro").each(function(e){
				var nh2=$(this).val().trim().length;
				cont2*=nh2;
			})
			console.log(cont2);
		}
		////////////fin validaciones//////////
		if(cont>0){
			if($("#barrio2").val()!=''){
				if(cont2>0){
					var formdata=$(this).serialize();
					$(".sbmt3").attr('disabled',true).html('<i class="fa fa-spin fa-spinner"></i>');
					$.ajax({
						url:'php/datos/proccess.php',
						type:'POST',
						data:'opc=saveif&clb='+clb+'&'+formdata,
						success:function(res){
							if(res==1){
								verifultact();
								$("#sw3").val('0');
								$("#formif").addClass('hidden');
								$("#infofami-son").removeClass('in');
								swal('Información familiar enviada','Esta información está sujeta a la revisión y aprobación de gestión humana','success');
							}else if(res=='H'){
								swal('Error','Asegúrese de que la información de su(s) hijo(s) esté completamente diligenciada','error');
							}else if(res=='B'){
								swal('Error','Asegúrese de que la información de su(s) hermano(s) esté completamente diligenciada','error');
							}else if(res=='C'){
								swal('Error','Asegúrese de que la información de su compañero(a) esté completamente diligenciada','error');
							}else{
								swal('Error SQL','Comuníquese con el departamento de sistemas para solucionar este error','error');
							}
							$(".sbmt3").removeAttr('disabled').html('Guardar');
						}
					})
				}else{
					swal('Error','Asegúrese de que la información de su(s) hermano(s) esté completamente diligenciada','warning');
				}
			}else{
				swal('Faltan datos','Elija el barrio de residencia de sus padres','warning');
			}
		}else{
			swal('Error','Asegúrese de que la información de su(s) hijo(s) esté completamente diligenciada','warning');
		}
	})

	////////////////////////////////////////////////////////
	

	function verifultact(){
		var clb=$("#codColaborador").val();
		$.ajax({
			url:'php/datos/proccess.php',
			type:'POST',
			data:{opc:'veract',clb:clb},
			success:function(res){
				var dat=JSON.parse(res);
				var cdp=cs=cif='<b class="text-danger">NUNCA</b>';
				if(dat.cdp!=null){cdp=dat.cdp}
				if(dat.cs!=null){cs=dat.cs}
				if(dat.cif!=null){cif=dat.cif}
				$(".infogen_alt").html('Ult actualización: '+cdp);
				$(".saludbi_alt").html('Ult actualización: '+cs);
				$(".infofami_alt").html('Ult actualización: '+cif);
			}
		})
	}

	function loadbarrio(){
		var opc='<option value="">Buscar y Selec Barrio</option>';
		$.ajax({
			url:'php/datos/proccess.php',
			type:'POST',
			data:{opc:'loadbarrio'},
			success:function(res){
				var datos=JSON.parse(res);
				for(i in datos){
					opc+='<option value="'+datos[i].cod+'">'+datos[i].nom+'</option>';
				}
				$(".barrio").html(opc).select2();
			}
		})
	}
	
	function numberOnly(id) {
	    var element = document.getElementById(id);
	    var regex = /[^0-9]/gi;
	    element.value = element.value.replace(regex, "");
	}

	function loadeps(){
		var opc='<option value="" selected disabled>Seleccione EPS</option>';
		$.ajax({
			url:'php/datos/proccess.php',
			type:'POST',
			data:{opc:'loadeps'},
			success:function(res){
				var datos=JSON.parse(res);
				for(i in datos){
					opc+='<option value="'+datos[i].cod+'">'+datos[i].nom+'</option>';
				}
				$("#eps").html(opc);
			}
		})
	}

	function loadafp(){
		var opc='<option value="" selected disabled>Selecc F.pension</option>';
		$.ajax({
			url:'php/datos/proccess.php',
			type:'POST',
			data:{opc:'loadafp'},
			success:function(res){
				var datos=JSON.parse(res);
				for(i in datos){
					opc+='<option value="'+datos[i].cod+'">'+datos[i].nom+'</option>';
				}
				$("#afp").html(opc);
			}
		})
	}

	function celular(num){
		if(num.length==10){
			return true;
		}else{
			return false;
		}
	}

	$(document).on('change','#enfermedad',function(){
		var ctrl=$(this);
		if(ctrl.val()==1){
			$(".detenf").removeClass('hidden');
			$("#detenf").focus();
			$("#detenf").attr('required', 'required');
		}else{
			$(".detenf").addClass('hidden');
			$("#detenf").removeAttr('required');
		}
	});
	$(document).on('change','#restriccion',function(){
		var ctrl=$(this);
		if(ctrl.val()==1){
			$(".detrest").removeClass('hidden');
			$("#detrest").focus();
			$("#detrest").attr('required', 'required');
		}else{
			$(".detrest").addClass('hidden');
			$("#detrest").removeAttr('required');
		}
	});
	$(document).on('change','#cirugia',function(){
		var ctrl=$(this);
		if(ctrl.val()==1){
			$(".detcirugia").removeClass('hidden');
			$("#detcirugia").focus();
			$("#detcirugia").attr('required', 'required');
		}else{
			$(".detcirugia").addClass('hidden');
			$("#detcirugia").removeAttr('required');
		}
	});
	$(document).on('change','#hospital',function(){
		var ctrl=$(this);
		if(ctrl.val()==1){
			$(".dethosp").removeClass('hidden');
			$("#dethosp").focus();
			$("#dethosp").attr('required', 'required');
		}else{
			$(".dethosp").addClass('hidden');
			$("#dethosp").removeAttr('required');
		}
	});
	$(document).on('change','#tratamto',function(){
		var ctrl=$(this);
		if(ctrl.val()==1){
			$(".dettrata").removeClass('hidden');
			$("#dettrata").focus();
			$("#dettrata").attr('required', 'required');
		}else{
			$(".dettrata").addClass('hidden');
			$("#dettrata").removeAttr('required');
		}
	});
	$(document).on('change','#judicial',function(){
		var ctrl=$(this);
		if(ctrl.val()==1){
			$(".detjud").removeClass('hidden');
			$("#detjud").focus();
			$("#detjud").attr('required', 'required');
		}else{
			$(".detjud").addClass('hidden');
			$("#detjud").removeAttr('required');
		}
	});
	///////////////////////////////////////////////////
	$(document).on('change','#civil',function(){
		var ctrl=$(this);
		if((ctrl.val()==1) || (ctrl.val()==2)){
			$(".detcivil").removeClass('hidden');
			$("#detcivil").focus();
			$("#detcivil").attr('required', 'required');
			$("#detcivil2").attr('required', 'required');
			$("#detcivil3").attr('required', 'required');
		}else{
			$(".detcivil").addClass('hidden');
			$("#detcivil").removeAttr('required');
			$("#detcivil2").removeAttr('required');
			$("#detcivil3").removeAttr('required');
		}
	});
	$(document).on('change','#hijos',function(){
		var ctrl=$(this);
		if(ctrl.val()==1){
			$("#datahijo").removeClass('hidden');
			$(".nomhijo").attr('required',true);
		}else{
			$("#datahijo").addClass('hidden');
			$(".nomhijo").val('').removeAttr('required');
			$(".nachijo").val('');
		}
	});
	$(document).on('change','#brother',function(){
		var ctrl=$(this);
		if(ctrl.val()==1){
			$("#databrother").removeClass('hidden');
			$(".nombro").attr('required',true);
			$(".ocubro").attr('required',true);
			$(".telbro").attr('required',true);
			$(".agebro").attr('required',true);
		}else{
			$("#databrother").addClass('hidden');
			$(".nombro").val('').removeAttr('required');
			$(".ocubro").val('').removeAttr('required');
			$(".telbro").val('').removeAttr('required');
			$(".agebro").val('').removeAttr('required');
		}
	});
	/*Agregar otro campo de Hijo*/
	$(".addson").click(function(e){
		e.preventDefault();
		$('.arrayhijos').append('<div class="form-group addedson"><input class="form-control nomhijo infson" name="nomhijo[]" placeholder="Nombre" required><div class="input-group"><input class="form-control nachijo infson" name="nachijo[]"placeholder="Fecha de nacimiento*" readonly><span class="input-group-addon delson"><i class="fa fa-times text-danger"></i> Eliminar</span></div></div>');
		$(".nachijo").datepicker({
			format:'yyyy-mm-dd',
			autoclose:true,
			startView: 2,
			orientation: "top",
		});
	});
	$(document).on('click','.delson',function(){
		if($(".addedson").length>1){
			$(this).parent().parent().remove();
		}
	});
	/*Agregar otro campo de Hermano*/
	$(".addbro").click(function(e){
		e.preventDefault();
		$('.arraybrother').append('<div class="form-group addedbro"><div class="input-group"><span class="input-group-addon">Nombre</span><input class="form-control nombro infbro" name="nombro[]" required></div><div class="input-group"><span class="input-group-addon">Ocupación</span><input class="form-control ocubro infbro" name="ocubro[]" required></div><div class="input-group"><span class="input-group-addon">Teléfono</span><input class="form-control telbro infbro" name="telbro[]" required></div><div class="input-group"><span class="input-group-addon">Edad</span><input class="form-control agebro infbro" type="number" name="agebro[]" required><span class="input-group-addon delbro"><i class="fa fa-times text-danger"></i>Eliminar</span></div></div>');
	});
	$(document).on('click','.delbro',function(){
		if($(".addedbro").length>1){
			$(this).parent().parent().remove();
		}
	});
	$("#veraz").change(function(){
		var ctrl=$(this);
		if(ctrl.is(':checked')){
			$(".submitform").removeAttr('disabled');
		}else{
			$(".submitform").attr('disabled','disabled');
		}
	})
</script>