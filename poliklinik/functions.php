<?php
    
    require 'db.php';

    function addPasien($dtPasien){
        global $con;
        
        $namaPsn = htmlspecialchars($dtPasien['nm_Psn']);
        $almtPsn = htmlspecialchars($dtPasien['almt_Psn']);
        $noPsn = htmlspecialchars($dtPasien['no_Psn']);

        $query = "INSERT INTO `pasien` VALUES('', '$namaPsn', '$almtPsn', '$noPsn')";
        mysqli_query($con, $query);
        return mysqli_affected_rows($con);
    }

    function tampilPasien() {
        global $con;

        $query = "SELECT * FROM `pasien`";
        $execute_query = mysqli_query($con, $query);
        return $execute_query;
    }

    function addDokter($dtDokter) {
        global $con;
        
        $namaDktr = htmlspecialchars($dtDokter['nm_dktr']);
        $almtDktr = htmlspecialchars($dtDokter['almt_dktr']);
        $noDktr = htmlspecialchars($dtDokter['no_dktr']);

        $query = "INSERT INTO `dokter` VALUES('', '$namaDktr', '$almtDktr', '$noDktr')";
        mysqli_query($con, $query);
        return mysqli_affected_rows($con);
    }

    function hpsPsn($id) {
        global $con;
        $query = "DELETE FROM `pasien` WHERE `id` = '$id'";
        $execute_query = mysqli_query($con, $query);

        if($execute_query){
            header('location: pasien.php');
        }
    }

    function tampilDokter() {
        global $con;

        $query = "SELECT * FROM `dokter`";
        $execute_query = mysqli_query($con, $query);
        return $execute_query;
    }

    function addPeriksa($dtPeriksa){
        global $con;

        $namaPsn = $dtPeriksa['nm_psn'];
        $namaDktr = $dtPeriksa['nm_dktr'];
        $tgl = $dtPeriksa['tgl_periksa'];
        $catatan = htmlspecialchars($dtPeriksa['catatan']);
        $obat = htmlspecialchars($dtPeriksa['obat']);

        $query = "INSERT INTO `periksa` VALUES('', '$namaPsn','$namaDktr', '$tgl', '$catatan', '$obat')";
        mysqli_query($con, $query);
        return mysqli_affected_rows($con);
    }

    function hpsDktr($id) {
        global $con;
        $query = "DELETE FROM `dokter` WHERE `id` = '$id'";
        $execute_query = mysqli_query($con, $query);

        if($execute_query){
            header('location: dokter.php');
        }
    }

    function tampilPeriksa(){
        global $con;

        $query = "SELECT * FROM `periksa`";
        $execute_query = mysqli_query($con, $query);
        return $execute_query; 
    }

    function hpsPrks($id) {
        global $con;
        $query = "DELETE FROM `periksa` WHERE `id` = '$id'";
        $execute_query = mysqli_query($con, $query);

        if($execute_query){
            header('location: periksa.php');
        }
    }

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
    }
?>