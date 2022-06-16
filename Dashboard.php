<?php

include("dbconnection.php");

session_start();

$uname = $_SESSION['uname'];

$checkquery = "SELECT * from registeruser WHERE uname='$uname'";
$queryrun = $conn->query($checkquery);
$fetchid = mysqli_fetch_assoc($queryrun);
$userid = $fetchid['id'];
$_SESSION['id'] = $userid;
$count = mysqli_num_rows($queryrun);
$SID = session_id();

if ($count >= 1) {

    if ($_SESSION['uname']) {
        $userid = $_SESSION['id'];
        $_SESSION['SID'] = $SID;
        echo "<h2 class='welcome'>Welcome</h2>" . $_SESSION['uname'];
        $offset = 5 * 60 * 60; //converting 5 hours to seconds.
        $dateFormat = "m/d/Y H:i:a";
        $timeNdate = gmdate($dateFormat, time() + $offset);


        $sessiondata = "INSERT into session(sessionid,userid,starttime)VALUES('$SID','$userid','$timeNdate')";
        $queryrun = $conn->query($sessiondata);
    } else {
        header("location:index.php");
    }

?>
    <html>

    <head>
        <title>Dashboard</title>
        <link rel="stylesheet" type="text/css" href="Dashboard.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- For Swal Pop Up -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">


        <!-- DaTatable -->
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    </head>

    <?php



    if (!empty($_SESSION['meta'])) {
        $data = $_SESSION['meta'];
        foreach ($data as $key => $value) {


    ?>
            <style>
                <?php
                if ($value['metakey'] == 'colorcode') {
                ?>.welcome {
                    color: <?= $_SESSION['meta'][$key]['value'] ?> !important;
                }

                <?php
                }
                if ($value['metakey'] == 'fontsize') {
                ?>.td {
                    font-size: <?= $_SESSION['meta'][$key]['value'] ?>px;
                }

                <?php
                }

                if ($value['metakey'] == 'background') {
                ?>body {

                    background-color: <?= $_SESSION['meta'][$key]['value'] ?>;
                }

                <?php
                }

                if ($value['metakey'] == 'font') {
                ?>.text-uppercase {
                    font-family: <?= $_SESSION['meta'][$key]['value'] ?>;
                }

                <?php
                }

                if ($value['metakey'] == 'border') {
                ?>#dataTable {
                    border: <?= $_SESSION['meta'][$key]['value'] ?>px solid;
                }

                <?php
                }
                if ($value['metakey'] == 'width') {
                ?>#dataTable {
                    width: <?= $_SESSION['meta'][$key]['value'] ?>px;
                }

                <?php
                }

                if ($value['metakey'] == 'btncolor') {
                ?>#btnncolor {
                    background-color: <?= $_SESSION['meta'][$key]['value'] ?>;
                }

                <?php
                }

                if ($value['metakey'] == 'btntxtcolor') {
                ?>#btnncolor {
                    color: <?= $_SESSION['meta'][$key]['value'] ?>;
                }

                <?php
                }
                ?>
            </style>

    <?php
        }
    }
    ?>
    <style>
        .dark .text-uppercase {
            color: #FFFFFF;
        }

        .dark label {
            color: #FFFFFF;
        }

        .dark #dataTable {
            border-color: #FFFFFF;
        }

        .dark .text-secondary {
            color: white !important;
        }

        .dark {
            background-color: #222;
            color: #e6e6e6;
        }

        .theme-switch-wrapper {
            display: flex;
            align-items: center;
            float: right;
        }

        .theme-switch {
            display: inline-block;
            height: 34px;
            position: relative;
            width: 60px;
            text-align: right;
        }

        .theme-switch input {
            display: none;
        }

        .slider {
            background-color: #ccc;
            bottom: 0;
            cursor: pointer;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            transition: .4s;
        }

        .slider:before {
            background-color: #fff;
            bottom: 4px;
            content: "";
            height: 26px;
            left: 4px;
            position: absolute;
            transition: .4s;
            width: 26px;
        }

        input:checked+.slider {
            background-color: #66bb6a;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>

    <?php
    ?>

    <body>

        <center>
            <h1>Dashboard</h1>
        </center>
        <div class="theme-switch-wrapper">
            <label class="theme-switch" for="checkbox">
                <input type="checkbox" id="checkbox" />
                <div class="slider round"></div>
            </label>
            <label style="margin-left: 10px;">Select Mode</label>

        </div>
        <!-- modal Starts -->
        <center>
            <div class="container">


                <!-- The Modal -->
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <center>
                                    <h4 class="modal-title">Update Record</h4>
                                </center>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Error Messages -->
                            <div class="display" style="display: none"></div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <form id="fupForm" name="form1" method="POST">
                                    <input type="text" name="fname" id="fname" class="un" placeholder="First Name" required pattern="[A-Za-z]{0,20}||[A-Za-z]{0,20}"><br>
                                    <input type="text" name="lname" id="lname" class="un" placeholder="Last Name" required pattern="[A-Za-z]{0,20}||[A-Za-z]{0,20}"><br>
                                    <input type="tel" name="numb" id="numb" class="un" placeholder="Phone Number" required pattern="[0-9]{11}"> <br>
                                    <input type="reset" id="btnncolor" value="Reset">
                                    <input type="submit" id="btnncolor" name="update" id="update" value="Update">
                                </form>
                            </div>
                            <!-- Modal footer -->
                            <!-- <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </center>
        <a class="btn2" id="btnncolor" href="logout.php">Logout</a>
        <a class="historybtn" href="history.php"><button id="btnncolor">History Log</button></a>
        <a class="setting" id="btnncolor" href="settings.php"><button id="btnncolor">Website Settings</button></a>
        <button class="dbdata" id="btnncolor">Send DB Backup</button>
        <form id="form2" action="" method="post" enctype="multipart/form-data">
            <input id="uploadImage" type="file" name="image" />
            <input id="btnncolor" type="submit" value="Upload">
            <!-- 
<?php

    $getfile = "SELECT * from settingsmeta WHERE userid='$userid'";
    $filequery = $conn->query($getfile);

    $count = mysqli_fetch_assoc($filequery);

    if ($count >= 1) {
        while ($data_view = mysqli_fetch_assoc($filequery)) {
            foreach ($data_view as $key => $value) {
                if ($value == 'filepath') {
?>
    <div class="box">
   <b><p  >Wants to Delete the File</p></b>
    <img class="filedata" data-id="<?= $data_view['id'] ?>" src="https://img.icons8.com/fluency/96/000000/file.png"/>
    </div>
    <?php
                }
            }
        }
    }
    ?> -->


        </form>
        <div class="main">
            <table id="dataTable" border=5>
                <thead>
                    <tr class="header">
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" align='center'>Table ID</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" align='center'>First Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" align='center'>Last Name</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" align='center'>Username</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" align='center'>Email</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" align='center'>Phone Number</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" align='center'>Document</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" align='center'>Actions</th>
                    </tr>
                </thead>
                <tbody id="table">
                    <?php
                    // session_start();
                    $displaydata = "SELECT * from registeruser ";
                    $queryrun = $conn->query($displaydata);
                    $getfile = "SELECT * from settingsmeta";
                    $filequery = $conn->query($getfile);
                    $datafile = mysqli_fetch_assoc($filequery);
                    $count = mysqli_fetch_assoc($queryrun);
                    if ($count > 0) {
                        while ($data_view = mysqli_fetch_assoc($queryrun)) {
                    ?>
                            <tr>
                                <td class="td" align="center"><?= $data_view['id']; ?> </td>
                                <td class="td" align="center"><?= $data_view['fname']; ?> </td>
                                <td class="td" align="center"><?= $data_view['lname']; ?> </td>
                                <td class="td" align="center"><?= $data_view['uname']; ?> </td>
                                <td class="td" align="center"><?= $data_view['email']; ?> </td>
                                <td class="td" align="center"><?= $data_view['phone']; ?> </td>
                                <?php
                                if ($data_view['id'] == $datafile['userid']) {

                                    while ($datafile = mysqli_fetch_assoc($filequery)) {

                                        if ($datafile['metakey'] == "filepath") {

                                ?>

                                            <td align="center">
                                                <img id="filedata" data-id="<?= $datafile['id'] ?>" src="https://img.icons8.com/fluency/96/000000/file.png" />
                                            </td>
                                    <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <td class="td" align="center">File Not Found</td>
                                <?php
                                }
                                ?>

                                <!-- <?php
                                        if ($datafile == "filepath") {   ?>
        <td class="td" align="center" ><?= $datafile['value']; ?> </td>
    <?php
                                        } else { ?>
           <td class="td" align="center" >No File Found</td>  
        <?php
                                        }
        ?> -->


                                <?php
                                if ($_SESSION['uname'] == $data_view['uname']) {
                                ?>

                                    <td class="edit">

                                        <button type="submit" class="btn1" data-toggle="modal" data-target="#myModal" data-id="<?= $data_view['id'] ?>">Edit</button>
                                    </td>
                            </tr>

                        <?php
                                } else {
                        ?>
                            <td>
                                <div class="actionbtns">

                                    <button type="submit" class="btn" id="btnncolor" data-id="<?= $data_view['id'] ?>">Delete</button>
                                    <button type="submit" class="btn1" id="btnncolor" data-toggle="modal" data-target="#myModal" data-id="<?= $data_view['id'] ?>">Edit</button>
                                </div>
                            </td>
                            </tr>
                        <?php
                                }
                        ?>

                <?php

                        }
                    } else {
                        json_encode(["status" => 344]);
                    }

                ?>
                </tbody>
            </table>

            <script type="text/javascript">


$(document).ready(function() {
                    $("#filedata").on("click", function(e) {
                        console.log("red");
                        var el = this;
                        e.preventDefault();
                        var id = $(this).attr("data-id");
                        swal({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            confirmButtonColor: 'red',

                            confirmButtonText: 'Yes, delete it!',
                            showCancelButton: true,
                            cancelButtonColor: 'red',
                        }, function(result) {
                            if (result) {
                                $.ajax({
                                    url: "deletefile.php",
                                    type: "POST",
                                    data: {
                                        id: id
                                    },
                                    cache: false,
                                    success: function(data) {
                                        var d = JSON.parse(data);

                                        if (d.status == 40005) {
                                            $(el).closest('#filedata').css('background', 'tomato');
                                            $(el).closest('#filedata').fadeOut(800, function() {
                                                $(this).remove();
                                            });
                                        }
                                    }


                                })
                            }
                        });
                    });
                });




            </script>



        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#checkbox').click(function() {
                    var element = document.body;
                    var value;
                    element.classList.toggle("dark");

                });
           
            
                $('#dataTable').DataTable();
            
           

                $(".btn").on("click", function(e) {
                    var el = this;
                    e.preventDefault();
                    var id = $(this).attr("data-id");
                    //   var conf=confirm("Are you sure?")
                    swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        confirmButtonColor: 'red',

                        confirmButtonText: 'Yes, delete it!',
                        showCancelButton: true,
                        cancelButtonColor: 'red',
                    }, function(result) {
                        if (result) {
                            console.log("Delete");
                            $.ajax({
                                url: "delete.php",
                                type: "POST",
                                data: {
                                    id: id
                                },
                                success: function(data) {
                                    var d = JSON.parse(data);
                                    console.log(d.status);
                                    if (d.status == 100) {

                                        $(el).closest('tr').css('background', 'tomato');
                                        $(el).closest('tr').fadeOut(800, function() {
                                            $(this).remove();
                                        });
                                    } else {
                                        alert("Not Deleted");
                                    }
                                }
                            });
                        } else {
                            console.log("Not Deleted");
                        }
                    })


                });

                $(".btn1").on("click", function(e) {
                    e.preventDefault();
                    var updateid = $(this).attr("data-id");


                    $.ajax({
                        url: "fetch.php",
                        type: "POST",
                        data: {
                            updateid: updateid,
                        },
                        success: function(dataresult) {

                            var d = JSON.parse(dataresult);
                            $("#fname").val(d.fname);
                            $("#lname").val(d.lname);
                            $("#numb").val(d.phone);

                            $.fn.myFunction(d.id);
                        }
                    })
                });

                $.fn.myFunction = function(id) {


                    $("#update").on("click", function(e) {
                        e.preventDefault();
                        var fname = $("#fname").val();
                        var lname = $("#lname").val();
                        var phone = $("#numb").val();

                        if (fname != "" && lname != "" && numb != null) {
                            $.ajax({

                                url: "update.php",
                                type: "POST",
                                data: {
                                    id: id,
                                    fname: fname,
                                    lname: lname,
                                    phone: phone
                                },
                                success: function(data) {
                                    var d = JSON.parse(data);
                                    if (d.update == 700) {
                                        swal({
                                            title: "Success!",
                                            text: "Record Updated",
                                            type: "success",
                                            confirmButtonColor: 'red',
                                            showConfirmButton: true
                                        }, function() {
                                            location.reload();
                                        });

                                    } else if (d.status == 500) {
                                        $(".display").html("<ul>" + d.msg + "</ul>");
                                        $(".display").css("display", "block");
                                    } else if (d.status == 507) {
                                        $(".display").html("<ul>" + d.msg + "</ul>");
                                        $(".display").css("display", "block");
                                    } else {
                                        alert("Not Updated");
                                    }

                                }

                            })
                        } else {
                            swal({
                                title: "Warning!",
                                text: "Please Fill all the fields",
                                type: "warning",
                                confirmButtonColor: 'red',
                                showConfirmButton: true
                            })
                        }



                    })


                }


                $(".historybtn").on("click", function(e) {
                    e.preventDefault();


                    $.ajax({
                        url: "history.php",
                        type: "GET",
                        data: "",
                        cache: false,

                        success: function(data) {
                            // alert("Hello");
                            // location.href("history.php");
                            window.location = "history.php";

                        }
                    })


                })

                $(".setting").on("click", function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: "settings.php",
                        type: "GET",
                        data: "",
                        cache: false,

                        success: function(data) {

                            window.location = "settings.php";

                        }
                    })
                })
                $(".dbdata").on("click", function(e) {

                    e.preventDefault();
                    $.ajax({

                        url: "dbdump.php",
                        type: "POST",
                        cache: false,



                        success: function(data) {
                            var d = JSON.parse(data);

                            if (d.status == 520) {
                                swal({
                                    title: "Success!",
                                    text: "DB Backup Sent",
                                    type: "success",
                                    confirmButtonColor: 'red',
                                    showConfirmButton: true
                                }, function() {});
                            }

                        }
                    });
                })

                $("#form2").on('submit', (function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "fileupload.php",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            var d = JSON.parse(data);
                            if (d.status == 1) {
                                swal({
                                    title: "Success!",
                                    text: d.title,
                                    type: "success",
                                    confirmButtonColor: 'green',
                                    showConfirmButton: true
                                }, function() {
                                    location.reload();
                                });

                            } else if (d.status == 2) {
                                swal({
                                    title: "Sorry!",
                                    text: d.title,
                                    type: "warning",
                                    confirmButtonColor: 'red',
                                    showConfirmButton: true
                                }, function() {});
                            } else {
                                swal({
                                    title: "Sorry!",
                                    text: d.title,
                                    type: "warning",
                                    confirmButtonColor: 'red',
                                    showConfirmButton: true
                                }, function() {});
                            }
                        }

                    });
                }));

            

            });
        </script>
    </body>

    </html>
<?php
} else {
    header("location:logout.php");
}
?>