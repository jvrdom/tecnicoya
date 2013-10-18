    <!--<h1><?php echo $welcome; ?></h1>-->
      <form  class="form-horizontal pull-right" action="index.php?rt=index/login" enctype="multipart/form-data" method="POST" id="ingresoForm" name="ingresoForm">
          <fieldset>
             <legend>Inicio de Sesión</legend>
                <div class="control-group">
                  <label class="control-label" for="usuario">Usuario:</label>
                  <div class="controls">
                    <input id="usuario" name="usuario" type="text" placeholder="usuario@mail.com">
                  </div>
                </div>

                <div class="control-group">
                  <label class="control-label" for="password">Password:</label>
                  <div class="controls">
                    <input id="password" name="password" type="password" placeholder="password">
                  </div>
                </div>

                <div class="control-group pull-right">
                  <div class="controls">
                    <input id="ingresar" type="submit" name="Registrar" class="btn" value="Iniciar Sesion"/>
                  </div>
                </div>
          </fieldset>
      </form>

