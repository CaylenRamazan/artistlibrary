<?php

    if(isset($_GET['artistid'])){


        include "connect.php";        
        $sql="SELECT * FROM artists WHERE artistid = :artistid";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':artistid'=>$_GET['artistid']]);
        $result =$stmt->fetch(PDO::FETCH_ASSOC);
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>edit artist</title>
  <link rel="stylesheet" href="../style.css?<?php echo time(); ?>">
</head>
<body>

<h2>edit artist</h2>

<form action="artist_edit_db.php" method="post">
<input type="number" id="artistid" name="artistid" required value="<?php echo $result['artistid']?>" hidden>

  <label for="name">name:</label>
  <input type="text" id="name" name="name" required value="<?php echo $result['name']?>"><br>

  <!-- <label for="id">ID:</label> -->

  <label for="genre">genre:</label>
  <input type="text" id="genre" name="genre" required value="<?php echo $result['genre']?>"><br>

  <label for="debutdate">Prijs:</label>
  <input type="date" id="debutdate" name="debutdate" required value="<?php echo $result['debutdate']?>"><br>

  <input class="hover" type="submit" name value="Submit">
</form>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    echo "er is gepost<br>";
include "connect.php";


$sql= "INSERT INTO songs (artistid, name, genre, debutdate)
       VALUES (:artistid, :name, :genre, :debutdate);";


$query = $conn->prepare($sql);

$query->execute(
    [
        'artistid'=>$_POST['artistid'],
        'name'=>$_POST['name'],
        'genre'=>$_POST['genre'],
        'debutdate'=>$_POST['debutdate'],
    ]
);

}


if(isset($_POST)){

}

?>


</body>
</html>
