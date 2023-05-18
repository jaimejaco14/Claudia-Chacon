<?php
include("./head.php");
    include '../cnx_data.php';
    VerificarPrivilegio("SALONES", $_SESSION['tipo_u'], $conn);
?>
<div class="content animate-panel">
    

    <!-- form here-->
    <div class="row">
      <form role="form" name="form1" method="post" id="sln_form" onsubmit="return validateform();">
        <div class="col-lg-7">
          <div class="hpanel">
            <div class="panel-heading">
              <div class="panel-tools">
                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
              </div>
              Datos del salon
            </div>
            <div class="panel-body">

              <div class="form-gruop">
                <label>
                  Nombre
                </label>
                <input class="form-control" id="sln_name" name="sln_name" maxlength="50" type="text" required>
                <div id="InfoSubGrupo" class="help-block with-errors"></div>
              </div>

              <div class="form-gruop">
                <label>
                  Direccion
                </label>
                <input class="form-control" id="sbl_dir" name="sbl_dir" maxlength="50" type="text" required>
                <div id="InfoSubGrupo" class="help-block with-errors"></div>
              </div>

              <div class="form-gruop">
                <label>
                  Telefono Fijo
                </label>
                <input class="form-control" id="sbl_fijo" name="sbl_fijo" maxlength="50"  type="number" required>
                <div id="InfoSubGrupo" class="help-block with-errors"></div>
              </div>

              <div class="form-gruop">
                <label>
                  Telefono movil
                </label>
                <input class="form-control" id="sbl_movil" name="sbl_movil" maxlength="50"  type="number" required>
                <div id="InfoSubGrupo" class="help-block with-errors"></div>
              </div>

              <div class="form-gruop">
                <label>
                  Email
                </label>
                <input class="form-control" id="sbl_email" name="sbl_email" maxlength="50" type="Email" required>
                <div id="InfoSubGrupo" class="help-block with-errors"></div>
              </div>

              <div class="form-gruop">
                <label>
                  Tamaño
                </label>
                <input class="form-control" id="sbl_size" name="sbl_size" maxlength="10" type="text" required>
                <div id="InfoSubGrupo" class="help-block with-errors"></div>
              </div>

              <div class="form-gruop">
                <label>
                  Fecha apertura
                </label>
                <input class="form-control" id="sbl_fecha_apert" name="sbl_fecha_apert"  type="date" required>
                <div id="InfoSubGrupo" class="help-block with-errors"></div>
              </div>

              <div class="form-gruop">
                <label>
                  Alias
                </label>
                <input class="form-control" id="sbl_alias" name="sbl_alias" maxlength="4" type="text" required>
                <div id="InfoSubGrupo" class="help-block with-errors"></div>
              </div>

              <div class="form-gruop">
                <label>
                  Imagen
                </label>
                <input class="form-control" id="sbl_dir" name="sbl_dir" maxlength="50" type="file" required>
                <div id="InfoSubGrupo" class="help-block with-errors"></div>
              </div>

              <br>
            <button type="submit" id="guardar" name="enviar" class="btn btn-lg btn-success">Guardar Registro</button>
            <button type="reset" class="btn btn-danger btn-lg"> Borrar todo</button>



                                        
            </div>


          </div>
         
          <br>
      </form>                  
    </div>
</div>

      
<!-- Footer-->
  <?php include "footer.php"; ?>

<!-- Vendor scripts -->
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="vendor/iCheck/icheck.min.js"></script>
<script src="vendor/sparkline/index.js"></script>
<script src="vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script src="vendor/toastr/build/toastr.min.js"></script>

<!-- App scripts -->
<script src="scripts/homer.js"></script>

<script>
            $("#sln_form").on("submit", function(event) {
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "guardar_salon.php",
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data == "true"){
                       swal({
                        title: "Salon guardado exitosamente",
                        text: "click para ir a la lista de salones",
                        type: "success",
                        confirmButtonColor: "#c9ad7d",
                        confirmButtonText: "Aceptar"
                    },
                    function () {
                       window.location.href = "salon.php";
                    });
                          
                          } 

                          else {
                             swal({
                        title: "Algo ha salido mal",
                        text: "Por favor verifique sus datos e intente nuevamente.",
                        type: "warning",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Aceptar"
                    },
                    function () {
                        swal("Booyah!");
                    });
                          }
                          
                        $("#chatbox").append(data+"<br/>");//instead this line here you can call some function to read database values and display
                    },
                });
            });
        </script>

</body>
</html>

