<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

$data = json_decode(file_get_contents("php://input"), true);
$response = ['message' => 'No changes saved.'];

if (!empty($data)) {
    foreach ($data as $row) {
        if (!empty($row['id'])) {
            // Update existing record
            $user->updateRecord('treatment_changes', array(
                'date' => $row['date'],
                'drug' => $row['drug'],
                'change_type' => $row['change_type'],
                'reason' => $row['reason'],
                'other_reason' => $row['other_reason'],
                'sid' => $row['sid'],
                'diagnosis_completness' => 1,
                'diagnosis_completed_by' => $user->data()->id,
                'diagnosis_completed_date' => 1,
                'diagnosis_verified_by' => $user->data()->id,
                'diagnosis_verified_date' => 1,
                'status' => 1,
                'enrollment_id' => $_GET['sid'],
                'create_on' => date('Y-m-d H:i:s'),
                'staff_id' => $user->data()->id,
                'update_on' => date('Y-m-d H:i:s'),
                'update_id' => $user->data()->id,
                'facility_id' => $row['facility_id'],
            ), $row['id']);
            $successMessage = 'Position Successful Updated';
        } else {
            // Insert new record
            $user->createRecord('treatment_changes', array(
                'date' => $row['date'],
                'drug' => $row['drug'],
                'change_type' => $row['change_type'],
                'reason' => $row['reason'],
                'other_reason' => $row['other_reason'],
                'sid' => $row['sid'],
                'diagnosis_completness' => 1,
                'diagnosis_completed_by' => $user->data()->id,
                'diagnosis_completed_date' => 1,
                'diagnosis_verified_by' => $user->data()->id,
                'diagnosis_verified_date' => 1,
                'status' => 1,
                'enrollment_id' => $_GET['sid'],
                'create_on' => date('Y-m-d H:i:s'),
                'staff_id' => $user->data()->id,
                'update_on' => date('Y-m-d H:i:s'),
                'update_id' => $user->data()->id,
                'facility_id' => $row['facility_id'],
            ));
            $successMessage = 'Position Successful Added';
        }
    }
    $response['message'] = 'Changes saved successfully!';
}

echo json_encode($response);
?>