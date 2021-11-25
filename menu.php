<?php
session_start();

if (isset($_COOKIE['c_user'])){
	header('Location: ./menu.php');
}
if ($_COOKIE['c_user'] != "audit"){
	header('Location: ./home.php');
} else {
	header('Location: ./menu.php?show=CRT');
}

?>
