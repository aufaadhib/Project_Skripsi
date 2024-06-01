<?php
include '../../koneksi.php';

// Memeriksa apakah ada data yang dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari formulir
    // $id_riwayat = 42;
    $id_pasien = $_POST['id_pasien'];
    $berat_badan = $_POST['berat_badan'];
    $tinggi_badan = $_POST['tinggi_badan'];
    $tanggal_berobat = $_POST['tanggal_berobat'];
    $rencana_berobat = $_POST['rencana_berobat'];
    $diagnosa = $_POST['diagnosa'];
    $keterangan_lainnya = $_POST['keterangan_lainnya'];

    // Membuat query untuk menyimpan data
    $sql = "INSERT INTO riwayat_berobat (id_pasien, berat_badan, tinggi_badan, tanggal_berobat, rencana_berobat, diagnosa, keterangan_lainnya)
            VALUES ('$id_pasien', '$berat_badan', '$tinggi_badan', '$tanggal_berobat', '$rencana_berobat', '$diagnosa', '$keterangan_lainnya')";

    // Menjalankan query dan memeriksa keberhasilannya
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil disimpan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Menutup koneksi
$conn->close();
?>
