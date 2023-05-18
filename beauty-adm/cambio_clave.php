<?php
include 'head.php';

?>
<div class="content animate-panel">

<div>

    
    <!-- form here-->
    <div class="row">
       
                        <div class="col-lg-7">
        <div class="hpanel">
        <div class="panel-heading">
            <div class="panel-tools">
                <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                <a class="closebox"><i class="fa fa-times"></i></a>
            </div>
            Cambio de clave
        </div>
        <div class="panel-body">
                                               <form action="Cambiar_clave.php" method="post" id="f1" name="f1" onsubmit='return validate_password()' >
                                              <div class="form-group">
                                                  <div id="epasswordActual" style="color:#f00;"></div>
                                                <label>Digite su clave actual</label>
                                                <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña actual" required>
                                             
                                              </div>   
                                           
                                                <div class="form-group">
                                                   
                                   <label>Ingrese su nueva clave</label>
                                   <input type="password" class="form-control has-feedback" placeholder="Nueva Contraseña" name="newpassword" id="newpassword" required>
                                   <span id="passstrength"></span>
                             
                                                </div>
                                            
                                                 <div class="form-group">
                                   <label>Confirme su nueva clave</label>
                                   <input type="password" class="form-control" placeholder="Confirmar contraseña" name="confirpass" id="confirpass" required>
                                    <div id="epasswordNew1" style="color:#f00;"></div>
                            </div>
                                                <div id="Info" class="help-block with-errors"> <?php echo $_SESSION['Respuesta'];
                                                $_SESSION['Respuesta']='';?></div>  
                                               
                                <button type="submit" name="guardar" id="guardar"  class="btn btn-success">Guardar</button>

                                    </form>                               
            
        </div>
        </div>
        </div>
            </div>




</div>

    <!-- Right sidebar -->
    <div id="right-sidebar" class="animated fadeInRight">

        <div class="p-m">
            <button id="sidebar-close" class="right-sidebar-toggle sidebar-button btn btn-default m-b-md"><i class="pe pe-7s-close"></i>
            </button>
            <div>
                <span class="font-bold no-margins"> Analytics </span>
                <br>
                <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
            </div>
            <div class="row m-t-sm m-b-sm">
                <div class="col-lg-6">
                    <h3 class="no-margins font-extra-bold text-success">300,102</h3>

                    <div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
                </div>
                <div class="col-lg-6">
                    <h3 class="no-margins font-extra-bold text-success">280,200</h3>

                    <div class="font-bold">98% <i class="fa fa-level-up text-success"></i></div>
                </div>
            </div>
            <div class="progress m-t-xs full progress-small">
                <div style="width: 25%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="25" role="progressbar"
                     class=" progress-bar progress-bar-success">
                    <span class="sr-only">35% Complete (success)</span>
                </div>
            </div>
        </div>
        <div class="p-m bg-light border-bottom border-top">
            <span class="font-bold no-margins"> Social talks </span>
            <br>
            <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.</small>
            <div class="m-t-md">
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="images/a1.jpg" alt="profile-picture">
                        </a>

                        <div class="media-body">
                            <span class="font-bold">John Novak</span>
                            <small class="text-muted">21.03.2015</small>
                            <div class="social-content small">
                                Injected humour, or randomised words which don't look even slightly believable.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="images/a3.jpg" alt="profile-picture">
                        </a>

                        <div class="media-body">
                            <span class="font-bold">Mark Smith</span>
                            <small class="text-muted">14.04.2015</small>
                            <div class="social-content">
                                Many desktop publishing packages and web page editors.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social-talk">
                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img src="images/a4.jpg" alt="profile-picture">
                        </a>

                        <div class="media-body">
                            <span class="font-bold">Marica Morgan</span>
                            <small class="text-muted">21.03.2015</small>

                            <div class="social-content">
                                There are many variations of passages of Lorem Ipsum available, but the majority have
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-m">
            <span class="font-bold no-margins"> Sales in last week </span>
            <div class="m-t-xs">
                <div class="row">
                    <div class="col-xs-6">
                        <small>Today</small>
                        <h4 class="m-t-xs">$170,20 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                    <div class="col-xs-6">
                        <small>Last week</small>
                        <h4 class="m-t-xs">$580,90 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <small>Today</small>
                        <h4 class="m-t-xs">$620,20 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                    <div class="col-xs-6">
                        <small>Last week</small>
                        <h4 class="m-t-xs">$140,70 <i class="fa fa-level-up text-success"></i></h4>
                    </div>
                </div>
            </div>
            <small> Lorem Ipsum is simply dummy text of the printing simply all dummy text.
                Many desktop publishing packages and web page editors.
            </small>
        </div>

    </div>

    <!-- Footer-->
    <footer class="footer">
        <span class="pull-right">
            Example text
        </span>
        Company 2015-2020
    </footer>

</div>

<!-- Vendor scripts -->
<?php include "librerias_js.php"; ?>





<script type="text/javascript">
<!--
function validate_password()
{
    //Cogemos los valores actuales del formulario
    pasActual=document.f1.password;
    pasNew1=document.f1.newpassword;
    pasNew2=document.f1.confirpass;
    //Cogemos los id's para mostrar los posibles errores
    id_epassActual=document.getElementById("epasswordActual");
    id_epassNew=document.getElementById("epasswordNew1");

    //Patron para los numeros
    var patron1=new RegExp("[0-9]+");
    //Patron para las letras
    var patron2=new RegExp("[a-zA-Z]+");

    var patron3=new RegExp("[A-Z]+");
    if(pasNew1.value==pasNew2.value && pasNew1.value.length>=8 && pasActual.value !="" && pasNew1.value.search(patron1)>=0 && pasNew1.value.search(patron2)>=0 && pasNew1.value.search(patron3)>=0 ){
        //Todo correcto!!!
        return true;
    }else{
        if(pasNew1.value.length<8)
            id_epassNew.innerHTML="La longitud mínima tiene que ser de 8 caracteres";
        else if(pasNew1.value!=pasNew2.value)
            id_epassNew.innerHTML="La copia de la nueva contraseña no coincide";
        else if(pasNew1.value.search(patron1)<0 || pasNew1.value.search(patron2)<0)
            id_epassNew.innerHTML="La contraseña tiene que tener numeros y letras";
        else if(pasNew1.value.search(patron3)<0)
            id_epassNew.innerHTML="La contraseña tiene que tener mayusculas";
        else
            id_epassNew.innerHTML="";
        if(pasActual.value=="")
            id_epassActual.innerHTML="Indicar tu contraseña actual";
        else
            id_epassActual.innerHTML="";
        return false;
    }
}
-->
</script>

    <script type="text/javascript">
            
$(document).ready(function() {
          $('#guardar').click(function(){

        $('#Info').html('').fadeOut(1000);

        var password = document.getElementById("password").val;        
        var dataString = 'password='+password;

        $.ajax({
            type: "POST",
            url: "cambiar_clave.php",
            data: dataString,
            success: function(data) {
                $('#Info').html(data);
            }
        });
    });  
});   
</script>
</body>
</html>