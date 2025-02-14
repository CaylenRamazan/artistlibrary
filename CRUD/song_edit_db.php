<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){

include "connect.php";


$sql= "UPDATE songs SET 
        songname = :songname,
        releasedate = :releasedate,
        artistid = :artistid,
        albumid = :albumid
    WHERE songid = :songid
    ";

$stmt = $conn->prepare($sql);

$stmt->execute(
    [
        'songid'=>$_POST['songid'],
        'songname'=>$_POST['songname'],
        'releasedate'=>$_POST['releasedate'],
        'artistid'=>$_POST['artistid'],
        'albumid'=>$_POST['albumid'],
    ]
);
    if($stmt->rowCount() <= 1){
        echo "<script>alert('Song has been edited')</script>";
        echo "<script>location.replace('dev.php'); </script>";
    } else{
        echo '<script>alert("song HAS NOT been edited")</scriptlocation.replace>';
    }
    echo "<script>location.replace('dev.php'); </script>";

}

?>