<?php

require_once 'pdf.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

if ($user->isLoggedIn()) {
    try {
        $site_data = $override->getData('sites');
        $screening = $override->getCount('screening', 'status', 1);
        $eligible = $override->getCount1('screening', 'status', 1, 'eligible', 1);
        $enrollment = $override->getCount('enrollment_form', 'status', 1);

        $successMessage = 'Report Successfully Created';
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    Redirect::to('index.php');
}

$title = 'LUNGCANCER SCREENING SUMMARY REPORT' . date('Y-m-d');
$pdf = new Pdf();
$file_name = $title . '.pdf';
$output = '';

if ($site_data) {
    $output .= '
        <table width="100%" border="1" cellpadding="5" cellspacing="0">
            <tr>
                <td colspan="18" align="center" style="font-size: 18px">
                    <b>' . $title . '</b>
                </td>
            </tr>
            <tr>
                <td colspan="18" align="center" style="font-size: 18px">
                    <b>Total Screening (' . $screening . '): Total Enrolled (' . $enrollment . ')</b>
                </td>
            </tr>
            <tr>
                <td colspan="18">
                    <br />
                    <table width="100%" border="1" cellpadding="5" cellspacing="0">
                        <tr>
                            <th rowspan="2">No.</th>
                            <th rowspan="2">SITE</th>
                            <th rowspan="2">RECRUITED</th>
                            <th rowspan="2">SCREENED</th>
                            <th rowspan="2">ELIGIBLE</th>
                            <th rowspan="2">ENROLLED</th>
                            <th colspan="4">TYPE</th>
                            <th rowspan="2">END</th>
                        </tr>
                        <tr>
                            <th>4A</th>
                            <th>4B</th>
                            <th>4C</th>
                            <th>OTHER</th>
                        </tr>
    ';

    $x = 1;
    foreach ($site_data as $row) {
        // $screened = $override->countData('screening', 'status', 1, 'facility_id', $row['id']);
        // $screened_Total = $override->getCount('screening', 'status', 1);
        // $eligible = $override->countData2('screening', 'status', 1, 'eligible', 1, 'facility_id', $row['id']);
        // $eligible_Total = $override->countData('screening', 'status', 1, 'eligible', 1);
        // // $enrolled = $override->countData('enrollment_form', 'status', 1,  'facility_id', $row['id']);
        // // $enrolled_Total = $override->getCount('enrollment_form', 'status', 1);
        // // $end_study = $override->countData2('diagnosis', 'status', 1, 'tb_otcome2', 1, 'facility_id', $row['id']);
        // // $end_study_Total = $override->countData('diagnosis', 'status', 1, 'tb_otcome2', 1);

        $output .= '
            <tr>
                <td>' . $x . '</td>
                <td>' . $row['name'] . '</td>
                <td align="right">' . $screened . '</td>
                <td align="right">' . $eligible . '</td>
                <td align="right">' . $enrolled . '</td>
                <td align="right">N/A</td>
                <td align="right">N/A</td>
                <td align="right">N/A</td>
                <td align="right">N/A</td>
                <td align="right">' . $end_study . '</td>
            </tr>
        ';
        $x += 1;
    }

    $output .= '
            <tr>
                <td align="right" colspan="2"><b>Total</b></td>
                <td align="right"><b>' . $screened_Total . '</b></td>
                <td align="right"><b>' . $eligible_Total . '</b></td>
                <td align="right"><b>' . $enrolled_Total . '</b></td>
                <td align="right"><b>N/A</b></td>
                <td align="right"><b>N/A</b></td>
                <td align="right"><b>N/A</b></td>
                <td align="right"><b>N/A</b></td>
                <td align="right"><b>' . $end_study_Total . '</b></td>
            </tr>
        </table>
    ';
}

$pdf->loadHtml($output);
$pdf->setPaper('A4', 'landscape');
$pdf->render();
$pdf->stream($file_name, array("Attachment" => false));
