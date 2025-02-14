<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dev edits</title>
    <base href="http://localhost/artistlibrary/">
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
</head>
<body>
<?php include "../nav.php" ; ?>
<div id="devdiv">
    <div class="cruddiv">
    <?php
    include "connect.php" ;
    $sql="SELECT * FROM artists";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result =$stmt->fetchALL(PDO::FETCH_ASSOC);
    ?>
    <h1>Artist</h1>
        <a href='CRUD/artist_insert.php'>add artist</a>
        <table>
            <tr>
                <th>artist id</th>
                <th>name</th>
                <th>genre</th>
                <th>debut date</th>
                <th>edit</th>
                <th>delete</th>
            </tr>
            

    <?php

        foreach ($result as $row) {
                echo "<tr>";
                echo "<td>". $row['artistid'] . "";
                echo "<td>". $row['name'] . "";
                echo "<td>". $row['genre']. "";
                echo "<td>". $row['debutdate']. "";
                echo "<td class='tdb' ><a class='button-add' href='CRUD/artist_edit.php?artistid=" . $row['artistid'] ."'>" . "edit</a></td>";
                echo "<td class='tdb' ><a class='button-delete' href='CRUD/artist_delete.php?artistid=" . $row['artistid'] ."'>" . "delete</a></td>";
                echo "</tr>";
        }

        ?>
        </table>
    </div>
    <div class="cruddiv">
    <?php
    $sql="SELECT * FROM songs";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result =$stmt->fetchALL(PDO::FETCH_ASSOC);
    ?>
    <h1>Songs</h1>
        <a href='CRUD/song_insert.php'>add song</a>
        <table>
            <tr>
                <th>song id</th>
                <th>song name</th>
                <th>release date</th>
                <th>artist id</th>
                <th>album id</th>
                <th>edit</th>
                <th>delete</th>
            </tr>



            <?php

            foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>". $row['songid'] . "";
                    echo "<td>". $row['songname'] . "";
                    echo "<td>". $row['releasedate']. "";
                    echo "<td>". $row['artistid']. "";
                    echo "<td>". $row['albumid']. "";
                    echo "<td class='tdb' ><a class='button-add' href='CRUD/song_edit.php?songid=" . $row['songid'] ."'>" . "edit</a></td>";
                    echo "<td class='tdb' ><a class='button-delete' href='CRUD/song_delete.php?songid=" . $row['songid'] ."'>" . "delete</a></td>";
                    echo "</tr>";
            }
            ?>
        </table>
    </div>
    <div class="cruddiv">
    <?php
    $sql="SELECT * FROM albums";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result =$stmt->fetchALL(PDO::FETCH_ASSOC);
    ?>
    <h1>Albums</h1>
        <a href='CRUD/album_insert.php'>add album</a>
        <table>
            <tr>
                <th>album id</th>
                <th>album name</th>
                <th>release date</th>
                <th>artist id</th>
                <th>edit</th>
                <th>delete</th>
            </tr>



            <?php

            foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>". $row['albumid'] . "";
                    echo "<td>". $row['albumname'] . "";
                    echo "<td>". $row['albumreleasedate']. "";
                    echo "<td>". $row['artistid']. "";
                    echo "<td class='tdb' ><a class='button-add' href='CRUD/album_edit.php?albumid=" . $row['albumid'] ."'>" . "edit</a></td>";
                    echo "<td class='tdb' ><a class='button-delete' href='CRUD/album_delete.php?albumid=" . $row['albumid'] ."'>" . "delete</a></td>";
                    echo "</tr>";
            }
            ?>
        </table>
    </div>
</div>
</body>