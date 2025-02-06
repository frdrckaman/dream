<?php
// fetch_dates.php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

// header('Content-Type: application/json');
$sid = $_GET['sid'] ?? '';

if ($sid) {
    $result = $override->get('treatment_changes', 'enrollment_id', $sid);
    echo json_encode($result);
} else {
    echo json_encode([]);
}
?>