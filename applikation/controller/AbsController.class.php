<?php
/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 27.10.2014
 * Time: 11:06
 */

abstract class AbsController {
    protected $view;
    protected $model;

    public function __construct(){
        //Set the var to true that the Controller is loaded
        //this is necessary for the Navigationbar
        //self::$ActiveController = true;
        $this->view = new view();
        $this->model = new model();
    }

    public function __destruct(){
        //Set the var to true that the Controller is not loaded
        //this is necessary for the Navigationbar
        $this->view = null;
        $this->model = null;
    }

    protected function checkIfLogedIn($bShowLogginBox){
        $config = Config::getInstance();

        if($this->model->isLoggedIn()){
            if($bShowLogginBox) {
                $this->view->DisplayLoginBoxLoggedIn($this->model->getLogedInUserInformation());
                $result=true;
            }
        }else{
            if($bShowLogginBox){
                $this->view->DisplayLoginBox($config->getConfig('canRegister'));
                $result=false;
            }
        }
        return $result;
    }

    public function login(){
        if(empty($_POST['name']) || empty($_POST['password'])) {
            //missing the username or password
            $this->view->DisplayMessageLabel("Benutzername oder Passwort fehlt",2,true,"LoginMessage");
        }else{
            if($this->model->checkLoginData($_POST['name'],$_POST['password'])){
                //login successfull
                $this->reload();
            }else{
                //login failed
                $this->view->DisplayMessageLabel("Falscher Benutzername oder Passwort",2,true,"LoginMessage");
                $this->run();
            }
        }

        //$this->run();

    }

    public function logout(){
        $session = FWSessionHandler::getInstance();
        $session->isLoggedIn = false;
        $session->UserID=0;
        //$this->run();
        $this->reload();
    }

    public function reload(){
        header('Location: ?controller=' . $_GET['controller']);
    }
    /**
     * @return mixed
     */
    abstract public function run();
} 