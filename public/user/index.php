<?php
ob_start();
session_start();
$username = $_SESSION['username'];
if (!isset($username)) {
    header('location:../index.php');
}
include "../koneksi.php";

// Mengambil Data Sesuai Session
$username = $_SESSION['username'];
$query="SELECT * FROM user where username= '$username'";
$result = mysqli_query($conn, $query);
$data=mysqli_fetch_assoc($result);
$id_user=$data['id_user'];

// Memasukkan Kedalam array hasil dari query
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_pasien'])) {
// // Escape input untuk mencegah serangan SQL Injection
// $id_pasien = mysqli_real_escape_string($conn, $_POST['id_pasien']);
// $query = "SELECT tanggal_berobat, berat_badan FROM riwayat_berobat WHERE id_pasien='$id_pasien'";
// $result = mysqli_query($conn, $query);

// Query untuk mengambil data riwayat_berobat berdasarkan kondisi yang diberikan
$sql = "SELECT riwayat_berobat.tanggal_berobat, riwayat_berobat.berat_badan, riwayat_berobat.tinggi_badan FROM riwayat_berobat 
INNER JOIN data_pasien ON riwayat_berobat.id_pasien = data_pasien.id_pasien 
INNER JOIN user ON data_pasien.id_user = user.id_user WHERE user.id_user = $id_user";
$result = mysqli_query($conn, $sql);
// $data=mysqli_fetch_assoc($result);

// Proses data
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}


// Konversi data ke format JSON
$data_json = json_encode($data);


$sql_berat_laki="SELECT * FROM grafik_kms_lakilaki";
$result_berat_laki = mysqli_query($conn, $sql_berat_laki);
// Proses data
$data_laki = array();
while ($row = mysqli_fetch_assoc($result_berat_laki)) {
    $data_laki[] = $row;
}


// Konversi data ke format JSON
$data_json_bb_laki = json_encode($data_laki);

?>

<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Admin One Tailwind CSS Admin Dashboard</title>

  <!-- Tailwind is included -->
  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png"/>
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png"/>
  <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png"/>
  <link rel="mask-icon" href="safari-pinned-tab.svg" color="#00b4b6"/>

  <meta name="description" content="Admin One - free Tailwind dashboard">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130795909-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-130795909-1');
  </script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

  <!-- Tailwind is included -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../css/main.css">
  <script type="text/javascript" src="../js/main.min.js?v=1652870200386"></script>

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

