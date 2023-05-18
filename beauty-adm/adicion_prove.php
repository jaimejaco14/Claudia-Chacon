          <?php 
          include '../cnx_data.php';
            $idd=$_POST['dni'];
            $ext=$_POST['exist'];
            //consulta en caso de encontrar el tercero pero no el proveedor
            if ($ext==1) {
               $sql="SELECT t.tdialias, u.tdicodigo, u.trcrazonsocial, u.trcnombres, u.trcapellidos, u.trcdireccion, u.trctelefonofijo, u.trctelefonomovil, b.brrcodigo,b.brrnombre, c.loccodigo, c.locnombre, d.depcodigo, d.depombre FROM btytercero u INNER JOIN btybarrio b on b.brrcodigo=u.brrcodigo INNER JOIN btylocalidad c on c.loccodigo = b.loccodigo INNER JOIN btydepartamento d on d.depcodigo=c.depcodigo INNER JOIN btytipodocumento t on t.tdicodigo = u.tdicodigo WHERE u.trcdocumento=$idd";
               echo "<script>
            $('#nuevog').hide();
            $('#bsq').show();
            $('#tipo_doc').prop( 'disabled', true );
            $('#rzscl').attr('readonly','readonly');
            $('#nombre').attr('readonly','readonly'); 
            $('#apellido').attr('readonly','readonly');
            $('#dep').prop( 'disabled', true );
            $('#ciudad').prop( 'disabled', true );
            $('#barrio').prop( 'disabled', true );
            $('#direccion').attr('readonly','readonly');
            $('#telefono_movil').attr('readonly','readonly');
            $('#telefono_fijo').attr('readonly','readonly');
            </script>";
            }else if($ext==0){
                //consulta en caso de encontrar el tercero con proveedor ya asignado.
            $sql="SELECT t.tdialias, p.prvemail, p.prvestado, u.tdicodigo, u.trcrazonsocial, u.trcnombres, u.trcapellidos, u.trcdireccion, u.trctelefonofijo, u.trctelefonomovil, b.brrcodigo, c.loccodigo, d.depcodigo FROM btytercero u INNER JOIN  btybarrio b on b.brrcodigo=u.brrcodigo INNER JOIN btylocalidad c on c.loccodigo = b.loccodigo INNER JOIN btydepartamento d on d.depcodigo=c.depcodigo INNER JOIN btyproveedor p on p.trcdocumento=u.trcdocumento INNER JOIN btytipodocumento t on t.tdicodigo = u.tdicodigo WHERE u.trcdocumento=$idd";
            echo "<script>
            $('#bsq').hide();
            $('#nuevog').hide();
            $('#tipo_doc').prop( 'disabled', true );
            $('#correoprv').attr('readonly','readonly');
            $('#rzscl').attr('readonly','readonly');
            $('#nombre').attr('readonly','readonly'); 
            $('#apellido').attr('readonly','readonly');
            $('#dep').prop( 'disabled', true );
            $('#ciudad').prop( 'disabled', true );
            $('#barrio').prop( 'disabled', true );
            $('#direccion').attr('readonly','readonly');
            $('#telefono_movil').attr('readonly','readonly');
            $('#telefono_fijo').attr('readonly','readonly');
            $('#estprv').attr('readonly','readonly');
            </script>";
            
        }else if($ext==2){
            //en caso de que el check digaque el tercero no existe 
            echo "<script>
                    $('#nuevog').show();
                    $('#bsq').hide();
                    $('#bsq').hide();
                    $('#correoprv').removeAttr('readonly');
                    $('#nombre').removeAttr('readonly'); 
                    $('#apellido').removeAttr('readonly');
                    $('#dep').prop( 'disabled', false );
                    $('#ciudad').prop( 'disabled', false );
                    $('#barrio').prop( 'disabled', false );
                    $('#direccion').removeAttr('readonly');
                    $('#telefono_movil').removeAttr('readonly');
                    $('#telefono_fijo').removeAttr('readonly');
                    $('#estprv').removeAttr('readonly');
                    $('#rzscl').removeAttr('readonly');
                    $('#tipo_doc').prop( 'disabled', false );
                    //------------------ vacio los input---------
                    $('#tipo_doc').val('');
                    $('#correoprv').val('');
                    $('#rzscl').val('');
                    $('#nombre').val(''); 
                    $('#apellido').val('');
                    $('#direccion').val('');
                    $('#telefono_movil').val('');
                    $('#telefono_fijo').val('');
                    $('#estprv').val('');


            </script>";

        }
  
             $result = $conn->query($sql);
                    if ($result->num_rows > 0) {

                     if ($row = $result->fetch_assoc()) {
                        $mail= $row['prvemail'];
                        $tipo=$row['tdicodigo'];
                        $nombret= $row["trcnombres"];
                        $apellidot=$row["trcapellidos"];
                        $direccion=$row["trcdireccion"];
                        $telff=$row['trctelefonofijo'];
                        $telfm=$row['trctelefonomovil'];
                        $barrio=$row['brrcodigo'];
                        $ciud=$row['loccodigo'];
                        $depto=$row['depcodigo'];
                        $razon=$row['trcrazonsocial'];
                        $estadoprv= $row['prvestado'];
                        }

                }
                $ver="display:none";
                $est="display:none";
                if ($tipo==1) {
                    $muestre="none";
                    $ver="";
                }
                
                if ($estadoprv == 1 &&  $ext ==0) {
                   $estado= "ACTIVO";
                   $est="";
                }else if($estadoprv == 0 && $estadoprv!="" && $ext ==0) {
                    $estado="INACTIVO";
                    $est="";

                }
           ?>                              
                                             <div class="form-group ">
                                               <label>Tipo Documento</label>      
                                               <select style="width: 99px" class="form-control" name="tipo_doc" id="tipo_doc" data-error="Escoja una opcion" required="NIT, CC, TI, CE">
                                            <?php
                                             include 'conexion.php';
                                             if ( $tipo!="") {
                                                echo '<option value="'.$row['tdicodigo'].'">'.$row['tdialias'].'</option>';
                                              
                                             }else{
                                              $result = $conn->query("SELECT tdicodigo, tdialias FROM btytipodocumento  ");
                                              echo '<option value=""></option>';
                                          
                                                if ($result->num_rows > 0) {
                                                   
                                                    while ($row = $result->fetch_assoc()) {                
                                                        echo '<option value="'.$row['tdicodigo'].'">'.$row['tdialias'].'</option>';
                                                    }
                                                }
                                            }
                                               // $conn->close();
                                            ?>
                                        </select>
                                        </div>
                                        <div class="form-group ">
                                             <label>Tipo de Tercero</label>  
                                                <div class="input-group col-lg-4 ">
                                                    <span class="input-group-addon">
                                                         
                                                    </span>
                                                    <input id="tipot" type="text" class="form-control" readonly="" aria-label="..." value="<?php if ($tipo>1) {
                                                       echo"Persona";
                                                    }else if ($tipo==1){
                                                        echo "Empresa";
                                                        } ?>" style="width: 100px" >
                                                </div>
                                                
                                              
                                        
                                        </div>
                                        <div class="form-group" >
                                            <label>E-mail</label>
                                            <input type="email" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" class="form-control text-uppercase" name="correoprv" id="correoprv"  placeholder="Correo Electronico" data-error="Campo obligatorio" required value="<?php echo $mail; ?>" >
                                            <div class="help-block with-errors"></div>
                                        </div> 
                                        <div class="form-group" style="display: <?php echo $muestre ?>" id="divnom">
                                            <label>Nombre</label>
                                            <input  class="form-control text-uppercase" name="nombre" id="nombre"  placeholder="Nombre" data-error="Campo obligatorio" required value=" <?php echo $nombret; ?> ">
                                            <div class="help-block with-errors"></div>
                                        </div> 
                                            <div class="form-group" style="display:<?php echo $muestre ?>" id="divape">
                                            <label>Apellido</label>
                                            <input  class="form-control text-uppercase" name="apellido" id="apellido"  placeholder="Apellido" data-error="Campo obligatorio" required value="  <?php echo $apellidot; ?> ">
                                            <div class="help-block with-errors"></div>
                                        </div> 
                                        <div class="form-group" style="<?php echo $ver ?>" id="divrz">
                                            <label>Razon Social</label>
                                            <input  class="form-control text-uppercase" name="rzscl" id="rzscl"  placeholder="Razon social" data-error="Campo obligatorio" required value="  <?php echo $razon; ?> ">
                                            <div class="help-block with-errors"></div>
                                        </div> 
                                <div class="form-group">
                                <label>Departamento</label>
                                <select  zize="30" class="form-control" name="dep" id="dep" data-error="Escoja una opcion" required>
                                    <?php
                                    //include 'conexion.php';
                                    
                                    if ($depto>='0') {
                                      $result = $conn->query("SELECT depcodigo, depombre FROM btydepartamento where depstado = 1 and NOT depcodigo = 0 and depcodigo=$depto");
                                    }else{
                                        
                                        $result = $conn->query("SELECT depcodigo, depombre FROM btydepartamento where depstado = 1 and NOT depcodigo = 0");
                                    }
                                        if ($result->num_rows > 0) {
                                            $sw = 0;
                                            while ($row = $result->fetch_assoc()) {
                                                if ($sw == 0) {
                                                    $depa = $row['depcodigo'];
                                                    $sw = 1;
                                                }  
                                                echo '<option value="'.$row['depcodigo'].'">'.$row['depombre'].'</option>';
                                            }
                                        }
                                    
                                        //$conn->close();
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <label> Ciudad </label>
                                <select  zize="30" class="form-control" name="ciudad" id="ciudad" data-error="Escoja una opcion" required>
                                    <?php
                                     //include 'conexion.php';
                                    if ($ciud>="0") {
                                        $result = $conn->query("SELECT loccodigo, locnombre FROM btylocalidad where depcodigo = $depa and loccodigo=$ciud ");
                                    }else{
                                       
                                        $result = $conn->query("SELECT loccodigo, locnombre FROM btylocalidad where depcodigo = $depa");
                                    }
                                        if ($result->num_rows > 0) {
                                            $sw = 0;
                                            while ($row = $result->fetch_assoc()) { 
                                            if ($sw == 0) {
                                                    $ciu = $row['loccodigo'];
                                                    $sw = 1;
                                                }                 
                                                echo '<option value="'.$row['loccodigo'].'">'.$row['locnombre'].'</option>';
                                            }
                                        }
                                    
                                        //$conn->close();
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                           </div>
                            <div class="form-group">
                                        <label> Barrio </label>
                                        <select class="form-control" name="barrio" id="barrio" data-error="Escoja una opcion" required>
                                        <?php
                                         //include 'conexion.php';
                                        if ($barrio>="0") {
                                            $result = $conn->query("SELECT brrcodigo, brrnombre FROM btybarrio where loccodigo = $ciu and brrcodigo=$barrio");
                                        }else{
                                       
                                        $result = $conn->query("SELECT brrcodigo, brrnombre FROM btybarrio where loccodigo = $ciu");
                                    }
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) { 
                                                echo '<option value="'.$row['brrcodigo'].'">'.utf8_encode(strtoupper($row['brrnombre'])).'</option>';
                                            }
                                        }
                                    
                                        //$conn->close();
                                    ?>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                        <div class="form-group">
                                            <label>Direccion</label>
                                            <input  class="form-control text-uppercase" name="direccion" id="direccion"  placeholder="Ejemplo: CLL 01 kr 02 - 03" data-error="Campo obligatorio" required value="<?php echo $direccion; ?>">
                                            <div class="help-block with-errors"></div>
                                        </div>                  
                                        <div class="form-group">
                                            <label>Tel&eacute;fono m&oacute;vil</label>
                                            <input  class="form-control" type="number" id="telefono_movil" min="0" name="telefono_movil" placeholder="NUMERO DE TELEFONO MOVIL" data-error="camp obligatorio" required value="<?php      echo $telfm; ?>">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Tel&eacute;fono fijo</label>
                                            <input  class="form-control" type="number" id="telefono_fijo" min="0" name="telefono_fijo" placeholder="NUMERO DE TELEFONO FIJO" value="<?php echo $telff; ?>">
                                            <div class="help-block">
                                      </div>
                                      </div>
                                      <div class="form-group" style="<?php echo $est ?>" >
                                            <label>Estado del proveedor</label>
                                            <input  class="form-control" type="text" id="estprv" min="0" name="estprv" placeholder="Estado del proveedor" value="<?php echo $estado; ?>">
                                            <div class="help-block">
                                      </div>
                                      </div>
                          <br>
                          </div>
                          </form> 
                          <script>
                              $('#tipo_doc').change(function(){
                                if ($('#tipo_doc').val()!="") {
                                    if ($('#tipo_doc').val()==1) {
                                        $('#tipot').val('Empresa');
                                        $('#divnom').hide();
                                        $('#divape').hide();
                                        $('#divrz').show();
                                    }else{
                                         $('#tipot').val('Persona');
                                         $('#divnom').show();
                                        $('#divape').show();
                                        $('#divrz').hide();
                                    }
                                }else{
                                    $('#tipot').val('');
                                }
                               
                            });
                                  $('#dep').change(function(){
                                    var depa = $(this).val();
                                    var depart = 'ciudad='+depa;
                                    $.ajax({
                                        type: "POST",
                                        url: "buscar_ciudad.php",
                                        data: depart,
                                        success: function(data) {
                                            $('#ciudad').html(data);
                                            brr ();
                                        }
                                    });
                                });
                                $('#ciudad').change(function(){
                                    brr ();
                                });
                                function brr () {
                                    var cod_brr = $('#ciudad').val();
                                    var brr = 'barrio='+cod_brr;
                                    $.ajax({
                                        type: "POST",
                                        url: "buscar_barrio.php",
                                        data: brr,
                                        success: function(data) {
                                            $('#barrio').html(data);
                                        }
                                    });
                                }
                              </script>