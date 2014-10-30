<!DOCTYPE html>
<html lang="de">
    <head>
        <link rel="stylesheet" href="public/css/bootstrap.css">
        <link rel="stylesheet" href="public/css/Style.css">
        <link rel="stylesheet" type="text/css" href="public/css/jquery.datetimepicker.css"/ >
        <script type="text/javascript" src="public/JS/jquery-2.1.1.js" ></script>
        <script type="text/javascript" src="public/JS/bootstrap.js" ></script>
        <script src="public/JS/jquery.datetimepicker.js"></script>
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
                            <!--<li <?php if($_GET['controller']=="uebersicht") echo 'class="active"' ?> ><a href="?content=uebersicht">Übersicht</a></li>-->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Übersicht <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="?controller=uebersicht&tab=1">Aktuell</a></li>
                                    <li><a href="?controller=uebersicht&tab=2">Verlauf</a></li>
                                </ul>
                            </li>
                            <li <?php if($_GET['controller']=="trainingsplaene") echo 'class="active"' ?>><a href="?controller=trainingsplaene">Trainingspläne</a></li>
                            <li <?php if($_GET['controller']=="geraete") echo 'class="active"' ?>><a href="?controller=geraete">Geräte</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
            <div id="content">
                <div id="left_content">
                    <?php
                        // Content laden
                        echo $this->content["Content"];
                    ?>
                </div>
                <div id="right_content">
                    <?php
                        echo $this->content["RightBoxes"];
                    ?>
                </div>
            </div>

            <div class="Footer">
                <p> Copyright © 2014 by Michael Huber </p>
            </div>
        </div>
    </body>
</html>

<?php

?>