<?php
header("Content-Type: application/json");

// Connect to database

require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

$users = $override->getData('user');


// Fetch treatment changes
$data = $override->getData('treatment_changes');


echo json_encode($data);
?>
