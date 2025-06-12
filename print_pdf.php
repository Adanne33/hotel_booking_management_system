<?php

session_start();

use Dompdf\Dompdf;

require_once "vendor/autoload.php";
require_once "includes/db_connect.php";
require_once "includes/get_record_id.php";
require_once "includes/isloggedin.php";

$id = $_GET['id'];

$conn = connectDB();

$data = getRecordById($conn, $id);

ob_start();

?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking Management System</title>
</head>
<body>
    
<article>
    <h2><?= htmlspecialchars($data['full_name']) ?></h2>
    <p><b>ID: <?= htmlspecialchars($data['id']) ?></b></p>
    <p>Email Address: <?= htmlspecialchars($data['email_address'])?></p>
    <p>Phone Number: <?= htmlspecialchars($data['phone_number'])?></p>
    <p>Room Type: <?= htmlspecialchars($data['room_type'])?></p>
    <p>Check In Date: <?= htmlspecialchars($data['check_in_date'])?></p>
    <p>Check Out Date: <?= htmlspecialchars($data['check_out_date'])?></p>
    
</article>

</body>
</html>
<?php 

$html = ob_get_clean();

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'potrait');

$dompdf->render();

$dompdf->stream('output.pdf', ['Attachment' => true]);

?>