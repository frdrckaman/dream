<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

header('Content-Type: application/json');

// Receive POST data
$id = $_POST['id'] ?? '';  // If this is empty, we're adding a new record.
$diagnosis_id = $_POST['diagnosis_id'] ?? '';
$enrollment_id = $_POST['enrollment_id'] ?? '';
$date = $_POST['date'] ?? '';
$drug = $_POST['drug'] ?? '';
$changes = $_POST['changes'] ?? '';
$reason = $_POST['reason'] ?? '';
$specify = $_POST['specify'] ?? '';
$facility_id = $_POST['facility_id'] ?? '';
$staff_id = $_POST['staff_id'] ?? '';

if (empty($date) || empty($drug) || empty($changes) || empty($reason)) {
    echo json_encode(["status" => "error", "message" => "All fields except 'Specify' are required!"]);
    exit;
}

if ($id) {
    // Update existing record
    $user->updateRecord('treatment_changes', array(
        'diagnosis_id' => $diagnosis_id,  // You can replace this with a dynamic value
        'enrollment_id' => $enrollment_id,  // You can replace this with a dynamic value
        'date' => $date,
        'drug' => $drug,
        'changes' => $changes,
        'reason' => $reason,
        'specify' => $specify,
        'status' => 1,
        'facility_id' => $facility_id,  // You can replace this with a dynamic value
        'update_id' => $staff_id,  // You can replace this with a dynamic value
        'update_on' => date('Y-m-d H:i:s'),  // You can replace this with a dynamic value
    ), $id);

    echo json_encode(["status" => "success", "message" => "Updated successfully!"]);
} else {
    // Insert new record
    $user->createRecord('treatment_changes', array(
        'diagnosis_id' => $diagnosis_id,  // You can replace this with a dynamic value
        'enrollment_id' => $enrollment_id,  // You can replace this with a dynamic value
        'date' => $date,
        'drug' => $drug,
        'changes' => $changes,
        'reason' => $reason,
        'specify' => $specify,
        'status' => 1,
        'facility_id' => $facility_id,  // You can replace this with a dynamic value
        'staff_id' => $staff_id,  // You can replace this with a dynamic value
        'update_id' => $staff_id,  // You can replace this with a dynamic value
        'create_on' => date('Y-m-d H:i:s'),  // You can replace this with a dynamic value
        'update_on' => date('Y-m-d H:i:s'),  // You can replace this with a dynamic value
    ));

    $insert_id = $override->getlastRow('treatment_changes', 'status', 1, 'id');
    echo json_encode(["status" => "success", "message" => "Saved successfully!", "new_id" => $insert_id]);
}
?>



