</br>
<div data-spy="affix" data-offset-top="200" class='span4'>
  <ul class="nav nav-list">
    <li class="nav-header">Panel</li>
    <?php if ($_SESSION['tipo'] == '1') { ?>
      <li class="active"><a href="index.php?rt=tecnicos/view">Ver Técnicos</a></li>
    <?php } ?>
    <?php if ($_SESSION['tipo'] == '3') { ?>
    <li class="active"><a href="index.php?rt=servicios/insert">Ingreso de Servicios</a></li>
    <li > <a href="index.php?rt=servicios/verContratados">Ver Servicios Contratados</a> </li>
    <?php } ?>
    <?php if ($_SESSION['tipo'] == '2') { ?>
    <li class="active"><a href="index.php?rt=usuario/listado">Ver Usuarios</a></li>
    <?php } ?>
    <?php if ($_SESSION['tipo'] == '1' || $_SESSION['tipo'] == '2') { ?>
    <li > <a href="index.php?rt=servicios/view">Ver Servicios</a> </li>
    <?php } ?>
    <li ></li>
    <li ></li>
    <li class="divider"></li>
    <li><a class="text-error" href="index.php?rt=usuario/delete">Darse de Baja</a></li>
  </ul>
</div>

<div id="info" class='span8'>
    <?php if ($_SESSION['tipo'] == '1') { ?>
        <p class="lead"><strong>Bienvenido al panel principal, usted como cliente podrá buscar técnicos y buscar servicios para posteriormente contratarlos. Podrá además, ver su perfil con toda su informácion.</strong></p>
    <?php } ?>

    <?php if ($_SESSION['tipo'] == '2') { ?>
        <p class="lead">Bienvenido al panel principal, usted como administrador podrá ver los usuarios y servicios de todo el sistema para tener un control sobre los mismos y así, si amerita, darlos de baja. Podrá además, ver su perfil con toda su informácion.</p>
    <?php } ?>

    <?php if ($_SESSION['tipo'] == '3') { ?>
        <p class="lead">Bienvenido al panel principal, usted como técnico podrá dar de alta servicios, y visualizar y controlar sus servicios que han sido controlados. Podrá además, ver su perfil con toda su informácion.</p>
    <?php } ?>
</div>
