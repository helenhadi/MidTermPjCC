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
                // Persentase
                $sql = "SELECT COUNT(id) as jumlah_hadir FROM `kehadirans` WHERE mahasiswas_id = " . $_SESSION['mid'] . " 
                        AND matakuliahs_id = " . $idmatakuliah . " AND matakuliahs_buka_id = " . $kpid . " AND status='HADIR'";
                $stmt = $mysqli->prepare($sql);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                $jumlah_kehadirans = $row['jumlah_hadir'];
                $sql = "SELECT count(DISTINCT e_code) as total_sesi from kehadirans where matakuliahs_id = " . $idmatakuliah . " 
                        AND matakuliahs_buka_id = " . $kpid;
                $stmt = $mysqli->prepare($sql);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
                $jumlah_sesi = $row['total_sesi'];
                $persentase = (100 * $jumlah_kehadirans) / $jumlah_sesi;
                $sql = "UPDATE ambil_matakuliahs SET persentase = ". $persentase . " WHERE mahasiswas_id = " . $_SESSION['mid'] . " 
                        AND matakuliahs_id = " . $idmatakuliah . " AND matakuliahs_buka_id = " . $kpid;
                $stmt = $mysqli->prepare($sql);
                $stmt->execute();
                // Persentase
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