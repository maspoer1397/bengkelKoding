<?php
    require 'functions.php';

    session_start();
    if (!isset ($_SESSION['username'])) {
        header('Location: login.php');
        exit;
    }

    if (!isset($_GET['id'])) {
        header('Location: periksa.php');
        exit;
    }

    $id_periksa = $_GET['id'];
    $data_periksa = tampilEditPeriksa($id_periksa);

    if (!$data_periksa) {
        header('Location: periksa.php');
        exit;
    }

    if (!empty($data_periksa['id_psn']) && !empty($data_periksa['id_dktr'])) {
        $pasien = tampilPasienById($data_periksa['id_psn']);
        $dokter = tampilDokterById($data_periksa['id_dktr']);
    
        $nama_pasien = $pasien['nama_pasien'];
        $alamat_pasien = $pasien['alamat'];
        $no_telp_pasien = $pasien['no_hp'];
    
        $nama_dokter = $dokter['nama_dokter'];
        $alamat_dokter = $dokter['alamat'];
        $no_telp_dokter = $dokter['no_hp'];
    }

    $tgl_periksa = $data_periksa['tgl'];
    $catatan = $data_periksa['catatan'];
    $obat = $data_periksa['obat'];
    
    // var_dump($obat);


    $obat_id_string = $data_periksa['obat']; // String berisi id obat dipisahkan koma (misalnya "1,2,3")
    $obat_id_array = explode(',', $obat_id_string); // Pisahkan string menjadi array berdasarkan koma

    // Hitung total harga periksa berdasarkan jasa dokter dan obat
    $harga_jasa_dokter = 150000; // Misalnya harga jasa dokter adalah Rp 150.000
    $total_harga = $harga_jasa_dokter + $total_harga_obat;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Nota Pembayaran</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container mt-3 mb-2">
            <a class="navbar-brand text-white" href="http://localhost/kuliah/UasPoli/index.php">POLIKLINIK</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="http://localhost/kuliah/UasPoli/index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Data Master
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="http://localhost/kuliah/UasPoli/pasien.php">Data Pasien</a></li>
                        <li><a class="dropdown-item" href="http://localhost/kuliah/UasPoli/dokter.php">Data Dokter</a></li>
                        <li><a class="dropdown-item" href="http://localhost/kuliah/UasPoli/obat.php">Data Obat</a></li>
                    </ul>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="http://localhost/kuliah/UasPoli/periksa.php">Periksa</a>
                    </li>
                </li>
            </ul>
            <div class="d-flex gap-3" role="search">
                <a href="periksa.php?action=logout" class="btn btn-danger">LogOut</a>
            </form>
            </div>
        </div>
    </nav>
    
    <div class="container ps-5 pe-5">
        <div class="container mt-3 p-5">
            <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
                <h3>Invoice</h3>
                <hr class="border border-black border-3 opacity-75">
                <div class="d-flex justify-content-between">
                    <div class="p-2">
                        <table>
                            <tr>
                                <th>No. Periksa</th>
                            </tr>
                            <tr>
                                <td><?= $data_periksa['id'] ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="p-2">
                        <table>
                            <tr>
                                <th>Tanggal Periksa</th>
                            </tr>
                            <tr>
                                <td><?= date('d-m-Y H:i', strtotime($tgl_periksa)) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <div class="p-2">
                        <table>
                            <tr>
                                <th>Pasien</th>
                            </tr>
                            <tr>
                                <td><?= $nama_pasien ?></td>
                            </tr>
                            <tr>
                                <td><?= $alamat_pasien ?></td>
                            </tr>
                            <tr>
                                <td><?= $no_telp_pasien ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="p-2">
                        <table>
                            <tr>
                                <th>Dokter</th>
                            </tr>
                            <tr>
                                <td><?= $nama_dokter ?></td>
                            </tr>
                            <tr>
                                <td><?= $alamat_dokter ?></td>
                            </tr>
                            <tr>
                                <td><?= $no_telp_dokter ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <div class="p-2">
                        <table>
                            <tr>
                                <th>Deskripsi</th>
                            </tr>
                            <tr>
                                <td><?= $catatan ?></td>
                            </tr>
                            <tr>
                                <td><?= $obat ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="p-2">
                        <table>
                            <tr>
                                <th>Harga</th>
                            </tr>
                            <tr>
                                <td>Jasa Dokter - Rp <?= number_format($harga_jasa_dokter, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Sub Obat - Rp <?= number_format(count(explode(',', $obat)) * $harga_obat, 0, ',', '.') ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <p>Total - Rp <?= number_format($total_harga, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
