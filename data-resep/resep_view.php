<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION["jabatan"])) {
    echo "<script>location='../login/index.php'</script>";
    exit();
}

$ambil = $koneksi->query("SELECT * FROM tb_resep a 
            JOIN tb_pemeriksaan b ON a.id_pemeriksaan = b.id_pemeriksaan
            JOIN tb_pendaftaran c ON b.id_pendaftaran = c.id_pendaftaran
            JOIN tb_pasien d ON c.id_pasien = d.id_pasien
            JOIN tb_dokter e ON c.id_dokter = e.id_dokter WHERE id_resep='$_GET[id_resep]'");
$pecah = $ambil->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Klinik Kecantikan | Resep Obat</title>
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <script src="../assets/js/all.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <a class="navbar-brand font-weight-bold text-center" href="../index.php">Klinik Kecantikan</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                <div class="input-group-append">
                    <button class="btn btn-light" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="../login/logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Klinik Kecantikan</div>
                        <?php if ($_SESSION["jabatan"] == 'admin') : ?>
                            <a class="nav-link active" href="../data-resep/resep.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-scroll"></i></div>
                                Resep Obat
                            </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pembayaran') : ?>
                            <a class="nav-link" href="../data-pembayaran/pembayaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart"></i></div>
                                Kasir Pembayaran
                            </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pendaftaran') : ?>
                            <a class="nav-link" href="../data-pendaftaran/pendaftaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Data Pendaftaran
                            </a>
                        <?php elseif ($_SESSION["jabatan"] == 'pemeriksaan') : ?>
                            <a class="nav-link" href="../data-pemeriksaan/pemeriksaan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                                Data Pemeriksaan
                            </a>
                            <a class="nav-link" href="../data-resep/resep.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-scroll"></i></div>
                                Resep Obat
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content" class="bg-white text-dark">
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Informasi Obat</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../index.php" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Resep Obat</li>
                        <li class="breadcrumb-item active">Informasi Obat</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header mt-1">
                            <div class="row">
                                <div class="col-md-9 font-weight-bold">
                                    Data Resep Obat : <?php echo $pecah['kd_resep']; ?>
                                </div>
                                <div class="col-md-3 font-weight-bold">
                                    <label class="ml-5">Status : </label>
                                    <?php if ($pecah['status_rsp'] == 0) { ?>
                                        <span class="badge badge-danger p-2">Belum Bayar</span>
                                    <?php } elseif ($pecah['status_rsp'] == 1) { ?>
                                        <span class="badge badge-success p-2">Sudah Bayar</span>
                                    <?php } else { ?>
                                        <span class="badge badge-danger p-2">
                                            <i class="fas fa-minus"></i>
                                        </span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="">
                                <form class="mx-4" method="post" class="rsp" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>Kode Resep</label>
                                            <input type="text" class="form-control" name="kd_resep" value="<?php echo $pecah['kd_resep']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-1">
                                            <label>ID</label>
                                            <input type="text" class="form-control" name="id_pendaftaran" id="id_pendaftaran" value="<?php echo $pecah['id_pendaftaran']; ?>" readonly>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Pasien</label>
                                            <input type="text" class="form-control" name="nm_pasien" id="nm_pasien" value="<?php echo $pecah['nm_pasien']; ?>" readonly>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Nama Dokter</label>
                                            <input type="text" class="form-control" name="nm_dokter" id="nm_dokter" value="<?php echo $pecah['nm_dokter']; ?>" readonly>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Tarif Dokter</label>
                                            <input type="text" class="form-control" name="tarif_dokter" id="tarif_dokter" value="<?php echo "Rp. " . number_format($pecah['tarif_dokter']); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label>Poli</label>
                                            <input type="text" class="form-control" name="nm_poli" id="nm_poli" value="<?php echo $pecah['tarif_dokter']; ?>" readonly>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Tanggal Daftar</label>
                                            <input type="date" class="form-control" name="tgl_pendaftaran" id="tgl_pendaftaran" value="<?php echo $pecah['tgl_pendaftaran']; ?>" readonly>
                                        </div>
                                        <div class="col-sm-4">
                                            <label>Tanggal Periksa</label>
                                            <input type="date" class="form-control" name="tgl_pemeriksaan" id="tgl_pemeriksaan" value="<?php echo $pecah['tgl_pemeriksaan']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <label>Keluhan</label>
                                            <textarea class="form-control" name="keluhan" id="keluhan" rows="3" readonly><?php echo $pecah['keluhan']; ?></textarea>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Diagnosa</label>
                                            <textarea class="form-control" name="diagnosa" id="diagnosa" rows="3" readonly><?php echo $pecah['diagnosa']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-5">
                                            <label>Obat</label>
                                            <input type="text" class="form-control" name="nama_obt" id="nama_obt" value="<?php echo $pecah['nama_obt']; ?>" readonly>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Harga</label>
                                            <input type="text" class="form-control" name="harga_obt" id="harga_obt" value="<?php echo "Rp. " . number_format($pecah['harga_obt']); ?>" readonly>
                                        </div>
                                        <div class="col-sm-1">
                                            <label>Jumlah</label>
                                            <input type="text" class="form-control" name="jumlah_obt" id="jumlah_obt" value="<?php echo $pecah['jumlah_obt']; ?>" readonly>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Sub Harga Obat</label>
                                            <input type="text" class="form-control" name="subharga_obt" id="subharga_obt" value="<?php echo "Rp. " . number_format($pecah['subharga_obt']); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>Total Bayar</label>
                                            <input type="text" class="form-control" name="total" id="total" value="<?php echo "Rp. " . number_format($pecah['total']); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label>Keterangan</label>
                                            <textarea class="form-control" name="keterangan" rows="4" readonly><?php echo $pecah['keterangan']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <input type="hidden" class="form-control" name="tgl_resep" value="<?php echo date("Y-m-d"); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <a href="resep.php" class="btn btn-danger font-weight-bold px-3 mr-2"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-dark mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted font-weight-bold"> Copyright &copy; <span id="currentYear"></span> Klinik Kecantikan</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
		// Script untuk menampilkan tahun saat ini secara otomatis
		document.getElementById("currentYear").textContent = new Date().getFullYear();
	</script>
    <script src="../assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <script src="../assets/js/Chart.min.js"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/demo/datatables-demo.js"></script>

</body>

</html>