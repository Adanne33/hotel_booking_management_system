<?php

session_start();

require_once "includes/db_connect.php";
require_once "includes/isloggedin.php";



$conn = connectDB();

$sql = "SELECT * FROM record_data";
$results = mysqli_query($conn, $sql);

if ($results === false) {
  echo mysqli_error($conn);
} else {
  $all_data = mysqli_fetch_all($results, MYSQLI_ASSOC);
}

if(isset($_POST['clear_record_data'])){
  $sql = "TRUNCATE TABLE record_data";
    mysqli_query($conn, $sql);

    header("Location: http://localhost:200/index_records.php");
    exit();
}

    

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>All Bookings</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }

    .table th,
    .table td {
      vertical-align: middle;
    }

    .btn-sm {
      min-width: 70px;
    }

    .card {
      border-radius: 1rem;
    }

    .btn-outline-secondary:hover,
    .btn-outline-warning:hover,
    .btn-outline-danger:hover {
      color: white;
    }
  </style>
</head>

<body>
  <div class="container my-5">
    <div class="card shadow-sm p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary mb-0">All Bookings</h2>
        
      </div>

      <?php if (!empty($all_data)): ?>
        <div class="table-responsive">
          <table class="table table-striped table-bordered align-middle text-center">
            <thead class="table-primary">
              <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Photos</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($all_data as $index => $data): ?>
                <tr>
                  <td><?= $index + 1 ?></td>
                  <td><?= htmlspecialchars($data['full_name']) ?></td>
                  <td><?= htmlspecialchars($data['email_address']) ?></td>
                  <td><?= htmlspecialchars($data['phone_number']) ?></td>
                  
                  <td><?= htmlspecialchars($data['check_in_date']) ?></td>
                  <td><?= htmlspecialchars($data['check_out_date']) ?></td>
                  <td>
                    
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $data['id'] ?>">
    View
  </button>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal<?= $data['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel<?= $data['id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel<?= $data['id'] ?>">Customer's Photo</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <!-- Modal Body -->
        <div class="modal-body">
          
            
          
            <img src="http://localhost/hotel_booking_management_system/uploads/<?= htmlspecialchars($data['image_file']) ?>" alt="Customer Photo" class="img-fluid">
          
            
          
        </div>
      </div>
    </div>
  </div>
</td>

  <td>
    <a class="btn btn-sm btn-secondary me-1" href="show.php?id=<?= $data['id'] ?>">Show</a>
    <a class="btn btn-sm btn-warning me-1" href="edit.php?id=<?= $data['id'] ?>">Edit</a>
    <a class="btn btn-sm btn-danger" href="delete.php?id=<?= $data['id'] ?>">Delete</a>
  </td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php else: ?>
  <div class="alert alert-info text-center mb-0">No booking records found.</div>
<?php endif; ?>
<div class="text-center mt-4">
                            <div class="d-flex justify-content-center gap-3">
                                <a href="/index.php" class="btn btn-success px-4">Add New Student</a>
                                <a href="http://localhost/hotel_booking_management_system/roomtypes/index_room.php" class="btn btn-info px-4">Roomtype</a>

                                <form method="POST">

 <!-- Button trigger modal -->
                                <button type="button" class="btn btn-dark px-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Clear Records
                                </button>
                        
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Are you sure?</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" name="clear_records" class="btn btn-sm btn-primary">YES, Delete!</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>