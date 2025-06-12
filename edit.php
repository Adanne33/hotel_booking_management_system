<?php

session_start();

require_once "includes/db_connect.php";
require_once "includes/get_record_id.php";
require_once "includes/isloggedin.php";
require_once "includes/form_validation.php";

$id = $_GET['id'];

$conn = connectDB();



// Check if 'id' is provided in the URL
if (isset($_GET['id'])) {
  
$data = getRecordById($conn, $id);

if (!$data) {
  echo require_once "includes/no_record.php";
  exit;
}
if($data){
  $full_name = $data['full_name'];
  $email_address = $data['email_address'];
  $phone_number = $data['phone_number'];
  $room_type = $data['room_type'];
  $check_in_date = $data['check_in_date'];
  $check_out_date = $data['check_out_date'];
  $filename = $data['image_file'];
  
}
} else {
  echo require_once "includes/invalid_request.php";
  exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_POST['update'])) {

    require_once "includes/file_upload.php";
    
    $full_name = trim(filter_input(INPUT_POST,'full_name'));
    $email_address = trim(filter_input(INPUT_POST, 'email_address'));
    $phone_number = trim(filter_input(INPUT_POST,'phone_number'));
    $room_type = trim(filter_input(INPUT_POST,'room_type'));
    $check_in_date = trim(filter_input(INPUT_POST,'check_in_date'));
    $check_out_date = trim(filter_input(INPUT_POST,'check_out_date'));
    
     $errors = formValidation($full_name, $email_address, $phone_number, $room_type, $check_in_date, $check_out_date,);
    
    if (empty($errors)) {
    

      $sql = "UPDATE record_data
              SET full_name = ?, email_address = ?, phone_number = ?, room_type = ?, check_in_date = ?, check_out_date = ?, image_file = ?
              WHERE id = ?";

      $stmt = mysqli_prepare($conn, $sql);


      mysqli_stmt_bind_param($stmt, 'sssssssi', $full_name, $email_address, $phone_number, $room_type, $check_in_date, $check_out_date, $filename, $id);


      $results = mysqli_stmt_execute($stmt);
      
      if ($results) {
        $_SESSION['success_message'] = "✅ form updated successfully";

        header("Location: http://localhost:200/show.php?id=$id");
        exit;
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
      <h2 class="form-title">Edit Booking Form</h2>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          
        <ul>
          <?php foreach($errors as $error): ?>
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
            <input type="text" name="full_name" value="<?= $data['full_name'] ?>" class="form-control shadow-sm" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email Address</label>
            <input type="email" name="email_address" value="<?= $data['email_address'] ?>" class="form-control shadow-sm" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Phone Number</label>
            <input type="tel" name="phone_number" value="<?= $data['phone_number'] ?>" class="form-control shadow-sm" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Room Type</label>
            <input class="form-control shadow-sm" name="room_type" value="<?= $data['room_type'] ?>" list="roomTypes" placeholder="Type to search..." required>
            <datalist id="roomTypes">

              <?php
              $roomType = ['Single room', 'Double room', 'Studio room', 'Suite', 'Executive room'];

              foreach ($roomType as $index_value) {
                $selected = ($index_value === $roomType) ? 'selected' : '';
                echo "<option value='$index_value' $selected>$index_value</option>";
              }
              ?>


            </datalist>
          </div>
          <div class="col-md-6">
            <label class="form-label">Check-in Date</label>
            <input type="date" name="check_in_date" value="<?= $data['check_in_date'] ?>" class="form-control shadow-sm" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Check-out Date</label>
            <input type="date" name="check_out_date" value="<?= $data['check_out_date'] ?>" class="form-control shadow-sm" required>
          </div>
<div class="col-12">
            <label for="file">Upload Image:</label>
            <input type="file"  name="file" id="file" accept="image/*" onchange="checkImageResolution(event);" value="<?= $filename ?>">
          </div>
        <div id="error-message" style="color: red"></div>

        <div class="text-center">
          <button type="submit" name="update" class="btn btn-primary btn-sm w-25">Update</button>
  <a class="btn btn-secondary btn-sm w-25 text-center" href="/index_records.php">Back</a>
</div>


          </div>
      </form>
    </div>
  </div>


<script src="js/file_dimension.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>