<?php
$username = "lgsatdirect";
$password = "Satdirect2945";
$hostname = "150.150.216.251";
$database = "kpidb";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
or die("Unable to connect to MySQL");
echo "Successfully connected to database <b>".$database."</b><br />";
//select a database to work with
$selected = mysql_select_db($database, $dbhandle)
  or die("Could not select database");
