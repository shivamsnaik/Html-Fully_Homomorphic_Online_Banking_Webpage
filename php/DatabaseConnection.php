<?php
    $dbHost = "localhost";
    $dbUsername = 'id3765227_infotechcrypto';
    $dbPassword = 'sasushso';
    $dbName = 'id3765227_iscryptodb';
    
    $connection = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    
    if($connection->connect_error)
    {
        echo "<b> Error connecting to the database</b>";
    }
?>