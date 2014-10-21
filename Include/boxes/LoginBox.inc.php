<?php
	//session_name('PHPSESSID');
	if (!(session_status() == PHP_SESSION_NONE)) {
    //echo "Ihre Session wurde gestartet!"; // oder was auch immer !!!
	}
	else {
		session_start();
	}
	
	$message='';
	
	if(isset($_SESSION['message'])){
		$message=$_SESSION['message'] . "<br/>";
		unset($_SESSION['message']);
	}
	
	if (isset($_SESSION['ist_eingeloggt']))
   {
		if(!$_SESSION['ist_eingeloggt']){ 
?>
				<div class="box">
                    <div class="box_headline"><div class="box_headline_text">Login</div></div>
                    <div class="box_content">
						<form name="FrmLogin" action="Include/functions/login.func.php" method="post">
							<?php echo $message; ?>
							<fieldset>
								<!--<span class="input-group-addon">@</span>-->
								<input type="text" name="name" class="form-control" placeholder="Benutzername" required="">
								<br />
								<!--<span class="input-group-addon">@</span>-->
								<input type="password" name="password" class="form-control" placeholder="Passwort" required="">
								<br />
								<!--<input type="hidden" name="src" value="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>" />-->
								<input type="hidden" name="src" value="<?php echo ''.$_SERVER['REQUEST_URI']; ?>" />
								<button type="submit" class="btn btn-default" name="btnLogin" value="Login">Login</button>
							</fieldset>
						</form>
					</div>
                    <div class="clear"></div>
                </div>
<?php
		}else{
?> 
				<div class="box">
                    <div class="box_headline"><div class="box_headline_text">Eingeloggt</div></div>
                    <div class="box_content">
						<form name="FrmLogin" action="Include/functions/logout.func.php" method="post">
							<fieldset>
								<div class="panel-body" style="text-align: left;">
    								<strong>Willkommen, <?php echo $_SESSION['username']; ?></strong>
    								<br />
    								<br />
    								Letztes Login erfolgte am: <?php echo '<br />' . $_SESSION['Last_Login']; ?>
  								</div>
								<br />
								<!--<input type="hidden" name="src" value="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>" />-->
								<input type="hidden" name="src" value="<?php echo ''.$_SERVER['REQUEST_URI']; ?>" />
								<button type="submit" class="btn btn-default" name="btnLogout" value="Login">Ausloggen</button>
							</fieldset>
						</form>
					</div>
                    <div class="clear"></div>
                </div>
<?php
		}
	} else {
		$_SESSION['ist_eingeloggt']=false;
?>
				<div class="box">
                    <div class="box_headline"><div class="box_headline_text">Login</div></div>
                    <div class="box_content">
						<form name="FrmLogin" action="Include/functions/login.func.php" method="post">
							<?php echo $message; ?>
							<fieldset>
								<!--<span class="input-group-addon">@</span>-->
								<input type="text" name="name" class="form-control" placeholder="Benutzername" required="">
								<br />
								<!--<span class="input-group-addon">@</span>-->
								<input type="password" name="password" class="form-control" placeholder="Passwort" required="">
								<br />
								<!--<input type="hidden" name="src" value="<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>" />-->
								<input type="hidden" name="src" value="<?php echo ''.$_SERVER['REQUEST_URI']; ?>" />
								<button type="submit" class="btn btn-default" name="btnLogin" value="Login">Login</button>
							</fieldset>
						</form>
					</div>
                    <div class="clear"></div>
                </div>
<?php
	}
	//session_write_close();
?>