<?php
require "dbconnection.php";
$dbcon = createDbConnection();

$artist_id = 3; //artist ID 

$pdo = $dbcon;

$stmt = $pdo->prepare("
    SELECT artists.Name AS artist, albums.AlbumId, albums.Title, tracks.Name AS track
    FROM artists
    JOIN albums ON artists.ArtistId = albums.ArtistId
    JOIN tracks ON albums.AlbumId = tracks.AlbumId
    WHERE artists.ArtistId = ?
");
$stmt->execute([$artist_id]);

if ($stmt->rowCount() > 0) {
    $artistInfo = array();
    $albums = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $artistInfo['artist'] = $row['artist'];

        $albumId = $row['AlbumId'];
        $albumTitle = $row['Title'];
        $trackName = $row['track'];

        if (!isset($albums[$albumId])) {
            $albums[$albumId] = array(
                'Title' => $albumTitle,
                'Tracks' => array()
            );
        }

        $albums[$albumId]['Tracks'][] = $trackName;
    }

    $artistInfo['Albums'] = array_values($albums);

    $jsonResponse = json_encode($artistInfo);
    echo $jsonResponse;
} else {
    echo "artist not found";
}