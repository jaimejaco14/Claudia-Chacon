<?php 
include '../../cnx_data.php';

	if (!$conn) 
	{
    		die("Error al establecer conexión con la base de datos. " . mysqli_connect_error());
	}

    $fecha=$_POST['fecha'];
    $vec=explode('-',$fecha);
    $nmes=$vec[1];
    switch($nmes){
      case '01':$mes='ENERO';
      break;
      case '02':$mes='FEBRERO';
      break;
      case '03':$mes='MARZO';
      break;
      case '04':$mes='ABRIL';
      break;
      case '05':$mes='MAYO';
      break;
      case '06':$mes='JUNIO';
      break;
      case '07':$mes='JULIO';
      break;
      case '08':$mes='AGOSTO';
      break;
      case '09':$mes='SEPTIEMBRE';
      break;
      case '10':$mes='OCTUBRE';
      break;
      case '11':$mes='NOVIEMBRE';
      break;
      case '12':$mes='DICIEMBRE';
      break;
    }

function quitar_tildes($cadena) 
{
  $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
  $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
  $texto = str_replace($no_permitidas, $permitidas ,$cadena);
  return $texto;
}

	include "../librerias_js.php";
?>

<table class="table table-hover table-striped table-bordered">
                    <thead>
                    <tr>
                      <th rowspan="2" class="text-center" style="vertical-align:middle;">
                            COLABORADOR<br><span> <i class="fa fa-filter text-info" id="btnModal" style="cursor: pointer;"></i></span><br>
                        </th>
                      <?php 

                        $dias = mysqli_query($conn, "SELECT DAY(LAST_DAY('$fecha')), MONTH('$fecha') ");

                            $rows = mysqli_fetch_array($dias); 

                            $semana = array('LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO');



                            $primerDia = mysqli_query($conn, "SET lc_time_names = 'es_CO';");

                            $y ="SELECT UCASE(DAYNAME(CAST(DATE_FORMAT('$fecha' ,'%Y-%m-01') as DATE)))";
                            

                            $primerDia = mysqli_query($conn, $y);


                            $filaDias = mysqli_fetch_array($primerDia);                         
                            $filaDias[0]=quitar_tildes(utf8_encode($filaDias[0]));                         

                            $sw=true;
                            $e=0;$i=0;$sem=1;
                            while ($sw) 
                            {

                                if ($filaDias[0] == "LUNES") 
                                {
                                  $d=7;
                                  $e+=$d;
                          
                              echo '<th colspan="7" class="text-center">SEMANA '.$sem.'</th>';
                                  $sw=false;
                                  $sem++;
                                }
                                else if ($filaDias[0] == $semana[$i]) 
                                {
                                    $d = COUNT($semana) - $i;
                                    $e+=$d;
                                    $sw=false;
                                    echo '<th colspan="'.$d.'" class="text-center">SEMANA '.$sem.'</th>'; 
                                    $sem++;                                   
                                }

                                  $i++;   
                                
                                                          
                              
                            }
                            //echo $e;
                            while ( $e <= $rows[0]) 
                            {
                          $d=7;
                          $e+=$d;
                          echo '<th colspan="'.$d.'" class="text-center">SEMANA '.$sem.'</th>';
                          $sem++;
                              
                            }                     
                                         
                       ?>
                    </tr>
                      <tr>
                          

                          <?php 
                                $dias = mysqli_query($conn, "SELECT DAY(LAST_DAY('$fecha'))");

                                $rows = mysqli_fetch_array($dias);

                                $semana = array('LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO');



                                $primerDia = mysqli_query($conn, "SET lc_time_names = 'es_CO';");

                                $y ="SELECT UCASE(DAYNAME(CAST(DATE_FORMAT('$fecha' ,'%Y-%m-01') as DATE)))";
                                //echo $y;

                                $primerDia = mysqli_query($conn, $y);


                                $filaDias = mysqli_fetch_array($primerDia);                              
                                $filaDias[0]=quitar_tildes(utf8_encode($filaDias[0]));

                                //echo $filaDias[0];

                                $queryFes = mysqli_query($conn, "SELECT DAY(a.fesfecha)AS dia FROM btyfechas_especiales a WHERE MONTH(a.fesfecha) = MONTH('$fecha') ORDER BY a.fesfecha");

                                $diaFestivo='';

                                while($fes = mysqli_fetch_array($queryFes))
                                {
                                    $diaFestivo.=$fes['dia'].',';
                                }

                                $vectorFestivo = explode(',',$diaFestivo);

                                


                                $x = 0;
                                for ($i=0; $i < COUNT($semana); $i++) 
                                {

                                    if ($semana[$i] == $filaDias[0]) 
                                    {
                                        $k=$i;

                                        for ($j=1; $j <= $rows[0] ; $j++) 
                                        {
                                            //echo $vectorFestivo[$x] . "***" . $j . "<br>";

                                            if($semana[$k]== 'DOMINGO')
                                            {
                                                if ($vectorFestivo[$x] == $j)
                                                {
                                                    $color='red';
                                                    $x++;
                                                }
                                                else
                                                {
                                                    $color='red';
                                                }                                   
                                            }
                                            else
                                            {
                                                if ($vectorFestivo[$x] == $j)
                                                {
                                                    $color='red';
                                                    $x++;
                                                }
                                                else
                                                {
                                                    $color='';
                                                }
                                                
                                            
                                            }
                                            echo ' 
                                                <th style="text-align:center;color:'.$color.';" >'.$j .  "<br> " . substr($semana[$k],0,3).'</th>
                                            ';

                                            $k++;                           

                                            if ($k > 6) 
                                            {
                                                $k=0;
                                            }
                                        }
                                    }
                                    
                                }
                    
                           ?>
                          
                      </tr>
                      </thead>
                      <tbody>

                      <?php 


                              $sql = mysqli_query($conn, "SELECT DISTINCT a.clbcodigo, c.trcrazonsocial, crg.crgnombre FROM btyprogramacion_colaboradores a JOIN btycolaborador b ON a.clbcodigo=b.clbcodigo JOIN btytercero c ON c.tdicodigo=b.tdicodigo AND c.trcdocumento=b.trcdocumento JOIN btycargo crg ON crg.crgcodigo=b.crgcodigo WHERE MONTH(a.prgfecha) = MONTH('$fecha')  AND a.slncodigo = '".$_POST['slncodigo']."' AND crg.crgcodigo IN (".$_POST['crgcodigo'].") ORDER BY c.trcrazonsocial");


                              if (mysqli_num_rows($sql) > 0) 
                              {
                                  
                                while ($row = mysqli_fetch_array($sql)) 
                                {
                                  echo '<tr>
                                      <td style="white-space: nowrap">
                                              '.utf8_encode($row['trcrazonsocial']).' [<b>'.$row['crgnombre'].'</b>]
                                  </td>
                                    ';

                                $a="SELECT SUBSTRING(b.trnnombre, 1, 2)AS trnnombre, DAY(a.prgfecha)AS dia, b.trnnombre AS tipoturno, a.trncodigo, c.tprcodigo, CONCAT(TIME_FORMAT(b.trndesde,'%H:%i'), ' a ', TIME_FORMAT(b.trnhasta, '%H:%i')) AS turno, b.trndesde, b.trnhasta, SUBSTRING(c.tprnombre, 1,1) AS tprnombre, c.tprnombre AS tipo, pt.ptrnombre, b.trncolor FROM btyprogramacion_colaboradores a JOIN btyturno b ON a.trncodigo=b.trncodigo JOIN btytipo_programacion c ON c.tprcodigo=a.tprcodigo JOIN btypuesto_trabajo pt ON pt.ptrcodigo=a.ptrcodigo WHERE a.slncodigo = '".$_POST['slncodigo']."' AND MONTH(a.prgfecha) = MONTH('$fecha') AND a.clbcodigo = '".$row['clbcodigo']."' ORDER BY a.prgfecha";
                                //echo $a;
                                  $queryPro = mysqli_query($conn, $a);

                                  $i=1;


                                    $dias = mysqli_query($conn, "SELECT DAY(LAST_DAY('$fecha'))");

                                        $rows = mysqli_fetch_array($dias);
                                        $dia='';
                                        $turno='';
                                        $turnoNombre='';
                                        $tipoProg='';
                                        $tipoTurno='';
                                        $tipo='';
                                        $puestoT = '';
                                        $Color = '';
                                         $turnoSubr = '';

                                        while($filas = mysqli_fetch_array($queryPro))
                                        {
                                          $turno.=$filas['trnnombre'].',';
                                          $dia.=$filas['dia'].',';
                                          $turnoNombre.=$filas['turno'].',';
                                          $tipoProg.=$filas['tprnombre'].',';
                                          $tipoTurno.=$filas['tipoturno'].',';
                                          $tipo.=$filas['tipo'].',';
                                          $puestoT.=$filas['ptrnombre'].',';
                                          $color.=$filas['trncolor'].',';
                                          $turnoSubr.=$filas['tprcodigo'].',';

                                        }

                                        $vectorDia      = explode(',',$dia);
                                        $vectorTurno    = explode(',',$turno);
                                        $vectorTurnoNom = explode(',',$turnoNombre);
                                        $vectorTipo     = explode(',',$tipoProg);
                                        $vectorTipoTurno= explode(',',$tipoTurno);
                                        $vectorTipoProg = explode(',',$tipo);
                                        $vectorPuesto   = explode(',',$puestoT);
                                        $vectorColor    = explode(',',$color);
                                        $vectorTurnoSub = explode(',',$turnoSubr);

                                        $j=0;

                                    while ($i <= $rows[0]) 
                                    {
                                            if ($i == $vectorDia[$j]) 
                                            {

                                               if ($vectorTurnoSub[$j] != 1) 
                                              {
                                                echo '
                                                    <td style="background-color: '.$vectorColor[$j].'; color: #222; white-space: nowrap" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$vectorTipoTurno[$j] . " " . $vectorTurnoNom[$j]. " " . $vectorTipoProg[$j].' - PUESTO: '.$vectorPuesto[$j].'">
                                                      <span><u>'.$vectorTurno[$j] . " ". $vectorTipo[$j].'</u></span>
                                                    </td>';                                               
                                              }
                                              else
                                              {
                                                echo '
                                                    <td style="background-color: '.$vectorColor[$j].'; color: #222; white-space: nowrap" data-toggle="tooltip" data-placement="top" data-container="body" title="'.$vectorTipoTurno[$j] . " " . $vectorTurnoNom[$j]. " " . $vectorTipoProg[$j].' - PUESTO: '.$vectorPuesto[$j].'">
                                                      <span>'.$vectorTurno[$j] . " </span> ". $vectorTipo[$j].'</span>
                                                    </td>';
                                              }
                                              $j++;
                                            }
                                            else
                                            { 
                                                $d = "SELECT a.clbcodigo, b.slnnombre FROM btyprogramacion_colaboradores a JOIN btysalon b ON b.slncodigo=a.slncodigo WHERE a.clbcodigo = '".$row['clbcodigo']."' AND MONTH(a.prgfecha) = MONTH('$fecha') AND DAY(a.prgfecha)='".$i."' AND NOT a.slncodigo='".$_GET['slncodigo']."'";

                                                        //echo $d;

                                                        $QueryProg = mysqli_query($conn, $d);
                  


                                                        if (mysqli_num_rows($QueryProg) > 0) 
                                                        {
                                                            while ($h = mysqli_fetch_array($QueryProg)) 
                                                            {
                                                                echo '<td data-toggle="tooltip" data-placement="top" data-container="body" title="'.$h['slnnombre'].'"><center><b><i class="pe-7s-less fa-2x" style="color: black"></i></b></center></td>';                                             
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo '<td></td>';
                                                        }

                                            }
                                        
                                             $i++;
                                      }
                                          
                                        echo '</tr>';
                                                                                      
                                    


                                }                             
                              
                              }
                              else
                              {
                                   echo '<tr><td colspan="32"><center><b>NO HAY REGISTROS CON ESTE FILTRO</b></center></td></tr>';
                              }


                    

                              
                             ?>
                                             
                       
                    
                     </tbody>
                </table>

   <script>
   	$(document).ready(function() {
	    $('[data-toggle="tooltip"]').tooltip();            			
		
	});
   </script>                         		


                            	
                           	
