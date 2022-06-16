<?php
include("dbconnection.php");
// require("helper.php");
session_start();


$errorMSG = "";
$fname=mysqli_real_escape_string($conn,$_POST['fname']);
$lname=mysqli_real_escape_string($conn,$_POST['lname']);
$uname=mysqli_real_escape_string($conn,$_POST['uname']);
$email=mysqli_real_escape_string($conn,$_POST['email']);
$numb= mysqli_real_escape_string($conn,$_POST['numb']);
$password= mysqli_real_escape_string($conn,$_POST['password']);
$encryptpass=md5($password);

$checkemail="SELECT * from registeruser WHERE email='$email'";
		$queryruns=$conn->query($checkemail);
		$count=mysqli_num_rows($queryruns);

$checkusername="SELECT * from registeruser WHERE uname='$uname'";
$queryruns=$conn->query($checkusername);
$usercount=mysqli_num_rows($queryruns);		
if($count>0)
{
	$errorMSG .= "<li>Email Already Exist</li>";
	echo json_encode(['status'=>405,"email"=>$errorMSG]);
    			
}
else if($usercount>0)
{
	$errorMSG .= "<li>Username Already Exist</li>";
	echo json_encode(['status'=>406,"uname"=>$errorMSG]);
}
else{

	if(preg_match("/^[a-zA-Z ]*$/",$fname) && preg_match("/^[a-zA-Z ]*$/",$lname) && preg_match("/^[a-zA-Z0-9,]*$/",$uname) && filter_var($email,FILTER_VALIDATE_EMAIL) && strlen($numb) ==11 && strlen($password)==8)
	{

		$sqlquery="INSERT into registeruser(fname,lname,uname,email,phone,password) VALUES('$fname','$lname','$uname','$email','$numb','$encryptpass')";
					$queryrun=$conn->query($sqlquery);
					if($queryrun)
						{
								emailuser($email,$fname,$uname,$password,$numb);
            					$_SESSION['uname']=$uname;
								$_SESSION['email']=$email;
            					echo json_encode(array("status"=>200));
						}
					else{
								echo json_encode(array("status"=>201));
						}

	}
	else{

		if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
				$errorMSG .= "<li>First Name Invalid</li>";

			}

		if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
				$errorMSG .= "<li>Last Name Invalid</li>";

			}

		if(!preg_match("/^[a-zA-Z0-9,]*$/",$uname))
  			{
				$errorMSG .= "<li>UserName Invalid</li>";

  			}

		if(!filter_var($email,FILTER_VALIDATE_EMAIL))
  			{
				$errorMSG .= "<li>Email Invalid</li>";
  			}
		if(strlen($numb) < 11 || strlen($numb) > 11)
  			{
				$errorMSG .= "<li>Number Invalid</li>";

  			}
		if(strlen($password) < 8 || strlen($password) > 8)
  			{
				$errorMSG .= "<li>Password Invalid</li>";
	
 			}
		 echo json_encode(['status'=>404, 'msg'=>$errorMSG]);

	}
	

}

