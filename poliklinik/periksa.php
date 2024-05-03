<?php
    require 'functions.php';

    session_start();
    if (!isset ($_SESSION['username'])) {
        header('Location: index.php');
        exit;
    }

    $dtPsn = tampilPasien();
    $dtDktr = tampilDokter();
    $dtPrks = tampilPeriksa();

    if(isset($_POST['btn_periksa'])){
        if(addPeriksa($_POST) > 0) {
            echo "
                <script>
                    alert('Data Berhasil di Tambahkan')
                    document.location.href = 'periksa.php';
                </script>    
                ";
        } else {
            echo "
                <script>
                    alert('Data Gagal di Tambahkan!')
                    document.location.href = 'periksa.php';
                </script>    
            ";
        }
    }

    if(isset($_GET['action']) && $_GET['id']){
        $id = $_GET['id'];
        if($_GET['action'] === 'delete'){
            hpsPrks($id);
        }
    }else{
        ?>
        <script>window.href.location ='periksa.php';</script>
        <?php
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Poliklinik</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-dark">
        <div class="container mt-3 mb-2">
            <a class="navbar-brand text-white" href="http://localhost/kuliah/poliklinik/index.php">POLIKLINIK</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="http://localhost/kuliah/poliklinik/index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Data Master
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="http://localhost/kuliah/poliklinik/pasien.php">Data Pasien</a></li>
                        <li><a class="dropdown-item" href="http://localhost/kuliah/poliklinik/dokter.php">Data Dokter</a></li>
                    </ul>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="http://localhost/kuliah/poliklinik/periksa.php">Periksa</a>
                    </li>
                </li>
            </ul>
            <div class="d-flex gap-3" role="search">
                <a href="#" class="btn btn-danger">LogOut</a>
            </form>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <div class="container mt-3">
            <h3>PERIKSA</h3>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="nm_psn" class="form-label"><b>Nama Pasien</b></label>
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="nm_psn">
                        <option selected>Pilih Nama Pasien</option>
                        <?php foreach($dtPsn as $pasien) {?>
                            <option value="<?= $pasien['nama_pasien']?>"><?= $pasien['nama_pasien']?></option>
                        <?php }?>
                    </select>   
                </div>
                <div class="mb-3">
                    <label for="nm_dktr" class="form-label"><b>Nama Dokter</b></label>
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="nm_dktr">
                        <option selected>Pilih Nama Dokter</option>
                        <?php foreach($dtDktr as $dokter) {?>
                            <option value="<?= $dokter['nama_dokter']?>"><?= $dokter['nama_dokter']?></option>
                        <?php }?>
                    </select>  
                </div>
                <div class="mb-3">
                    <label for="tgl_periksa" class="form-label"><b>Tanggal Periksa</b></label>
                    <input type="date" class="form-control" id="tgl_periksa" placeholder="masukan nama" name="tgl_periksa">
                </div>
                <div class="mb-3">
                    <label for="catatan" class="form-label"><b>Catatan</b></label>
                    <input type="text" class="form-control" id="catatan" placeholder="masukan nama" name="catatan">
                </div>
                <div class="mb-3">
                    <label for="obat" class="form-label"><b>Obat</b></label>
                    <input type="text" class="form-control" id="obat" placeholder="masukan nama" name="obat">
                </div>
                <button type="submit" name="btn_periksa" class="btn btn-primary">Simpan</button>
            </form>
        </div>
        <hr>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Dokter</th>
                    <th>Nama Pasien</th>
                    <th>Tanggal</th>
                    <th>Catatan</th>
                    <th>Obat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($dtPrks as $periksa) {
                    $i = 1;
                ?>
                <tr>
                    <th><?= $i++;?></th>
                    <th><?= $periksa['nm_pasien']?></th>
                    <th><?= $periksa['nm_dokter']?></th>
                    <th><?= $periksa['tgl']?></th>
                    <th><?= $periksa['catatan']?></th>
                    <th><?= $periksa['obat']?></th>
                    <th>
                        <a class="btn btn-success" href="">Ubah</a>
                        <a class="btn btn-danger" href="periksa.php?id=<?= $periksa['id'];?>&action=delete">Hapus</a>
                    </th>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>