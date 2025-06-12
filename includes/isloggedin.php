<?php

require_once "auth.php";



if(!isLoggedIn()){
  die(require_once "unauthorized.php");
}