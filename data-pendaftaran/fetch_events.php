<?php
include '../koneksi.php';

$data = array();

$query = $koneksi->query("SELECT a.tgl_pendaftaran, b.nm_pasien, c.nm_dokter, a.status FROM tb_pendaftaran a
                            JOIN tb_pasien b ON a.id_pasien = b.id_pasien
                            JOIN tb_dokter c ON a.id_dokter = c.id_dokter");

while ($row = $query->fetch_assoc()) {
    // Tentukan warna berdasarkan status
    if ($row['status'] == 0) {
        $color = '#007bff'; // Biru untuk "Belum Diperiksa"
    } elseif ($row['status'] == 1) {
        $color = '#28a745'; // Hijau untuk "Sudah Diperiksa"
    } else {
        $color = '#dc3545'; // Merah untuk "Dibatalkan"
    }

    $data[] = array(
        'title' => $row['nm_pasien'] . ' - ' . $row['nm_dokter'], // Nama pasien dan dokter
        'start' => $row['tgl_pendaftaran'], // Tanggal temu
        'color' => $color, // Warna berdasarkan status
    );
}

echo json_encode($data);
?>
