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
$numRec = 10;

if ($user->isLoggedIn()) {
    // Get JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data)) {
        foreach ($data as $entry) {
            $user->createRecord('users', array(
                'name' => $entry["name"],
                'email' => $entry["email"],
            ));
        }
        echo "Data synced successfully";
    } else {
        echo "No data received";
    }

} else {
    Redirect::to('index.php');
}
?>