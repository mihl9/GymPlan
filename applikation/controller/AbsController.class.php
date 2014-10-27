<?php
/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 27.10.2014
 * Time: 11:06
 */

abstract class AbsController {
    private static $isActive = false;

    public static function getIsLoaded(){
        return self::$isActive;
    }

    public function __construct(){
        //Set the var to true that the Controller is loaded
        //this is necessary for the Navigationbar
        self::$isActive = true;
    }

    public function __destruct(){
        //Set the var to true that the Controller is not loaded
        //this is necessary for the Navigationbar
        self::$isActive = false;
    }

    public function checkIfLoggedIn($bShowLogginBox){
        $session = SessionHandler::getInstance();
        if(isset($session->isLoggedIn)){

        }else{

        }
    }
} 