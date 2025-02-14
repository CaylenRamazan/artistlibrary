<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>add artist</title>
  <link rel="stylesheet" href="../style.css?<?php echo time(); ?>">
</head>
<body>

<h2>add artist</h2>

<form method="post">
<!-- <label for="artistid">artistid:</label>
  <input type="text" id="artistid" name="artistid" required><br> -->

  <label for="name">name</label>
  <input type="text" id="name" name="name" required><br>

  <label for="genre">genre:</label>
  <input type="text" id="genre" name="genre" required><br>

  <label for="debutdate">debut date:</label>
  <input type="date" id="dabutdate" name="debutdate" required><br>

  <input class="hover" type="submit" name value="Submit">
</form>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    echo "er is gepost<br>";
include "connect.php";


$sql= "INSERT INTO artists (name, genre, debutdate)
       VALUES (:name, :genre, :debutdate);";


$query = $conn->prepare($sql);

$query->execute(
  [
      // 'artistid'=>$_POST['artistid'],
      'name'=>$_POST['name'],
      'genre'=>$_POST['genre'],
      'debutdate'=>$_POST['debutdate']
  ]
);
echo "<script>
alert('Artist has been added');
location.replace('dev.php'); </script>";

}


if(isset($_POST)){

}

?>


</body>
</html>