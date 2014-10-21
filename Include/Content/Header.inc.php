<?php

?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/Style.css">
		<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/ >
		<script type="text/javascript" src="JS/jquery-2.1.1.js" ></script>
		<script type="text/javascript" src="JS/bootstrap.js" ></script>
		<script src="JS/jquery.datetimepicker.js"></script>
		<link rel="shortcut icon" href="favicon.ico" type="image/icon">
		<link rel="icon" href="favicon.ico" type="image/icon">
	</head>
	<body>
		<div class="Window">
			<div class="banner">
	           
	        </div>
	        <nav class="navbar navbar-default" role="navigation">
  				<div class="container-fluid">
				    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
				    	
				    </div>
				   	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
							<!--<li <?php if($content=="uebersicht") echo 'class="active"' ?> ><a href="?content=uebersicht">Übersicht</a></li>-->
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Übersicht <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="?content=uebersicht&tab=1">Aktuell</a></li>
									<li><a href="?content=uebersicht&tab=2">Verlauf</a></li>
								</ul>
							</li>
							<li <?php if($content=="trainingsplaene") echo 'class="active"' ?>><a href="?content=trainingsplaene">Trainingspläne</a></li>
							<li <?php if($content=="geraete") echo 'class="active"' ?>><a href="?content=geraete">Geräte</a></li>
						</ul>
					</div><!-- /.navbar-collapse -->
  				</div><!-- /.container-fluid -->
			</nav>
<?php

?>