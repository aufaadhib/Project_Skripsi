<?php
include "../koneksi.php";
// Periksa apakah permintaan POST telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_pasien'])) {
    // Escape input untuk mencegah serangan SQL Injection
    $id_pasien = mysqli_real_escape_string($conn, $_POST['id_pasien']);
    echo $id_pasien;
    
    // Query SQL untuk menghapus data berdasarkan id_riwayat
    $query_hapus = "DELETE FROM data_pasien WHERE id_pasien = $id_pasien";
    $result = mysqli_query($conn, $query_hapus);

    // Periksa apakah penghapusan berhasil
    if ($result) {
        // Kirim respons HTTP 200 OK
        http_response_code(200);
        // Keluarkan pesan ke klien
        echo json_encode(array("message" => "Data berhasil dihapus."));
    } else {
        // Kirim respons HTTP 500 Internal Server Error
        http_response_code(500);
        // Keluarkan pesan ke klien
        echo json_encode(array("message" => "Gagal menghapus data."));
    }
} else {
    // Kirim respons HTTP 400 Bad Request jika tidak ada id_riwayat yang diterima
    http_response_code(400);
    // Keluarkan pesan ke klien
    echo json_encode(array("message" => "ID pasien tidak diterima."));
}

// Tutup koneksi
mysqli_close($conn);
?>
