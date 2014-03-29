<?php

 /*** Inicia la sesion ***/
 session_start();

 /*** error reporting on ***/
 error_reporting(E_ALL);

 /*** define the site path ***/
 $site_path = realpath(dirname(__FILE__));
 define ('__SITE_PATH', $site_path);

 /*** include the init.php file ***/
 include 'includes/init.php';

 /*** load the router ***/
 $registry->router = new router($registry);

 /*** set the controller path ***/
 $registry->router->setPath (__SITE_PATH . '/controller');

 /*** load up the template ***/
 $registry->template = new template($registry);


?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="includes/public/css/style.css" rel="stylesheet" type="text/css" media="screen">
    <link href="includes/public/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="includes/public/css/bootstrap-select.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="includes/public/css/tagmanager.css">
    <link rel="stylesheet" type="text/css" href="includes/public/css/datepicker.css">
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="includes/public/css/rating.css">
    <link rel="stylesheet" type="text/css" href="includes/public/css/jRating.jquery.css" media="screen">
    <link rel="stylesheet" type="text/css" href="includes/public/css/jNotify.jquery.css" media="screen">

    <script src="http://code.jquery.com/jquery.js"></script>
    <!--<script src="includes/public/js/jquery-1.10.2.js"></script>-->
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
    <script src="includes/public/js/bootstrap.js"></script>
    <script src="includes/public/js/bootstrap-select.js"></script>
    <script src="includes/public/js/jqBootstrapValidation.js"></script>
    <script src="includes/public/js/tagmanager.js"></script>
    <script src="includes/public/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="includes/public/js/jRating.jquery.js"></script>
    <script type="text/javascript" src="includes/public/js/jNotify.jquery.js"></script>
  </head>
  <body>
     <div class="navbar navbar-fixed-top navbar-inverse">
        <div class="navbar-inner">
          <div class="container">
            <a href="index.php" class="brand">TécnicoYa!</a>
            <div class="nav-collapse">
               <?php  if (!empty($_SESSION["usuario"])) { ?>
              <ul class="nav">
                <li class="active"><a href="index.php?rt=usuario/index/<?php echo $_SESSION["id_usuario"] ?>"><i class="icon-home icon-white"></i> Home</a></li>
              </ul>
              <form class="navbar-search pull-right" action="">
                    <small id="bienvenido">Bienvenido <?php echo ($_SESSION["usuario"]) ?></small>
                    <button type="button" class="btn btn-link" style="margin-top: 0px;">
                      <a href="index.php?rt=usuario/update/<?php echo $_SESSION["id_usuario"] ?>" > <small>Mi Perfil </small></a></button>
                    |
                    <button type="button" class="btn btn-link" style="margin-top: 0px;">
                      <a href="index.php?rt=index/logout"><small>Salir</small></a></button>
                    <?php } ?>
              </form>
            </div>
          </div>
        </div>
        </div>

    <div class="container">
      <div class="row">
        <?php
          $registry->router->loader();
        ?>
      </div>
    </div>

      <div id="footer">
        <footer>
          <div class ="container">
            <div class="content">
              <div class="text-muted credit">
                  <p>
                    <small>
                    </small>
                  </p>
              </div>
          </div>
        </div>
        </footer>
    </div>
  </body>
</html>

