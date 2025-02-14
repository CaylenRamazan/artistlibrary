<?php
include "CRUD/connect.php"; 
include "nav.php";

if (isset($_GET['artistid'])) {
    $artistId = $_GET['artistid']; //Haal het artistid uit de URL

    try {
        //Haal artiestgegevens op
        $artistQuery = $conn->prepare("SELECT * FROM artists WHERE artistid = :artistid");
        $artistQuery->bindParam(':artistid', $artistId, PDO::PARAM_INT);
        $artistQuery->execute();
        $artistData = $artistQuery->fetch(PDO::FETCH_ASSOC);

        if ($artistData) {
            //Haal liedjes van de artiest op
            $songsQuery = $conn->prepare("SELECT * FROM songs WHERE artistid = :artistid");
            $songsQuery->bindParam(':artistid', $artistId, PDO::PARAM_INT);
            $songsQuery->execute();
            $songs = $songsQuery->fetchAll(PDO::FETCH_ASSOC);

            //haal albums op van de artiest op
            $albumsQuery = $conn->prepare("SELECT * FROM albums WHERE artistid = :artistid");
            $albumsQuery->bindParam(':artistid', $artistId, PDO::PARAM_INT);
            $albumsQuery->execute();
            $albums = $albumsQuery->fetchAll(PDO::FETCH_ASSOC);


            //Tel het aantal liedjes
            $totalSongs = count($songs);
        } else {
            echo "<p>NO artist found with id: " . htmlspecialchars($artistId) . ".</p>";
            exit;
        }
    } catch (Exception $e) {
        echo "<p>Something went wrong :(: " . htmlspecialchars($e->getMessage()) . "</p>";
        exit;
    }
} else {
    echo "<p>NO artist id in URL.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($artistData['name']); ?></title>
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
</head>
<body>
    <?php include "nav.php"; ?>

    <h1><?php echo htmlspecialchars($artistData['name']); ?></h1>
    <div class="artist_info">
    <div class="artist_info_links">
    <p>Genre: <?php echo htmlspecialchars($artistData['genre']); ?></p>
    <p>Debut date: <?php echo htmlspecialchars($artistData['debutdate']); ?></p>
    </div>
    <div class="song_count">
        <h1>Songs published:</h1>
        <p><?php echo $totalSongs; ?></p>
    </div>
    </div>
    
    <div class="artist_songs">
    <h2>Songs of this artist</h2>
    <?php if (!empty($songs)) : ?>
        <table class="artist_songs_table">
                <tr>
                    <th>Song Name</th>
                    <th>Release Date</th>
                </tr>
            <?php foreach ($songs as $song) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($song['songname']); ?></td>
                    <td><?php echo htmlspecialchars($song['releasedate']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php else : ?>
        <p>Deze artiest heeft nog geen liedjes in de database.</p>
    <?php endif; ?>
    
    <div class="artist_songs">
    <h2>Albums of this artist</h2>
    <?php if (!empty($albums)) : ?>
        <table class="artist_songs_table">
                <tr>
                    <th>Album Name</th>
                    <th>Release Date</th>
                </tr>
            <?php foreach ($albums as $album) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($album['albumname']); ?></td>
                    <td><?php echo htmlspecialchars($album['albumreleasedate']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php else : ?>
        <p>Deze artiest heeft nog geen albums in de database.</p>
    <?php endif; ?>
</body>
</html>