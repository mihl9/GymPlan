<?php
class view extends AbsView{
	public function __construct() {

	}

    public function DisplayEinheit($data){
        if(isset($this->content['PlanCombobox'])){
            $result=$this->content['PlanCombobox'];
        }

        if(!empty($data)) {
            foreach ($data as $row) {
                $result.="<p>Trainingseintrag vom: ". date("d.m.Y h:i",strtotime($row['EinheitDatum']))."</p>";
                $result.='<table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Gerät</td>
                                    <td>Gewicht (KG)</td>
                                    <td>Wiederholung</td>
                                    <td>Sätze</td></tr>
			                </thead>
			                <tbody>';
                foreach($row['Uebungen'] as $rowUebung){
                    $result.='<tr>';
                    $result.='<td>'.$rowUebung['GerateName'].'</td>';
                    $result.='<td>'.$rowUebung['UebGewicht'].'</td>';
                    $result.='<td>'.$rowUebung['UebWiederholungen'].'</td>';
                    $result.='<td>'.$rowUebung['UebSaetze'].'</td>';
                    $result.='</tr>';
                }

                $result.='</tbody></table>';
                $result.='<form name="FrmEdit" action="?controller=' . $_GET['controller'] . '&action=editEinheit" method="post">
				<input type="hidden" name="EinheitID" value="' . $row['EinheitID'] . '" />
				<div class="row">
					<div class="col-md-1 ">
						<button type="submit" class="btn btn-default" name="btnDel" value="del">Löschen</button>
					</div>
					<div class="col-md-1" style="margin-left: 3.5%;">
						<button type="submit" class="btn btn-default" name="btnEdit" value="edit">Bearbeiten</button>
					</div>
					<div class="col-md-1" style="margin-left: 5%;">
						<button type="submit" class="btn btn-default" name="btnNew" value="new">Neu</button>
					</div>
				</div>
			</form>';

            }
        }else{
            $result.=$this->DisplayMessageLabel("Keine daten vorhanden.",3,false,"");
            $result.="<p>Keine Einträge vorhanden </p>";
            $result.='<table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Gerät</td>
                                    <td>Gewicht (KG)</td>
                                    <td>Wiederholung</td>
                                    <td>Sätze</td></tr>
			                </thead>
			                <tbody>';
            $result.='</tbody></table>';
            $result.='<form name="FrmEdit" action="?controller=' . $_GET['controller'] . '&action=editEinheit" method="post">
				<div class="row">
					<div class="col-md-1 ">
						<button type="submit" class="btn btn-default" name="btnDel" disabled="disabled" value="del">Löschen</button>
					</div>
					<div class="col-md-1" style="margin-left: 3.5%;">
						<button type="submit" class="btn btn-default" name="btnEdit" disabled="disabled" value="edit">Bearbeiten</button>
					</div>
					<div class="col-md-1" style="margin-left: 5%;">
						<button type="submit" class="btn btn-default" name="btnNew" value="new">Neu</button>
					</div>
				</div>
			</form>';
        }
        $this->setContent("Content",$result);
    }

    public function DisplayHistoryEinheit($data){

    }

    public function DisplayTrainPlanCombobox($data,$_Selection){
        $_ObjID="SelectedPlan";
        if($data){
            $_result='<form name="FrmChangePlan" action="?controller='. $_GET['controller'] .'&action=changePlan" method="post">
                        <div class="row">
                            <div class="col-xs-3">';
            $_result.='<select name="' . $_ObjID . '" class="form-control">';
            foreach($data as $row){
                if($row['TrainID']==$_Selection){
                    $_result= $_result . '<option selected value="' . $row['TrainID'] . '"  >' . $row['TrainName'] . '</option>';
                }else{
                    $_result= $_result . '<option value="' . $row['TrainID'] . '"  >' . $row['TrainName'] . '</option>';
                }
            }
            $_result =$_result . '</select>
                        </div>
                        <button type="submit" class="btn btn-default" name="btnChangePlan" value="OK">OK</button>
                    </div>
                </form>
                <br/>';
        }else{
            $_result="Keine Daten vorhanden";
        }
        $this->setContent('PlanCombobox',$_result);
        //return $_result;
    }

    public function setTemplate($template){
        $templatePath=$this->path . '/' . $template . '.php';
        if(file_exists($templatePath)){
            $this->Template = $templatePath;
        }
    }

}
?>
