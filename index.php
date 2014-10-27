<?php
//Datenbank - Klasse
define('MYSQL_HOST', "localhost");
define('MYSQL_USER' ,"root");
define('MYSQL_PW' ,"");
define('MYSQL_DB', "m151");
include_once('./config/Config.php');
include_once('./lib/DatabaseHandler.php') ;
// MVC laden
function application_loader ($ControllerName)  {  
	$controller = './applikation/controller/'. $ControllerName . '.php';
	$model = './applikation/model/'. $ControllerName . '.php';
	$view= './applikation/view/'. $ControllerName . '.php';
	include_once($controller) ;
	include_once($model) ;
	include_once($view) ;
}
// welcher Controller soll geladen werden
if(isset($_GET['controller'])){ 
	$lade = $_GET['controller'];
}else{
	$lade = 'index';
}
application_loader($lade);
// Controller erstellen und Anzeige
$controller   = new controller(); 
echo $controller->display();  
?>