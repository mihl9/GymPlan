<?php
	//session_start();
	//session_name('PHPSESSID');
	if (!(session_status() == PHP_SESSION_NONE)) {
    //echo "Ihre Session wurde gestartet!"; // oder was auch immer !!!
	}
	else {
		session_start();
	}
		if(empty($_SESSION))
		{
		  
		} else {
			$_SESSION['ist_eingeloggt']=false;
			$_SESSION['username']='';
			$_SESSION=array();
			session_destroy();
		}
		// Ziel der Weiterleitung ermitteln:
		//session_write_close();
		$srcURL.=str_replace(array("\r","\n"),'',$_POST['src']);
		// Umleitung zur aufrufenden Seite:
		header('Location: '.$srcURL);
?>