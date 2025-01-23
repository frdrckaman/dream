<?php
require_once 'php/core/init.php';

$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

$Substudy = 'DF_TZ_SS2';

for ($site_id = 1; $site_id <= 24; $site_id++) { // Loop through 24 sites
    for ($x = 1; $x <= 50; $x++) { // Generate 50 IDs for each site
        // Generate study_id dynamically based on site_id and $x
        if ($x < 10) {
            if ($site_id < 10) {
                $study_id = $Substudy . '_0' . $site_id . '-00' . $x;
            } else {
                $study_id = $Substudy . '_' . $site_id . '-00' . $x;
            }
        } elseif ($x < 100) {
            if ($site_id < 10) {
                $study_id = $Substudy . '_0' . $site_id . '-0' . $x;
            } else {
                $study_id = $Substudy . '_' . $site_id . '-0' . $x;
            }
        }

        // Create a record for each study_id dynamically
        $user->createRecord('study_id', array(
            'study_id' => $study_id,
            'client_id' => 0,
            'site_id' => $site_id,
            'status' => 0,
        ));

        // Print the study_id for debugging or logging purposes
        echo $study_id . "\n";
    }
}
?>