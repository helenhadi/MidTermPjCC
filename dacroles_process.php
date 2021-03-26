<?php
session_start();
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '', '');
$mysqli->select_db('presensi_cloud');
if (isset($_POST['addholder'])) {
  $roleid = $_POST['roleid'];
  $userid = $_POST['userid'];

  $sql = "insert into dac_roles(user_id, dac_rule_id) values (?, ?)";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("ii", $userid, $roleid);
  $stmt->execute(); 

  if ($stmt->affected_rows > 0) {
    $_SESSION['success'] = "Add DAC holder succeed!";
  }
  else {
    $_SESSION['error'] = "Failed to add DAC holder, please try again...";
  }

  header("Location: dacroles.php?roleid=$roleid");
}
elseif (isset($_GET['delid'])){
  $roleid = $_GET['roleid'];
  $sql = "delete from dac_roles where id = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("i", $_GET['delid']);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    $_SESSION['success'] = "Delete DAC holder succeed!";
  }
  else {
    $_SESSION['error'] = "Failed to delete DAC holder, please try again...";
  }

  header("Location: dacroles.php?roleid=$roleid");
}
else
  header("Location: dashboard.php");
?>