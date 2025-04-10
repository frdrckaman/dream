<?php

require_once 'pdf.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

if ($user->isLoggedIn()) {
    try {
        $site_data = $override->get('sites','status',1);
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

$title = 'NANOPORE STUDY PROGRESS SUMMARY REPORT ' . date('Y-m-d');
$pdf = new Pdf();
$file_name = $title . '.pdf';
$output = '';

if ($site_data) {
    $output .= '<table width="100%" border="1" cellpadding="5" cellspacing="0">
        <tr>
            <td colspan="6" align="center" style="font-size: 18px">
                <b>' . $title . '</b>
            </td>
        </tr>
        <tr>
            <td colspan="6" align="center" style="font-size: 18px">
                <b>Total Screening (' . $screening . '): Total Enrolled (' . $enrollment . ')</b>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <br />
                <table width="100%" border="1" cellpadding="5" cellspacing="0">
                    <tr>
                        <th>No.</th>
                        <th>SITE</th>
                        <th>SCREENED</th>
                        <th>ELIGIBLE</th>
                        <th>ENROLLED</th>
                        <th>END</th>
                    </tr>';

    $x = 1;
    foreach ($site_data as $row) {
        $screened = $override->countData('screening', 'status', 1, 'facility_id', $row['id']);
        $screened_Total = $override->getCount('screening', 'status', 1);
        $eligible = $override->countData1('screening', 'status', 1, 'eligible', 1, 'facility_id', $row['id']);
        $eligible_Total = $override->countData('screening', 'status', 1, 'eligible', 1);
        $enrolled = $override->countData('enrollment_form', 'status', 1, 'facility_id', $row['id']);
        $enrolled_Total = $override->getCount('enrollment_form', 'status', 1);
        $end_study = $override->countData1('diagnosis', 'status', 1, 'tb_otcome2', 1, 'facility_id', $row['id']);
        $end_study_Total = $override->countData('diagnosis', 'status', 1, 'tb_otcome2', 1);

        $output .= '<tr>
            <td>' . $x . '</td>
            <td>' . $row['name'] . '</td>
            <td align="right">' . $screened . '</td>
            <td align="right">' . $eligible . '</td>
            <td align="right">' . $enrolled . '</td>
            <td align="right">' . $end_study . '</td>
        </tr>';
        $x += 1;
    }

    $output .= '<tr>
        <td align="right" colspan="2"><b>Total</b></td>
        <td align="right"><b>' . $screened_Total . '</b></td>
        <td align="right"><b>' . $eligible_Total . '</b></td>
        <td align="right"><b>' . $enrolled_Total . '</b></td>
        <td align="right"><b>' . $end_study_Total . '</b></td>
    </tr>
    </table>
    </td>
    </tr>
    </table>';
}

$pdf->loadHtml($output);
$pdf->setPaper('A4', 'landscape');
$pdf->render();
$pdf->stream($file_name, array("Attachment" => false));
