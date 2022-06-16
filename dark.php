<?php
include("dbconnection.php");
session_start();

$userid=$_SESSION['id'];


$darkvalue=$_POST['value'];

$checkuser="SELECT * from dark WHERE userid='$userid'";
$queryrun=$conn->query($checkuser);
$count=mysqli_num_rows($queryrun);

if($count>=1)
{
    $updatequery="UPDATE dark SET value='$darkvalue' WHERE userid='$userid'";
    $updaterun=$conn->query($updatequery);
}
else{
$sql="INSERT into dark(userid,value) VALUES('$userid','$darkvalue')";
$insertrun=$conn->query($sql);    
}
?>