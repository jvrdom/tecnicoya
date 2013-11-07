<div class="span7">
<form  class="form-horizontal" action="index.php?rt=usuario/update" method="POST" id="perfilForm" name="perfilForm">
    <fieldset>
       <legend>Perfil de Usuario</legend>
          <div class="control-group">
            <label class="control-label" for="usuario">Usuario:</label>
            <div class="controls">
              <input id="usuario" name="usuario" type="text" value="<?php echo ($usuario['0']['email']); ?>" >
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="nombre">Nombre:</label>
            <div class="controls">
              <input id="nombre" name="nombre" type="text" placeholder="nombre" value="<?php echo ($usuario['0']['nombre']); ?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="apellido">Apellido:</label>
            <div class="controls">
              <input id="apellido" name="apellido" type="text" placeholder="apellido" value="<?php echo ($usuario['0']['apellido']); ?>">
               <input id="coord" type="hidden" name="coord" value="">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="celular">Celular:</label>
            <div class="controls">
              <input id="celular" name="celular" type="text" placeholder="celular" value="<?php echo ($usuario['0']['celular']); ?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="address">Direccion:</label>
            <div class="controls">
              <div class="input-append">
                <input id="address" type="text" name="address" placeholder="dirección" class="span3" value="<?php echo $localidad; ?>">
                <input id="coord" type="hidden" name="coord" value="">
                <button id="Geocode" type="button" name="direccion" class="btn" onclick="codeAddress()">
                  <i class="icon-map-marker"></i>
                </button>
              </div>
            </div>
          </div>


          <div class="control-group">
            <div class="controls">
              <label class="checkbox inline">
                <input id="ingresar" type="submit" name="Editar" class="btn pull" value="Editar"/>
              </label>
            </div>
          </div>

    </fieldset>
</form>
</div>

<div class="span5">
  <div id="mapa" name="mapa" style="height:250px; width:200; margin-top: 26%; margin-left: -20%"></div>
</div>


<div id="static" class="modal hide fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-body">
    <p>Esta seguro de darse de baja?</p>
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn">Cancelar</button>
    <button name="eliminar" type="button" data-dismiss="modal" class="btn btn-primary" href="index.php?rt=usuario/delete">Confirmar</button>
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

      </script>


