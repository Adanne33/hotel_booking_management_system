<?php

function getRecordById($conn, $id){

$sql = "SELECT * FROM record_data WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("SQL prepare error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, 'i', $id);

if (!mysqli_stmt_execute($stmt)) {
    die("SQL execute error: " . mysqli_stmt_error($stmt));
}

$get_result = mysqli_stmt_get_result($stmt);

if (!$get_result) {
    die("Error getting result: " . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($get_result);

if (!$data) {
    die("No booking found for ID $id.");
}
return $data;





}
?>







