<?php
ob_start();
session_start();
$username = $_SESSION['username'];
if (!isset($username)) {
    header('location:../index.php');
}
include "../koneksi.php";

// // Mengambil Data Sesuai Session
// $username = $_SESSION['username'];
// $query="SELECT * FROM user where username= '$username'";
// Memasukkan Kedalam array hasil dari query
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_pasien'])) {
// Escape input untuk mencegah serangan SQL Injection
$id_pasien = mysqli_real_escape_string($conn, $_POST['id_pasien']);
$query = "SELECT tanggal_berobat, berat_badan, tinggi_badan FROM riwayat_berobat WHERE id_pasien='$id_pasien'";
$result = mysqli_query($conn, $query);

// Proses data
$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Konversi data ke format JSON
$data_json = json_encode($data);


$query = "SELECT gender FROM data_pasien WHERE id_pasien='$id_pasien'";
$result = mysqli_query($conn, $query);
if ($result) {
  $row = mysqli_fetch_assoc($result);
  $gender = $row['gender'];
  if ($gender="Laki-Laki"){
    $queryGender="SELECT * FROM grafik_kms_lakilaki";
  }if ($gender="Perempuan"){
    $queryGender="SELECT * FROM grafik_kms_perempuan";
  }
} else {
  echo "Query failed: " . mysqli_error($conn);
}

// Ambil Grafik 
$result = mysqli_query($conn, $queryGender);

// Proses data
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

// Konversi data ke format JSON
$data_json_kms_lakilaki = json_encode($data);


}




?>

<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="../css/main.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Admin One Tailwind CSS Admin Dashboard</title>

  <!-- Tailwind is included -->
  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png"/>
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png"/>
  <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png"/>
  <link rel="mask-icon" href="safari-pinned-tab.svg" color="#00b4b6"/>

  <meta name="description" content="Admin One - free Tailwind dashboard">

  <meta property="og:url" content="https://justboil.github.io/admin-one-tailwind/">
  <meta property="og:site_name" content="JustBoil.me">
  <meta property="og:title" content="Admin One HTML">
  <meta property="og:description" content="Admin One - free Tailwind dashboard">
  <meta property="og:image" content="https://justboil.me/images/one-tailwind/repository-preview-hi-res.png">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="1920">
  <meta property="og:image:height" content="960">

  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:title" content="Admin One HTML">
  <meta property="twitter:description" content="Admin One - free Tailwind dashboard">
  <meta property="twitter:image:src" content="https://justboil.me/images/one-tailwind/repository-preview-hi-res.png">
  <meta property="twitter:image:width" content="1920">
  <meta property="twitter:image:height" content="960">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130795909-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-130795909-1');
  </script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script> -->

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

</head>
<!-- <body> -->

<div id="app">
<!-- Awal Navbar -->
<nav id="navbar-main" class="navbar is-fixed-top">
  <div class="navbar-brand">
    <a class="navbar-item mobile-aside-button">
      <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
    </a>
    <div class="navbar-item">
      <div class="control"><input placeholder="Search everywhere..." class="input"></div>
    </div>
  </div>
  <div class="navbar-brand is-right">
    <a class="navbar-item --jb-navbar-menu-toggle" data-target="navbar-menu">
      <span class="icon"><i class="mdi mdi-dots-vertical mdi-24px"></i></span>
    </a>
  </div>
  <div class="navbar-menu" id="navbar-menu">
    <div class="navbar-end">
      <div class="navbar-item dropdown has-divider has-user-avatar">
      <a class="navbar-link">
              <?php
              $username = $_SESSION['username'];
              $query = "SELECT * FROM user where username= '$username'";
              $result = mysqli_query($conn, $query);
              $data = mysqli_fetch_assoc($result);
              ?>
              <div class="user-avatar">
                <img src=./profile/uploads/<?php echo $data['profile_photo'] ?> alt="John Doe" class="rounded-full">
              </div>
              <div class="is-user-name">

                <span><?php echo $data['username']; ?></span>
              </div>
              <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
            </a>
        <div class="navbar-dropdown">
          <a href="profile.html" class="navbar-item">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            <span>My Profile</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-settings"></i></span>
            <span>Settings</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-email"></i></span>
            <span>Messages</span>
          </a>
          <hr class="navbar-divider">
          <form action="function/logout.php" method="post">
          <button>
          <a class="navbar-item">
          <span class="icon"><i class="mdi mdi-logout"></i></span>
            <span>Log Out</span>
          </a>
          </button>            
          </form>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Akhir Navbar -->

