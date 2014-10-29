<?php
//load the abstract classes
include_once('./applikation/controller/AbsController.class.php');
include_once('./applikation/model/AbsModel.class.php');
include_once('./applikation/view/AbsView.class.php');
//Load the LIBs
include_once('./config/Config.php');
include_once('./lib/FWSessionHandler.class.php');
include_once('./lib/DatabaseHandler.class.php') ;


// load MVC
function application_loader ($ControllerName)  {
	$controller = './applikation/controller/'. $ControllerName . '.class.php';
	$model = './applikation/model/'. $ControllerName . '.class.php';
	$view= './applikation/view/'. $ControllerName . '.class.php';
	include_once($controller) ;
	include_once($model) ;
	include_once($view) ;
}

function run($controller, $action){
    if(is_callable($controller,$action)){
        $controller->$action();
    }else{
        $controller->run();
    }

}


// choose which controller should be loaded
if(isset($_GET['controller'])){ 
	$lade = $_GET['controller'];
}else{
	$lade = 'uebersicht';
}

application_loader($lade);
// Create controller and display
$controller   = new controller();

if(isset($_GET['action'])){
    $action = $_GET['action'];
}else{
    $action = "run";
}

//runs the action of the controller
run($controller,$action);

