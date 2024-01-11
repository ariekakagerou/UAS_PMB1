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
if (isset($_FILES['foto'])) {
    $fileType = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

    if (in_array($fileType, ALLOWED_FILE_TYPES)) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["foto"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFilePath)) {
            // Prepared statement for database insertion
            $stmt = $kon->prepare("INSERT INTO tbl_cln_mhs_ari (reg_id, nama_lengkap, jenis_kelamin, no_handphone, email, asal_sekolah, program_studi, jenjang, kelas, foto, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssss", $nama_lengkap, $jenis_kelamin, $no_handphone, $email, $asal_sekolah, $program_studi, $jenjang, $kelas, $fileName, $status);

            $reg_id = '';
            $nama_lengkap = $_POST['nama_lengkap'];
            $jenis_kelamin = $_POST['jenis_kelamin'];
            $no_handphone = $_POST['no_handphone'];
            $email = $_POST['email'];
            $asal_sekolah = $_POST['asal_sekolah'];
            $program_studi = $_POST['program_studi'];
            $jenjang = $_POST['jenjang'];
            $kelas = $_POST['kelas'];
            $status = $_POST['status'];

            if ($stmt->execute()) {
                $last_insert_id = $kon->insert_id; // Get the ID of the inserted record
                echo json_encode(array('error' => false, 'msg' => 'Data Berhasil Disimpan', 'reg_id' => $last_insert_id));
            } else {
                echo json_encode(array('error' => true, 'msg' => "Database error: " . $stmt->error));
            }
        } else {
            echo json_encode(array('error' => true, 'msg' => 'Gagal upload file'));
        }
    } else {
        echo json_encode(array('error' => true, 'msg' => 'File tidak diperbolehkan'));
    }
} else {
    echo json_encode(array('error' => true, 'msg' => 'Tidak ada file yang diunggah'));
}
?>
