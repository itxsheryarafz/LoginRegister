<?php
session_start();
include("dbconnection.php");

if($_SESSION['uname'])
{
if(isset($_POST['uname']) && isset($_POST['password']))
{
    
    $uname=mysqli_real_escape_string($conn,$_POST['uname']);
    $password=mysqli_real_escape_string($conn,$_POST['password']);

    $encryptpass=md5($password);

    $checkquery="SELECT * from registeruser WHERE uname='$uname' AND password='$encryptpass'";
    $queryrun=$conn->query($checkquery);
    $fetchid=mysqli_fetch_assoc($queryrun);
    $userid=$fetchid['id'];
    $count=mysqli_num_rows($queryrun);
    $SID=session_id();
    if($count>=1)
    {
        
         $_SESSION['SID']=$SID;
         $_SESSION['id']=$userid;   
         $_SESSION['uname']=$uname;
         getmetadata(); 
         $offset=5*60*60; 
         $dateFormat="m/d/Y H:i:a";
         $timeNdate=gmdate($dateFormat, time()+$offset);
     
     
         $sessiondata="INSERT into session(sessionid,userid,starttime)VALUES('$SID','$userid','$timeNdate')";
         $queryrun=$conn->query($sessiondata);
     
        if(isset($_SESSION['uname']))
        {
          
            echo json_encode(array("statusCode"=>200));
        }
        else{
            echo json_encode(array("statusCode"=>201));
        }
         
     
    }
    else{
        echo json_encode(array("statusCode"=>201));
    }

}
}
else
{
    header("location:index.php");
}

?>