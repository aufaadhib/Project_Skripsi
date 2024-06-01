<?php
session_start();
include "../../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username']; // Menggunakan username dari sesi

    // Periksa apakah data form disetel
    if (isset($_POST['current_password'], $_POST['new_password'], $_POST['confirm_new_password'])) {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmNewPassword = $_POST['confirm_new_password'];

        if ($newPassword !== $confirmNewPassword) {
            echo 'New passwords do not match.';
            exit;
        }

        if (strlen($newPassword) < 6) {
            echo 'New password must be at least 6 characters long.';
            exit;
        }

        // Ambil kata sandi saat ini dari database
        $sql = "SELECT password FROM user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user || md5($currentPassword) !== $user['password']) {
            echo 'Current password is incorrect.';
            exit;
        }

        // Perbarui kata sandi
        $newPasswordHash = md5($newPassword); // Hash kata sandi baru dengan MD5
        $sql = "UPDATE user SET password = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $newPasswordHash, $username); // Mengikat variabel newPasswordHash dan username sebagai string

        if ($stmt->execute()) {
            echo 'Password changed successfully.';
        } else {
            echo 'Error updating password.';
        }
    } else {
        echo 'Form data is missing.';
    }
}
?>
