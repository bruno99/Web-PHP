<?php
session_start();

if (isset($_COOKIE['c_user'])){
	header('Location: ./menu.php');
}
if ($_COOKIE['c_user'] != "audit"){
	header('Location: ./mainMenu.php');
} else {
	header('Location: ./viewerDr.php?show=CRT');
}

?>
