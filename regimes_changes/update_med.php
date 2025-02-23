<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $date = $_POST['date'];
    $drug = $_POST['drug'];
    $changes = $_POST['changes'];
    $reason = $_POST['reason'];
    $specify = $_POST['specify'];

    $sql = "UPDATE regimen_changes SET date='$date', drug='$drug', changes='$changes', reason='$reason', specify='$specify' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Success";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
