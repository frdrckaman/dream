<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $sql = "DELETE FROM regimen_changes WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Deleted";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
