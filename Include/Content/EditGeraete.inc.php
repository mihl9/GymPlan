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
		$_GerName="";
		$_GerBez="";
		$_SaveMode="new";
		//Check if it has an datarow ID
		if(isset($_POST['DataID'])){
			//Load the Data
			$_GeraetArray=_getGeraeteInfo($_POST['DataID']);
			$_GerName=$_GeraetArray[0];
			$_GerBez=$_GeraetArray[1];
			$_SaveMode="update";
		}
		//load a empty entry
?>

<div class="modal fade" id="ModalEditGeraete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Ger&auml;t</h4>
			</div>
			<div class="modal-body">
				<form role="form" name="FrmEditGeraete" id="FrmEditGeraete" method="post">
					<input type="hidden" name="ID" value="<?php echo $_GerName; ?>" />
					
			  		<div class="form-group">
						<label for="GeraetName">Name</label>
			    		<input type="text" class="form-control" id="GeraetName" name="GeraetName" required placeholder="Namen eingeben" value="<?php echo $_GerName; ?>">
					</div>
					<div class="form-group">
						<label for="GeraetBeschreibung">Bezeichnung</label>
			    		<!--<input type="text" class="form-control" id="GeraetBeschreibung" placeholder="Beschreibung eingeben">-->
			    		<textarea class="form-control" name="GeraetBeschreibung" id="GeraetBeschreibung" rows="3" maxlength="50"><?php echo $_GerBez; ?></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Schliessen</button>
				<button type="submit" form="FrmEditGeraete" class="btn btn-primary" name="btnSave" value="<?php echo $_SaveMode; ?>">Speichern</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
	}else{
?>
		<div class="alert alert-warning alert-dismissible" role="alert">
			<!--<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
			<strong>Achtung!</strong> Diese Seite benötigt ein gültiges Login.
		</div>
<?php
	}
?>