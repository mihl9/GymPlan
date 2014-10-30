<?php
class model extends AbsModel
{

    public function __construct(){
        parent::__construct();
    }

    public function getCurrentEinheit(){
        $user=$this->getLogedInUserInformation();
        if($user) {
            $sql = 'SELECT * FROM t_einheit WHERE EinheitTrinID_FK='. $user[0]['UserID'] .' order by EinheitDatum DESC Limit 1;';
            $result = $this->database->executeWithResult($sql);
            $result[0]['Uebungen'] = $this->getEinheitUebungen($result[0]['EinheitID']);
        }
        return $result;
    }

    private function getEinheitUebungen($EinheitID){
        $sql = 'SELECT * FROM t_uebungen inner join t_geraete on t_uebungen.UebGeraeteID_FK=t_geraete.GeraeteID WHERE UebEinheitID_FK='.$EinheitID;
        $result=$this->database->executeWithResult($sql);
        return $result;
    }
    public function getHistoryEinheiten(){

    }

    public function getTrainingsplaene(){
        $user=$this->getLogedInUserInformation();
        if($user){
            $sql="SELECT * FROM t_trainingsplaene WHERE TrainUserID_FK=". $user[0]['UserID'];
            $result=$this->database->executeWithResult($sql);
        }else{
            $result=false;
        }
        return $result;
    }
    /**
     *
     */
    public function GetSelectedPlan(){
        $session = FWSessionHandler::getInstance();
        if(isset($session->SelectedPlan)){

        }else{
            //Session var is not set. Load the default value
            $user=$this->getLogedInUserInformation();
            if($user) {
                $sql = 'SELECT MAX(TrainID) as count FROM t_trainingsplaene WHERE TrainUserID_FK=' . $session->UserID;
                $result = $this->database->executeWithResult($sql);
                if ($result) {
                    $session->SelectedPlan = $result[0]['count'];
                }else{
                    $session->SelectedPlan=0;
                }
            }
        }
        return $session->SelectedPlan;
    }

    /**
     * @param $Value
     */
    public function setSelectedPlan($Value){
        $session = FWSessionHandler::getInstance();
        $session->SelectedPlan = $Value;
    }
}
?>
