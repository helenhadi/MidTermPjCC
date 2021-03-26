<?php
    session_start();
    include('connectdb.php');
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
    $kpid = $_POST['idkp'];
    $mysqli->select_db('presensi_cloud_' . $_SESSION['jid']);
    if($int == 0){
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