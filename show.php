<?php

session_start();

require_once "includes/db_connect.php";
require_once "includes/get_record_id.php";
require_once "includes/isloggedin.php";




$id = $_GET['id'];

$conn = connectDB();

$data = getRecordById($conn, $id);

if (isset($_POST['download'])){
  header("Location: http://localhost/hotel_booking_management_system/print_pdf.php?id={$data['id']}");
  exit;
}


?>











<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Booking Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }

    .details-card {
      max-width: 700px;
      margin: 50px auto;
      padding: 30px;
      border-radius: 15px;
      background-color: #fff;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }

    .details-title {
      font-weight: 600;
      color: #0d6efd;
      margin-bottom: 20px;
      text-align: center;
    }

    .details-label {
      font-weight: 600;
      margin-bottom: 5px;
    }

    .booking-picture {
      height: 80px;
      width: 80px;
      object-fit: cover;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    .btn-group {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="details-card">
      <h2 class="details-title">Booking Details</h2>

      
            <?php if (isset($_SESSION['success_message'])): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
               <?= $_SESSION['success_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

      

        <!-- Student Info Display -->
            <div class="row mb-3">
            <img src="http://localhost/students_management_system/uploads/<?= $data['image_file'] ?>" alt="">
            </div>

      <div class="mb-3">
        
        <div class="details-label">Full Name</div>
        <div><?= $data['full_name'] ?></div>
      </div>

      <div class="mb-3">
        <div class="details-label">Email</div>
        <div><?= $data['email_address'] ?></div>
      </div>

      <div class="mb-3">
        <div class="details-label">Phone</div>
        <div><?= $data['phone_number'] ?></div>
      </div>

      <div class="mb-3">
        <div class="details-label">Room Type</div>
        <div><?= $data['room_type'] ?></div>
      </div>

      <div class="mb-3">
        <div class="details-label">Check-in</div>
        <div><?= $data['check_in_date'] ?></div>
      </div>

      <div class="mb-3">
        <div class="details-label">Check-out</div>
        <div><?= $data['check_out_date'] ?></div>
      </div>

      

<div class="col-mb-6">
  <form method="POST" >
    <button type="submit" name="download">Download PDF</button>
  </form>
</div>

      <div class="col-12 mt-4 d-flex justify-content-center gap-2">
   <a href="index_records.php" class="btn btn-secondary btn-sm">← Back</a>
  <a class="btn btn-sm btn-danger" href="delete.php?id=<?= $id ?>">Delete</a>
</div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
