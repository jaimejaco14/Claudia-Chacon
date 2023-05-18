
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>Beauty ERP | </title>

     <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" type="image/ico" href="imagenes/favicon.png" />

    <!-- Vendor styles -->
    <link rel="stylesheet" href="../../lib/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../../lib/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="../../lib/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="../../lib/vendor/bootstrap/dist/css/bootstrap.css" />
     <link rel="stylesheet" href="../../lib/vendor/sweetalert/lib/sweet-alert.css" />
    <link rel="stylesheet" href="../../lib/vendor/toastr/build/toastr.min.css" />

    <link rel="stylesheet" href="../../lib/vendor/select2-3.5.2/select2.css" />
    <link rel="stylesheet" href="../../lib/vendor/select2-bootstrap/select2-bootstrap.css" />

    <link rel="stylesheet" href="../../lib/vendor/fullcalendar/dist/fullcalendar.print.css" media="print"/>
    <link rel="stylesheet" href="../../lib/vendor/fullcalendar/dist/fullcalendar.min.css" />
    <link rel="stylesheet" href="../../lib/vendor/bootstrap-datepicker-master/dist/css/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="../../lib/vendor/clockpicker/dist/bootstrap-clockpicker.min.css" />
    <link rel="stylesheet" href="../../lib/vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    

    <!-- App styles -->
    <link rel="stylesheet" href="../../lib/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="../../lib/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="../../lib/styles/style.css">
    <link rel="stylesheet" href="../../lib/styles/static_custom.css">



</head>
<body class="landing-page">
<row><img class="img-animate pull-left" src="../../contenidos/images/claudia-chacon_logo-365.png"> <br></row>

<!-- Simple splash screen-->
<!-- <div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>Homer - Responsive Admin Theme</h1><p>Special Admin Theme for small and medium webapp with very clean and aesthetic style and feel. </p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div> -->
<!--[if lt IE 7]>
<p class="alert alert-danger">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->


<!-- <header id="page-top">
    <div class="container">
        <div class="heading">
            <h1>
                Mi programaci&oacute;n.
            </h1>
            <span>Recibe mayores beneficios registrandote con nosotros...<br/> registrate como cliente de Claudia Chacón.</span>
            <p class="small">
 <img class="img-animate" src="images/claudia-chacon_logo-365.png">

               
            </p>
            <a href="#" class="btn btn-success btn-sm">Saber mas</a>

        </div>
        <div class="heading-image animate-panel" data-child="img-animate" data-effect="fadeInRight">
            <p class="small">  <img class="img-animate" src="images/claudia-chacon_logo-365.png">
            </p>
            
            
            <br/>
            
        </div>
    </div>
</header>
 -->


<section id="clients">
    <div class="container">     
        <input type="hidden" id="cola" value="<?php echo $_GET['codigo']; ?>">
        <input type="hidden" id="nombre" value="<?php echo $_GET['nombre']; ?>">

        <div class="row text-center m-t-lg">
            <div class="">

                    <div class="col-md-12" id="panelCalendario">
                        <div class="content animate-panel">
                            <div class="row">
                                <div class="hpanel">
                                    <div class="panel-heading">
                                        <div class="panel-tools">
                                        </div>
                                        Programación de <?php echo $_GET['nombre']; ?>
                                       <!--  <button class="btn btn-default pull-right" id="btn_export" title="Cargar imagen para guardar"></i> <i class="pe-7s-date text-info"></i></button> -->
                                        <!-- <a id="btn-Convert-Html2Image" class="btn-link btn pull-right" href="#/">Descargar</a> -->
                                        <div class="dropdown pull-right">
                                          <button class="btn btn-default dropdown-toggle btn-Convert-Html2Image" type="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Exportar
                                            <span class="caret"></span>
                                          </button>
                                          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                            <li><a href="#/" class="btn-Convert-Html2Image"><i class="fa fa-picture-o"></i> PNG</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="" title="PDF" class="btn_pdf" id="btn_report"><i class="fa fa-file-pdf-o"></i> PDF</a></li>
                                          </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- <img class="img-animate" src="images/claudia-chacon_logo-365.png"> -->


            </div>

        </div>


    </div>
</section>


<!-- Vendor scripts -->
<?php 
include '../librerias_js.php'; ?>

<!-- App scripts -->
<script src="scripts/homer.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
<script src="addimage.js"></script>

