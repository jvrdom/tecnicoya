<?php

Class usuarioController Extends baseController {

public function index()
{
        if($_SESSION['tipo'] == $this->registry->admin){
          $this->registry->template->blog_heading = 'This is the admin Index';
        } elseif ($_SESSION['tipo'] == $this->registry->tecnico) {
          $this->registry->template->blog_heading = 'This is the técnico Index';
        } else {
          $this->registry->template->blog_heading = 'This is the usuario Index';
        }

        $this->registry->template->show('usuario_index');
}

public function insert(){
  /**
   * Metodo de ingreso de usuarios
   */
  $this->registry->template->usuario_heading = 'This is the usuario heading';
  $results = $this->registry->db->get('tipo_servicio');
  $this->registry->template->filas = $results;
  $this->registry->template->show('ingreso_usuarios');

  if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $new_user_direccion = array(
      'direccion' => $_POST['address'],
      'latlong' => $_POST['coord']
    );

    $this->registry->db->insert('localidad', $new_user_direccion);
    //Obtengo el ultimo id ingresado.
    $id_localidad = $this->registry->db->getInsertId();

    //$password = $this->registry->utiles->blowfish_crypt($_POST['password']);
    $password = md5($_POST['password']);

    //Pregunto por si es tecnico o usuario.
    if(isset($_POST['tecnicoCheckbox'])){

      $tipo_usuario = $this->registry->tecnico;

      $new_user_data = array(
        'email' => $_POST['usuario'],
        'password' => $password,
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'celular' => $_POST['celular'],
        'id_tipo_usuario' => $tipo_usuario,
        'localidad_id_localidad' => $id_localidad
      );

      $this->registry->db->insert('usuarios', $new_user_data);
      $id_usuario = $this->registry->db->getInsertId();

      $opciones = array(
        'usuarios_id_usuarios' => $id_usuario,
        'tipo_servicio_id_tipo_servicio' => '');

      foreach($_POST['tecnicoSelect'] as $key => $valor) {
          $opciones['tipo_servicio_id_tipo_servicio'] = $valor;
          $this->registry->db->insert('usuarios_servicio', $opciones);
      }

    } else {
      $tipo_usuario = $this->registry->cliente;
      /**
     * Creo el nuevo array con la informacion a ingresar
     * del nuevo usuario y lo ingreso en la Base de Datos.
     */
      $new_user_data = array(
        'email' => $_POST['usuario'],
        'password' => $password,
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'celular' => $_POST['celular'],
        'id_tipo_usuario' => $tipo_usuario,
        'localidad_id_localidad' => $id_localidad
      );

      $this->registry->db->insert('usuarios', $new_user_data);
    }

   }

}

public function delete(){
  /**
   * Metodo de eliminacion de usuarios
   */
    $this->registry->db->where('email', $_SESSION['usuario']);
    $usuario = $this->registry->db->get('usuarios');

    if ($usuario[0]['id_tipo_usuario'] == $this->registry->tecnico){
      $this->registry->db->where('usuarios_id_usuarios', $usuario[0]['id_usuarios'] );
      if($this->registry->db->delete('usuarios_servicio')) echo 'successfully deleted';
    }

    $this->registry->db->where('email', $_SESSION['usuario']);
    if($this->registry->db->delete('usuarios')) echo 'successfully deleted';

    $this->registry->db->where('id_localidad', $usuario[0]['id_usuarios']);
    if($this->registry->db->delete('localidad')) echo 'me cago';

    unset($_SESSION['usuario']);
    session_destroy();
    header('location: index.php');

}

