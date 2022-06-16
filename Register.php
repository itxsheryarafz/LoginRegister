<?php


session_start();

if($_SESSION)
{
	header("location:Dashboard.php");
}
else{
?>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="Register.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	
    <!-- For Swal Pop Up -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

</head>
<body>
<div class="display" style="display: none"></div>


<center>
<form id="fupForm" name="form1" method="POST">
<h1>Register YourSelf</h1>
<input type="text"  name="fname" id="fname" placeholder="First Name" required pattern="[A-Za-z]{0,20}||[A-Za-z]{0,20}" ><br>
<input type="text"  name="lname" id="lname" placeholder="Last Name"  required pattern="[A-Za-z]{0,20}||[A-Za-z]{0,20}" ><br>
<input type="text"  name="uname" id="uname" placeholder="User Name" required pattern="[A-Z||a-z0-9]{5,40}"><br>
<input type="email"  name="email" id="email" placeholder="Email" required ><br>
<input type="tel" name="numb" id="numb" placeholder="Phone Number" required pattern="[0-9]{11}"> <br>
    
<input type="password"  name="password" id="password" placeholder="Password" required pattern="[A-Z||a-z||0-9]{8}"><br>

<input type="reset" value="Reset">
<input type="submit"  name="register" id="btn" value="Register">
</form>
</center>
<script type="text/javascript">

$(document).ready(function() 
{

	$("#btn").on("click",function(e)
	{
		e.preventDefault();
		
		// $("#btn").attr("disabled", "disabled");
		var fname=$("#fname").val();
		var lname=$("#lname").val();
		var uname=$("#uname").val();
		var email=$("#email").val();
		var numb=$("#numb").val();
		var password=$("#password").val();
		if(fname!="" && lname!="" && uname!="" && email!="" && numb!=null && password!=""){
		$.ajax(
			
			{
				url: "save.php",
				type: "POST",
				data: {
					fname: fname,
					lname:lname,
					uname:uname,
					email: email,
					numb: numb,
					password: password				
				},
				cache: false,
				beforeSend:function(){

				},
				success: function(dataResult){
						// var b = JSON.parse(dataResult);
				var d = JSON.parse(dataResult);
					// console.log("Response is ",d);
					console.log(d);
					// console.log(d.status);
					if(d.status==200){
						$("#btn").removeAttr("disabled");
						$('#fupForm').find('input:text').val('');					
						 location.href = "Dashboard.php";	
					}
					else if(d.status==404){
						$(".display").html("<ul>"+d.msg+"</ul>");
						$(".display").css("display","block");
					}
					
					else if(d.status==405)
					{
						$(".display").html("<ul>"+d.email+"</ul>");
						$(".display").css("display","block");
					}
					else if(d.status==406)
					{
						$(".display").html("<ul>"+d.uname+"</ul>");
						$(".display").css("display","block");
					}
					
				}
			});
		}
		else{

			swal({
                     title: "Warning!",
                     text: "Please Fill all the fields",
                     type: "warning",
                     confirmButtonColor: 'red',
                    showConfirmButton: true
            	 });
		}
			



	});

});

</script>
</body>
</html>

<?php
}

?>