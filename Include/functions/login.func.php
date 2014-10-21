<?php
	include_once 'DataReader.func.php';
	include_once 'User.func.php';
	if (!(session_status() == PHP_SESSION_NONE)) {
    //echo "Ihre Session wurde gestartet!"; // oder was auch immer !!!
	}
	else {
		session_start();
	}

	if(empty($_POST['name']) || empty($_POST['password']))
	{
		//werte fehlen seite nochmals anzeigen
	  //require '../Content/loginPage.inc.php';
	  // Reset des "ist_eingeloggt"-Flags
	  $_SESSION['ist_eingeloggt']=false;
	  $_SESSION['message']='
	  	<div class="alert alert-warning alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Schliessen</span></button>
			<strong>Achtung!</strong> Benutzername oder Passwort fehlt.
		</div>';
	  
		redirect();
		exit;
	  exit;
	}

	
	$Data = confirmNameAndPassword(trim($_POST['name']),trim($_POST['password']));
	if($Data==FALSE)
	{
	  // Reset des "ist_eingeloggt"-Flags
	  $_SESSION['ist_eingeloggt']=false;
	  $_SESSION['message']='
	  	<div class="alert alert-warning alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Schliessen</span></button>
			<strong>Achtung!</strong> Benutzername oder Kennwort falsch.
		</div>';
	  
	  /*// Abbruch
		echo 	"<div>";
		echo		"Fehler!";
		echo	"</div>";
		die('Zugangsdaten falsch');*/
		redirect();
		exit;
	}
	
		// Ansonsten: Nutzer freischalten
		$_SESSION['ist_eingeloggt']=true;
		$_SESSION['username']=$_POST['name'];
		_LoadUserInformation();
		redirect();
		
	function redirect(){
		// Ziel der Weiterleitung ermitteln:
		$srcURL.=str_replace(array("\r","\n"),'',$_POST['src']); // Zeilenumbrüche könnten XSS ermöglichen - weg damit

		// Umleitung zur aufrufenden Seite:
		header('Location: '.$srcURL);
		return true;
	}
	
	function confirmNameAndPassword($name,$password)
	{		
		$_Result = FALSE;
		_LoadFile('../Daten/Users.csv');
		if(_Find($name,0)){
			if(_read(1)==sha1($password)){
				//$_SESSION['Last_Login']=_read(2);
				$_Result = TRUE;
			}
		}
		_UnloadFile(FALSE);
		return $_Result;
	}
	
?>
