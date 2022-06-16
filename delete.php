<?php

include("dbconnection.php");
$id=$_POST['id'];
$deleteuser="DELETE FROM registeruser WHERE id='$id'";
$queryrun=$conn->query($deleteuser);

if($queryrun)
{
    echo json_encode(["status"=>100]);
}
else{
  echo  json_encode(["status"=>100]);
}


?>