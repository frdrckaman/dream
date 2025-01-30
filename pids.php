<?php
require_once 'php/core/init.php';

$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

$Substudy = 'DF_TZ_SS2';

for ($facility_id = 1; $facility_id <= 24; $facility_id++) { // Loop through 24 sites
    // Generate study_id dynamically based on site_id and $x
    if ($facility_id < 10) {
        $pid = $Substudy . '_0' . $facility_id;
    } else {
        $pid = $Substudy . '_' . $facility_id;
    }

    // Create a record for each study_id dynamically
    $user->createRecord('pids', array(
        'pid' => $pid,
        'facility_id' => $facility_id,
        'sub_study' => 2,
        'status' => 1,
    ));

    // Print the study_id for debugging or logging purposes
    echo $facility_id . "\n";
}
?>