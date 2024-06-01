<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload file dari Composer
// require '../../vendor/autoload.php';
require 'C:/xampp/htdocs/Project_Skripsi/public/koneksi.php';
require 'C:/xampp/htdocs/Project_Skripsi/vendor/autoload.php';

// require '../koneksi.php';

// SELECT riwayat_berobat.tanggal_berobat, riwayat_berobat.berat_badan, riwayat_berobat.tinggi_badan FROM riwayat_berobat 
// INNER JOIN data_pasien ON riwayat_berobat.id_pasien = data_pasien.id_pasien 
// INNER JOIN user ON data_pasien.id_user = user.id_user
// Ambil pasien yang punya jadwal berobat -7 hari, -3 hari, -1 hari, dan hari ini

// SELECT FROM user INNER JOIN 
$sql = "SELECT user.name as name, user.email as email, riwayat_berobat.rencana_berobat FROM user
JOIN data_pasien ON user.id_user = data_pasien.id_user
JOIN riwayat_berobat ON data_pasien.id_pasien = riwayat_berobat.id_pasien WHERE riwayat_berobat.rencana_berobat = CURDATE() 
OR riwayat_berobat.rencana_berobat = DATE_ADD(CURDATE(), INTERVAL 1 DAY) 
OR riwayat_berobat.rencana_berobat = DATE_ADD(CURDATE(), INTERVAL 3 DAY) 
OR riwayat_berobat.rencana_berobat = DATE_ADD(CURDATE(), INTERVAL 7 DAY) ";
$result = $conn->query($sql);
if (!$result) {
    die("Query prepare failed (Output All): " . $conn->error);
}


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Informasi pasien
        $patient_name = $row['name'];
        $patient_email = $row['email'];
        $rencana_berobat = $row['rencana_berobat'];

        

        // Konversi tanggal janji temu menjadi objek DateTime
        $appointment_date = new DateTime($rencana_berobat);
        $current_date = new DateTime();
        $current_date->modify('-1 day');

        // Hitung interval hari
        $interval = $current_date->diff($appointment_date)->days;
        // Hitung interval hari
        
        // $current_date = new DateTime();
        // $rencana_berobat_obj = new DateTime($rencana_berobat);
        // $interval = $rencana_berobat_obj->diff($current_date)->days;

        // $current_dat = new DateTimeImmutable();
        // $target = new DateTimeImmutable($rencana_berobat);
        // $interval = $current_dat->diff($target)->days;
        
        // Tentukan subjek dan isi email berdasarkan interval hari
        if ($interval == 0) {
            $subject = 'Pengingat: Kamu Ada Jadwal Pemeriksaan Anak Hari Ini';
            $body = 'Dear ' . $patient_name . ',<br><br>Ini adalah notifikasi pengingat pemeriksaan anak anda ke fasilitas terdekat pada hari ini.<br><br>Best regards,<br>Klinik Pratama';
        } elseif ($interval == 1) {
            $subject = 'Pengingat: Kamu Ada Jadwal Pemeriksaan Anak Besok';
            $body = 'Dear ' . $patient_name . ',<br><br>Ini adalah notifikasi pengingat pemeriksaan anak anda ke fasilitas terdekat besok.<br><br>Best regards,<br>Your Clinic Name';
        } elseif ($interval == 3) {
            $subject = 'Pengingat: Kamu Ada Jadwal Pemeriksaan Anak Dalam 3 Hari Lagi';
            $body = 'Dear ' . $patient_name . ',<br><br>Ini adalah notifikasi pengingat pemeriksaan anak anda ke fasilitas terdekat dalam 3 hari lagi.<br><br>Best regards,<br>Your Clinic Name';
        } elseif ($interval == 7) {
            $subject = 'Pengingat: Kamu Ada Jadwal Pemeriksaan Anak Dalam 7 Hari Lagi';
            $body = 'Dear ' . $patient_name . ',<br><br>Ini adalah notifikasi pengingat pemeriksaan anak anda ke fasilitas terdekat dalam 7 hari lagi.<br><br>Best regards,<br>Your Clinic Name';
        } else {
            continue; // Skip if not -7, -3, -1 days or today
        }
        
        // Buat email
        $mail = new PHPMailer(true);
        
        try {
            // Konfigurasi server SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'faufaadhib@gmail.com';
            $mail->Password = 'mnle rrjp vxln jvlf';
            $mail->SMTPSecure='ssl';
            $mail->Port='465';

            // Recipients
            $mail->setFrom('faufaadhib@gmail.com', 'Klinik Pratama');
            $mail->addAddress($patient_email, $patient_name); // Ganti dengan email dan nama pasien

            // Konten email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);

            // Kirim email
            $mail->send();
            echo 'Reminder has been sent to ' . $patient_email .'-'.$rencana_berobat .'-'.$body.'-'.$interval.'<br>';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
        }
    }
} else {
    echo "No appointments requiring reminders today.<br>";
}

$conn->close();
