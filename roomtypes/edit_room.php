<?php
require_once "../includes/db_connect.php";
$conn = connectDB();

if (!isset($_GET['id'])) {
    die("Roomtype ID missing.");
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $room_name = trim($_POST['room_name']);

    if ($room_name) {
        $sql = "UPDATE roomtypes SET customer_room = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $room_name, $id);
        mysqli_stmt_execute($stmt);

        header("Location: index_room.php");
        exit;
    } else {
        $error = "Room name cannot be empty.";
    }
} else {
    $sql = "SELECT * FROM roomtypes WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $room = mysqli_fetch_assoc($result);

    if (!$room) {
        die("Roomtype not found.");
    }
}
?>

<form method="POST">
  <label>Room Name:</label>
  <input type="text" name="room_name" value="<?= htmlspecialchars($room['customer_room']) ?>" required>
  <button type="submit">Update</button>
</form>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