<div id="app">
<!-- Awal Navbar -->
<nav id="navbar-main" class="navbar is-fixed-top">
  <div class="navbar-brand">
    <a class="navbar-item mobile-aside-button">
      <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
    </a>
    <div class="navbar-item">
      <div class="control"><input placeholder="Search everywhere..." class="input" id="searchInput"></div>
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
          <div class="user-avatar">
            <img src=profile/uploads/<?php echo $_SESSION['profile_photo'] ?> alt="John Doe" class="rounded-full">
          </div>
          <div class="is-user-name">
            <span>
            
              <?php echo $_SESSION['username']; ?>
          </span></div>
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
        <a href="">
          <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
          <span class="menu-item-label">Dashboard</span>
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
                
                $sql = "SELECT COUNT(riwayat_berobat.id_riwayat) AS total_kunjungan FROM riwayat_berobat 
                INNER JOIN data_pasien ON riwayat_berobat.id_pasien = data_pasien.id_pasien 
                INNER JOIN user ON data_pasien.id_user = user.id_user WHERE user.id_user = $id_user";
                
                // $query = "SELECT COUNT(id_riwayat) AS total_kunjungan FROM riwayat_berobat WHERE id_pasien='$id_pasien'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $total_kunjungan = $row['total_kunjungan'];
                ?>
              </h3>
              <h2 class="text-lg font-semibold">
                <?php echo $total_kunjungan ;
                ?>
              </h2>
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
                $sql = "SELECT MAX(riwayat_berobat.tanggal_berobat) AS kunjungan_terakhir FROM riwayat_berobat 
                INNER JOIN data_pasien ON riwayat_berobat.id_pasien = data_pasien.id_pasien 
                INNER JOIN user ON data_pasien.id_user = user.id_user WHERE user.id_user = $id_user";
                
                // $query = "SELECT MAX(tanggal_berobat) AS kunjungan_terakhir FROM riwayat_berobat  WHERE id_pasien='$id_pasien'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $kunjungan_terakhir = $row['kunjungan_terakhir'];
                ?>
              </h3>
              <h2 class="text-lg font-semibold justify-center">
              <?php echo $kunjungan_terakhir
                ?>
              </h2>
            </div>
            <span class="icon widget-icon text-blue-500"><i class="mdi mdi-history mdi-48px"></i></span>
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
                    $sql = "SELECT MIN(riwayat_berobat.rencana_berobat) AS jadwal, data_pasien.nama_depan as nama FROM riwayat_berobat 
                INNER JOIN data_pasien ON riwayat_berobat.id_pasien = data_pasien.id_pasien 
                INNER JOIN user ON data_pasien.id_user = user.id_user WHERE user.id_user = $id_user AND riwayat_berobat.rencana_berobat >= CURDATE()";
                
                    // $query = "SELECT MAX(rencana_berobat) AS jadwal FROM riwayat_berobat  WHERE id_pasien='$id_pasien'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $tanggal_rencana = $row['jadwal'];
                    $nama = $row['nama'];
                    // Tampilkan tanggal rencana berobat di halaman HTML
                    echo "<span id='tanggal_rencana' style='display:none;'>$tanggal_rencana</span>";
                ?>
              </h3>
              <?php 
              if (!$nama) {
                
                echo "";
            }else{
              echo "<h2 class='text-lg font-semibold'>Nama Anak : $nama ";
            }
                ?>
              </h2>
              <p class="text-lg" id="countdown">
              <!-- <div id="countdown"></div> -->
              </p>
              
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
            <span class="icon widget-icon text-red-500"><i class="mdi mdi-timetable mdi-48px"></i></span>
          </div>
        </div>
      </div>
    </div>
    <!-- Content Card Table  -->
    <div id="result"></div>
    <!-- Grafik Berat Badan -->
    <!-- <div class="card mb-6">
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
    Grafik Tinggi Badan 
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
    </div> -->

    <!-- <div class="notification blue">
      <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
        <div>
          <span class="icon"><i class="mdi mdi-buffer"></i></span>
          <b>Responsive table</b>
        </div>
        <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
      </div>
    </div> -->

    
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
        var data_berat = <?php echo $data_json_bb_laki; ?>;
        // Siapkan label dan data untuk grafik
        var labels = data.map(function(item) {
            return item.tanggal_berobat;
        });

        var dataset = {
            label: 'Berat Badan',
            data: data.map(function(item) {
                return item.berat_badan;
            }),
            borderColor: 'blue',
            fill: false
        };

        // // Siapkan data untuk garis tambahan
        // var additionalDataset = {
        //     label: 'Batas Tidak Normal',
        //     data: data.map(function(item, index) {
        //         return index * 10;
        //     }),
        //     borderColor: 'red',
        //     borderDash: [5, 5], // Garis putus-putus
        //     fill: false
        // };

        var normal = {
            label: 'Berat Badan Normal',
            data: data_berat.map(function(item) {
                return item.normal;
            }),
            borderColor: 'green',
            fill: false
        };

        var tidak_normal = {
            label: 'Berat Badan Tidak Normal',
            data: data_berat.map(function(item) {
                return item.batas_bawah;
            }),
            borderColor: 'red',
            fill: false
        };

        var obesitas = {
            label: 'Berat Badan Tidak Normal',
            data: data_berat.map(function(item) {
                return item.batas_atas;
            }),
            borderColor: 'yellow',
            fill: false
        };

        // // Siapkan data untuk garis tambahan
        // var bb_normal= {
        //     label: 'Batas Tidak Normal',
        //     data: data_bb.map(function(item, index) {
        //       return item.normal;
        //     }),
        //     borderColor: 'blue',
        //     borderDash: [5, 5], // Garis putus-putus
        //     fill: false
        // };

        var config = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [dataset, normal, tidak_normal, obesitas ]
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
            label: 'Analisis Tinggi Badan',
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
                        }
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

<!-- Scripts below are for demo only -->
<script type="text/javascript" src="js/main.min.js?v=1652870200386"></script>
<!-- menampilkan chart -->
<!-- <script type="text/javascript" src="js/chart.sample.min.js"></script> -->


<!-- LiveSearching -->
<script>
    $(document).ready(function() {
      // Fungsi untuk memuat data dengan query pencarian dan pagination
      function load_data(page = 1, query = '') {
        $.ajax({
          url: "search_anak.php",
          method: "POST",
          data: {
            page: page,
            query: query
          },
          success: function(data) {
            $('#result').html(data);
          }
        });
      }

      // Memuat data pertama kali ketika halaman dimuat
      load_data();

      // Event handler untuk pencarian berdasarkan input
      $('#searchInput').keyup(function() {
        var query = $(this).val();
        load_data(1, query);
      });

      // Event handler untuk mengganti halaman pagination
      $(document).on('click', '.page_link', function() {
        var page = $(this).attr("id");
        var query = $('#searchInput').val();
        load_data(page, query);
      });
    });
  </script>

<script>
  // Fungsi Hapus Data
  function hapusData(idPasien) {
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak akan dapat mengembalikan data ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
      }).then((result) => {
        if (result.isConfirmed) {
          // Kirim permintaan AJAX untuk menghapus data
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "hapus_data_anak.php", true);
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
              // Tampilkan notifikasi setelah data dihapus
              Swal.fire(
                'Dihapus!',
                'Data berhasil dihapus.',
                'success'
              ).then(() => {
                location.reload(); // Muat ulang halaman setelah konfirmasi
              });
            }
          };
          xhr.send("id_pasien=" + idPasien);
        }
      });
    }

    // Fungsi Email
    function sendEmail(idPasien) {
      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to send this email?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, send it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: 'autoloader.php',
            type: 'POST',
            data: {
              id_pasien: idPasien
            },
            success: function(response) {
              Swal.fire(
                'Sent!',
                'The email has been sent.',
                'success'
              );
            },
            error: function() {
              Swal.fire(
                'Error!',
                'There was an error sending the email.',
                'error'
              );
            }
          });
        }
      });
    }

</script>


<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=658339141622648&ev=PageView&noscript=1"/></noscript>

<!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">

</body>
</html>
