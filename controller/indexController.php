<?php

Class indexController Extends baseController {

  public function index() {
  	/*** load the index template ***/
          $this->registry->template->show('index');
  }

  public function login() {

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

    /*function exceptions_error_handler($severity, $message, $filename, $lineno) {
      if (error_reporting() == 0) {
        return;
      }
      if (error_reporting() & $severity) {
        throw new ErrorException($message, 0, $severity, $filename, $lineno);
      }
    }

    set_error_handler('exceptions_error_handler');*/

      $usuario = $this->registry->db->where('email',$_POST['usuario'])->get('usuarios');
      if(md5($_POST['password']) == $usuario[0]['password'] and $usuario[0]['email'] == $_POST['usuario']){
        //Almacenamos el nombre de usuario en una variable de sesión usuario
        $_SESSION['usuario'] = $_POST['usuario'];
        $_SESSION['tipo'] = $usuario[0]['id_tipo_usuario'];
        $_SESSION['id_usuario'] = $usuario[0]['id_usuarios'];
        header('location: index.php?rt=usuario/index/'. $usuario[0]['id_usuarios']);

        /*if($usuario[0]['id_tipo_usuario'] == $this->registry->admin){
          $this->registry->template->blog_heading = 'This is the admin Index';

        } elseif ($usuario[0]['id_tipo_usuario'] == $this->registry->tecnico) {
          $this->registry->template->blog_heading = 'This is the técnico Index';

        } else {
          $this->registry->template->blog_heading = 'This is the usuario Index';

        }
        $this->registry->template->show('usuario_index');*/
      } else {
              $_SESSION['error'] = 'true';
              $this->registry->template->mensaje = "Nombre de usuario o contraseña incorrectos!";
              $this->registry->template->show('login');
      }
    } else {
        $_SESSION['error'] = 'false';
        $this->registry->template->show('login');
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
