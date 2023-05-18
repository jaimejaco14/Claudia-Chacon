<?php
$actcod=$_GET['actcod'];
?>
<body onload="javascript:window.print()">
    <div>
        <center>
            <?php echo '<img src="qr.php?codact='.$actcod.'" />';?>
        </center>
    </div>
</body>