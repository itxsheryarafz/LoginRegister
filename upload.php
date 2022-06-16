<?php
include("dbconnection.php");
$imgname=$_FILES['img']['name'];
$filetype=$_FILES['img']['type'];


if($filetype=='image/jpeg' || $filetype=='image/png' || $filetype=='image/jpg')
{
    if($_FILES['img']['size']>1000000)
    {
        echo "Image file should be less than 1 MB";

    }
    else{
        $imgpath="upload/".$imgname;
        move_uploaded_file($_FILES['img']['tmp_name'],$imgpath);
        $imagesave="INSERT into images (images) VALUES('$imgname')";
        $queryrun=$conn->query($imagesave);
        if($queryrun)
        {   
            $msg="Image Uploaded";
            json_encode(["status"=>600,"img"=>$msg]);
        }
        else{
            $msg="Image Not Uploaded";
            json_encode(["status"=>601,"img"=>$msg]);
        }
    }

}
else{
    echo "File should be jpg, jpeg, png";
}


?>