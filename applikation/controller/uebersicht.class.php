<?php
class controller extends AbsController{

	public function __construct() {
        parent::__construct();
        self::$ActiveController="uebersicht";
	}
	public function display(){
		echo $this->view->showtxt($this->model->data);
	}

    public function run(){

    }
}
?>