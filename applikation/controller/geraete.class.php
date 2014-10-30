<?php
class controller extends AbsController{

	public function display(){

	}

    public function run(){
        if($this->checkIfLogedIn(true)){
            $this->view->setContent("Content", $this->model->getData());
        }else {
            $this->view->DisplayMessageLabel("Diese Seite benötigt ein gültiges Login.", 2,false,"Content");
        }
        $this->view->setTemplate("simple");
        echo $this->view->getTemplateContent();
    }
}
?>