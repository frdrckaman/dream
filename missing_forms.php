<?php

require 'pdf.php';
$user = new User();
$override = new OverideData();

if ($user->isLoggedIn()) {
    try {
        $data = $override->getOrderBy('screening', 'status', 1);
        $successMessage = 'Report Successfully Created';
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    Redirect::to('index.php');
}

$pdf = new Pdf();
$title = 'Patient Missing Forms Report';
$file_name = $title . '_' . date('Y-m-d') . '.pdf';

$output = '
<html>
    <head>
        <style>
            @page { margin: 50px;}
            header { position: fixed; top: -50px; left: 0px; right: 0px; height: 100px;}
            footer { position: fixed; bottom: -50px; left: 0px; right: 0px; height: 50px; }

            table { border-collapse: collapse; width: 100%; font-size: 12px; }
            th, td { border: 1px solid black; padding: 5px; text-align: center; }
            th { background: #eee; }
            .missing { color: red; font-weight: bold; }
            .summary { font-weight: bold; background: #f0f0f0; }
        </style>
    </head>
    <body>
        <header>
            <div class="reportTitle">Patient Report</div>
            <div class="tittle">National Institute For Medical Research (NIMR)</div>
            <div class="period">' . date('Y-m-d') . '</div>
        </header>
        <table>
            <tr>
                <th>No.</th>
                <th>PID</th>
                <th>SITE_ID</th>
                <th>ZONE</th>
                <th>ENROLLMENT</th>
                <th>CLINIC_LAB</th>
                <th>DIAGNOSIS</th>
                <th>ZONAL_LAB</th>
            </tr>
';

$counter = 1;
$total_checked = count($data);
$total_missing = 0;

// helper function for check/x
// $mark = function($record) {
//     return !empty($record) ? '✅' : '<span class="missing">❌</span>';
// };

// helper function for DONE / MISSING
$mark = function($record) {
    return !empty($record) ? 'DONE' : '<span class="missing">MISSING</span>';
};


foreach ($data as $value) {
    // $zone = $override->getNews('zones', 'id', $value['zone'], 'status', 1)[0];
    $site = $override->getNews('sites', 'id', $value['facility_id'], 'status', 1)[0];

    $enrollment = $override->getNews('enrollment_form', 'enrollment_id', $value['id'], 'status', 1);
    $clinic_lab = $override->getNews('respiratory', 'enrollment_id', $value['id'], 'status', 1);
    $diagnosis = $override->getNews('diagnosis', 'enrollment_id', $value['id'], 'status', 1);
    $zonal_lab = $override->getNews('diagnosis_test', 'enrollment_id', $value['id'], 'status', 1);

    // include only if at least one form is missing
    if (empty($enrollment) || empty($clinic_lab) || empty($diagnosis) || empty($zonal_lab)) {
        $output .= '
            <tr>
                <td>' . $counter . '</td>
                <td>' . $value['pid'] . '</td>
                <td>' . $site['name'] . '</td>
                <td>' . $zone['name'] . '</td>
                <td>' . $mark($enrollment) . '</td>
                <td>' . $mark($clinic_lab) . '</td>
                <td>' . $mark($diagnosis) . '</td>
                <td>' . $mark($zonal_lab) . '</td>
            </tr>
        ';
        $counter++;
        $total_missing++;
    }
}

// Summary row
$output .= '
            <tr class="summary">
                <td colspan="8">
                    Total Patients Checked: ' . $total_checked . ' | 
                    Patients with Missing Forms: ' . $total_missing . '
                </td>
            </tr>
';

$output .= '
        </table>
    </body>
</html>
';

$pdf->loadHtml($output);
$pdf->setPaper('A4', 'landscape');
$pdf->render();
$pdf->stream($file_name, array("Attachment" => false));
