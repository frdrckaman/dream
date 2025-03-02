<?php
require_once 'init.php'; // Include your initialization file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $drug = $_POST['drug'];
    $changes = $_POST['changes'];
    $reason = $_POST['reason'];
    $specify = $_POST['specify'];
    $enrollment_id = $_POST['enrollment_id'];

    // Insert the new record into the database
    $user->createRecord('treatment_changes', array(
        'date' => $date,
        'drug' => $drug,
        'changes' => $changes,
        'reason' => $reason,
        'specify' => $specify,
        'enrollment_id' => $enrollment_id,
        'status' => 1
    ));

    // Fetch the updated table rows
    $treatments = $override->getNewsAs2('treatment_changes', 'enrollment_id', $enrollment_id, 'status', 1);
    $x = 1;
    foreach ($treatments as $treatment) {
        $changes = $override->getNews('regimen_changes', 'status', 1, 'id', $treatment['changes'])[0];
        $reasons = $override->getNews('regimen_changes_reasons', 'status', 1, 'id', $treatment['reason'])[0];
        $sites = $override->getNews('sites', 'status', 1, 'id', $treatment['facility_id'])[0];
        echo "<tr>
                <td>{$x} / <hr> {$treatment['date']}</td>
                <td>{$treatment['drug']}</td>
                <td>{$changes['name']}</td>
                <td>{$reasons['name']}</td>
                <td>{$treatment['specify']}</td>
                <td>
                    <span class='badge bg-info'>
                        <a href='#update_med{$treatment['id']}' role='button' data-toggle='modal'>Update</a>
                    </span>
                    <br>
                    <hr>
                    <span class='badge bg-danger'>
                        <a href='#delete_med{$treatment['id']}' role='button' data-toggle='modal'>Delete</a>
                    </span>
                </td>
              </tr>";
        $x++;
    }
}