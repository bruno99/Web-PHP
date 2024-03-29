<?php
	session_start();

include_once(".htconnection.php");
$resultDIR= mysqli_query($mysqli,"SELECT ID, name FROM t_addresses") or die(mysqli_error($mysqli));
?>
<!DOCTYPE html>
<html>

<script src="./jquery/jquery-1.11.1.min.js"></script>
<script src="./jquery/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="./Style.css" />
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
   
	      $results = false; //Para evitar que, en caso de meter datos en el autocomplete que no existen en la base de datos, la variable $results no exista y devuelva un error parseError
	
                             $req = "SELECT modelo "
                                    ."FROM t_models "
                                     ."WHERE modelo LIKE '%".$_REQUEST['term']."%' ORDER BY modelo ASC";
    
                              $query = mysqli_query($mysqli,$req);
    
    while($row = mysqli_fetch_array($query))
    {
        $results[] = array('modelo' => $row['modelo']);
    }
    
    echo json_encode($results);

?>
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
	
<thead><th colspan="4">Información de contacto</th></thead>
<tr>
   <td><div align="center">Precargado:        <select name="precargado" id="precargado">
					<option selected="yes" value=""></option>
					<?php
					while($rowDIR = mysqli_fetch_assoc($resultDIR)){
						echo "<option value='".$rowDIR['ID']."'>".$rowDIR['name']."</option>";
					}?>
					</select>
					<br><br>
					Núm. Ref. (RNE): <input id="nref" name="nref" value="" type="text" autofocus="yes" class="autoField">
				</div></td>
   <td>
   RMA: <input id="rma" name="rma" type="text">
   </td>
   <td>MC/SD/OT/OR: <br /><input name="mc" value="" type="text" id="mc"></td>
   <td>Fecha recepción terminal: <input id="f_recibido" name="f_recibido" value="" type="text" class="datepicker"></td>
</tr>
<tr>
	<td><div align="center">
	*Cliente: <br /><input name="cliente" id="cliente" value="" type="text" size="40"> <a href="javascript:insertarComentario();"> <img src="./img/addComment.png" width="20"></a><br><div id="insertComment"><textarea placeholder='Inserte aquí su comentario...' name='comentarios' rows='1' cols='50'></textarea></div>
   <br>
	Código Postal: <br /><input name="cp" id="cp" type="number""></div></td>
	<td>Teléfono:<br />     <input name="telefono" id="telefono" type="number"><br>Calle: <input name="calle" id="calle" type="text"></td>
	<td>Población: <input name="poblacion" id="poblacion" type="text"></td>
	<td>Provincia: <input name="provincia" id="provincia" type="text"></td>
</tr>
<thead><th colspan="4">Razón</th></thead>
<tbody>
<tr>
   <td colspan="4">*Reason: <select name="reason" id="reason">

	</td>
</tr>
</tbody>
<thead><th colspan="4">Datos de salida</th></thead>
<tbody>
<tr>
	<td><b>*Almacén:</b><br><br>
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
		
<thead><th>Datos de entrada</th></thead>
<tbody>
<tr>
	<td>*Almacén: <select name="in_almacen">
					<option selected="yes" value="UNITDMG-SV">UNITDMG-SV</option>

	<td>*IMEI: <input name="in_imei" type="text" class="getIMEI"></td>
	<td>*S/N: <input name="in_serial" id="in_serial" type="text" class="serialNumber"></td>
	<td>*Modelo: <input name="in_modelo" id="in_modelo" type="text" class="autoModel"></td>
</tr>
</tbody>
<tr>
<td></td>
<td colspan="2"><input value="Enviar DR"  type="button" onclick="javascript:sendForm()" class="botonEnviar"></td>
<td><a href="javascript:if(confirm('¿Cerrar ventana?')) window.close();"><button type="button" class="botonAtras">Cerrar ventana</button></a></td>
</tr>
</tbody>
</form>
</table>

</body>
</html>


