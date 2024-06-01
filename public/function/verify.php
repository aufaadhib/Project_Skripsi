<?php
require '../koneksi.php'; // Include your database connection file

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify the token
    $sql = "SELECT * FROM user WHERE token = ? AND status = 'inactive'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Activate the user account
        $sql = "UPDATE user SET status = 'active' WHERE token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $token);

        if ($stmt->execute()) {
            echo 'Account verified successfully! You can now log in.';
        } else {
            echo 'Error: ' . $conn->error;
        }
    } else {
        echo 'Invalid or expired token.';
    }
} else {
    echo 'No token provided.';
}
?>
