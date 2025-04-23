<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$validate = new validate();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

$table = $_GET['table'];
$ext = $_GET['ext'];
$file = $table;

// Specify columns to omit (use field names from your database)
$omitColumns = [
    // 'REGISTRATION'
    'id',
    'firstname',
    'middlename',
    'lastname',
    'study_id',
    'age2',
    'region',
    'location',
    'house_number',
    'comments',
    'screened',
    'eligible',
    'status',
    'enrolled',
    'end_study',
    'create_on',
    'staff_id',
    'update_on',
    'update_id',
    'visit_date',
    // 'ELIGIBLITY'
    'patient_id',
    // 'RISK'
    'sequence',
    'visit_code',
    'covid19',
    'vaccine_covid19',
    'risk_factors_complete_date',
    // 'HIV'
    'hiv_history_and_medication_complete_date',
    // 'CHRONIC'
    'chronic_illnesses_specify_complete_date',
    // 'LAB'
    'laboratory_results_complete_date',
    // 'RADIOLOGY'
    'uploads',
    'uploads1',
    'uploads2',
    'uploads3',
    'uploads4',
    'radiological_investigations_complete_date'
]; // Example: omit 'email' and 'password' columns

// Fetch results from the database
$result = $override->get($table, 'status', 1);

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set the column headers
$columns = array();
$columnIndex = 'A';

if (count($result) > 0) {
    // Fetch the field names from the first row
    $fieldinfo = array_keys($result[0]);

    // Create a new array to hold the actual columns to be included
    $includedColumns = [];

    foreach ($fieldinfo as $fieldname) {
        // Only include the header if it's not in the omit list and exists in the results
        if (!in_array($fieldname, $omitColumns)) {
            $sheet->setCellValue($columnIndex . '1', $fieldname);
            $includedColumns[$columnIndex] = $fieldname; // Save the column mapping
            $columnIndex++;
        }
    }

    // Fill data
    $rowNumber = 2; // Start on the second row after headers
    foreach ($result as $row) {
        $columnIndex = 'A';
        foreach ($includedColumns as $column) {
            // Check if the column exists in the row before trying to set the value
            if (array_key_exists($column, $row)) {
                $sheet->setCellValue($columnIndex . $rowNumber, $row[$column]);
            }
            $columnIndex++;
        }
        $rowNumber++;
    }
}

// Set the appropriate writer based on the file extension
$filename = $file . '.' . $ext;

switch ($ext) {
    case 'xlsx':
        $writer = new Xlsx($spreadsheet); // Use the correct namespace
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        break;
    case 'xls':
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet); // For XLS files (use Xlsx as PhpSpreadsheet does not support native XLS)
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet); // Use Xls writer for .xls files
        header('Content-Type: application/vnd.ms-excel');
        break;
    case 'csv':
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet); // For CSV files
        header('Content-Type: text/csv');
        break;
    default:
        throw new Exception('Unsupported file format');
}

// Set the download headers
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit();
