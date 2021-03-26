<?php
    session_start();
    include('connectdb.php');
    $mysqli = konek('localhost', 'root', '', 'presensi_cloud');
    $idmatakuliah = $_POST['idmatkul'];
    $kpid = $_POST['idkp'];
    $mysqli->select_db('presensi_cloud_' . $_SESSION['jid']);
    $sql = "SELECT * from matakuliahs_kp WHERE matakuliahs_id=" . $idmatakuliah . " AND matakuliahs_buka_id=" . $kpid;
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    echo json_encode([
        "status" => true,
        "data" => $row['status']
    ]);
?>
