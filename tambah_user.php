<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>E-Presensi Cloud</title>
  <link rel="icon" href="./assets/img/brand/favicon.png" type="image/png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <link rel="stylesheet" href="./assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="./assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <link rel="stylesheet" href="./assets/css/argon.css?v=1.1.0" type="text/css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css" rel="stylesheet">
  </link>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<?php
session_start();
if (!isset($_SESSION['username']) && !isset($_SESSION['nama']) && !isset($_SESSION['jurusan'])) {
  header("location: login.php");
}
if ($_SESSION['jabatan'] != 'admin' && $_SESSION['nama'] != 'Admin') {
  $_SESSION['error'] = "Kamu tidak dapat mengakses page ini!";
  header("location: dashboard.php");
}
if (isset($_SESSION['success'])) {
  $status = $_SESSION['success'];
  echo '<script type="text/javascript">';
  echo "setTimeout(function () {swal('Success!', '" . $status . "', 'success');";
  echo '}, 1);</script>';
}
if (isset($_SESSION['error'])) {
  $status = $_SESSION['error'];
  echo '<script type="text/javascript">';
  echo "setTimeout(function () {swal('Failed!', '" . $status . "', 'error');";
  echo '}, 1);</script>';
}
include('connectdb.php');
$mysqli = konek('localhost', 'root', '');
?>

