<?php


function getmetadata()
{
    $dbconn = mysqli_connect(DBHOST,DBUSERNAME,DBPASSWORD,DBUSER);
    $userid=$_SESSION['id'];
    $checkdata="SELECT metakey,value from settingsmeta WHERE userid='$userid'";
    $queryrun=$dbconn->query($checkdata);
    $count=mysqli_num_rows($queryrun);
    if($count>=1)
    {
    while($row=mysqli_fetch_assoc($queryrun))
    {
        $data[]=$row;
    }
    $_SESSION['meta']=$data;    
    }
    else{
      
        mysqli_close($dbconn);
    }
}

function emailuser($email,$fname,$uname,$password,$numb)
{
    $to_email = $email;
    $subject = "Thanks for Registration";
    $headers = "Content-type:text/html; charset=ISO-8859-1";
    $message="<html><body>
    <h3>New User Registered</h3>
    <p>Username</p>$uname
    <p><b>First Name</b></p> $fname
    <p><b>Phone Number</b></p>$numb
    <p><b>Your Password is </b></p>$password
    </body></html>";

    
    if (mail($to_email, $subject, $message,$headers)) {
       
        $adminsubject="New User Registered";
        $headers = "Content-type:text/html; charset=ISO-8859-1";
   
        $message="<html><body>
        <h3>New User Registered</h3>
        <table border=1>
        <tr>
        <th>
        Username
        </th>
        <th>
        Name
        </th>
        <th>
        Phone number
        </th>
        </tr>
        <tr>
        <td>$uname</td>
        <td>$fname</td>
        <td>$numb</td>
        </tr>
        </body></html>";
   

        mail("shehryar.devp@gmail.com",$adminsubject,$message,$headers);
    }
     else {

           }
    
}



?>