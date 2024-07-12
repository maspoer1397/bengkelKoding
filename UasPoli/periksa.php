<?php
require 'functions.php';

session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Memuat data pasien, dokter, periksa, dan obat
$dtPsn = tampilPasien();
$dtDktr = tampilDokter();
$dtPrks = tampilPeriksa();
$dtObat = tampilObat();

// Aksi untuk tambah data periksa
if (isset($_POST['btn_periksa'])) {
    if (addPeriksa($_POST) > 0) {
        echo "<script>alert('Data Berhasil ditambahkan'); window.location.href = 'periksa.php'; </script>";
        exit;
    } else {
        echo "<script>alert('Data Gagal ditambahkan'); window.location.href = 'periksa.php'; </script>";
        exit;
    }
}

// Penanganan aksi edit, delete, dan logout
if (isset($_GET['action'])) {
    $id = $_GET['id'];

    if ($_GET['action'] === 'delete') {
        hpsPrks($id);
        echo "<script>alert('Data Berhasil dihapus'); window.location.href = 'periksa.php'; </script>";
        exit;
    } elseif ($_GET['action'] === 'edit') {
        $periksa = tampilEditPeriksa($id);
        // Jika data periksa ditemukan, lanjutkan proses edit
        if ($periksa) {
            // Lanjutkan dengan menampilkan form edit
        } else {
            // Redirect atau tampilkan pesan jika data tidak ditemukan
            echo "<script>alert('Data Periksa tidak ditemukan'); window.location.href = 'periksa.php'; </script>";
            exit;
        }
    } elseif ($_GET['action'] === 'logout') {
        logout();
        header('Location: login.php');
        exit;
    }
}

// Proses update data periksa setelah edit
if (isset($_POST['btn_update_periksa'])) {
    $updateData = [
        'id' => $_POST['id_periksa'],
        'id_psn' => $_POST['id_psn'],
        'id_dktr' => $_POST['id_dktr'],
        'tgl' => $_POST['tgl_periksa'],
        'catatan' => $_POST['catatan'],
        'obat' => $_POST['obat']
    ];
    
    if (editPeriksa($updateData) > 0) {
        echo "<script>alert('Data Berhasil diubah'); window.location.href = 'periksa.php'; </script>";
        exit;
    } else {
        echo "<script>alert('Data Gagal diubah'); window.location.href = 'edit_periksa.php?id=" . $updateData['id'] . "'; </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Poliklinik</title>
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

    <div class="container mt-3">
        <h3>PERIKSA</h3>
        <hr>

        <!-- Form untuk tambah data periksa -->
        <form action="periksa.php?action=null" method="POST">
            <?php if (isset($_GET['action']) && $_GET['id']) : ?>
                <input type="hidden" name="id_periksa" value="<?= $periksa['id'] ?>">
                <div class="mb-3">
                    <label for="nm_psn" class="form-label"><b>Nama Pasien</b></label>
                    <select class="form-select" id="nm_psn" name="id_psn">
                        <?php foreach ($dtPsn as $pasien) : ?>
                            <option value="<?= $pasien['id_psn'] ?>" <?= ($pasien['id_psn'] == $periksa['id_psn']) ? 'selected' : '' ?>>
                                <?= $pasien['nama_pasien'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nm_dktr" class="form-label"><b>Nama Dokter</b></label>
                    <select class="form-select" id="nm_dktr" name="id_dktr">
                        <?php foreach ($dtDktr as $dokter) : ?>
                            <option value="<?= $dokter['id_dktr'] ?>" <?= ($dokter['id_dktr'] == $periksa['id_dktr']) ? 'selected' : '' ?>>
                                <?= $dokter['nama_dokter'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tgl_periksa" class="form-label"><b>Tanggal Periksa</b></label>
                    <input type="datetime-local" class="form-control" id="tgl_periksa" name="tgl_periksa" value="<?= date('Y-m-d\TH:i', strtotime($periksa['tgl'])) ?>">
                </div>
                <div class="mb-3">
                    <label for="catatan" class="form-label"><b>Catatan</b></label>
                    <input type="text" class="form-control" id="catatan" name="catatan" value="<?= $periksa['catatan'] ?>">
                </div>
                <div class="mb-3">
                    <label for="obat" class="form-label"><b>Obat</b></label><br>
                    <?php foreach ($dtObat as $obat) : ?>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" id="obat<?= $obat['id_obat'] ?>" name="obat[]" value="<?= $obat['nm_obat'] ?>" <?= (in_array($obat['nm_obat'], explode(',', $periksa['obat']))) ? 'checked' : '' ?>>
                            <label class="form-check-label btn btn-outline-primary" for="obat<?= $obat['id_obat'] ?>"><?= $obat['nm_obat'] ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" name="btn_update_periksa" class="btn btn-primary">Update</button>
            <?php else : ?>
                <!-- Form untuk tambah data periksa -->
                <div class="mb-3">
                    <label for="nm_psn" class="form-label"><b>Nama Pasien</b></label>
                    <select class="form-select" id="nm_psn" name="id_psn">
                        <?php foreach ($dtPsn as $pasien) : ?>
                            <option value="<?= $pasien['id_psn'] ?>"><?= $pasien['nama_pasien'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nm_dktr" class="form-label"><b>Nama Dokter</b></label>
                    <select class="form-select" id="nm_dktr" name="id_dktr">
                        <?php foreach ($dtDktr as $dokter) : ?>
                            <option value="<?= $dokter['id_dktr'] ?>"><?= $dokter['nama_dokter'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tgl_periksa" class="form-label"><b>Tanggal Periksa</b></label>
                    <input type="datetime-local" class="form-control" id="tgl_periksa" name="tgl_periksa" value="<?= date('Y-m-d\TH:i') ?>">
                </div>
                <div class="mb-3">
                    <label for="catatan" class="form-label"><b>Catatan</b></label>
                    <input type="text" class="form-control" id="catatan" name="catatan">
                </div>
                <div class="mb-3">
                    <label for="obat" class="form-label"><b>Obat</b></label><br>
                    <?php foreach ($dtObat as $obat) : ?>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" id="obat<?= $obat['id_obat'] ?>" name="obat[]" value="<?= $obat['nm_obat'] ?>">
                            <label class="form-check-label btn btn-outline-primary" for="obat<?= $obat['id_obat'] ?>"><?= $obat['nm_obat'] ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" name="btn_periksa" class="btn btn-primary">Tambah</button>
            <?php endif; ?>
        </form>

        <hr>

        <!-- Tabel untuk menampilkan data periksa -->
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Nama Dokter</th>
                    <th>Tanggal</th>
                    <th>Catatan</th>
                    <th>Obat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i = 1;
                    foreach($dtPrks as $periksa) 
                : ?>
                    <tr>
                        <td><?= $i?></td>
                        <td><?= $periksa['nama_pasien'] ?></td>
                        <td><?= $periksa['nama_dokter'] ?></td>
                        <td><?= $periksa['tgl'] ?></td>
                        <td><?= $periksa['catatan'] ?></td>
                        <td><?= $periksa['obat'] ?></td>
                        <td>
                            <a class="btn btn-success" href="periksa.php?action=edit&id=<?= $periksa['id'] ?>">Ubah</a>
                            <a class="btn btn-danger" href="periksa.php?action=delete&id=<?= $periksa['id'] ?>" onclick="return confirm('Apakah anda yakin?')">Hapus</a>
                            <a class="btn btn-warning" href="nota.php?id=<?= $periksa['id'] ?>">Nota</a>
                        </td>
                    </tr>
                <?php $i++; endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
