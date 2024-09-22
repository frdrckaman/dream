<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

$x = 1;

while ($x <= 200) {
    if ($x < 10) {
        $SUB1 = 'DF_SUBS1_TZ_CTRL_00' . $x . '_0' . $x;
    } elseif ($x < 100) {
        $SUB1 = 'DF_SUBS1_TZ_CTRL_0' . $x . '_0' . $x;
    } else {
        $SUB1 = 'DF_SUBS1_TZ_CTRL_' . $x . '_0' . $x;
    }
    if ($x <= 200) {
        $user->createRecord('study_id', array(
            'study_id' => $SUB1,
            'client_id' => 0,
            'site_id' => 1,
            'status' => 0,
        ));
    }
    echo $SUB1;
    $x++;
}
