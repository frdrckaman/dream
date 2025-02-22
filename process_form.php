<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$validate = new validate();

$successMessage = null;
$pageError = null;
$errorMessage = null;
$numRec = 5;
if ($user->isLoggedIn()) {
    if (Input::exists('post')) {
        if (Input::get('add_drug_changes')) {

            // Get form data
            $date = $_POST['date'];
            $drug = $_POST['drug'];
            $changes = $_POST['changes'];
            $reason = $_POST['reason'];
            $specify = $_POST['specify'];
            $enrollment_id = $_POST['enrollment_id'];

            // Insert into database
            $query = "INSERT INTO regimen_changes (enrollment_id, date, drug, changes, reason, specify) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("isssss", $enrollment_id, $date, $drug, $changes, $reason, $specify);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to save data"]);
            }

            $stmt->close();
            $conn->close();

            $successMessage = 'Regimen Changes Added Successful';

        } elseif (Input::get('update_drug_changes')) {

            $user->updateRecord('treatment_changes', array(
                'enrollment_id' => $_GET['sid'],  // You can replace this with a dynamic value
                'date' => Input::get('date'),
                'drug' => Input::get('drug'),
                'changes' => Input::get('changes'),
                'reason' => Input::get('reason'),
                'specify' => Input::get('specify'),
                'status' => 1,
                'facility_id' => $_GET['facility_id'],  // You can replace this with a dynamic value
                'update_id' => $user->data()->site_id,  // You can replace this with a dynamic value
                'update_on' => date('Y-m-d H:i:s'),  // You can replace this with a dynamic value
            ), Input::get('id'));

            $successMessage = 'Regimen Changes Updated Successful';
        } elseif (Input::get('delete_drug_changes')) {
            $user->updateRecord('treatment_changes', array(
                'status' => 0,
            ), Input::get('id'));
            $successMessage = 'Regimen Changes Deleted Successful';
        } elseif (Input::get('add_drug_changes2')) {

            $user->createRecord('treatment_changes', array(
                'diagnosis_id' => "",  // You can replace this with a dynamic value
                'enrollment_id' => $_GET['sid'],  // You can replace this with a dynamic value
                'date' => Input::get('date'),
                'drug' => Input::get('drug'),
                'changes' => Input::get('changes'),
                'reason' => Input::get('reason'),
                'specify' => Input::get('specify'),
                'status' => 1,
                'facility_id' => $_GET['facility_id'],  // You can replace this with a dynamic value
                'staff_id' => $user->data()->site_id,  // You can replace this with a dynamic value
                'update_id' => $user->data()->site_id,  // You can replace this with a dynamic value
                'create_on' => date('Y-m-d H:i:s'),  // You can replace this with a dynamic value
                'update_on' => date('Y-m-d H:i:s'),  // You can replace this with a dynamic value
            ));

            $successMessage = 'Regimen Changes Added Successful';

        }
    }
} else {
    Redirect::to('index.php');
}
?>