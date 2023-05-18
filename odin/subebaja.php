<?php 
    include '../cnx_data.php';
    include("head.php");
    include("librerias_js.php");
?>
<div class="content animated-panel">
    <div class="col-lg-12">
        <div class="hpanel">
            <div class="tab-content">
                <a class="btn btn-primary" href="inicio.php">volver</a>
                <a class="btn btn-default pull-right" href="logout.php" title="Cerrar Sesión">Cerrar sesión <i class="pe-7s-sign-out"></i></a>
                <div class="panel-body">
                    <div class="row"> 
                        <center><h3>Reset colaborador en sube y baja</h3></center><br>
                        <div class="col-md-4">
                            <select id="sln" class="form-control">
                                <?php
                                $sql="SELECT slncodigo, slnnombre FROM btysalon WHERE slnestado=1 order by slnnombre";
                                $res=$conn->query($sql);
                                ?>
                                 <option value="0">Seleccione Salón</option>
                                <?php
                                while($row=$res->fetch_array()){
                                    ?>
                                    <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select id="clb" class="form-control"></select>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-info okbtn">OK</button>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<script>
    /*************************************Busqueda de colaborador**************************/
        $(document).ready(function() {
            $('#clb').selectpicker({
                liveSearch: true,
                title:'Buscar y seleccionar colaborador...'
            });
        });
        $('#clb').on('show.bs.select', function (e) 
        {
            $('.bs-searchbox').addClass('seekclb');
            $('.seekclb .form-control').attr('id', 'seekclb');
        });

        $(document).on('keyup', '#seekclb', function(event) {
            var seek = $(this).val();
            $.ajax({
                url: 'subebajaoper.php',
                type: 'POST',
                data:'opc=seek&texto='+seek,
                success: function(data){
                    var json = JSON.parse(data);
                    var colaboradores = "";
                    for(var i in json){
                        colaboradores += "<option value='"+json[i].codigo+"'>"+json[i].nombrecol+"</option>";
                    }
                    $("#clb").html(colaboradores);
                    $("#clb").selectpicker('refresh');
                }
            }); 
        });
    /**************************************************************************************/


    $(".okbtn").click(function(e){
        e.preventDefault();
        var sln=$("#sln").val();
        var clb=$("#clb").val();
        if(sln!=0 && clb!=''){
            $.ajax({
                url:'subebajaoper.php',
                type:'POST',
                data:'opc=proc&sln='+sln+'&clb='+clb,
                success:function(data){
                    console.log(data);
                    if(data==1){
                         swal('Exitoso!','El colaborador ha sido removido del sube y baja.','success');
                    }else if(data==0){
                        swal('Oops!','No se encontraron registros que cumplan las condiciones elegidas, verifique e intentelo nuevamente','error')
                    }
                }
            });
        }else{
             swal('Atención!','Debe seleccionar un salón y un colaborador!','warning');
        }
    })
</script>