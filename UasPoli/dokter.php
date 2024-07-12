<?php
    require 'functions.php';
    
    session_start();
    if (!isset ($_SESSION['username'])) {
        header('Location: login.php');
        exit;
    }

    // menampilkan data dokter
    $dtDktr = tampilDokter();

    // cek apakah tombol tambah dokter diklik
    if(isset($_POST['btn_dktr'])){
        if(addDokter($_POST) > 0) {
            echo "
                <script>
                    alert('Data Berhasil di Tambahkan')
                    document.location.href = 'dokter.php';
                </script>    
                ";
        } else {
            echo "
                <script>
                    alert('Data Gagal di Tambahkan!')
                    document.location.href = 'dokter.php';
                </script>    
            ";
        }
    }

    // pengecekan edit - hapus - logout menggunakan action
    if(isset($_GET['action']) || isset($_GET['id'])){
        $id = $_GET['id'];
        // aksi hapus
        if($_GET['action'] === 'delete'){
            hpsDktr($id);
        }

        // aksi edit 
        if($_GET['action'] === 'edit'){
            $id = $_GET['id'];
            // menampilkan data yg akan di update
            $edit = tampilEditDktr($id);
            // update data obat
        } else if(isset($_POST['btn_dktr_ubah'])){
            $id = $_POST['dokter_id'];
            if(editDktr($_POST)) {
                echo "
                    <script>
                        alert('Data Berhasil di Update')
                        document.location.href = 'dokter.php';
                    </script>    
                    ";
            } else {
                echo "
                    <script>
                        alert('Data Gagal di Update!')
                        document.location.href = 'dokter.php';
                    </script>    
                ";
            }
        };

        // logout
        if($_GET['action'] === 'logout') {
            logout();
        }
    }
    else{
        ?>
        <script>window.href.location ='dokter.php';</script>
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

    <nav class="navbar navbar-expand-lg  bg-dark">
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
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="http://localhost/kuliah/UasPoli/periksa.php">Periksa</a>
                    </li>
                </ul>
                <div class="d-flex gap-3" role="search">
                    <a href="dokter.php?action=logout" class="btn btn-danger">LogOut</a>
                </form>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <div class="container mt-3">
            <h3>DOKTER</h3><hr>
            <form action="dokter.php?action=null" method="POST">
                <?php if(!empty($_GET['action']) && $_GET['id']) {?>
                    <div class="mb-3">
                        <input type="hidden" name="dokter_id" value="<?= $edit['id_dktr'] ?>"/>
                        <label for="nm_dktr" class="form-label"><b>Nama Dokter</b></label>
                        <input type="text" class="form-control" id="nm_dktr" placeholder="masukan nama" name="nm_dktr" value="<?= $edit['nama_dokter'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="almt_dktr" class="form-label"><b>Alamat</b></label>
                        <input type="text" class="form-control" id="almt_dktr" placeholder="Alamat" name="almt_dktr" value="<?= $edit['alamat'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="no_dktr" class="form-label"><b>No Telp</b></label>
                        <input type="text" class="form-control" id="no_dktr" placeholder="No handphone" name="no_dktr" value="<?= $edit['no_hp']?>">
                    </div>
                    <button type="submit" name="btn_dktr_ubah" class="btn btn-primary">Simpan</button>
                <?php }else{?>
                    <div class="mb-3">
                        <label for="nm_dktr" class="form-label"><b>Nama Dokter</b></label>
                        <input type="text" class="form-control" id="nm_dktr" placeholder="masukan nama" name="nm_dktr">
                    </div>
                    <div class="mb-3">
                        <label for="almt_dktr" class="form-label"><b>Alamat</b></label>
                        <input type="text" class="form-control" id="almt_dktr" placeholder="Alamat" name="almt_dktr">
                    </div>
                    <div class="mb-3">
                        <label for="no_dktr" class="form-label"><b>No Telp</b></label>
                        <input type="text" class="form-control" id="no_dktr" placeholder="No handphone" name="no_dktr">
                    </div>
                    <button type="submit" name="btn_dktr" class="btn btn-primary">Simpan</button>
                <?php }?> 
            </form>
        </div>
        <hr>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Dokter</th>
                    <th>Alamat</th>
                    <th>No Telepon</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i = 1;
                    foreach($dtDktr as $dokter) {
                ?>
                <tr>
                    <th><?= $i++?></th>
                    <th><?= $dokter['nama_dokter']?></th>
                    <th><?= $dokter['alamat']?></th>
                    <th><?= $dokter['no_hp']?></th>
                    <th>
                        <a class="btn btn-success" href="dokter.php?id=<?= $dokter['id_dktr'];?>&action=edit">Ubah</a>
                        <a class="btn btn-danger" href="dokter.php?id=<?= $dokter['id_dktr'];?>&action=delete" onclick="return confirm('Apakah anda yakin?')">Hapus</a>
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