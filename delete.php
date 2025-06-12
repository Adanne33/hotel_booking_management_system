<?php

require_once "includes/db_connect.php";

session_start();

$id = $_GET['id'];

$conn = connectDB();

if(isset($id)){

    $sql = "DELETE FROM record_data WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, 'i', $id);

     $result = mysqli_stmt_execute($stmt);

     if($result){
        header("Location: http://localhost:200/index_records.php");
        exit;
     }

}



?>