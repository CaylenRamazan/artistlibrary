<?php
if($_SERVER['REQUEST_METHOD'] == "GET" &&
    isset($_GET['songid'])){

        include "connect.php";

$sql= "
        DELETE FROM songs 
        WHERE songid = :songid";


$stmt = $conn->prepare($sql);

$stmt->execute(
    [
        ':songid'=>$_GET['songid']
    ]
);

    if($stmt->rowCount() == 1){
        echo "<script>alert('song is deleted')</script>";
        echo "<script>location.replace('dev.php'); </script>";
    } else{
        echo '<script>alert("song IS NOT deleted")</scriptlocation.replace>';
    }


}
?>