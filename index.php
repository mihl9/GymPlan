<?php
//Loads the LIBs
include_once('./config/Config.php');
include_once('./lib/DatabaseHandler.class.php') ;
include_once('./lib/SessionHandler.class.php');

// MVC laden
function application_loader ($ControllerName)  {  
	$controller = './applikation/controller/'. $ControllerName . '.class.php';
	$model = './applikation/model/'. $ControllerName . '.class.php';
	$view= './applikation/view/'. $ControllerName . '.class.php';
	include_once($controller) ;
	include_once($model) ;
	include_once($view) ;
}

// choose which controller shoudl be loaded
if(isset($_GET['controller'])){ 
	$lade = $_GET['controller'];
}else{
	$lade = 'uebersicht';
}

application_loader($lade);
// Create controller and display
$controller   = new controller(); 
echo $controller->display();  
?>