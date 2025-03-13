<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='login/index.php'</script>";
    exit();
}
// Ambil nama user dari session
$namaUser = $_SESSION['nama'];  // Pastikan 'nama' sudah diatur saat login
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Klinik Venice | Dashboard</title>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="assets/js/all.min.js"></script>
    <style>
        body {
            background-color: #f8f9fc;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 20px;
        }
        .card i {
            font-size: 3rem;
            margin-right: 10px;
        }
        .card:hover {
            transform: scale(1.02);
            transition: all 0.3s ease-in-out;
        }
        .bg-primary, .bg-success, .bg-info, .bg-warning {
            color: white;
        }
        .breadcrumb {
            background-color: transparent;
            padding: 0;
        }
        .breadcrumb-item.active {
            font-weight: bold;
        }
        .footer {
            background-color: #f8f9fc;
        }
        .footer .text-muted {
            font-size: 0.9rem;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand font-weight-bold" href="index.php">Klinik Venice</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="login/logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Klinik Venice</div>
                        <a class="nav-link active" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <?php if ($_SESSION["jabatan"] == 'admin') : ?>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#data-master" aria-expanded="false" aria-controls="data-master">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Data Master
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="data-master" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="data-master/data-pasien/pasien.php">Data Pasien</a>
                                <a class="nav-link" href="data-master/data-dokter/dokter.php">Data Dokter</a>
                                <a class="nav-link" href="data-master/data-obat/obat.php">Data Obat</a>
                                <a class="nav-link" href="data-master/data-poli/poli.php">Data Poli</a>
                            </nav>
                        </div>
                        <a class="nav-link" href="data-pendaftaran/pendaftaran.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                            Data Pendaftaran
                        </a>
                        <a class="nav-link" href="data-pemeriksaan/pemeriksaan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                            Data Pemeriksaan
                        </a>
                        <a class="nav-link" href="data-resep/resep.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-scroll"></i></div>
                            Resep Obat
                        </a>
                        <a class="nav-link" href="data-pembayaran/pembayaran.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Kasir Pembayaran
                        </a>
                        <div class="sb-sidenav-menu-heading">Admin</div>
                        <a class="nav-link" href="user.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Data User
                        </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pendaftaran') : ?>
                        <a class="nav-link" href="data-master/data-pasien/pasien.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>
                            Data Pasien
                        </a>
                        <a class="nav-link" href="data-pendaftaran/pendaftaran.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                            Data Pendaftaran
                        </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pemeriksaan') : ?>
                        <a class="nav-link" href="data-pemeriksaan/pemeriksaan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                            Data Pemeriksaan
                        </a>
                        <a class="nav-link" href="data-resep/resep.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-scroll"></i></div>
                            Resep Obat
                        </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pembayaran') : ?>
                        <a class="nav-link" href="data-pembayaran/pembayaran.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                            Kasir Pembayaran
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>

                    <div class="row">
                        <!-- Data Pasien -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary bg-primary">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Data Pasien</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php $ambil = mysqli_query($koneksi, "SELECT * FROM tb_pasien"); ?>
                                                <?php $count = mysqli_num_rows($ambil); ?>
                                                <?php echo $count; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-alt fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Obat -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success bg-success">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Data Obat</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php $ambil = mysqli_query($koneksi, "SELECT * FROM tb_obat"); ?>
                                                <?php $count = mysqli_num_rows($ambil); ?>
                                                <?php echo $count; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-capsules fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pendaftaran -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info bg-info">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Pendaftaran</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php $ambil = mysqli_query($koneksi, "SELECT * FROM tb_pendaftaran WHERE status = '0'"); ?>
                                                <?php $count = mysqli_num_rows($ambil); ?>
                                                <?php echo $count; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pembayaran -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning bg-warning">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Pembayaran</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php $ambil = mysqli_query($koneksi, "SELECT * FROM tb_resep WHERE status_rsp = '0'"); ?>
                                                <?php $count = mysqli_num_rows($ambil); ?>
                                                <?php echo $count; ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-shopping-cart fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="alert alert-success" role="alert">
                        Selamat datang, <strong><?php echo $namaUser; ?></strong>! Semoga harimu menyenangkan.
                    </div>
            </main>
            <footer class="footer py-4 mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                    Copyright &copy; <span id="currentYear"></span> Klinik Venice
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
		// Script untuk menampilkan tahun saat ini secara otomatis
		document.getElementById("currentYear").textContent = new Date().getFullYear();
	</script>

    <script src="assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>
