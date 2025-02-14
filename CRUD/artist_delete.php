<?php
if($_SERVER['REQUEST_METHOD'] == "GET" &&
    isset($_GET['artistid'])){

        include "connect.php";

$sql= "
        DELETE FROM artists 
        WHERE artistid = :artistid";


$stmt = $conn->prepare($sql);

$stmt->execute(
    [
        ':artistid'=>$_GET['artistid']
    ]
);

    if($stmt->rowCount() == 1){
        echo "<script>alert('artist is deleted')</script>";
        echo "<script>location.replace('dev.php'); </script>";
    } else{
        echo '<script>alert("artist IS NOT deleted")</scriptlocation.replace>';
    }


}
?>