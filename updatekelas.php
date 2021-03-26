<?php
    session_start();
    include('connectdb.php');
    $mysqli = konek('localhost', 'root', '', 'presensi_cloud');
    $int = $_POST['int'];
    $idmatakuliah = $_POST['idmatkul'];
    $kpid = $_POST['idkp'];
    $mysqli->select_db('presensi_cloud_' . $_SESSION['jid']);
    $sql = "update matakuliahs_kp set status=? where matakuliahs_id=? AND matakuliahs_buka_id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iii", $int, $idmatakuliah, $kpid);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "status" => true,
            "data" => $int
        ]);
    }else{
        echo json_encode([
            "status" => false
        ]);
    }
?>