<!-- Awal Sidebar -->
<aside class="aside is-placed-left is-expanded">
  <div class="aside-tools">
    <div>
      Admin <b class="font-black">One</b>
    </div>
  </div>
  <div class="menu is-menu-main">
    <p class="menu-label">General</p>
    <ul class="menu-list">
      <li class="active">
        <a href="index.php">
          <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
          <span class="menu-item-label">Dashboard</span>
        </a>
      </li>
    </ul>
    <p class="menu-label">Examples</p>
    <ul class="menu-list">
    <li class="">
            <a class="dropdown">
              <span class="icon"><i class="mdi mdi-view-list"></i></span>
              <span class="menu-item-label">Data Pasien</span>
              <span class="icon"><i class="mdi mdi-plus"></i></span>
            </a>
            <ul>
              <li class="">
                <a href="tables">
                  <span class="icon"><i class="mdi mdi-human-pregnant"></i></span>
                  <span class="menu-item-label">Data Ibu</span>
                </a>
              </li>
              <li class="">
                <a href="tables/list_anak.php">
                  <span class="icon"><i class="mdi mdi-baby"></i></span>
                  <span class="menu-item-label">Data Anak</span>
                </a>
              </li>
            </ul>
          </li>
      <li class="--set-active-forms-html">
        <a href="forms">
          <span class="icon"><i class="mdi mdi-square-edit-outline"></i></span>
          <span class="menu-item-label">Forms</span>
        </a>
      </li>
      <li class="">
        <a href="profile">
          <span class="icon"><i class="mdi mdi-account-circle"></i></span>
          <span class="menu-item-label">Profile</span>
        </a>
      </li>
    </ul>
    
  </div>
</aside>

<!-- Akhir Sidebar -->

<section class="is-title-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <ul>
      <li>Admin</li>
      <li>Dashboard</li>
    </ul>
    <a href="https://github.com/justboil/admin-one-tailwind" target="_blank" class="button blue">
      <span class="icon"><i class="mdi mdi-github-circle"></i></span>
      <span>GitHub</span>
    </a>
  </div>
</section>

<section class="is-hero-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="title">
      Dashboard
    </h1>
    <button class="button light">Button</button>
  </div>
