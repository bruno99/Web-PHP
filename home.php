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
	<li><a href="#" onclick="javascript:window.open('DrForm.php','[New] Insertar DR manual','scrollbars=1,width=1600,height=800')">[New] Insertar DR manual </a></li>
        <li><a href="#" onclick="javascript:window.open('uploadDRFile.php','Insertar DR file','scrollbars=1,width=1600,height=400')">Insertar Dr fichero</a></li>
        <li><a href="#" onclick="javascript:window.open('exportToExcel.php','Listado DR','scrollbars=1,width=800,height=800')">Listado DR</a></li>
	<li><a href="#" onclick="javascript:window.open('seekDR.php','Buscar DR','scrollbars=1,width=800,height=400')"> Buscar DR</a></li>

</script>

