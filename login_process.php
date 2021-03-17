<?php 
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = $_POST['uid'];
    $password = $_POST['password'];
    header("Location:index.php");
    exit;
}
?>