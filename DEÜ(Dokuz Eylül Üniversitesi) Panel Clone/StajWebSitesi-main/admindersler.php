<?php
include("config.php");
ob_start();
session_start();


// Kullanıcı giriş yapılmamışsa login sayfasına yönlendir
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("Location: login.php");
  exit;
}

if ($_SESSION['tip'] == 'Akademik Personel' || $_SESSION['tip'] == 'Öğrenci') {
  header("Location: login.php");
  exit;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dersler</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <script src="https://kit.fontawesome.com/f2bf49d1b5.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="dist/css/adminpanel.css" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">


    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
              class="fa-solid fa-ellipsis-vertical"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:history.back()" role="button">
            <i class="fa-solid fa-backward"></i>
          </a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->
    <?php
    $tip = $_SESSION['tip'];
    $id = $_SESSION['ak_id'];
    if ($tip == 'Akademik Personel') {
      $sql = "SELECT * FROM akademik_per WHERE ak_id = $id";
      $result = $conn->query($sql);
      $sorgu = $result->fetch_all(MYSQLI_ASSOC);
    } else if ($tip == 'Öğrenci') {
      $sql = "SELECT * FROM ogrenci WHERE ak_id = $id";
      $result = $conn->query($sql);
      $sorgu = $result->fetch_all(MYSQLI_ASSOC);
    } else if ($tip == 'Admin') {
      $sql = "SELECT * FROM admin_table WHERE ak_id = $id";
      $result = $conn->query($sql);
      $sorgu = $result->fetch_all(MYSQLI_ASSOC);
    }



    foreach ($sorgu as $row) {

      echo '
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">';
      if ($tip == 'Akademik Personel') {
        echo '  <img src="dist/img/akademik.png" class="img-circle elevation-2" alt="User Image">';
      } else if ($tip == 'Öğrenci') {
        echo '  <img src="dist/img/ogrenci.png" class="img-circle elevation-2" alt="User Image">';
      } else if ($tip == 'Admin') {
        echo '<img src="dist/img/admin.jpg" class="img-circle elevation-2" alt="User Image">';
      }

      echo '
              </div>
              <div class="info">
                <a style="text-decoration: none;
                " href="#" >' . $row["ak_ad"] . '</a>
              </div>
            </div>';
    }
    ?>
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <?php
    $tip = $_SESSION['tip'];
    $id = $_SESSION['ak_id'];

    echo '   <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">DERS PROGRAM İŞLEMLERİ</li>
          <li class="nav-item">
            <a href="adminpanel.php" class="nav-link">
              <i class="fa-solid fa-house"></i>
              <p>
                Ana Sayfa
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="ogrencisayfa.php" class="nav-link">
            <i class="fa-solid fa-user"></i>
              <p>
                Öğrenci
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="admindonem.php" class="nav-link">
            <i class="fa-solid fa-school"></i>
              <p>
                Dönem Seç
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="admindersler.php" class="nav-link">
            <i class="fa-solid fa-book"></i>
              <p>
                Dersler
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="iletisim.php" class="nav-link">
              <i class="fa-solid fa-phone"></i>
              <p>
                İletişim
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="fa-solid fa-right-from-bracket"></i>
              <p>
                Çıkış Yap
              </p>
            </a>
          </li> 
        </ul>
      </nav>';


    ?>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <center>
      <a href="admindersolustur.php">
        <button type="button" class="btn btn-primary" style="margin-top:30px;">DERS OLUŞTUR</button>
      </a>
      <div class="container-main" style="padding-top: 20px; padding-bottom: 20px;">
        <?php
        include("config.php");
        $sql = "SELECT * FROM dersler ORDER BY ders_id ASC";
        $result = $conn->query($sql);
        ?>
        <table border="2" cellspacing="1" cellpadding="10">
          <tr>
            <th>ID</th>
            <th>DERS ADI</th>
            <th>Bölüm_ID</th>
            <th>Sınıf_ID</th>
            <th>Dönem_ID</th>
            <th>Değiştir</th>
            <th>Sil</th>
          </tr>
          <?php
          if ($result->num_rows > 0) {
            while ($data = $result->fetch_assoc()) {
              ?>
              <tr>
                <td>
                  <?php echo $data['ders_id']; ?>
                </td>
                <td>
                  <?php echo $data['ders_ad']; ?>
                </td>
                <td>
                  <?php echo $data['bolum_id']; ?>
                </td>
                <td>
                  <?php echo $data['sinif_id']; ?>
                </td>
                <td>
                  <?php echo $data['donem_id']; ?>
                </td>
                <td>
                  <?php
                  echo "<a href='admindersduzenle.php?
                                         ders_id=" . $data['ders_id'] .
                    "&ders_ad=" . $data['ders_ad'] .
                    "&bolum_id=" . $data['bolum_id'] .
                    "&sinif_id=" . $data['sinif_id'] .
                    "&donem_id=" . $data['donem_id'] .
                    "'><input class='btn btn-success' type='button'  value='Düzenle'></a>";
                  ?>
                </td>
                <td>
                  <?php
                  echo "<button class='btn btn-danger delete-button' onclick ='DersSil(" . $data['ders_id'] . ");'>Sil</button>";
                  ?>
                </td>
              <tr>
                <?php

            }
          } else { ?>
            <tr>
              <td colspan="6">No data</td>
            </tr>
          <?php } ?>
        </table>
      </div>
    </center>
  </div>
  </div>

  </div>
  </section>
  <!-- /.content -->


  </div>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>



  <script>
    function DersSil(ders_id) {
      fetch("adminderssil.php", {
        method: "POST",
        body: JSON.stringify({
          ders_id: ders_id,

        }),
      })
        .then((response) => response.text())
        .then((data) => {
          if (data === "success") {
            toastr.success("Program başarıyla silindi.");
            location.reload();
          } else {
            toastr.error("Program silinirken bir hata oluştu.");
          }
        })
        .catch((error) => {
          console.error("Bir hata oluştu:", error);
          toastr.error("Bir hata oluştu. Lütfen tekrar deneyin.");
        });
    }

  </script>

</body>

</html>