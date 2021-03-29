<?php
    session_start();
    include('connectdb.php');
    date_default_timezone_set("Asia/Jakarta");
    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    $ecode = generateRandomString(6);
    $mysqli = konek('localhost', 'root', '', 'presensi_cloud');
    $int = $_POST['int'];
    $idmatakuliah = $_POST['idmatkul'];
    $datenow = date("Y-m-d");
    $kpid = $_POST['idkp'];
    $kunik = $_POST['kodeun'];
    $tdkhdir = "TIDAK HADIR";
    $mysqli->select_db('presensi_cloud_' . $_SESSION['jid']);
    if($int == 0){
        $sql = "SELECT jadwals_id from jadwal_matakuliahs WHERE matakuliahs_id=" . $idmatakuliah . " AND matakuliahs_buka_id=" . $kpid;
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $jid = $row['jadwals_id'];
        $sql = "SELECT * FROM mahasiswas WHERE id NOT IN(SELECT mahasiswas_id FROM kehadirans WHERE matakuliahs_id=$idmatakuliah AND matakuliahs_buka_id=$kpid AND e_code='".$kunik."')";
        $stmt = $mysqli->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();
        while($row=$res->fetch_assoc()){
            $mid = $row['id'];
            $sql1="INSERT INTO kehadirans (mahasiswas_id,matakuliahs_id,matakuliahs_buka_id,jadwals_id,tanggal,status,e_code) 
            VALUES (". $mid. "," . $idmatakuliah . "," . $kpid . "," . $jid .",'" . $datenow . "','" . $tdkhdir . "','" . $kunik . "')";
            $stmt1 = $mysqli->prepare($sql1);
            $stmt1->execute();
        }
        $sql = "update matakuliahs_kp set e_code=NULL where matakuliahs_id=? AND matakuliahs_buka_id=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ii", $idmatakuliah, $kpid);
        $stmt->execute();
    }else{
        $sql = "update matakuliahs_kp set e_code=? where matakuliahs_id=? AND matakuliahs_buka_id=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sii", $ecode, $idmatakuliah, $kpid);
        $stmt->execute();
    }
    $sql = "update matakuliahs_kp set status=? where matakuliahs_id=? AND matakuliahs_buka_id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iii", $int, $idmatakuliah, $kpid);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        if ($int == 0) {
            echo json_encode([
                "status" => true,
                "data" => $int,
                "kunik" => '-'
            ]);
        }else{
        echo json_encode([
            "status" => true,
            "data" => $int,
            "kunik" => $ecode
        ]);
        }
    }else{
        echo json_encode([
            "status" => false
        ]);
    }
?>