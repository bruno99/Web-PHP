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
					<option selected="yes" value=""></option>
					<option value="UR1">UR1 UNABLE TO REPAIR (Imposible / Dif&iacute;cil reparar)</option>
					<option value="DA1">DA1 DEAD ON ARRIVAL (DOA)</option>
					<option value="MR1">MR1 MULTIPLE REPAIRS (P2R / 2AVE / P3R / 3AVE)</option>
					<option value="PA1">PA1 PARTS NOT AVAILABLE DELAYED SUPPLY (Retraso en llegada del repuesto)</option>
					<option value="PA2">PA2 PARTS NOT AVAILABLE DISCONTINUED PART (Repuesto discontinuado)</option>
					<option value="TE1">TE1 TOO EXPENSIVE TO REPAIR (Coste reparaci&oacuten supera coste del terminal)</option>
					<option value="PL1">PL1 PL & RECALL (Equipo sustituido por ser PL)</option>
				</select><br /> <br />
				<div id="defectivePart" hidden="yes"> C&oacute;digo de respuesto <input name='defectivePart' id="codRep"></div>
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

<script language="javascript">
	//var flag1 = false, flag2 = false;

	function sendForm(){ //Se utiliza esta función para evitar falsos envios del formulario al pulsar intro. En lugar de submit se usa un button que pasa por esta función
		if (comprobar() == true)
			document.drForm.submit();
	}

	function comprobar()
	{
		var cliente = document.drForm.cliente.value;
		var reason = document.drForm.reason.value;
		var in_almacen= document.drForm.in_almacen.value;
		var in_modelo = document.drForm.in_modelo.value;
		var in_imei = document.drForm.in_imei.value;
		var in_serial = document.drForm.in_serial.value;
		var out_almacen= document.drForm.out_almacen.value;
		var out_modelo = document.drForm.out_modelo.value;
		var out_imei = document.drForm.out_imei.value;
		var out_serial = document.drForm.out_serial.value;
		var telefono = document.drForm.telefono.value;
		var cp = document.drForm.cp.value;
		var gsnain = document.getElementById("gsnain").checked;
		var gradejsv = document.getElementById("gradejsv").checked;
		var unitdmgsv = document.getElementById("unitdmgsv").checked;
		var poblacion = document.drForm.poblacion.value;
		var provincia = document.drForm.provincia.value;
		var fechaRecibido = document.drForm.f_recibido.value;
		var mc = document.drForm.mc.value;
		var rma = document.drForm.rma.value;
		var codRep = document.drForm.codRep.value;

	   if (cliente.length == 0 || reason == "" || in_almacen.length == 0 || in_modelo.length == 0 || (gsnain == false && gradejsv == false && unitdmgsv == false) || out_modelo.length == 0){

			alert("Debe rellenar los campos obligatorios marcados con un asterisco (*)");
			return false;
	   }

	   var bypass = false;

	   if (isAccessory(in_modelo) == false || isAccessory(out_modelo) == false){
			if(in_imei.length == 0 || in_serial.length == 0 || out_imei.length == 0 || out_serial.length == 0){
				alert("Debe rellenar los campos de IMEI y numero de serie");
				return false;
			}
	   }
	   else
		   bypass = true;

	   if ((reason == "PA1" || reason == "PA2") && codRep.length == 0){
		   alert("Al seleccionar PA1 o PA2 como razon, es obligatorio rellenar el campo 'Codigo de repuesto'");
		   return false;
	   }

	   if (poblacion.length !=0 && provincia.length == 0){
		alert("Debe rellenar el campo Provincia");
		return false;
	   }

	   if ((in_serial.length != 13 && in_serial.length != 14) || (out_serial.length != 13 && out_serial.length != 14)){
			alert("El numero de serie debe ser de 13 o 14 digitos");
			 if (in_serial.length != 13 && in_serial.length != 14)
				document.getElementById("in_serial").style.backgroundColor = "red";
			else
				document.getElementById("in_serial").style.backgroundColor = "white";
			if (out_serial.length != 13 && out_serial.length != 14)
				document.getElementById("out_serial").style.backgroundColor = "red";
			else
				document.getElementById("out_serial").style.backgroundColor = "white";

			return false;
	   }

		if((in_imei.trim() == out_imei.trim()) && bypass == false){
			alert("El numero IMEI de entrada y salida no pueden ser iguales");

			return false;
		}

		if (fechaRecibido.length == 0){
			var r = confirm ("El terminal ya ha sido recibido -> Aceptar\n\nEl terminal NO ha llegado -> Cancelar");
			if (r == true)
				document.getElementById("f_recibido").value = "<?php echo date('Y-m-d') ?>";
	   }

	   return true;
	}

	function startsWith(cadena){
		var primerCaracter;
		primerCaracter = cadena.substring(0,1);
		return primerCaracter = cadena.substring(0,1);
	}

	function copiarModelo(){
		document.drForm.in_modelo.value = document.drForm.out_modelo.value
	}

	function isAccessory(modelo){
		   var itIs;

		   if (modelo.substr(0, 3) == "BCK" || modelo.substr(0, 3) == "HBS" || modelo.substr(0, 3) == "CCF" || modelo.substr(0, 3) == "CCY" || modelo.substr(0, 3) == "CFR" || modelo.substr(0, 3) == "CLA" || modelo.substr(0, 3) == "UTC" || modelo.substr(0, 3) == "WCD")
			   itIs = true;
		   else
			   itIs = false;

		   return itIs;
	   }
