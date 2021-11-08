<?php

include_once(".htconnection.php");

?>
<!--******JQuery******-->
<script src="./jquery/jquery-1.11.1.min.js"></script>
<script src="./jquery/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./jquery/jquery-ui.css" />
<!--******JQuery******-->

<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="./css/tableStyle.css" />
<link rel="stylesheet" type="text/css" href="./css/loginStyle.css" />

<html>
<body>
<table class="ventana">
<tr>
	<th>S&oacute;lo un IMEI por l&iacute;nea</th>
	<th>Comentarios</th>
</tr>
<form action="uploadImeis.php" method="post">
	<tr>
		<td><textarea id="campoImeis" name="imeis" rows="25" autofocus="yes"></textarea></td>
		<td><textarea id="comentarios" name="comentarios" rows="10" cols="25" placeholder="Los comentarios se almacenar&aacute;n para todos los IMEI escritos"></textarea></td>
	</tr>
	<tr><td colspan="2"><button type="submit">Insertar IMEIs</button></td></tr>
</form>
</table>
</body>
</html>
<script src="./js/dailyBackground.js"></script>
<script>
//Live UpperCase
$(document).ready(function() { //Las tablets con "lg" en minúscula no coincidían con los DR y se encontraban como no recibidas
    $('#campoImeis').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });
});
</script>
