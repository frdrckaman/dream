<?php

require 'pdf.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

if ($user->isLoggedIn()) {
    try {
        $eligible = $override->getNews('history', 'status', 1, 'eligible', 1);
        $Total = $override->getCount1('history', 'status', 1, 'eligible', 1);
        $data_enrolled = $override->getCount('results', 'status', 1);
        $successMessage = 'Report Successful Created';
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    Redirect::to('index.php');
}


$title = 'LUNG CANCER SUMMARY REPORT ' . date('Y-m-d');

$title1 = 'LUNG CANCER SUMMARY REPORT ' . date('Y-m-d');

$title2 = 'LUNG CANCER SCREENING ELIGIBLE LIST';

$pdf = new Pdf();

// $title = 'NIMREGENIN SUMMARY REPORT_'. date('Y-m-d');
$file_name = $title . '.pdf';

$output = ' ';

$output .= '
    <table width="100%" border="1" cellpadding="5" cellspacing="0">
        <tr>
            <td colspan="22" align="center" style="font-size: 18px">
                <b>' . $title . '</b>
            </td>
        </tr>
        <tr>
            <td colspan="22" align="center" style="font-size: 18px">
                <b>Total Eligible (' . $Total . '): Called and Results Entered(' . $data_enrolled . ')</b>
            </td>
        </tr>
        <tr>
            <th colspan="8">Site</th>
            <th colspan="5">Total Eligible</th>
            <th colspan="5">Results Entered</th>
            <th colspan="4">Pending Results</th>
        </tr>
';

// Initialize totals
$totalEligible = 0;
$totalEnrolled = 0;
$totalPending = 0;

// Fetch the data for each site
$sites = $override->get('sites', 'status', 1); // Assuming sites table holds site data
foreach ($sites as $site) {
    // Calculate totals for each site
    $siteEligible = $override->countData1('history', 'status', 1, 'site_id', $site['id'], 'eligible', 1);
    $siteEnrolled = $override->countData('results', 'site_id', $site['id'], 'status', 1);
    $sitePending = $siteEligible - $siteEnrolled;

    // Add to overall totals
    $totalEligible += $siteEligible;
    $totalEnrolled += $siteEnrolled;
    $totalPending += $sitePending;

    $output .= '
        <tr>
            <td colspan="8">' . $site['name'] . '</td>
            <td colspan="5">' . $siteEligible . '</td>
            <td colspan="5">' . $siteEnrolled . '</td>
            <td colspan="4">' . $sitePending . '</td>
        </tr>
    ';
}

// Add totals row
$output .= '
        <tr style="font-weight: bold; background-color: #f2f2f2;">
            <td colspan="8">Total</td>
            <td colspan="5">' . $totalEligible . '</td>
            <td colspan="5">' . $totalEnrolled . '</td>
            <td colspan="4">' . $totalPending . '</td>
        </tr>
';

$output .= '</table>';

// Add line break between the tables
$output .= '<br><br>';

$output .= '
    <table width="100%" border="1" cellpadding="5" cellspacing="0">
            <tr>
            <td colspan="22" align="center" style="font-size: 18px">
                <b>' . $title2 . '</b>
            </td>
        </tr>
        <tr>
            <th colspan="1">No.</th>
            <th colspan="3">PID</th>
            <th colspan="2">NAME</th>
            <th colspan="2">Sex</th>
            <th colspan="2">Age</th>
            <th colspan="2">Pack Year</th>
            <th colspan="2">Site</th>
            <th colspan="2">Phone</th>
            <th colspan="2">Phone2</th>
            <th colspan="2">Call Status</th>
            <th colspan="2">Results</th>
        </tr>
';

// Add the detailed patient data
$x = 1;
foreach ($eligible as $client) {
    $results = $override->getNews('results', 'status', 1, 'patient_id', $client['patient_id']);

    if ($results) {
        $calls = 'Called';
        $results_data = 'Entered';
        $call_status_color = 'green';
        $result_color = 'green';
    } else {
        $calls = 'NOT Called';
        $results_data = 'NOT Entered';
        $call_status_color = 'red';
        $result_color = 'red';
    }

    $clients = $override->get('clients', 'id', $client['patient_id'])[0];
    $site = $override->get('sites', 'id', $client['site_id'])[0];
    $gender = $override->get('sex', 'id', $clients['sex'])[0];

    $output .= '
        <tr>
            <td colspan="1">' . $x . '</td>
            <td colspan="3">' . $client['study_id'] . '</td>
            <td colspan="2">' . $clients['firstname'] . ' - ' . $clients['lastname'] . '</td>
            <td colspan="2">' . $gender['name'] . '</td>
            <td colspan="2">' . $clients['age'] . '</td>
            <td colspan="2">' . $client['pack_year'] . '</td>
            <td colspan="2">' . $site['name'] . '</td>
            <td colspan="2">' . $clients['patient_phone'] . '</td>
            <td colspan="2">' . $clients['patient_phone2'] . '</td>
            <td colspan="2" style="background-color: ' . $call_status_color . '; color: white;">' . $calls . '</td>
            <td colspan="2" style="background-color: ' . $result_color . '; color: white;">' . $results_data . '</td>
        </tr>
    ';

    $x += 1;
}

$output .= '</table>';


// $output = '<html><body><h1>Hello, dompdf!' . $row . '</h1></body></html>';
$pdf->loadHtml($output);

// SetPaper the HTML as PDF
$pdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$pdf->render();

// Output the generated PDF
$pdf->stream($file_name, array("Attachment" => false));
