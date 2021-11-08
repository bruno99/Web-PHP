
<meta http-equiv="Pragma" content="no-cache">
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
<link rel="stylesheet" type="text/css" href="./jquery/jquery-ui.css" />
<!--******JQuery******-->
<script src="./js/Hover.js"></script>
<div id="descriptionBoxes"></div>
    <script>
    $(function(){
      $("#descriptionBoxes").load("descBox.html");
	  $("#mainMenu").load("newMenu.html");
    });
</script>
<?php
include_once(".htconnection.php");
$rowNombre = mysql_fetch_array(mysql_query("SELECT name FROM t_users WHERE user = '".$_COOKIE['c_user']."' "));

//Contador DR para mostrar la cantidad en el menú desplegable
$total = mysql_result(mysql_query("SELECT COUNT(*) FROM t_storage WHERE estado='CRT'"),0);
$totalACP = mysql_result(mysql_query("SELECT COUNT(*) FROM t_storage WHERE estado='ACP' AND f_recibido<>'0000-00-00'"),0);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="./css/loginStyle.css" />
<link rel="stylesheet" type="text/css" href="./css/tableStyle.css" />
<link rel="stylesheet" type="text/css" href="./css/Hover.css" />
	<link rel="icon"
      type="image/gif"
      href="img/favicon.gif">

<!--*****Menú*****-->
<meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="./css/stylesMenu.css">
   <script src="./js/scriptMenu.js"></script>
<!--*****Menú*****-->
</head>
<body>

<!--*****Menú*****-->
<div id='cssmenu'>
<ul>
   <li class='active'><a href="javascript:loadContent('home.php');">Home</a></li>
   <li class='has-sub'><a href='#'>IMEI Tools</a>
      <ul>
         <li><a href="javascript:loadContent('getIMEIinfo.php');">IMEI Info</a></li>
         <li><a href="imei2barcode.php" target="_blank">IMEI to Barcode</a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'>Abonos</a>
      <ul>
         <li class='has-sub'><a href='#'>Listado</a>
			<ul>
				<li><a href="./abonos/listadoAbonos.php" target="_blank">Pendientes</a></li>
				<li><a href="./abonos/listadoAbonados.php" target="_blank">Abonados</a></li>
			</ul>
		 </li>
		 <li class='has-sub'><a href='#'>Insertar</a>
			<ul>
				<li><a href="#" onclick="javascript:window.open('./abonos/uploadAbonoFile.php','InOutUnits','scrollbars=1,width=650,height=450')">Fich. nuevos abonos</a></li>
				<li><a href="#" onclick="javascript:window.open('./abonos/uploadAbonoAbonado.php','InOutUnits','scrollbars=1,width=650,height=400')">Fichero abonados</a></li>
			</ul>
		 </li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'>Herramientas DR</a>
      <ul>
         <li><a href='viewerDr.php?show=CRT' target='_blank'>Pending CRT (<?php echo $total ?>)</a></li>
         <li><a href='viewerDr.php?show=ACP' target='_blank'>Pending ACP (<?php echo $totalACP ?>)</a></li>
         <li class='has-sub'><a href='#'>Insertar DR</a>
            <ul>
               <li><a href="drForm.php" target="_blank">Manual</a></li>
               <li><a href="#" onclick="javascript:window.open('uploadDrFile.php','Insertar DR fichero','width=750,height=500')">Fichero</a></li>
            </ul>
         </li>
         <!--<li><a href="#" onclick="javascript:window.open('insertIMEI.php','Insertar IMEIs','scrollbars=1,width=600,height=600')">Insertar IMEIs</a></li>-->
         <li><a href="#" onclick="javascript:window.open('insertIMEInew.php','[New] Insertar IMEIs','scrollbars=1,width=1600,height=800')">[New] Insertar IMEIs</a></li>
         <li><a href="#" onclick="javascript:window.open('uploadRmaFile.php','Insertar RMAs','scrollbars=1,width=800,height=400')">Insertar RMAs</a></li>
         <li><a href="#" onclick="javascript:window.open('insertNewModelForm.php','Insertar modelo','scrollbars=1,width=800,height=300')">Insertar modelo</a></li>
         <li><a href='javascript:checkReception()'>Check recepciones</a></li>
         <li class='has-sub'><a href='#'>Exportar</a>
            <ul>
               <li><a href='exportToExcel.php?type=all'>Todo</a></li>
               <li><a href='exportToExcel.php?type=crt'>Creados</a></li>
               <li><a href='exportToExcel.php?type=pnd'>Pendientes</a></li>
               <li><a href='exportToExcel.php?type=acp'>Aceptados</a></li>
               <li><a href='exportToExcel.php?type=err'>Err&oacute;neos</a></li>
               <li><a href="#" onclick="javascript:window.open('askForDate.php','Seleccionar rango de fechas','scrollbars=1,width=800,height=400')">Envialia</a></li>
               <li><a href="#" onclick="javascript:window.open('askForDateDR.php','Seleccionar fecha','scrollbars=1,width=800,height=400')">Sel. Fecha</a></li>
            </ul>
         </li>
         <li><a href='seekDr.php' target='_blank'>Buscar</a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'>ASC / DSC</a>
      <ul>
         <li><a href="#" onclick="javascript:window.open('../sds/php/formUploadPartsPedidos.php','Subida parte pedido','scrollbars=1,width=600,height=400')">Subir parte pedido</a></li>
         <li><a href="#" onclick="javascript:loadContent('llegadaParts.php');">Llegada parts</a></li>
         <li><a href="#" onclick="javascript:window.open('changeStatus.php','Cambiar estado','scrollbars=1,width=900,height=500')">Cambiar estado</a></li>
      </ul>
   </li>
	<li class='no-sub'><a href='./avisosrep/php/index.php' target="_blank">Av. reparaci&oacute;n</a></li>
	<li class='no-sub'><a href='./warehouse' target="_blank">Warehouse</a></li>
   <!-- <li class='no-sub'><a href='./satreport/' target="_blank">Satreport</a></li> -->
   
   <li><a href='logout.php'><div class="logout">Logout</div></a></li>
   <?php for ($i=0;$i<10;$i++) echo "<li>&nbsp;</li>"; ?> <!-- Espaciado forzado entre elementos -->
	<li><?php echo "Logueado como<br>".$rowNombre['name'] ?></li>
	<?php for ($i=0;$i<10;$i++) echo "<li>&nbsp;</li>"; ?>
	<li><?php echo jddayofweek ( cal_to_jd(CAL_GREGORIAN, date("m"),date("d"), date("Y")) , 1 ) . " ". date('d/m/Y') . "<br>Semana W_".date("W"); ?><br /><div id="clock"></div></li>
</ul>
</div>
<!--*****Menú*****-->
<div id="mainContent">
</div>


</body>
</html>

<script>

function loadContent(file){
	//document.getElementById("mainContent").innerHTML = load(file);
	$('#mainContent').load(file);
}

function checkReception() {
   $.ajax({
       url: 'checkReception.php?callFunction=true',
       success: function(data){
			alert("Chequeo de coincidencias de IMEIs y DRs completado");
       }
    });
}
</script>
<script src="./js/dailyBackground.js"></script>
<script src="./js/realtimeClock.js"></script>
<script>
$(document).ready(function()
{
	loadContent('home.php');
	setInterval('updateClock()', 1000);
});
</script>
<script>

</script>



?>
