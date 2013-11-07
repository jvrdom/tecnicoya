<div class="span6 offset3">
  <form  class="form-horizontal" action="index.php?rt=index/login" method="POST" id="ingresoForm" name="ingresoForm">
      <fieldset>
         <legend>Inicio de Sesión</legend>
         <?php if ($_SESSION["error"] == 'true') {?>
            <div class="alert alert-error"> <?php echo $mensaje; ?></div>
         <?php } ?>
            <div class="control-group">
              <label class="control-label" for="usuario">Usuario:</label>
              <div class="controls">
                <input id="usuario" name="usuario" type="email" placeholder="usuario@mail.com"
                data-validation-email-message="Dirección de mail no válida."
                data-validation-required-message="Por favor, ingrese su usuario">
                <p class="help-block"></p>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="password">Password:</label>
              <div class="controls">
                <input id="password" name="password" type="password" placeholder="password"
                data-validation-required-message="Por favor, ingrese su contraseña">
              </div>
            </div>

            <div class="control-group center">
              <div class="controls">
                <input id="ingresar" type="submit" name="Registrar" class="btn" value="Iniciar Sesion"/>
              </div>
            </div>
      </fieldset>
  </form>
</div>

<script type="text/javascript">
  $(function () { $("input").not("[type=submit]").jqBootstrapValidation(); } );

</script>
