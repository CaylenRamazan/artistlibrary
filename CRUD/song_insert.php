<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>add artist</title>
  <link rel="stylesheet" href="../style.css?<?php echo time(); ?>">
</head>
<body>

<h2>Add Song</h2>

<form method="post">
<!-- <label for="artistid">artistid:</label>
  <input type="text" id="artistid" name="artistid" required><br> -->

  <label for="songname">songname</label>
  <input type="text" id="songname" name="songname" required><br>

  <label for="releasedate">release date:</label>
  <input type="date" id="releasedate" name="releasedate" required><br>

  <label for="artistid">Select artist:</label><br>
        <select id="artistid" name="artistid" required>
            <option value="" disabled selected>select artist</option>
            <?php
                include "connect.php";

                $sql = "SELECT artistid, name FROM artists";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($result) {
                    foreach ($result as $row) {
                        echo "<option value='" . $row["artistid"] . "'>" . $row["name"] . "</option>";
                    }
                }
                ?>
        </select><br>
        <label for="albumid">Select album:</label><br>
        <select id="albumid" name="albumid" required>
            <option value="" disabled selected>select album</option>
            <?php
                include "connect.php";

                $sql = "SELECT albumid, albumname FROM albums";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($result) {
                    foreach ($result as $row) {
                        echo "<option value='" . $row["albumid"] . "'>" . $row["albumname"] . "</option>";
                    }
                }
                ?>
        </select>

  <input class="hover" type="submit" name value="Submit">
</form>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    echo "er is gepost<br>";
include "connect.php";


$sql= "INSERT INTO songs (songname, releasedate, artistid, albumid)
       VALUES (:songname, :releasedate, :artistid, :albumid);";


$query = $conn->prepare($sql);

$query->execute(
  [
      // 'artistid'=>$_POST['artistid'],
      'songname'=>$_POST['songname'],
      'releasedate'=>$_POST['releasedate'],
      'artistid'=>$_POST['artistid'],
      'albumid'=>$_POST['albumid']
  ]
);
    if ($albumid == 0) {
        echo "<script>
                alert('The song has been added as a single.');
                location.replace('dev.php');
            </script>";
    } else {
        echo "<script>
                alert('The song has been added to the album.');
                location.replace('dev.php');
            </script>";
    }

}
if(isset($_POST)){

}

?>


</body>
</html>