<?php
class model extends AbsModel
{
	public $data;
    public function getData(){
        $this->data = '';
        $this->database->executeWithResult('SELECT * FROM t_users');
        while($row = mysqli_fetch_object($this->database->_results)){
            $this->data .= $row->UserID;
            $this->data .= ' / ';
            $this->data .=  $row->UserNickname;
            $this->data .=  ' / ';
            $this->data .=  $row->UserPasswort;
            $this->data .=  '<br>';
        }
    }
}
?>
