<?php
session_start();
include 'head.php';
?>

<div class="content animate-panel">
        <div class="row">
            <div class="col-md-3">
                <div class="hpanel hbggreen" >
                    <div class="panel-body" style="background-color: #62cb31!important;">
                        <div class="text-center">
                            <h3>CLIENTES</h3>
                            <p class="text-big font-light">
                                <?php 
                                $cli=mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) FROM btycliente c WHERE c.cliestado=1"));
                                echo $cli[0];
                                ?>
                            </p>
                            <small>
                                Registrados hasta este momento
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel hbgred">
                    <div class="panel-body" id="detallecol" style="cursor:pointer;">
                        <div class="text-center">
                            <h3>COLABORADORES</h3>
                            <p class="text-big font-light">
                                <?php  
                                    $totcol = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) FROM btycolaborador c WHERE c.clbestado=1"));
                                    echo $totcol[0];
                                ?>
                            </p>
                            <small>
                                Total Colaboradores
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel hbgblue">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3>MENSAJES DE TEXTO</h3>
                            <p class="text-big font-light">
                                <?php  
                                    $totsms = mysqli_fetch_array(mysqli_query($conn,"SELECT COUNT(*) FROM btyregistro_sms r WHERE YEAR(r.smsfecha)= YEAR(CURDATE()) AND MONTH(r.smsfecha)= MONTH(CURDATE())"));
                                    echo $totsms[0];
                                ?>
                            </p>
                            <small>
                                Enviados durante el presente mes
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel hbgyellow">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3>Title text</h3>
                            <p class="text-big font-light">
                                750
                            </p>
                            <small>
                                texto   
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                    <center><b>MEDIOS DE REGISTRO</b></center>
                    <?php
                    $sql="SELECT c.clitiporegistro, COUNT(*) FROM btycliente c GROUP BY c.clitiporegistro";
                    $res=$conn->query($sql);
                    while($row=$res->fetch_array()){
                        $medios.=$row[0].'•';
                        $cantci.=$row[1].'•';
                    }
                    ?>
                       <div id="canvasdiv2"> 
                            <canvas id="myChart2" style="width:100%;height:230px;"></canvas>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="text-center">
                            <h2 class="m-b-xs">Box title</h2>
                            <p class="font-bold text-info">Lorem ipsum</p>
                            <div class="m">
                                <i class="pe-7s-global fa-5x"></i>
                            </div>
                            <p class="small">
                                Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            </p>
                            <button class="btn btn-info btn-sm">Action button</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="text-center">
                            <h2 class="m-b-xs">Box title</h2>
                            <p class="font-bold text-warning">Lorem ipsum</p>
                            <div class="m">
                                <i class="pe-7s-display1 fa-5x"></i>
                            </div>
                            <p class="small">
                                Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            </p>
                            <button class="btn btn-warning btn-sm">Action button</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="text-center">
                            <h2 class="m-b-xs">Box title</h2>
                            <p class="font-bold text-danger">Lorem ipsum</p>
                            <div class="m">
                                <i class="pe-7s-airplay fa-5x"></i>
                            </div>
                            <p class="small">
                                Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            </p>
                            <button class="btn btn-danger btn-sm">Action button</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="hpanel">
                    <div class="panel-body">
                    <?php
                        $resclianio=mysqli_fetch_array(mysqli_query($conn,"SELECT 
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 1 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 2 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 3 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 4 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 5 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 6 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 7 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 8 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 9 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 10 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 11 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 12 THEN 1 ELSE 0 END),'0')
                                from btycliente c
                                where year(c.clifecharegistro)=year(curdate())"));
                        for($i=0;$i<=11;$i++){
                            $clianio.=$resclianio[$i].'•';
                        }
                        $resclianio2=mysqli_fetch_array(mysqli_query($conn,"SELECT 
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 1 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 2 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 3 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 4 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 5 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 6 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 7 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 8 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 9 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 10 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 11 THEN 1 ELSE 0 END),'0'),
                                IFNULL(SUM(CASE WHEN month(c.clifecharegistro) = 12 THEN 1 ELSE 0 END),'0')
                                from btycliente c
                                where year(c.clifecharegistro)=year(curdate())-1"));
                        for($i=0;$i<=11;$i++){
                            $clianioa.=$resclianio2[$i].'•';
                        }
                    ?>
                        <center>
                            <h4>CLIENTES REGISTRADOS POR MES</h4>
                        </center>
                        <center>
                            <select class="form-control" name="selclianio" id="selclianio">
                                <option value="1">Año Actual</option>
                                <option value="2">Año Anterior</option>
                            </select>
                        </center><br>
                       <div id="canvasdiv"> 
                            <canvas id="myChart" width="400" height="170"></canvas>
                       </div>
                        
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="stats-title pull-left">
                            <h4>Income</h4>
                        </div>
                        <div class="stats-icon pull-right">
                            <i class="pe-7s-ticket fa-4x"></i>
                        </div>
                        <div class="m-t-xl">
                            <h1 class="text-warning">$200,00</h1>
                            <small>
                                Lorem Ipsum is simply dummy text of the printing and <strong>typesetting industry</strong>. Lorem Ipsum has been.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="stats-title pull-left">
                            <h4>Messages</h4>
                        </div>
                        <div class="stats-icon pull-right">
                            <i class="pe-7s-attention fa-4x"></i>
                        </div>
                        <div class="m-t-xl">
                            <h1 class="text-danger">680</h1>
                            <small>
                                Lorem Ipsum is simply dummy text of the printing and <strong>typesetting industry</strong>. Lorem Ipsum has been.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Task</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Lorem ipsum</span>
                                    </td>
                                    <td>Jul 14, 2013</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Lorem ipsum</span>
                                    </td>
                                    <td>Jul 09, 2015</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-success font-bold">Lorem ipsum</span>
                                    </td>
                                    <td>Jul 24, 2014</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Task</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <span class="text-info font-bold">Lorem ipsum</span>
                                    </td>
                                    <td>Jul 14, 2013</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-info font-bold">Lorem ipsum</span>
                                    </td>
                                    <td>Jul 09, 2015</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-info font-bold">Lorem ipsum</span>
                                    </td>
                                    <td>Jul 24, 2014</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Task</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <span class="text-warning font-bold">Lorem ipsum</span>
                                    </td>
                                    <td>Jul 14, 2013</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-warning font-bold">Lorem ipsum</span>
                                    </td>
                                    <td>Jul 09, 2015</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-warning font-bold">Lorem ipsum</span>
                                    </td>
                                    <td>Jul 24, 2014</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="hpanel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Task</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <span class="text-danger font-bold">Lorem ipsum</span>
                                    </td>
                                    <td>Jul 14, 2013</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-danger font-bold">Lorem ipsum</span>
                                    </td>
                                    <td>Jul 09, 2015</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-danger font-bold">Lorem ipsum</span>
                                    </td>
                                    <td>Jul 24, 2014</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            </div>
        </div>
