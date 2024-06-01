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
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- <script src="../../css/output.css"></script> -->
  <link rel="stylesheet" href="../../css/main.css">
  <script type="text/javascript" src="../js/main.min.js?v=1652870200386"></script>

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <script src="../../../node_modules/flowbite/dist/flowbite.min.js"></script>

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
              <?php
              $username = $_SESSION['username'];
              $query = "SELECT * FROM user where username= '$username'";
              $result = mysqli_query($conn, $query);
              $data = mysqli_fetch_assoc($result);
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
              <li class="active">
                <a href="index.php">
                  <span class="icon"><i class="mdi mdi-human-pregnant"></i></span>
                  <span class="menu-item-label">Data Ibu</span>
                </a>
              </li>
              <li class="">
                <a href="">
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

    <!-- Akhir Sidebar -->
    <section class="is-title-bar">
      <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
        <ul>
          <li>Admin</li>
          <li>Tables</li>
        </ul>

        <button data-modal-target="default-modal" data-modal-toggle="default-modal">
          <span class="icon"><i class="mdi mdi-account-multiple-plus mdi-24px"></i></span>
        </button>
        <!-- Main modal -->
        <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                  Tambah Data Anak
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="default-modal">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                  <span class="sr-only">Close modal</span>
                </button>
              </div>
              <!-- Modal body -->
              <form id="register_anak" class="p-4 md:p-5" method="post" action="tambah_anak.php">
                <div class="grid gap-4 mb-4 grid-cols-2">
                  <div class="col-span-2">
                    <label for="no_akta" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No Akta Kelahiran</label>
                    <input type="text" name="no_akta" id="no_akta" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required="">
                  </div>
                  <div class="col-span-2">
                    <label for="id_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Ibu</label>
                    <select id="id_user_dropdown" name="id_user" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                      <option value="" selected disabled hidden>Pilih Nama Ibu</option>
                      <?php
                      // Query untuk mengambil data ibu dari tabel ibu
                      $query = "SELECT id_user, name FROM user";
                      $result = mysqli_query($conn, $query);
                      if (!$result) {
                        die("Query prepare failed (Output All): " . $conn->error);
                    }

                      // Mengecek apakah ada data ibu
                      if (mysqli_num_rows($result) > 0) {
                        // Menampilkan data ibu dalam dropdown
                        while ($row = mysqli_fetch_assoc($result)) {
                          echo "<option value='" . $row['id_user'] . "'>".$row['id_user'].' - ' . $row['name'] . "</option>";
                        }
                      } else {
                        echo "<option value='' disabled>Data ibu tidak tersedia</option>";
                      }

                      ?>
                    </select>
                    
                  </div>

                  <div class="col-span-2 sm:col-span-1">
                    <label for="nama_depan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Depan</label>
                    <input type="text" name="nama_depan" id="nama_depan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nama Depan" required="">
                  </div>
                  <div class="col-span-2 sm:col-span-1">
                    <label for="nama_belakang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Belakang</label>
                    <input type="text" name="nama_belakang" id="nama_belakang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nama Belakang" required="">
                  </div>
                  <div class="col-span-2">
                    <label for="tmpt_tgl_lahir" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tempat, Tanggal Lahir</label>
                    <input type="text" name="tmpt_tgl_lahir" id="tmpt_tgl_lahir" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Banyuwangi, 20 Juni 2001" required="">
                  </div>
                  <div class="col-span-2 sm:col-span-2">
                    <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Kelamin</label>
                    <select id="gender" name="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                      <option value="" selected disabled hidden>Jenis Kelamin</option>
                      <option value="Laki-laki">Laki-laki</option>
                      <option value="Perempuan">Perempuan</option>
                    </select>
                  </div>
                  
                </div>
                <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                  <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                  </svg>
                  Tambah Data Anak
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section main-section">

      <!-- Content Card Table  -->
      <div id="result"></div>

    </section>
  </div>

  <!-- Scripts below are for demo only -->
  <script src="../js/main.min.js?v=1652870200386"></script>

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

  <script>
    document.getElementById('register_anak').addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            fetch('tambah_anak.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('Profile updated successfully!')) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data Anak Berhasil Ditambahkan',
                      }).then(() => {
                        location.reload(); // Refresh page
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'error',
                        text: data,
                      }).then(() => {
                        location.reload(); // Refresh page
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was an error updating your profile.',
                });
            });
        });
  </script>

  <!-- Output Data ALL -->
  <!-- <script>
    function loadData() {
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "search_anak.php", true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          document.getElementById("result").innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }

    window.onload = function() {
      loadData();
    };
  </script> -->

  <!-- <script>
      $(document).ready(function() {
        function fetch_data(query = '') {
          $.ajax({
            url: "search_anak.php",
            method: "POST",
            data: {
              query: query
            },
            success: function(data) {
              $('#result').html(data);
            }
          });
        }

        $('#searchInput').on('input', function() {
          var query = $(this).val();
          fetch_data(query);
        });

        // Load full data initially
        fetch_data();
      });
    </script> -->

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



  <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=658339141622648&ev=PageView&noscript=1" /></noscript>

  <!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">


</body>

</html>