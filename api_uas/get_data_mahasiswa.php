<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methos: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token");
header("Content-Type: application/json; charset=utf-8");

    include "config.php";
    $data = array();
    $no=1;
    $query = mysqli_query($kon, "SELECT * FROM tbl_cln_mhs_ari order by reg_id desc ");

    while($rows =mysqli_fetch_array($query)){
        $data[] = array(
            'no' => $no,
            'reg_id' => $rows['reg_id'],
            'nama_lengkap' => $rows['nama_lengkap'],
            'email' => $rows['email'],
            'status' => $rows['status'],
        );
        $no++;
    }
        
    if($query){
        $result = json_encode(array('success'=>true, 'result'=>$data));
    }else{
        $result = json_encode(array('success'=>false));
    }
    echo $result;
    
?>  