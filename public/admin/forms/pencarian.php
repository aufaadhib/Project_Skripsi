<?php
include "../../koneksi.php";
$query = "";
if (isset($_POST['query'])) {
    $query = $_POST['query'];
}

if ($query != "") {
    $sql = "SELECT id_pasien, nama_depan, nama_belakang FROM data_pasien WHERE id_pasien LIKE '%$query%' OR nama_depan LIKE '%$query%' OR nama_belakang LIKE '%$query%'";
} else {
    $sql = "SELECT id_pasien, nama_depan, nama_belakang FROM data_pasien";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div data-id="' . $row['id_pasien'] . '">' . $row['nama_depan'] . ' ' . $row['nama_belakang'] . '</div>';
    }
} else {
    echo '<div>Tidak ditemukan</div>';
}

$conn->close();
?>
