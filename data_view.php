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
  <!-- Theme style -->
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
      <div class="alert alert-danger text-center"><h4>Error!</h4>
        <?= implode(', ', $pageError); ?>
      </div>
    <?php } elseif ($successMessage) { ?>
      <div class="alert alert-success text-center"><h4>Success!</h4><?= $successMessage ?></div>
    <?php } ?>

    <?php if ($_GET['id'] == 2): ?>
      <?php
      $table_name = $_GET['table'];
      if (in_array($user->data()->accessLevel, [1]) || in_array($user->data()->position, [1, 2])) {
        $pagNum = $override->getWithLimit000Count($table_name, 'status', 1);
        $data = $override->getWithLimit000($table_name, 'status', 1, 0, 500); // limit for DataTables
      } else {
        $pagNum = $override->getWithLimit00Count($table_name, 'status', 1, 'facility_id', $user->data()->site_id);
        $data = $override->getWithLimit00($table_name, 'status', 1, 'facility_id', $user->data()->site_id, 0, 500);
      }
      ?>

      <!-- Content Wrapper -->
      <div class="content-wrapper">
        <!-- Page header -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6"><h1><?= ucfirst($_GET['table']); ?> Data</h1></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                  <li class="breadcrumb-item active"><?= $_GET['table']; ?></li>
                </ol>
              </div>
            </div>
          </div>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">List of <?= $_GET['table']; ?> Records</h3>
                <span class="badge badge-info"><?= $pagNum; ?></span>
              </div>

              <div class="card-body">
                <!-- Filters -->
                <div class="row mb-3">
                  <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 3): ?>
                    <div class="col-md-6">
                      <form method="post" class="d-flex">
                        <select class="form-control me-2" name="facility_id">
                          <option value="">Select Site</option>
                          <?php foreach ($override->get('sites', 'status', 1) as $site): ?>
                            <option value="<?= $site['id'] ?>"><?= $site['name'] ?></option>
                          <?php endforeach; ?>
                        </select>
                        <button type="submit" name="search_by_site" class="btn btn-info">
                          <i class="fas fa-search"></i> Search
                        </button>
                      </form>
                    </div>
                  <?php endif; ?>

                  <div class="col-md-6">
                    <form method="get" class="d-flex">
                      <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                      <input type="hidden" name="table" value="<?= $_GET['table'] ?>">
                      <input type="text" name="search_item" class="form-control me-2"
                        placeholder="Search Study ID or Patient ID">
                      <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-search"></i> Search
                      </button>
                    </form>
                  </div>
                </div>

                <!-- DataTable -->
                <table id="records-table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>PID</th>
                      <?php if (in_array($_GET['table'], ['screening', 'enrollment_form'])): ?>
                        <th>Age</th>
                        <th>Sex</th>
                      <?php endif; ?>
                      <th>Site</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($data as $value):
                      $sites = $override->getNews('sites', 'status', 1, 'id', $value['facility_id'])[0]; ?>
                      <tr>
                        <td><?= $value['pid'] ?></td>
                        <?php if (in_array($_GET['table'], ['screening', 'enrollment_form'])): ?>
                          <td><?= $value['age'] ?></td>
                          <td><?= $value['sex'] == 1 ? 'Male' : 'Female' ?></td>
                        <?php endif; ?>
                        <td><?= $sites['name'] ?></td>
                        <td>
                          <span class="badge <?= $value['status'] == 1 ? 'badge-success' : 'badge-danger' ?>">
                            <?= $value['status'] == 1 ? 'Active' : 'Deleted' ?>
                          </span>
                        </td>
                        <td>
                          <a href="add.php?id=13&status=<?= $_GET['status'] ?>&sid=<?= $value['id'] ?>&facility_id=<?= $value['facility_id'] ?>"
                            class="btn btn-info btn-sm">Update</a>
                          <button class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#delete<?= $value['id'] ?>">Delete</button>
                          <button class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#restore<?= $value['id'] ?>">Restore</button>
                        </td>
                      </tr>
                      <!-- Delete Modal -->
                      <div class="modal fade" id="delete<?= $value['id'] ?>">
                        <div class="modal-dialog">
                          <form method="post">
                            <div class="modal-content">
                              <div class="modal-header"><h5>Delete Record</h5></div>
                              <div class="modal-body text-danger">Are you sure you want to delete this record?</div>
                              <div class="modal-footer">
                                <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                <button type="submit" name="delete_record" class="btn btn-danger">Delete</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                      <!-- Restore Modal -->
                      <div class="modal fade" id="restore<?= $value['id'] ?>">
                        <div class="modal-dialog">
                          <form method="post">
                            <div class="modal-content">
                              <div class="modal-header"><h5>Restore Record</h5></div>
                              <div class="modal-body text-success">Are you sure you want to restore this record?</div>
                              <div class="modal-footer">
                                <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                <button type="submit" name="restore_record" class="btn btn-warning">Restore</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>
      </div>
    <?php endif; ?>

    <?php include 'footer.php'; ?>
  </div>

  <!-- JS Scripts -->
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

  <script>
    $(function () {
      $("#records-table").DataTable({
        responsive: true,
        lengthChange: true,
        autoWidth: false,
        pageLength: 25,
        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#records-table_wrapper .col-md-6:eq(0)');
    });
  </script>
</body>
</html>
