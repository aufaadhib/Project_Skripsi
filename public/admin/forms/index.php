<?php
ob_start();
session_start();
$username = $_SESSION['username'];
if (!isset($username)) {
  header('location:../index.php');
}
include "../../koneksi.php";
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
  <link rel="stylesheet" href="../../css/main.css?v=1652870200386">
  <script type="text/javascript" src="../js/main.min.js?v=1652870200386"></script>



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
  <style>
    #dropdown {
      border: 1px solid #ccc;
      display: none;
      /* position: absolute; */
      max-height: 150px;
      overflow-y: auto;
      background: white;
      width: 100%;
      left: 0;
      z-index: 1000;
    }

    #dropdown div {
      padding: 8px;
      cursor: pointer;
    }

    #dropdown div:hover {
      background-color: #f0f0f0;
    }
  </style>

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
          <li class="--set-active-dashboard-html">
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
          <li class="active">
            <a href="../forms/">
              <span class="icon"><i class="mdi mdi-square-edit-outline"></i></span>
              <span class="menu-item-label">Forms</span>
            </a>
          </li>
          <li class="--set-active-profile-html">
            <a href="../profile/">
              <span class="icon"><i class="mdi mdi-account-circle"></i></span>
              <span class="menu-item-label">Profile</span>
            </a>
          </li>
        </ul>

      </div>
    </aside>

    <!-- Akhir Sidebar -->
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <script src="https://cdn.tailwindcss.com"></script>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Dropdown with Live Search</title>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <section class="is-title-bar">
      <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
        <ul>
          <li>Admin</li>
          <li>Forms</li>
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
          Forms
        </h1>
        <button class="button light">Button</button>
      </div>
    </section>

    <section class="section main-section">
      <div class="card mb-6">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-ballot"></i></span>
            Forms
          </p>
        </header>
        <div class="card-content">
          <form method="post" action="rekam_medis.php">
            <div class="field">
              <div class="field-body">
                <div class="field">
                  <label class="label">Tanggal Berobat</label>
                  <div class="control icons-left">
                    <?php $date = date('Y-m-d H:i:s'); ?>
                    <input class="input" type="date" value=<?php echo $date ?> name="tanggal_berobat">
                    <span class="icon left"><i class="mdi mdi-mail"></i></span>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Nama Pasien</label>
                  <div class="control icons-left">
                    <input type="hidden" id="selectedId" name="id_pasien">
                    <input class="input" type="text" placeholder="Nama Pasien" id="searchInput" autocomplete="off">
                    <div id="dropdown">
                    </div>
                    <span class="icon left"><i class="mdi mdi-account"></i></span>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Berat Badan Pasien</label>
                  <div class="control icons-left">

                    <input class="input" type="text" placeholder="Berat Badan" value="" name="berat_badan">
                    <span class="icon left"><i class="mdi mdi-mail"></i></span>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Tinggi Badan Pasien</label>
                  <div class="control icons-left">

                    <input class="input" type="text" placeholder="Berat Badan" value="" name="tinggi_badan">
                    <span class="icon left"><i class="mdi mdi-mail"></i></span>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Diagnosa Pasien</label>
                  <div class="control">
                    <textarea class="textarea" placeholder="Jelaskan diagnosa hasil berobat" name="diagnosa"></textarea>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Keterangan Tambahan Pasien</label>
                  <div class="control">
                    <textarea class="textarea" placeholder="Jelaskan keterangan tambahan pasien" name="keterangan_lainnya"></textarea>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Rencana Berobat</label>
                  <div class="control icons-left">
                    <input class="input" type="date" name="rencana_berobat">
                    <span class="icon left"><i class="mdi mdi-mail"></i></span>
                  </div>
                </div>
              </div>
            </div>
            <hr>

            <div class="field grouped">
              <div class="control">
                <button type="submit" class="button green">
                  Submit
                </button>
              </div>
              <div class="control">
                <button type="reset" class="button red">
                  Reset
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-ballot-outline"></i></span>
            Custom elements
          </p>
        </header>
        <div class="card-content">
          <div class="field">
            <label class="label">Checkbox</label>
            <div class="field-body">
              <div class="field grouped multiline">
                <div class="control">
                  <label class="checkbox"><input type="checkbox" value="lorem" checked>
                    <span class="check"></span>
                    <span class="control-label">Lorem</span>
                  </label>
                </div>
                <div class="control">
                  <label class="checkbox"><input type="checkbox" value="ipsum">
                    <span class="check"></span>
                    <span class="control-label">Ipsum</span>
                  </label>
                </div>
                <div class="control">
                  <label class="checkbox"><input type="checkbox" value="dolore">
                    <span class="check is-primary"></span>
                    <span class="control-label">Dolore</span>
                  </label>
                </div>
              </div>
            </div>
          </div>
          <hr>
          <div class="field">
            <label class="label">Radio</label>
            <div class="field-body">
              <div class="field grouped multiline">
                <div class="control">
                  <label class="radio">
                    <input type="radio" name="sample-radio" value="one" checked>
                    <span class="check"></span>
                    <span class="control-label">One</span>
                  </label>
                </div>
                <div class="control">
                  <label class="radio">
                    <input type="radio" name="sample-radio" value="two">
                    <span class="check"></span>
                    <span class="control-label">Two</span>
                  </label>
                </div>
              </div>
            </div>
          </div>
          <hr>
          <div class="field">
            <label class="label">Switch</label>
            <div class="field-body">
              <div class="field">
                <label class="switch">
                  <input type="checkbox" value="false">
                  <span class="check"></span>
                  <span class="control-label">Default</span>
                </label>
              </div>
            </div>
          </div>
          <hr>
          <div class="field">
            <label class="label">File</label>
            <div class="field-body">
              <div class="field file">
                <label class="upload control">
                  <a class="button blue">
                    Upload
                  </a>
                  <input type="file">
                </label>
              </div>
            </div>
          </div>
        </div>
      </div> -->
    </section>


    <footer class="footer">
      <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0">
        <div class="flex items-center justify-start space-x-3">
          <div>
            © 2024, Universitas Ahmad Dahlan
          </div>
        </div>
      </div>
    </footer>
  </div>

  <script type="text/javascript" src="../js/main.min.js?v=1652870200386"></script>


 
  <script>
    $(document).ready(function() {
      function fetchDropdown(query = '') {
        $.ajax({
          url: 'pencarian.php',
          method: 'POST',
          data: {
            query: query
          },
          success: function(data) {
            $('#dropdown').html(data);
            $('#dropdown').show();
          }
        });
      }

      $('#searchInput').on('focus', function() {
        fetchDropdown();
      });

      $('#searchInput').on('input', function() {
        var query = $(this).val();
        fetchDropdown(query);
      });

      $(document).on('click', '#dropdown div', function() {
        var selectedText = $(this).text();
        var selectedId = $(this).data('id');
        $('#searchInput').val(selectedText);
        $('#selectedId').val(selectedId);
        $('#dropdown').hide();
      });

      $(document).on('click', function(event) {
        if (!$(event.target).closest('#searchInput, #dropdown').length) {
          $('#dropdown').hide();
        }
      });
    });
  </script>
  <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=658339141622648&ev=PageView&noscript=1" /></noscript>

  <!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">

</body>

</html>