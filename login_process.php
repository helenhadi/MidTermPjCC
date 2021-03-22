<?php 
session_start();
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '', 'presensi_cloud');
if (isset($_POST['btnsignin'])) {
    $uid = $_POST['uid'];
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
        $_SESSION['idd'] = $row['id'];
        $_SESSION['jabatan'] = $row['jabatan'];
        $_SESSION['fid'] = $row['fakultass_id'];
        $_SESSION['jid'] = $row['jurusans_id'];
        header("Location: dashboard.php");
    }
}
?>