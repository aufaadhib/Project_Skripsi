<?php
session_start();

// Menghapus semua variabel sesi
session_unset();

// Menghapus sesi
session_destroy();

// Redirect ke halaman login atau halaman lain yang sesuai
header("Location: ../");
exit();
?>

<link rel="stylesheet" href="../index.php">
