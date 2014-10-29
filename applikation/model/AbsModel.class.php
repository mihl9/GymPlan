<?php
/**
 * Created by PhpStorm.
 * User: Anwender
 * Date: 27.10.2014
 * Time: 11:07
 */

abstract class AbsModel {
    protected $database;

    public function __construct() {
        $this->database = new DatabaseHandler();
    }

    public function checkLoginData($username,$password){
        $result = false;
        //prepare the count command
        $sql = 'SELECT count(UserID) as count FROM t_users where UserNickname='.$username.'UserPasswort'.sha1($password).';';
        //open the session handler
        $session = FWSessionHandler::getInstance();
        if($this->database->GetNumberOfRows($sql)==1){
            $session->isLoggedIn=true;
            $SQL="SELECT UserID FROM t_users WHERE UserNickname=".$username."UserPasswort".sha1($password).";";
            $session->UserID=$this->database->executeWithResult($sql)['UserID'];
            $result=true;
        }else{
            $session->isLoggedIn=false;
            $result=false;
        }
        return $result;
    }

    public function getLogedInUserInformation(){
        $result=array();
        $session = FWSessionHandler::getInstance();
        $result = $this->database->executeWithResult("SELECT * FROM t_users WHERE UserID=".$session->UserID);
        return $result;
    }

    public function isLoggedIn(){
        $result = false;
        $session = FWSessionHandler::getInstance();
        if(isset($session->isLoggedIn)){
            if($session->isLoggedIn==true){
                $result = true;
            }else{
                $result=false;
            }
        }else{
            $result=false;
        }
        return $result;
    }
} 