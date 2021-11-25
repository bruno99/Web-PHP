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
<link rel="stylesheet" type="text/css" href=".styles.css" />

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


if(mysql_num_rows($resultDR) <=0){
	$resultIMEI = mysql_query("SELECT * FROM t_imeis WHERE imei = ".$datos." ");
	if(@mysql_num_rows($resultIMEI) <= 0)
		$results[] = array('status' => 'FAIL');
	else{
		$rowIMEI = mysql_fetch_assoc($resultIMEI);
		if (strlen($comentarios = $rowIMEI['comentarios']) < 1)
			$comentarios = "No hay comentarios";

		$results[] = array('ID' => $rowIMEI['ID'], 'cliente' => 'S/N' ,'reason' => 'S/N', 'mc' => 'S/N', 'in_almacen' => 'S/N', 'in_modelo' => 'S/N', 'in_imei' => $rowIMEI['imei'], 'in_serial' => 'S/N', 'out_almacen' => 'S/N', 'out_modelo' => 'S/N', 'out_imei' => 'S/N', 'out_serial' => 'S/N', 'rma' => 'SIN DATOS EN DB', 'f_recibido' => $rowIMEI['fecha'], 'estado' => 'S/N', 'f_creacion' => 'TERMINAL RECIBIDO PERO SIN DATOS DE DR<br /><br />COMENTARIOS: ' . $comentarios . '', 'status' => 'OK');
	}
}
else{
	while(@ $row = mysql_fetch_assoc($resultDR)){
			$results[] = array('ID' => $row['ID'], 'cliente' => utf8_encode($row['cliente']) ,'reason' => $row['reason'], 'mc' => $row['mc'], 'in_almacen' => $row['in_almacen'], 'in_modelo' => $row['in_modelo'], 'in_imei' => $row['in_imei'], 'in_serial' => $row['in_serial'], 'out_almacen' => $row['out_almacen'], 'out_modelo' => $row['out_modelo'], 'out_imei' => $row['out_imei'], 'out_serial' => $row['out_serial'], 'rma' => $row['rma'], 'f_recibido' => $row['f_recibido'], 'estado' => $row['estado'], 'f_creacion' => $row['f_creacion'], 'author' => $row['author'], 'status' => 'OK');
		}
}
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
					$("#datos").select();
				},
			});
		}
}




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
