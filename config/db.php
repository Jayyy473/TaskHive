<?php
// Get Aiven connection settings from Render environment variables
$host = getenv('Aiven_Host');
$port = getenv('Aiven_Port');
$username = getenv('Aiven_User');
$password = getenv('Aiven_Pass');
$dbname = getenv('Aiven_DB');
$ssl_ca = __DIR__ . '/ca.pem'; 

$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, $ssl_ca, NULL, NULL);

if (!mysqli_real_connect($conn, $host, $username, $password, $dbname, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>