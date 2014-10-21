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
		if($_POST['btnSave']=="update"){
			_updateGeraet($_POST['ID'],$_POST['GeraetName'],$_POST['GeraetBeschreibung']);
		}else{
			_addGeraet($_POST['GeraetName'],$_POST['GeraetBeschreibung']);
		}
	}
	if(isset($_POST['btnNew']) || isset($_POST['btnEdit'])){
			include 'Include/Content/EditGeraete.inc.php';
			echo '<script type="text/javascript">';
			echo "$('#ModalEditGeraete').modal('show');";
			echo '</script>';
		}
	
	if(isset($_POST['btnDel'])){
		_delGeraet($_POST['DataID']);
	}
	//include_once 'Include/boxes/LoginBox.inc.php';
	echo _getGeraeteTab();
	/*echo $_POST['btnNew'];
	echo $_POST['btnEdit'];
	/*echo $_POST['btnDel'];
	echo $_POST['SelectedPlan'];*/
	/*<?php echo _getPlanCombobox(); ?>*/
?>
	<form name="FrmEdit" method="post">
		<input type="hidden" name="src" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
		<button type="submit" class="btn btn-default" name="btnNew" value="new">Neu</button>
	</form>
<?php
	
	}

?>