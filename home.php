<?php
include_once(".htconnection.php");
$result = mysql_query("SELECT MAX(ID) as ID FROM t_storage") or die(mysql_error());
$row = mysql_fetch_array($result);
$result2 = mysql_query("SELECT * FROM t_storage") or die(mysql_error());
$numReg = mysql_num_rows($result2);

$rowLastUp = mysql_fetch_array(mysql_query("SELECT MAX(f_creacion) FROM t_storage WHERE tipo_subida = 'F' "));
$lastUp = $rowLastUp['MAX(f_creacion)'];

$rowDrByUser = mysql_num_rows(mysql_query("SELECT ID FROM t_storage WHERE author = '".$_COOKIE['c_user']."' "));

$rowGerpByUser = mysql_num_rows(mysql_query("SELECT ID FROM t_storage WHERE author_gerp = '".$_COOKIE['c_user']."' "));

$rowMaxDrUser = mysql_fetch_array(mysql_query("SELECT author, COUNT(author) AS drNumber FROM t_storage GROUP BY author ORDER BY drNumber DESC LIMIT 1"));

$rowMaxGerpUser = mysql_fetch_array(mysql_query("SELECT author_gerp, COUNT(author_gerp) AS gerpNumber FROM t_storage GROUP BY author_gerp ORDER BY gerpNumber DESC LIMIT 1"));

$rowNombre = mysql_fetch_array(mysql_query("SELECT name FROM t_users WHERE user = '".$_COOKIE['c_user']."' "));

?>
<table class="selectTool">
<tr>
	<td></td>
	<td><?php echo "Se han introducido ".$row['ID']." DR desde el d&iacute;a 19/09/2014, con ".$numReg." activos<br><br><a href='#' onclick=javascript:window.open('Ranking.php','RankingDR','width=400,height=600')>El usuario con m&aacute;s DR introducidos (en el sistema local) hasta el momento es ".strtoupper($rowMaxDrUser['author']).", con ".$rowMaxDrUser['drNumber'].".</a> <a href='#' onclick=javascript:window.open('RankingGerp.php','RankingGerp','width=400,height=600')>El usuario que ha introducido m&aacute;s DR en GERP es ".strtoupper($rowMaxGerpUser['author_gerp']).", con ".$rowMaxGerpUser['gerpNumber']."</a><br><br>Con su usuario, ".strtoupper($_COOKIE['c_user']).", ha introducido ".$rowDrByUser." al sistema local, y ".$rowGerpByUser." DR a GERP. " ?></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td><img src="./img/LG_new_logo.png" width="250" ></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td><a href="./DRselectTool.php">VOLVER A MEN&Uacute; CL&Aacute;SICO</a></td>
	<td></td>
</tr>
</table>
<div id="pendRec">
</div>

<script>
function checkNoReceived(){
	$.ajax({ //Si hace mas de un mes que un terminal no se ha recibido, se muestra una alerta
	   url: 'checkNoReceived.php',
	   dataType: 'json',
	   success: function(data){
			if(data[0].status=='OK'){
				var listaDR = "\n";
				for(i=0; i<data.length;i++){
					if(i==0) //La primera fila se abre con <tr> y se escribe el primer campo
						listaDR = listaDR + "<tr><td><a target='_blank' href='./seekDr.php?rma=" + data[i].rma + "'>" + data[i].rma + "</a></td>";
					else if (i%2==0) //Cada 2 filas, se escribe la siguiente columna, pero se cierra la fila con </tr>
						listaDR = listaDR + "<td><a target='_blank' href='./seekDr.php?rma=" + data[i].rma + "'>" + data[i].rma + "</a></td></tr>";
					else if(i!=0 && i%3==0) //Cada 3, salta fila. Se excluye i=0 porque si no saltaría línea tras el primero
						listaDR = listaDR + "<tr><td><a target='_blank' href='./seekDr.php?rma=" + data[i].rma + "'>" + data[i].rma + "</a></td>";
					else
						listaDR = listaDR + "<td><a target='_blank' href='./seekDr.php?rma=" + data[i].rma + "'>" + data[i].rma + "</a></td>";
				}
				listaDR = listaDR + "\n\n";
				$("#pendRec").html("<table class='pending'><tr><td colspan='3'>Terminales pendientes de recibir de m&aacute;s de 15 d&iacute;as</td></tr><tr>" + listaDR + "</tr></table>");
				
			}
	   }
	});
}
</script>
<script>
$(document).ready(function()
{
	checkNoReceived();
});
</script>
