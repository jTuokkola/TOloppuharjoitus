<?php


function createDbConnection()
{
    $ini = parse_ini_file("myconf.ini");

    $host = $ini["host"];
    $db = $ini["db"];
    $username = $ini["username"];
    $pw = $ini["pw"];


    try {
        $dbcon = new PDO("mysql:host=$host;dbname=$db", $username, $pw);
        $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbcon;
        
    } catch (PDOException $e) {
         echo $e->getMessage();
     }

    return null;
}