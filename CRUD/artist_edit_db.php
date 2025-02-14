<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){

include "connect.php";


$sql= "UPDATE artists SET 
        name = :name,
        genre = :genre,
        debutdate = :debutdate
    WHERE artistid = :artistid
    ";

$stmt = $conn->prepare($sql);

$stmt->execute(
    [
        'artistid'=>$_POST['artistid'],
        'name'=>$_POST['name'],
        'genre'=>$_POST['genre'],
        'debutdate'=>$_POST['debutdate'],
    ]
);
    if($stmt->rowCount() <= 1){
        echo "<script>alert('artist has been edited')</script>";
        echo "<script>location.replace('dev.php'); </script>";
    } else{
        echo '<script>alert("artist HAS NOT been edited")</scriptlocation.replace>';
    }
    echo "<script>location.replace('dev.php'); </script>";

}

?>