<?php
  session_start();
  if (isset($_SESSION['username']) && isset($_SESSION['nama']) && isset($_SESSION['jabatan'])) {
    header("location: dashboard.php");
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="./assets/img/brand/favicon.png" type="image/png">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <title>
    Login 
  </title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <link href="./assets/css/font-awesome.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="./assets/css/argon-design-system.css?v=1.2.2" rel="stylesheet" />
  <style>
      body{
          height:100%;
      }
  </style>
</head>

<body class="login-page">
  <!-- Navbar -->
  <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light py-2">
    <div class="container">
        <span class="nav-link-inner--text" style="color:white;">E-Presensi Cloud</span>
    </div>
  </nav>
  <!-- End Navbar -->
  <section class="section section-shaped section-lg">
    <div class="shape shape-style-1 bg-gradient-primary py-7 py-lg-8 pt-lg-9">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
    <div class="container pt-lg-7" style="margin-bottom:2.4%;">
      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="card bg-secondary shadow border-0">
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <h5>Login ke E-Presensi</h5>
              </div>
              <form method="POST" enctype="multipart/form-data" action="login_process.php">
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                    </div>
                    <input required class="form-control" placeholder="username" name="uid" type="text">
                  </div>
                </div>
                <div class="form-group focused">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input required class="form-control" placeholder="password" name="password" type="password">
                  </div>
                </div>
                <p class='text-danger'>
                <?php
                  if (isset($_SESSION['err'])) {
                    echo $_SESSION['err'];
                    unset($_SESSION['err']);
                  }
                ?>
                </p>
                <div class="text-center">
                  <input id="signin" type="submit" class="btn btn-primary my-4" name="btnsignin" value="Masuk"></input>
                </div>
              </form>
            </div>
          </div>
          <div class="row mt-3">
            <!-- <div class="col-6">
                <a href="register.php" class="text-light"><small>Buat akun baru</small></a>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--   Core JS Files   -->
  <script src="./assets/js/core/jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
  <script src="./assets/js/core/bootstrap.min.js" type="text/javascript"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
  <script src="./assets/js/plugins/bootstrap-switch.js"></script>
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="./assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
  <script src="./assets/js/plugins/moment.min.js"></script>
  <script src="./assets/js/plugins/datetimepicker.js" type="text/javascript"></script>
  <script src="./assets/js/plugins/bootstrap-datepicker.min.js"></script>
  <!-- Control Center for Argon UI Kit: parallax effects, scripts for the example pages etc -->
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <script src="./assets/js/argon-design-system.min.js?v=1.2.2" type="text/javascript"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-design-system-pro"
      });
  </script>
</body>
</html>