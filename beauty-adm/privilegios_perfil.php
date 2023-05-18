<?php 
    include("./head.php");
    include '../cnx_data.php';

  VerificarPrivilegio("PRIVILEGIOS", $_SESSION['tipo_u'], $conn);
  revisarLogin();
?>
<div class="content animated-panel">

    <!-- Modal Nuevo rol -->
  <div class="modal fade" tabindex="-1" role="dialog" id="modal_linea">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Crear nuevo tipo de usuario</h4>
      </div>
        <form id="role_from" name="role_from" method="post" enctype="multipart/form-data">
      <div class="modal-body">
          <div class="form-gruop">
              <label>
                  Nombre
              </label>
              <input class="form-control" id="rol_name" name="rol_name" maxlength="50" type="text" onKeyUp="this.value=this.value.toUpperCase();" required>
              <div id="InfoLinea" class="help-block with-errors"></div>
          </div>
           <div class="form-gruop">
              <label>
                  Alias
              </label>
               <input class="form-control" id="rol_alias" name="rol_alias" type="text" maxlength="3" required>
          </div>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Guardar</button>
       
      </div>
         </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


    <div class="hpanel">
        <div class="panel-body">
            <a class="small-header-action" href="">
                <div class="clip-header">
                    <i class="fa fa-arrow-up"></i>
                </div>
            </a>

            <div id="hbreadcrumb" class="pull-right m-t-lg">
                <ol class="hbreadcrumb breadcrumb">
                    
                    <li><a href="index.php">Inicio</a></li>
                    <li>
                        <span>App views</span>
                    </li>
                    <li class="active">
                        <span>Privilegios</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-9">
            <div class="row">
                <div class="col-lg-12">
                            <div class="input-group">
                                <select class="form-control" type="text" id="perfil" name="perfil" > 
                                <?php
                                    $sql = "SELECT `tiucodigo`, `tiunombre`, `tiualias` FROM `btytipousuario` WHERE tiuestado = 1 ORDER BY TIUNOMBRE";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0){
                                        $sw = 0;
                                        while ($row=$result->fetch_assoc()) {
                                            # code...
                                            if ($sw == 0) {
                                                $tiucodigo = $row['tiucodigo'];
                                                $sw = 1;
                                            }
                                            
                                            echo "<option value='".$row['tiucodigo']."'>".$row['tiunombre']."</option>";
                                        }
                                    }

                                ?>
                                </select>
                                <div class="input-group-btn">
                                    
                                      <a><button  class="btn btn-default" data-toggle="modal" data-target="#modal_linea"  title="Nuevo"><i class="fa fa-plus-square-o text-info"></i></button></a>
                                 
                                </div>
                                <div class="input-group">
                                
                                </div>
                                
                            </div>
                    
                        </div>
                    </div>
                </div>
            </div>   
        </div>
<div id="result" class="col-lg-12">
          <div class="col-lg-5">
            <div class="animate-panel">
                <div class="hpanel">
                <div class="panel-heading">
                    <h3 class="panel-title">Privilegios de Perfil</h3>
                </div>
                <div class="panel-body">

                <div class="list-group" id="left">
                            <?php
                    $sql = "SELECT prinombre, pricodigo, pridescripcion FROM btyprivilegio WHERE pricodigo NOT IN (SELECT p.pricodigo FROM btytipousuario tiu INNER JOIN btyprivilegioperfil pp ON pp.tiucodigo = tiu.tiucodigo INNER JOIN btyprivilegio p ON p.pricodigo = pp.pricodigo WHERE tiu.tiucodigo = '$tiucodigo' and tiu.tiuestado = 1) ORDER BY prinombre";
                     $result = $conn->query($sql);
                    if ($result->num_rows > 0){
                    
                            while ($row=$result->fetch_assoc()) {
                            # code...
                                echo "<div id='div".$row['pricodigo']."'><button data-toggle='tooltip' data-placement='left' title='".$row['pridescripcion']."' id='".$row['pricodigo']."'  type='button' onclick='orientar (this);'  value='left' class='list-group-item'>".$row['prinombre']."</button> <input type='hidden' name='one[]' value='".$row['pricodigo']."' /> </div>";
                            }
                    }

                 ?>
				        </div>

                </div>
                </div>
                </div>