</script>

<script>
$('#cliente').change(function(event) {
	setTimeout(blinkField, 1000);
})

$('#precargado').change(function(event) {
	$.ajax({
		   url: './getDir.php',
		   dataType: 'json',
		   type: 'POST',
		   data: {
			selected: $('#precargado').val(),
		   },
		   success: function(data){
				if(data[0].status == "OK"){
					$('#cliente').val(data[0].cliente);
					$('#cliente').prop('readonly', true);
					$('#telefono').val(data[0].telf);
					$('#telefono').prop('readonly', true);
					$('#calle').val(data[0].calle);
					$('#calle').prop('readonly', true);
					$('#cp').val(data[0].cp);
					$('#cp').prop('readonly', true);
					$('#poblacion').val(data[0].pob);
					$('#poblacion').prop('readonly', true);
					$('#provincia').val(data[0].prov);
					$('#provincia').prop('readonly', true);
				}
				else{
					$('#cliente').val("");
					$('#cliente').prop('readonly', false);
					$('#telefono').val("");
					$('#telefono').prop('readonly', false);
					$('#calle').val("");
					$('#calle').prop('readonly', false);
					$('#cp').val("");
					$('#cp').prop('readonly', false);
					$('#poblacion').val("");

					$('#poblacion').prop('readonly', false);
					$('#provincia').val("");
					$('#provincia').prop('readonly', false);
				}
		   },
    });
	setTimeout(blinkField, 1000);
});

$('#cp').change(function(event) {
$('#loading').html("<img src='./img/ajax-loader.gif'>");
	$.ajax({
		url: './getDirFromCP.php',
		dataType: 'json',
		type: 'POST',
		data: {
			codigo: $('#cp').val(),
		},
		success: function(data){
			if(data[0].status == "OK"){
				$('#poblacion').val(data[0].pob);
				$('#provincia').val(data[0].prov);
			}
			else{
				$('#poblacion').val("");
				$('#provincia').val("");
			}
				$('#loading').html("");
		   },
		error: function(data){
			$('#loading').html("<img src='./img/cancel.png' width=45px>");
		},
    });
});

$('#nref').change(function(event) {
$('#loading').html("<img src='./img/ajax-loader.gif'>");
	$.ajax({
		   url: './getInfoFromNREF.php',
		   dataType: 'json',
		   type: 'POST',
		   data: {
			nref: $('#nref').val(),
		   },
		   success: function(data){
				if(data[0].status == "OK"){
					//$('#cliente').val(data[0].cliente);
					$('#cliente').val("Cliente final " + $('#nref').val());
					//$('#calle').val(data[0].direccion);
					$('#calle').val("N/A");
					//$('#cp').val(data[0].zip);
					$('#cp').val(data[0].zip);
					//$('#poblacion').val(data[0].ciudad);
					$('#poblacion').val(data[0].ciudad);
					//$('#provincia').val(data[0].estado);
					$('#provincia').val(data[0].estado);
					//$('#telefono').val(data[0].telefono);
					$('#telefono').val("100000009");
					//$('#in_imei').val(data[0].imei);
				}
				else{
					$('#cliente').val("");
					$('#calle').val("");
					$('#cp').val("");
					$('#poblacion').val("");
					$('#provincia').val("");
					$('#telefono').val("");
					//$('#in_imei').val("");
				}
				$('#loading').html("");
		   },
    });
});

