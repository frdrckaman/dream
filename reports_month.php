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
$numRec = 5;
if ($user->isLoggedIn()) {
    if (Input::exists('post')) {
        $validate = new validate();
        if (Input::get('report')) {
            $salt = $random->get_rand_alphanumeric(32);
            $password = '12345678';
            $user->updateRecord('user', array(
                'password' => Hash::make($password, $salt),
                'salt' => $salt,
            ), Input::get('id'));
            $successMessage = 'Password Reset Successful';
        } elseif (Input::get('report2')) {
            $validate = $validate->check($_POST, array(
                // 'facility_id' => array(
                //     'required' => true,
                // ),
            ));
            if ($validate->passed()) {
                if (Input::get('facility_id')) {
                    $url = 'info.php?id=' . $_GET['id'] . '&status=' . $_GET['status'] . '&facility_id=' . Input::get('facility_id');
                } else {
                    $url = 'info.php?id=' . $_GET['id'] . '&status=' . $_GET['status'];
                }
                Redirect::to($url);
                $pageError = $validate->errors();
            }
        }
    }
    // else if (Input::exists('get')) {
    //     $validate = new validate();
    //     if (Input::get('report')) {
    //         function getDateWhereClause($dateField, $selectedMonth, $selectedYear)
    //         {
    //             if ($selectedMonth && $selectedYear) {
    //                 return "AND DATE_FORMAT($dateField, '%Y-%m') = '" . $selectedYear . "-" . $selectedMonth . "'";
    //             } elseif ($selectedYear) {
    //                 return "AND YEAR($dateField) = '" . $selectedYear . "'";
    //             }
    //             return "";
    //         }
    //         $successMessage = 'Password Reset Successful';
    //     }
    // }
} else {
    Redirect::to('index.php');
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dream Nanopore | Summary</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'sidemenu.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Summary Report For Nanopore Study on <?= date('Y-m-d') ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Summary</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <form method="get" class="form-inline">
                                        <label for="month" class="mr-2">Month:</label>
                                        <select name="month" id="month" class="form-control mr-2">
                                            <option value="">Up To Date</option>
                                            <?php
                                            $selectedMonth = $_GET['month'] ?? '';
                                            for ($m = 1; $m <= 12; $m++) {
                                                $monthValue = str_pad($m, 2, '0', STR_PAD_LEFT);
                                                $monthName = date('F', mktime(0, 0, 0, $m, 10));
                                                $selected = ($selectedMonth == $monthValue) ? 'selected' : '';
                                                echo "<option value=\"$monthValue\" $selected>$monthName</option>";
                                            }
                                            ?>
                                        </select>
                                        <label for="year" class="mr-2">Year:</label>
                                        <select name="year" id="year" class="form-control mr-2">
                                            <option value="">Up To Date</option>
                                            <?php
                                            $currentYear = date('Y');
                                            $selectedYear = $_GET['year'] ?? '';
                                            for ($y = $currentYear; $y >= $currentYear - 10; $y--) {
                                                $selected = ($selectedYear == $y) ? 'selected' : '';
                                                echo "<option value=\"$y\" $selected>$y</option>";
                                            }
                                            ?>
                                        </select>
                                        <button type="submit" class="btn btn-primary">Show</button>
                                        <!-- <input type="submit" name="report" class="btn btn-primary" value="Show Report"> -->
                                    </form>
                                    <h3 class="card-title mt-2">
                                        <?php
                                        if (!empty($selectedMonth) && !empty($selectedYear)) {
                                            echo "Summary Report For " . date('F', mktime(0, 0, 0, $selectedMonth, 10)) . " $selectedYear";
                                        } elseif (!empty($selectedYear)) {
                                            echo "Summary Report For Year $selectedYear";
                                        } else {
                                            echo "Summary Report Up To ". date('Y m d');
                                        }
                                        ?>
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- Adjusted Table -->
                                <div class="card-body p-0">
                                    <table class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Site</th>
                                                <th colspan="3">SCREENED</th>
                                                <th colspan="3">ELIGIBLE</th>
                                                <th colspan="3">ENROLLED</th>
                                                <th colspan="3">COMPLETED</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th>Male</th>
                                                <th>Female</th>
                                                <th>Total</th>
                                                <th>Male</th>
                                                <th>Female</th>
                                                <th>Total</th>
                                                <th>Male</th>
                                                <th>Female</th>
                                                <th>Total</th>
                                                <th>Male</th>
                                                <th>Female</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php


                                            $x = 1;
                                            $site_data = $override->get('sites', 'status', 1);
                                            $updateScreening = $override->updateScreening();
                                            $updateEnrollmentFormPID = $override->updateEnrollmentFormPID();
                                            $updateRespiratoryFormPID = $override->updateRespiratoryFormPID();
                                            $updateDiagnosisTestFormPID = $override->updateDiagnosisTestFormPID();
                                            $updateDiagnosisFormPID = $override->updateDiagnosisFormPID();


                                            // Helper for WHERE clause
                                            function getDateWhereClause($dateField, $selectedMonth, $selectedYear)
                                            {
                                                if ($selectedMonth && $selectedYear) {
                                                    return "AND DATE_FORMAT($dateField, '%Y-%m') = '" . $selectedYear . "-" . $selectedMonth . "'";
                                                } elseif ($selectedYear) {
                                                    return "AND YEAR($dateField) = '" . $selectedYear . "'";
                                                }
                                                return "";
                                            }
                                            // $screeningWhere = getDateWhereClause('screening_date', $selectedMonth, $selectedYear);
                                            // print_r($screeningWhere);

                                            foreach ($site_data as $row) {
                                                // SCREENING
                                                $screeningWhere = getDateWhereClause('screening_date', $selectedMonth, $selectedYear);
                                                $screened_male = $override->customCount('screening', 'status', 1, 'facility_id', $row['id'], 'sex', 1, $screeningWhere);
                                                $screened_female = $override->customCount('screening', 'status', 1, 'facility_id', $row['id'], 'sex', 2, $screeningWhere);
                                                $screened = $override->customCountSubTotal('screening', 'status', 1, 'facility_id', $row['id'], $screeningWhere);

                                                $eligible_male = $override->customCount1('screening', 'status', 1, 'eligible', 1, 'facility_id', $row['id'], 'sex', 1, $screeningWhere);
                                                $eligible_female = $override->customCount1('screening', 'status', 1, 'eligible', 1, 'facility_id', $row['id'], 'sex', 2, $screeningWhere);
                                                $eligible = $override->customCount('screening', 'status', 1, 'eligible', 1, 'facility_id', $row['id'], $screeningWhere);

                                                // // ENROLLMENT
                                                $enrollmentWhere = getDateWhereClause('enrollment_date', $selectedMonth, $selectedYear);
                                                $enrolled_male = $override->customCount('enrollment_form', 'status', 1, 'facility_id', $row['id'], 'sex', 1, $enrollmentWhere);
                                                $enrolled_female = $override->customCount('enrollment_form', 'status', 1, 'facility_id', $row['id'], 'sex', 2, $enrollmentWhere);

                                                // $end_study_male = $override->countData2('diagnosis', 'status', 1, 'tb_otcome2', 1, 'facility_id', $row['id'], 'sex', 1);
                                                // $end_study_female = $override->countData2('diagnosis', 'status', 1, 'tb_otcome2', 1, 'facility_id', $row['id'], 'sex', 2);
                                                // $end_study = $override->countData1('diagnosis', 'status', 1, 'tb_otcome2', 1, 'facility_id', $row['id']);

                                                // print_r($screened_male);
                                                // print_r($screened_female);
                                            ?>
                                                <tr>
                                                    <td><?= $x ?></td>
                                                    <td><?= $row['name'] ?></td>
                                                    <td><?= $screened_male ?></td>
                                                    <td><?= $screened_female ?></td>
                                                    <td><span class="badge bg-info"><?= $screened ?></span></td>
                                                    <td><?= $eligible_male ?></td>
                                                    <td><?= $eligible_female ?></td>
                                                    <td><span class="badge bg-info"><?= $eligible ?></span></td>
                                                    <td><?= $enrolled_male ?></td>
                                                    <td><?= $enrolled_female ?></td>
                                                    <td><span class="badge bg-info"><?= $enrolled ?></span></td>
                                                    <td><?= $end_study_male ?></td>
                                                    <td><?= $end_study_female ?></td>
                                                    <td><span class="badge bg-info"><?= $end_study ?></span></td>
                                                </tr>
                                            <?php $x++;
                                            } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Total</th>
                                                <th><span class="badge bg-success"><?= $override->customCountSubTotal('screening', 'status', 1, 'sex', 1, $screeningWhere) ?></span></th>
                                                <th><span class="badge bg-success"><?= $override->customCountSubTotal('screening', 'status', 1, 'sex', 2, $screeningWhere) ?></span></th>
                                                <th><span class="badge bg-success"><?= $override->customCountTotal('screening', 'status', 1, $screeningWhere) ?></span></th>
                                                <th><span class="badge bg-success"><?= $override->customCountTotal1('screening', 'status', 1, 'eligible', 1, 'sex', 1, $screeningWhere) ?></span></th>
                                                <th><span class="badge bg-success"><?= $override->customCountTotal1('screening', 'status', 1, 'eligible', 1, 'sex', 2, $screeningWhere) ?></span></th>
                                                <th><span class="badge bg-success"><?= $override->customCountSubTotal('screening', 'status', 1, 'eligible', 1, $screeningWhere) ?></span></th>
                                                <th><span class="badge bg-success"><?= $override->customCountSubTotal('enrollment_form', 'status', 1, 'sex', 1, $enrollmentWhere) ?></span></th>
                                                <th><span class="badge bg-success"><?= $override->customCountSubTotal('enrollment_form', 'status', 1, 'sex', 2, $enrollmentWhere) ?></span></th>
                                                <th><span class="badge bg-success"><?= $override->customCountTotal('enrollment_form', 'status', 1, $enrollmentWhere) ?></span></th>
                                                <th><span class="badge bg-success">
                                                        <?php
                                                        //  printf($override->countData2('diagnosis', 'status', 1, 'tb_otcome2', 1, 'sex', 1))
                                                        ?>
                                                    </span></th>
                                                <th><span class="badge bg-success">
                                                        <?php
                                                        //  printf($override->countData2('diagnosis', 'status', 1, 'tb_otcome2', 1, 'sex', 2))
                                                        ?>
                                                    </span></th>
                                                <th><span class="badge bg-success"><?= $override->countData('diagnosis', 'status', 1, 'tb_otcome2', 1) ?></span></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include 'footer.php'; ?>


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="dist/js/demo.js"></script> -->
</body>

</html>