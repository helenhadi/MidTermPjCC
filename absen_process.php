<?php
    session_start();
    include('connectdb.php');
    date_default_timezone_set("Asia/Jakarta");
    $mysqli = konek('localhost', 'root', '', 'presensi_cloud');
    $idmatakuliah = $_POST['idmatkul'];
    $kpid = $_POST['idkp'];
    $kode_absen = $_POST['kode'];
    $datenow = date("Y-m-d");
    $hadir = "HADIR";
    $mysqli->select_db('presensi_cloud_' . $_SESSION['jid']);
    $sql = "SELECT jadwals_id from jadwal_matakuliahs WHERE matakuliahs_id=" . $idmatakuliah . " AND matakuliahs_buka_id=" . $kpid;
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $jid = $row['jadwals_id'];
    $sql = "SELECT * from matakuliahs_kp WHERE matakuliahs_id=" . $idmatakuliah . " AND matakuliahs_buka_id=" . $kpid . " AND e_code=" . $kode_absen;
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $res = $stmt->get_result();
    if($res->num_rows > 0){
        $sql = "SELECT * from kehadirans WHERE mahasiswas_id=" . $_SESSION['mid'] . " AND matakuliahs_id=" . $idmatakuliah . " AND matakuliahs_buka_id=" . $kpid . " AND e_code=" . $kode_absen;
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            echo json_encode([
                "status" => false,
                "data" => 'Kamu sudah melakukan absensi pada sesi ini!'
            ]);
        }else{
            $sql = "INSERT INTO kehadirans (mahasiswas_id,matakuliahs_id,matakuliahs_buka_id,jadwals_id,tanggal,status,e_code) 
            VALUES (". $_SESSION['mid']. "," . $idmatakuliah . "," . $kpid . "," . $jid .",'" . $datenow . "','" . $hadir . "'," . $kode_absen . ")";
            $stmt = $mysqli->prepare($sql);
            $stmt->execute();
            if($stmt->affected_rows > 0){
                echo json_encode([
                    "status" => true,
                    "data" => 'Kamu berhasil absen!'
                ]);
            }else{
                echo json_encode([
                    "status" => false,
                    "data" => 'Error terjadi ketika absen, coba lagi!'
                ]);
            }
        }
    }else{
        echo json_encode([
            "status" => false,
            "data" => 'Kode kelas invalid!'
        ]);
    }

?>