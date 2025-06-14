<?php
require_once "../includes/db_connect.php";
$conn = connectDB();

if (!isset($_GET['id'])) {
    die("Roomtype ID missing.");
}

$id = $_GET['id'];

$sql = "DELETE FROM roomtypes WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: index_room.php");
exit;

