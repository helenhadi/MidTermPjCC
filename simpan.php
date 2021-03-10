<?php 
include ('connectdb.php');
$mysqli = konek('localhost', 'root', '');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $entities = $_POST['entity'];
    $fields = $_POST['field'];

    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
    else {
        $mysqli->select_db('presensi_cloud');
        //simpan ke database
        $sql = "insert into universitass (nama) values ('".$nama."')";
        $result = $mysqli->query($sql);
        if ($result === TRUE) {
            //jika berhasil simpan ke database, maka selanjutnya ambil id yang tersimpan
            //dan buat schema dengan id tersebut
            $sql2 = "select id from universitass order by id desc limit 1";
            $result2 = $mysqli->query($sql2);
            $row = $result2->fetch_assoc();
            $id = $row['id'];
            //create new schema
            $newSchema = 'presensi_cloud_'.$id;
            $sql3 = "create database ".$newSchema;
            $result3 = $mysqli->query($sql3);

            $restore_file  = "master_schema.sql";
            $server_name   = "localhost";
            $username      = "root";
            $password      = "";

            // $cmd = "mysql -h {$server_name} -u {$username} -p{$password} {$newSchema} < $restore_file";
            $cmd = "mysql -h $server_name -u $username $newSchema < $restore_file";
            
            exec($cmd);

            // echo print_r($entities)."<br>";
            // echo print_r($fields)."<br>";

            $mysqli->select_db($newSchema);
            for ($i=0; $i <= count($entities)-1 ; $i++) { 
                $sql = "ALTER TABLE ".$entities[$i]." ADD COLUMN ".$fields[$i]." VARCHAR(45)";
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