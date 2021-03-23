<?php 
session_start();
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $fakultas_id = $_POST['fakultas_id'];
    $entities = $_POST['entity'];
    $fields = $_POST['field_name'];
    $typee = $_POST['typee'];
    $entitycustom = $_POST['entityc_name'];
    $typeentitycustom = $_POST['typee_en'];
    for ($i=0; $i <= count($fields)-1 ; $i++) { 
        $fields[$i] = strtolower(str_replace(" ", "_", $fields[$i]));
    }
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
    else {
        $mysqli->select_db('presensi_cloud');
        $sql = "SELECT * FROM jurusans WHERE nama = ? AND fakultass_id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $nama, $fakultas_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows <= 0) {
            $sql = "insert into jurusans (nama, fakultass_id) values ('".$nama."','".$fakultas_id."')";
            $result = $mysqli->query($sql);
            if ($result === TRUE) {
                $sql2 = "select id from jurusans order by id desc limit 1";
                $result2 = $mysqli->query($sql2);
                $row = $result2->fetch_assoc();
                $id = $row['id'];
                $newSchema = 'presensi_cloud_'.$id;
                $sql3 = "create database ".$newSchema;
                $result3 = $mysqli->query($sql3);

                $restore_file  = "master_schema.sql";
                $server_name   = "localhost";
                $username      = "root";
                $password      = "";

                $cmd = "mysql -h $server_name -u $username $newSchema < $restore_file";
                exec($cmd);
                $mysqli->select_db($newSchema);
                if($fields[0] != '' || $fields[0] != null){
                    $mysqli->select_db($newSchema);
                    for ($i = 0; $i <= count($entities) - 1; $i++) {
                        $sql = "ALTER TABLE " . $entities[$i] . " ADD COLUMN " . $fields[$i] . " " . $typee[$i];
                        $result = $mysqli->query($sql);
                    }
                    $mysqli->select_db('presensi_cloud');
                    $sql = "Insert Into metadatas (entity, custom_field, jurusans_id) Values (?,?,?)";
                    for ($i = 0; $i <= count($entities) - 1; $i++) {
                        $stmt = $mysqli->prepare($sql);
                        $stmt->bind_param("ssi", $entities[$i], $fields[$i], $id);
                        $stmt->execute();
                    }
                }
                if ($entitycustom[0] != '' || $entitycustom[0] != null) {
                  $mysqli->select_db($newSchema);
                  for ($i = 0; $i <= count($entitycustom) - 1; $i++) {
                    $sql = "CREATE TABLE " . $entitycustom[$i] . "(id " . $typeentitycustom[$i]. " NOT NULL AUTO_INCREMENT, PRIMARY KEY (id))";
                    $result = $mysqli->query($sql);
                  }
                  $mysqli->select_db('presensi_cloud');
                  $sql = "Insert Into metadatas (entity, custom_field, jurusans_id) Values (?,?,?)";
                  for ($i = 0; $i <= count($entitycustom) - 1; $i++) {
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("ssi", $entitycustom[$i], '', $id);
                    $stmt->execute();
                  }
                }
                $_SESSION['success'] = "Jurusan berhasil ditambahkan.";
                header("Location:manage_jurusans.php");
                exit;
            }
            else {
                $_SESSION['error'] = $mysqli->error;
            }
        } else {
            $_SESSION['error'] = "Jurusan sudah ada!";
            header("Location:manage_jurusans.php");
        }
    }
}