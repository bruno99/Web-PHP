<?php
session_start();
unset($_SESSION['user']);
setcookie('c_user', null);
unset($_COOKIE['c_user']);
session_destroy();
header('Location: ./index.php');?>
