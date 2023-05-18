<!DOCTYPE html>
<html>
<head>
	<title>subir imagen salon</title>
</head>
<body>
<?php
if ((isset($_POST["enviado"])) && ($_POST["enviado"] == "form1")) {
$nombre_archivo=$_FILES['userfile']['name'];
move_uploaded_file($_FILES['userfile']['tmp_name'],"/dev/app_final/imagenes/servicios".$nombre_archivo);

?>
<script>
opener.document.form1.imagen.value="<?php echo $nombre_archivo; ?>";
self.close();


</script>
<?php
}
else
{?>

<form action="" method="post" enctype="multipart/form-data" id="form1">
  <p>
    <input name="userfile" type="file" />
  </p>
  <p>
    <input type="submit" name="button" id="button" value="Subir Imagen" />
  </p>
      <input type="hidden" name="enviado" value="form1" />
</form>
<?php } ?>

</body>
</html>