<?php
$host = "mysql-273006ce-tamcc.k.aivencloud.com";
$port = 17199;
$user = "avnadmin";
$pass = "AVNS_ttME4P816txlP2F5mVY";
$dbname = "TaskHive";
$ssl_ca = __DIR__ . 'connection/ca.pem';

// Initialize MySQL connection
$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, $ssl_ca, NULL, NULL);

// Connect using SSL
if (!mysqli_real_connect(
        $conn,
        $host,
        $user,
        $pass,
        $dbname,
        $port,
        NULL,
        MYSQLI_CLIENT_SSL
    )) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}?>