<?php
	session_start();

	if(!isset($_COOKIE['c_user'])){
		header('Location: ./index.html');
		exit;
	}

include_once(".htconnection.php");
$resultDIR= mysql_query("SELECT ID, name FROM t_addresses") or die(mysql_error());
?>
<!DOCTYPE html>
<html>
<!--******JQuery******-->
<script src="./jquery/jquery-1.11.1.min.js"></script>
<script src="./jquery/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./jquery/jquery-ui.css" />
<style type="text/css">
   .ui-autocomplete { height: 250px; overflow-y: scroll; overflow-x: hidden;}
</style>
<!--******JQuery******-->
<link rel="stylesheet" type="text/css" href="./css/loginStyle.css" />
<link rel="stylesheet" type="text/css" href="./css/tableStyle.css" />

<script>
	$(function(){
		$(".datepicker").datepicker({
			showAnim: 'drop',
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true
		});

		 $( ".autoModel" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "getModels.php",
					type: 'GET',
					dataType: "json",
					data: {
						term: request.term
					},
					success: function(data) {
						response($.map(data, function(item) {
							return {
							    label: item.modelo,
							    value: item.modelo
							};
						}));
					},
					error: function(request, textStatus, errorThrown){
						console.log(request.responseText);
						alert(textStatus);
						alert(errorThrown);
					}
				});
			},
			change: function (event, ui) {
                if(!ui.item){
					$(this).css({'background-color' : '#FF0000'});
				}
				 if(ui.item || $(this).val()==""){
					$(this).css({'background-color' : '#d1d1d1'}); 
				}
			},
			minLength: 2
		 });
	});
</script>
<body>

<table cellspacing='0' class='tableDRform'>
<form action="./newDrPhpCode.php" method="post" name="drForm" id="drForm">
<thead><th colspan="4">Informaci&oacute;n de contacto</th></thead>
<tr>
   <td><div align="center">Precargado:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="precargado" id="precargado">
					<option selected="yes" value=""></option>
					<?php
					while($rowDIR = mysql_fetch_assoc($resultDIR)){
						echo "<option value='".$rowDIR['ID']."'>".$rowDIR['name']."</option>";
					}?>
					</select>
					<br><br>
					N&uacutem. Ref. (RNE): <input id="nref" name="nref" value="" type="text" autofocus="yes" class="autoField">
				</div></td>
   <td>
   RMA: <input id="rma" name="rma" type="text">
   </td>
   <!-- <td>* MC/SD/OT/OR: <br /><input name="mc" value="" type="text" id="mc"><br><input type="button" value="Seguir sin MC" onclick="javascript:document.getElementById('mc').value='null '"></td> -->
   <td>MC/SD/OT/OR: <br /><input name="mc" value="" type="text" id="mc"></td>
   <td>Fecha recepci&oacuten terminal: <input id="f_recibido" name="f_recibido" value="" type="text" class="datepicker"></td>
</tr>
<tr>
	<td><div align="center">
	*Cliente: <br /><input name="cliente" id="cliente" value="" type="text" size="40"> <a href="javascript:insertarComentario();">&nbsp;<img src="./img/addComment.png" width="20"></a><br><div id="insertComment"><textarea placeholder='Inserte aqu&iacute; su comentario...' name='comentarios' rows='1' cols='50'></textarea></div>
   <br>
	C&oacute;digo Postal: <br /><input name="cp" id="cp" type="number" class="autoField"></div></td>
	<td>Tel&eacute;fono:<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="telefono" id="telefono" type="number"><br>Calle: <input name="calle" id="calle" type="text"></td>
	<td>Poblaci&oacute;n: <input name="poblacion" id="poblacion" type="text"></td>
	<td>Provincia: <input name="provincia" id="provincia" type="text"></td>
</tr>
<thead><th colspan="4">Raz&oacute;n</th></thead>
<tbody>
<tr>
   <td colspan="4">*Reason: <select name="reason" id="reason">

	</td>
</tr>
</tbody>
<thead><th colspan="4">Datos de salida</th></thead>
<tbody>
<tr>
	<td><b>*Almac&eacute;n:</b><br><br>
	<span class="almacenes">
		<input type="radio" id="gsnain" name="out_almacen" value="GS-NA-IN">GS-NA-IN (Producto nuevo)<br>
		<input type="radio" id="gradejsv" name="out_almacen" value="GRADE-J-SV">GRADE-J-SV (Refurbish)<br>
		<input type="radio" id="unitdmgsv" name="out_almacen" value="UNITDMG-SV">UNITDMG-SV (Devoluciones)
	</span>
	</td>
	<td>*IMEI: <input name="out_imei" id="out_imei" type="text" class="getIMEImov"><br><div id="imeiAlmacen"></div></td>
	<td>*S/N: <input name="out_serial" id="out_serial" type="text" class="serialNumber"></td>
	<td>*Modelo: <input name="out_modelo" id="out_modelo" type="text" class="autoModel"></td>
</tr>
<thead><th>Datos de entrada</th><th><div id="statusIMEI"></div></th><th></th><th><a href="javascript:copiarModelo()">Copiar modelo<img src="./img/copyModel.png" width=30px></a></th></thead>
<tbody>
<tr>
	<td>*Almac&eacuten: <select name="in_almacen">
					<option selected="yes" value="UNITDMG-SV">UNITDMG-SV</option>
				</select><br><br><br>Los campos con fondo gris cuentan con alg&uacute;n tipo de auto-completado autom&aacute;tico<br><br>Los campos con un asterisco son obligatorios<br>&nbsp;<div id="loading" align="center"></div></td>
	<td>*IMEI: <input name="in_imei" type="text" class="getIMEI"></td>
	<td>*S/N: <input name="in_serial" id="in_serial" type="text" class="serialNumber"></td>
	<td>*Modelo: <input name="in_modelo" id="in_modelo" type="text" class="autoModel"></td>
</tr>
</tbody>
<tr>
<td></td>
<td colspan="2"><input value="Enviar DR"  type="button" onclick="javascript:sendForm()" class="botonEnviar"></td>
<td><a href="javascript:if(confirm('&iquest;Cerrar ventana?')) window.close();"><button type="button" class="botonAtras">Cerrar ventana</button></a></td>
</tr>
</tbody>
</form>
</table>

</body>
</html>

<script>
	var cont = 0;
	var r = 255, g = 255, b = 255;
	function blinkField(){
		if($("#mc").val() == "" && cont < 9){
			if(g != 255){
				g = 255;
				$("#mc").css("background-color", "rgb(0,"+g+",50)");
			}
			else{
				g=250;
				$("#mc").css("background-color", "rgb(250,"+g+",250)");
			}
		}
		if(cont < 9){
			cont++;
			setTimeout(blinkField, 500);
		}
	}
</script>
