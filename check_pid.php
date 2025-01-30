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

    header('Content-Type: application/json');

    // Get PID from the request
    $data = json_decode(file_get_contents('php://input'), true);
    $pid = $data['pid'];

    // Query to check if PID exists
    $facility_code = $override->get('pids', 'facility_id', $user->data()->site_id)[0];
    $full_pid = $facility_code['pid'] . '_' . $pid;
    $pid_exists = $override->getCount('screening', 'pid', $full_pid);

    $exists = false;
    if ($pid_exists) {
        return $exists = true;
    }

    echo json_encode(['exists' => $exists]);

} else {
    Redirect::to('index.php');
}
?>