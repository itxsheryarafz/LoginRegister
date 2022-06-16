<?php
session_start();
include("dbconnection.php");

$errorMSG = "";


$userid = $_SESSION['id'];

if($_POST['width'] < 750  )
{
    $errorMSG .= "Width Should greater than 750px </br>";
}
else
{
$alldata=$_POST;
print_r($alldata);
$checkuser="SELECT * from settingsmeta WHERE userid='$userid'";

$checkquery=$conn->query($checkuser);
$count=mysqli_num_rows($checkquery);

    if($count>=1)
    {


        foreach($alldata as $index=>$value)
        {
        $data[] = "WHEN metakey='$index' THEN '$value'";
        }
 
        $updatemeta="UPDATE settingsmeta SET value = CASE ".implode(' ',$data)." END WHERE userid='$userid'";
        $updatequery=$conn->query($updatemeta);
                if($updatequery)
                {
                    getmetadata();
                echo json_encode(["status" => 1010]); 
                }    
                else
                {
                    
                }
    }
    else
    {
      
        foreach($alldata as $key=>$values)
        {
        $keys[]= "('NULL','$userid', '$key', '$values')";  
        } 
    
        $insertquery="INSERT INTO `settingsmeta` (`id`,`userid`,`metakey`,`value`) VALUES".implode(',',$keys)."";
        $insertrun=$conn->query($insertquery);
        if($insertquery) 
            {
            echo json_encode(["status" => 1010]); 
            }
    
        else
            {


            }
    }
  

  
  
}

if ($errorMSG != "") 
{
     echo json_encode(["status" => 1003, "msg" => $errorMSG]);
} 

