<?php
require_once 'php/core/init.php';
$user = new User();

header('Content-Type: application/json');

// Receive POST data
$id = $_POST['id'] ?? '';

if ($id) {
    // Delete record
    $user->deleteRecord('treatment_changes','id', $id);
    echo json_encode(["status" => "success", "message" => "Record deleted successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "No ID provided!"]);
}
?>