<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="dashboard.php">
          <img src="./assets/img/brand/blue.jpg" class="navbar-brand-img" alt="...">
        </a>
        <div class="ml-auto">
          <!-- Sidenav toggler -->
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="dashboard.php" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
                <i class="ni ni-shop text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <?php
            if ($_SESSION['jabatan'] == 'admin') {
              echo "
              <li class='nav-item'>
              <a class='nav-link' href='manage_jurusans.php' role='button' aria-expanded='true' aria-controls='navbar-dashboards'>
              <i class='ni ni-badge text-primary'></i>
              <span class='nav-link-text'>Tambah Jurusan</span>
              </a>
              </li>
              <li class='nav-item'>
              <a class='nav-link active' href='tambah_user.php' role='button' aria-expanded='true' aria-controls='navbar-dashboards'>
              <i class='ni ni-single-02 text-primary'></i>
              <span class='nav-link-text'>Tambah User</span>
              </a>
              </li>
              <li class='nav-item'>
              <a class='nav-link' href='listdac.php' role='button' aria-expanded='true' aria-controls='navbar-dashboards'>
              <i class='ni ni-bulb-61 text-primary'></i>
              <span class='nav-link-text'>Manage DAC Rules</span>
              </a>
              </li>
              <li class='nav-item'>
                    <a class='nav-link' href='mydacroles.php' role='button' aria-expanded='true' aria-controls='navbar-dashboards'>
                      <i class='ni ni-bulb-61 text-primary'></i>
                      <span class='nav-link-text'>My DAC Roles</span>
                    </a>
                  </li>
              ";
            }
            ?>
          </ul>
          <!-- Divider -->
          <hr class="my-3">
          <!-- Heading -->
          <!-- <h6 class="navbar-heading p-0 text-muted">Documentation</h6> -->
          <!-- Navigation -->
        </div>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-light bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Search form -->
          <form class="navbar-search navbar-search-dark form-inline mr-sm-3" id="navbar-search-main">
            <div class="form-group mb-0">
              <div class="input-group input-group-alternative input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control" placeholder="Search" type="text">
              </div>
            </div>
            <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
              <span aria-hidden="true">??</span>
            </button>
          </form>
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center ml-md-auto">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-light" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
          </ul>
          <ul class="navbar-nav align-items-center ml-auto ml-md-0">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle bg-transparent">
                    <i class="ni ni-circle-08 bg-transparent"></i>
                  </span>
                  <div class="media-body ml-2 d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold text-white"><?php echo $_SESSION['nama'] ?></span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome!</h6>
                </div>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-single-02"></i>
                  <span>My profile</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="logout.php" class="dropdown-item">
                  <i class="ni ni-user-run"></i>
                  <span>Logout</span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Header -->
    <!-- Header -->
    <div class="header pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 d-inline-block mb-0">Tambah User</h6>
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links">
                  <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah User</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-12">
          <div class="card bg-bg-white border-0">
            <!-- Card body -->
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <?php
                  if (isset($_SESSION['success'])) {
                  ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                      <span class="alert-text"><strong>Success!</strong> <?php echo $_SESSION['success']; ?></span>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  <?php
                    unset($_SESSION['success']);
                  } elseif (isset($_SESSION['error'])) {
                  ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                      <span class="alert-text"><strong>Error!</strong> <?php echo $_SESSION['error']; ?></span>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  <?php
                    unset($_SESSION['error']);
                  }
                  ?>
                  <form method="POST" enctype="multipart/form-data" action="tambah_user_process.php">
                    <!-- Input groups with icon -->
                    <div class="row" id="fieldss">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-control-label">NRP/ NPK</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                            </div>
                            <input required class="form-control" name="kode" placeholder="NRP/ NPK" type="text">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-control-label">Nama</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                            </div>
                            <input required class="form-control" name="nama" placeholder="nama" type="text">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-control-label">Username</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                            </div>
                            <input required class="form-control" name="username" placeholder="username" type="text">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-control-label">Password</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="ni ni-key-25"></i></span>
                            </div>
                            <input required class="form-control" name="password" placeholder="password" type="password">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-control-label">Repeat Password</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="ni ni-key-25"></i></span>
                            </div>
                            <input required class="form-control" name="r_password" placeholder="repeat password" type="password">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-control-label">Jabatan</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="ni ni-paper-diploma"></i></span>
                            </div>
                            <select class="form-control" name="jabatan" data-toggle="select">
                              <option value='dekan'>Dekan</option>
                              <option value='wadek'>Wakil Dekan</option>
                              <option value='kajur'>Kepala Jurusan</option>
                              <option value='dosen'>Dosen</option>
                              <option value='mhs'>Mahasiswa</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-control-label">Fakultas</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="ni ni-paper-diploma"></i></span>
                            </div>
                            <select class="form-control" id="fakultas" name="fakultas" data-toggle="select" onchange="changeJurusan(this.value)">
                              <option value='0'>Pilih Fakultas</option>
                              <?php
                              $sql = "SELECT * FROM fakultass order by nama ASC";
                              $stmt = $mysqli->prepare($sql);
                              $stmt->execute();
                              $res = $stmt->get_result();

                              while ($row = $res->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['nama'] . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-control-label">Jurusan</label>
                          <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="ni ni-paper-diploma"></i></span>
                            </div>
                            <select id="jurusanlist" class="form-control" name="jurusan" data-toggle="select">
                              <option value='0'>Pilih Jurusan</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="form-control-label" style='opacity:0%;'>Add</label>
                        <div class="input-group input-group-merge">
                          <div class="input-group-prepend">
                          </div>
                          <input class="btn btn-primary" type="submit" name="adduser" value="Tambah User" />
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </li>
      </ul>
    </div>
    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="./assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="./assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/vendor/js-cookie/js.cookie.js"></script>
    <script src="./assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
    <script src="./assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
    <!-- Optional JS -->
    <script src="./assets/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="./assets/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="./assets/vendor/jvectormap-next/jquery-jvectormap.min.js"></script>
    <script src="./assets/js/vendor/jvectormap/jquery-jvectormap-world-mill.js"></script>
    <!-- Argon JS -->
    <script src="./assets/js/argon.js?v=1.1.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <!-- Demo JS - remove this in your project -->
    <script src="./assets/js/demo.min.js"></script>
    <script type="text/javascript">
      function swalgood(msg1, msg2) {
        Swal.fire(
          msg1,
          msg2,
          'success'
        );
      }

      // function toogleJurusan(jabatan) {
      //   var jabatan = jabatan;
      //   if (jabatan == 'dekan' || jabatan == 'wadek') {
      //     $('#jurusanlist').prop('disabled', true);
      //   } else {
      //     $('#jurusanlist').prop('disabled', false);
      //   }
      // }

      function changeJurusan(idFakultas) {
        var idFakultas = idFakultas;
        $.ajax({
          type: "POST",
          url: "loadjurusanperfakultas.php",
          data: {
            idFakultas: idFakultas
          },
          success: function(data) {
            var obj = JSON.parse(data);
            $("#jurusanlist").html("");
            if (obj['status']) {
              var dataa = obj['data'];
              $("#jurusanlist").append("<option value='0'>Pilih Jurusan</option>");
              for (var i = 0; i < dataa.length; i++) {
                $("#jurusanlist").append("<option value='" + dataa[i]['id'] + "'>" + dataa[i]['nama'] + "</option>");
              }
            }
          }
        });
      }
    </script>
</body>

</html>