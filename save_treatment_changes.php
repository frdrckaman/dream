<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once 'php/core/init.php';
    $user = new User();
    $override = new OverideData();
    $email = new Email();
    $random = new Random();

    $users = $override->getData('user');

    $ids = $_POST['id'];
    $dates = $_POST['date'];
    $drugs = $_POST['drug'];
    $changes = $_POST['changes'];
    $reasons = $_POST['reason'];
    $specify = $_POST['specify'];

    for ($i = 0; $i < count($dates); $i++) {
        $date = $dates[$i];
        $date = $dates[$i];
        $drug = $drugs[$i];
        $change = $changes[$i];
        $reason = $reasons[$i];
        $specify_value = !empty($specify[$i]) ? $specify[$i] : NULL;
        $enrollment_id = $enrollment_id[$i];
        $facility_id = $facility_id[$i];

        if ($id) {
            // Update existing record
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
            $successMessage = 'Account locked Successful';
        } else {
            // Insert new record
            $user->createRecord('treatment_changes', array(
                'diagnosis_id' => 1,
                'date' => $date,
                'drug' => $drug,
                'changes' => $change,
                'reason' => $reason,
                'specify' => $specify_value,
                'enrollment_id' => 1,
                'status' => 1,
                'facility_id' => 1,
            ));
            $successMessage = 'Account locked Successful';
        }

        echo "Treatment changes saved successfully!";
    }

    echo "Success";
}
?>