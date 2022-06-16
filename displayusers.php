<?php
session_start();
include("dbconnection.php");

$displaydata="SELECT * from registeruser";
$queryrun=$conn->query($displaydata);

$count=mysqli_fetch_assoc($queryrun);

if($count>0)
{  
    while($data_view=mysqli_fetch_assoc($queryrun))
    {  ?>

        <tr>
        <td align="center"><?= $data_view['fname']; ?> </td>
        <td align="center"><?= $data_view['lname']; ?> </td>
        <td align="center"><?= $data_view['uname']; ?> </td>
        <td align="center"><?= $data_view['email']; ?> </td>
        <td align="center" ><?= $data_view['phone']; ?> </td>
    <?php
    if($_SESSION['uname']==$data_view['uname'])
    {
?>
         <td></td>
        <td>
          <button type="submit" class="btn1" data-id="<?= $data_view['id'] ?>" >Edit</button>
         </td>
        </tr>
   
  <?php 
   }
   else{
    ?>
    <td> <button type="submit" class="btn" data-id="<?= $data_view['id'] ?>" >Delete</button>
      </td>
      <td>
      <button type="submit" class="btn1" data-toggle="modal" data-target="#myModal" data-id="<?= $data_view['id'] ?>" >Edit</button>
    
      </td>
        </tr>
  <?php
   }
   ?>     

<?php

    }

}   
else
{
    json_encode(["status"=>344]);
}

?>
<html>
<head>
	<title>Users</title>
    <!-- Ajax -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>




<script>

    $(document).ready(function()
    {
        $(".btn").on("click",function(e)
        {
            var el = this;
            e.preventDefault();
        var id=$(this).attr("data-id");
          var conf=confirm("Are you sure?")
            
        if(conf==true)
            {
                console.log("Delete");
                $.ajax(
                    {
                        url:"delete.php",
                        type:"POST",
                        data:{
                            id:id
                        },
                        success:function(data)
                        {
                        var d=JSON.parse(data);
                        console.log(d.status);
                            if(d.status==100)
                            {
                                
                                $(el).closest('tr').css('background','tomato');
                                $(el).closest('tr').fadeOut(800,function(){
		                        $(this).remove();
		});
                            }  
                            else{
                                alert("Not Deleted");
                            }                      
                        }
                    });
            }
        else{
            console.log("NO");
        }    
            
        })

        $(".btn1").on("click",function(e)
        {
            e.preventDefault();
            var updateid=$(this).attr("data-id");
            console.log("Update Id",updateid);
            $.ajax({
                    url:"fetch.php",
                    type:"POST",
                    data:{
                        updateid:updateid,
                    },
                    success:function(dataresult)
                    {
                       console.log(dataresult);
                       $("#fname").val(dataresult.fname);
                    }
            })
        });

    });
</script>

</body>
</html>