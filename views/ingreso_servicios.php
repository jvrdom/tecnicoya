        <div class="span7">
            <form  class="form-horizontal" action="index.php?rt=servicios/insert" method="POST" id="ingresoForm" name="ingresoForm" enctype="multipart/form-data">
                <fieldset>
                   <legend>Registro de Servicios</legend>
                      <div class="control-group">
                        <label class="control-label" for="nombre">Nombre:</label>
                        <div class="controls">
                          <input  id="nombre" name="nombre" type="text" placeholder="Nombre">
                        </div>
                      </div>

                      <div class="control-group">
                        <label class="control-label" for="fecha">Fecha:</label>
                        <div class="controls">
                          <input id="fecha" name="fecha" type="text" placeholder="dd/mm/yyyy">
                        </div>
                      </div>

                      <div class="control-group">
                        <label class="control-label" for="cant_horas">Cantidad de horas:</label>
                        <div class="controls">
                          <input id="cant_horas" name="cant_horas" type="number" placeholder="10,5">
                        </div>
                      </div>

                      <div class="control-group">
                        <label class="control-label" for="precio">Precio:</label>
                        <div class="controls ">
                          <div class="input-prepend input-append">
                            <span class="add-on">$</span>
                            <input id="precio" name="precio" class="span2" type="text" placeholder="100">
                            <span class="add-on">.00</span>
                          </div>
                        </div>
                      </div>

                      <div class="control-group">
                        <label class="control-label" for="descripcion">Descripcion:</label>
                        <div class="controls">
                          <textarea rows="3" id="descripcion" name="descripcion"></textarea>
                        </div>
                      </div>

                      <div class="control-group">
                        <label class="control-label" for="foto">Foto:</label>
                        <div class="controls">
                            <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
                            <input id="fileInput" name="userfile" type="file" class="filestyle" data-classButton="btn" data-buttonText="Elige la foto..."/>
                        </div>
                      </div>

                      <div class="control-group">
                        <label class="control-label" for="prueba"> Categorías</label>
                        <div class="controls">
                            <select id="prueba" class="selectpicker span3"
                            title='Elige las categorias...' name='tecnicoSelect' >
                              <?php foreach ($filas as $key => $value) { ?>
                                    <option value="<?php echo $value['id_tipo_servicio'] ?>"><?php echo $value['nombre'] ?></option>
                              <?php } ?>
                            </select>
                        </div>
                      </div>

                      <div class="control-group">
                        <div class="controls">
                          <input id="ingresar" type="submit" name="Registrar" class="btn btn-primary" value="Ingresar Servicio"/>
                        </div>
                      </div>

                </fieldset>
            </form>
        </div>
        <div class="span5">

        </div>

      <script src="includes/public/js/bootstrap-filestyle.min.js"></script>
      <script type="text/javascript">


        $('.selectpicker').selectpicker();

        $(function () { $("input").not("[type=submit]").jqBootstrapValidation(); } );

        $('#fecha').datepicker({
          format: "dd/mm/yyyy",
          startDate: "today",
          language: "es",
          todayBtn: "linked",
          orientation: "top right",
          autoclose: true
        });

      </script>


