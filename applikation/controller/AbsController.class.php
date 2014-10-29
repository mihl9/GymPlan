<?php
/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 27.10.2014
 * Time: 11:06
 */

abstract class AbsController {
    public static $ActiveController = 'none';
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
        self::$ActiveController = false;
        $this->view = null;
        $this->model = null;
    }

    protected function checkIfLogedIn($bShowLogginBox){
        $config = Config::getInstance();
        if($this->model->isLoggedIn()){
            $this->view->DisplayLoginBoxLoggedIn($this->model->getLogedInUserInformation);
        }else{
            $this->view->DisplayLoginBox($config->getConfig('canRegister'));
        }
    }

    public function login(){

    }

    public function logout(){

    }
    /**
     * @return mixed
     */
    abstract public function run();
} 