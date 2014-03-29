<div class="span12" id="tabla">
  <table id="servicios" class="table table-striped tablesorter">
      <thead>
        <th>Id</th>
        <th>Nombre</th>
        <th>Fecha</th>
        <th>Descripción</th>
        <th>Categoría</th>
        <th>Usuario</th>
        <th> </th>
        <th>Precio</th>
      </thead>
     <tbody>
      <?php
         foreach ($servicios as $key => $value){
             echo "<tr>";
             echo "<td>".$value['id_servicios']."</td>";
             echo "<td>".$value['nombre']."</td>";
             echo "<td>".$value['fecha']."</td>";
             echo "<td>". substr($value['descripcion'],0,20).'...'."</td>";
             echo "<td>".$value['categoria']."</td>";
             echo "<td> <a href='index.php?rt=usuario/viewUsuario/".$value['id_usuarios']."' > ".$value['usuario']. "</a> </td>";
             echo "<td> <a href='index.php?rt=servicios/update/".$value['id_servicios']."' > Ver Más... </a> </td>";
             echo "<td>".$value['precio']."</td>";
             echo "</tr>";
         }

      ?>
      </tbody>

      <tfoot>
        <tr>
            <th style="text-align: right" colspan="7">Total:</th>
            <th style="width: 14%;">&nbsp;</th>
        </tr>
      </tfoot>

    </table>
</div>

<script type="text/javascript">

  var otable;

  $(document).ready(function() {


    otable = $('#servicios').dataTable( {
      "aaSorting": [[ 2, "asc" ]],

      "aoColumnDefs": [
      { "bVisible": false, "aTargets": [ 0 ] } ],

      "oLanguage": {
        "sLengthMenu": "Mostrar _MENU_ entradas por pagina",
        "sInfo": "_TOTAL_ entradas para mostrar (_START_ a _END_)",
        "sInfoEmpty": "0 entradas",
        "sSearch": "Buscar:",
        "sZeroRecords": "No hay registros para esa busqueda",
      },

      "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
            /*
             * Calculate the total market share for all browsers in this table (ie inc. outside
             * the pagination)
             */
            var iTotalMarket = 0;
            for ( var i=0 ; i<aaData.length ; i++ )
            {

                iTotalMarket += aaData[i][7]*1;
            }

            /* Calculate the market share for browsers on this page */
            var iPageMarket = 0;
            for ( var i=iStart ; i<iEnd ; i++ )
            {
                iPageMarket += aaData[ aiDisplay[i] ][7]*1;
            }

            /* Modify the footer row to match what we want */
            var nCells = nRow.getElementsByTagName('th');
            nCells[1].innerHTML = parseInt(iPageMarket) + " ("+ parseInt(iTotalMarket) +" total)"
        }

    });

  } );
</script>
