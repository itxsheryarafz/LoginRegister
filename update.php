<?php
$errorMSG="";
include("dbconnection.php");
$id=$_POST['id'];

if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['phone']))
{


$fname=mysqli_real_escape_string($conn,$_POST['fname']);
$lname=mysqli_real_escape_string($conn,$_POST['lname']);
$numb= mysqli_real_escape_string($conn,$_POST['phone']);
if(preg_match("/^[a-zA-Z ]*$/",$fname) && preg_match("/^[a-zA-Z ]*$/",$lname) && strlen($numb) ==11)
{
            
        $updateuser="UPDATE registeruser SET fname='$fname', lname='$lname',phone='$numb' WHERE id='$id'";
        $queryrun= $conn->query($updateuser);

            if($queryrun)
                {
    
              echo  json_encode(["update"=>700]);
                }
            else
                {
                echo  json_encode(["update"=>701]); 
                }

}  
else{

                if (!preg_match("/^[a-zA-Z ]*$/",$fname)) 
                {
                             $errorMSG .= "<li>First Name Invalid</li>";

                 }

                 if (!preg_match("/^[a-zA-Z ]*$/",$lname)) 
                 {
                            $errorMSG .= "<li>Last Name Invalid</li>";

                }

               
             
                if(strlen($numb) < 11 || strlen($numb) > 11)
                {
                            $errorMSG .= "<li>Number Invalid</li>";

                }
            

                echo json_encode(['status'=>500, 'msg'=>$errorMSG]);

    }

}
else{
   echo json_encode(['status'=>507,'msg'=>"Please Dont empty any field"]);
}





?>