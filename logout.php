<?php
session_start();
include("dbconnection.php");
if(isset($_SESSION))
{
    $offset=5*60*60; //converting 5 hours to seconds.
    $dateFormat="m/d/Y H:i:a";
    $timeNdate=gmdate($dateFormat, time()+$offset);
    $SID=$_SESSION['SID'];
    $endtime="UPDATE session SET endtime='$timeNdate' WHERE sessionid='$SID' && endtime=''";
    $queryrun=$conn->query($endtime);
    if($queryrun)
    {
        session_destroy();
        header("location:index.php");
        
    }
    else{
        header("location:Dashboard.php");
    }
}


?>