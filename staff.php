<?php

require 'pdf.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

if ($user->isLoggedIn()) {
    try {
        $site_id = 2;

        $sites = $override->getNews('sites', 'status', 1, 'id', $_GET['site_id'])[0];
        $zones = $override->getNews('zones', 'status', 1, 'id', $sites['zone'])[0];
        $staffs = $override->getNewsASC('user', 'status', 1, 'zone', $_GET['zone'],'zone');
        $staffs_COUNTS = $override->countData('user', 'status', 1, 'zone', $_GET['zone']);

        $successMessage = 'Report Successful Created';
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    Redirect::to('index.php');
}


$pdf = new Pdf();

$title = 'DREAM TOTAL STAFF MWANZA ZONE_'. date('Y-m-d');
$file_name = $title . '.pdf';

$output = ' ';


$output .= '
    <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <td colspan="11" align="center" style="font-size: 18px">
                        <b>' . $title . '</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="11" align="center" style="font-size: 18px">
                        <b>Total Staffs ( ' . $staffs_COUNTS . ' ) </b>
                    </td>
                </tr>    
                <tr>
                    <th colspan="1">No.</th>
                    <th colspan="2">First Name</th>
                    <th colspan="2">Middle Name</th>
                    <th colspan="2">Last Name</th>    
                    <th colspan="2">SITE</th>   
                    <th colspan="2">ZONE</th>   
                </tr>
    
     ';

// Load HTML content into dompdf
$x = 1;
foreach ($staffs as $client) {

    $sites = $override->get('sites', 'id', $client['site_id'])[0];
    $zones = $override->get('zones', 'id', $_GET['zone'])[0];



    $output .= '
         <tr>
            <td colspan="1">' . $x . '</td>
            <td colspan="2">' . $client['firstname'] . '</td>
            <td colspan="2">' . $client['middlename'] . '</td>
            <td colspan="2">' . $client['lastname'] . '</td>
            <td colspan="2">' . $sites['name'] . '</td>
            <td colspan="2">' . $zones['name'] . '</td>
        </tr>
        ';

    $x += 1;
}

$output .= '
        </table>  
    ';





// $output = '<html><body><h1>Hello, dompdf!' . $row . '</h1></body></html>';
$pdf->loadHtml($output);

// SetPaper the HTML as PDF
$pdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$pdf->render();

// Output the generated PDF
$pdf->stream($file_name, array("Attachment" => false));
