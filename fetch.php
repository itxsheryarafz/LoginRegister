<?php
include("dbconnection.php");

$updateid=$_POST['updateid'];

$fetchuser="SELECT * from registeruser WHERE id='$updateid'";
$queryrun=$conn->query($fetchuser);

$data_view=mysqli_fetch_assoc($queryrun);

echo json_encode($data_view);



?>