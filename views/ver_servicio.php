<?php if($mensaje != '') {?>
  <div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo $mensaje; ?>
  </div>
<?php } ?>
<div class="span7">
<?php if ($_SESSION['tipo'] == '3') { ?>
<form  class="form-horizontal"
  action="index.php?rt=servicios/update/<?php echo ($_SESSION['id_servicio']); ?>"
  method="POST" id="perfilForm" name="perfilForm">
    <fieldset>
       <legend>Características del servicio</legend>
          <div class="control-group">
            <label class="control-label" for="nombre">Nombre:</label>
            <div class="controls">
              <input  id="nombre" name="nombre" type="text" value="<?php echo ($servicio['0']['nombre']); ?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="fecha">Fecha:</label>
            <div class="controls">
              <input id="fecha" name="fecha" type="text" value="<?php echo ($servicio['0']['fecha']); ?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="cant_horas">Cantidad de Horas:</label>
            <div class="controls">
              <input id="cant_horas" name="cant_horas" type="text" value="<?php echo ($servicio['0']['cant_horas']); ?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="celular">Precio:</label>
            <div class="controls">
              <input id="precio" name="precio" type="text" value="<?php echo ($servicio['0']['precio']); ?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="descripcion">Descripcion:</label>
            <div class="controls">
              <textarea  rows="3" id="descripcion" name="descripcion">
                <?php echo ($servicio['0']['descripcion']); ?>
              </textarea>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="calificacion">Calificacion:</label>
            <div class="controls">
               <div class="calificacion" data-average= "<?php echo $puntuacion; ?>" data-id="1"></div>
            </div>
          </div>

          <div class="control-group">
            <div class="controls">
              <label class="checkbox inline" style="padding-left: 1px;">
                <input id="ingresar" type="submit" name="Editar" class="btn" value="Editar"/>
              </label>
            </div>
          </div>

    </fieldset>
</form>

<?php } else { ?>
<form  class="form-horizontal"
  action="index.php?rt=servicios/contratarServicio"
  method="POST" id="usuarioForm" name="usuarioForm">
    <fieldset>
       <legend>Características del servicio</legend>
          <div class="control-group">
            <label class="control-label" for="nombre">Nombre:</label>
            <div class="controls">
              <label class="control-label" name="nombre" style="text-align: left;"> <strong><?php echo ($servicio['0']['nombre']); ?></strong></label>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="fecha">Fecha:</label>
            <div class="controls">
              <label class="control-label" name="fecha" style="text-align: left;"><strong><?php echo ($servicio['0']['fecha']); ?></strong></label>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="cant_horas">Cantidad de Horas:</label>
            <div class="controls">
              <label class="control-label" name="cant_horas"  style="text-align: left;"><strong><?php echo ($servicio['0']['cant_horas']); ?></strong></label>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="celular">Precio:</label>
            <div class="controls">
              <label class="control-label" name="precio"  style="text-align: left;"><strong><?php echo ($servicio['0']['precio']); ?></strong></label>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="descripcion">Descripcion:</label>
            <div class="controls">
              <label class="control-label" name="descripcion"  style="text-align: left;"><strong><?php echo ($servicio['0']['descripcion']); ?></strong></label>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="calificacion">Calificacion:</label>
            <div class="controls">
               <div class="calificacion" data-average= "<?php echo $puntuacion; ?>" data-id="1"></div>
            </div>
          </div>

          <div class="control-group">
            <div class="controls">
                <?php if ($_SESSION['tipo'] == '1') { ?>
                  <input id="ingresar" type="submit" name="Contratar" class="btn btn-primary" value="Contratar Servicio"/>
                <?php } ?>
                <?php if ($_SESSION['tipo'] == '2') { ?>
                  <input id="eliminar" type="submit" name="Eliminar" class="btn btn-danger" value="Eliminar Servicio" data-toggle="modal" data-target="#modalEliminar"/>
                <?php } ?>
            </div>
          </div>

    </fieldset>
</form>

<?php } ?>
</div>

<div class="span5">
  <ul class="thumbnails" style="margin-top: 26%; margin-left: -20%;">
    <li class="span4">
      <a href="#modal" class="thumbnail" data-toggle="modal">
        <img src="<?php echo $imagenurl ?>" alt="">
      </a>
    </li>
  </ul>
</div>

<?php if ($_SESSION['tipo'] == '2') { ?>
  <div id="modalEliminar" class="modal fade" >
    <div class="modal-header">
      <strong>Eliminar Servicio</strong>
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
    <div class="modal-body">
      <form  class="form-horizontal"action="index.php?rt=servicios/delete"method="POST" id="usuarioForm" name="usuarioForm">
        <fieldset id="confirmacionFieldset">
           Esta seguro de eliminar el servicio?
           <input type="hidden" name="servicio" value="<?php echo ($_SESSION['id_servicio']); ?>"/>
           <div class="control-group">
              <div id="confirmacion" class="controls">
                    <input id="aceptar" type="submit" name="aceptar" class="btn btn-danger" value="Si"/>
                    <input id="cancelar" type="button" name="cancelar" class="btn btn-danger" value="No" data-dismiss="modal"/>
              </div>
            </div>
        </fieldset>
      </form>
    </div>
  </div>
<?php } ?>

<script src="includes/public/js/bootstrap-filestyle.min.js"></script>
<script type="text/javascript">


$(document).ready(function(){

  var sessionValue = "<?php echo $_SESSION['tipo']?>";

  $('#fecha').datepicker({
    format: "dd/mm/yyyy",
    startDate: "today",
    language: "es",
    todayBtn: "linked",
    orientation: "top right",
    autoclose: true
  });

  if(sessionValue == '3'){
    $(".calificacion").jRating({
      step: true,
      sendRequest : false,
      decimalLength: 1,
      rateMax: 5,
      isDisabled : true
    });
  } else {
    $(".calificacion").jRating({
      showRateInfo: false,
      step: true,
      sendRequest : false,
      decimalLength: 1,
      rateMax: 5,
      onClick : function(element,rate){
        $.ajax({
              url: "index.php?rt=servicios/calificar/",
              type: "POST",
              data: {rate: rate, id: '<?php echo ($servicio['0']['id_servicios']); ?>' }
        });
        jSuccess('Exito : Su calificacion ha sido guardada :)',{
          HorizontalPosition:'center',
          VerticalPosition:'top'
        });
      }
    });
  }

});
</script>
