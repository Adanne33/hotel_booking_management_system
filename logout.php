<?php

session_start();

require_once "includes/db_connect.php";
require_once "includes/auth.php";





$_SESSION = [];

session_destroy();

header("Location: http://localhost:200/");
exit;

