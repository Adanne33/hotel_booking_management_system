<?php

function connectDB(){
    $db_host = 'localhost';
    $db_name = 'hotel_booking';
    $db_user = 'root';
    $db_password = '';

    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    if(mysqli_connect_error()){
        echo mysqli_connect_error();
        exit;
    }

    return $conn;
}
    