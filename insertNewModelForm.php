<?php
	session_start();
	
	if(!isset($_COOKIE['c_user'])){
		header('Location: index.php');
		exit;
	}
?>
<!DOCTYPE html>
<html>
<!--******JQuery******-->
<script src="./jquery/jquery-1.11.1.min.js"></script>
<script src="./jquery/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./jquery/jquery-ui.css" />
<!--******JQuery******-->
<link rel="stylesheet" type="text/css" href="./css/loginStyle.css" />
<link rel="stylesheet" type="text/css" href="./css/tableStyle.css" />

<body>

<table cellspacing='0'>
<form action="insertNewModel.php" method="post" name="modelForm" id="modelForm">
<thead><th colspan="4">Introduzca nuevo modelo con sufijo</th></thead>
<tr>
   <td>Modelo: <input name="modelo" value="" autofocus="yes" type="text"><br>Sufijo: <input name="sufijo" value="" type="text"></td>
   <td><input type="submit" value="Enviar"></td>
</tr>

</form>
</table>

</body>
</html>
