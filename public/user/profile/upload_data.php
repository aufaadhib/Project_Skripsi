<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika belum, redirect ke halaman login
    header("Location: .././");
    exit();
}
include '../../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$username = $_SESSION['username'];
$name = $_POST['name'];
$email = $_POST ['email'];
$nik = $_POST['nik'];
$pembiayaan = $_POST['pembiayaan'];
$pekerjaan = $_POST['pekerjaan'];
$golongan_darah = $_POST['golongan_darah'];
$tmpt_tgl_lahir = $_POST['tmpt_tgl_lahir'];
$no_jkn = $_POST['no_jkn'];
$faskes_tk_1 = $_POST['faskes_tk_1'];
$faskes_rujukan = $_POST['faskes_rujukan'];

    $target_dir = "../../admin/profile/uploads/";
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));
    $new_file_name = basename($_FILES["photo"]["name"]);
    $target_file = $target_dir . $new_file_name;

    // Check if file was uploaded
    if ($_FILES["photo"]["size"] > 0) {
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["photo"]["size"] > 10000000) { // 1MB
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $sql = "UPDATE user SET profile_photo=?, name=?, email=?, nik=?, pembiayaan=?, pekerjaan=?, golongan_darah=? ,tmpt_tgl_lahir=?,no_jkn=?, faskes_tk_1=?, faskes_rujukan=? WHERE username='$username'";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sssissssiss', $new_file_name, $name, $email, $nik, $pembiayaan,$pekerjaan,$golongan_darah,$tmpt_tgl_lahir,$no_jkn,$faskes_tk_1,$faskes_rujukan);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // Update without changing the profile photo
        $sql = "UPDATE user SET name=?, email=?, nik=?, pembiayaan=?, pekerjaan=?, golongan_darah=? ,tmpt_tgl_lahir=?,no_jkn=?, faskes_tk_1=?, faskes_rujukan=? WHERE username='$username'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssissssiss', $name, $email, $nik, $pembiayaan,$pekerjaan,$golongan_darah,$tmpt_tgl_lahir,$no_jkn,$faskes_tk_1,$faskes_rujukan);
    }

    if ($stmt->execute()) {
        echo "Profile updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
