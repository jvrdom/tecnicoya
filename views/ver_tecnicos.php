<legend>Búsqueda de Técnicos</legend>

<div class="span12">
  <div class="row">
    <div id="divZona" class="span6">
      <button id="zona" type="button" name="direccion" class="btn" data-toogle="tooltip" onclick="busqueda()">
        <i class="icon-map-marker" rel="tooltip"></i>
      </button>
      <button id="fullScreen" type="button" class="btn btn-link" style="margin-top: 0px; visibility:
      hidden" onclick="fullScreen()"> Ver Pantalla Completa </button>
    </div>
    <div class="span6">
          <select id="prueba" class="selectpicker span3 pull-right" style="margin-top: 0px;" onchange="optionCheck()">
            <option selected="selected" disabled="disabled" value="none">Elige una opcion..</option>
            <?php foreach ($tipos as $key => $value) { ?>
                  <option value="<?php echo $value['id_tipo_servicio'] ?>"><?php echo $value['nombre'] ?></option>
            <?php } ?>
          </select>
    </div>
  </div>
  <div id="mapa" name="mapa" style="height:300px;"/>
</div>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBDun4Glg2ymc4wiMNbzPXsCAlrEYJhwRA&libraries=geometry&sensor=true"></script>
<script type="text/javascript">

        var map;
        var marker;
        var marker2;
        var geocoder;
        var infowindow;
        var option = [];
        var markers = [];
        var tecnicos = <?php echo json_encode($tecnicos); ?>;
        var categorias_tecnicos = <?php echo json_encode($categorias_tecnicos); ?>;
        var phpvalue = '<?php echo $coordenadas; ?>';


        function initialize() {

          centro = phpvalue.split(',');
          var myLatlng = new google.maps.LatLng(centro[0],centro[1]);

          var mapOptions = {
            center: myLatlng,
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            mapTypeControlOptions: {
              style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            }
          };

          map = new google.maps.Map(document.getElementById('mapa'),
              mapOptions);

          marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
          });

          var contentString = "Usted esta Aquí!"

          infowindow = new google.maps.InfoWindow({
              content: contentString

          });

          infowindow.open(map,marker);

        }

        google.maps.event.addDomListener(window, 'load', initialize);

        function optionCheck(){

            var pointA = new google.maps.LatLng(marker.getPosition().lat(), marker.getPosition().lng());   // Circle center
            var radius = 5;

            var circle = new google.maps.Circle({
               center: pointA,
               radius: radius * 1000,       // Convert to meters
               fillColor: '#FF0000',
               fillOpacity: 0.2,
               map: map
            });

            var actualTecnicos = tecnicos.map(function(obj){return obj.id_usuarios}),
              comparableTags = actualTecnicos.sort().join(" ");

            var categoriasByTecnico = categorias_tecnicos.reduce(function(map, cat) {
                if (cat.usuarios_id_usuarios in map)
                    map[cat.usuarios_id_usuarios].push(cat.tipo_servicio_id_tipo_servicio);
                else
                    map[cat.usuarios_id_usuarios] = [ cat.tipo_servicio_id_tipo_servicio ];
                return map;
            }, {});

            options = $('#prueba').val();
            for(var i=0;i<options.length;i++){
              for (var key in categoriasByTecnico) {
                if (categoriasByTecnico.hasOwnProperty(key)) {
                  var p = categoriasByTecnico[key];
                  for(key2 in p) {
                      if(p.hasOwnProperty(key2)){
                        if (options[i] == p[key2]){
                          encontraTecnico(key, pointA, radius);
                        }
                      }
                  }
                }
              }
            }
        }

        function encontraTecnico(id_usuarios, centro, radius) {

          //clearMarkers();

          for(var i=0;i<tecnicos.length;i++){
                var obj = tecnicos[i];
                if(obj['id_usuarios'] == id_usuarios) {
                  var valor = obj['latlong'];
                  res = valor.replace('(', " ").replace(')', " ");
                  var point = res.split(',');
                  var myLatLng2 = new google.maps.LatLng(point[0], point[1]);
                  var distanceInMetres = google.maps.geometry.spherical.computeDistanceBetween(centro, myLatLng2);
                  if(distanceInMetres < radius * 1000){
                    var marker2 = new google.maps.Marker({
                      position: myLatLng2,
                      map: map,
                    });

                    var id = obj['id_usuarios'];

                    var contentString =
                    "<a href='http://localhost:8080/tecnicoya/index.php?rt=usuario/viewUsuario/"+ id +"'>" + obj['email'] +"</a>'";

                    infowindow = new google.maps.InfoWindow({
                        content: contentString
                    });

                    infowindow.open(map, marker2);

                    markers.push(marker2);
                  } else {
                    /*var marker2 = new google.maps.Marker({
                        position: myLatLng2,
                        map: map,
                      });
                    }*/
                    }
                }
          }
        }

        function busqueda(){

          clearMarkers();

          var pointA = new google.maps.LatLng(marker.getPosition().lat(), marker.getPosition().lng());   // Circle center
          var radius = 5;

          var circle = new google.maps.Circle({
             center: pointA,
             radius: radius * 1000,       // Convert to meters
             fillColor: '#FF0000',
             fillOpacity: 0.2,
             map: map
          });

          for(var i=0;i<tecnicos.length;i++){
                var obj = tecnicos[i];
                for(var key in obj){
                    var attrName = key;
                    var attrValue = obj[key];
                    if (attrName == 'latlong') {
                      res = attrValue.replace('(', " ").replace(')', " ");
                      var point = res.split(',');
                      var myLatLng2 = new google.maps.LatLng(point[0], point[1]);
                      var distanceInMetres = google.maps.geometry.spherical.computeDistanceBetween(pointA, myLatLng2);
                      if(distanceInMetres < radius * 1000){
                        var marker2 = new google.maps.Marker({
                          position: myLatLng2,
                          map: map,
                        });

                        var id = obj['id_usuarios'];

                        var contentString =
                        "<a href='http://localhost:8080/tecnicoya/index.php?rt=usuario/viewUsuario/"+ id +"'>" + obj['email'] +"</a>'";

                        infowindow = new google.maps.InfoWindow({
                            content: contentString
                        });

                        infowindow.open(map, marker2);
                        markers.push(marker2);
                        //bindInfoWindow(marker2, map, infowindow);
                      }

                    }
                }
            }
          document.getElementById('fullScreen').style.visibility="visible";
        }

        function bindInfoWindow(marker, map, infowindow) {
            google.maps.event.addListener(marker, 'click', function() {
                //infowindow.setContent(strDescription);
                infowindow.open(map, marker);
            });
        }

        function fullScreen() {
            var style = document.getElementById('mapa').style;
            style.width = '100%';
            style.height = '100%';
            style.position = 'absolute';
            style.top = '0';
            style.left = '0';
            style.right = '0';
            style.bottom = '0';
            style.overflow = 'hidden';
            google.maps.event.trigger(map, 'resize');
            map.setCenter (new google.maps.LatLng(-34.832405,-56.16359));
            map.setZoom(11);
        }

        function setAllMap(map) {
          for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
          }
        }

        function clearMarkers() {
          setAllMap(null);
        }

        $('#zona').tooltip({
            'show': true,
            'placement': 'bottom',
            'title': "Haz click aquí para encontrar los técnicos de tu zona"
        });

        $('#zona').tooltip('show');

        $('.selectpicker').selectpicker();

</script>

