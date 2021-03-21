<?php
session_start();
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '', 'presensi_cloud');
if (isset($_POST['adduser'])) {
    if ($_POST['password'] == $_POST['r_password']) {
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $saltedPwd = sha1(md5($password));
        $jabatan = $_POST['jabatan'];
        $fakultas = $_POST['fakultas'];
        $jurusan = $_POST['jurusan'];
        if ($jurusan == 0) {
            $sql = "insert into users(nama, username, password, jabatan, fakultass_id) values (?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ssssi", $nama, $username, $saltedPwd, $jabatan, $fakultas);
        }
        else {
            $sql = "insert into users(nama, username, password, jabatan, fakultass_id, jurusans_id) values (?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ssssii", $nama, $username, $saltedPwd, $jabatan, $fakultas, $jurusan);
        }
        
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Insert user succeed!";
        }
        else {
            $_SESSION['error'] = "Failed to insert user, please try again...";
        }
    }
    else {
        $_SESSION['error'] = "Passwords does not match!";
    }

    header("Location: tambah_user.php");
}
else
    header("Location: dashboard.php");
?>