<?php 
include '../../cnx_data.php';
 $opc=$_POST['opc'];
 switch($opc){
 	case 'new':
	 	if(isset($_FILES['archivoPDF'])){ 
		    $actcod=$_POST['codigoactivo'];
		    $tidoc=$_POST['seltidoc'];
		    $nomad=trim($_POST['nomadjunto']);
		    $desc=$_POST['txtobserv'];
		    $sqlmx="SELECT if(MAX(ad.adjcodigo) is null,1,MAX(ad.adjcodigo)+1) FROM btyactivo_adjunto ad";
		    $resmx=$conn->query($sqlmx);
		    $rowmx=$resmx->fetch_array();
		    $max=$rowmx[0];
		    $info = new SplFileInfo($_FILES['archivoPDF']['name']);
			$ext=$info->getExtension();
		    $nomadjunto=$max.'.'.$ext;


		    if(move_uploaded_file($_FILES['archivoPDF']['tmp_name'], '../../contenidos/activos/'.$actcod.'/' . $nomadjunto)){
		       $sqladd="INSERT INTO btyactivo_adjunto (adjcodigo,adjarchivo,tadcodigo,actcodigo,adjnombre,adjdescricpcion) VALUES ($max,'$nomadjunto',$tidoc,$actcod,'$nomad','$desc')";
		       $resadd=$conn->query($sqladd);
		       if($resadd){
		       		clearstatcache();
		       		$arhivo_subido = true;
		       }else{
		    		$arhivo_subido = false;
		       }
		    }else{
		       $arhivo_subido = false;
		    } 
			?> 
			 <!DOCTYPE html>
			 <html>
			 <head>
			 </head>
			 <body>
			    <?php if($arhivo_subido): ?>
			       <script type="text/javascript">
			          parent.resultadoOk();
			       </script>
			    <?php else: ?>
			       <script type="text/javascript">
			          parent.resultadoErroneo();
			       </script>
			    <?php endif; ?>
			 </body>
			 </html>
			<?php 
	 	} 
	break;
	case 'upd':
		if($_FILES['archivoPDF2']['tmp_name']!=''){ 
		    $dac=$_POST['daccol'];
		    $tidoc=$_POST['seltidoc2'];
		    $obs=$_POST['txtobserv2'];

		    if(move_uploaded_file($_FILES['archivoPDF2']['tmp_name'], '../contenidos/documentos_colaborador/' . $dac.'.pdf')){
		       $sqladd="UPDATE btydocumento_adjunto_colaborador SET taccodigo=$tidoc, dacfecharegistro=curdate(), dachoraregistro=curtime(), dacobseracion='$obs' WHERE daccodigo=$dac";
		       $resadd=$conn->query($sqladd);
		       if($resadd){
		       		clearstatcache();
		       		$arhivo_subido = true;
		       }else{
		    		$arhivo_subido = false;
		       }
		    }else{
		       $arhivo_subido = false;
		    } 
			?> 
			 <!DOCTYPE html>
			 <html>
			 <head>
			 </head>
			 <body>
			    
			    <?php if($arhivo_subido): ?>
			       <script type="text/javascript">

			          parent.resultadoOk2();
			       </script>
			    <?php else: echo $sqladd; ?>
			       <script type="text/javascript">
			          parent.resultadoErroneo2();
			       </script>
			    <?php endif; ?>
			 </body>
			 </html>
			<?php 
	 	}else{
	 		$dac=$_POST['daccol'];
		    $tidoc=$_POST['seltidoc2'];
		    $obs=$_POST['txtobserv2'];
		    $sqladd="UPDATE btydocumento_adjunto_colaborador SET taccodigo=$tidoc, dacfecharegistro=curdate(), dachoraregistro=curtime(), dacobseracion='$obs' WHERE daccodigo=$dac";
	       $resadd=$conn->query($sqladd);
	       if($resadd){
	       		clearstatcache();
	       		$arhivo_subido = true;
	       }else{
	    		$arhivo_subido = false;
	       }
	       ?>
	       <!DOCTYPE html>
			 <html>
			 <head>
			 </head>
			 <body>
			    <?php if($arhivo_subido): ?>
			       <script type="text/javascript">
			          parent.resultadoOk2();
			       </script>
			    <?php else: echo 'boom';?>
			       <script type="text/javascript">
			          parent.resultadoErroneo2();
			       </script>
			    <?php endif; ?>
			 </body>
			 </html>
			 <?php
	 	}
	break;
	
 }
 
?>
