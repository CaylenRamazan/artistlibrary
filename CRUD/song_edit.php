<?php

    if(isset($_GET['songid'])){


        include "connect.php";        
        $sql="SELECT * FROM songs WHERE songid = :songid";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':songid'=>$_GET['songid']]);
        $result =$stmt->fetch(PDO::FETCH_ASSOC);
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>edit song</title>
  <link rel="stylesheet" href="../style.css?<?php echo time(); ?>">
</head>
<body>

<h2>edit song</h2>

<form action="song_edit_db.php" method="post">
<input type="number" id="songid" name="songid" required value="<?php echo $result['songid']?>" hidden>

  <label for="songname">song name:</label>
  <input type="text" id="songname" name="songname" required value="<?php echo $result['songname']?>"><br>

  <!-- <label for="id">ID:</label> -->

  <label for="releasedate">release date:</label>
  <input type="date" id="releasedate" name="releasedate" required value="<?php echo $result['releasedate']?>"><br>

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
    
        <label for="albumid">Select album:</label><br>
        <select id="albumid" name="albumid" required>
            <?php
                include "connect.php";

                // Haal de artiesten op
                $sql = "SELECT albumid, albumname FROM albums";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($albums) {
                    foreach ($albums as $album) {
                        $selected = ($album['albumid'] == $result['albumid']) ? 'selected' : '';
                        echo "<option value='" . $album["albumid"] . "' " . $selected . ">" . $album["albumid"] ." ". $album["albumname"] . "</option>";
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


$sql= "INSERT INTO songs (songid, songname, releasedate, artistid, albumid)
       VALUES (:songid, :songname, :releasedate, :artistid, :albumid);";


$query = $conn->prepare($sql);

$query->execute(
    [
        'songid'=>$_POST['songid'],
        'songname'=>$_POST['songname'],
        'releasedate'=>$_POST['releasedate'],
        'artistid'=>$_POST['artistid'],
        'albumid'=>$_POST['albumid'],
    ]
);

}


if(isset($_POST)){

}

?>


</body>
</html>