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
    <link rel="stylesheet" href="./assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="./assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="./assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css">
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
if (!(isset($_GET['roleid'])))
    header("location: listdac.php");
else
    $roleid = $_GET['roleid'];
include('connectdb.php');
$mysqli = konek('localhost', 'root', '', '');

$mysqli->select_db('presensi_cloud');
$sql = "SELECT dac.id as id, dac.kode as kode, jur.nama as nama, dac.entity as entity, dac.field as field, dac.operator as operator, dac.value as value FROM dac_rules as dac inner join jurusans as jur on dac.jurusans_id=jur.id where dac.id = ? order by dac.kode ASC limit 1";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $roleid);
$stmt->execute();
$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {
    $kode = $row['kode'];
    $nama = $row['nama'];

    $entity = $row['entity'];
    if ($entity == 'jadwals')
        $entity = "Jadwal";
    elseif ($entity == 'kehadirans')
        $entity = "Kehadiran";
    elseif ($entity == 'mahasiswas')
        $entity = "Mahasiswa";
    elseif ($entity == 'matakuliahs')
        $entity = "Mata Kuliah";
    elseif ($entity == 'matakuliahs_buka')
        $entity = "Mata Kuliah yang Buka";
    else
        $entity = "Kelas Pararel Mata Kuliah";

    $field = $row['field'];

    $opt = $row['operator'];
    if ($opt == '=')
        $opt = "equal as";
    elseif ($opt == '!=')
        $opt = "not equal as";
    elseif ($opt == '<')
        $opt = "lower than";
    elseif ($opt == '>')
        $opt = "grater than";
    elseif ($opt == '<=')
        $opt = "lower than or equal as";
    else
        $opt = "grater than or equal as";
    $value = $row['value'];
}
?>

<body>
    <!-- Sidenav -->
    <?php
    if ($_SESSION['jabatan'] == 'admin') {
    ?>
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
                            <a class='nav-link' href='tambah_user.php' role='button' aria-expanded='true' aria-controls='navbar-dashboards'>
                            <i class='ni ni-single-02 text-primary'></i>
                            <span class='nav-link-text'>Tambah User</span>
                            </a>
                            </li>
                            <li class='nav-item'>
                            <a class='nav-link active' href='listdac.php' role='button' aria-expanded='true' aria-controls='navbar-dashboards'>
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
    <?php
    }
    ?>
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
                            <h6 class="h2 d-inline-block mb-0">Manage DAC Roles</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links">
                                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Manage Roles DAC Code: <?php echo $kode; ?></li>
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
                                    <div class="card-header border-0">
                                        <div class="row">
                                            <div class="col-6">
                                                <h3 class="mb-0">DAC Holders</h3>
                                            </div>
                                            <div class="col-6 text-right">
                                                <!-- Insert DAC -->
                                                <?php
                                                if ($_SESSION['jabatan'] == 'admin' || $_SESSION['jabatan'] == 'dekan' || $_SESSION['jabatan'] == 'wadek') {
                                                ?>
                                                    <a href="tambah_dac_holder.php?roleid=<?php echo $roleid ?>" class="btn btn-sm btn-neutral btn-round btn-icon" data-toggle="tooltip" data-original-title="Add DAC Role Holder">
                                                        <span class="btn-inner--icon"><i class="fas fa-user-edit"></i></span>
                                                        <span class="btn-inner--text">Tambah Holder</span>
                                                    </a>
                                                <?php
                                                }
                                                ?>
                                                <!-- Insert DAC -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive py-4">
                                        <table class="table table-flush" id="datatable-basic">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama</th>
                                                    <th>Jabatan</th>
                                                    <th>Fakultas</th>
                                                    <th>Jurusan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Isi List DAC -->
                                                <?php
                                                $mysqli->select_db('presensi_cloud');
                                                $sql = "SELECT *, dr.id as id from dac_roles as dr inner join users as u on dr.user_id=u.id where dr.dac_rule_id = ? ORDER BY u.nama ASC";
                                                $stmt = $mysqli->prepare($sql);
                                                $stmt->bind_param("i", $roleid);
                                                $stmt->execute();
                                                $res = $stmt->get_result();

                                                $count = 0;
                                                while ($row = $res->fetch_assoc()) {
                                                    $count++;
                                                    $dac_roles_id = $row['id'];
                                                ?>
                                                    <tr>
                                                        <td><?php echo $count; ?></td>
                                                        <td><?php echo $row['nama']; ?></td>
                                                        <td><?php echo $row['jabatan']; ?></td>
                                                        <td><?php echo $row['fakultass_id']; ?></td>
                                                        <td><?php echo $row['jurusans_id']; ?></td>
                                                        <!-- Edit Delete -->
                                                        <td class="table-actions">
                                                            <a href="dacroles_process.php?delid=<?php echo $dac_roles_id; ?>&roleid=<?php echo $roleid; ?>" class="table-action table-action-delete" name="delete-dac-<?php echo $id; ?>" data-toggle="tooltip" data-original-title="Delete DAC Holder">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </td>
                                                        <!-- Edit Delete -->
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <!-- Isi List DAC -->
                                            </tbody>
                                        </table>
                                    </div>
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
        <script src="./assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="./assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="./assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="./assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="./assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="./assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="./assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="./assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>
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
        </script>
</body>

</html>