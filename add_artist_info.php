<?php
require "dbconnection.php";
$dbcon = createDbConnection();


$ArtistName = "New Artist Name";
$AlbumTitle = "New Album Title";
$TrackNames = ["Track 1", "Track 2", "Track 3"];
$MediaTypeId = 1; //media ID foreign key constraintin takia

$pdo = $dbcon;

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO artists (Name) VALUES (?)");
    $stmt->execute([$ArtistName]);

    $artistId = $pdo->lastInsertId();

    $stmt = $pdo->prepare("INSERT INTO albums (Title, ArtistId) VALUES (?, ?)");
    $stmt->execute([$AlbumTitle, $artistId]);

    $albumId = $pdo->lastInsertId();

    foreach ($TrackNames as $trackName) {
        $stmt = $pdo->prepare("INSERT INTO tracks (Name, AlbumId, MediaTypeId) VALUES (?, ?, ?)");
        $stmt->execute([$trackName, $albumId, $MediaTypeId]);
    }

    $pdo->commit();
    echo "artist, album, and tracks added";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "error adding artist: " . $e->getMessage();
}
