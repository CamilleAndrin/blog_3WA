<?php
include('../config/config.php');
include('utilities/utilities.php');

session_start();
session_destroy();
header('location: loginUser.php');
exit;
?>