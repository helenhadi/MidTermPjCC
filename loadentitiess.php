<?php
    session_start();
    include('connectdb.php');
    $jurusans_id = $_POST['id'];
    $mysqli = konek('localhost', 'root', '', 'presensi_cloud_' . $jurusans_id);
    $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='presensi_cloud_$jurusans_id'";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $res = $stmt->get_result();
    $array = [];
    $i = 0;
    while ($row = $res->fetch_assoc()) {
        $array[$i]['TABLE_NAME'] = $row['TABLE_NAME'];
        $i++;
    }
    echo json_encode([
        "status" => true,
        "data" => $array
    ]);
