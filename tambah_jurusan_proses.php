<?php 
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $fakultas_id = $_POST['fakultas_id'];
    $entities = $_POST['entity'];
    $fields = $_POST['field_name'];
    $typee = $_POST['typee'];
    for ($i=0; $i <= count($fields)-1 ; $i++) { 
        $fields[$i] = strtolower(str_replace(" ", "_", $fields[$i]));
    }
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
    else {
        $mysqli->select_db('presensi_cloud');
        $sql = "insert into jurusans (kode,nama) values ('".$nama.$fakultas_id."','".$nama."')";
        $result = $mysqli->query($sql);
        if ($result === TRUE) {
            $sql2 = "select id from jurusans order by id desc limit 1";
            $result2 = $mysqli->query($sql2);
            $row = $result2->fetch_assoc();
            $id = $row['id'];
            $newSchema = 'presensi_cloud_'.$nama;
            $sql3 = "create database ".$newSchema;
            $result3 = $mysqli->query($sql3);

            $restore_file  = "master_schema.sql";
            $server_name   = "localhost";
            $username      = "root";
            $password      = "";

            $cmd = "mysql -h $server_name -u $username $newSchema < $restore_file";
            exec($cmd);
            $mysqli->select_db($newSchema);
            for ($i=0; $i <= count($entities)-1 ; $i++) { 
                $sql = "ALTER TABLE ".$entities[$i]." ADD COLUMN ".$fields[$i]." ".$typee[$i];
                $result = $mysqli->query($sql);
            }
            $mysqli->select_db('presensi_cloud');
            $sql = "Insert Into metadatas (entity, custom_field, fakultas_id) Values (?,?,?)";
            for ($i=0; $i <= count($entities)-1 ; $i++) { 
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ssi", $entities[$i], $fields[$i], $fakultas_id);
                $stmt->execute();
            }
            $_SESSION['msg'] = "Jurusan berhasil ditambahkan.";
            header("Location:dashboard.php");
            exit;
        }
        else {
            echo $mysqli->error;
        }
    }
}
?>