<?php
session_start();

include_once("./.htconnection.php");
$user = mysql_real_escape_string($_POST["user"]);
$password = hash('sha256', mysql_real_escape_string($_POST["pass"]));

$query = mysql_query("SELECT * FROM t_users WHERE user='$user' AND password='$password'");
$row = mysql_fetch_array($query);

if(mysql_num_rows($query) > 0){
	$_SESSION['ID'] = $row['ID'];
	$_SESSION['user'] = $user;
	$_SESSION['name'] = $row['name'];
	echo ($row['name']);

	if($_SESSION['user']!="admin"){
		setcookie("c_user", strtolower($row['user']), time() + (60*60*10)); //10 horas de sesión activa
	} else {
		setcookie("c_user", strtolower($row['user']), time() + (60*60*100)); //100 horas de sesión activa 
	}
	
	$currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$result_sqlaccess = mysql_query("INSERT INTO t_accesscontrol (k_user, location) VALUES (".$_SESSION['ID'].", '".$currentURL."')") or die(mysql_error());
}
else{
	echo ("NoCorrect");
}
?>
