<?php

Class indexController Extends baseController {

public function index() {
	/*** set a template variable ***/
        $this->registry->template->welcome = 'Welcome to PHPRO MVC';
	/*** load the index template ***/
        $this->registry->template->show('index');
}

public function login() {

  if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if($usuario = $this->registry->db->where('email',$_POST['usuario'])
                                  ->where('password',$_POST['password'])
                                  ->get('usuarios'))
    {
      //Almacenamos el nombre de usuario en una variable de sesión usuario
      session_start();
      $_SESSION['usuario'] = $_POST['usuario'];
      //Redireccionamos a la pagina: index.php
      //header("Location: ingreso_usuarios.php");
      $this->registry->template->show('ingreso_usuarios');

    } else {
      //Mensajes de error
    }
/*
    if($usuario['id_tipo_usuario'] == 1){
      $this->registry->template->show('ingreso_usuarios');
    }else{
      //Ir a panel de administrador o panel de tecnico.
    }
*/
  }
}

/**
 * Funcion para desloguearse del sitio web.
 * @return [type] [description]
 */
public function logout(){

}


}

?>
