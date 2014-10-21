<?php
	//session_name('PHPSESSID');
	if (!(session_status() == PHP_SESSION_NONE)) {
    //echo "Ihre Session wurde gestartet!"; // oder was auch immer !!!
	}
	else {
		session_start();
	}
	header('Content-Type: text/html; charset=UTF-8');
	
	include_once 'Include/functions/User.func.php';
	include_once 'Include/functions/DataReader.func.php';
		
	$message='';
	
	if(isset($_SESSION['message'])){
		$message=$_SESSION['message'] . "<br/>";
		unset($_SESSION['message']);
	}
	
	echo $message;
	
	if(_checkSession()){
		$_SaveMode="new";
		//Check if it has an datarow ID
		$_ID=0;
		$_AddRows=0;
		if(isset($_POST['PlanID'])){
			if($_POST['PlanID']!=0){
				//Load the Data
				$_ID=$_POST['PlanID'];
				
				$_SaveMode="update";
			}else{
				$_AddRows=1;
			}
		}
		//load a empty entry
?>

<div class="modal fade" id="ModalEditTrainPlan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Trainingsplan</h4>
			</div>
			<div class="modal-body">
				<?php echo _getEditPlanTab($_ID,$_AddRows); ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Schliessen</button>
				<button type="submit" form="FrmEditPlan" class="btn btn-primary" name="btnSave" value="<?php echo $_SaveMode; ?>">Speichern</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
	}else{
?>
		<div class="alert alert-warning alert-dismissible" role="alert">
			<strong>Achtung!</strong> Diese Seite benötigt ein gültiges Login.
		</div>
<?php
	}
?>