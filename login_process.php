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
        $sql1 = "SELECT * FROM dac_roles WHERE user_id=". $row['id'];
        $stmt1 = $mysqli->prepare($sql1);
        $stmt1->execute();
        $res1 = $stmt1->get_result();
        if($res1->num_rows > 0){
            $_SESSION['isdac'] = true;
        }else{
            $_SESSION['isdac'] = false;
        }
        $_SESSION['jabatan'] = $row['jabatan'];
        $_SESSION['fid'] = $row['fakultass_id'];
        $_SESSION['jid'] = $row['jurusans_id'];
        if($_SESSION['jabatan'] == 'mhs'){
            $mysqli->select_db('presensi_cloud_' . $_SESSION['jid']);
            $sql = "SELECT * FROM mahasiswas WHERE user_id=?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $_SESSION['idd']);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            $_SESSION['mid'] = $row['id'];
        }
        header("Location: dashboard.php");
    }
}
?>