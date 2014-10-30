<?php
class controller extends AbsController{

    public function run(){
        if($this->checkIfLogedIn(true)){
            $this->view->DisplayTrainPlanCombobox($this->model->getTrainingsplaene(),$this->model->GetSelectedPlan());
            if(isset($_GET['tab'])){
                $tab=$_GET['tab'];
            }else{
                $tab=1;
            }
            if($tab==1){
                $this->view->DisplayEinheit($this->model->getCurrentEinheit());
            }else{
                $this->view->DisplayEinheit($this->model->getHistoryEinheiten());
            }
        }else {
            $this->view->DisplayMessageLabel("Diese Seite benötigt ein gültiges Login.", 2,false, "Content");
        }
        $this->view->setTemplate("simple");
        echo $this->view->getTemplateContent();
    }

    public function changePlan(){
        if(isset($_POST['SelectedPlan'])){
            $this->model->setSelectedPlan($_POST['SelectedPlan']);
        }
        $this->reload();
    }

    public function editEinheit(){
        if(isset($_POST['btnDel'])){
            $this->model->delEinheit($_POST['EinheitID']);
            $this->reload();
        }elseif(isset($_POST['btnEdit'])){
            $this->view->showEinheitenDialog($this->model->getEinheit($_POST['EinheitID'])[0],"Einheit bearbeiten",true);
            $this->view->showModalWindow();
            $this->run();
        }elseif(isset($_POST['btnNew'])){
            $this->view->showEinheitenDialog($this->model->getNewEinheit(),"Neue Einheit",true);
            $this->view->showModalWindow();
            $this->run();
        }elseif(isset($_POST['btnSaveChanges'])){
            $data=array();
            $data['EinheitID']=$_POST['EinheitID'];
            $data['EinheitTrinID_FK']=$this->model->GetSelectedPlan();
            $data['EinheitDatum']=$_POST['EinheitDate'];
            $count=0;
            $i=0;
            //$data['Uebungen']=$this->getTrainPlanUebungen($this->GetSelectedPlan());
            $data['Uebungen'] = array();
            while(isset($_POST[$count])){
                $data['Uebungen'][$i]['UebEinheitID_FK']=$_POST['EinheitID'];
                $data['Uebungen'][$i]['UebGeraeteID_FK']=$_POST[$count];
                $count++;
                $data['Uebungen'][$i]['UebGewicht']=$_POST[$count];
                $count++;
                $data['Uebungen'][$i]['UebWiederholungen']=$_POST[$count];
                $count++;
                $data['Uebungen'][$i]['UebSaetze']=$_POST[$count];
                $count++;
                $data['Uebungen'][$i]['UebID']=$_POST[$count];
                $count++;
                $i++;
            }
            if($data['EinheitID']==0) {
                $this->model->addEinheit($data);
            }else {
                $this->model->UpdateEinheit($data);
            }
            $this->reload();
        }else{
            $this->reload();
        }


    }
}
?>