<!-- Local script for menu handle -->
<script>
$(document).ready(function () 
{
    $('[data-toggle="tooltip"]').tooltip();

       

    function crear_calendario () 
    {
        var p = "clbs";
        var a = $('#cola').val();

        $('#calendar').fullCalendar({
            textColor : "#0c0c0c",
            lang: 'es',
            header: 
            {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar
            drop: function() 
            {
                if ($('#drop-remove').is(':checked')) 
                {
                    $(this).remove();
                }
            },

            eventRender: function(event, element)
            {
                $(element).tooltip({title: "SALON: " +event.salon + " - " + "TURNO: " + event.turno, container: "body"});

                switch (event.res) 
                {
                    case 'LABORA':
                        //element.find(".fc-content").css('background-color','rgb(21,142,39)');
                        element.find(".fc-title").append("<center><b>"+event.res+" </b> </center>" + "<center>" + event.desde + "  " + event.hasta+"</center>" + "<center>" + event.salon + "</center>").css('color', '#333');
                        break;

                    case 'DESCANSO':
                    event.backgroundColor = '#565656';
                       element.find(".fc-content").append("<center><b><i class='fa fa-coffee'></i><br>"+event.res+"</b></center>").css({'height': '30px', 'color': '#333'});

                       /*element.find(".fc-content").css('height', '30px');

                        element.find('.fc-time-grid-event').css('background-color', event.backgroundColor);
                        element.find('.fc-event').css('background-color', event.backgroundColor);
                        element.find('.fc-start').css('background-color', event.backgroundColor); 
                        element.find('.fc-end').css('background-color', event.backgroundColor);  */  

                        //.css({"background-color": "yellow", "font-size": "200%"});

                        break;
              
                    default:
                         element.find(".fc-title").append("<center><b>"+event.res+" </b> </center>");
                    break;
                }

                if (event.backgroundColor == '#400080') {
                    element.find(".fc-title").css('color', '#ffffff');
                }else{
                    if (event.backgroundColor == '#ff0000') {
                        element.find(".fc-title").css('color', '#ffffff');
                    }
                }

               //#ff0000

               
            },
           
            events: "find_progra_img.php?p="+p+"&codigo="+a //carga las programaciones existentes,
            
        });
    }
        crear_calendario();

        $('a.page-scroll').bind('click', function(event) 
        {
            var link = $(this);
            $('html, body').stop().animate({
                scrollTop: $(link.attr('href')).offset().top - 50
            }, 500);
            event.preventDefault();
        });

        $('body').scrollspy({
            target: '.navbar-fixed-top',
            offset: 80
        });

});
</script>
<!-- It can be also directive -->
</body>
</html>

<!-- Modal -->
<div class="modal fade" id="ver_progra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Ver Programación</h4>
      </div>
      <div class="modal-body">
        <span id="codigo"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalpreview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width: 95%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Ver Programación</h4>
      </div>
      <div class="modal-body">
        <div id="preview"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a id="btn-Convert-Html2Image" class="btn-link btn pull-right" href="#/" data-action="share/whatsapp/share">Descargar</a>
      </div>
    </div>
  </div>
</div>

<script src="canvashtml.js"></script>
<script>
$(document).ready(function(){

var element = $("#clients"); // global variable
var getCanvas; // global variable
 
    //$(document).on('click', '#btn_export', function () {
        //$('#modalpreview').modal("show");
    
                       
    
    //});

    $(".btn-Convert-Html2Image").on('click', function () {
         html2canvas(element, {
             onrendered: function (canvas) {
                    //$("#preview").append(canvas);  
                    getCanvas = canvas;                
                 },
                   width: 1200,
                   height: 1200
             }); 
    var imgageData = getCanvas.toDataURL("image/jpg");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/jpg/, "data:application/octet-stream");
        $(".btn-Convert-Html2Image").attr("download", "PROGRAMACION_<?php echo $_GET['nombre']; ?>.jpg").attr("href", newData);
    });



    var doc = new jsPDF();
    var specialElementHandlers = {
            '#clients': function (element, renderer) {
            return true;
        }
    };

    $('#ignorePDF').click(function () {
                            var specialElementHandlers = 
                            function (element,renderer) {
                            return true;
                            }
                            var doc = new jsPDF();
                            doc.fromHTML($('#clients').html(), 15, 15, {
                            'width': 1200,
                            'elementHandlers': specialElementHandlers
                            });
                            doc.output('datauri'); 
                        });

   /* $('#ignorePDF').click(function () {
        doc.fromHTML($('#clients').html(), 15, 15, {
            'width': 1100,
                'elementHandlers': specialElementHandlers,

        });
        doc.save('sample-file.pdf');
    }); 
*/

});

/*function addURL(element)
{
    var moment = $('#calendar').fullCalendar('getDate');
    var mes = moment.format('M');
    $(element).attr('href', function() {
        return this.href + '&mes='+mes+' ';
    });
}
*/
        

$(document).on('click', '#btn_report', function() {
    var moment = $('#calendar').fullCalendar('getDate');
    var mes = moment.format('M');
     window.open("reporteProgramacionCol.php?codcolaborador="+ $("#cola").val()+"&nombre="+$('#nombre').val()+"&mes="+mes+"");
     //url  ="http://192.168.1.202/beauty/reporteProgramacionCol.php"+window.location.href;
     //window.open(url);
});



</script>
<?php 
$mes = $_GET['mes'];
 ?>


<style>
    .fc-content{
        height: 70px!important;
    }

    .fc-day-grid-event > .fc-content {
        white-space: normal;
    }

    /* fc-time-grid-event, .fc-v-event .fc-event, .fc-start, .fc-end, .fc-draggable, .fc-resizable:before {
        background-color: purple!important;
    } */
</style>