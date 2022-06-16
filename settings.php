<?php
session_start();
include("dbconnection.php");

if(!$_SESSION['id'])
{
  header("location:index.php");
}
else{


$userid=$_SESSION['id'];
// error_reporting(0);

$getmeta="SELECT metakey,value from settingsmeta where userid = '$userid' ";

$getquery=$conn->query($getmeta);

while($item = $getquery->fetch_assoc()){
    
    $settingData[]=$item;
}
$fetchdata=mysqli_num_rows($getquery);

?>
<html>
<head>
  <title>Settings</title>
  <link rel="stylesheet" type="text/css" href="setting.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

     <!-- bootstrap -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


  <!-- Swal Alert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

  <!-- Color Picker  -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.css"
    rel="stylesheet">



</head>

<style>


.custom-size .colorpicker-saturation {
    width: 180px;
    height: 160px;
}

.custom-size .colorpicker-hue,
.custom-size .colorpicker-alpha {
    width: 40px;
    height: 100px;
}

.custom-size .colorpicker-color,
.custom-size .colorpicker-color div {
    height: 20px;
}


</style>
<body>

<center><h1>Dashboard</h1></center>

<div class="theme-switch-wrapper">
        <label class="theme-switch" for="checkbox">
            <input type="checkbox" id="checkbox" />
            <div class="slider round"></div>
        </label>
   <b><label style="margin-left: 10px;">Select Mode</label></b> 
</div>
<div class="display" style="display: none"></div>
<div class="main">
    <p class="sign" align="center">Website Settings</p>
    <form class="form1" method="POST" action="">
   <center><b><label>Text Color Code</label></b></center>
    <input class="un" id="colorcode" type="text" align="center" name="colorcode" readonly  <?php if($fetchdata != NULL){?> value=<?= $settingData[0]['value'];  } else {?> value="" <?php  }?>  >
    <center><label><b>Font Size</b></label></center>
    <center><p>Enter number in pixel</p></center>
    <input class="pass" id="fontsize" type="number" align="center" name="fontsize"  <?php if($fetchdata != NULL){?> value=<?= $settingData[1]['value'];  } else {?> value="" <?php  }?>  >
    <center><label><b>Background Color</b></label></center>
    <input class="un " id=background type="text" align="center" name="backgroundcolor" readonly <?php if($fetchdata != NULL){?> value=<?= $settingData[2]['value'];  } else {?> value="" <?php  }?> >
    <center><label><b>Font Family</b></label></center>
 <center>  <select name="font" id="font" >
        <option value="Georgia, serif" <?php if($fetchdata!=NULL){ if($settingData[3]['value']=="Georgia, serif"){ echo 'selected="selected"';}}?>>Georgia, serif</option>
        <option value="sans-serif" <?php if($fetchdata!=NULL){ if($settingData[3]['value']=="sans-serif"){ echo 'selected="selected"';}} ?>>sans-serif</option>
        <option value="Arial, Helvetica, sans-serif" <?php if($fetchdata!=NULL){ if($settingData[3]['value']=="Arial, Helvetica, sans-serif") { echo 'selected="selected"';}} ?>>Arial, Helvetica, sans-serif</option>
        <option value="Comic Sans, Comic Sans MS, cursive" <?php if($fetchdata!=NULL){ if($settingData[3]['value']=="Comic Sans, Comic Sans MS, cursive"){ echo 'selected="selected"';}} ?>>Comic Sans, Comic Sans MS, cursive</option>
    </select>
    </center> 
    <center><label><b>Border</b></label></center>
   <center><p>Enter number in pixel</p></center> 
    <input class="un " id="border" type="number" align="center" name="border" <?php if($fetchdata != NULL){?> value=<?= $settingData[4]['value'];  } else {?> value="" <?php  }?> >
    <center><label><b>Width for Table</b></label></center>
    <center> <p>Width should be greater than 750 px</p></center>
    <input class="un " id="width" type="number" align="center" name="width"  <?php if($fetchdata != NULL){?> value=<?= $settingData[5]['value'];  } else {?> value="" <?php  }?> >
    <center><label><b>Buttons Color</b></label></center>
    <input class="un " id="btncolor" type="text" align="center" name="btncolor" readonly <?php if($fetchdata != NULL){?> value=<?= $settingData[7]['value'];  } else {?> value="" <?php  }?> >
    <center><label><b>Buttons Text Color</b></label></center>
    <input class="un " id="btntxtcolor" type="text" align="center" name="btntxtcolor" readonly <?php if($fetchdata != NULL){?> value=<?= $settingData[6]['value'];  } else {?> value="" <?php  }?>  >
    <input class="submit" type="submit" value="Add" name="btn" align="center"> 
    </form>                
    </div>

    <script type="text/javascript">
    

    $(function () {
      $('#colorcode').colorpicker(
        {
          customClass: 'custom-size',
                  sliders: {
                      saturation: {
                          maxLeft: 250,
                          maxTop: 250
                      },
                      hue: {
                          maxTop: 250
                      },
                      alpha: {
                          maxTop: 250
                      }
                  }    
           }
      );
      $('#background').colorpicker(
        {
          customClass: 'custom-size',
                  sliders: {
                      saturation: {
                          maxLeft: 250,
                          maxTop: 250
                      },
                      hue: {
                          maxTop: 250
                      },
                      alpha: {
                          maxTop: 250
                      }
                  }    
           }
      );
      $('#btncolor').colorpicker(
        {
          customClass: 'custom-size',
                  sliders: {
                      saturation: {
                          maxLeft: 250,
                          maxTop: 250
                      },
                      hue: {
                          maxTop: 250
                      },
                      alpha: {
                          maxTop: 250
                      }
                  }    
           }
      );
      $("#btntxtcolor").colorpicker(
        {
          customClass: 'custom-size',
                  sliders: {
                      saturation: {
                          maxLeft: 250,
                          maxTop: 250
                      },
                      hue: {
                          maxTop: 250
                      },
                      alpha: {
                          maxTop: 250
                      }
                  }    
           }
      );

      $("#dashtxtcolor").colorpicker(
        {
          customClass: 'custom-size',
                  sliders: {
                      saturation: {
                          maxLeft: 250,
                          maxTop: 250
                      },
                      hue: {
                          maxTop: 250
                      },
                      alpha: {
                          maxTop: 250
                      }
                  }    
           }
      );

    });
    $(document).ready(function()
    {
        
        var form=$(".form1");
        $(".submit").on("click",function(e)
        {
            e.preventDefault();

            // var colorcode=$("#colorcode").val();
            // var fontsize=$("#fontsize").val();
            // var background=$("#background").val();
            // var font=$("#font").val();
            // var border=$("#border").val();
            // var width=$("#width").val();
            // var btncolor=$("#btncolor").val();
            // var btntxtcolor=$("#btntxtcolor").val();

                $.ajax({

                    url:"settingajax.php",
                    type:"POST",
                    cache:false,
                    data:$(".form1 input,select").serialize(),
                    success:function(data)
                    {
                     var d=JSON.parse(data);
                     console.log(d);
                       
                         
                           if(d.status==1003)
                           {

                            swal({
                                      title: 'Oops...',
                                      text: '<p style="color:red;">'+d.msg+'</hp>',
                                       icon: 'warning',
                                       confirmButtonColor: 'red',
                                        html:true,
                                     
                                })
                           }
                        else if(d.status==1010){
                                swal({
                                title: "Success",
                                text: "",
                                type: "success",
                                confirmButtonColor: 'red',
                                showConfirmButton: true
                                },
                                        function()
                                        {
                                            window.location= "Dashboard.php";
                                        }) 
                           
                           }
                            
                    }
                })
        })
    })
    </script>
</body>
</html>
<?php
}
?>