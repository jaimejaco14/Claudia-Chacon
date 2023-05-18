<?php    

   $xml = simplexml_load_file("../conexiones.xml");

   echo $xml->alias;

   foreach ($xml->conexion as $nodo)
   {
     echo '<option value="'.$nodo->nombre.'">'.$nodo->alias.'</option>';
   }                           

?>