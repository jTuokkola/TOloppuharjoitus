<?php
require "dbconnection.php";
$dbcon = createDbConnection();

$playlist_id = 1; //playlist ID

$pdo = $dbcon;

$stmt = $pdo->prepare("
    SELECT tracks.Name, tracks.Composer
    FROM playlist_track
    JOIN tracks ON playlist_track.TrackId = tracks.TrackId
    WHERE playlist_track.PlaylistId = ?
");
$stmt->execute([$playlist_id]);

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $trackName = $row['Name'];
        $composer = $row['Composer'];
        echo "$trackName <br> ($composer) <br>";
    }
} else {
    echo "no tracks found for playlist ID: $playlist_id";
}
