<?php
class model extends AbsModel
{

    public function __construct(){
        parent::__construct();
    }

    public function getCurrentEinheit(){
        $user=$this->getLogedInUserInformation();
        if($user) {
            $sql = 'SELECT * FROM t_einheit WHERE EinheitTrinID_FK='. $this->GetSelectedPlan() .' order by EinheitDatum DESC Limit 1;';
            $result = $this->database->executeWithResult($sql);
            if($result) {
                $result[0]['Uebungen'] = $this->getEinheitUebungen($result[0]['EinheitID']);
            }
        }
        return $result;
    }

    private function getEinheitUebungen($EinheitID){
        $sql = 'SELECT * FROM t_uebungen inner join t_geraete on t_uebungen.UebGeraeteID_FK=t_geraete.GeraeteID WHERE UebEinheitID_FK='.$EinheitID;
        $result=$this->database->executeWithResult($sql);
        return $result;
    }

    private  function getTrainPlanUebungen($TrainPlanID){
        $sql = 'SELECT * FROM t_uebungen inner join t_geraete on t_uebungen.UebGeraeteID_FK=t_geraete.GeraeteID WHERE UebTrainID_FK='.$TrainPlanID;
        $result=$this->database->executeWithResult($sql);
        return $result;
    }
    public function getHistoryEinheiten(){
        $user=$this->getLogedInUserInformation();
        if($user) {
            $sql = 'SELECT * FROM t_einheit WHERE EinheitTrinID_FK='. $this->GetSelectedPlan() .' order by EinheitDatum DESC;';
            $result = $this->database->executeWithResult($sql);
            if($result) {
                $count=0;
                foreach($result as $row) {
                    $result[$count]['Uebungen'] = $this->getEinheitUebungen($row['EinheitID']);
                    $count++;
                }
            }
        }
        return $result;
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

    public function getNewEinheit(){
        $result = $this->getCurrentEinheit();
        if($result){
            $result[0]['EinheitID']=0;
            $result[0]['EinheitTrinID_FK']=$this->GetSelectedPlan();
            $result[0]['EinheitDatum']=date("Y-m-d h:i", time());
        }else{
            $result=array();
            $result[0]=array();
            $result[0]['EinheitID']=0;
            $result[0]['EinheitTrinID_FK']=$this->GetSelectedPlan();
            $result[0]['EinheitDatum']=date("Y-m-d h:i", time());
            $result[0]['Uebungen']=$this->getTrainPlanUebungen($this->GetSelectedPlan());
        }
        return $result[0];
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

    public function getEinheit($EinheitID){
        $user=$this->getLogedInUserInformation();
        if($user) {
            $sql = 'SELECT * FROM t_einheit WHERE EinheitTrinID_FK='. $user[0]['UserID'] .' AND EinheitID='. $EinheitID .';';
            $result = $this->database->executeWithResult($sql);
            if($result) {
                $result[0]['Uebungen'] = $this->getEinheitUebungen($result[0]['EinheitID']);
            }
        }
        return $result;
    }

    public function addEinheit($Data){

    }

    public function delEinheit($EinheitID){
        $user=$this->getLogedInUserInformation();
        if($user) {
            $sql = "DELETE FROM t_einheit WHERE EinheitID=". $EinheitID;
            $this->delUebung("UebEinheitID=".$EinheitID);
            $this->database->execute($sql);
        }
    }

    public function UpdateEinheit($Data){

    }

    private function addUebung($data){
        $user=$this->getLogedInUserInformation();
        if($user) {

        }
    }

    private function delUebung($Where){
        $user=$this->getLogedInUserInformation();
        if($user) {
            $sql='DELETE FROM t_uebungen WHERE'. $Where;
            $this->database->execute($sql);
        }
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
