<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){

include "connect.php";


$sql= "UPDATE albums SET 
        albumname = :albumname,
        albumreleasedate = :albumreleasedate,
        artistid = :artistid
    WHERE albumid = :albumid
    ";

$stmt = $conn->prepare($sql);

$stmt->execute(
    [
        'albumid'=>$_POST['albumid'],
        'albumname'=>$_POST['albumname'],
        'albumreleasedate'=>$_POST['albumreleasedate'],
        'artistid'=>$_POST['artistid'],
    ]
);
    if($stmt->rowCount() <= 1){
        echo "<script>alert('album has been edited')</script>";
        echo "<script>location.replace('dev.php'); </script>";
    } else{
        echo '<script>alert("album HAS NOT been edited")</scriptlocation.replace>';
    }
    echo "<script>location.replace('dev.php'); </script>";

}

?>