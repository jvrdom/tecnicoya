<?php
  class tecnicosController extends baseController {

    public function index()
    {
        $this->registry->template->blog_heading = 'This is the tecnicos Index';
        $this->registry->template->show('blog_index');
    }
  }
?>
