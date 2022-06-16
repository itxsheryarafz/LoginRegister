<?php

define("DBHOST","localhost");
define("DBUSERNAME","root");
define("DBPASSWORD","");
define("DBUSER","user");

$conn = mysqli_connect(DBHOST,DBUSERNAME,DBPASSWORD,DBUSER);
include("helper.php");
?>

