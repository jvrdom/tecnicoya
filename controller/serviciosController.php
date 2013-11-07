<?php
  class serviciosController extends baseController {

    public function index()
    {
        $this->registry->template->blog_heading = 'This is the servicios Index';
        $this->registry->template->show('blog_index');
    }


  }
?>
