<?php
// check_pid.php

// Database connection

require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$validate = new validate();

$successMessage = null;
$pageError = null;
$errorMessage = null;
$numRec = 10;
if ($user->isLoggedIn()) {

// Get PID from the request
$data = json_decode(file_get_contents('php://input'), true);
$pid1 = $data['pid1'];

// Query to check if PID exists
    $all_pid = $override->getData('screening')[0];
    $pid_exists = $pid['pid'] . '_' . $pid1;

// Return JSON response
header('Content-Type: application/json');
echo json_encode(['exists' => $row['count'] > 0]);

$stmt->close();
$conn->close();

} else {
    Redirect::to('index.php');
}
?>