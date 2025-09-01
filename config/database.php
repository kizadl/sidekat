<?php
$host = "localhost";
$user = "root";
$pass = "<>Anwar1441";
$db = "project_sidekat";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
