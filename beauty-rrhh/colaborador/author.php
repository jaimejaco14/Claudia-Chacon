<?php
    include '../head.php';

  	VerificarPrivilegio("AUTORIZACIONES", $_SESSION['tipo_u'], $conn);
?>
<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>


<div class="content">
	<div class="row">
        <div class="col-md-4 col-md-offset-1">
            <div class="hpanel panel-group">
                <div class="panel-body">
                    <div class="text-center text-muted font-bold">Buscar Autorización</div>

                </div>
                <div class="panel-section">

                    <div class="input-group">
                        <input type="text" class="form-control" id="inputbuscar" placeholder="Digite código o beneficiario...">
                           <span class="input-group-btn">
                                <button class="btn btn-info" id="btnModalNuevaAut" data-toggle="tooltip" data-placement="top" title="Nueva Autorización" type="button"><i class="fa fa-plus"></i> </button>
                                <button class="btn btn-warning" id="btnModalReporte" data-toggle="tooltip" data-placement="top" title="Reportes" type="button"><i class="fa fa-line-chart"></i> </button>
                           </span>
                    </div>
                   
                </div>
                    <div class="input-group" style="width: 100%!important">
                        <select name="" id="buscarTipo" class="form-control" required="required" >
                          <option value="0" selected>Buscar por Tipo</option>
                        <?php 
                          $sql = mysqli_query($conn, "SELECT * FROM btyautorizaciones_tipo WHERE autestado = 1 ORDER BY alias");

                          while($row = mysqli_fetch_array($sql))
                          {
                            echo '<option value="'.$row['auttipo_codigo'].'">'.utf8_encode($row['nombre']).'</option>';
                            
                          }

                        ?>
                        </select>

                    </div>
                    <br>

                <div id="notes" class="collapse">              
                    
                </div>



            </div>
        </div>
        <div class="col-md-7">
            <div class="hpanel">

                <div class="panel-body">

                    <!-- <div class="tab-content" id="contenido">
                    </div> -->
                    <table class="table table-hover table-bordered" id="tblContent">
                      <tbody>
                                              
                    </table>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalNuevaAut" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-check"></i> Gestionar Autorización</h4>
      </div>
      <div class="modal-body">
           <div class="panel panel-default">
           	<div class="panel-body">
           		<div class="col-md-12">
           			<div class="col-md-6">
           				<form action="" method="POST" id="formNuevaAut">
           				
           					<div class="form-group">
           						<label for="">Clasificación</label>
           						<select name="selTipo" id="selTipo" class="form-control">
           							<option value="0" selected>Seleccione tipo...</option>
           							<?php 
           								$sql = mysqli_query($conn, "SELECT * FROM btyautorizaciones_tipo WHERE autestado = 1 ORDER BY nombre");

           								while($row = mysqli_fetch_array($sql))
           								{
           									echo '<option value="'.$row['auttipo_codigo'].'">'.utf8_encode($row['nombre']).'</option>';
           									
           								}

           							?>
           						</select>
           					</div>

           					


           					<div class="form-group">
           						<!-- <label for="">Seleccione Subtipo</label>
           						<select name="" id="selSubtipo" class="form-control" required="required">
           							<option value="0" selected>Seleccione</option>
           							
           						</select> -->
           						<div class="input-group"><select name="selSubtipo" id="selSubtipo" class="form-control" required="required">
           							<option value="0" selected>Seleccione subtipo...</option>
           							
           						</select> <span class="input-group-btn"> <button type="button" class="btn btn-primary" id="btnNuevoSubtipo" data-toggle="tooltip" data-placement="right" title="Ingresar Nuevo Subtipo"><i class="fa fa-plus"></i>
                        			</button> </span></div>
           					</div>

           					<div class="form-group">
           						<label for="">Salón y beneficiario</label>
           						<select name="selSalon" id="selSalon" class="form-control" required="required">
           							<option value="" selected>Seleccione salón...</option>
           							<?php 
           								$sql = mysqli_query($conn, "SELECT * FROM btysalon  ORDER BY slnnombre");

           								while($row = mysqli_fetch_array($sql))
           								{
           									echo '<option value="'.$row['slncodigo'].'">'.ucwords(strtolower(utf8_encode($row['slnnombre']))).'</option>';
           									
           								}

           							?>
           						</select>
           					</div>


           					<div class="form-group" id="groupCol">

           						<div class="input-group">
           							  <select name="selColaborador" id="selColaborador" class="form-control" required="required" data-placeholder="Seleccione">
           						</select> 
           						<span class="input-group-btn"> <button type="button" class="btn btn-primary" id="btnNuevoBeneficiario" data-toggle="tooltip" data-placement="right" title="Ingresar Beneficiario"><i class="fa fa-plus"></i>
                        			</button> </span>
                      </div>


           					</div>

	                    <div class="form-group" id="groupCli" style="display: none">
	                      <label for="" id="lblbeneficiario">Ingrese Beneficiario</label>
	                      <input type="text" id="txtbeneficiario" name="txtbeneficiario" class="form-control" value=""  title="Digite beneficiario">
                        <input type="hidden" id="docTer" name="docTer"> 
	                    </div>

           
           					<label for="" id="labelValor">Digite Valor</label>     						
           					 <div class="input-group m-b"><span class="input-group-addon" id="sign">$</span> <input type="text" class="form-control"  id="valor" name="valor"><input type="number" class="form-control"  id="porcentaje" style="display:none"></div>          				
           					
           				

                </div>
          <br>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="">Por concepto de</label>
                    <textarea name="observacion" id="observacion" class="form-control" rows="6" style="resize: none;" placeholder="Justifique aquí el egreso..."></textarea>
                  </div>
                </div>

                <div class="col-md-6" style="padding-top: 20px">
                  <div class="form-group">
                      <label for="">Fecha</label>
                      <input type="text" class="form-control"  id="fecha" name="fecha" placeholder="0000-00-00">
                    </div>
                </div>

               <!--  <div class="col-md-12" id="divfoto" style="padding-top: 10px; display: none">
                 <div class="form-group">
                     <label for="">Foto</label>
                     <input type="file" class="form-control"  id="foto">
                   </div>
               </div> -->
                <div class="col-md-12" id="divfoto" style="padding-top: 10px; display: none">
                <div class="input-group">
                          <input type="file" name="foto" class="form-control"  id="foto">
                      <span class="input-group-btn"> <button type="button" class="btn btn-primary" id="btnNuevoBeneficiario" data-toggle="tooltip" data-placement="right" title="Ingrese Foto"><i class="fa fa-plus"></i>
                              </button> </span>
                </div>


              </div>
            </div>
           <div class="panel-footer">
                Autorizaciones Beauty Soft
            </div>
           </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnIngresarAut2">Ingresar <i class="fa fa-cog fa-spin send" style="display:none"></i></button>
           				</form>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalNuevoSubtipo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Subtipo</h4>
      </div>
      <div class="modal-body">
        <form action="" method="POST" role="form">
        	<input type="hidden" id="tipo_new">
        	<div class="form-group">
        		<label for="">Ingrese Subtipo</label>
        		<input type="text" class="form-control" id="subtipo_new" placeholder="Digite el subtipo">
        	</div>

        	<div class="form-group">
        		<label for="">Ingrese Descripción</label>
        		<textarea name="" id="descripcion" class="form-control" rows="3" required="required" placeholder="Ingrese la descripción (opcional)"></textarea>
        	</div>
        
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarSubtipo">Guardar</button>
      </div>
    </div>
  </div>
