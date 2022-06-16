<?php
session_start();

if($_SESSION)
{
    header("location:Dashboard.php");
}
else
{
?>
<html>
<head>
	<title></title>
    <link rel="stylesheet" type="text/css" href="Register.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- SWAL popups -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
</head>
<body>
    <center>
    <form class="form1" id="fupform" method="POST">
    <h1>Log in</h1>
    <input type="text" name="uname" id="uname" placeholder="Enter Your Username" required><br>
    <input type="password" name="password" id="password" placeholder="Enter Your Password" required><br>
    <input type="reset" id="btn2" value="Reset">
    <input type="submit" id="btn" value="Login" name="login" >

    </form>
  <a href="Register.php"> <button type="submit" id="btn1" >Dont have a Account</button></a>
    </center>

    <script type="text/javascript">

        $(document).ready(function()
        {    
            $("#btn").on("click",function(e)
            {
              
                e.preventDefault();
               
                // $("btn").attr("disabled","disabled");
                var uname=$("#uname").val();
                var password=$("#password").val();
                console.log("HERE");
                console.log(uname);
                console.log(password);
                if(uname!="" && password!="")
                {

                    $.ajax(
                        {
                            url:"loginsave.php",
                            type:"POST",
                            data:{

                                uname:uname,
                                password:password
                            },
                            success:function(dataResult)
                            {
                                var dataResult = JSON.parse(dataResult);
                                console.log(dataResult);
                                if(dataResult.statusCode==200)
                                {
                                location.href="Dashboard.php";
                                }
                                else if(dataResult.statusCode==201)
                                {
                                    swal({
                     title: "Warning!",
                     text: "Invalid Credentials",
                     type: "warning",
                     confirmButtonColor: 'red',
                    showConfirmButton: true
                                        })
                                } 
                            }

                        }
                    )
                }


            })
        })

    </script>
</body>
</html>
<?php
}
?>
