<?php
require "dbconnection.php";
$dbcon = createDbConnection();

$artist_id = 1; //artist ID 

try {
    $pdo = $dbcon;
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        DELETE FROM invoice_items
        WHERE TrackId IN (
            SELECT tracks.TrackId
            FROM tracks
            JOIN albums ON tracks.AlbumId = albums.AlbumId
            WHERE albums.ArtistId = ?
        )
    ");
    $stmt->execute([$artist_id]);

    $stmt = $pdo->prepare("
        DELETE FROM tracks
        WHERE AlbumId IN (
            SELECT albums.AlbumId
            FROM albums
            WHERE albums.ArtistId = ?
        )
    ");
    $stmt->execute([$artist_id]);

    $stmt = $pdo->prepare("DELETE FROM albums WHERE ArtistId = ?");
    $stmt->execute([$artist_id]);

    $stmt = $pdo->prepare("DELETE FROM artists WHERE ArtistId = ?");
    $stmt->execute([$artist_id]);

    $pdo->commit();
    echo "artist with ID $artist_id removed";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "error removing artist" . $e->getMessage();
}
