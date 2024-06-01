<?php
ob_start();
session_start();

include "../../koneksi.php";

// Menentukan jumlah data per halaman
$limit = 5; // Jumlah data per halaman
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$start = ($page - 1) * $limit;
$query = isset($_POST['query']) ? $_POST['query'] : '';

if (!empty($query)) {
  $query = '%' . ($query) . '%';
  // $stmt = $conn->prepare("SELECT * FROM user WHERE id_user LIKE ? OR username LIKE ? OR name LIKE ? OR alamat LIKE ? OR no_jkn LIKE ? LIMIT ?, ?");
  // $stmt->bind_param("isssiii", $query, $query,$query,$query,$query,$start, $limit);
  $stmt = $conn->prepare("SELECT * FROM user WHERE id_user LIKE ? OR username LIKE ? OR no_jkn LIKE ? LIMIT ?, ?");
  if (!$stmt) {
    die("Query prepare failed (data_pasien select): " . $conn->error);
}
  $stmt->bind_param("sssii", $query, $query,$query, $start, $limit);
  $stmt->execute();
  $result = $stmt->get_result();
  $data_user = $result->fetch_all(MYSQLI_ASSOC);
  $stmt->close(); // Tutup statement setelah digunakan

  $total_stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE id_user LIKE ? OR username LIKE ? OR no_jkn LIKE ?");
  if (!$total_stmt) {
    die("Query prepare failed (Count): " . $conn->error);
}
  $total_stmt->bind_param("sss", $query, $query,$query,);
  $total_stmt->execute();
  $total_stmt->bind_result($total_records);
  $total_stmt->fetch();
  $total_stmt->close(); // Tutup statement setelah digunakan
  
} else {
  $stmt = $conn->prepare("SELECT * FROM user LIMIT ?, ?");
  if (!$stmt) {
    die("Query prepare failed (Output All): " . $conn->error);
}
  $stmt->bind_param("ii", $start, $limit);
  $stmt->execute();
  $result = $stmt->get_result();
  $data_user = $result->fetch_all(MYSQLI_ASSOC);
  $total_stmt = $conn->query("SELECT COUNT(*) FROM user");
  $total_records = $total_stmt->fetch_row()[0];
  $stmt->close(); // Tutup statement setelah digunakan
}

$total_halaman = ceil($total_records / $limit);

if (empty($data_user)) {
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
                    <th>ID User</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>No JKN</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>';
  foreach ($data_user as $row) {
    echo '<tr  onclick="hideRow(this)" class="ibu-row hover:cursor-pointer" data-id=' . $row['id_user'] . '>
                  <td class="checkbox-cell">
                    <label class="checkbox">
                      <input type="checkbox">
                      <span class="check"></span>
                    </label>
                  </td>
                  <td class="image-cell">
                    <div class="image">
                      <img src="../profile/uploads/' . $row['profile_photo'] . '" class="rounded-full w-48 h-20">
                    </div>
                  <td>' . $row['id_user'] . '</td>
                  <td>' . $row['username'] . '</td>
                  <td>' . $row['name'] . '</td>
                  <td>' . $row['email'] . '</td>
                  <td>' . $row['no_jkn'] . '</td>
                  <td class="actions-cell">
                    <div class="buttons nowrap">
                      <form method="post" action="../index.php">
                        <input type="hidden" name="id_user" value="' . $row['id_user'] . '">
                        <button type="submit" class="button small blue --jb-modal">
                          <span class="icon">
                            <i class="mdi mdi-eye"></i>
                          </span>
                        </button>
                      </form>
                      <button class="button small red --jb-modal" onclick="hapusData(' . $row['id_user'] . ')">
                        <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                      </button>
                      <button class="button small green --jb-modal" onclick="sendEmail(' . $row['id_user'] . ')">
                        <span class="icon"><i class="mdi mdi-email"></i></span>
                      </button>
                    </div>
                  </td>
  
                </tr>';
    $id_user = $row['id_user'];
    $sql_anak = "SELECT * FROM data_pasien WHERE id_user=?";
    $stmt_anak = $conn->prepare($sql_anak);
    if (!$stmt_anak) {
      die("Query prepare failed: " . $conn->error);
  }
    $stmt_anak->bind_param("s", $id_user);
    $stmt_anak->execute(); 
    $result_anak = $stmt_anak->get_result();
    while ($anak = $result_anak->fetch_assoc()) {
      $id_anak = $anak['id_pasien'];
      // echo '<tr>

      echo '<tr class="hidden" data-id-ibu=' . $row['id_user'] . '>
                
                <td colspan=3></td>
                <td colspan=2>' . $anak['nama_depan'] . ' ' . $anak['nama_belakang'] . '</td>
                <td>' . $anak['gender'] . '</td>
                </tr>';
    }
    $stmt_anak->close(); // Tutup statement setelah digunakan
  }
  echo '</tbody>
          </table>';

  echo '<div class="table-pagination">
          <div class="flex items-center justify-between">
            <div class="buttons">';
  for ($halaman = 1; $halaman <= $total_halaman; $halaman++) {
    if ($halaman == $page) {
      echo '<span class="button page_link active" id="' . $halaman . '">' . $halaman . '</span>';
    } else {
      echo '<span class="button page_link" id="' . $halaman . '">' . $halaman . '</span>';
    }
    // echo '<span class="button page_link" id="'.$halaman.'">'.$halaman.'</span>';

    // echo "<a id='.$halaman.' class='button page_link" . ($halaman == $page ? "active" : "") . "' href='?page=$halaman'>$halaman</a> ";
  }
  echo '</div>
              <small>Page ' . $page . ' of ' . $total_halaman . '</small>
            </div>
          </div>';
}

$conn->close();
