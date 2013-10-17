<?php

Class usuarioController Extends baseController {

public function index()
{
        $this->registry->template->blog_heading = 'This is the usuario Index';
        $this->registry->template->show('blog_index');
}

public function view_json(){

  $this->registry->template->blog_heading = 'This is the blog heading';
  $this->registry->template->blog_content = 'This is the blog content';
  $results = $this->registry->db->get('usuarios');
  $this->registry->template->filas = $results;

  $this->registry->template->show('blog_view_json');
}

public function view(){

	/*** should not have to call this here.... FIX ME ***/

	$this->registry->template->blog_heading = 'This is the blog heading';
	$this->registry->template->blog_content = 'This is the blog content';
	$results = $this->registry->db->get('usuarios');
	$this->registry->template->filas = $results;

	$this->registry->template->show('blog_view');
}

public function insert(){
  /**
   * Metodo de ingreso de usuarios
   */
  $this->registry->template->usuario_heading = 'This is the usuario heading';

  $this->registry->template->show('ingreso_usuarios');

  if($_SERVER['REQUEST_METHOD'] === 'POST'){

    //Pregunto por si es tecnico o usuario.
    if(isset($_POST['tecnicoCheckbox'])){
      $tipo_usuario = $this->registry->tecnico;
    } else {
      $tipo_usuario = $this->registry->cliente;
    }

    /**
     * Ingreso las ubicacion del nuevo usuario.
     */
    $new_user_direccion = array(
      'direccion' => $_POST['address'],
      'latlong' => $_POST['coord']
    );

    $this->registry->db->insert('localidad', $new_user_direccion);
    //Obtengo el ultimo id ingresado.
    $id_localidad = $this->registry->db->getInsertId();

    /**
     * Creo el nuevo array con la informacion a ingresar
     * del nuevo usuario y lo ingreso en la Base de Datos.
     */
    $new_user_data = array(
      'email' => $_POST['usuario'],
      'password' => $_POST['password'],
      'nombre' => $_POST['nombre'],
      'apellido' => $_POST['apellido'],
      'celular' => $_POST['celular'],
      'id_tipo_usuario' => $tipo_usuario,
      'localidad_id_localidad' => $id_localidad
    );

    $this->registry->db->insert('usuarios', $new_user_data);
   }

}

public function get(){
  /**
   * Metodo para obtener un usuario
   *
   */
  $this->registry->template->usuario_heading = 'This is the usuario heading';


  $this->registry->db->where('email', 'jvrdom@gmail.com');
  $usuario = $this->registry->db->get('usuarios');
  $this->registry->template->usuario = $usuario;

  $this->registry->template->show('perfil_usuario');

}

public function delete(){
  /**
   * Metodo de eliminacion de usuarios
   */
  if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $this->registry->db->where('email', 'jvrdom@gmail.com');
    if($db->delete('usuarios')) echo 'successfully deleted';

  }
}

public function update(){
  /**
   * Metodo de actualizacion de usuarios
   */

  $this->registry->template->usuario_heading = 'This is the usuario heading';

  $this->registry->db->where('email', 'jvrdom@gmail.com');
  $usuario = $this->registry->db->get('usuarios');
  $this->registry->template->usuario = $usuario;

  $this->registry->template->show('perfil_usuario');

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $new_user_data = array(
        'email' => $_POST['usuario'],
        'password' => $_POST['password'],
        'nombre' => $_POST['nombre'],
        'apellido' => $_POST['apellido'],
        'celular' => $_POST['celular'],
    );

    $this->registry->db->where('email', $_POST['usuario']);
    $this->registry->db->update('usuarios', $new_user_data);

  }
}

}
?>
