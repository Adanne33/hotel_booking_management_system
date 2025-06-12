<?php

require_once "includes/db_connect.php";

$conn = connectDB();
$query = "SELECT * FROM room_types";
$result = mysqli_query($conn, $query);

$room_types = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
            
            <select class="form-select" id="room_type"   name="room_type" required>
                <?php foreach($room_types as $room_type):?>
              <option value="<?= $room_type['name']?>"><?= $room_type['name']?></option>
              <?php endforeach ?>
            </select>
   
</body>
</html>