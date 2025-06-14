<?php

function validateRoomData($customer_room) {
    $errors = [];

    if (empty(trim($customer_room))) {
        $errors[] = 'Room name field must not be empty';
    }

    return $errors;
}
