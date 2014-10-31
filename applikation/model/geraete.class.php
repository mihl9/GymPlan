<?php
class model extends AbsModel
{
    public function getGerate($ID){
        $user=$this->getLogedInUserInformation();
        if($user){
            if($ID==0){
                $sql="SELECT * FROM t_geraete";
            }else{
                $sql="SELECT * FROM t_geraete WHERE GeraeteID=".$ID;
            }
            $result=$this->database->executeWithResult($sql);
            return $result;
        }else{
            return false;
        }
    }

    public function addGeraete($data){
        $user=$this->getLogedInUserInformation();
        if($user){
            $sql="INSERT INTO t_geraete (GeraeteUserID_FK, GeraeteName, GeraeteBez) VALUES (".$data['GeraeteUserID_FK'].")";
        }
    }

    public function updateGeraete(){

    }

    public function getGeraete(){

    }
}
?>
