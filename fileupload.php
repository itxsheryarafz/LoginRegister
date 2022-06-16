<?php
session_start();
include("dbconnection.php");
$userid = $_SESSION['id'];

$checkuser = "SELECT * from settingsmeta WHERE userid='$userid'";

$checkquery = $conn->query($checkuser);
$count = mysqli_num_rows($checkquery);

$valid_extensions = array('pdf', 'doc', 'docx');
$path = 'uploads/';
if (!empty($_POST['name']) || !empty($_POST['email']) || $_FILES['image']) {
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    $final_image = rand(1000, 1000000) . $img;
    if (in_array($ext, $valid_extensions))
     {
        $path = $path . strtolower($final_image);
        if (move_uploaded_file($tmp, $path)) {
           
                $checkmeta = "SELECT * from settingsmeta WHERE metakey='filepath'  && userid='$userid'";

                $querymeta = $conn->query($checkmeta);
                $pathmeta = mysqli_num_rows($querymeta);
                if ($pathmeta >= 1) {
                    $updatemeta = "UPDATE `settingsmeta` SET `value` = '$path' WHERE `settingsmeta`.`userid` = '$userid' && `settingsmeta`.`metakey`='filepath' ";
                    $queryrun = $conn->query($updatemeta);
                    if ($queryrun) {
                        echo json_encode(["status" => 1,"title" => "File Updated"]);
                    } else {
                        echo json_encode(["status" => 2,"title" => "File Not Updated"]);
                    }
                } 
                else {

                    $insertquery = "INSERT INTO `settingsmeta` (`userid`,`metakey`,`value`) VALUES('$userid','filepath','$path')";
                    $insertrun = $conn->query($insertquery);
                    if ($insertquery) 
                    {
                        echo json_encode(["status" => 1,"title" => "File Uploaded"]);
                    }
                    else
                    {
                        echo json_encode(["status" => 2,"title" => "File Not Uploaded"]);
                    }
                }
            //     else {
            //     $insertquery = "INSERT INTO `settingsmeta` (`userid`,`metakey`,`value`) VALUES('$userid','filepath','$path')";
            //     $insertrun = $conn->query($insertquery);
            //     if ($insertquery) {
            //         echo json_encode(["status" => "File Uploaded"]);
            //     }
            // }
        }
    } 
    else {
        echo json_encode(["status" => 3,"title" => "Format Invalid"]);
    }
}
