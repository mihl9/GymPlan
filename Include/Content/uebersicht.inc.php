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
	//check witch action should be executed
	if(isset($_POST['btnSave'])){
		$_count=1;
		$_ArrIndex=0;
		$_TrainSessionArr=array();
		$_TrainSessionArr[0]=$_POST['EinheitID'];
		$_TrainSessionArr[1]=$_POST['EinheitDate'];
		$_ArrIndex=1;
		$_newArrIndex=2;
		while(isset($_POST[$_ArrIndex])){
			if($_count>4){
				$_count=1;
				$_TrainSessionArr[$_newArrIndex]="next";
			}else{
				$_TrainSessionArr[$_newArrIndex]=$_POST[$_ArrIndex];
				$_count++;
				$_ArrIndex++;
			}
			$_newArrIndex++;
		}
		if($_POST['btnSave']=="update"){
			//_updateGeraet($_POST['ID'],$_POST['GeraetName'],$_POST['GeraetBeschreibung']);
			_UpdateTrainSession($_POST['EinheitID'],$_TrainSessionArr);
		}else{
			//_addGeraet($_POST['GeraetName'],$_POST['GeraetBeschreibung']);
			_AddTrainSession($_TrainSessionArr);
		}
	}
	
	if(isset($_POST['btnNew'])){
		unset($_POST['EinheitID']);
	}
	if(isset($_POST['btnNew']) || isset($_POST['btnEdit'])){
			include 'Include/Content/EditEinheiten.inc.php';
			echo '<script type="text/javascript">';
			echo "$('#ModalEditEinheit').modal('show');";
			echo '</script>';
		}
	
	if(isset($_POST['btnDel'])){
		_DelTrainSession($_POST['EinheitID']);
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
	<br />
<?php
	//include_once 'Include/boxes/LoginBox.inc.php';
		$_tabID=1;
		if(isset($_GET['tab'])){
			$_tabID=$_GET['tab'];
		}else{
			$_tabID=1;
		}
		
		if($_tabID==2){
		
			echo _getHistoryTrainSession(TRUE);
?>
	

<?php
		}else{
			echo _getLastTrainSession(TRUE);

		}

	}

?>