<?php
include_once(".htconnection.php");
$result = $mysqli->query("SELECT MAX(ID) as ID FROM t_storage") or die($mysqli->error);
$row = $result->fetch_array();
$result2 = $mysqli->query("SELECT * FROM t_storage") or die($mysqli->error);
$numReg = $result2->num_rows;

$rowLastUp = $mysqli->query("SELECT MAX(f_creacion) FROM t_storage WHERE tipo_subida = 'F' ")->fetch_array();
$lastUp = $rowLastUp['MAX(f_creacion)'];

$rowDrByUser = $mysqli->query("SELECT ID FROM t_storage WHERE author = '".$_COOKIE['c_user']."' ")->num_rows;

$rowGerpByUser = $mysqli->query("SELECT ID FROM t_storage WHERE author_gerp = '".$_COOKIE['c_user']."' ")->num_rows;

$rowMaxDrUser = $mysqli->query("SELECT author, COUNT(author) AS drNumber FROM t_storage GROUP BY author ORDER BY drNumber DESC LIMIT 1")->fetch_array();

$rowMaxGerpUser = $mysqli->query("SELECT author_gerp, COUNT(author_gerp) AS gerpNumber FROM t_storage GROUP BY author_gerp ORDER BY gerpNumber DESC LIMIT 1")->fetch_array();

$rowNombre = $mysqli->query("SELECT name FROM t_users WHERE user = '".$_COOKIE['c_user']."' ")->fetch_array();

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
				$("#pendRec").html("<table class='pending'><tr><td colspan='3'>Terminales pendientes de recibir de más de 15 días</td></tr><tr>" + listaDR + "</tr></table>");
				
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
