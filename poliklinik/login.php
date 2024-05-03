<?php
    session_start();
    require 'functions.php';

    if(isset($_POST['btn_login'])) {
        login($_POST);
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
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="http://localhost/kuliah/poliklinik/periksa.php">Periksa</a>
                </li>
            </ul>
            <div class="d-flex gap-3" role="search">
                <a href="login.php" class="btn btn-secondary">Login</a>
                <a href="#" class="btn btn-danger">Register</a>
            </form>
            </div>
        </div>
    </nav>
    
    <div class="container mt-3">
        <div class="mx-auto p-2 border" style="width: 500px;">
            <h3 class="text-center">LOGIN</h3>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label"><b>Username</b></label>
                    <input type="text" class="form-control" id="nm_dktr" placeholder="Username" name="user">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><b>Password</b></label>
                    <input type="password" class="form-control" id="almt_dktr" placeholder="Password" name="pass">
                </div>
                <div class="vstack gap-2 col-md-5 mx-auto">
                    <button type="submit" name="btn_login" class="btn btn-primary">Login</button>
                </div>
            </form>
            <p class="mt-3">Belum punya akun? <a href="daftar.php">daftar</a></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>