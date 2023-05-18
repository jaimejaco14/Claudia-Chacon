         <?php
         $tiucodigo = $_POST['tiucodigo'];
         include '../cnx_data.php';
         
         ?>
         <div class="col-lg-5">
          <div class="animate-panel">
            <div class="hpanel">
              <div class="panel-heading">
                <h3 class="panel-title">Privilegios de Perfil</h3>
              </div>
              <div class="panel-body">

                <div class="list-group" id="left">
                  <?php
                  $sql = "SELECT prinombre, pricodigo FROM btyprivilegio WHERE pricodigo NOT IN (SELECT p.pricodigo FROM btytipousuario tiu INNER JOIN btyprivilegioperfil pp ON pp.tiucodigo = tiu.tiucodigo INNER JOIN btyprivilegio p ON p.pricodigo = pp.pricodigo WHERE tiu.tiucodigo = '$tiucodigo' and tiu.tiuestado = 1) order by prinombre";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0){

                    while ($row=$result->fetch_assoc()) {
                            # code...
                      echo "<div id='div".$row['pricodigo']."'><button id='".$row['pricodigo']."'  type='button' onclick='orientar (this);'  value='left' class='list-group-item'>".$row['prinombre']."</button> <input type='hidden' name='one[]' value='".$row['pricodigo']."' /> </div>";
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
               <button type="button" id="put" class="list-group-item text-info"><center><i class="fa fa-angle-right text-info"></i></center></button>
               <button type="button" id="quit" class="list-group-item"><center><i class="fa fa-angle-left text-info"></i></center></button>
               <button type="button" id="put_all" onclick="left_all();" class="list-group-item"><center><i class="fa fa-angle-double-right text-info"></i></center></button>
               <button type="button" id="quit_all" onclick="right_all ();" class="list-group-item"><center><i class="fa fa-angle-double-left text-info"></i></center></button>
               <br>
               <!-- <center><button type="button" id="save" onclick="guardar();" class="btn btn-success"><center>Guardar</center></button></center> -->
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
               $sql = "SELECT p.prinombre, p.pricodigo FROM btytipousuario tiu INNER JOIN btyprivilegioperfil pp ON pp.tiucodigo = tiu.tiucodigo INNER JOIN btyprivilegio p ON p.pricodigo = pp.pricodigo WHERE tiu.tiucodigo = '$tiucodigo' and tiu.tiuestado = 1  order by p.prinombre";
               $result = $conn->query($sql);
               if ($result->num_rows > 0){
                while ($row=$result->fetch_assoc()) {
                            # code...
                  echo "<div id='div".$row['pricodigo']."'> <button type='button' id='".$row['pricodigo']."' value='right' onclick='orientar (this);' class='list-group-item'>".$row['prinombre']."</button>  <input type='hidden' name='one[]' value='".$row['pricodigo']."'> </div>";
                }
              }


              ?>

            </form>
          </div>



        </div>
      </div>
    </div>
  </div>
  <script src="../lib/scripts/privilegios.js"></script>