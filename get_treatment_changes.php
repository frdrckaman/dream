<?php
require_once 'php/core/init.php';
$override = new OverideData();
$user = new User();
header('Content-Type: application/json');

// Get all treatment changes
$treatment_changes = $override->getData('treatment_changes');
echo json_encode($treatment_changes);
?>
