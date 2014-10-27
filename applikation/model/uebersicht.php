<?php
class model
{
	public $data;
	private $meinedb;
	public function __construct()
	{
		$this->data = '';
		$this->meinedb = new mydb();
		$this->meinedb->sqlexec('SELECT * FROM users');
		while($row = mysqli_fetch_object($this->meinedb->_results)){
			$this->data .= $row->usersid;
			$this->data .= ' / ';
			$this->data .=  $row->loginname;
			$this->data .=  ' / ';
			$this->data .=  $row->loginpass;
			$this->data .=  '<br>';
		}
		$this->meinedb = NULL;
	}
}
?>