public function update(){
  /**
   * Metodo de actualizacion de usuarios
   */

  $this->registry->db->where('id_usuarios', $_SESSION['id_usuario']);
  $usuario = $this->registry->db->get('usuarios');
  $direccion = $this->registry->db->where('id_localidad', $usuario['0']['localidad_id_localidad'])->get('localidad');

  $id_usuario = $usuario['0']['id_usuarios'];
  $_SESSION['id_localidad_usuario'] = $usuario['0']['localidad_id_localidad'];

  $puntuacion = $this->registry->db->query("SELECT AVG(p.puntuacion) puntuacion from usuarios u, usuarios_has_puntuacion up, puntuacion p WHERE u.id_usuarios = up.usuarios_id_usuarios AND up.puntuacion_id_puntuacion = p.id_puntuacion AND u.id_usuarios = ". $id_usuario ."");

  $this->registry->template->puntuacion = number_format($puntuacion['0']['puntuacion'],1);

  if ($_SESSION['tipo'] == $this->registry->tecnico) {

    $resultado = $this->registry->db->query("SELECT tipo_servicio.nombre from usuarios_servicio us, tipo_servicio WHERE tipo_servicio.id_tipo_servicio = us.tipo_servicio_id_tipo_servicio AND usuarios_id_usuarios = " .$id_usuario."");

    $servicios = $this->registry->db->query("SELECT s.id_servicios, s.nombre, s.fecha, s.cant_horas, s.precio, s.descripcion,s.foto from servicios s, usuarios u, ofrece o WHERE s.id_servicios = o.servicios_id_servicios AND u.id_usuarios = o.usuarios_id_usuarios AND u.id_usuarios = ". $id_usuario."");

    $categorias = array();

    foreach ($resultado as $key => $value) {
        foreach ($value as $key => $value) {
            array_push($categorias, $value);
        }
    }

    $this->registry->template->categorias = $categorias;
    $this->registry->template->servicios = $servicios;

  } else {

    $this->registry->template->categorias = '';
    $servicios = $this->registry->db->query("SELECT s.id_servicios, s.nombre, s.fecha, s.cant_horas, s.precio, s.descripcion,s.foto from servicios s, usuarios u, contrata c WHERE s.id_servicios = c.servicios_id_servicios AND u.id_usuarios = c.usuarios_id_usuarios AND u.id_usuarios = ". $id_usuario."");

    $this->registry->template->servicios = $servicios;
  }

  $this->registry->template->usuario = $usuario;
  $this->registry->template->coordenadas = str_replace(array('(',')'), '',$direccion['0']['latlong']);
  $this->registry->template->localidad = $direccion['0']['direccion'];

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_SESSION['id_usuario'];
    $id_localidad = $_SESSION['id_localidad_usuario'];

    if ($_SESSION['tipo'] == $this->registry->tecnico) {
      $array = explode(',', $_POST['hidden-especialidades']);
      $diferencia = array_diff($array, $categorias);
    }

    if(!empty($diferencia)){
      foreach($diferencia as $key => $valor) {
        $update_data_categorias = array(
        'nombre' => $valor,
        );

        $this->registry->db->insert('tipo_servicio', $update_data_categorias);
        $id_categoria = $this->registry->db->getInsertId();

        $opciones = array(
       'usuarios_id_usuarios' => $id,
       'tipo_servicio_id_tipo_servicio' => $id_categoria);

        $this->registry->db->insert('usuarios_servicio', $opciones);

      }
    }

    $update_data = array(
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'celular' => $_POST['celular'],
    );

    $update_data_localidad = array(
        'direccion' => $_POST['address'],
        'latlong' => $_POST['coord']
    );


    $results = $this->registry->db->rawQuery("UPDATE usuarios SET nombre = ? , apellido = ? , celular = ? WHERE id_usuarios = $id ", $update_data);

    $results = $this->registry->db->rawQuery("UPDATE localidad SET direccion = ? , latlong = ? WHERE id_localidad = $id_localidad ", $update_data_localidad);


    $this->registry->db->where('email', $_SESSION['usuario']);
    $usuario = $this->registry->db->get('usuarios');
    $direccion = $this->registry->db->where('id_localidad', $usuario['0']['localidad_id_localidad'])->get('localidad');
    $this->registry->template->usuario = $usuario;
    $this->registry->template->coordenadas = str_replace(array('(',')'), '',$direccion['0']['latlong']);
    $this->registry->template->localidad = $direccion['0']['direccion'];

    if ($_SESSION['tipo'] == $this->registry->tecnico) {

      $resultado = $this->registry->db->query("SELECT tipo_servicio.nombre from usuarios_servicio us, tipo_servicio WHERE tipo_servicio.id_tipo_servicio = us.tipo_servicio_id_tipo_servicio AND usuarios_id_usuarios = " .$id_usuario."");

      $categorias = array();

      foreach ($resultado as $key => $value) {
          foreach ($value as $key => $value) {
              array_push($categorias, $value);
          }
      }

      $this->registry->template->categorias = $categorias;

    } else {

      $this->registry->template->categorias = '';
    }

    $this->registry->template->show('perfil_usuario');

  } else{
    $this->registry->template->show('perfil_usuario');
  }

}

