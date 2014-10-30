<?php
class controller extends AbsController{

	public function display(){

	}

    public function run(){
        $this->checkIfLogedIn(true);
        $this->view->setTemplate("simple");
        $this->view->setContent("Content", $this->model->getData());
        echo $this->view->getTemplateContent();
    }
}
?>