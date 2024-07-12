<?php
    
    require 'db.php';

    // ===== LOGIN & REGISTER & LOGOUT =====
    function daftar($data) {
        global $con;

        $username = strtolower(stripslashes(htmlspecialchars($data['user'])));
        $pass = mysqli_real_escape_string($con,htmlspecialchars($data["pass"]));
        $c_pass = mysqli_real_escape_string($con,htmlspecialchars($data["c_pass"]));

        $result = mysqli_query($con, "SELECT username FROM user WHERE username ='$username'");

        if( mysqli_fetch_assoc($result) ) {
            echo "
                <script>
                    alert('username sudah terdaftar!')
                </script>";
            return false;
        }

        if($pass !== $c_pass) {
            echo "
                <script>
                    alert('Konfirmasi password tidak sesuai')
                </script>";
            return false;
        } 

        $pass = password_hash($pass, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO `user` VALUES('', '$username','$pass')";
        mysqli_query($con, $query);
        return mysqli_affected_rows($con);

    }

    function login($data) {
        global $con;

        $username = $data['user'];
        $pass = $data['pass'];

        $result = mysqli_query($con, "SELECT * FROM user WHERE
        username = '$username'") ;

        // cek username
        if( mysqli_num_rows($result) === 1 ) {
            $row = mysqli_fetch_assoc($result);
            if(password_verify($pass, $row['password'])) {
                $_SESSION['username'] = $username;
                header('Location: index.php');
                exit;
            }
        }
        
        $error = true;
    }

    function logout() {
        session_start();
        $_SESSION = [];
        session_unset();
        session_destroy();
        header('location:login.php');
    }


    
    // ===== PASIEN =====
    // tambah pasien
    function addPasien($dtPasien){
        global $con;
        
        $namaPsn = htmlspecialchars($dtPasien['nm_Psn']);
        $almtPsn = htmlspecialchars($dtPasien['almt_Psn']);
        $noPsn = htmlspecialchars($dtPasien['no_Psn']);

        $query = "INSERT INTO `pasien` VALUES('', '$namaPsn', '$almtPsn', '$noPsn')";
        mysqli_query($con, $query);
        return mysqli_affected_rows($con);
    }
    //tampil semua data pasien
    function tampilPasien() {
        global $con;

        $query = "SELECT * FROM `pasien`";
        $execute_query = mysqli_query($con, $query);
        return $execute_query;
    }
    // hapus pasien
    function hpsPsn($id) {
        global $con;
        $query = "DELETE FROM `pasien` WHERE `id_psn` = '$id'";
        $execute_query = mysqli_query($con, $query);

        if($execute_query){
            header('location: pasien.php');
        }
    }
    // ambil data edit
    function tampilEditPsn($id){
        global $con;

        $query = "SELECT * FROM `pasien` WHERE id_psn = $id ";
        $execute_query = mysqli_query($con, $query);
        $result = mysqli_fetch_assoc($execute_query);
        return $result;
        // return mysqli_affected_rows($con);
    }
    // edit data pasien
    function editPsn($dtPasien){
        global $con;

        $id = htmlspecialchars($dtPasien['no']);
        $namaPsn = htmlspecialchars($dtPasien['nm_Psn']);
        $almtPsn = htmlspecialchars($dtPasien['almt_Psn']);
        $noPsn = htmlspecialchars($dtPasien['no_Psn']);

        $query = "UPDATE pasien SET nama_pasien = '$namaPsn', alamat ='$almtPsn', no_hp = '$noPsn' WHERE id_psn = $id";
        $execute_query = mysqli_query($con, $query);
        return mysqli_affected_rows($con);
    };



    // ===== DOKTER =====
    // tambah data dokter
    function addDokter($dtDokter) {
        global $con;
        
        $namaDktr = htmlspecialchars($dtDokter['nm_dktr']);
        $almtDktr = htmlspecialchars($dtDokter['almt_dktr']);
        $noDktr = htmlspecialchars($dtDokter['no_dktr']);

        $query = "INSERT INTO `dokter` VALUES('', '$namaDktr', '$almtDktr', '$noDktr')";
        mysqli_query($con, $query);
        return mysqli_affected_rows($con);
    }
    // tampil semua data dokter
    function tampilDokter() {
        global $con;

        $query = "SELECT * FROM `dokter`";
        $execute_query = mysqli_query($con, $query);
        return $execute_query;
    }
    // hapus dokter
    function hpsDktr($id) {
        global $con;
        $query = "DELETE FROM `dokter` WHERE `id_dktr` = '$id'";
        $execute_query = mysqli_query($con, $query);

        if($execute_query){
            header('location: dokter.php');
        }
    }
    // ambil data edit
    function tampilEditDktr($id){
        global $con;

        $query = "SELECT * FROM `dokter` WHERE id_dktr = $id ";
        $execute_query = mysqli_query($con, $query);
        $result = mysqli_fetch_assoc($execute_query);
        return $result;
        // return mysqli_affected_rows($con);
    }
    // edit data dokter
    function editDktr($dtPasien){
        global $con;

        $id = htmlspecialchars($dtPasien['dokter_id']);
        $namaPsn = htmlspecialchars($dtPasien['nm_dktr']);
        $almtPsn = htmlspecialchars($dtPasien['almt_dktr']);
        $noPsn = htmlspecialchars($dtPasien['no_dktr']);

        $query = "UPDATE dokter SET nama_dokter = '$namaPsn', alamat ='$almtPsn', no_hp = '$noPsn' WHERE id_dktr = $id";
        $execute_query = mysqli_query($con, $query);
        return mysqli_affected_rows($con);
    };



    // ===== OBAT =====
    function addObat($dtObat) {
        global $con;
        
        $namaObat = htmlspecialchars($dtObat['nm_obat']);
        $kemasan = htmlspecialchars($dtObat['kemasan']);
        $noObat = htmlspecialchars($dtObat['hrg']);

        $query = "INSERT INTO `obat` VALUES('', '$namaObat', '$kemasan', '$noObat')";
        mysqli_query($con, $query);
        return mysqli_affected_rows($con);
    }

    function tampilObat(){
        global $con;

        $query = "SELECT * FROM `obat`";
        $execute_query = mysqli_query($con, $query);
        return $execute_query; 
    }
    
    function tampilEditObat($id){
        global $con;

        $query = "SELECT * FROM `obat` WHERE id_obat = $id ";
        $execute_query = mysqli_query($con, $query);
        $result = mysqli_fetch_assoc($execute_query);
        return $result;
        // return 
        // return mysqli_affected_rows($con);
    }
    

    function hpsObat($id) {
        global $con;
        $query = "DELETE FROM `obat` WHERE `id_obat` = '$id'";
        $execute_query = mysqli_query($con, $query);

        if($execute_query){
            header('location: obat.php');
        }
    }

    function editObat($dtObat){
        global $con;

        $id = htmlspecialchars($dtObat['obat_id']);
        $namaObat = htmlspecialchars($dtObat['nm_obat']);
        $kemasan = htmlspecialchars($dtObat['kemasan']);
        $harga = htmlspecialchars($dtObat['hrg']);

        $query = "UPDATE obat SET nm_obat = '$namaObat', kemasan ='$kemasan', harga = '$harga' WHERE id_obat = $id";
        $execute_query = mysqli_query($con, $query);
        return mysqli_affected_rows($con);
    };


    
    // ===== PERIKSA =====
    // tambah data periksa
    function addPeriksa($data) {
        global $con;
    
        $id_psn = htmlspecialchars($data['id_psn']);
        $id_dktr = htmlspecialchars($data['id_dktr']);
        $tgl_periksa = htmlspecialchars($data['tgl_periksa']);
        $catatan = htmlspecialchars($data['catatan']);
        $obat = implode(", ", $data['obat']);
    
        $query = "INSERT INTO periksa (id_psn, id_dktr, tgl, catatan, obat) VALUES ('$id_psn', '$id_dktr','$tgl_periksa', '$catatan', '$obat')";
    
        mysqli_query($con, $query);
    
        return mysqli_affected_rows($con);
    }
    // tampil semua data periksa
    function tampilPeriksa() {
        global $con;

        $query = "SELECT periksa.id, periksa.id_psn, periksa.id_dktr, pasien.nama_pasien, dokter.nama_dokter, periksa.tgl, periksa.catatan, periksa.obat
              FROM periksa
              JOIN pasien ON periksa.id_psn = pasien.id_psn
              JOIN dokter ON periksa.id_dktr = dokter.id_dktr";

        $result = mysqli_query($con, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    // ambil data periksa
    function tampilEditPeriksa($id) {
        global $con;
    
        $query = "SELECT periksa.id, periksa.id_psn, periksa.id_dktr, pasien.nama_pasien, dokter.nama_dokter, periksa.tgl, periksa.catatan, periksa.obat
              FROM periksa
              INNER JOIN pasien ON periksa.id_psn = pasien.id_psn
              INNER JOIN dokter ON periksa.id_dktr = dokter.id_dktr
              WHERE periksa.id = $id";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_assoc($result);

    }
    
    // Fungsi untuk mengubah data periksa


    function editPeriksa($data) {
        global $con;
        $id = htmlspecialchars($data["id"]);
        // $id_psn = htmlspecialchars($data["nm_psn"]);
        // $id_dktr = htmlspecialchars($data["nm_dktr"]);
        $tgl = htmlspecialchars($data["tgl"]);
        $catatan = htmlspecialchars($data["catatan"]);
        $obat = implode(',', $data["obat"]);
    
        $query = "UPDATE periksa SET
                    tgl = '$tgl',
                    catatan = '$catatan',
                    obat = '$obat'
                  WHERE id = $id";
    
        mysqli_query($con, $query);
        return mysqli_affected_rows($con);
    }

    // hapus periksa
    function hpsPrks($id) {
        global $con;
        $query = "DELETE FROM `periksa` WHERE `id` = '$id'";
        $execute_query = mysqli_query($con, $query);

        if($execute_query){
            header('location: periksa.php');
        }
    }



    ////////////////////////////////

    function tampilPasienById($id_pasien) {
        global $con;
        $query = "SELECT * FROM pasien WHERE id_psn = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $id_pasien);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    function tampilDokterById($id) {
        global $con;

        // Query untuk mengambil data dokter berdasarkan ID
        $sql = "SELECT * FROM dokter WHERE id_dktr = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Ambil hasil query
        $row = $result->fetch_assoc();

        // Tutup statement dan koneksi
        $stmt->close();
        $con->close();

        return $row; // Mengembalikan array asosiatif berisi informasi dokter
    }

    function tampilObatById($id) {
        global $con;
        $query = "SELECT * FROM obat WHERE id_obat = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $obat = $result->fetch_assoc();
        $stmt->close();
        return $obat; // Return the entire row, including the harga field
    }

    function tampilObatByNama($nama_obat) {
        global $con;
        $query = "SELECT * FROM obat WHERE nm_obat = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $nama_obat);
        $stmt->execute();
        $result = $stmt->get_result();
        $obat = $result->fetch_assoc();
        $stmt->close();
        return $obat; // Return the entire row, including the harga field
    }
?>