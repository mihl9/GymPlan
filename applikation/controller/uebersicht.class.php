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

            }
        }else {
            $this->view->DisplayMessageLabel("Diese Seite benötigt ein gültiges Login.", 2,false,"Content");
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

        $this->run();
    }
}
?>