<?php

	session_start();

	if(!isset($_COOKIE['c_user'])){
		header('Location: index.php');
		exit;
	}

	if(!empty($_GET['rma']))
		$rmaRef = $_GET['rma'];
	else
		$rmaRef = "";
?>
<!DOCTYPE html>
<html>
<script src="./jquery/jquery-1.11.1.min.js"></script>
<script src="./jquery/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./jquery/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="./css/loginStyle.css" />
<link rel="stylesheet" type="text/css" href="./css/tableSeek.css" />

<body>
<div class="cabecera">
<table cellspacing="0">

<thead><th colspan="5">Introduzca RMA, RNE (N&uacute;m. ref), IMEI, SN, modelo o MC/SD/FO para buscar DR en la base de datos</th></thead>
<tr>
   <td align="center"><span class="centrado">Datos de entrada</span></td>
   <td align="center">&iquest;ENCONTRADO?</td>
   <td rowspan="2"><input type="button" onclick="javascript:locateDr()" value="Realizar b&uacute;squeda" id="search"></td>
</tr>
<tr>
	<td align="center"><input id="datos" name="datos" value="<?php echo $rmaRef ?>" autofocus="yes" type="text" class="inputAct"></td>
	<td><div id="encontrado"></div></td>

</tr>
</table>
</div>

<div id="result" class="datagrid"></div>

</body>

<script>
	function locateDr(){
		$("#datos").val($("#datos").val().toUpperCase());
		var datos = $("#datos").val();


		if (datos.length > 0){
			$.ajax({
				url: 'seekDRresult.php',
			   dataType: 'json',
			   type: 'POST',
			   data: {
				DATOS: datos,
			   },
				success: function(data){
					if(data[0].status == "OK"){
						$('#result').html("");
						var html = "<table width='80%' align='center'>";
						html = html + "<thead><tr>";
						html = html + "<th>Cliente</th>";
						html = html + "<th>Reason</th>";
						html = html + "<th>MC</th>";
						html = html + "<th>Entrada</th>";
						html = html + "<th>Salida</th>";
						html = html + "<th>RMA</th>";
						html = html + "<th>Fecha recepci&oacute;n</th>";
						html = html + "<th>Estado</th>";
						html = html + "<th>Datos creaci&oacute;n</th>";
						html = html + "</tr></thead>";
						for(var i=0; i<data.length; i++){
							html = html + "<tbody><tr>";
							html = html + "<td>"+data[i].cliente+"</td>";
							html = html + "<td>"+data[i].reason+"</td>";
							html = html + "<td>"+data[i].mc+"</td>";

							if(data[i].estado == "ACP")
								html = html + "<td>"+data[i].in_almacen+"<br>"+data[i].in_modelo+"<br>"+"<input id='in_imei_"+data[i].ID+"' value='"+data[i].in_imei+"' class='disableEnter'><br>"+"<input id='in_serial_"+data[i].ID+"' value='"+data[i].in_serial+"' class='disableEnter'><br><div align='center'><a onclick='javascript:updateIN("+data[i].ID+")'><img src='./img/update.png' width=20px></a></div></td>";
							else
								html = html + "<td>"+data[i].in_almacen+"<br>"+data[i].in_modelo+"<br>"+data[i].in_imei+"<br>"+data[i].in_serial+"</td>";

							html = html + "<td>"+data[i].out_almacen+"<br>"+data[i].out_modelo+"<br>"+data[i].out_imei+"<br>"+data[i].out_serial+"</td>";
							html = html + "<td>"+data[i].rma+"</td>";

							if(data[i].f_recibido == "0000-00-00")
								html = html + "<td><div id='markNoReceived_"+data[i].ID+"'>NO RECIBIDO<br>Marcar como recibido<a onclick='javascript:markReceived("+data[i].ID+")'><img src='./img/accept.png' width=30px></a></div></td>";
							else
							html = html + "<td>"+data[i].f_recibido+"</td>";
								html = html + "<td>"+data[i].estado+"</td>";

							html = html + "<td>"+data[i].f_creacion+"<br><br>"+data[i].author+"</td>";
							html = html +"</tr></tbody>";
							html = html + "<tr colspan='9'></tr>";
						}
						html = html + "</table>";
						$('#result').append(html);
						$('#encontrado').html("<img src='./img/accept.png' width=45px>")
					}
					else{
						$('#result').html("");
						$('#encontrado').html("<img src='./img/cancel.png' width=35px>");
					}
					//Selecciono el contenido del campo de búsqueda para machacar el contenido directamente cuando se usa pistola
					$("#datos").select();
				},
			});
		}
}

function markReceived(ID){
	//var r = confirm ("Se va a marcar el terminal como recibido");

		   $.ajax({
			   url: 'markIDreceived.php',
			   type: 'post',
			   dataType: 'json',
			   data: {
				ID: ID
			   },
			   success: function(data){
					if(data[0].status == 'OK'){
						$('#markNoReceived_'+ID).html("Marcado como recibido");
						checkReception();
					}
					else
						alert("ERROR");
				}
			});

}

function checkReception(){
   $.ajax({
       url: 'checkReception.php?callFunction=' + true,
	   type: 'post',
       dataType: 'json',
       success: function(data){
	   }
    });
}

function updateIN(ID){
	var imeiName = "#in_imei_"+ID;
	var imei = $(imeiName).val();
	var serialName = "#in_serial_"+ID;
	var serial = $(serialName).val();

	 $.ajax({
       url: 'updateIN.php',
	   data: {
			ID: ID,
			imei: imei,
			serial: serial
	   },
	   type: 'post',
       dataType: 'json',
       success: function(data){
			if(data[0].status == 'OK'){
				alert("Actualizado correctamente");
			}
			else
				alert("ERROR");
	   }
    });
}

//Se hace esta función para que, en caso de estar una clase "disableEnter" como la de los IMEI y SN de las líneas que estén en estado "Aceptado", se captura el Intro y no se hace nada, ya que como "pistolean" podría o guardarse y no ser lo deseado, o en caso de no capturar el Intro, recargar la búsqueda como pasa al dejar de hacer el focus.
$(document).on("focus", ".disableEnter", function(){
		$(document).off();
});

$(document).keypress(function(e){
	if(e.which == 13){
		$("#search").click();
	}
});

$(document).ready(function(){ //Si hay contenido en el campo de búsqueda significa que viene un valor por referencia, y por tanto forzamos la búsqueda para mostrar los resultados tan pronto se cargue el documento
	if( ("#datos").length > 0 )
		$("#search").click();
});

$(".inputAct").change(function(event) { //Cuando se escribe en un input, vacía el resto de campos
	var id = this.id;
	var content = this.value;

	if(($(this).val() != "")){
		$(".inputAct").val("");
		$("#"+id).val(content);
	}
});
</script>
<script src="./js/dailyBackground.js"></script>
