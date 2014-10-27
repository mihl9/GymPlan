<?php
class controller{
	private $view;
        	private $model;
	public function __construct() {
		$this->model	= new model();
		$this->view	= new view();
	}
	public function display(){
		echo $this->view->showtxt($this->model->data);
	}
}
?>