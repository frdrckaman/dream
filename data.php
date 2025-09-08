<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$validate = new validate();

$successMessage = null;
$pageError = null;
$errorMessage = null;

$numRec = 10;

// require 'vendor/autoload.php';

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// $spreadsheet = new Spreadsheet();
// $sheet = $spreadsheet->getActiveSheet();


if ($user->isLoggedIn()) {
    if (Input::exists('post')) {
        $validate = new validate();

        if (Input::get('delete_record')) {
            $user->updateRecord($_GET['table'], array(
                'status' => 0,
            ), Input::get('id'));
            $successMessage = 'Recored Deleted Successful';
        }

        if (Input::get('restore_record')) {
            $user->updateRecord($_GET['table'], array(
                'status' => 1,
            ), Input::get('id'));
            $successMessage = 'Recored Restored Successful';
        }

        if (Input::get('search_by_site')) {
            $validate = new validate();
            $validate = $validate->check($_POST, array(
                'facility_id' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                // id = 2 & status = 1 & data = 1 & table = clients
                $url = 'data.php?id=' . $_GET['id'] . '&status=' . $_GET['status'] . '&data=' . $_GET['data'] . '&table=' . $_GET['table'] . '&page=' . $_GET['page'] . '&facility_id=' . Input::get('facility_id');
                Redirect::to($url);
                $pageError = $validate->errors();
            }
        }

        // if (Input::get('download_xls')) {
        //     $validate = new validate();
        //     $validate = $validate->check($_POST, array(
        //         'table' => array(
        //             'required' => true,
        //         ),
        //     ));
        //     if ($validate->passed()) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['download_xls'])) {
                $ext = 'xls';
                $url = 'downloads.php?table=' . Input::get('table') . '&ext=' . $ext;
                Redirect::to($url);
                $pageError = $validate->errors();
            } else if (isset($_POST['download_xlsx'])) {
                $ext = 'xlsx';
                $url = 'downloads.php?table=' . Input::get('table') . '&ext=' . $ext;
                Redirect::to($url);
                $pageError = $validate->errors();
            } else if (isset($_POST['download_csv'])) {
                $ext = 'csv';
                $url = 'downloads.php?table=' . Input::get('table') . '&ext=' . $ext;
                Redirect::to($url);
                $pageError = $validate->errors();
            } else if (isset($_POST['download_stata'])) {
                $ext = 'dta';
                $url = 'downloads.php?table=' . Input::get('table') . '&ext=' . $ext;
                Redirect::to($url);
                $pageError = $validate->errors();
            } else if (isset($_POST['download_all_xls'])) {
                $ext = 'xls';
                $url = 'downloads.php?table=' . Input::get('table') . '&ext=' . $ext;
                Redirect::to($url);
                $pageError = $validate->errors();
            } else if (isset($_POST['download_all_xlsx'])) {
                $ext = 'xlsx';
                $url = 'downloads.php?table=' . Input::get('table') . '&ext=' . $ext;
                Redirect::to($url);
                $pageError = $validate->errors();
            } else if (isset($_POST['download_all_csv'])) {
                $ext = 'csv';
                $url = 'downloads.php?table=' . Input::get('table') . '&ext=' . $ext;
                Redirect::to($url);
                $pageError = $validate->errors();
            } else if (isset($_POST['download_treatement_xls'])) {
                $ext = 'xls';
                $url = 'downloads.php?table=' . Input::get('table') . '&ext=' . $ext;
                Redirect::to($url);
                $pageError = $validate->errors();
            } else if (isset($_POST['download_treatement_xlsx'])) {
                $ext = 'xlsx';
                $url = 'downloads.php?table=' . Input::get('table') . '&ext=' . $ext;
                Redirect::to($url);
                $pageError = $validate->errors();
            } else if (isset($_POST['download_treatement_csv'])) {
                $ext = 'csv';
                $url = 'downloads.php?table=' . Input::get('table') . '&ext=' . $ext;
                Redirect::to($url);
                $pageError = $validate->errors();
            }
        }
        //     }
        // }
    }
} else {
    Redirect::to('index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dream Database | Data Tables</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <style>
        .alert {
            margin: 20px;
        }

        .card-header .badge {
            font-size: 0.9rem;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include 'navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'sidemenu.php'; ?>

        <!-- Alerts -->
        <?php if (!empty($errorMessage)) : ?>
            <div class="alert alert-danger text-center">
                <h4>Error!</h4>
                <?= $errorMessage ?>
            </div>
        <?php elseif (!empty($pageError)) : ?>
            <div class="alert alert-danger text-center">
                <h4>Error!</h4>
                <?= implode(' , ', $pageError) ?>
            </div>
        <?php elseif (!empty($successMessage)) : ?>
            <div class="alert alert-success text-center">
                <h4>Success!</h4>
                <?= $successMessage ?>
            </div>
        <?php endif; ?>

        <?php if ($_GET['id'] == 1) : ?>
            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <!-- Content Header -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>List of Data Tables</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                                    <li class="breadcrumb-item active">List of Data Tables</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main Content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">List of Data Tables</h3>
                                        <span class="badge badge-info float-right"><?= $visit; ?></span>
                                    </div>
                                    <div class="card-body">

                                        <!-- Download All -->
                                        <form method="post" class="mb-3">
                                            <input type="hidden" name="data" value="0">
                                            <input type="hidden" name="table" value="ALL">
                                            <button type="submit" name="download_all_csv" class="btn btn-primary">Download All CSV</button>
                                            <button type="submit" name="download_all_xls" class="btn btn-success">Download All XLS</button>
                                            <button type="submit" name="download_all_xlsx" class="btn btn-info">Download All XLSX</button>
                                        </form>

                                        <!-- Download Treatment -->
                                        <form method="post" class="mb-3">
                                            <input type="hidden" name="data" value="0">
                                            <input type="hidden" name="table" value="TREATMENT">
                                            <button type="submit" name="download_treatement_csv" class="btn btn-primary">Treatment CSV</button>
                                            <button type="submit" name="download_treatement_xls" class="btn btn-success">Treatment XLS</button>
                                            <button type="submit" name="download_treatement_xlsx" class="btn btn-info">Treatment XLSX</button>
                                        </form>

                                        <!-- Data Table -->
                                        <table id="data-tables" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Table Name</th>
                                                    <th>Records</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $x = 1;
                                                foreach ($override->AllTables() as $tables) :
                                                    $table_name = match ($tables['Tables_in_dream']) {
                                                        'screening' => 'Screening Form',
                                                        'enrollment_form' => 'Enrollment Form',
                                                        'respiratory' => 'Clinic Lab Form',
                                                        'diagnosis_test' => 'Zonal Lab Form',
                                                        'diagnosis' => 'Diagnosis Form',
                                                        default => $tables['Tables_in_dream']
                                                    };

                                                    if (in_array($tables['Tables_in_dream'], ['screening', 'enrollment_form', 'respiratory', 'diagnosis', 'diagnosis_test'])) :
                                                ?>
                                                        <tr>
                                                            <td><?= $x; ?></td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="table_name[]" value="<?= $tables['Tables_in_dream']; ?>" checked>
                                                                    <label class="form-check-label"><?= $table_name; ?></label>
                                                                </div>
                                                            </td>
                                                            <td><?= $override->getCount($tables['Tables_in_dream'], 'status', 1); ?></td>
                                                            <td class="text-center">
                                                                <form method="post">
                                                                    <input type="hidden" name="data" value="<?= $x; ?>">
                                                                    <input type="hidden" name="table" value="<?= $tables['Tables_in_dream']; ?>">
                                                                    <button type="submit" name="download_xls" class="btn btn-success btn-sm">XLS</button>
                                                                    <button type="submit" name="download_xlsx" class="btn btn-info btn-sm">XLSX</button>
                                                                    <button type="submit" name="download_csv" class="btn btn-primary btn-sm">CSV</button>
                                                                    <a href="data_view.php?id=2&table=<?= $tables['Tables_in_dream'] ?>&status=<?= $_GET['status'] ?>" class="btn btn-warning btn-sm">View Records</a>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                <?php $x++; endif; endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Table Name</th>
                                                    <th>Records</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        <!-- Pagination -->
                                        <div class="card-footer clearfix">
                                            <ul class="pagination pagination-sm m-0 float-right">
                                                <?php
                                                $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                                                $range = 2;
                                                $start = max(1, $currentPage - $range);
                                                $end = min($pages, $currentPage + $range);
                                                ?>
                                                <!-- Previous -->
                                                <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : ''; ?>">
                                                    <a class="page-link" href="data.php?id=<?= $_GET['id']; ?>&status=<?= $_GET['status']; ?>&page=<?= max($currentPage - 1, 1); ?>">&laquo;</a>
                                                </li>

                                                <?php if ($start > 1) : ?>
                                                    <li class="page-item"><a class="page-link" href="data.php?id=<?= $_GET['id']; ?>&status=<?= $_GET['status']; ?>&page=1">1</a></li>
                                                    <?php if ($start > 2) : ?>
                                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                <?php for ($i = $start; $i <= $end; $i++) : ?>
                                                    <li class="page-item <?= ($i === $currentPage) ? 'active' : ''; ?>">
                                                        <a class="page-link" href="data.php?id=<?= $_GET['id']; ?>&status=<?= $_GET['status']; ?>&page=<?= $i; ?>"><?= $i; ?></a>
                                                    </li>
                                                <?php endfor; ?>

                                                <?php if ($end < $pages) : ?>
                                                    <?php if ($end < $pages - 1) : ?>
                                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                                    <?php endif; ?>
                                                    <li class="page-item"><a class="page-link" href="data.php?id=<?= $_GET['id']; ?>&status=<?= $_GET['status']; ?>&page=<?= $pages; ?>"><?= $pages; ?></a></li>
                                                <?php endif; ?>

                                                <!-- Next -->
                                                <li class="page-item <?= ($currentPage >= $pages) ? 'disabled' : ''; ?>">
                                                    <a class="page-link" href="data.php?id=<?= $_GET['id']; ?>&status=<?= $_GET['status']; ?>&page=<?= min($currentPage + 1, $pages); ?>">&raquo;</a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        <?php endif; ?>

        <?php include 'footer.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    <!-- Scripts -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>

    <script>
        $(function() {
            $("#data-tables").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#data-tables_wrapper .col-md-6:eq(0)');
        });
    </script>
</body>

</html>
