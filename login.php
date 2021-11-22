<?php
session_start();

include_once("./.htconnection.php");
$user = $mysqli->real_escape_string($_POST["user"]);
$password = hash('sha256', $mysqli->real_escape_string($_POST["pass"]));

$query = $mysqli->query("SELECT * FROM t_users WHERE user='$user' AND password='$password'");
$row = $query->fetch_array();

if($query->num_rows > 0){
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
	$result_sqlaccess = $mysqli->query("INSERT INTO t_accesscontrol (k_user, location) VALUES (".$_SESSION['ID'].", '".$currentURL."')") or die($mysqli->error);
}
else{
	echo ("NoCorrect");
}
?>
