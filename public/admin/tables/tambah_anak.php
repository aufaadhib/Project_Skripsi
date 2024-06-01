<?php
include '../../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $id_pasien='';
    $no_akta=$_POST['no_akta'];
    $id_user=$_POST['id_user'];
    $nama_depan=$_POST['nama_depan'];
    $nama_belakang=$_POST['nama_belakang'];
    $tmpt_tgl_lahir=$_POST['tmpt_tgl_lahir'];
    $gender=$_POST['gender'];
    


    // Check if file was uploaded

    // Update without changing the profile photo
    // $sql = "UPDATE user SET name=?, email=?, nik=?, pembiayaan=?, pekerjaan=?, golongan_darah=? ,tmpt_tgl_lahir=?,no_jkn=?, faskes_tk_1=?, faskes_rujukan=? WHERE username='$username'";
    $sql = "INSERT INTO data_pasien SET no_akta=?, id_user=?, nama_depan=?, nama_belakang=?, tmpt_tgl_lahir=?, gender=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sissss', $no_akta, $id_user, $nama_depan, $nama_belakang, $tmpt_tgl_lahir, $gender);


    if ($stmt->execute()) {
        echo "Profile updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
