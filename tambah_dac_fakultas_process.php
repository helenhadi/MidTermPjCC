<?php
session_start();
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '', '');
$mysqli->select_db('presensi_cloud');
if (isset($_POST['adddacf'])) {
  $kode = $_POST['kode'];
  $jurusan_id = $_POST['jurusan'];
  $entity = $_POST['entity'];
  $field = $_POST['field'];
  $operator = $_POST['operator'];
  $value = $_POST['value'];

  $sql = "insert into dac_rules(nama, username, password, jabatan, fakultass_id) values (?, ?, ?, ?, ?)";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("ssssi", $nama, $username, $saltedPwd, $jabatan, $fakultas);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    $_SESSION['success'] = "Insert DAC succeed!";
  }
  else {
    $_SESSION['error'] = "Failed to insert DAC, please try again...";
  }

  header("Location: tambah_dac_fakultas.php");
}
else
  header("Location: dashboard.php");
?>