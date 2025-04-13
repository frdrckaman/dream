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
                            <h1>Summary</h1>
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
                                <!-- Month Filter Form -->
                                <div class="card-header">
                                    <h3 class="card-title">Summary Total For Nanopore Study on <?= date('Y-m-d') ?></h3>
                                    <form method="GET" action="" class="form-inline float-right">
                                        <label for="month" class="mr-2">Filter by Month:</label>
                                        <select name="month" id="month" class="form-control mr-2">
                                            <option value="">All Months</option>
                                            <?php
                                            for ($m = 1; $m <= 12; $m++) {
                                                $monthName = date('F', mktime(0, 0, 0, $m, 1));
                                                $selected = (isset($_GET['month']) && $_GET['month'] == $m) ? 'selected' : '';
                                                echo "<option value='$m' $selected>$monthName</option>";
                                            }
                                            ?>
                                        </select>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </form>
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
                                            $monthFilter = isset($_GET['month']) && !empty($_GET['month']) ? $_GET['month'] : null;

                                            $site_data = $override->get('sites', 'status', 1);
                                            $updateScreening = $override->updateScreening();

                                            foreach ($site_data as $row) {
                                                $conditions = [
                                                    'status' => 1,
                                                    'facility_id' => $row['id']
                                                ];

                                                if ($monthFilter) {
                                                    $startDate = date('Y-m-01', strtotime("2025-$monthFilter-01"));
                                                    $endDate = date('Y-m-t', strtotime("2025-$monthFilter-01"));
                                                    $conditions['create_on[>=]'] = $startDate;
                                                    $conditions['create_on[<=]'] = $endDate;
                                                }

                                                $screened_male = $override->countDataWithConditions('screening', array_merge($conditions, ['sex' => 1]));
                                                $screened_female = $override->countDataWithConditions('screening', array_merge($conditions, ['sex' => 2]));
                                                $screened = $override->countDataWithConditions('screening', $conditions);

                                                $eligible_male = $override->countDataWithConditions('screening', array_merge($conditions, ['eligible' => 1, 'sex' => 1]));
                                                $eligible_female = $override->countDataWithConditions('screening', array_merge($conditions, ['eligible' => 1, 'sex' => 2]));
                                                $eligible = $override->countDataWithConditions('screening', array_merge($conditions, ['eligible' => 1]));

                                                $enrolled_male = $override->countDataWithConditions('enrollment_form', array_merge($conditions, ['sex' => 1]));
                                                $enrolled_female = $override->countDataWithConditions('enrollment_form', array_merge($conditions, ['sex' => 2]));
                                                $enrolled = $override->countDataWithConditions('enrollment_form', $conditions);

                                                // $end_study_male = $override->countDataWithConditions('diagnosis', array_merge($conditions, ['tb_otcome2' => 1, 'sex' => 1]));
                                                // $end_study_female = $override->countDataWithConditions('diagnosis', array_merge($conditions, ['tb_otcome2' => 1, 'sex' => 2]));
                                                // $end_study = $override->countDataWithConditions('diagnosis', array_merge($conditions, ['tb_otcome2' => 1]));
                                            ?>
                                                <tr>
                                                    <td><?= $x ?></td>
                                                    <td><?= $row['name'] ?></td>
                                                    <td><?= $screened_male ?></td>
                                                    <td><?= $screened_female ?></td>
                                                    <td><?= $screened ?></td>
                                                    <td><?= $eligible_male ?></td>
                                                    <td><?= $eligible_female ?></td>
                                                    <td><?= $eligible ?></td>
                                                    <td><?= $enrolled_male ?></td>
                                                    <td><?= $enrolled_female ?></td>
                                                    <td><?= $enrolled ?></td>
                                                    <td><?= $end_study_male ?></td>
                                                    <td><?= $end_study_female ?></td>
                                                    <td><?= $end_study ?></td>
                                                </tr>
                                            <?php $x++;
                                            } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Total</th>
                                                <th><?= $override->countData('screening', 'status', 1, 'sex', 1) ?></th>
                                                <th><?= $override->countData('screening', 'status', 1, 'sex', 2) ?></th>
                                                <th><?= $override->getCount('screening', 'status', 1) ?></th>
                                                <th><?= $override->countData1('screening', 'status', 1, 'eligible', 1, 'sex', 1) ?></th>
                                                <th><?= $override->countData1('screening', 'status', 1, 'eligible', 1, 'sex', 2) ?></th>
                                                <th><?= $override->countData('screening', 'status', 1, 'eligible', 1) ?></th>
                                                <th><?= $override->countData('enrollment_form', 'status', 1, 'sex', 1) ?></th>
                                                <th><?= $override->countData('enrollment_form', 'status', 1, 'sex', 2) ?></th>
                                                <th><?= $override->getCount('enrollment_form', 'status', 1) ?></th>
                                                <th>
                                                    <?php
                                                    //  printf($override->countData2('diagnosis', 'status', 1, 'tb_otcome2', 1, 'sex', 1))
                                                    ?>
                                                </th>
                                                <th>
                                                    <?php
                                                    //  printf($override->countData2('diagnosis', 'status', 1, 'tb_otcome2', 1, 'sex', 2))
                                                    ?>
                                                </th>
                                                <th>
                                                    <?php
                                                    // print_r($override->countData('diagnosis', 'status', 1, 'tb_otcome2', 1))
                                                    ?>
                                                </th>
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