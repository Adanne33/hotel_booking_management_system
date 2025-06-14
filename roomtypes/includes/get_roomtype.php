<?php

function getRoomtypeData($conn, $id)
{
    // Prepare the SQL statement
    $sql = "SELECT * FROM roomtypes WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        // If preparation failed
        die("SQL prepare failed: " . mysqli_error($conn));
    }

    // Bind the id parameter
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Execute the statement
    if (!mysqli_stmt_execute($stmt)) {
        die("Statement execution failed: " . mysqli_stmt_error($stmt));
    }

    // Get the result set
    $get_result = mysqli_stmt_get_result($stmt);

    if (!$get_result) {
        die("Getting result failed: " . mysqli_error($conn));
    }

    // Fetch and return the associative array
    return mysqli_fetch_assoc($get_result);
}
