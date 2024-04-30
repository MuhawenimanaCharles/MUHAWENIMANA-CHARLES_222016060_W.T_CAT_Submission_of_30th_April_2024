<?php
    // Connection details
    $host = "localhost";
    $user = "222016060";
    $pass = "222016060";
    $database = "financial_position";

    // Creating connection
    $connection = new mysqli($host, $user, $pass, $database);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
?>