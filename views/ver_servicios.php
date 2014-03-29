<div class="span12" id="tabla">
  <table id="servicios" class="table table-striped tablesorter">
      <thead>
        <th>Id</th>
        <th>Nombre</th>
        <th>Fecha</th>
        <th>Precio</th>
        <th>Descripción</th>
        <th>Categoría</th>
        <th>Técnico</th>
        <th> </th>
      </thead>

      <?php
         foreach ($servicios as $key => $value){
             echo "<tr>";
             echo "<td>".$value['id_servicios']."</td>";
             echo "<td>".$value['nombre']."</td>";
             echo "<td>".$value['fecha']."</td>";
             echo "<td>".$value['precio']."</td>";
             echo "<td>". substr($value['descripcion'],0,20).'...'."</td>";
             echo "<td>".$value['categoria']."</td>";
             echo "<td>".$value['tecnico']."</td>";
             echo "<td> <a href='index.php?rt=servicios/update/".$value['id_servicios']."' > Ver Más... </a> </td>";
             echo "</tr>";
         }

      ?>
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
      }

    });

  } );
</script>