</div>
</div>

<!-- Vendor scripts -->
<?php include "./librerias_js.php"; ?> 

<script>
  $('#side-menu').children(".active").removeClass("active");
  $("#INICIO").addClass("active");  
  
    $(function () {

         $('#datepicker').datepicker();
            $("#datepicker").on("changeDate", function(event) {
                $("#my_hidden_input").val(
                        $("#datepicker").datepicker('getFormattedDate')
                )
            });

            $('#datapicker2').datepicker();
            $('#datepicker .input-group.date').datepicker({ });
            $('#datepicker .input-daterange').datepicker({ });
            $('#datetimepicker1').datetimepicker();
        function call () {
            /* initialize the calendar
         -----------------------------------------------------------------*/
        var p = $("#p").val();
        if (p == "salon"){
            var a = $("#salon").val();
        } if (p== "clb") {
            var a = $("#cola").val();
        }
        $('#calendar').fullCalendar({

         eventClick: function(calEvent, jsEvent, view) {

        var trn = calEvent.id;
        var fecha = new Date(calEvent.start);
        y = fecha.getFullYear();
        m = fecha.getMonth();
        m++;
        d = fecha.getDate();
        var fecha_turno = y+"-"+m+"-"+d;
        //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
        //alert('View: ' + view.name);
                $.ajax({
            type: "POST",
            url: "find_col_on_turn.php",
            data: {id_turno: trn, fch: fecha_turno},
            success: function(data) {
                $('#lista').html(data);
            }
        });
        $('#my_modal').modal('show'); 

        // change the border color just for fun
        $(this).css('border-color', 'red');

    },
            lang: 'es',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar
            drop: function() {
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
           

            events: "find_progra.php?p="+p+"&codigo="+a


        });



        }
        /* initialize the external events
         -----------------------------------------------------------------*/

        $('#external-events div.external-event').each(function() {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 1111999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
        });


        call ();

        $('#salon').change( function() {
            $('#calendar').fullCalendar('destroy');
            call();
            
        });
                $('#clb').change( function() {
            $('#calendar').fullCalendar('destroy');
            call();
            
        });
        $('#by_clb').click(function() {
            $('#p').val('clb');
            $('#clb').show();
            $('#sln').hide();
            $('#calendar').fullCalendar('destroy');
            call();
        });
        $('#by_sln').click(function() {
            $('#p').val('salon');
            $('#clb').hide();
            $('#sln').show();
            $('#calendar').fullCalendar('destroy');
            call();
        });
    });
</script>
<script>//graficos

Chart.defaults.global.legend.display = false;
    var clianio ='<?php echo $clianio;?>';
    var clianioa ='<?php echo $clianioa;?>';
    var medios='<?php echo $medios;?>';
    var cantci='<?php echo $cantci;?>';
    graficar(clianio);
    graficarpie();
    function graficar(can) {
        
        var cantmes=can.split('•');

        var mes = [];
        var cant    = [];
        var col    = [];

        meses=["ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"];
        col = ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "#0d8ccb", "#0d51ce", "#290ccd", "#bb00cc", "#cc0d01"];

         for (i=0;i<meses.length;i++)
        {
            mes.push(meses[i]);
            cant.push(parseInt(cantmes[i]));
            col.push(col[i]);
        }

         var chartdata = 
                {
                    labels: mes,
                    datasets: [
                        {
                            label: 'Clientes Registrados',
                            backgroundColor: col,
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverbackgroundColor: 'rgba(200, 200, 200, 1)',
                            hoverborderColor: 'rgba(200, 200, 200, 1)',
                            data:cant
                        }
                    ] 
                };

      var ctx = $('#myChart').get(0).getContext("2d");

        var barGraph = new Chart(ctx, 
        {
            type:'horizontalBar',
            data: chartdata,
            options: 
            {
                legend: 
                {
                    display: false
                },
                scales: 
                {
                    pointLabelFontSize: 10
                }        
            }
        });
    }
    function clear ()
    {
        $("#canvasdiv").html('');
        $("#canvasdiv").html('<canvas id="myChart" width="400" height="170"></canvas>');
    }
    $("#selclianio").change(function(e){
        var opc=$(this).val();
        clear();
        if(opc==1){
            graficar(clianio);
        }else if(opc==2){
            graficar(clianioa);
        }
    });
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    function graficarpie(){
        var med=medios.split('•');
        var cantm=cantci.split('•');

        var medio = [];
        var cant    = [];

         for (i=0;i<med.length-1;i++)
        {
            medio.push(med[i]);
            cant.push(parseInt(cantm[i]));
        }

        new Chart(document.getElementById("myChart2"), 
        {
            type: 'pie',
            data: 
            {
                labels: medio,
                datasets: [{
                    backgroundColor: ["#cc0d01", "#fb6300","#fb9b00","#f8cf01","#f4fb00", "#addb08", "#04cf14", "#0d8ccb", "#0d51ce", "#290ccd"],
                    data: cant
                }]
            },
                options: {
                    title: {
                        display: true,
                    }
                }
        });
    }
</script>
</body>
</html>