public function viewUsuario() {

  $pieces = explode("/", $_GET['rt']);

  $this->registry->db->where('id_usuarios', $pieces['2']);
  $usuario = $this->registry->db->get('usuarios');
  $id_usuario =  $pieces['2'];
  $direccion = $this->registry->db->where('id_localidad', $usuario['0']['localidad_id_localidad'])->get('localidad');

  $this->registry->template->coordenadas = str_replace(array('(',')'), '',$direccion['0']['latlong']);
  $this->registry->template->localidad = $direccion['0']['direccion'];

  $puntuacion = $this->registry->db->query("SELECT AVG(p.puntuacion) puntuacion from usuarios u, usuarios_has_puntuacion up, puntuacion p WHERE u.id_usuarios = up.usuarios_id_usuarios AND up.puntuacion_id_puntuacion = p.id_puntuacion AND u.id_usuarios = ". $id_usuario ."");

  $this->registry->template->puntuacion = number_format($puntuacion['0']['puntuacion'],1);

  if($usuario['0']['id_tipo_usuario'] == '3') {
    $servicios = $this->registry->db->query("SELECT s.id_servicios, s.nombre, s.fecha, s.cant_horas, s.precio, s.descripcion,s.foto from servicios s, usuarios u, ofrece o WHERE s.id_servicios = o.servicios_id_servicios AND u.id_usuarios = o.usuarios_id_usuarios AND u.id_usuarios = ". $id_usuario."");

    $resultado = $this->registry->db->query("SELECT tipo_servicio.nombre from usuarios_servicio us, tipo_servicio WHERE tipo_servicio.id_tipo_servicio = us.tipo_servicio_id_tipo_servicio AND usuarios_id_usuarios = " .$id_usuario."");

    $categorias = array();

    foreach ($resultado as $key => $value) {
        foreach ($value as $key => $value) {
            array_push($categorias, $value);
        }
    }

    $this->registry->template->categorias = $categorias;

  } else {
    $servicios = $this->registry->db->query("SELECT s.id_servicios, s.nombre, s.fecha, s.cant_horas, s.precio, s.descripcion,s.foto from servicios s, usuarios u, contrata c WHERE s.id_servicios = c.servicios_id_servicios AND u.id_usuarios = c.usuarios_id_usuarios AND u.id_usuarios = ". $id_usuario."");
    $this->registry->template->categorias = "";
  }

  $this->registry->template->servicios = $servicios;
  $this->registry->template->usuario = $usuario;
  $this->registry->template->show('ver_usuario');
}

public function listado(){

  $usuarios = $this->registry->db->get('usuarios');

  $this->registry->template->usuarios = $usuarios;
  $this->registry->template->show('ver_usuarios');
}

public function calificar(){

    $calificacion = array(
        'puntuacion' => $_POST['rate'],
        'comentario' => 'prueba');

    $this->registry->db->insert('puntuacion', $calificacion);
    $id_calificacion = $this->registry->db->getInsertId();

    $calificacion_usuario = array(
        'usuarios_id_usuarios' => $_POST['id'],
        'puntuacion_id_puntuacion' => $id_calificacion
    );

    $this->registry->db->insert('usuarios_has_puntuacion', $calificacion_usuario);

}

}
?>
