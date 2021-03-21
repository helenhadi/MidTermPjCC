<?php
    session_start();
    include('connectdb.php');
    $fakultass_id = $_POST['idFakultas'];
    $mysqli = konek('localhost', 'root', '', 'presensi_cloud');
    $sql = "SELECT * FROM jurusans where fakultass_id=? order by nama ASC";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $fakultass_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $array = [];
    $i = 0;
    while ($row = $res->fetch_assoc()) {
        $array[$i]['id'] = $row['id'];
        $array[$i]['nama'] = $row['nama'];
        $i++;
    }
    echo json_encode([
        "status" => true,
        "data" => $array
    ]);
?>