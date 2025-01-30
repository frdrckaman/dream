<?php

require 'pdf.php';

$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

if ($user->isLoggedIn()) {
    try {
        $pids = $override->getData('study_id');
        $pid_Total = $override->getNo('study_id');
        $successMessage = 'Report Successfully Created';
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    Redirect::to('index.php');
}

$title = 'LIST OF DREAM NANOPORE PIDs ' . date('Y-m-d');

$pdf = new Pdf();
$file_name = $title . '.pdf';

$output = '';

$output .= '
    <table width="100%" border="1" cellpadding="5" cellspacing="0">
        <tr>
            <td colspan="4" align="center" style="font-size: 18px">
                <b>' . $title . ' | Total PIDs: ' . $pid_Total . '</b>
            </td>
        </tr>
        <tr>
            <th>PID</th>
            <th>PID</th>
            <th>PID</th>
            <th>PID</th>
        </tr>
';

// Add the detailed patient data
$pid_count = count($pids);
for ($i = 0; $i < $pid_count; $i += 4) {
    $output .= '<tr>';
    // Display up to four PIDs in each row
    for ($j = 0; $j < 4; $j++) {
        if (isset($pids[$i + $j])) {
            $output .= '<td>' . $pids[$i + $j]['study_id'] . '</td>';
        } else {
            $output .= '<td></td>'; // Empty cell if no more PIDs
        }
    }
    $output .= '</tr>';
}

$output .= '</table>';

$pdf->loadHtml($output);
$pdf->setPaper('A4', 'landscape');
$pdf->render();
$pdf->stream($file_name, array("Attachment" => false));
