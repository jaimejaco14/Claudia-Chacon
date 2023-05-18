<?php
//******************************************************
//CAMPOS TABLA btymeta_salon_cargo**********************
//******************************************************
//mtames=mes
//slncodigo=codigo salon
//crgcodigo=codigo cargo
//******************************************************
//mtatipo=porcentaje o valor definido
//mtapuntoreferencia=1 o 0
//mtavalor=valor o porcentaje asignado
//******************************************************
include '../cnx_data.php';
    if( ($_POST['filtromes'] > 0 ) or ($_POST['filtrosln'] > 0) or ($_POST['filtrocrg'] > 0))
    {

        $cont=0;
        $f1="";
        $f2="";
        $f3="";
        $mes=$_POST['filtromes'];
        $sln=$_POST['filtrosln'];
        $crg=$_POST['filtrocrg'];
        if($mes>0){
            $f1=" sc.mtames=".$mes;
            $cont++;
        }
        if($sln>0){
            if($cont>0){
                $f2=" AND sc.slncodigo=".$sln;
            }else{
                $f2="sc.slncodigo=".$sln;
            }
            $cont++;
        }
        if($crg>0){
            if($cont>0){
                $f3=" AND sc.crgcodigo=".$crg;
            }else{
                $f3="sc.crgcodigo=".$crg;
            }
            $cont++;
        }
        $filtro=$f1.$f2.$f3;

        $sql = "SELECT sc.mtames,sc.slncodigo,sln.slnnombre,sc.crgcodigo,cg.crgnombre ,sc.mtatipo,sc.mtapuntoreferencia,sc.mtavalor from btymeta_salon_cargo as sc natural join btysalon as sln natural join btycargo as cg WHERE $filtro ORDER BY sc.mtames asc, sln.slnnombre ASC, cg.crgnombre asc";

    } 
    else 
    {
        $sql = "SELECT sc.mtames,sc.slncodigo,sln.slnnombre,sc.crgcodigo,cg.crgnombre ,sc.mtatipo,sc.mtapuntoreferencia,sc.mtavalor from btymeta_salon_cargo as sc natural join btysalon as sln natural join btycargo as cg ORDER BY sc.mtames asc, sln.slnnombre ASC, cg.crgnombre asc";
    }


?>
<div class="animate-panel">
    <div class="hpanel">
        <div class="panel-heading">
            <h3 class="panel-title">Meta por salón y cargos</h3>
        </div>
        <div class="panel-body">
            <div class="table-responsive"> 
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <th>Mes</th>
                        <th>Salón</th>
                        <th>Cargo</th>  
                        <th>Tipo meta</th> 
                        <th>Valor</th>      
                        <th class="text-center">Referencia</th>
                        <th>Acciones</th>                
                    </thead>
                    <tbody>
                    <?php
                        
                        //include 'conexion.php';
                        $query_num_col = $sql;

                        $result = $conn->query($query_num_col);
                        $num_total_registros = $result->num_rows;

                        $rowsPerPage = 6;
                         $pageNum = 1;

                        if(isset($_POST['page'])) 
                        {
                            $pageNum = $_POST['page'];
                        }
                        $offset = ($pageNum - 1) * $rowsPerPage;
                        $total_paginas = ceil($num_total_registros / $rowsPerPage);

                        $sql = $sql." limit $offset, $rowsPerPage";
                        if ($result = $conn->query($sql)) 
                        {

                        } 
                        else 
                        {
                            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                        }

                        if ($result->num_rows > 0) 
                        {
                            while ($row = $result->fetch_assoc()) 
                            {  
                                switch($row['mtames']){
                                    case 1:
                                    $mes="ENERO";
                                    break;
                                    case 2:
                                    $mes="FEBRERO";
                                    break;
                                    case 3:
                                    $mes="MARZO";
                                    break;
                                    case 4:
                                    $mes="ABRIL";
                                    break;
                                    case 5:
                                    $mes="MAYO";
                                    break;
                                    case 6:
                                    $mes="JUNIO";
                                    break;
                                    case 7:
                                    $mes="JULIO";
                                    break;
                                    case 8:
                                    $mes="AGOSTO";
                                    break;
                                    case 9:
                                    $mes="SEPTIEMBRE";
                                    break;
                                    case 10:
                                    $mes="OCTUBRE";
                                    break;
                                    case 11:
                                    $mes="NOVIEMBRE";
                                    break;
                                    case 12:
                                    $mes="DICIEMBRE";
                                    break;
                                }

                                ?>    
                                <tr>
                                    <td> <?php echo $mes;?> </td>
                                    <td><?php echo $row['slnnombre']?></td>
                                    <td><?php echo $row['crgnombre']?></td>
                                    <td><?php echo $row['mtatipo']?></td>
                                    <td><?php echo number_format($row['mtavalor'], 0, '.', ',');?></td>
                                    <td class="text-center">
                                    <?php 
                                    if($row['mtapuntoreferencia']==1){
                                        echo "<input type='checkbox' checked disabled>";
                                    }else{
                                        echo "<input type='checkbox' disabled>";
                                    }
                                    ?>    
                                    </td>
                                    <td>
                                        <button class="btn btn-default" title="Editar meta" onclick="editar('<?php echo $row['mtames']?>','<?php echo $row['slncodigo']?>','<?php echo $row['crgcodigo']?>')"><i class="pe-7s-note text-info"></i> </button> 
                                        <button class="btn btn-default" title="Eliminar meta" onclick="eliminar('<?php echo $row['mtames']?>','<?php echo $row['slncodigo']?>','<?php echo $row['crgcodigo']?>')"><i class="pe-7s-trash text-info"></i></button>
                                    </td>
                                </tr>
                                    <?php                             
                                $con++;
                            }
                        }
                           
                            $conn->close();
                    ?>
                    </tbody>                        
                </table>
                <?php include "paginate.php"; ?>

            </div>
        </div>
    </div>
</div>
