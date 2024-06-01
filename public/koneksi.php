<?php
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname   = 'skripsi-kia';

    $conn = mysqli_connect($hostname, $username, $password, $dbname) or die ('Gagal Terhubung ke Database');

    // Memeriksa koneksi
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>