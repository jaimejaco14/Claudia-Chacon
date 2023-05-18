<?php 
include '../cnx_data.php';
$eliminar=$_POST['id_med'];
$react=$_POST['react'];
$edit=$_POST['id_mede'];
$nombre=$_POST['nomb'];
$all=$_POST['ali'];
if ($eliminar!="") {
	$sql='UPDATE `btyunidad_medida` SET `umeestado`= 0 WHERE `umecodigo` = '.$eliminar.'';
		 if (mysqli_query($conn, $sql)) { 
            echo "TRUE";

        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "Error updating record: " . $conn->error;
            
        }

}
 if ($edit=='si') {
  $sql="UPDATE `btyunidad_medida` SET `umeestado`= 1 WHERE (umenombre ='$nombre' or umealias= '$all')and umeestado= 0";
  if (mysqli_query($conn, $sql)) { 
            echo "TRUE";

        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            echo "Error updating record: " . $conn->error;
            
        }
 }

 $sqll="SELECT umenombre,umealias FROM btyunidad_medida WHERE umecodigo = ".$edit."";
 $result = $conn->query($sqll);
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
     $nom=$row['umenombre'];
     $alis=$row['umealias'];
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
                        <div class="form-group col-lg-1">
                          

                            <input  style="display:none" type="text" id="consec" name="consec" class="form-control" disabled="" value="'.$edit.' ">
                        </div>
                          <div class="form-group col-lg-5">
                            <label data-toggle=>Nombre Unidad</label>
                                <input value='.$nom.' maxlength="15" type="text" id="nmunidad" name="numunidad" class="form-control" required onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();">
                        </div>'?>

                        <div class="form-group col-lg-4">
                            <label>Alias</label>
                            <input value="<?php echo $alis; ?>" maxlength="3"  type="text" id="aliass" name="aliass" class="form-control" required onchange="this.value=this.value.toUpperCase();" onKeyUp="this.value=this.value.toUpperCase();">
                            
                        </div>
                    </div>
 
                </div>


                <div class="modal-footer">
                 <button class="btn btn-success"   onclick="add($('#consec').val(),$('#nmunidad').val(), $('#aliass').val() )" >
                                       Guardar
                                    </button>
                </div>
            </form>

                </div>
                </div>
                </div>
                </div>
                <script >
                function add (con,nom,ali){
                  if (nom=="" || ali=="") {
                    swal("Por Favor Complete Los Campos");
                  }else{
                	  $.ajax({
                  
                 async: false,
                 type: "POST",
                 url: "update_unidad.php",
                 data: {
                     codigo: con, nombre: nom, alias:ali
                 },
                 success: function(data) {
                    swal(data);
                 }
                });
                }
                	}
                </script>
                
                