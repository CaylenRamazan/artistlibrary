<?php
if($_SERVER['REQUEST_METHOD'] == "GET" &&
    isset($_GET['albumid'])){

        include "connect.php";

$sql= "
        DELETE FROM albums 
        WHERE albumid = :albumid";


$stmt = $conn->prepare($sql);

$stmt->execute(
    [
        ':albumid'=>$_GET['albumid']
    ]
);

    if($stmt->rowCount() == 1){
        echo "<script>alert('album is deleted')</script>";
        echo "<script>location.replace('dev.php'); </script>";
    } else{
        echo '<script>alert("album IS NOT deleted")</scriptlocation.replace>';
    }


}
?>