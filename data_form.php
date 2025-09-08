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

if ($user->isLoggedIn()) {
    if (Input::exists('post')) {
        $validate = new validate();

        if (Input::get('delete_record')) {
            $user->updateRecord($_GET['table'], array(
                'status' => 0,
            ), Input::get('id'));
            $successMessage = 'Record Deleted Successfully';
        }

        if (Input::get('restore_record')) {
            $user->updateRecord($_GET['table'], array(
                'status' => 1,
            ), Input::get('id'));
            $successMessage = 'Record Restored Successfully';
        }

        if (Input::get('search_by_site')) {
            $validate = $validate->check($_POST, array(
                'facility_id' => array('required' => true),
            ));
            if ($validate->passed()) {
                $url = 'data.php?id=' . $_GET['id'] . '&status=' . $_GET['status'] .
                    '&data=' . $_GET['data'] . '&table=' . $_GET['table'] .
                    '&page=' . $_GET['page'] . '&facility_id=' . Input::get('facility_id');
                Redirect::to($url);
            } else {
                $pageError = $validate->errors();
            }
        }

        // File downloads
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $downloadTypes = [
                'download_xls' => 'xls',
                'download_xlsx' => 'xlsx',
                'download_csv' => 'csv',
                'download_stata' => 'dta',
                'download_all_xls' => 'xls',
                'download_all_xlsx' => 'xlsx',
                'download_all_csv' => 'csv',
                'download_treatement_xls' => 'xls',
                'download_treatement_xlsx' => 'xlsx',
                'download_treatement_csv' => 'csv'
            ];
            foreach ($downloadTypes as $key => $ext) {
                if (isset($_POST[$key])) {
                    $url = 'downloads.php?table=' . Input::get('table') . '&ext=' . $ext;
                    Redirect::to($url);
                }
            }
        }
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
    <title>DReam Database | Data</title>

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>
    <!-- Sidebar -->
    <?php include 'sidemenu.php'; ?>

    <!-- Alerts -->
    <?php if ($errorMessage) { ?>
        <div class="alert alert-danger text-center"><h4>Error!</h4><?= $errorMessage ?></div>
    <?php } elseif ($pageError) { ?>
        <div class="alert alert-danger text-center">
            <h4>Error!</h4>
            <?php foreach ($pageError as $error) { echo $error . ' , '; } ?>
        </div>
    <?php } elseif ($successMessage) { ?>
        <div class="alert alert-success text-center"><h4>Success!</h4><?= $successMessage ?></div>
    <?php } ?>

    <?php if (isset($_GET['id']) && $_GET['id'] == 3) { ?>
        <?php
        $table_name = $_GET['table'];
        $form_status = $_GET['form_status'];

        if ($user->data()->accessLevel == 1 || $user->data()->position == 1 || $user->data()->position == 2) {
            $pagNum = $override->countData($table_name, 'status', 1, 'form_status', $form_status);
        } else {
            $pagNum = $override->countData1($table_name, 'status', 1, 'form_status', $form_status,
                'facility_id', $user->data()->site_id);
        }

        $pages = ceil($pagNum / $numRec);
        $page = (!isset($_GET['page']) || $_GET['page'] == 1) ? 0 : ($_GET['page'] * $numRec) - $numRec;

        if ($user->data()->accessLevel == 1 || $user->data()->position == 1 || $user->data()->position == 2) {
            $data = $override->getWithLimit1($table_name, 'status', 1, 'form_status', $form_status, $page, $numRec);
        } else {
            $data = $override->getWithLimit2($table_name, 'status', 1, 'form_status', $form_status,
                'facility_id', $user->data()->site_id, $page, $numRec);
        }
        ?>

        <!-- Content -->
        <div class="content-wrapper">
            <!-- Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6"><h1><?= $_GET['table']; ?> Data</h1></div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                                <li class="breadcrumb-item active"><?= $_GET['table']; ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of <?= $_GET['table']; ?> Records</h3>
                            <span class="badge badge-info right"><?= $pagNum; ?></span>
                        </div>

                        <div class="card-body">
                            <table id="search-results" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>PID</th>
                                    <?php if ($_GET['table'] == 'screening' || $_GET['table'] == 'enrollment_form') { ?>
                                        <th>Age</th><th>Sex</th>
                                    <?php } ?>
                                    <th>Site</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($data as $value): ?>
                                    <?php
                                    $sites = $override->getNews('sites', 'status', 1, 'id', $value['facility_id'])[0];
                                    ?>
                                    <tr>
                                        <td><?= $value['pid']; ?></td>
                                        <?php if ($_GET['table'] == 'screening' || $_GET['table'] == 'enrollment_form') { ?>
                                            <td><?= $value['age']; ?></td>
                                            <td><?= $value['sex'] == 1 ? 'Male' : 'Female'; ?></td>
                                        <?php } ?>
                                        <td><?= $sites['name']; ?></td>
                                        <td class="text-center">
                                            <?= $value['status'] == 1
                                                ? "<span class='badge badge-success'>Active</span>"
                                                : "<span class='badge badge-danger'>Deleted</span>"; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="add.php?id=13&status=<?= $_GET['status'] ?>&sid=<?= $value['id'] ?>&facility_id=<?= $value['facility_id'] ?>&page="
                                               class="btn btn-info btn-sm">Update</a>
                                            <a href="#delete_record<?= $value['id'] ?>" class="btn btn-danger btn-sm" data-toggle="modal">Delete</a>
                                            <a href="#restore_record<?= $value['id'] ?>" class="btn btn-warning btn-sm" data-toggle="modal">Restore</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="data.php?id=3&status=<?= $_GET['status'] ?>&table=<?= $_GET['table'] ?>&facility_id=<?= $_GET['facility_id'] ?>&page=<?= max(($_GET['page'] - 1), 1) ?>">&laquo;</a></li>
                                <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                    <li class="page-item"><a class="page-link <?= $i == $_GET['page'] ? 'active' : '' ?>"
                                        href="data.php?id=3&status=<?= $_GET['status'] ?>&table=<?= $_GET['table'] ?>&facility_id=<?= $_GET['facility_id'] ?>&page=<?= $i ?>"><?= $i ?></a></li>
                                <?php } ?>
                                <li class="page-item"><a class="page-link" href="data.php?id=3&status=<?= $_GET['status'] ?>&table=<?= $_GET['table'] ?>&facility_id=<?= $_GET['facility_id'] ?>&page=<?= min(($_GET['page'] + 1), $pages) ?>">&raquo;</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    <?php } ?>

    <?php include 'footer.php'; ?>
</div>

<!-- Scripts -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
