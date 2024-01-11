<?php
// Security headers
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token");
header("Content-Type: application/json; charset=utf-8");

include "config.php";

// Define allowed file types
const ALLOWED_FILE_TYPES = ['jpg', 'png', 'jpeg', 'gif', 'pdf'];

// Process file upload
if (isset($_FILES['foto_mahasiswa'])) {
    $fileType = strtolower(pathinfo($_FILES['foto_mahasiswa']['name'], PATHINFO_EXTENSION));

    if (in_array($fileType, ALLOWED_FILE_TYPES)) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["foto_mahasiswa"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["foto_mahasiswa"]["tmp_name"], $targetFilePath)) {
            // Prepared statement for database insertion
            $stmt = $kon->prepare("INSERT INTO tbl_cln_mhs_ari ('reg_id', 'nama_lengkap', 'jenis_kelamin', 'no_handphone', 'email', 'asal_sekolah', 'program_studi', 'jenjang', 'kelas', 'foto_mahasiswa','status') VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
            $stmt->bind_param("ssssss", $reg_id, $nama_lengkap, $jenis_kelamin, $no_handpone, $email, $asal_sekolah, $program_studi, $jenjang, $kelas, $fileName, $status);

            $reg_id = '';
            $nama_lengkap = $_POST['nama_lengkap'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $no_handpone = $_POST['no_handphone'];
            $asal_sekolah = $_POST['asal_sekolah'];
            $program_studi= $_POST['program_studi'];
            $jenjang = $_POST['jenjang'];
            $kelas = $_POST['kelas'];
            $status = $_POST['0'];


            if ($stmt->execute()) {
                $last_insert_id = $kon->insert_id; // Get the ID of the inserted record
                echo json_encode(array('error' => false, 'msg' => 'Data Berhasil Disimpan', 'id' => $last_insert_id));
            } else {
                echo json_encode(array('error' => true, 'msg' => "Database error: " . $stmt->error));
            }
        } else {
            echo json_encode(array('error' => true, 'msg' => 'Gagal upload file'));
        }
    } else {
        echo json_encode(array('error' => true, 'msg' => 'File tidak diperbolehkan'));
    }
} 
