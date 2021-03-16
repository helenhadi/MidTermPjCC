<?php 
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $entities = $_POST['entity'];
    $fields = $_POST['field'];
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
        $sql = "insert into universitass (nama) values ('".$nama."')";
        $result = $mysqli->query($sql);
        if ($result === TRUE) {
            $sql2 = "select id from universitass order by id desc limit 1";
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
            for ($i=0; $i <= count($entities)-1 ; $i++) { 
                $sql = "ALTER TABLE ".$entities[$i]." ADD COLUMN ".$fields[$i]." ".$typee[$i];
                $result = $mysqli->query($sql);
            }
            $mysqli->select_db('presensi_cloud');
            $sql = "Insert Into metadatas (entity, custom_field, universitass_id) Values (?, ?,?)";
            for ($i=0; $i <= count($entities)-1 ; $i++) { 
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("ssi", $entities[$i], $fields[$i], $id);
                $stmt->execute();
            }
            header("Location:index.php");
            exit;
        }
        else {
            echo $mysqli->error;
        }
    }
}
?>