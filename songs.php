<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Songs</title>
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
</head>
<body>
<?php
    include "nav.php";
    include "CRUD/connect.php";

    // Basis SQL-query met INNER JOINs
    $sql = "SELECT songs.songname, songs.releasedate, songs.songid, songs.artistid, songs.albumid, 
                   artists.name AS artistname, albums.albumname 
            FROM songs 
            INNER JOIN artists ON songs.artistid = artists.artistid 
            INNER JOIN albums ON songs.albumid = albums.albumid";

    $params = [];
    $order_by = "releasedate ASC"; // Standaard sortering: vroegste eerst

    // Filter logica
    if (!empty($_GET['search'])) {
        $conditions = [];
        $search = "%" . $_GET['search'] . "%";
        $conditions[] = "(songs.songname LIKE :search OR artists.name LIKE :search OR albums.albumname LIKE :search)";
        $params[':search'] = $search;

        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    // Sorteeroptie
    if (!empty($_GET['sort'])) {
        if ($_GET['sort'] === 'newest') {
            $order_by = "releasedate DESC"; // Nieuwste eerst
        } elseif ($_GET['sort'] === 'oldest') {
            $order_by = "releasedate ASC"; // Vroegste eerst
        }
    }

    $sql .= " ORDER BY $order_by";

    // Bereid de query voor en voer uit
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>Songs</h1>
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
            <th>Song Name</th>
            <th>Release Date</th>
            <th>Artist</th>
            <th>Album</th>
        </tr>
        <?php
        // Toon de resultaten
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['songname']) . "</td>";
            echo "<td>" . htmlspecialchars($row['releasedate']) . "</td>";
            echo "<td><a style='text-decoration: none; color:black;' href='artist_details.php?artistid=" . htmlspecialchars($row['artistid']) . "'>" . htmlspecialchars($row['artistname']) . "</a></td>";
            echo "<td><a style='text-decoration: none; color:black;' href='album_details.php?albumid=" . htmlspecialchars($row['albumid']) . "'>" . htmlspecialchars($row['albumname']) . "</a></td>";
            echo "</tr>";
        }
        if (empty($result)) {
            echo "<tr><td colspan='4'>Geen resultaten gevonden.</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>