</div>





<div class="modal fade" id="modalNuevoBeneficiario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-users"></i> Nuevo Beneficiario</h4>
      </div>
      <div class="modal-body">
          <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active" id="liper">
                <a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-users"></i> Persona Mantenimiento</a>
              </li>
              <li role="presentation" id="lipp">
                <a href="#tab" aria-controls="tab" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Persona Proveedor</a>
              </li>
            </ul>
          
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="home">
                <br>
                  <form action="" method="POST" role="form" id="formnewbenef">
                        <input type="hidden" id="tipo_new">

                          <div class="row">
                              <div class="col-md-12">                
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="">Seleccione Tipo Documento</label>
                                              <select name="" id="tdicodigo" class="form-control" required="required">
                                                <?php 
                                                     $sql = mysqli_query($conn, "SELECT * FROM btytipodocumento WHERE tdiestado = 1 ORDER BY tdialias");

                                                     while($row = mysqli_fetch_array($sql))
                                                     {
                                                       echo '<option value="'.$row['tdicodigo'].'">'.ucwords(strtolower(utf8_encode($row['tdinombre']))).'</option>';
                                                       
                                                     }

                                                   ?>
                                              </select>
                                      </div>
                                  </div>
          <div class="col-md-6">
            <div class="form-group">
                    <label for="">Ingrese Documento</label>
                    <input type="number" class="form-control" id="documento" placeholder="Digite el documento">
                  </div>
          </div>
              </div>

              <div class="col-md-12">                
          <div class="col-md-6">
            <div class="form-group">
                    <label for="">Nombres</label>
                    <input type="text" class="form-control" id="nombres" placeholder="Digite el nombre">
                  </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                    <label for="">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" placeholder="Digite el apellido">
                  </div>
          </div>
              </div>

              <div class="col-md-12">                
          <div class="col-md-6">
            <div class="form-group">
                    <label for="">Dirección</label>
                    <input type="text" class="form-control" id="direccion" placeholder="Digite la dirección">
                  </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                    <label for="">Móvil</label>
                    <input type="number" maxlength="10" id="movil" onblur="validar(this)" placeholder="Digite número móvil" class="form-control" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" id="subtipo_new">
                  </div>
          </div>
              </div>

              <div class="col-md-12">                
          <div class="col-md-4">
            <div class="form-group">
                    <label for="">Fijo</label>
                    <input type="number" class="form-control" maxlength="7" id="fijo" placeholder="Digite número fijo" class="form-control" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Digite el número fijo">
                  </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                    <label for="">E-mail</label>
                    <input type="text" class="form-control" id="email" placeholder="Digite el e-mail">
                  </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
                    <label for="">Fecha de Nacimiento</label>
                    <input type="text" class="form-control" id="fechanuevaPersona" placeholder="0000-00-00">
                  </div>
          </div>
              </div>

              
            </div>

        
        </form>
      
      
              </div>
              <div role="tabpanel" class="tab-pane" id="tab">.
                    <!--============================================
                    =            Ingreso de Proveedores            =
                    =============================================-->
                    
                    <form action="" method="POST" role="form">
                          <div class="row">
                              <div class="col-md-12">                
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="">Seleccione Tipo Documento</label>
                                              <select name="" id="tdicodigoPro" class="form-control" required="required">
                                                <?php 
                                                     $sql = mysqli_query($conn, "SELECT * FROM btytipodocumento WHERE tdiestado = 1 ORDER BY tdialias");

                                                     while($row = mysqli_fetch_array($sql))
                                                     {
                                                       echo '<option value="'.$row['tdicodigo'].'">'.ucwords(strtolower(utf8_encode($row['tdinombre']))).'</option>';
                                                       
                                                     }

                                                   ?>
                                              </select>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="">Ingrese Documento</label>
                                            <input type="number" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="15" class="form-control" id="documentoPro" placeholder="Digite el documento">
                                          </div>
                                  </div>
                              </div>

                              <div class="col-md-12" id="">                
                                  <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="">Nombres</label>
                                            <input type="text" class="form-control" id="nombresPro" placeholder="Digite el nombre">
                                    </div>
                                  </div>
                                  <div class="col-md-6" >
                                    <div class="form-group">
                                            <label for="">Apellidos</label>
                                            <input type="text" class="form-control" id="apellidosPro" placeholder="Digite el apellido">
                                          </div>
                                  </div>
                              </div>

                              
                              <div class="col-md-12">                
                                  <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="">Dirección</label>
                                            <input type="text" class="form-control" id="direccionPro" placeholder="Digite el nombre">
                                          </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="">Móvil</label>
                                            <input type="number" maxlength="10" id="movilPro" onblur="validar(this)" placeholder="Digite número móvil" class="form-control" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control">
                                          </div>
                                  </div>
                              </div>

                              <div class="col-md-12">                
                                  <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="">Fijo</label>
                                            <input type="number" class="form-control" maxlength="7" id="fijoPro" placeholder="Digite número fijo" class="form-control" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Digite el número fijo">
                                          </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="">E-mail</label>
                                            <input type="text" class="form-control" id="emailPro" placeholder="Digite el e-mail">
                                          </div>
                                  </div>
                                  <!-- <div class="col-md-4">
                                    <div class="form-group">
                                            <label for="">Fecha de Nacimiento</label>
                                            <input type="text" class="form-control" id="fechanuevaPersonaPro" placeholder="0000-00-00">
                                          </div>
                                  </div> -->
                              </div>
                            </div>
                          </form>
                    
                    <!--====  End of Ingreso de Proveedores  ====-->
                    
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarPersona">Guardar</button>
      </div>
    </div>
  </div>
</div>




<?php include "../librerias_js.php"; ?>
<script src="js/author223.js"></script>
<!-- <script src="js/authmantenimiento.js"></script> -->