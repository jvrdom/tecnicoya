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

}

  public function update(){
    /**
     * Metodo de actualizacion de usuarios
     */

    $pieces = explode("/", $_GET['rt']);

    $this->registry->db->where('id_usuarios', $pieces['2']);
    $usuario = $this->registry->db->get('usuarios');
    $direccion = $this->registry->db->where('id_localidad', $usuario['0']['localidad_id_localidad'])->get('localidad');
    $this->registry->template->usuario = $usuario;
    $this->registry->template->coordenadas = str_replace(array('(',')'), '',$direccion['0']['latlong']);
    $this->registry->template->localidad = $direccion['0']['direccion'];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

      $id = $usuario['0']['id_usuarios'];
      $id_localidad = $usuario['0']['localidad_id_localidad'];

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
      $this->registry->template->show('perfil_usuario');

    } else{
      $this->registry->template->show('perfil_usuario');
    }

  }

}
?>
