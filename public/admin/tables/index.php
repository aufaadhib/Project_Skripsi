<?php

// Mulai sesi
ob_start();
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  // Jika belum, redirect ke halaman login
  header("Location: ../");
  exit();
}
// Koneksi ke Database
include "../../koneksi.php";

// Mengambil Data Sesuai Session
$username = $_SESSION['username'];
$_SESSION['page'] = isset($_GET['page']) && $_GET['page'] > 0 ? $_GET['page'] : 1;
?>

<!DOCTYPE html>
<html lang="en" class="">

<head>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tables - Admin One Tailwind CSS Admin Dashboard</title>

  <!-- Tailwind is included -->
  <link rel="stylesheet" href="../../css/main.css">
  <!-- <link rel="stylesheet" href="/src/css/output.css"> -->
  <script type="text/javascript" src="../js/main.min.js?v=1652870200386"></script>

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130795909-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-130795909-1');
  </script>

  <!-- Tambahkan JavaScript dan CSS di sini -->

  <style>
    .hidden {
      display: none;
    }
  </style>
  <!-- Akhir tambahan JavaScript dan CSS -->

</head>

<body>

  <div id="app">

    <!-- Awal Navbar -->
    <nav id="navbar-main" class="navbar is-fixed-top">
      <div class="navbar-brand">
        <!-- <a class="navbar-item mobile-aside-button">
          <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
        </a> -->
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
              <?php
              $username = $_SESSION['username'];
              $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
              $stmt->bind_param("s", $username);
              $stmt->execute();
              $result = $stmt->get_result();
              $data = $result->fetch_assoc();
              ?>
              <div class="user-avatar">
                <img src=../profile/uploads/<?php echo $data['profile_photo'] ?> alt="John Doe" class="rounded-full">
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
              <form action="../function/logout.php" method="post">
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
          <li class="--set-active-index-html">
            <a href="../">
              <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
              <span class="menu-item-label">Dashboard</span>
            </a>
          </li>
        </ul>
        <p class="menu-label">Examples</p>
        <ul class="menu-list">
        <li class="active">
            <a class="dropdown">
              <span class="icon"><i class="mdi mdi-view-list"></i></span>
              <span class="menu-item-label">Data Pasien</span>
              <span class="icon"><i class="mdi mdi-plus"></i></span>
            </a>
            <ul>
              <li class="">
                <a href="">
                  <span class="icon"><i class="mdi mdi-human-pregnant"></i></span>
                  <span class="menu-item-label">Data Ibu</span>
                </a>
              </li>
              <li class="active">
                <a href="list_anak.php">
                  <span class="icon"><i class="mdi mdi-baby"></i></span>
                  <span class="menu-item-label">Data Anak</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="--set-active-forms-html">
            <a href="../forms">
              <span class="icon"><i class="mdi mdi-square-edit-outline"></i></span>
              <span class="menu-item-label">Forms</span>
            </a>
          </li>
          <li class="--set-active-profile-html">
            <a href="../profile">
              <span class="icon"><i class="mdi mdi-account-circle"></i></span>
              <span class="menu-item-label">Profile</span>
            </a>
          </li>

        </ul>

      </div>
    </aside>
    <a href="../profile/up"></a>

    <!-- Akhir Sidebar -->
    <section class="is-title-bar">
      <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
        <ul>
          <li>Admin</li>
          <li>Tables</li>
        </ul>

      </div>
    </section>

    <!-- <section class="is-hero-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="title">
      Responsive Tables
    </h1>
    <button class="button light">Button</button>
  </div>
</section> -->

    <section class="section main-section">
      <!-- <div class="notification blue">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
          <div>
            <span class="icon"><i class="mdi mdi-buffer"></i></span>
            <b>Responsive table</b>
          </div>
          <button type="button" class="button small textual --jb-notification-dismiss">Dismiss</button>
        </div>
      </div> -->

      <!-- Content Card Table  -->
      <div id="result"></div>
    </section>


    <!-- Scripts below are for demo only -->
    <script src="../js/main.min.js?v=1652870200386"></script>

    <script>
      // function hapusData(idPasien) {
      //   if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
      //     // Kirim permintaan AJAX untuk menghapus data
      //     var xhr = new XMLHttpRequest();
      //     xhr.open("POST", "hapus_data.php", true);
      //     xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      //     xhr.onreadystatechange = function() {
      //       if (xhr.readyState == 4 && xhr.status == 200) {
      //         // Tampilkan notifikasi setelah data dihapus
      //         alert("Data berhasil dihapus");
      //         location.reload();

      //       }
      //     };
      //     xhr.send("id_pasien=" + idPasien);
      //   }
      // }

      // Fungsi Hapus Data
      function hapusData(idUser) {
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
            xhr.open("POST", "hapus_data_user.php", true);
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
            xhr.send("id_user=" + idUser);
          }
        });
      }

      // Fungsi Lihat Data
      function lihatData(idPasien) {
        // Kirim permintaan AJAX untuk menghapus data
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "index.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            // Tampilkan notifikasi setelah data dihapus
            // location.reload();

          }
        };
        xhr.send("id_pasien=" + idPasien);
      }

      //Fungsi Tombol Anak
      function hideRow(element) {
        var userId = element.dataset.id; // Mendapatkan ID pasien dari atribut data pada elemen
        var anakRows = document.querySelectorAll('[data-id-ibu="' + userId + '"]');
        anakRows.forEach(function(anakRow) {
        if (anakRow.classList.contains('hidden')) {
            anakRow.classList.remove('hidden');
        } else {
            anakRow.classList.add('hidden');
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

    <!-- LiveSearching -->
    <script>
    $(document).ready(function() {
      // Fungsi untuk memuat data dengan query pencarian dan pagination
      function load_data(page = 1, query = '') {
        $.ajax({
          url: "search_ibu.php",
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

    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=658339141622648&ev=PageView&noscript=1" /></noscript>

    <!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">

</body>

</html>