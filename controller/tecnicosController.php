<?php
  class tecnicosController extends baseController {

    public function index()
    {
        $this->registry->template->blog_heading = 'This is the tecnicos Index';
        //$this->registry->template->show('blog_index');
    }

    public function view_json(){

        $this->registry->template->blog_heading = 'This is the blog heading';
        $this->registry->template->blog_content = 'This is the blog content';
        $this->registry->template->show('blog_view_json');
    }

    public function view2(){

    /*** should not have to call this here.... FIX ME ***/

        $this->registry->template->blog_heading = 'This is the blog heading';
        $this->registry->template->blog_content = 'This is the blog content';
        $results = $this->registry->db->get('usuarios');
        $this->registry->template->filas = $results;
        $this->registry->template->show('blog_view');
    }

    public function view(){

        $id = $_SESSION['id_usuario'];
        $this->registry->db->where('id_usuarios', $id);
        $usuario = $this->registry->db->get('usuarios');

        $direccion = $this->registry->db->where('id_localidad', $usuario['0']['localidad_id_localidad'])->get('localidad');

        /*$results = $this->registry->db->query('SELECT localidad.latlong FROM localidad, usuarios WHERE localidad.id_localidad = usuarios.localidad_id_localidad AND usuarios.id_tipo_usuario = 3 ');*/

        $tecnicos = $this->registry->db->query('SELECT * FROM usuarios, localidad WHERE localidad.id_localidad = usuarios.localidad_id_localidad AND usuarios.id_tipo_usuario = 3 ');

        $categorias = $this->registry->db->get('tipo_servicio');

        /*$coordenadas = array();

        foreach ($results as $key => $value) {
            foreach ($value as $key => $value) {
                $a = str_replace(array('(',')'), '',$value);
                array_push($coordenadas, $a);
            }
        }

        $this->registry->template->coordenadas = str_replace(array('(',')'), '',$direccion['0']['latlong']);
        $this->registry->template->filas = $coordenadas;*/
        $this->registry->template->tecnicos = $tecnicos;
        $this->registry->template->tipos = $categorias;
        $this->registry->template->show('ver_tecnicos');

        /*var_dump($_GET);
        $pieces = explode("/", $_GET['rt']);
        var_dump($pieces);*/
    }
  }
?>
