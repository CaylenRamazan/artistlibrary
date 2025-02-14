<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Albums</title>
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
</head>
<body>
<?php
    include "nav.php"; // Navigatiebalk
    include "CRUD/connect.php"; // Databaseverbinding

    // Basis SQL-query met INNER JOINs
    $sql = "SELECT 
                albums.albumname, 
                albums.albumreleasedate, 
                albums.albumid, 
                albums.artistid, 
                artists.name AS artistname, 
                COUNT(songs.songid) AS song_count
            FROM albums
            INNER JOIN artists ON albums.artistid = artists.artistid
            LEFT JOIN songs ON albums.albumid = songs.albumid
            WHERE 1=1";

    $params = [];
    $order_by = "albums.albumreleasedate ASC"; // Standaard sortering: vroegste eerst

    // Filter logica
    if (!empty($_GET['search'])) {
        $search = "%" . $_GET['search'] . "%";
        $sql .= " AND (albums.albumname LIKE :search OR artists.name LIKE :search)";
        $params[':search'] = $search;
    }

    // Sorteeroptie
    if (!empty($_GET['sort'])) {
        if ($_GET['sort'] === 'newest') {
            $order_by = "albums.albumreleasedate DESC"; // Nieuwste eerst
        } elseif ($_GET['sort'] === 'oldest') {
            $order_by = "albums.albumreleasedate ASC"; // Vroegste eerst
        }
    }

    $sql .= " GROUP BY albums.albumid ORDER BY $order_by";

    // Bereid de query voor en voer uit
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>Albums</h1>
<div class="filter_div">
    <form method="GET" class="filter">
        <input type="text" class="search_bar" name="search" placeholder="Search for Albums or Songs..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
        <select name="sort" class="sort_select">
            <option value="oldest" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'oldest') ? 'selected' : ''; ?>>Old to New</option>
            <option value="newest" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'newest') ? 'selected' : ''; ?>>New to Old</option>
        </select>
        <button type="submit">Search</button>
    </form>
</div>
<div class="information">
    <table class="infromation_table">
        <tr>
            <th>Album Name</th>
            <th>Album Release Date</th>
            <th>Artist</th>
            <th>Number of Songs</th>
            <th>More</th>
        </tr>
        <?php
        // Toon de resultaten
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['albumname']) . "</td>";
            echo "<td>" . htmlspecialchars($row['albumreleasedate']) . "</td>";
            echo "<td><a style='text-decoration: none; color:black;' href='artist_details.php?artistid=" . htmlspecialchars($row['artistid']) . "'>" . htmlspecialchars($row['artistname']) . "</a></td>";
            echo "<td>" . htmlspecialchars($row['song_count']) . "</td>";
            echo "<td><a class='button-more' href='album_details.php?albumid=" . htmlspecialchars($row['albumid']) . "'>More</a></td>";
            echo "</tr>";
        }
        if (empty($result)) {
            echo "<tr><td colspan='5'>No results found.</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>