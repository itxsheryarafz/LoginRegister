<?php
session_start();
if($_SESSION['uname'])
{
    header("location:Dashboard.php");
}
else{
  echo "SESSIOn";
}
?>