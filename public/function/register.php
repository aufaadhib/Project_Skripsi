<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../koneksi.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $token = bin2hex(random_bytes(50)); // Generate a unique token

    // Insert user into the database with an inactive status
    $sql = "INSERT INTO user (username, name , email, password, token, status) VALUES (?, ?, ?, ?, ?, 'inactive')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $username, $name ,$email, $password, $token);

    if ($stmt->execute()) {
        // Send verification email
        $verificationLink = "http://localhost/project_skripsi/public/function/verify.php?token=$token";
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'qheyco2001v1@gmail.com';
            $mail->Password = 'your-email-password';
            $mail->SMTPSecure='ssl';
            $mail->Port='465';

            // Recipients
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress($email, $username);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body    = "Click on the following link to verify your email: <a href='$verificationLink'>$verificationLink</a>";
            $mail->AltBody = "Click on the following link to verify your email: $verificationLink";

            $mail->send();
            echo 'Registration successful! Please check your email to verify your account.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Error: ' . $conn->error;
    }
}
?>
