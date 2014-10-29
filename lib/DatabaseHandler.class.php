<?php
/**
 * Autor: Michael Huber, Sandro Pedrett
 * Created in collaboration with Sandro Pedrett.
 * Date: 23.10.2014
 * Time: 14:22
 */

class DatabaseHandler {
    /**
     * @var mysqli
     */
    private $mysql;
    private $mysqlHost;
    private $mysqlUser;
    private $mysqlPw;
    private $mysqlDB;

    public $_results;

    public function __construct() {
        // sdfasfd config ini
        $config = Config::getInstance();
        $this->mysqlHost=$config->getConfig("host");
        $this->mysqlUser=$config->getConfig("user");
        $this->mysqlPw=$config->getConfig("pass");
        $this->mysqlDB=$config->getConfig("db");
    }

    public function __destruct() {
        $this->_results = "";
        //$this->close();
    }
    private function open(){
        $result=true;

        $this->mysql = new mysqli($this->mysqlHost, $this->mysqlUser,$this->mysqlPw,$this->mysqlDB);

        if ($this->mysql->connect_error) {
            echo "Keine Datenbank vorhanden, wird erstellt.";
            $this->install();
            $this->open();
        }

        return $result;
}

    private function close(){
        $result=true;
        if (!$this->mysql->get_connection_stats()) {
            $this->mysql->close();
        }
        return $result;
    }

    public function execute($sql){
        $successful=false;
        $this->open();
        $statement=$this->mysql->prepare($sql);
        if($statement){
            $successful = $statement->execute();
            if($successful){
                $test =$statement->fetch();
            }else{
                //error executing the query
                $successful = false;
            }
        }else{
            $successful = false;
        }
        $this->close();
        return $successful;
    }

    public function executeWithResult($sql){
        $result=array();
        $success=true;
        $this->open();
        $statement=$this->mysql->prepare($sql);
        if($statement){
            $success=$statement->execute();
            if($success){
                $tmpResult = $statement->get_result();
                //save the raw result
                $this->_results = $tmpResult;
                while($row = $tmpResult->fetch_array()){
                    $result[] = $row;
                }
            }else{
                //failed to execute
                //return false;
                $result = false;
                $this->_results = "";
            }
        }else{
            //error within the sql string
            //return false;
            $this->_results = "";
            $result = false;
        }
        $this->close();
        return $result;
    }

    public function GetLastID(){
        $result=0;
        //todo: funktion implementieren
        $SQL="";
        return $result;
    }

    public function GetNumberOfRows($sql){
        $result=0;
        //todo: funktion implementieren
        $result = $this->executeWithResult($sql)['count'];
        return $result;
    }

    private function install()
    {
        $this->_con = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PW);
        //todo: Installationscript der Datenbank erstellen und implementieren
        $sqlstr = "CREATE DATABASE IF NOT EXISTS " . MYSQL_DB;
        $this->_con->query($sqlstr);
        $this->_con->select_db(MYSQL_DB);
        $sqlstr = "";

        $this->_con->query($sqlstr);
        $sqlstr = "";
        $this->_con->query($sqlstr);
    }
} 