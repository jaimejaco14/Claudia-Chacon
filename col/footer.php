<br><br>

<footer class="footer" style="position: absolute;bottom: 0;">
    <span class="pull-right">
       <b> Derechos Reservados <script>var f = new Date(); document.write(f.getFullYear())</script>
    </span>
    <b>BEAUTY SOFT</b> 
</footer>
<script type="text/javascript">
	$(document).on('click','.opcmenu',function(e){
        e.preventDefault();
        var lnk=$(this).attr('href');
        $(".bodys").removeClass('show-sidebar');
        $('#wrapper').html('<center><h1 class="text-center" style="position: fixed;"><i class="fa fa-spin fa-spinner"></i> Cargando...</h1></center>');
        setTimeout(window.location=lnk, 600);
    });
</script>

