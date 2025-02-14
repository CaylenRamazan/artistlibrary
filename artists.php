<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artists</title>
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
</head>
<body>
<?php
    include "nav.php";
    include "CRUD/connect.php";

    // Basis SQL-query
    $sql = "SELECT * FROM artists";

    // Filter logica
    $params = [];
    $order_by = "debutdate ASC"; // Standaard: vroegste eerst

    if (!empty($_GET['search'])) {
        $search = "%" . $_GET['search'] . "%";
        $sql .= " WHERE name LIKE :search OR genre LIKE :search";
        $params[':search'] = $search;
    }

    // Controleer op sorteeroptie
    if (!empty($_GET['sort'])) {
        if ($_GET['sort'] === 'newest') {
            $order_by = "debutdate DESC"; // Nieuwste eerst
        } elseif ($_GET['sort'] === 'oldest') {
            $order_by = "debutdate ASC"; // Vroegste eerst
        }
    }

    // Voeg ORDER BY toe
    $sql .= " ORDER BY $order_by";

    // Bereid de query voor en voer uit
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>Artists</h1>
<div class="filter_div">
    <form method="GET" class="filter">
        <input type="text" class="search_bar" name="search" placeholder="Search for Artist or Genre..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
        <select name="sort" class="sort_select">
            <option value="oldest" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'oldest') ? 'selected' : ''; ?>>Old to new</option>
            <option value="newest" <?php echo (isset($_GET['sort']) && $_GET['sort'] === 'newest') ? 'selected' : ''; ?>>New to Old</option>
        </select>
        <button type="submit">Search</button>
    </form>
</div>
<div class="information">
    <table class="infromation_table">
        <tr>
            <th>Name</th>
            <th>Genre</th>
            <th>Debut Date</th>
            <th>Details</th>
        </tr>
        <?php
        // Sorteer en toon resultaten
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>"; // Beveiligde uitvoer
            echo "<td>" . htmlspecialchars($row['genre']) . "</td>"; // Beveiligde uitvoer
            echo "<td>" . htmlspecialchars($row['debutdate']) . "</td>"; // Beveiligde uitvoer
            echo "<td><a class='button-more' href='artist_details.php?artistid=" . htmlspecialchars($row['artistid']) . "'>More</a></td>";
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