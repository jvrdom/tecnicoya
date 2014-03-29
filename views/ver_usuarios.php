<div class="span12" id="tabla">
  <table id="servicios" class="table table-striped tablesorter">
      <thead>
        <th>Id</th>
        <th>Email</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Celular</th>
        <th>Tipo de Usuario</th>
        <th> </th>
      </thead>

      <?php
         foreach ($usuarios as $key => $value){
             echo "<tr>";
             echo "<td>".$value['id_usuarios']."</td>";
             echo "<td>".$value['email']."</td>";
             echo "<td>".$value['nombre']."</td>";
             echo "<td>".$value['apellido']."</td>";
             echo "<td>".$value['celular']."</td>";
             if ($value['id_tipo_usuario'] == '1') {
              echo "<td> Cliente </td>";
             } elseif($value['id_tipo_usuario'] == '2') {
              echo "<td> Administrador </td>";
             } else {
              echo "<td> Técnico </td>";
             }
             echo "<td> <a href='index.php?rt=usuario/viewUsuario/".$value['id_usuarios']."' > Ver Más... </a> </td>";
             echo "</tr>";
         }

      ?>
    </table>
</div>

<script type="text/javascript">

  var otable;

  $(document).ready(function() {


    otable = $('#servicios').dataTable( {
      "aaSorting": [[ 0, "asc" ]],

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