</div>
          <div class="col-lg-2">
           <div class="animate-panel">
                <div class="hpanel">
                <div class="panel-heading">
                    <h3 class="panel-title">Acciones</h3>
                </div>
                <div class="panel-body">

                <div class="list-group">

                 <br> <br>
                  <button type="button" id="put"  data-placement="right" class="list-group-item text-info"><center><i class="fa fa-angle-right text-info"></i></center></button>
                  <button type="button" id="quit" class="list-group-item"><center><i class="fa fa-angle-left text-info"></i></center></button>
                  <button type="button" id="put_all" onclick="left_all();" class="list-group-item"><center><i class="fa fa-angle-double-right text-info"></i></center></button>
                  <button type="button" id="quit_all" onclick="right_all ();" class="list-group-item"><center><i class="fa fa-angle-double-left text-info"></i></center></button>

                  <br>
                  <!--<center><button type="button" id="save" onclick="guardar();" class="btn btn-success"><center>Guardar</center></button></center>-->
                </div>


                </div>
                </div>
                </div>
</div>

    <div class="col-lg-5">
            <div class="animate-panel">
                <div class="hpanel">
                <div class="panel-heading">
                    <h3 class="panel-title">Privilegios asignados</h3>
                </div>
                <div class="panel-body">
                 
                <div class="list-group" id="righ">
               <form method="post" id="form_pri" action="update_pri.php">
               <input type="hidden" name="tipo" value="<?php echo $tiucodigo; ?>">
                <?php
                //include "conexion.php";
                    $sql = "SELECT p.prinombre, p.pricodigo  , p.pridescripcion FROM btytipousuario tiu INNER JOIN btyprivilegioperfil pp ON pp.tiucodigo = tiu.tiucodigo INNER JOIN btyprivilegio p ON p.pricodigo = pp.pricodigo WHERE tiu.tiucodigo = '$tiucodigo' and tiu.tiuestado = 1 ORDER BY prinombre";
                     $result = $conn->query($sql);
                    if ($result->num_rows > 0){
                        while ($row=$result->fetch_assoc()) {
                            # code...
                            echo "<div id='div".$row['pricodigo']."'> <button type='button' data-toggle='tooltip' data-placement='left' title='".$row['pridescripcion']."' id='".$row['pricodigo']."' value='right' onclick='orientar (this);' class='list-group-item'>".$row['prinombre']."</button>  <input type='hidden' name='one[]' value='".$row['pricodigo']."'> </div>";
                        }
                    }
                ?>
                 </form>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
<?php
include "librerias_js.php";
?>
<script>
  $('side-menu').children(".active").removeClass("active");  
  $("#USUARIOS").addClass("active");
  $("#PRIVILEGIOS").addClass("active");
</script>
<script src="../lib/scripts/privilegios.js"></script>
<script type="text/javascript">
function ok() {
  swal({
    title: "Tipo de usuario Guardado correctamente",
    text: "",
    type: "success",
    confirmButtonText: "Aceptar"
  },
  function () {
    window.location = "privilegios_perfil.php";
  });
}
function fail() {
  swal({
    title: "Vaya... algo ha salido mal.",
    text: "Por favor intenta nuevamente",
    type: "warning",
    confirmButtonText: "Aceptar"
  },
  function () {
    window.location = "privilegios_perfil.php";
  });
    

}
    $("#role_from").on("submit", function(event) {
        event.preventDefault();
        var f = $(this);
        var formData = new FormData(document.getElementById("role_from"));
        formData.append("dato", "valor");
        $.ajax({
            url: "insert_rol.php",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        })
        .done(function(res){
        if (res == "TRUE"){
           ok ();
        } else {
          fail();
        }
        });
    });
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

 $(document).ready(function() {
    conteoPermisos ();
});
</script>
</body>
</html>