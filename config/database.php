<?php
$host = "db_sidekat";
$user = "admsidekat";
$pass = "Wak1Lraky@tJBR";
$db = "db_sidekat";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
