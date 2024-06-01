<?php
session_start();
require '../koneksi.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists and is active
    $sql = "SELECT * FROM user WHERE email = ? AND status = 'active'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['level'];
            $_SESSION['profile_photo'] = $user['profile_photo'];
            $_SESSION['logged_in'] = true; // Menandai bahwa pengguna telah login
            // Redirect ke halaman dashboard
            echo 'Login successful! Welcome, ' . $user['username'];
            if ($_SESSION['role'] == 'dokter' || $_SESSION['role'] == 'bidan') {
                header("Location: ../admin"); // Redirect ke dashboard admin
            } elseif ($_SESSION['role'] == 'pasien') {
                header("Location: ../user"); // Redirect ke dashboard pengguna
            }
            exit();
        } else {
            echo 'Invalid password.';
        }
    } else {
        echo 'No account found with that email or account is not verified.';
    }
}
mysqli_close($conn);

?>