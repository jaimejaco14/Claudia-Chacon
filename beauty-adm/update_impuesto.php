<?php 
include '../cnx_data.php';
$eliminar=$_POST['id_med'];
$react=$_POST['react'];
$edit=$_POST['id_mede'];
$nombre=$_POST['nomb'];
$all=$_POST['alia'];
if ($eliminar!="") {
	$sql='UPDATE `btyimpuesto_ventas` SET `imvestado`= 0 WHERE `imvcodigo` = '.$eliminar.'';
		 if (mysqli_query($conn, $sql)) { 
            echo "TRUE";

        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "Error updating record: " . $conn->error;
            
        }

}
 if ($edit=='si') {
  $sql="UPDATE `btyimpuesto_ventas` SET `imvestado`= 1 WHERE (imvnombre ='$nombre' or imvalias= '$all')and imvestado= 0";
  if (mysqli_query($conn, $sql)) { 
            echo "TRUE";

        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "Error updating record: " . $conn->error;
            
        }
 }

 $sqll="SELECT imvnombre,imvalias,imvalor, imvporcentaje FROM btyimpuesto_ventas WHERE imvcodigo = ".$edit."";
 $result = $conn->query($sqll);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
     $nom=$row['imvnombre'];
     $alis=$row['imvalias'];
     $tipo=$row['tipo'];
     $valor=$row['imvalor'];
  }
 }

  echo' <div class="animate-panel">
                <div class="hpanel">
                <div class="panel-heading">
                
                    <br>
                </div>
                <div class="panel-body">
                          <form >     
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-12">
                           <input  style="display:none" type="text" id="consec" name="consec" class="form-control" disabled="" value="'.$edit.' ">
                        </div>
                          <div class="col-md-6">
                            <label data-toggle=>Impuesto</label>
                                <input value='.$nom.' maxlength="50" type="text" id="nmunidad" name="numunidad" class="form-control" required onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();">
                        </div>
                        <div class="col-md-6">
                            <label>Alias</label>
                            <input value="' .$alis.'" maxlength="10"  type="text" id="aliass" name="aliass" class="form-control" required onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();">
                        </div>
                         <div class="col-md-6">
                            <label>Tipo</label>
                            <select name="tipo_imp" id="tipo_imp" class="form-control">                            
                                <option value="1">Porcentaje </option>
                                <option value="0">Fijo </option>                        
                            </select>                            
                        </div>

                        <div class="col-md-6">
                            <label>Valor</label>
                            <input type="number" id="val_imp" value="'.$valor.'" name="val_imp" class="form-control">              
                        </div>
                    </div>';
                    ?>
 
                </div>


                <div class="modal-footer">
                 <button class="btn btn-success"   onclick="add($('#consec').val(),$('#nmunidad').val(), $('#aliass').val(), $('#tipo_imp').val(), $('#val_imp').val() )" > Guardar </button>
                </div>
            </form>

                </div>
                </div>
                </div>
                </div>
                <script >
                function add (con,nom,ali,tipo, valor){
                  if (nom=="" || ali=="" || tipo=="" || valor== "") {
                    swal("Por Favor Complete Los Campos");
                  }else{
                	  $.ajax({
                  
                 async: false,
                 type: "POST",
                 url: "actualizar_impuesto.php",
                 data: {
                     codigo: con, nombre: nom, alias:ali, tipo:tipo, valor:valor
                 },
                   success: function(data) {
                      swal(data);
                   }
                });
                }
                	}
                </script>
                
                