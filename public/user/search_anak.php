<?php
ob_start();
session_start();

include "../koneksi.php";

// Menentukan jumlah data per halaman
$limit = 5; // Jumlah data per halaman
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$start = ($page - 1) * $limit;
$query = isset($_POST['query']) ? $_POST['query'] : '';
$id_user= $_SESSION['user_id'];

if (!empty($query)) {
  $query = '%' . ($query) . '%';
  $stmt = $conn->prepare("SELECT * FROM data_pasien WHERE id_user=? AND (id_pasien LIKE ? OR nama_depan LIKE ? OR nama_belakang LIKE ?) LIMIT ?, ?");
  $stmt->bind_param("isssii", $id_user, $query, $query, $query, $start, $limit);
  if (!$stmt) {
    die("Query prepare failed (data_pasien select): " . $conn->error);
}
  $stmt->execute();
  
  $result = $stmt->get_result();
  $data_pasien = $result->fetch_all(MYSQLI_ASSOC);

  $total_stmt = $conn->prepare("SELECT COUNT(*) FROM data_pasien WHERE id_user=? AND (id_pasien LIKE ? OR nama_depan LIKE ? OR nama_belakang LIKE ?)");
  $total_stmt->bind_param("isss", $id_user, $query, $query, $query);
  $total_stmt->execute();
  $total_stmt->bind_result($total_records);
  $total_stmt->fetch();
} else {
  $stmt = $conn->prepare("SELECT * FROM data_pasien WHERE id_user=? LIMIT ?, ?");
  $stmt->bind_param("iii", $id_user,$start, $limit);
  $stmt->execute();
  $result = $stmt->get_result();
  $data_pasien = $result->fetch_all(MYSQLI_ASSOC);

  $total_stmt = $conn->prepare("SELECT COUNT(*) FROM data_pasien WHERE id_user=?");
  // $total_stmt->execute();
  $total_stmt->bind_param("s",$id_user);
  $total_stmt->execute();
  $total_stmt->bind_result($total_records);
  $total_stmt->fetch();
}

$total_halaman = ceil($total_records / $limit);

if (empty($data_pasien)) {
  echo '    <div class="notification red">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
    <div>
      <span class="icon"><i class="mdi mdi-buffer"></i></span>
      <b>Empty table.</b>
    </div>
  </div>
</div>

<div class="card empty">
  <div class="card-content">
    <div>
      <span class="icon large"><i class="mdi mdi-emoticon-sad mdi-48px"></i></span>
    </div>
    <p>Nothings here…</p>
  </div>
</div>
  
  ';
} else {
  if (!empty($query)) {
        echo '<div class="notification green">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
                    <div>
                        <span class="icon"><i class="mdi mdi-check-circle"></i></span>
                        <b>Data ditemukan.</b>
                    </div>
                </div>
              </div>';
    }
  echo '<div class="card has-table">
            <header class="card-header">
              <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
                Clients
              </p>
              <button class="card-header-icon" onclick="refreshPage()">
              <script>
                function refreshPage() {
                    location.reload();
                }
              </script>
              <span class="icon"><i class="mdi mdi-reload"></i></span>
              </button>
            </header>
            <div class="card-content">
              <table>
                <thead>
                  <tr>
                    <th class="checkbox-cell">
                      <label class="checkbox">
                        <input type="checkbox">
                        <span class="check"></span>
                      </label>
                    </th>
                    <th class="image-cell"></th>
                    <th>ID Pasien</th>
                    <th>Nama Depan</th>
                    <th>Nama Belakang</th>
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>Nomor HP</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>';
                foreach ($data_pasien as $row) {
                  echo '<tr>
                <td class="checkbox-cell">
                  <label class="checkbox">
                    <input type="checkbox">
                    <span class="check"></span>
                  </label>
                </td>
                <td class="image-cell">
                  <div class="image">
                    <img src="https://avatars.dicebear.com/v2/initials/' . $row['nama_depan'] . '-' . $row['nama_belakang'] . '.svg" class="rounded-full">
                  </div>
                </td>
                <td>' . $row['id_pasien'] . '</td>
                <td>' . $row['nama_depan'] . '</td>
                <td>' . $row['nama_belakang'] . '</td>
                <td>' . $row['gender'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['nomor_telp'] . '</td>
                <td class="actions-cell">
                  <div class="buttons right nowrap">
                  
                    <form method="post" action="details.php">
                      <input type="hidden" name="id_pasien" value="' . $row['id_pasien'] . '">
                      <button type="submit" class="button small blue --jb-modal">
                        <span class="icon">
                          <i class="mdi mdi-eye"></i>
                        </span>
                      </button>
                    </form>
                    <button class="button small red --jb-modal" onclick="hapusData(' . $row['id_pasien'] . ')">
                      <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                    </button>
                    <button class="button small green --jb-modal" onclick="sendEmail(' . $row['id_pasien'] . ')">
                      <span class="icon"><i class="mdi mdi-email"></i></span>
                    </button>
                  </div>
                </td>
              </tr>';
  }
  echo '</tbody>
          </table>';

  echo '<div class="table-pagination">
          <div class="flex items-center justify-between">
            <div class="buttons">';
  for ($halaman = 1; $halaman <= $total_halaman; $halaman++) {
    if ($halaman == $page) {
      echo '<span class="button page_link active" id="'.$halaman.'">'.$halaman.'</span>';
  } else {
      echo '<span class="button page_link" id="'.$halaman.'">'.$halaman.'</span>';  }
    // echo '<span class="button page_link" id="'.$halaman.'">'.$halaman.'</span>';

    // echo "<a id='.$halaman.' class='button page_link" . ($halaman == $page ? "active" : "") . "' href='?page=$halaman'>$halaman</a> ";
  }
  echo '</div>
              <small>Page ' . $page . ' of ' . $total_halaman . '</small>
            </div>
          </div>';
}


$conn->close();
