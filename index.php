<?php
    include "CRUD/connect.php";
    include "nav.php";

    $sql = "SELECT * FROM artists, albums, songs";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
    <title>Artist Library</title>
</head>
<body>
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