<!--******JQuery******-->
<script src="./jquery/jquery-1.11.1.min.js"></script>
<script src="./jquery/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./jquery/jquery-ui.css" />
<!--******JQuery******-->
<?php
	session_start();
	
	if(!isset($_COOKIE['c_user'])){
		header('Location: index.php');
		exit;
	}

	mysql_query("SET AUTOCOMMIT=0");
	
	$tempModelo = $_POST['modelo'];
	
	if(substr($tempModelo, 0, 2) != "LG" && substr($tempModelo, 0, 3) != "HBS" && substr($tempModelo, 0, 2) != "LM")
		$tempModelo = "LG".$_POST['modelo'];
		
	if(strlen($_POST['sufijo']) == "5")
		$modelo = $tempModelo.".A".$_POST['sufijo'];
	else{
		$tempSufijo = substr($_POST['sufijo'], 1);
		$modelo = $tempModelo.".A".$tempSufijo;
	}
	
include_once(".htconnection.php");
$resultMOD= mysql_query("SELECT modelo FROM t_models WHERE modelo = '".$modelo."'") or die(mysql_error());

if(mysql_num_rows($resultMOD) > 0){ ?>
	<!DOCTYPE html>
	<html>
	<link rel="stylesheet" type="text/css" href="./css/loginStyle.css" />
	<link rel="stylesheet" type="text/css" href="./css/tableStyle.css" />
	<body>
	<table class="selectTool">
	<tr>
		<td colspan="3">ERROR: El modelo ya existe en la base de datos</td>
		<td></td>
		<td></td>

	</tr>
	</table>
	</body>
	</html>
<?php
}
else{ 
mysql_query("INSERT INTO t_models (modelo) VALUES ('".$modelo."')") or die(mysql_error());
if (!mysql_errno())
	mysql_query("COMMIT");
else
	mysql_query("ROLLBACK");
?>
	<!DOCTYPE html>
	<html>
	<link rel="stylesheet" type="text/css" href="./css/loginStyle.css" />
	<link rel="stylesheet" type="text/css" href="./css/tableStyle.css" />
	<body>
	<table class="selectTool">
	<tr>
		<td colspan="3"><?php echo "El modelo ".$modelo." ha sido correctamente introducido en la base de datos"; ?></td>
		<td></td>
		<td></td>

	</tr>
	</table>
	</body>
	</html>
<?php
}
?>
