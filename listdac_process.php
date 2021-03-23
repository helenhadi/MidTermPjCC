<?php
session_start();
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '', '');
$mysqli->select_db('presensi_cloud');
if (isset($_POST['edtdacf'])) {
  $id = $_POST['edtid'];
  $kode = $_POST['kode'];
  $jurusan = $_POST['jurusan'];
  $entity = $_POST['entity'];
  $field = $_POST['field'];
  $operator = $_POST['operator'];
  $value = $_POST['value'];

  $sql = "update dac_rules set kode=?, jurusans_id=?, entity=?, field=?, operator=?, value=? where id=?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("ssssssi", $kode, $jurusan, $entity, $field, $operator, $value, $id);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    $_SESSION['success'] = "Insert DAC succeed!";
  }
  else {
    $_SESSION['error'] = "Failed to insert DAC, please try again...";
  }

  header("Location: listdac.php");
}
elseif (isset($_GET['delid'])){
  $sql = "delete from dac_rules where id = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("i", $_GET['delid']);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    $_SESSION['success'] = "Delete DAC succeed!";
  }
  else {
    $_SESSION['error'] = "Failed to delete DAC, please try again...";
  }
}
else
  header("Location: dashboard.php");
?>