//Live UpperCase
$(function() {
    $('.getIMEI, .serialNumber').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
    });
});

$('.getIMEI').change(function(event) {
	$('#loading').html("<img src='./img/ajax-loader.gif'>");
	var thisName = this.name;

		var outputModelo = "#in_modelo";
		var outputSerial = "#in_serial";
	//}

	$.ajax({
		   url: './XML/imeiFromCSMG.php',
		   dataType: 'json',
		   type: 'POST',
		   data: {
			IMEI: $(this).val(),
		   },
		   success: function(data){
				if(data[0].status == "OK"){
					var modelo = data[0].model;
					var sufijo = data[0].suffix;
					sufijo = sufijo.substring(1, sufijo.length);
					sufijo = "A" + sufijo;
					modelo = modelo + "." + sufijo;

					$(outputModelo).val(modelo);
					$(outputSerial).val(data[0].serial);
					$("#statusIMEI").html("");
				}
				else{
					$(outputModelo).val("");
					$(outputSerial).val("");
					$("#statusIMEI").html("IMEI no encontrado");
				}
				$('#loading').html("");
		   },
    });
});
$('.getIMEImov').change(function(event) {
	$('#loading').html("<img src='./img/ajax-loader.gif'>");
	var thisName = this.name;

	var outputModelo = "#out_modelo";
	var outputSerial = "#out_serial";
	var outputSubinventory = "#out_almacen";
		
	$.ajax({
		   url: './ajaxOutUnit.php',
		   dataType: 'json',
		   type: 'POST',
		   data: {
			IMEI: $(this).val(),
		   },
		   success: function(data){
				if(data[0].status == "OK" && data[0].model != null){
					var modelo = data[0].model;
					var sufijo = data[0].suffix;
					sufijo = sufijo.substring(1, sufijo.length);
					sufijo = "A" + sufijo;
					modelo = modelo + "." + sufijo;
					
					$(outputModelo).val(modelo);
					$(outputSerial).val(data[0].sn);
					
					if(data[0].subinventory == "UNITDMG-SV")
						$("#unitdmgsv").prop('checked', true);
					else if(data[0].subinventory == "GS-NA-IN")
						$("#gsnain").prop('checked', true);
					else if(data[0].subinventory == "GRADE-J-SV")
						$("#gradejsv").prop('checked', true);
					
					$("#statusIMEI").html("");
				}
				else{
					$(outputModelo).val("");
					$(outputSerial).val("");
					$(outputSubinventory).val("");
					$("#statusIMEI").html("IMEI no encontrado");
				}
				$('#loading').html("");
		   },
    });
});

$('.getIMEIAlmacen').change(function(event) {
	$('#loading').html("<img src='./img/ajax-loader.gif'>");

	$.ajax({
		   url: './getModelFromAlmacen.php',
		   dataType: 'json',
		   type: 'POST',
		   data: {
			IMEI: $(this).val(),
		   },
		   success: function(data){
				if(data[0].status == "OK"){
					$("#out_modelo").val(data[0].modelo);
					$("#out_serial").val(data[0].sn);
					if(data[0].almacen == "UNITDMG-SV")
						$("#unitdmgsv").prop('checked', true);
					else if(data[0].almacen == "GS-NA-IN")
						$("#gsnain").prop('checked', true);
					else if(data[0].almacen == "GRADE-J-SV")
						$("#gradejsv").prop('checked', true);

					$('#imeiAlmacen').html("");
				}
				else{
					$("#out_modelo").val("");
					$("#out_serial").val("");
						if(document.getElementById("out_imei").value != ""){
						}
						else
							$('#imeiAlmacen').html("");

				}
				$('#loading').html("");
		   },
    });
});

$('#reason').change(function(event) {
	var thisName = this.value;
	var line = "C&oacute;digo de respuesto <input name='defectivePart'> ";

	if(thisName == "PA1" || thisName == "PA2")
		$('#defectivePart').show();
	else
		$('#defectivePart').hide();
});
</script>
<script src="./js/dailyBackground.js"></script>
<script>
function insertarComentario(){
	$("#insertComment").toggle();
}

$(document).ready(function(){
	$("#codRep").css("background-color", "rgb(135, 230, 24)"); //Fondo del campo de insertar código de repuesto
	$("#insertComment").hide(); //Se oculta el campo de escribir comentarios
});
</script>
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
