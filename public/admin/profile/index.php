<?php

// Mulai sesi
ob_start();
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika belum, redirect ke halaman login
    header("Location: login_form.php");
    exit();
}
// Koneksi ke Database
include "../../koneksi.php";

// Mengambil Data Sesuai Session
$username = $_SESSION['username'];
$query="SELECT * FROM user where username= '$username'";
// Memasukkan Kedalam array hasil dari query
$result = mysqli_query($conn, $query);
$data=mysqli_fetch_assoc($result);



?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile - Admin One Tailwind CSS Admin Dashboard</title>

  <!-- Tailwind is included -->
  <link rel="stylesheet" href="../../css/main.css">
  <script type="text/javascript" src="./js/main.min.js"></script>

  <script></script>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130795909-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-130795909-1');
  </script>
      <!-- Include SweetAlert CSS -->
      <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>
  <!-- Include SweetAlert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


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
          <div class="user-avatar">
            <img src=uploads/<?php echo $data['profile_photo'] ?> alt="John Doe" class="rounded-full">
          </div>
          <div class="is-user-name">
            <span>
            
              <?php echo $data['username']; ?>
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
    <li class="">
            <a class="dropdown">
              <span class="icon"><i class="mdi mdi-view-list"></i></span>
              <span class="menu-item-label">Data Pasien</span>
              <span class="icon"><i class="mdi mdi-plus"></i></span>
            </a>
            <ul>
              <li class="">
                <a href="../tables">
                  <span class="icon"><i class="mdi mdi-human-pregnant"></i></span>
                  <span class="menu-item-label">Data Ibu</span>
                </a>
              </li>
              <li class="">
                <a href="../tables/list_anak.php">
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
      <li class="active">
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
      <li>Profile</li>
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
      Profile
    </h1>
    <button class="button light">Button</button>
  </div>
</section>

  <section class="section main-section">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account-circle"></i></span>
            Edit Profile
          </p>
        </header>
        <div class="card-content">
          <form id="profileForm" action="upload_data.php" method="POST" enctype="multipart/form-data">
            <div class="field">
              <label class="label">Avatar</label>
              <div class="field-body">
                <div class="field file">
                  <label class=" ">
                    <input class="button blue" type="file" name="photo" accept="image/*">
                  </label>
                </div>
              </div>
            </div>
            <hr>
            <div class="field">
              <label class="label">Name</label>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input type="text" autocomplete="off" name="name" value="<?php echo $data['name'];?>" class="input" required>
                  </div>
                  <p class="help">Required. Your name</p>
                </div>
              </div>
            </div>
            <div class="field">
              <label class="label">E-mail</label>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input type="email" autocomplete="off" name="email" value="<?php echo $data['email'];?>" class="input" required>
                  </div>
                  <p class="help">Required. Your e-mail</p>
                </div>
              </div>
            </div>
            <div class="field">
              <label class="label">NIK</label>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input type="text" autocomplete="off" name="nik" value="<?php echo $data['nik'];?>" class="input" required>
                  </div>
                  <p class="help">Required. Your NIK</p>
                </div>
              </div>
            </div>
            <div class="field">
              <label class="label">Pembiayaan</label>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input type="text" autocomplete="off" name="pembiayaan" value="<?php echo $data['pembiayaan'];?>" class="input" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="field">
              <label class="label">Pekerjaan</label>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input type="text" autocomplete="off" name="pekerjaan" value="<?php echo $data['pekerjaan'];?>" class="input" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="field">
              <label class="label">Golongan Darah</label>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input type="text" autocomplete="off" name="golongan_darah" value="<?php echo $data['golongan_darah'];?>" class="input" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="field">
              <label class="label">Tempat, Tanggal Lahir</label>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input type="text" autocomplete="off" name="tmpt_tgl_lahir" value="<?php echo $data['tmpt_tgl_lahir'];?>" class="input" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="field">
              <label class="label">Nomor JKN</label>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input type="text" autocomplete="off" name="no_jkn" value="<?php echo $data['no_jkn'];?>" class="input" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="field">
              <label class="label">Fasilitas Kesehatan Tingkat Pertama</label>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input type="text" autocomplete="off" name="faskes_tk_1" value="<?php echo $data['faskes_tk_1'];?>" class="input" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="field">
              <label class="label">Fasilitas Kesehatan Rujukan</label>
              <div class="field-body">
                <div class="field">
                  <div class="control">
                    <input type="text" autocomplete="off" name="faskes_rujukan" value="<?php echo $data['faskes_rujukan'];?>" class="input" required>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="field">
              <div class="control">
                <button type="submit" class="button green">
                  Submit
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            Profile
          </p>
        </header>
        <div class="card-content">
          <div class="field">

            <div class="image w-48 h-20 mx-auto ">
              <img src=uploads/<?php echo $data['profile_photo'] ?> alt="John Doe" class="rounded-full">
            </div>
          </div>
          <hr>
          <div class="field">
            <label class="label">Name</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $data['name'];?>" class="input is-static">
            </div>
          </div>
          <hr>
          <div class="field">
            <label class="label">E-mail</label>
            <div class="control">
              <input type="text" readonly value="<?php echo $data['email'];?>" class="input is-static">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-lock"></i></span>
          Change Password
        </p>
      </header>
      <div class="card-content">
        <form id="change-password-form" >
          <div class="field">
            <label class="label">Current password</label>
            <div class="control">
              <input type="password" name="current_password" id="current-password" autocomplete="current-password" class="input" required>
            </div>
            <p class="help">Required. Your current password</p>
          </div>
          <hr>
          <div class="field">
            <label class="label">New password</label>
            <div class="control">
              <input type="password" autocomplete="new-password" name="new_password" id="new-password" class="input" required>
            </div>
            <p class="help">Required. New password</p>
          </div>
          <div class="field">
            <label class="label">Confirm password</label>
            <div class="control">
              <input type="password" autocomplete="confirm-new-password" name="confirm_new_password" id="confirm-new-password" class="input" required>
            </div>
            <p class="help">Required. New password one more time</p>
          </div>
          <hr>
          <div class="field">
            <div class="control">
              <button type="submit" class="button green">
                Submit
              </button>
            </div>
          </div>
        </form>
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
  </div>
</footer>





</div>

<!-- Scripts below are for demo only -->
<script type="text/javascript" src="../js/main.min.js?v=1652870200386"></script>

<!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">
<script>
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
        document.getElementById('profileForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);

            fetch('upload_data.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('Profile updated successfully!')) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Update Data successfully!',
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
<script>
        document.getElementById('change-password-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission

            const currentPassword = document.getElementById('current-password').value;
            const newPassword = document.getElementById('new-password').value;
            const confirmNewPassword = document.getElementById('confirm-new-password').value;

            if (newPassword !== confirmNewPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'New passwords do not match.'
                });
                return;
            }

            if (newPassword.length < 6) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'New password must be at least 6 characters long.'
                });
                return;
            }

            // Submit the form using AJAX
            const formData = new FormData(document.getElementById('change-password-form'));

            fetch('change_password.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('Password changed successfully.')) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data
                      }).then(() => {
                        location.reload(); // Refresh page
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data
                        
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while changing the password.'
                });
            });
        });
    </script>
</body>
</html>
