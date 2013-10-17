<?php

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

 session_start();

?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="includes/public/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="includes/public/css/bootstrap-select.css" rel="stylesheet" media="screen">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the
                              way to the bottom of the topbar */
      }

      footer {
        margin-top: 40px;
        border-top: 1px solid #EEE;
      }

    </style>
  </head>
  <body>
     <div class="navbar navbar-fixed-top navbar-inverse">
        <div class="navbar-inner">
          <div class="container">
            <a class="brand">TecnicoYa!</a>
            <div class="nav-collapse">
              <ul class="nav">
                <li class="active"><a href="index.php"><i class="icon-home icon-white"></i> Home</a></li>
              </ul>
              <form class="navbar-search pull-right" action="">
                <?php  if (empty($_SESSION["usuario"])) { ?>
                          <!--<button type="button" class="btn btn-link" style="margin-top: 0px;">Iniciar Sesion</button>
                          |-->
                          <button type="button" class="btn btn-link" style="margin-top: 0px;">
                            <a href="index.php?rt=usuario/insert">Registrarse</a></button>
                       <?php } else { ?>
                                    <button type="button" class="btn btn-link" style="margin-top: 0px;">Mi Perfil</button>
                                    |
                                    <button type="button" class="btn btn-link" style="margin-top: 0px;">
                                      <a href="index.php?rt=index/logout">Salir</a></button>
                       <?php } ?>
              </form>
            </div><!-- /.nav-collapse -->
          </div><!-- /.container -->
        </div><!-- /.navbar-inner -->
        </div><!-- /.navbar -->

    <div class="container">
      <div class="row">
        <?php
          $registry->router->loader();
        ?>
      </div>

      <footer class="footer">
        <p>
          <small>
            Hellou
          </small>
        </p>
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="includes/public/js/bootstrap.js"></script>
      </footer>
    </div>
  </body>
</html>

