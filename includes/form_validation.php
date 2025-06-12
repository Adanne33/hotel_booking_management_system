<?php

function formValidation($full_name, $email_address, $phone_number, $room_type, $check_in_date, $check_out_date,){
    
    $errors = [];

    if ($full_name == ''){
        $errors[] = "The full name field must not be empty.";

    }
if ($email_address == ''){
        $errors[] = "The email address field must not be empty.";
    }
if ($phone_number == ''){
        $errors[] = "The phone number field must not be empty.";
    }
if ($room_type == ''){
        $errors[] = "The room type field must not be empty.";
    }
if ($check_in_date == ''){
        $errors[] = "The check in date field must not be empty.";
    }
if ($check_out_date == ''){
        $errors[] = "The check out daate field must not be empty.";
    }
    return $errors;
}






