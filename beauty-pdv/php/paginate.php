<?php
  if ($total_paginas > 1) {
    echo '<br><center><div class="col-lg-12"><div class="pagination">';
    echo '<ul class="pagination pull-right"></ul>';
        if ($pageNum != 1) {
            echo '<li><a class="paginate" id="btn_paginar" title="Anterior"  data-id="'.($pageNum-1).'">Anterior</a></li>';
        }
            for ($i=1;$i<=$total_paginas;$i++) {
                if ($pageNum == $i) {
                    //si muestro el índice de la página actual, no coloco enlace
                    echo '<li class="active"><a id="btn_paginar">'.$i.'</a></li>';
                } else if ($pageNum > ($i + 2) or $pageNum < $i - 2) {
                    //echo '<li hiddenn><a class="paginate" onclick="paginar('.$i.');" data="'.$i.'">'.$i.'</a></li>';

                } else {
                    //si el índice no corresponde con la página mostrada actualmente,
                    //coloco el enlace para ir a esa página
                    echo '<li><a class="paginate" id="btn_paginar" data-id="'.$i.'">'.$i.'</a></li>';
                }
            }
        if ($pageNum != $total_paginas) {
            echo '<li><a class="paginate" id="btn_paginar" title="Siguiente" data-id="'.($pageNum+1).'">Siguiente</a></li>';    
        }
    echo '</ul>';
    echo '</div> </div></center> <br>';
}
$conn->close();