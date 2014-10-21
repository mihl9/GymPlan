<?php
	$_arr=array();
	$_arr[0][0]="1";
	$_arr[0][1]="Hallo";
	$_arr[0][2]="pw";
	
	$_arr[1][0]="2";
	$_arr[1][1]="Hasdallo";
	$_arr[1][2]="pwsd";
	
	/*echo implode("#",$_arr[0]);
	echo count($_arr);*/
	
	/*$_fp=fopen('../../Include/Daten/test.txt','w');
	fwrite($_fp,implode("#",$_arr[0]) . "\n");
	fwrite($_fp,implode("#",$_arr[1]) . "\n");
	fclose($_fp);*/
	
	include '../functions/User.func.php';
	
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<link rel="stylesheet" href="../../css/bootstrap.css">
		<link rel="stylesheet" href="../../css/Style.css">
		<script type="text/javascript" src="../../js/jquery-2.1.1.js" ></script>
		<script type="text/javascript" src="../../JS/bootstrap.js" ></script>
		
	</head>
	<body>
		<?php  
			echo $_POST['btnEdit'];
			echo $_POST['btnDel'];
		?>
		
		
	</body>
</html>