<?php
    $base_url = 'http://10.147.17.235/fish/';
    $servername = 'localhost';
    $dbname = 'fish';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=fish", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);
        //echo "Connect Success";
    } catch(PDOException $e) {
        echo "Connection Fail :" . $e->getMessage();
    }
?>