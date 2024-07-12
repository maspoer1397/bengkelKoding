<?php
    require 'functions.php';

    session_start();
    if (!isset ($_SESSION['username'])) {
        header('Location: login.php');
        exit;
    }

    // menampilkan data obat
    $dtObat = tampilObat();

    // cek apakah tombol tambah obat di klik
    if(isset($_POST['btn_obat'])){
        if(addObat($_POST) > 0) {
            echo "
                <script>
                    alert('Data Berhasil di Tambahkan')
                    document.location.href = 'obat.php';
                </script>    
                ";
        } else {
            echo "
                <script>
                    alert('Data Gagal di Tambahkan!')
                    document.location.href = 'obat.php';
                </script>    
            ";
        }
    }

    // pengecekan edit - hapus - logout mengguunakan action
    if(isset($_GET['action'])){
        $id = $_GET['id'];
        // aksi hapus
        if($_GET['action'] === 'delete'){
            hpsObat($id);
        }

        // aksi edit 
        if($_GET['action'] === 'edit'){
            $id = $_GET['id'];
            // menampilkan data yg akan di update
            $edit = tampilEditObat($id);
            // update data obat
        } else if(isset($_POST['btn_obat_ubah'])){
            $id = $_POST['obat_id'];
            if(editObat($_POST)) {
                echo "
                    <script>
                        alert('Data Berhasil di Update')
                        document.location.href = 'obat.php';
                    </script>    
                    ";
            } else {
                echo "
                    <script>
                        alert('Data Gagal di Update!')
                        document.location.href = 'obat.php';
                    </script>    
                ";
            }
        };
        if($_GET['action'] === 'logout') {
            logout();
        }
    }else{
        ?>
        <script>window.href.location ='obat.php';</script>
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
                <a href="obat.php?action=logout" class="btn btn-danger">LogOut</a>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <div class="container mt-3">
            <h3>Obat</h3><hr>
            <form action="obat.php?action=null" method="POST">
                <?php if(!empty($_GET['action']) && $_GET['id']) {?>
                    <div class="mb-3">
				        <input type="hidden" name="obat_id" value="<?= $edit['id_obat'] ?>"/>
                        <label for="nm_obat" class="form-label"><b>Nama Obat</b></label>
                        <input type="text" class="form-control" id="nm_obat" placeholder="masukan obat" name="nm_obat" value="<?= $edit['nm_obat'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="kemasan" class="form-label"><b>Kemasan</b></label>
                        <input type="text" class="form-control" id="kemasan" placeholder="Kemasan" name="kemasan" value="<?= $edit['kemasan'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="hrg" class="form-label"><b>Harga</b></label>
                        <input type="text" class="form-control" id="hrg" placeholder="harga obat" name="hrg" value="<?= $edit['harga'] ?>">
                    </div>
                    <button type="submit" name="btn_obat_ubah" class="btn btn-primary">Simpan</button>
                <?php }else{?>
                    <div class="mb-3">
                        <label for="nm_obat" class="form-label"><b>Nama Obat</b></label>
                        <input type="text" class="form-control" id="nm_obat" placeholder="masukan Obat" name="nm_obat" >
                    </div>
                    <div class="mb-3">
                        <label for="kemasan" class="form-label"><b>kemasan</b></label>
                        <input type="text" class="form-control" id="kemasan" placeholder="kemasan" name="kemasan">
                    </div>
                    <div class="mb-3">
                        <label for="hrg" class="form-label"><b>Harga</b></label>
                        <input type="text" class="form-control" id="hrg" placeholder="harga" name="hrg">
                    </div>
                    <button type="submit" name="btn_obat" class="btn btn-primary">Simpan</button>
                <?php }?> 
            </form>
        </div>
        <hr>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama obat</th>
                    <th>Kemasan</th>
                    <th>Harga</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i = 1;
                    foreach($dtObat as $obat) {
                ?>
                <tr>
                    <th><?= $i++?></th>
                    <th><?= $obat['nm_obat']?></th>
                    <th><?= $obat['kemasan']?></th>
                    <th><?= 'Rp ' . number_format($obat['harga'], 0, ',', '.')?></th>
                    <th>
                        <a class="btn btn-success" href="obat.php?action=edit&id=<?= $obat['id_obat'];?>">Ubah</a>
                        <a class="btn btn-danger" href="obat.php?action=delete&id=<?= $obat['id_obat'];?>" onclick="return confirm('Apakah anda yakin?')">Hapus</a>
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