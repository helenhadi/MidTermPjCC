<?php
session_start();
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '', '');
$database = ""; //MASIH BINGUNG HOW TO GET THE JURUSAN ID :)
$mysqli->select_db($database);
if (isset($_POST['adddacf'])) {
  $kode = $_POST['kode'];
  $entity = $_POST['entity'];
  $field = $_POST['field'];
  $operator = $_POST['operator'];
  $value = $_POST['value'];

  $sql = "insert into dac_rules(kode, entity, field, operator, value) values (?, ?, ?, ?, ?, ?)";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("ssssss", $kode, $entity, $field, $operator, $value);
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