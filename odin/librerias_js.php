

<script src="../lib/vendor/jquery/dist/jquery.min.js"></script>
<script src="../lib/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="../lib/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="../lib/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../lib/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="../lib/vendor/iCheck/icheck.min.js"></script>
<script src="../lib/vendor/sparkline/index.js"></script>
<script src="../lib/vendor/sweetalert/lib/sweet-alert.min.js"></script>
<script src="../lib/vendor/toastr/build/toastr.min.js"></script>

<script src="../lib/vendor/select2-3.5.2/select2.min.js"></script>
<!-- Vendor scripts -->
<script src="../lib/vendor/moment/min/moment.min.js"></script>
<script src="../lib/vendor/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="../lib/vendor/fullcalendar/dist/lang-all.js"></script>

<!-- DataTables -->
<script src="../lib/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="../lib/vendor/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- DataTables buttons scripts -->
<script src="../lib/vendor/pdfmake/build/pdfmake.min.js"></script>
<script src="../lib/vendor/pdfmake/build/vfs_fonts.js"></script>
<script src="../lib/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="../lib/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="../lib/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="../lib/vendor/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>

<script src="../lib/vendor/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
<script src="../lib/vendor/clockpicker/dist/bootstrap-clockpicker.min.js"></script>
<script src="../lib/vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="js/selectpicker/selectpicker.js"></script>
<!-- <script src="vendor/nestable/jquery.nestable.js" type="text/javascript"></script> -->

<!--Block UI-->
<script src="../lib/vendor/blockui/blockui.js"></script>

<!-- App scripts -->
<script src="../lib/scripts/homer.js"></script>

<!-- <script src="../lib/permisos.js"></script> -->


<!-- <script src="js/main.js"></script> -->

<script>


	 $(document).ready(function() {
        $(document).on('click', '.selector', function(event) {
            var href = document.location.href;
            var url = href.substr(href.lastIndexOf('/') + 1);
            //var res = url.substr(19); 
            var usu = $('#usuario').val();
            
            $.ajax({
                url: 'bloquear_pantalla.php',
                method: 'POST',
                data: {url:url},
                success: function (data) 
                {
          
                    window.location="bloquear_pantalla.php?url="+url+"&usuario="+usu+"";
                }
            });
        });
    });
</script>