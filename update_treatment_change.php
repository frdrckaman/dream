<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

$users = $override->getData('user');
$sites = $override->getData('sites');


$id = $_POST['id'];
$date = $_POST['date'];
$drug = $_POST['drug'];
$changes = $_POST['changes'];
$reason = $_POST['reason'];
$specify = $_POST['specify'];

$user->updateRecord('treatment_changes', array(
    'diagnosis_id' => 1,
    'date' => $date,
    'drug' => $drug,
    'changes' => $change,
    'reason' => $reason,
    'specify' => $specify_value,
    'enrollment_id' => 1,
    'status' => 1,
    'facility_id' => 1,
), $id);

echo json_encode(["message" => "Update successful"]);
?>
