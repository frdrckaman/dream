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

// helper function for DONE / MISSING
$mark = function($record) {
    return !empty($record) ? 'DONE' : '<span class="missing">MISSING</span>';
};

// Calculate missing counts per zone and facility
$zone_summary = []; // [zone_name][facility_name] => ['enrollment'=>0, 'clinic_lab'=>0, 'diagnosis'=>0, 'zonal_lab'=>0, 'screened'=>0]
$total_missing_summary = ['enrollment'=>0, 'clinic_lab'=>0, 'diagnosis'=>0, 'zonal_lab'=>0, 'screened'=>0];
$max_missing_total = 0;

foreach ($data as $value) {
    $zone = $override->getNews('zones', 'id', $value['zone'], 'status', 1)[0];
    $site = $override->getNews('sites', 'id', $value['facility_id'], 'status', 1)[0];

    $enrollment = $override->getNews('enrollment_form', 'enrollment_id', $value['id'], 'status', 1);
    $clinic_lab = $override->getNews('respiratory', 'enrollment_id', $value['id'], 'status', 1);
    $diagnosis = $override->getNews('diagnosis', 'enrollment_id', $value['id'], 'status', 1);
    $zonal_lab = $override->getNews('diagnosis_test', 'enrollment_id', $value['id'], 'status', 1);

    $zone_name = $zone['name'];
    $facility_name = $site['name'];

    if (!isset($zone_summary[$zone_name])) $zone_summary[$zone_name] = [];
    if (!isset($zone_summary[$zone_name][$facility_name])) {
        $zone_summary[$zone_name][$facility_name] = [
            'enrollment' => 0,
            'clinic_lab' => 0,
            'diagnosis' => 0,
            'zonal_lab' => 0,
            'screened' => 0
        ];
    }

    // count total screened
    $zone_summary[$zone_name][$facility_name]['screened']++;
    $total_missing_summary['screened']++;

    // count missing
    if (empty($enrollment)) {
        $zone_summary[$zone_name][$facility_name]['enrollment']++;
        $total_missing_summary['enrollment']++;
    }
    if (empty($clinic_lab)) {
        $zone_summary[$zone_name][$facility_name]['clinic_lab']++;
        $total_missing_summary['clinic_lab']++;
    }
    if (empty($diagnosis)) {
        $zone_summary[$zone_name][$facility_name]['diagnosis']++;
        $total_missing_summary['diagnosis']++;
    }
    if (empty($zonal_lab)) {
        $zone_summary[$zone_name][$facility_name]['zonal_lab']++;
        $total_missing_summary['zonal_lab']++;
    }

    // calculate total missing per facility for highlighting
    $facility_missing_total = $zone_summary[$zone_name][$facility_name]['enrollment'] +
                              $zone_summary[$zone_name][$facility_name]['clinic_lab'] +
                              $zone_summary[$zone_name][$facility_name]['diagnosis'] +
                              $zone_summary[$zone_name][$facility_name]['zonal_lab'];

    if ($facility_missing_total > $max_missing_total) {
        $max_missing_total = $facility_missing_total;
    }
}

// Start HTML output
$output = '
<html>
    <head>
        <style>
            @page { margin: 50px;}
            header { position: fixed; top: -50px; left: 0px; right: 0px; height: 100px;}
            footer { position: fixed; bottom: -50px; left: 0px; right: 0px; height: 50px; }

            table { border-collapse: collapse; width: 100%; font-size: 12px; margin-bottom:20px; }
            th, td { border: 1px solid black; padding: 5px; text-align: center; }
            th { background: #eee; }
            .missing { color: red; font-weight: bold; }
            .summary { font-weight: bold; background: #f0f0f0; }
            .highlight { background: #ffcccc; font-weight:bold; }
        </style>
    </head>
    <body>
        <header>
            <div class="reportTitle">Patient Report</div>
            <div class="tittle">National Institute For Medical Research (NIMR)</div>
            <div class="period">' . date('Y-m-d') . '</div>
        </header>
';

// Zone & Facility summary table
$output .= '
<h3>Missing Forms Summary by Zone & Facility</h3>
<table>
    <tr>
        <th>ZONE</th>
        <th>FACILITY ID</th>
        <th>SCREENED</th>
        <th>ENROLLMENT MISSING</th>
        <th>CLINIC LAB MISSING</th>
        <th>DIAGNOSIS MISSING</th>
        <th>ZONAL LAB MISSING</th>
    </tr>
';

foreach ($zone_summary as $zone_name => $facilities) {
    foreach ($facilities as $facility_name => $counts) {
        $facility_missing_total = $counts['enrollment'] + $counts['clinic_lab'] + $counts['diagnosis'] + $counts['zonal_lab'];
        $highlight_class = ($facility_missing_total == $max_missing_total) ? 'highlight' : '';
        $output .= '
        <tr class="' . $highlight_class . '">
            <td>' . $zone_name . '</td>
            <td>' . $facility_name . '</td>
            <td>' . $counts['screened'] . '</td>
            <td>' . $counts['enrollment'] . '</td>
            <td>' . $counts['clinic_lab'] . '</td>
            <td>' . $counts['diagnosis'] . '</td>
            <td>' . $counts['zonal_lab'] . '</td>
        </tr>
        ';
    }
}

// Add total row
$output .= '
<tr class="summary">
    <td colspan="2">TOTAL MISSING</td>
    <td>' . $total_missing_summary['screened'] . '</td>
    <td>' . $total_missing_summary['enrollment'] . '</td>
    <td>' . $total_missing_summary['clinic_lab'] . '</td>
    <td>' . $total_missing_summary['diagnosis'] . '</td>
    <td>' . $total_missing_summary['zonal_lab'] . '</td>
</tr>
';

$output .= '</table>';

// Detailed patient table
$output .= '
<h3>Detailed Patient Missing Forms</h3>
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

foreach ($data as $value) {
    $zone = $override->getNews('zones', 'id', $value['zone'], 'status', 1)[0];
    $site = $override->getNews('sites', 'id', $value['facility_id'], 'status', 1)[0];

    $enrollment = $override->getNews('enrollment_form', 'enrollment_id', $value['id'], 'status', 1);
    $clinic_lab = $override->getNews('respiratory', 'enrollment_id', $value['id'], 'status', 1);
    $diagnosis = $override->getNews('diagnosis', 'enrollment_id', $value['id'], 'status', 1);
    $zonal_lab = $override->getNews('diagnosis_test', 'enrollment_id', $value['id'], 'status', 1);

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

$output .= '</table>
</body>
</html>
';

$pdf->loadHtml($output);
$pdf->setPaper('A4', 'landscape');
$pdf->render();
$pdf->stream($file_name, ["Attachment" => false]);