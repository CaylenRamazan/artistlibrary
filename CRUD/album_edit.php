<?php

    if(isset($_GET['albumid'])){


        include "connect.php";        
        $sql="SELECT * FROM albums WHERE albumid = :albumid";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':albumid'=>$_GET['albumid']]);
        $result =$stmt->fetch(PDO::FETCH_ASSOC);
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> edit album</title>
  <link rel="stylesheet" href="../style.css?<?php echo time(); ?>">
</head>
<body>

<h2>edit album</h2>

<form action="album_edit_db.php" method="post">
<input type="number" id="albumid" name="albumid" required value="<?php echo $result['albumid']?>" hidden>

  <label for="albumname">song name:</label>
  <input type="text" id="albumname" name="albumname" required value="<?php echo $result['albumname']?>"><br>

  <!-- <label for="id">ID:</label> -->

  <label for="albumreleasedate">release date:</label>
  <input type="date" id="albumreleasedate" name="albumreleasedate" required value="<?php echo $result['albumreleasedate']?>"><br>

  <label for="artistid">Select artist:</label><br>
        <select id="artistid" name="artistid" required>
            <?php
                include "connect.php";

                // Haal de artiesten op
                $sql = "SELECT artistid, name FROM artists";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $artists = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($artists) {
                    foreach ($artists as $artist) {
                        $selected = ($artist['artistid'] == $result['artistid']) ? 'selected' : '';
                        echo "<option value='" . $artist["artistid"] . "' " . $selected . ">" . $artist["artistid"] ." ". $artist["name"] . "</option>";
                    }
                }
            ?>
        </select>

  <input type="submit" name value="Submit">
</form>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    echo "er is gepost<br>";
include "connect.php";


$sql= "INSERT INTO albums (albumid, albumname, albumreleasedate, artistid)
       VALUES (:albumid, :albumname, :albumreleasedate, :artistid);";


$query = $conn->prepare($sql);

$query->execute(
    [
        'albumid'=>$_POST['albumid'],
        'albumname'=>$_POST['albumname'],
        'albumreleasedate'=>$_POST['albumreleasedate'],
        'artistid'=>$_POST['artistid'],
    ]
);

}


if(isset($_POST)){

}

?>


</body>
</html>