</section>

  <section class="section main-section">
    <div class="grid gap-6 grid-cols-1 md:grid-cols-3 mb-6">
      <div class="card">
        <div class="card-content">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3>
                Jumlah Kunjungan
                <?php
                $query = "SELECT COUNT(id_riwayat) AS total_kunjungan FROM riwayat_berobat WHERE id_pasien='$id_pasien'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $total_kunjungan = $row['total_kunjungan'];
                ?>
              </h3>
              <h1>
                <?php echo $total_kunjungan
                ?>
              </h1>
            </div>
            <span class="icon widget-icon text-green-500"><i class="mdi mdi-account-multiple mdi-48px"></i></span>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-content">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3>
                Kunjungan Terakhir
                <?php
                $query = "SELECT MAX(tanggal_berobat) AS kunjungan_terakhir FROM riwayat_berobat  WHERE id_pasien='$id_pasien'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $kunjungan_terakhir = $row['kunjungan_terakhir'];
                ?>
              </h3>
              <h1>
              <?php echo $kunjungan_terakhir
                ?>
              </h1>
            </div>
            <span class="icon widget-icon text-blue-500"><i class="mdi mdi-cart-outline mdi-48px"></i></span>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-content">
          <div class="flex items-center justify-between">
            <div class="widget-label">
              <h3>
                Jadwal Selanjutnya
                <?php
                    // Ambil tanggal rencana berobat dari database
                    $query = "SELECT MAX(rencana_berobat) AS jadwal FROM riwayat_berobat  WHERE id_pasien='$id_pasien'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $tanggal_rencana = $row['jadwal'];
                    // Tampilkan tanggal rencana berobat di halaman HTML
                    echo "<span id='tanggal_rencana' style='display:none;'>$tanggal_rencana</span>";
                ?>
              </h3>
              <h1>
              <div id="countdown"></div>
              <script>
        // Ambil tanggal rencana berobat dari PHP
        var tanggalRencana = document.getElementById('tanggal_rencana').innerText;

        // Fungsi untuk menghitung mundur dan memperbarui tampilan
        function updateCountdown() {
          if (!tanggalRencana || isNaN(new Date(tanggalRencana).getTime())) {
              document.getElementById("countdown").innerHTML = "Tidak ada jadwal";
              return;
          }
            var tanggalBerobat = new Date(tanggalRencana).getTime();
            var sekarang = new Date().getTime();
            var selisihWaktu = tanggalBerobat - sekarang;

            var hari = Math.floor(selisihWaktu / (1000 * 60 * 60 * 24));
            var jam = Math.floor((selisihWaktu % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var menit = Math.floor((selisihWaktu % (1000 * 60 * 60)) / (1000 * 60));
            var detik = Math.floor((selisihWaktu % (1000 * 60)) / 1000);

            // Tampilkan hitungan mundur
            var countdownText = "";

            if (selisihWaktu <= 0) {
                countdownText = "WAKTU BEROBAT TELAH TIBA!";
            } else {
                countdownText = hari + " hari " + jam + " jam " + menit + " menit " + detik + " detik ";
            }

            document.getElementById("countdown").innerHTML = countdownText;

            // Jika waktu hitungan mundur habis, kirim notifikasi email
            if (selisihWaktu <= 0) {
                sendEmailNotification();
            }
        }

        // Memperbarui setiap detik
        setInterval(updateCountdown, 1000);

        // Fungsi untuk mengirim notifikasi email
        function sendEmailNotification() {
            // Kirim notifikasi email menggunakan Ajax atau lakukan pengiriman di sini
            console.log('Notifikasi email dikirim!');
        }
    </script>
              </h1>
            </div>
            <span class="icon widget-icon text-red-500"><i class="mdi mdi-finance mdi-48px"></i></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Grafik Berat Badan -->
    <div class="card mb-6">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-finance"></i></span>
          Data Observasi Berat Badan
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <div class="chart-area">
          <div class="h-full">
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div></div>
              </div>
            </div>
            <canvas id="lineChart_BB" width="2000" height="500" class="chartjs-render-monitor block" style="height: 400px; width: 1197px;"></canvas>
          </div>
        </div>
      </div>
    </div>
    <!-- Grafik Tinggi Badan -->
    <div class="card mb-6">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-finance"></i></span>
          Data Observasi Tinggi Badan
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <div class="chart-area">
          <div class="h-full">
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div></div>
              </div>
            </div>
            <canvas id="lineChart_TB" width="2000" height="500" class="chartjs-render-monitor block" style="height: 400px; width: 1197px;"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="notification blue">
      <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
        <div>
          <span class="icon"><i class="mdi mdi-buffer"></i></span>
          <b>Responsive table</b>
        </div>
        <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
      </div>
    </div>

    <div class="card has-table">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
          Clients
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="card-content">
        <table>
          <thead>
          <tr>
            <th></th>
            <th>Name</th>
            <th>Company</th>
            <th>City</th>
            <th>Progress</th>
            <th>Created</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td class="image-cell">
              <div class="image">
                <img src="https://avatars.dicebear.com/v2/initials/rebecca-bauch.svg" class="rounded-full">
              </div>
            </td>
            <td data-label="Name">Rebecca Bauch</td>
            <td data-label="Company">Daugherty-Daniel</td>
            <td data-label="City">South Cory</td>
            <td data-label="Progress" class="progress-cell">
              <progress max="100" value="79">79</progress>
            </td>
            <td data-label="Created">
              <small class="text-gray-500" title="Oct 25, 2021">Oct 25, 2021</small>
            </td>
            <td class="actions-cell">
              <div class="buttons right nowrap">
                <button class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                  <span class="icon"><i class="mdi mdi-eye"></i></span>
                </button>
                <button class="button small red --jb-modal" data-target="sample-modal" type="button">
                  <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td class="image-cell">
              <div class="image">
                <img src="https://avatars.dicebear.com/v2/initials/felicita-yundt.svg" class="rounded-full">
              </div>
            </td>
            <td data-label="Name">Felicita Yundt</td>
            <td data-label="Company">Johns-Weissnat</td>
            <td data-label="City">East Ariel</td>
            <td data-label="Progress" class="progress-cell">
              <progress max="100" value="67">67</progress>
            </td>
            <td data-label="Created">
              <small class="text-gray-500" title="Jan 8, 2021">Jan 8, 2021</small>
            </td>
            <td class="actions-cell">
              <div class="buttons right nowrap">
                <button class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                  <span class="icon"><i class="mdi mdi-eye"></i></span>
                </button>
                <button class="button small red --jb-modal" data-target="sample-modal" type="button">
                  <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td class="image-cell">
              <div class="image">
                <img src="https://avatars.dicebear.com/v2/initials/mr-larry-satterfield-v.svg" class="rounded-full">
              </div>
            </td>
            <td data-label="Name">Mr. Larry Satterfield V</td>
            <td data-label="Company">Hyatt Ltd</td>
            <td data-label="City">Windlerburgh</td>
            <td data-label="Progress" class="progress-cell">
              <progress max="100" value="16">16</progress>
            </td>
            <td data-label="Created">
              <small class="text-gray-500" title="Dec 18, 2021">Dec 18, 2021</small>
            </td>
            <td class="actions-cell">
              <div class="buttons right nowrap">
                <button class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                  <span class="icon"><i class="mdi mdi-eye"></i></span>
                </button>
                <button class="button small red --jb-modal" data-target="sample-modal" type="button">
                  <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td class="image-cell">
              <div class="image">
                <img src="https://avatars.dicebear.com/v2/initials/mr-broderick-kub.svg" class="rounded-full">
              </div>
            </td>
            <td data-label="Name">Mr. Broderick Kub</td>
            <td data-label="Company">Kshlerin, Bauch and Ernser</td>
            <td data-label="City">New Kirstenport</td>
            <td data-label="Progress" class="progress-cell">
              <progress max="100" value="71">71</progress>
            </td>
            <td data-label="Created">
              <small class="text-gray-500" title="Sep 13, 2021">Sep 13, 2021</small>
            </td>
            <td class="actions-cell">
              <div class="buttons right nowrap">
                <button class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                  <span class="icon"><i class="mdi mdi-eye"></i></span>
                </button>
                <button class="button small red --jb-modal" data-target="sample-modal" type="button">
                  <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td class="image-cell">
              <div class="image">
                <img src="https://avatars.dicebear.com/v2/initials/barry-weber.svg" class="rounded-full">
              </div>
            </td>
            <td data-label="Name">Barry Weber</td>
            <td data-label="Company">Schulist, Mosciski and Heidenreich</td>
            <td data-label="City">East Violettestad</td>
            <td data-label="Progress" class="progress-cell">
              <progress max="100" value="80">80</progress>
            </td>
            <td data-label="Created">
              <small class="text-gray-500" title="Jul 24, 2021">Jul 24, 2021</small>
            </td>
            <td class="actions-cell">
              <div class="buttons right nowrap">
                <button class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                  <span class="icon"><i class="mdi mdi-eye"></i></span>
                </button>
                <button class="button small red --jb-modal" data-target="sample-modal" type="button">
                  <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td class="image-cell">
              <div class="image">
                <img src="https://avatars.dicebear.com/v2/initials/bert-kautzer-md.svg" class="rounded-full">
              </div>
            </td>
            <td data-label="Name">Bert Kautzer MD</td>
            <td data-label="Company">Gerhold and Sons</td>
            <td data-label="City">Mayeport</td>
            <td data-label="Progress" class="progress-cell">
              <progress max="100" value="62">62</progress>
            </td>
            <td data-label="Created">
              <small class="text-gray-500" title="Mar 30, 2021">Mar 30, 2021</small>
            </td>
            <td class="actions-cell">
              <div class="buttons right nowrap">
                <button class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                  <span class="icon"><i class="mdi mdi-eye"></i></span>
                </button>
                <button class="button small red --jb-modal" data-target="sample-modal" type="button">
                  <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td class="image-cell">
              <div class="image">
                <img src="https://avatars.dicebear.com/v2/initials/lonzo-steuber.svg" class="rounded-full">
              </div>
            </td>
            <td data-label="Name">Lonzo Steuber</td>
            <td data-label="Company">Skiles Ltd</td>
            <td data-label="City">Marilouville</td>
            <td data-label="Progress" class="progress-cell">
              <progress max="100" value="17">17</progress>
            </td>
            <td data-label="Created">
              <small class="text-gray-500" title="Feb 12, 2021">Feb 12, 2021</small>
            </td>
            <td class="actions-cell">
              <div class="buttons right nowrap">
                <button class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                  <span class="icon"><i class="mdi mdi-eye"></i></span>
                </button>
                <button class="button small red --jb-modal" data-target="sample-modal" type="button">
                  <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td class="image-cell">
              <div class="image">
                <img src="https://avatars.dicebear.com/v2/initials/jonathon-hahn.svg" class="rounded-full">
              </div>
            </td>
            <td data-label="Name">Jonathon Hahn</td>
            <td data-label="Company">Flatley Ltd</td>
            <td data-label="City">Billiemouth</td>
            <td data-label="Progress" class="progress-cell">
              <progress max="100" value="74">74</progress>
            </td>
            <td data-label="Created">
              <small class="text-gray-500" title="Dec 30, 2021">Dec 30, 2021</small>
            </td>
            <td class="actions-cell">
              <div class="buttons right nowrap">
                <button class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                  <span class="icon"><i class="mdi mdi-eye"></i></span>
                </button>
                <button class="button small red --jb-modal" data-target="sample-modal" type="button">
                  <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td class="image-cell">
              <div class="image">
                <img src="https://avatars.dicebear.com/v2/initials/ryley-wuckert.svg" class="rounded-full">
              </div>
            </td>
            <td data-label="Name">Ryley Wuckert</td>
            <td data-label="Company">Heller-Little</td>
            <td data-label="City">Emeraldtown</td>
            <td data-label="Progress" class="progress-cell">
              <progress max="100" value="54">54</progress>
            </td>
            <td data-label="Created">
              <small class="text-gray-500" title="Jun 28, 2021">Jun 28, 2021</small>
            </td>
            <td class="actions-cell">
              <div class="buttons right nowrap">
                <button class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                  <span class="icon"><i class="mdi mdi-eye"></i></span>
                </button>
                <button class="button small red --jb-modal" data-target="sample-modal" type="button">
                  <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                </button>
              </div>
            </td>
          </tr>
          <tr>
            <td class="image-cell">
              <div class="image">
                <img src="https://avatars.dicebear.com/v2/initials/sienna-hayes.svg" class="rounded-full">
              </div>
            </td>
            <td data-label="Name">Sienna Hayes</td>
            <td data-label="Company">Conn, Jerde and Douglas</td>
            <td data-label="City">Jonathanfort</td>
            <td data-label="Progress" class="progress-cell">
              <progress max="100" value="55">55</progress>
            </td>
            <td data-label="Created">
              <small class="text-gray-500" title="Mar 7, 2021">Mar 7, 2021</small>
            </td>
            <td class="actions-cell">
              <div class="buttons right nowrap">
                <button class="button small blue --jb-modal"  data-target="sample-modal-2" type="button">
                  <span class="icon"><i class="mdi mdi-eye"></i></span>
                </button>
                <button class="button small red --jb-modal" data-target="sample-modal" type="button">
                  <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                </button>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
        <div class="table-pagination">
          <div class="flex items-center justify-between">
            <div class="buttons">
              <button type="button" class="button active">1</button>
              <button type="button" class="button">2</button>
              <button type="button" class="button">3</button>
            </div>
            <small>Page 1 of 3</small>
          </div>
        </div>
      </div>
    </div>
  </section>

<footer class="footer">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
    <div class="flex items-center justify-start space-x-3">
      <div>
        © 2022, JustBoil.me
      </div>
      <a href="https://github.com/justboil/admin-one-tailwind" style="height: 20px">
        <img src="https://img.shields.io/github/v/release/justboil/admin-one-tailwind?color=%23999">
      </a>
    </div>
    <a href="https://justboil.me">
      <svg xmlns="http://www.w3.org/2000/svg" width="250" height="100" viewBox="0 0 250 100" class="w-auto h-8">
      </svg>
    </a>
  </div>
</footer>

<div id="sample-modal" class="modal">
  <div class="modal-background --jb-modal-close"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Sample modal</p>
    </header>
    <section class="modal-card-body">
      <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
      <p>This is sample modal</p>
    </section>
    <footer class="modal-card-foot">
      <button class="button --jb-modal-close">Cancel</button>
      <button class="button red --jb-modal-close">Confirm</button>
    </footer>
  </div>
</div>

<div id="sample-modal-2" class="modal">
  <div class="modal-background --jb-modal-close"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Sample modal</p>
    </header>
    <section class="modal-card-body">
      <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
      <p>This is sample modal</p>
    </section>
    <footer class="modal-card-foot">
      <button class="button --jb-modal-close">Cancel</button>
      <button class="button blue --jb-modal-close">Confirm</button>
    </footer>
  </div>
</div>

</div>

<!-- Grafik Berat Badan -->
<script>
        var data = <?php echo $data_json; ?>;
        var data_laki = <?php echo $data_json_kms_lakilaki ?>;
        // Siapkan label dan data untuk grafik
        var labels = data.map(function(item, index) {
        return index;
        });

        var dataset = {
            label: 'Berat Badan Anak',
            borderWidth: 2,
            data: data.map(function(item) {
                return item.berat_badan;
            }),
            borderColor: 'blue',
            fill: false
        };

        var garis_hitam_atas_bb = {
            label: 'Risiko berat badan lebih tinggi',
            borderWidth: 1,
            data: data_laki.map(function(item) {
                return item.garis_hitam_atas_bb;
            }),
            borderColor: 'black',
            fill: false
        };

        var garis_merah_atas_bb = {
            label: 'Risiko berat badan lebih',
            borderWidth: 1,
            data: data_laki.map(function(item) {
                return item.garis_merah_atas_bb;
            }),
            borderColor: 'red',
            fill: false
        };

        
        var normal_bb = {
            label: 'Berat badan normal',
            borderWidth: 1,
            data: data_laki.map(function(item) {
                return item.normal_bb;
            }),
            borderColor: 'green',
            fill: false
        };

        var garis_merah_bawah_bb = {
            label: 'Berat badan kurang',
            borderWidth: 1,
            data: data_laki.map(function(item) {
                return item.garis_merah_bawah_bb;
            }),
            borderColor: 'red',
            fill: false
        };

        var garis_hitam_bawah_bb = {
            label: 'Berat badan sangat kurang',
            borderWidth: 1,
            data: data_laki.map(function(item) {
                return item.garis_hitam_bawah_bb;
            }),
            borderColor: 'black',
            fill: false
        };

        // Siapkan data untuk garis tambahan
        // var additionalDataset = {
        //     label: 'Tambah 1',
        //     data: data.map(function(item, index) {
        //         return index * 10;
        //     }),
        //     borderColor: 'red',
        //     borderDash: [5, 5], // Garis putus-putus
        //     fill: false
        // };

        var config = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [dataset,garis_hitam_atas_bb, garis_merah_atas_bb, normal_bb, garis_merah_bawah_bb, garis_hitam_bawah_bb]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Data Observasi Pasien'
                },
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Bulan Berobat'
                        }
                    }],
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Berat Badan'
                        },
                        gridLines: {
                            display: false // Menonaktifkan gridlines pada sumbu Y
                        }
                    }]
                },
                legend: {
                    display: false // Menonaktifkan legend
                },
                tooltips: {
            mode: 'nearest',
            intersect: false,
            backgroundColor: 'rgba(230, 230, 230, 0.8)', // Warna latar belakang
    titleFontColor: 'black', // Warna judul tooltip
    bodyFontColor: 'black', // Warna teks tooltip
    titleFontSize: 14, // Ukuran font judul tooltip
    bodyFontSize: 12, // Ukuran font teks tooltip
    

        }
            }
        };

        // Buat dan tampilkan grafik menggunakan Chart.js
        var myChart = new Chart(
            document.getElementById('lineChart_BB'),
            config
        );
    </script>
    <!-- End Grafik -->
    <!-- Grafik Tinggi Badan -->
