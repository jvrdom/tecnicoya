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

    $usuario = $this->registry->db->where('email',$_POST['usuario'])->get('usuarios');
    if(crypt($_POST['password'], $usuario[0]['password']) == $usuario[0]['password'] and $usuario[0]['usuario'] == $_POST['usuario']){
      //Almacenamos el nombre de usuario en una variable de sesión usuario
      $_SESSION['usuario'] = $_POST['usuario'];
      //Redireccionamos a la pagina: index.php
      header("Location: index.php?rt=usuario/insert");
      //$this->registry->template->sesion = $_SESSION['usuario'];
      //$this->registry->template->show('ingreso_usuarios');
      //header("Location: ingreso_usuarios.php");
    } else {
      //Mensajes de error
      echo "me cago";
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
  unset($_SESSION['usuario']);
  session_destroy();
  header('location: index.php');
}

}

?>
