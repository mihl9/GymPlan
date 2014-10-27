<?php
class mydb
{
	public  $_con = null;
	public  $_results = null;
	public function __construct()
	{
		$this->conection();
	}
	function __destruct()
	{
		$this->_con->close();
	}
	public function conection()
	{
		$this->_con = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PW, MYSQL_DB);
		if($this->_con->connect_errno){
			echo "Keine Datenbank vorhanden, wird erstellt.";
    			$this->install();
		}
	}
	public function close()
	{
		$this->_con->close();
	}
	function sqlexec($sqlstr)
	{
		$this->_results = $this->_con->query($sqlstr);
	}
	private function install()
	{
		$this->_con = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PW);
		$sqlstr = "CREATE DATABASE IF NOT EXISTS " . MYSQL_DB;
		$this->_con->query($sqlstr);
		$this->_con->select_db(MYSQL_DB);
		$sqlstr = "CREATE TABLE IF NOT EXISTS  users
		(
		usersid int NOT NULL AUTO_INCREMENT,
		PRIMARY KEY (usersid),
		loginname VARCHAR(15),
		loginpass VARCHAR(100)
		)";
		$this->_con->query($sqlstr);
		$sqlstr = "INSERT INTO users
		(loginname, loginpass)
		VALUES
		('admin',  '1234')";
		$this->_con->query($sqlstr);
	}
}
?>