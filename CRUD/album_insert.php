<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>add artist</title>
  <link rel="stylesheet" href="../style.css?<?php echo time(); ?>">
</head>
<body>

<h2>add album</h2>

<form method="post">
<!-- <label for="artistid">artistid:</label>
  <input type="text" id="artistid" name="artistid" required><br> -->

  <label for="songname">album name</label>
  <input type="text" id="albumname" name="albumname" required><br>

  <label for="releasedate">release date:</label>
  <input type="date" id="albumreleasedate" name="albumreleasedate" required><br>

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
        </select>

  <input class="hover" type="submit" name value="Submit">
</form>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    echo "er is gepost<br>";
include "connect.php";


$sql= "INSERT INTO albums (albumname, albumreleasedate, artistid)
       VALUES (:albumname, :albumreleasedate, :artistid);";


$query = $conn->prepare($sql);

$query->execute(
  [
      // 'artistid'=>$_POST['artistid'],
      'albumname'=>$_POST['albumname'],
      'albumreleasedate'=>$_POST['albumreleasedate'],
      'artistid'=>$_POST['artistid']
  ]
);
echo "<script>
alert('album has been added');
location.replace('dev.php'); </script>";

}


if(isset($_POST)){

}

?>


</body>
</html>