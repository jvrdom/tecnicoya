<?php

  class enviarNotificaciones {

    protected static $_instance;


    public function __construct() {
      self::$_instance = $this;
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
