<?php
header('Content-Type: application/json');

// Database connection
require_once 'php/core/init.php';

$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$validate = new validate();

$sid = $_GET['sid'] ?? null;

if ($sid) {
    // Replace with the actual query to fetch the screening date
    $result = $override->get('screening', 'id', $sid);

    if ($result) {
        echo json_encode(['screening_date' => $result[0]['screening_date']]);
    } else {
        echo json_encode(['error' => 'No screening date found']);
    }
} else {
    echo json_encode(['error' => 'No screening ID provided']);
}

// echo json_encode(['screening_date' => $result['screening_date']]);

?>