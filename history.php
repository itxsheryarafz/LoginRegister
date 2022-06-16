<?php
session_start();

if($_SESSION['uname'])
{

$SID=$_SESSION['SID'];
$id=$_SESSION['id'];

include("dbconnection.php");

 $fetchdata="SELECT * from session WHERE sessionid='$SID'";
 $queryrun=$conn->query($fetchdata);

 $fetchuser="SELECT * from registeruser WHERE id='$id'";
 $userquery=$conn->query($fetchuser);
 
 $countuser=mysqli_num_rows($userquery);
 $count=mysqli_num_rows($queryrun);
 $user=mysqli_fetch_assoc($userquery);
}
else{

    header("location:index.php");
}
?>

<html>
<head>
  <title>History Log</title>
    <!-- Css -->
    <link rel="stylesheet" type="text/css" href="history.css">

    <!-- AJAX -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

      <!-- DaTatable -->
      <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
</head>

<style>

table.dataTable {
    position: relative;
    right: 60%;
}
</style>
<body>
<center><h1><u>HISTORY LOGS</u></h1></center>
<div class="main">
<table id="dataTable" border=5 width=600 >  

<thead>
<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" align='center' >User Name</th>
<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" align='center' >Session key</th>
<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" align='center' >Login Time</th>
<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" align='center' >Log Out Time</th>
</thead>

<tbody>

    <?php
    if($count>=1)
    {
        while($sessiondata=mysqli_fetch_assoc($queryrun))
        {
            ?>
         <tr>
        <td align="center"><?= $user['uname'] ?></td>
        <td align="center"><?= $sessiondata['sessionid'] ?></td>  
        <td align="center"><?= $sessiondata['starttime'] ?></td>
        <td align="center"><?= $sessiondata['endtime'] ?></td>
        </tr>
      <?php      
            }

    }
    else{

       echo "Record Not found";
    }
        ?>
</tbody>
</table>
</div>

<script type="text/javascript">
 $(document).ready(function()
        {
            $('#dataTable').DataTable();
        });

  $(document).ready(function()
  {

  });      
</script>


</body>
</html>