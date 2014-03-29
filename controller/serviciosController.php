<?php
  class serviciosController extends baseController {

    public function index()
    {
        $this->registry->template->blog_heading = 'This is the servicios Index';
        $this->registry->template->show('blog_index');
    }

    public function insert(){

        $id_usuario = $_SESSION['id_usuario'];

        $resultado = $this->registry->db->query("SELECT tipo_servicio.id_tipo_servicio, tipo_servicio.nombre from usuarios_servicio us, tipo_servicio WHERE tipo_servicio.id_tipo_servicio = us.tipo_servicio_id_tipo_servicio AND usuarios_id_usuarios = " .$id_usuario."");

        $this->registry->template->filas = $resultado;
        $this->registry->template->show('ingreso_servicios');

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $uploaddir = '/var/www/tecnicoya/includes/public/img/';
            $uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
            $path = $uploaddir.basename($_FILES['userfile']['name']);

            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)){
            } else{
                 echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
            }

            $insert_data = array(
                'nombre' => $_POST['nombre'],
                'fecha' => $_POST['fecha'],
                'cant_horas' => $_POST['cant_horas'],
                'precio' => $_POST['precio'],
                'foto' => $path,
                'descripcion' => $_POST['descripcion']);

            $this->registry->db->insert('servicios', $insert_data);
            $id_servicio = $this->registry->db->getInsertId();

            $opciones = array(
            'tipo_servicio_id_tipo_servicio' => '',
            'servicios_id_servicios' => $id_servicio);

            $opciones['tipo_servicio_id_tipo_servicio'] = $_POST['tecnicoSelect'];
            $this->registry->db->insert('tipo_servicio_has_servicios', $opciones);

            $ofrecido = array(
                'usuarios_id_usuarios' => $id_usuario,
                'servicios_id_servicios' => $id_servicio);

            $this->registry->db->insert('ofrece', $ofrecido);

        }
    }

    public function delete(){

        $this->registry->db->where('id_servicios', $_POST['servicio'] );
        $servicio = $this->registry->db->get('servicios');

        $this->registry->db->where('servicios_id_servicios', $servicio[0]['id_servicios'] );
        if($this->registry->db->delete('tipo_servicio_has_servicios'))

        $this->registry->db->where('servicios_id_servicios', $servicio[0]['id_servicios'] );
        if($this->registry->db->delete('ofrece'))

        $this->registry->db->where('servicios_id_servicios', $servicio[0]['id_servicios'] );
        if($this->registry->db->delete('contrata'))

        $this->registry->db->where('id_servicios', $_POST['servicio'] );
        if($this->registry->db->delete('servicios'))

        //$this::view();
        header('location: index.php?rt=servicios/view/');
    }

    public function update(){

        $pieces = explode("/", $_GET['rt']);
        $_SESSION['id_servicio'] = $pieces['2'];
        $id_servicio = $pieces['2'];

        $servicio = $this->registry->db->where('id_servicios', $pieces['2'])->get('servicios');

        $puntuacion = $this->registry->db->query("SELECT AVG(p.puntuacion) puntuacion from servicios s, contrata c, contrata_has_puntuacion cp, puntuacion p WHERE s.id_servicios = c.servicios_id_servicios AND c.servicios_id_servicios = cp.contrata_servicios_id_servicios AND cp.puntuacion_id_puntuacion = p.id_puntuacion AND s.id_servicios = ". $pieces['2'] ."");

        $imagen = str_replace('/var/www', '', $servicio['0']['foto']);

        $this->registry->template->puntuacion = number_format($puntuacion['0']['puntuacion'],1);
        $this->registry->template->imagenurl = $imagen;
        $this->registry->template->servicio = $servicio;


        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $id_servicio = $_SESSION['id_servicio'];

            $update_data = array(
                'nombre' => $_POST['nombre'],
                'fecha' => $_POST['fecha'],
                'cant_horas' => $_POST['cant_horas'],
                'precio' => $_POST['precio'],
                'descripcion' => $_POST['descripcion']
            );

            $this->registry->db->rawQuery("UPDATE servicios SET nombre = ? , fecha = ? , cant_horas = ?, precio = ?, descripcion = ? WHERE id_servicios = $id_servicio ", $update_data);

            $servicio = $this->registry->db->where('id_servicios', $id_servicio)->get('servicios');

            $imagen = str_replace('/var/www', '', $servicio['0']['foto']);

            $this->registry->template->mensaje = "El servicio se ha actualizado correctamente!";
            $this->registry->template->imagenurl = $imagen;
            $this->registry->template->servicio = $servicio;
            $this->registry->template->show('ver_servicio');

        } else {
            $this->registry->template->mensaje = "";
            $this->registry->template->show('ver_servicio');
        }
    }

    public function contratarServicio(){

        $id_servicio = $_SESSION['id_servicio'];
        $id_usuario = $_SESSION['id_usuario'];

        $contrata = array(
            'usuarios_id_usuarios' => $id_usuario,
            'servicios_id_servicios' => $id_servicio);

        $tecnicoNombre = $this->registry->db->query("SELECT u.email from servicios s, usuarios u, ofrece o  WHERE s.id_servicios = o.servicios_id_servicios AND u.id_usuarios = o.usuarios_id_usuarios");

        $this->registry->db->insert('contrata', $contrata);
        header('location: index.php?rt=usuario/update/'. $id_usuario);
    }

    public function view(){

        $servicios = $this->registry->db->query("SELECT s.id_servicios, s.nombre, s.fecha, s.cant_horas, s.precio, s.descripcion,s.foto, t.nombre AS categoria, u.email AS tecnico from servicios s, usuarios u, ofrece o, tipo_servicio_has_servicios tp, tipo_servicio t WHERE s.id_servicios = o.servicios_id_servicios AND u.id_usuarios = o.usuarios_id_usuarios AND s.id_servicios = tp.servicios_id_servicios AND tp.tipo_servicio_id_tipo_servicio = t.id_tipo_servicio");

        $this->registry->template->servicios = $servicios;
        $this->registry->template->show('ver_servicios');
    }

    public function verContratados(){
        $servicios = $this->registry->db->query("SELECT s.id_servicios, s.nombre, s.fecha, s.cant_horas, s.precio, s.descripcion,s.foto, t.nombre AS categoria, u.email AS usuario, u.id_usuarios from servicios s, usuarios u, contrata c, tipo_servicio_has_servicios tp, tipo_servicio t WHERE s.id_servicios = c.servicios_id_servicios AND u.id_usuarios = c.usuarios_id_usuarios AND s.id_servicios = tp.servicios_id_servicios AND tp.tipo_servicio_id_tipo_servicio = t.id_tipo_servicio");

        $this->registry->template->servicios = $servicios;
        $this->registry->template->show('ver_servicios_contratados');
    }

    public function calificar(){

        $calificacion = array(
            'puntuacion' => $_POST['rate'],
            'comentario' => 'prueba');

        $this->registry->db->insert('puntuacion', $calificacion);
        $id_calificacion = $this->registry->db->getInsertId();

        $calificacion_servicio = array(
            'contrata_usuarios_id_usuarios' => $_SESSION['id_usuario'],
            'contrata_servicios_id_servicios' => $_POST['id'],
            'puntuacion_id_puntuacion' => $id_calificacion
        );

        $this->registry->db->insert('contrata_has_puntuacion', $calificacion_servicio);

    }

  }
?>
