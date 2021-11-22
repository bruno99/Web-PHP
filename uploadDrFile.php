<?php

	session_start();

	if(!isset($_COOKIE['c_user'])){
		header('Location: index.php');
		exit;
	}
?>

<script src="./jquery/jquery-1.11.1.min.js"></script>
<script src="./jquery/jquery-ui.js"></script>
<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="./css/Style.css" />
<
<html>
<head>
    <title>Subir fichero DR</title>
</head>

<body>
<table class="ventana">
<tr>
<th>Seleccione el fichero de DRs que desea cargar en la base de datos (Pulse una sola vez sobre Enviar, y espere)</th>
</tr>
<form 
      $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objReader->setReadDataOnly(true); //No se leen propiedades, solo los datos
	
$arrayColumn = ['B', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q'];

	//Se calcula el número de filas que contienen datos
$contador = 3;
$newCell = "E2";
$currentCell = $sheet->getCell($newCell)->getValue();
do{
  $newCell = "E".$contador;
  $contador++;
}while(!is_null($currentCell = $sheet->getCell($newCell)->getValue()));

$contador = $contador - 2; //Número máximo de filas (descontando cabecera y fin) real

if($errorFlag == false){
  mysql_query("COMMIT");
  $echoContador = $contador - 1;
  echo "<br><strong>".$echoContador." DR del fichero insertados satisfactoriamente en la base de datos. Ya puede cerrar esta ventana</strong><br>";
	else{
	 echo "<br><br><strong><h2>ERROR: Se ha producido un error subiendo el fichero de los DR</h2></strong><br>";
	}
	}
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

<script>
$("#sendFile").click(function(){
	$('#formFile').submit();
});


</script>
