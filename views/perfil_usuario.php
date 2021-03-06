<div class="span7">
<form  class="form-horizontal" action="index.php?rt=usuario/update" method="POST" id="perfilForm" name="perfilForm">
    <fieldset>
       <legend>Perfil de Usuario</legend>
          <div class="control-group">
            <label class="control-label" for="usuario">Usuario:</label>
            <div class="controls">
              <input  id="usuario" name="usuario" type="email" value="<?php echo ($usuario['0']['email']); ?>">
              <p class="help-block"></p>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="nombre">Nombre:</label>
            <div class="controls">
              <input id="nombre" name="nombre" type="text" value="<?php echo ($usuario['0']['nombre']); ?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="apellido">Apellido:</label>
            <div class="controls">
              <input id="apellido" name="apellido" type="text" value="<?php echo ($usuario['0']['apellido']); ?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="celular">Celular:</label>
            <div class="controls">
              <input id="celular" name="celular" type="text" value="<?php echo ($usuario['0']['celular']); ?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="address">Direccion:</label>
            <div class="controls">
              <div class="input-append">
                <input id="address" type="text" name="address" class="span3" value="<?php echo $localidad; ?>">
                <input id="coord" type="hidden" name="coord" value="">
                <button id="Geocode" type="button" name="direccion" class="btn btn-success" onclick="codeAddress()">
                  <i class="icon-map-marker"></i>
                </button>
              </div>
            </div>
          </div>

          <?php if ($_SESSION['tipo'] == '3') { ?>
          <div class="control-group">
            <label class="control-label" for="especialidades">Especialidades:</label>
            <div class="controls">
              <input id="especialidades" name="especialidades" type="text" class="tm-input" placeholder="Agregar más categorias...">
            </div>
          </div>
          <?php  } ?>

          <?php if ($usuario['0']['id_tipo_usuario'] == '1') { ?>
          <div class="control-group">
            <label class="control-label" for="calificacion">Calificacion:</label>
            <div class="controls">
               <div class="calificacion" data-average= "<?php echo $puntuacion; ?>" data-id="1"></div>
            </div>
          </div>
          <?php  } ?>

          <div class="control-group">
            <div class="controls">
              <label class="checkbox inline">
                <input id="ingresar" type="submit" name="Editar" class="btn btn-primary" value="Editar"/>
                <?php if ($_SESSION['tipo'] == '3') { ?>
                  <button type="button" class="btn" style="margin-top: 0px;" data-toggle="modal" href="#static">
                    <i class="icon-search"></i> Ver Servicios
                  </button>
                <?php  } else if ($_SESSION['tipo'] == '1') {?>
                  <button type="button" class="btn" style="margin-top: 0px;" data-toggle="modal" href="#static">
                    <i class="icon-search"></i> Ver Servicios
                  </button>
                <?php } ?>
              </label>
            </div>
          </div>

    </fieldset>
</form>
</div>

<div class="span5">
  <div id="mapa" name="mapa" style="height:250px; width:200; margin-top: 26%; margin-left: -20%"></div>
</div>

<div id="static" class="modal container hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4>Servicios</h4>
  </div>
  <div class="modal-body">
    <table id="servicios" class="table table-striped tablesorter">
      <thead>
        <th class="{sorter: false}">Id</th>
        <th>Nombre</th>
        <th>Fecha</th>
        <th>Precio</th>
        <th>Descripción</th>
        <th> </th>
      </thead>

      <?php
         foreach ($servicios as $key => $value){
             echo "<tr>";
             echo "<td>".$value['id_servicios']."</td>";
             echo "<td>".$value['nombre']."</td>";
             echo "<td>".$value['fecha']."</td>";
             echo "<td>".$value['precio']."</td>";
             echo "<td>".$value['descripcion']."</td>";
             echo "<td> <a href='index.php?rt=servicios/update/".$value['id_servicios']."' > Ver Más... </a> </td>";
             echo "</tr>";
         }

      ?>
    </table>
  </div>
</div>

      <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBDun4Glg2ymc4wiMNbzPXsCAlrEYJhwRA&sensor=true"></script>

      <script type="text/javascript">

        var map;
        var marker;
        var position;
        var coord;
        var geocoder;
        var phpvalue = '<?php echo $coordenadas; ?>';
        var markers = [];

        function initialize() {
          var bounds = new google.maps.LatLngBounds();
          geocoder = new google.maps.Geocoder();
          coord = phpvalue.split(',');
          position = new google.maps.LatLng(coord[0],coord[1]);

          var mapOptions = {
            center: new google.maps.LatLng(-34.904375,-56.166414),
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            mapTypeControlOptions: {
              style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            }
          };

          map = new google.maps.Map(document.getElementById('mapa'),
              mapOptions);

          marker = new google.maps.Marker({
            position: position,
            map: map,
            draggable: true
          });

          markers.push(marker);

          map.setCenter(marker.getPosition());

          document.getElementById('coord').value = marker.getPosition();

/*          if(marker.getDraggable() == true) {
            google.maps.event.addListener(
                marker,
                'drag',
                function() {
                    document.getElementById('coord').value = marker.getPosition();
                }
            );
          } else {
            document.getElementById('coord').value = marke.getPosition();
          }*/

        }

        function setAllMap(map) {
          for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
          }
        }

        function clearMarkers() {
          setAllMap(null);
        }

        function codeAddress(){

          clearMarkers();

          var address = document.getElementById('address').value;
          var bounds = new google.maps.LatLngBounds();
          geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              map.setCenter(results[0].geometry.location);
              var latLng = results[0].geometry.location;
              var marker = new google.maps.Marker({
                  map: map,
                  animation: google.maps.Animation.DROP,
                  draggable: true,
                  position: results[0].geometry.location,
              });

              bounds.extend(latLng);
              map.fitBounds(bounds);
              var zoom = map.getZoom();
              map.setZoom(zoom > 15 ? 15 : zoom);

              google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
              });

              if(marker.getDraggable() == true) {
                google.maps.event.addListener(
                    marker,
                    'drag',
                    function() {
                        document.getElementById('coord').value = marker.getPosition();
                    }
                );
              }
              document.getElementById('coord').value = marker.getPosition();


            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }
          });
        }

        google.maps.event.addDomListener(window, 'load', initialize);

        var prueba = jQuery(".tm-input").tagsManager({
          prefilled: <?php echo json_encode($categorias); ?>
        });

        var otable;

        $(document).ready(function() {

          $(".calificacion").jRating({
            showRateInfo: false,
            step: true,
            sendRequest : false,
            decimalLength: 1,
            rateMax: 5,
            isDisabled: true,
          });

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


