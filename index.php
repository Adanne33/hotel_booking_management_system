<?php

session_start();

require_once "includes/db_connect.php";
require_once "includes/auth.php";
require_once "includes/form_validation.php";




function myErrorHandler($errno, $errstr)
{
  echo "<b>Error:</b> [$errno] $errstr";
}
set_error_handler("myErrorHandler");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_POST['save'])) {

    require_once "includes/file_upload.php";


    $full_name = trim(filter_input(INPUT_POST, 'full_name'));
    $email_address = trim(filter_input(INPUT_POST, 'email_address'));
    $phone_number = trim(filter_input(INPUT_POST, 'phone_number'));
    $room_type = trim(filter_input(INPUT_POST, 'room_type'));
    $check_in_date = trim(filter_input(INPUT_POST, 'check_in_date'));
    $check_out_date = trim(filter_input(INPUT_POST, 'check_out_date'));

    $errors = formValidation($full_name, $email_address, $phone_number, $room_type, $check_in_date, $check_out_date);


    if (empty($errors)) {

      $conn = connectDB();

      $sql = "INSERT INTO record_data (full_name, email_address, phone_number, room_type, check_in_date, check_out_date, image_file)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

      $stmt = mysqli_prepare($conn, $sql);

      if ($stmt === false) {
        echo mysqli_error($conn);
      } else {

        mysqli_stmt_bind_param($stmt, 'sssssss', $full_name, $email_address, $phone_number, $room_type, $check_in_date, $check_out_date, $filename);

        $results = mysqli_stmt_execute($stmt);

        if ($results === false) {
          echo mysqli_stmt_error($stmt);
        } else {


          header('Location: http://localhost:200/index.php?success=1');
          exit;
        }
      }
    }
  }
}





?>







<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Booking Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }

    .form-card {
      max-width: 700px;
      margin: 40px auto;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }

    .form-title {
      font-weight: 600;
      margin-bottom: 25px;
      text-align: center;
      color: #0d6efd;
    }

    .btn-primary {
      width: 100%;
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="form-card">
      <h2 class="form-title">Booking Form</h2>

      <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Form submitted successfully!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?= $error ?></li>
            <?php endforeach; ?>
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>



      <form method="POST" enctype="multipart/form-data">


        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control shadow-sm" name="full_name" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control shadow-sm" name="email_address" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Phone Number</label>
            <input type="tel" class="form-control shadow-sm" name="phone_number" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Room Type</label>

            <select class="form-select" id="roomTypes" name="room_type" required>
              <option value="Single room">Single room</option>
              <option value="Double room">Double room</option>
              <option value="Studio room">Studio room</option>
              <option value="Suite">Suite</option>
              <option value="Executive room">Executive room</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Check-in Date</label>
            <input type="date" class="form-control shadow-sm" name="check_in_date" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Check-out Date</label>
            <input type="date" class="form-control shadow-sm" name="check_out_date" required>
          </div>


          <div class="col-12">
            <label for="file">Upload Image:</label>
            <input type="file" name="file" id="file" accept="image/*" onchange="checkImageResolution(event);">
          </div>
          <div id="error-message" style="color: red"></div>
  <div class="d-flex justify-content-center gap-2">

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary px-5" name="save">Submit</button>

    <!-- View Records Button -->
    <?php if (isLoggedIn()): ?>
      <a href="/index_records.php" class="btn btn-info px-5">View</a>
    <?php endif; ?>

  </div>
</div>


      <div class="py-3 text-center">
        <?php if (isLoggedIn()): ?>
          <p>You are logged in. <a href="logout.php">Logout</a></p>
        <?php else: ?>

          <p>Are you an admin? if yes, <a href="login.php">Login</a>!</p>
        <?php endif; ?>
      </div>

    </div>

  </div>
  </div>





  </div>
  </div>

  <script src="js/file_dimension.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>