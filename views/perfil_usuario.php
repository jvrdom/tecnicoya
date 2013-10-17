              <form  class="form-horizontal" action="index.php?rt=usuario/get" enctype="multipart/form-data" id="perfilForm" name="perfilForm">
                  <fieldset>
                     <legend>Perfil de Usuario</legend>
                        <div class="control-group">
                          <label class="control-label" for="usuario">Usuario:</label>
                          <div class="controls">
                            <input id="usuario" name="usuario" type="text" value="<?php echo ($usuario['0']['email']); ?>" >
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
                            <input id="nombre" name="nombre" type="text" placeholder="nombre" value="<?php echo ($usuario['0']['nombre']); ?>">
                          </div>
                        </div>

                        <div class="control-group">
                          <label class="control-label" for="apellido">Apellido:</label>
                          <div class="controls">
                            <input id="apellido" name="apellido" type="text" placeholder="apellido" value="<?php echo ($usuario['0']['apellido']); ?>">
                          </div>
                        </div>

                        <div class="control-group">
                          <label class="control-label" for="celular">Celular:</label>
                          <div class="controls">
                            <input id="celular" name="celular" type="text" placeholder="celular" value="<?php echo ($usuario['0']['celular']); ?>">
                          </div>
                        </div>

                        <div class="control-group">
                          <div class="controls">
                            <label class="checkbox inline">
                              <input id="ingresar" type="submit" name="Registrar" class="btn" value="Editar"/>
                            </label>
                            <button type="button" class="btn btn-link" style="margin-top: 0px;">
                              <a href="index.php?rt=usuario/delete">Darse de Baja</a></button>
                          </div>
                        </div>

                        <div class="control-group inline">
                          <div class="controls">
                            <div id="mapa" name="mapa" style="height:100px; width:200;"></div>
                            <input id="coord" type="hidden" name="coord" value="">
                          </div>
                        </div>
                  </fieldset>
              </form>


      <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBDun4Glg2ymc4wiMNbzPXsCAlrEYJhwRA&sensor=true"></script>

      <script type="text/javascript">

      </script>


