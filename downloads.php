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
if ($table == 'screening') {
    $file = $table . '_form';
} elseif ($table == 'enrollment_form') {
    $file = 'enrollment_form';
} elseif ($table == 'respiratory') {
    $file = 'clinic_lab_form';
} elseif ($table == 'diagnosis_test') {
    $file = 'zonal_lab_form';
} elseif ($table == 'diagnosis') {
    $file = $table . '_form';
} 
$ext = $_GET['ext'];
// $file = $table . '_form';

// Specify columns to omit (use field names from your database)
$omitColumns = [
    // 'REGISTRATION'
    'pid1',
    'pid2',
    // 'sex',
    // 'dob',
    // 'age',
    'form_status',
    'date_completed',
    'completed_by',
    'date_verified',
    'verified_by',
    'status',
    'create_on',
    'staff_id',
    'update_on',
    'update_id',
    'region',
    'district',
    'ward',
    'village_street',
    'relapse_years',
    'immunosuppressive',
    'immunosuppressive_diseases',
    'immunosuppressive_specify',
    'sequencing_sample_date',
    'sequencing_sample_type',
    'other_samples',
    'sputum_samples',
    'pleural_fluid_date',
    'csf_date',
    'peritoneal_fluid_date',
    'pericardial_fluid_date',
    'lymph_node_aspirate_date',
    'stool_date',
    'sputum_samples_other',
    'sputum_samples_date',
    'chest_x_ray',
    'chest_x_ray_date',
    'entry_date',
    'tb_regimen_based',
    'tb_regimen_based_other',
    'regimen_changed_other',
    'regimen_changed__date',
    'regimen_removed_name',
    'regimen_added_name',
    'regimen_changed__reason',
    'laboratory_test_used',
    'laboratory_test_used2',
    'laboratory_test_used_date',
    'form_status',
    'zone'
    // 'laboratory_test_used2',   
]; // Example: omit 'email' and 'password' columns

// Fetch results from the database
if ($table == 'ALL') {
    $result = $override->get($table, 'status', 1);
} else if ($table == 'TREATMENT') {
    $result = $override->get($table, 'status', 1);
} 
else {
    $result = $override->get($table, 'status', 1);
}

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
