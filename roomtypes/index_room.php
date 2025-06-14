<?php
require "../includes/db_connect.php";
require "includes/form_validate.php";
require "../includes/auth.php";

session_start();

// Redirect if not logged in
if (!isLoggedIn()) {
    die("Unauthorized access. Please <a href='../index.php'>log in</a>.");
}

// Custom error handler
set_error_handler(function ($errno, $errstr) {
    echo "<div class='alert alert-danger'>Error [$errno]: $errstr</div>";
});

$conn = connectDB();
$errors = [];
$successMsg = "";

// Clear all roomtypes
if (isset($_POST['clear_roomtypes'])) {
    mysqli_query($conn, "TRUNCATE TABLE roomtypes");
    header("Location: index_room.php");
    exit;
}

// Insert new roomtype
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['save'])) {
    $roomtype = trim(htmlspecialchars($_POST['new_roomtype'] ?? ''));

    $errors = validateRoomData($roomtype);

    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO roomtypes (customer_room) VALUES (?)");

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $roomtype);
            if (mysqli_stmt_execute($stmt)) {
                $successMsg = "Roomtype added successfully!";
            } else {
                $errors[] = "Failed to add roomtype.";
            }
        } else {
            $errors[] = "Error preparing statement.";
        }
    }
}

// Fetch all roomtypes
$query = "SELECT * FROM roomtypes ORDER BY id DESC";
$result = mysqli_query($conn, $query);
$roomtypes = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KGHOTEL | Manage Roomtypes</title>
  <link href="../stylings/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: whitesmoke; font-family: Arial, sans-serif;">

<div class="container mt-5">
  <h2 class="text-center mb-4 text-dark">Manage Roomtypes</h2>

  <!-- Success Message -->
  <?php if (!empty($successMsg)): ?>
    <div class="alert alert-success"><?= $successMsg ?></div>
  <?php endif; ?>

  <!-- Error Messages -->
  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($errors as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <!-- Add Roomtype Form -->
  <form method="POST" class="bg-light p-4 rounded shadow-sm mb-4">
    <div class="mb-3">
      <label for="new_roomtype" class="form-label">New Roomtype</label>
      <input type="text" class="form-control" name="new_roomtype" id="new_roomtype" placeholder="Enter new roomtype">
    </div>
    <button type="submit" class="btn btn-success" name="save">Add Roomtype</button>
    <button type="submit" class="btn btn-outline-danger" name="clear_roomtypes" onclick="return confirm('Are you sure you want to clear all roomtypes?')">Clear All</button>
  </form>

  <!-- Roomtype Table -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover text-center">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Roomtype</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($roomtypes)): ?>
          <?php foreach ($roomtypes as $room): ?>
            <tr>
              <td><?= $room['id'] ?></td>
              <td><?= htmlspecialchars($room['customer_room']) ?></td>
              <td>
                <a class="btn btn-sm btn-warning me-1" href="edit_room.php?id=<?= $room['id'] ?>">Edit</a>
<a class="btn btn-sm btn-danger" href="delete_room.php?id=<?= $room['id'] ?>" onclick="return confirm('Are you sure you want to delete this roomtype?')">Delete</a>

              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="3">No roomtypes found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <div class="text-center mt-4">
    <a class="btn btn-secondary" href="../admin.php">Back to Database Page</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
