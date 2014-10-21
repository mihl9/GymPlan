<?php
if (!(session_status() == PHP_SESSION_NONE)) {
    //echo "Ihre Session wurde gestartet!"; // oder was auch immer !!!
	}
	else {
		session_start();
	}
	
include_once 'Include/functions/User.func.php';

	if(_checkSession()==FALSE){
		//include_once 'Include/boxes/LoginBox.inc.php';
		?>
			<div class="alert alert-warning alert-dismissible" role="alert">
			  <!--<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
			  <strong>Achtung!</strong> Diese Seite benötigt ein gültiges Login.
			</div>
		<?php
		//exit;
	}else{
	//include_once 'Include/boxes/LoginBox.inc.php';
	//check witch action should be executed
	if(isset($_POST['btnSave'])){
		if($_POST['btnSave']=="update"){
			//_updateGeraet($_POST['ID'],$_POST['GeraetName'],$_POST['GeraetBeschreibung']);
		}else{
			//_addGeraet($_POST['GeraetName'],$_POST['GeraetBeschreibung']);
		}
	}
	
	if(isset($_POST['btnNew'])){
		$_POST['PlanID']=0;
	}
	
	if(isset($_POST['btnNew']) || isset($_POST['btnEdit'])){
			include 'Include/Content/EditTrainPlan.inc.php';
			echo '<script type="text/javascript">';
			echo "$('#ModalEditTrainPlan').modal('show');";
			echo '</script>';
		}
	
	if(isset($_POST['btnDel'])){
		//_delGeraet($_POST['DataID']);
	}
?>
	<form name="FrmChangePlan" method="post">
		<input type="hidden" name="src" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
		<div class="row">
			<div class="col-xs-3">
				<?php echo _getPlanCombobox(); ?> 
			</div>
			<button type="submit" class="btn btn-default" name="btnChangePlan" value="OK">OK</button>
		</div>
	</form>
	<br/>
<?php
	//Print out the table with the Trainplan Information
	echo _getPlanInformationTab(FALSE);
?>
	<form name="FrmEdit" method="post">
		<input type="hidden" name="src" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
		<input type="hidden" name="PlanID" value="<?php echo $_SESSION['SelectedPlan']; ?>" />
		<div class="row">
			<div class="col-md-1 ">
				<button type="submit" class="btn btn-default" name="btnDel" value="del">Löschen</button>
			</div>
			<div class="col-md-1" style="margin-left: 3.5%;">
				<button type="submit" class="btn btn-default" name="btnNew" value="new">Neu</button>
			</div>
			<div class="col-md-1">
				<button type="submit" class="btn btn-default" name="btnEdit" value="update">Bearbeiten</button>
			</div>
		</div>
	</form>
<?php
	}

?>