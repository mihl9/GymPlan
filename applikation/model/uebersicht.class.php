<?php
class model extends AbsModel
{
	public $data;
    public function display(){
        $this->data = '';
        $this->database->executeWithResult('SELECT * FROM t_users');
        while($row = mysqli_fetch_object($this->database->_results)){
            $this->data .= $row->usersid;
            $this->data .= ' / ';
            $this->data .=  $row->loginname;
            $this->data .=  ' / ';
            $this->data .=  $row->loginpass;
            $this->data .=  '<br>';
        }
    }
}
?>
