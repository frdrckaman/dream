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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $drug = $_POST['drug'];
    $changes = $_POST['changes'];
    $reason = $_POST['reason'];
    $specify = $_POST['specify'];
    $enrollment_id = $_POST['enrollment_id'];

    // Insert new record
    // $user->createRecord('treatment_changes', array(
    //     'diagnosis_id' => 1,  // You can replace this with a dynamic value
    //     'enrollment_id' => 1,  // You can replace this with a dynamic value
    //     'date' => $date,
    //     'drug' => $drug,
    //     'changes' => $changes,
    //     'reason' => $reason,
    //     'specify' => $specify,
    //     'status' => 1,
    //     'facility_id' => 1,  // You can replace this with a dynamic value
    //     'staff_id' => 1,  // You can replace this with a dynamic value
    //     'update_id' => 1,  // You can replace this with a dynamic value
    //     'create_on' => date('Y-m-d H:i:s'),  // You can replace this with a dynamic value
    //     'update_on' => date('Y-m-d H:i:s'),  // You can replace this with a dynamic value
    // ));

    echo 'hi';

}
?>