<script>
        var data = <?php echo $data_json; ?>;

        // Siapkan label dan data untuk grafik
        var labels = data.map(function(item) {
            return item.tanggal_berobat;
        });

        var dataset = {
            label: 'Analisis Berat Badan',
            data: data.map(function(item) {
                return item.tinggi_badan;
            }),
            borderColor: 'blue',
            fill: false
        };

        var config = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [dataset]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Data Observasi Pasien'
                },
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Waktu'
                        },
                        
                    }],
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Tinggi Badan'
                        },
                        gridLines: {
                            display: false // Menonaktifkan gridlines pada sumbu Y
                        }
                    }]
                },
                legend: {
                    display: false // Menonaktifkan legend
                }
            }
        };

        // Buat dan tampilkan grafik menggunakan Chart.js
        var myChart = new Chart(
            document.getElementById('lineChart_TB'),
            config
        );
    </script>
    <!-- End Grafik -->
<!-- Scripts below are for demo only -->
<script type="text/javascript" src="js/main.min.js?v=1652870200386"></script>
<!-- menampilkan chart -->
<!-- <script type="text/javascript" src="js/chart.sample.min.js"></script> -->


<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '658339141622648');
  fbq('track', 'PageView');
</script>

<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=658339141622648&ev=PageView&noscript=1"/></noscript>

<!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">

</body>
</html>
