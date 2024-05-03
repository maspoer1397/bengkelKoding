<?php
    require 'functions.php';

    session_start();
    if (!isset ($_SESSION['username'])) {
        header('Location: index.php');
        exit;
    }


    $dtPsn = tampilPasien();

    if(isset($_POST['btn_psn'])){
        if(addPasien($_POST) > 0) {
            echo "
                <script>
                    alert('Data Berhasil di Tambahkan')
                    document.location.href = 'pasien.php';
                </script>    
                ";
        } else {
            echo "
                <script>
                    alert('Data Gagal di Tambahkan!')
                    document.location.href = 'pasien.php';
                </script>    
            ";
        }
    }

    if(isset($_GET['action']) || isset($_GET['id'])){
        $id = $_GET['id'];
        if($_GET['action'] === 'delete'){
            hpsPsn($id);
        }
    }else{
        ?>
        <script>window.href.location ='pasien.php';</script>
        <?php
    }

    // if(isset($_POST[])) {

    // }
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
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="http://localhost/kuliah/poliklinik/periksa.php">Periksa</a>
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
            <h3>PASIEN</h3>
            <form action="" method="POST">
                <?php if(!empty($_GET['action']) && $_GET['id']) {?>
                    <div class="mb-3">
                        <label for="nm_Psn" class="form-label"><b>Nama Pasien</b></label>
                        <input type="text" class="form-control" id="nm_Psn" placeholder="masukan nama" name="nm_Psn">
                    </div>
                    <div class="mb-3">
                        <label for="almt_Psn" class="form-label"><b>Alamat</b></label>
                        <input type="text" class="form-control" id="almt_Psn" placeholder="Alamat" name="almt_Psn">
                    </div>
                    <div class="mb-3">
                        <label for="no_Psn" class="form-label"><b>No Telp</b></label>
                        <input type="text" class="form-control" id="no_Psn" placeholder="nomor telpon" name="no_Psn">
                    </div>
                    <button type="submit" name="btn_psn_ubah" class="btn btn-primary">Simpan</button>
                <?php }else{?>
                    <div class="mb-3">
                        <label for="nm_Psn" class="form-label"><b>Nama Pasien</b></label>
                        <input type="text" class="form-control" id="nm_Psn" placeholder="masukan nama" name="nm_Psn">
                    </div>
                    <div class="mb-3">
                        <label for="almt_Psn" class="form-label"><b>Alamat</b></label>
                        <input type="text" class="form-control" id="almt_Psn" placeholder="Alamat" name="almt_Psn">
                    </div>
                    <div class="mb-3">
                        <label for="no_Psn" class="form-label"><b>No Telp</b></label>
                        <input type="text" class="form-control" id="no_Psn" placeholder="nomor telpon" name="no_Psn">
                    </div>
                    <button type="submit" name="btn_psn" class="btn btn-primary">Simpan</button>
                <?php }?> 
            </form>
        </div>
        <hr>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Alamat</th>
                    <th>No Telepon</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($dtPsn as $pasien) {
                    $i = 1;
                ?>
                <tr>
                    <th><?= $i++?></th>
                    <th><?= $pasien['nama_pasien']?></th>
                    <th><?= $pasien['alamat']?></th>
                    <th><?= $pasien['no_hp']?></th>
                    <th>
                        <a class="btn btn-success" href="pasien.php?action=edit&id=<?= $pasien['id'];?>">Ubah</a>
                        <a class="btn btn-danger" href="pasien.php?action=delete&id=<?= $pasien['id'];?>">Hapus</a>
                    </th>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>