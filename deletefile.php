<?php
include("dbconnection.php");
$id=$_POST['id'];
$deletemeta="DELETE from settingsmeta WHERE id='$id'";
$deltequery=$conn->query($deletemeta);

if($deltequery)
{
    echo json_encode(["status"=> 40005]);
}
else
{
echo "Not deleted";
}

?>