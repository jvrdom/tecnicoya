        <div class="span7">
            <form  class="form-horizontal" action="index.php?rt=usuario/insert" enctype="multipart/form-data" method="POST" id="ingresoForm" name="ingresoForm">
                <fieldset>
                   <legend>Registro de Usuario</legend>
                      <div class="control-group">
                        <label class="control-label" for="usuario">Usuario:</label>
                        <div class="controls">
                          <input id="usuario" name="usuario" type="text" placeholder="usuario@mail.com">
                        </div>
                      </div>

                      <div class="control-group">
                        <label class="control-label" for="password">Password:</label>
                        <div class="controls">
                          <input id="pass" name="password" type="password" placeholder="password">
                        </div>
                      </div>

                      <div class="control-group">
                        <label class="control-label" for="nombre">Nombre:</label>
                        <div class="controls">
                          <input id="nombre" name="nombre" type="text" placeholder="nombre">
                        </div>
                      </div>

                      <div class="control-group">
                        <label class="control-label" for="apellido">Apellido:</label>
                        <div class="controls">
                          <input id="apellido" name="apellido" type="text" placeholder="apellido">
                        </div>
                      </div>

                      <div class="control-group">
                        <label class="control-label" for="celular">Celular:</label>
                        <div class="controls">
                          <input id="celular" name="celular" type="text" placeholder="celular">
                        </div>
                      </div>

                      <div class="control-group">
                        <label class="control-label" for="direccion">Direccion:</label>
                        <div class="controls">
                          <div class="input-append">
                            <input id="address" type="text" name="address" placeholder="dirección" class="span3">
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
                            <input type="checkbox" name="tecnicoCheckbox" id="tecnicoCheckbox" value="tecnicoCheckbox"> Técnico
                          </label>
                          <input id="ingresar" type="submit" name="Registrar" class="btn" value="Enviar formulario"/>
                        </div>
                      </div>

                </fieldset>
            </form>
        </div>
        <div class="span5">
          <div id="mapa" name="mapa" style="height:250px; width:200; margin-top: 26%; margin-left: -20%"></div>
        </div>


      <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBDun4Glg2ymc4wiMNbzPXsCAlrEYJhwRA&sensor=true"></script>
      <script type="text/javascript">

        var map;
        var marker;
        var markerNew;
        var geocoder;

        function initialize() {
          geocoder = new google.maps.Geocoder();
          var mapOptions = {
            center: new google.maps.LatLng(-34.904375,-56.166414),
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            mapTypeControlOptions: {
              style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            }
          };

          map = new google.maps.Map(document.getElementById('mapa'),
              mapOptions);

          /*google.maps.event.addListener(map, 'click', function(event) {
            addMarker(event.latLng);
          });*/
        }

        function addMarker(location) {
          if (marker){
            marker.setPosition(location);
          } else {
              marker = new google.maps.Marker({
              position: location,
              map: map
            });
          }
          markerNew = marker.getPosition();
          document.getElementById('coord').value = markerNew;
        }

        function codeAddress(){
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


