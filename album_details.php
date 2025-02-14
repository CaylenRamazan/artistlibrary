<?php
include "nav.php"; // Navigatiebalk
include "CRUD/connect.php"; // Databaseverbinding

// Haal het album ID uit de URL
if (!isset($_GET['albumid']) || empty($_GET['albumid'])) {
    die("No album id in url.");
}

$albumid = $_GET['albumid'];

// Query om albuminformatie en bijbehorende liedjes op te halen
$sql = "SELECT 
            albums.albumname, 
            albums.albumreleasedate, 
            artists.artistid,
            artists.name AS artistname, 
            songs.songname
        FROM albums
        INNER JOIN artists ON albums.artistid = artists.artistid
        INNER JOIN songs ON albums.albumid = songs.albumid
        WHERE albums.albumid = :albumid";

// Bereid de query voor en voer uit
$stmt = $conn->prepare($sql);
$stmt->bindParam(':albumid', $albumid, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Controleer of er resultaten zijn
if (empty($result)) {
    die("No information found for this album.");
}

// Haal algemene albuminformatie (eerste rij)
$album_info = $result[0];

// Query om het aantal liedjes in het album te tellen
$count_sql = "SELECT COUNT(*) AS song_count FROM songs WHERE albumid = :albumid";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->bindParam(':albumid', $albumid, PDO::PARAM_INT);
$count_stmt->execute();
$song_count = $count_stmt->fetch(PDO::FETCH_ASSOC)['song_count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($album_info['albumname']); ?></title>
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
</head>
<body>
    <h1><?php echo htmlspecialchars($album_info['albumname']); ?></h1>
    <div class="album_page">
        <div class="album_info">
            <p><strong>Artist:</strong> 
                <a href="artist_details.php?artistid=<?php echo htmlspecialchars($album_info['artistid']); ?>">
                    <?php echo htmlspecialchars($album_info['artistname']); ?>
                </a>
            </p>
            <p><strong>Release Date:</strong> <?php echo htmlspecialchars($album_info['albumreleasedate']); ?></p>
            <p><strong>Total Songs:</strong> <?php echo htmlspecialchars($song_count); ?></p>
        </div>
        <div class="song_list">
        <h2>Songs in this Album</h2>
                <?php
                foreach ($result as $row) {
                    echo "<li>" . htmlspecialchars($row['songname']) . "</li>";
                }
                ?>
        </div>
    </div>
</body>
</html>