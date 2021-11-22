<?php

	session_start();

	if(!isset($_COOKIE['c_user'])){
		header('Location: index.php');
		exit;
	}
?>
<!--******JQuery******-->
<script src="./jquery/jquery-1.11.1.min.js"></script>
<script src="./jquery/jquery-ui.js"></script>
<!--******JQuery******-->
<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="./css/tableStyle.css" />
<link rel="stylesheet" type="text/css" href="./css/loginStyle.css" />
<html>
<head>
    <title>Subir fichero DR</title>
</head>

<body>
<table class="ventana">
<tr>
<th>Seleccione el fichero de DRs que desea cargar en la base de datos (Pulse una sola vez sobre Enviar, y espere)</th>
</tr>
<form id="formFile" action="./uploadDrFileProcess.php" method="post" enctype="multipart/form-data">
    <tr><td><label for="file">Fichero:</label><input type="file" name="file" id="file"></tr></td>
</form>
<tr><td><input id="sendFile" type="button" value="Enviar"></tr></td>
<tr>
<th><div id="loading" align="center">Si no dispone de la plantilla de subida de DR, puede descargarla pulsando en la imagen. No elimine ni a&ntilde;ada ninguna columna.</div></th>
</tr>
<tr>
<td><a href="./file/DR_UPLOAD_TEMPLATE.xlsx"><img src="./img/excel_icon.png" width=30px></a></td>
</tr>
</table>
</body>
</html>
<script src="./js/dailyBackground.js"></script>
<script>
$("#sendFile").click(function(){
	$('#formFile').submit();
	$('.ventana').html("<th>Este programa recupera el N&ordm; de serie y modelo por XML, por lo que puede llevar un rato la carga de todos los DR<br><br><div align='center'><img src='./img/loading.gif' width=250px></div></th>");
});
	//$('#loading').html("Este programa recupera el N. de serie y modelo por XML, por lo que puede llevar un rato la carga de todos los DR.");


</script>
