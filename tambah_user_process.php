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
        $sql = "SELECT * FROM users WHERE username=? AND password=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $uid, $saltedPwd);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        if(!$row) {
            $_SESSION['err'] = "Wrong credentials";
            header("Location: login.php");
        } else {
            $_SESSION['err'] = "";
            $_SESSION['username'] = $uid;
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['jabatan'] = $row['jabatan'];
            header("Location: dashboard.php");
        }
    }
    else {
        $_SESSION['err'] = "Passwords does not match!";
    }
}
?>