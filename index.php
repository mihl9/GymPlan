<?php
	if (!(session_status() == PHP_SESSION_NONE)) {
    //echo "Ihre Session wurde gestartet!"; // oder was auch immer !!!
	}
	else {
		session_start();
	}
	
	
	//echo sha1("1234");
	header('Content-Type: text/html; charset=UTF-8');
	//check if the Plan change event is activatet
	if(isset($_POST['btnChangePlan'])){
		$_SESSION['SelectedPlan']=$_POST['SelectedPlan'];
	}
	
	if (isset($_GET['content'])) {
	    $content = strtolower(trim($_GET['content']));
	} else {
	    $content = 'uebersicht';
	}
	// Gültige Bereiche definieren
	$pages = array( "uebersicht", "trainingsplaene", "geraete" );

	// Gültigkeit prüfen und ggf Standard setzen
	if ( !in_array( $content, $pages ) )
	    $content = "uebersicht";
	
	//header mit Navigation bar laden
	include_once 'Include/Content/Header.inc.php';
	
?>
	<div id="content">
		<div id="left_content">
<?php
	// Bereich einbinden
	include( "Include/Content/" . $content. ".inc.php" );  
	
?>
		</div>
		<div id="right_content">
			<?php 
			include_once 'Include/boxes/LoginBox.inc.php'; 
			?>
		</div>
	</div>
<?php
	//Fusszeile laden
	include_once 'Include/Content/Footer.inc.php';
?> 