<?php

  class enviarNotificaciones {

    public function __construct() {

    }

    public static function getInstance()
    {
        if (!isset(self::$_instance)){
            self::$_instance = new enviarNotificaciones();
        }
        return self::$_instance;
    }

    public function enviarNotificacionEmail ($email){

    }

    public function enviarNotificacionCel ($celular){

    }

  }
?>
