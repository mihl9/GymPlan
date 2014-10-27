<?php
class controller{
	private $view;
        	private $model;
	public function __construct() {
		$this->model	= new model();
		$this->view	= new view();
	}
	public function display(){
		//zeige Daten oder Form
		if($_POST){
			// stimmt Loginname und Passwort
			$this->model->chklogindata($_POST['loginname'], $_POST['loginpass']);
			if($this->model->check==0){
				// falscher Username oder Passwort
				echo $this->view->showtxt($this->model->showdata());
			}else{
				// Login erfolgreich , ID des users wird angezeigt
				echo $this->view->showtxt($this->model->check);
			}
		}else{
			echo $this->view->showtxt($this->model->showform());
		}
	}
}
?>