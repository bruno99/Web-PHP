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
	<td></td>
</tr>
<tr>
	<td></td>
	<td><img src="./img/LG_new_logo.png" width="250" ></td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td></td>
</tr>
</table>
<div id="pendRec">
</div>

<script>
function checkNoReceived(){
	$.ajax({ 
	   url: 'checkNoReceived.php',
	   dataType: 'json',
	   success: function(data){
			if(data[0].status=='OK'){
				var listaDR = "\n";
				for(i=0; i<data.length;i++){
					if(i==0) 
						listaDR = listaDR + "<tr><td><a target='_blank' href='./seekDr.php?rma=" + data[i].rma + "'>" + data[i].rma + "</a></td>";
					else if (i%2==0)
						listaDR = listaDR + "<td><a target='_blank' href='./seekDr.php?rma=" + data[i].rma + "'>" + data[i].rma + "</a></td></tr>";
					else if(i!=0 && i%3==0) 
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
