<?php
// Database configuration 
$dbHost     = "213.171.200.24";
$dbUsername = "davidComfort3423";
$dbPassword = "f1o4*X!3$&vW?a2B";
$dbName     = "comfortBeds2022";

// Create database connection 
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection 
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
