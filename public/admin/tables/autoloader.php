<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/SMTP.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
$message=file_get_contents('template.php');

if(isset($_POST["send"])){
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host='smtp.gmail.com';
    $mail->SMTPAuth=true;
    $mail->Username='skripsi.farhanaufa@gmail.com';
    $mail->Password='dzzghyvvfrsudbwv';
    $mail->SMTPSecure='ssl';
    $mail->Port='465';

    $mail->setFrom('skripsi.farhanaufa@gmail.com');
    $mail->addAddress($_POST["email"]);

    $mail->isHTML(true);

    $mail->Subject = $_POST["subject"];
    $mail->Body = $message;

    $mail->send();

    // echo "
    // <script>
    // alert('Berhasil Dikirim');
    // document.location.('kirimemail.php');
    // </script>
    // ";


}
?>
