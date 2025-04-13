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

        if (Input::get('reset_pass')) {
            $salt = $random->get_rand_alphanumeric(32);
            $password = '12345678';
            $user->updateRecord('user', array(
                'password' => Hash::make($password, $salt),
                'salt' => $salt,
            ), Input::get('id'));
            $successMessage = 'Password Reset Successful';
        } elseif (Input::get('change_pass')) {
            $salt = $random->get_rand_alphanumeric(32);
            $password = Input::get('password');
            $user->updateRecord('user', array(
                'password' => Hash::make($password, $salt),
                'salt' => $salt,
            ), Input::get('id'));
            $successMessage = 'Password Changed Successful';
        } elseif (Input::get('lock_account')) {
            $user->updateRecord('user', array(
                'count' => 4,
            ), Input::get('id'));
            $successMessage = 'Account locked Successful';
        } elseif (Input::get('unlock_account')) {
            $user->updateRecord('user', array(
                'count' => 0,
            ), Input::get('id'));
            $successMessage = 'Account Unlock Successful';
        } elseif (Input::get('delete_staff')) {
            $user->updateRecord('user', array(
                'status' => 0,
            ), Input::get('id'));
            $successMessage = 'User Restored Successful';
        } elseif (Input::get('delete_sites')) {
            $user->updateRecord('sites', array(
                'status' => 0,
            ), Input::get('id'));
            $successMessage = 'Site Deleted Successful';
        } elseif (Input::get('delete_positions')) {
            $user->updateRecord('position', array(
                'status' => 0,
            ), Input::get('id'));
            $successMessage = 'Position Deleted Successful';
        } elseif (Input::get('delete_facility')) {
            $user->updateRecord('sites', array(
                'status' => 0,
            ), Input::get('id'));
            $successMessage = 'Site Deleted Successful';
        } elseif (Input::get('restore_facility')) {
            $user->updateRecord('sites', array(
                'status' => 1,
            ), Input::get('id'));
            $successMessage = 'Facility Restored Successful';
        } elseif (Input::get('restore_staff')) {
            $user->updateRecord('user', array(
                'status' => 1,
            ), Input::get('id'));
            $successMessage = 'User Deleted Successful';
        } elseif (Input::get('add_visit')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'visit_status' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $user->updateRecord('visit', array(
                    'visit_date' => Input::get('visit_date'),
                    'visit_status' => Input::get('visit_status'),
                    'comments' => Input::get('comments'),
                    'patient_id' => Input::get('cid'),
                    'update_on' => date('Y-m-d H:i:s'),
                    'update_id' => $user->data()->id,
                ), Input::get('id'));

                $successMessage = 'Visit Updates  Successful';
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('search_by_site')) {

            $validate = $validate->check($_POST, array(
                'facility_id' => array(
                    'required' => true,
                ),
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
        } elseif (Input::get('clear_data')) {

            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    if (Input::get('name')) {
                        if (Input::get('name') == 'user' || Input::get('name') == 'sites' || Input::get('name') == 'position' || Input::get('name') == 'district') {
                            $errorMessage = 'Table ' . '"' . Input::get('name') . '"' . '  can not be Cleared';
                        } else {
                            $clearData = $override->clearDataTable(Input::get('name'));
                            $successMessage = 'Table ' . '"' . Input::get('name') . '"' . ' Cleared Successfull';
                        }
                    } else {
                        $errorMessage = 'Table ' . '"' . Input::get('name') . '"' . '  can not be Found!';
                    }
                    // die;
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('setSiteId')) {

            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $setSiteId = $override->setSiteId('visit', 'site_id', Input::get('name'), 1);
                    $successMessage = 'Site ID Successfull';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('unset_study_id')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    if (Input::get('name') == 'study_id') {
                        $study_id = $override->getData('study_id');
                        foreach ($study_id as $row) {
                            $user->updateRecord('study_id', array(
                                'client_id' => 0,
                                'status' => 0,
                            ), $row['id']);
                        }
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('invite')) {
            $staff = $override->get('user', 'id', Input::get('id'))[0];
            $subject = 'Nanopore WhatsApp Invite';
            $link = 'https://chat.whatsapp.com/KbhgEsRCew40x5ZHbcac3y';
            try {
                $email->userInvite($staff['email_address'], $staff['lastname'], $subject, $link);
                $successMessage = 'Email Sent Successful';
            } catch (Exception $e) {
                $e->getMessage();
            }
        } else if (Input::get('delete_record')) {
            $user->updateRecord('screening', array(
                'status' => 0,
            ), Input::get('id'));

            $enrollment_form = $override->get('enrollment_form', 'enrollment_id', Input::get('id'));
            foreach ($enrollment_form as $value) {
                $user->updateRecord('enrollment_form', array(
                    'status' => 0,
                ), $value['id']);
            }

            $respiratory = $override->get('respiratory', 'enrollment_id', Input::get('id'));
            foreach ($respiratory as $value) {
                $user->updateRecord('respiratory', array(
                    'status' => 0,
                ), $value['id']);
            }

            $diagnosis_test = $override->get('diagnosis_test', 'enrollment_id', Input::get('id'));
            foreach ($diagnosis_test as $value) {
                $user->updateRecord('diagnosis_test', array(
                    'status' => 0,
                ), $value['id']);
            }

            $diagnosis = $override->get('diagnosis', 'enrollment_id', Input::get('id'));
            foreach ($diagnosis as $value) {
                $user->updateRecord('diagnosis', array(
                    'status' => 0,
                ), $value['id']);
            }

            $successMessage = 'Recored Deleted Successful';
        } else if (Input::get('restore_record')) {
            $user->updateRecord('screening', array(
                'status' => 1,
            ), Input::get('id'));

            $enrollment_form = $override->get('enrollment_form', 'enrollment_id', Input::get('id'));
            foreach ($enrollment_form as $value) {
                $user->updateRecord('enrollment_form', array(
                    'status' => 1,
                ), $value['id']);
            }

            $respiratory = $override->get('respiratory', 'enrollment_id', Input::get('id'));
            foreach ($respiratory as $value) {
                $user->updateRecord('respiratory', array(
                    'status' => 1,
                ), $value['id']);
            }

            $diagnosis_test = $override->get('diagnosis_test', 'enrollment_id', Input::get('id'));
            foreach ($diagnosis_test as $value) {
                $user->updateRecord('diagnosis_test', array(
                    'status' => 1,
                ), $value['id']);
            }

            $diagnosis = $override->get('diagnosis', 'enrollment_id', Input::get('id'));
            foreach ($diagnosis as $value) {
                $user->updateRecord('diagnosis', array(
                    'status' => 1,
                ), $value['id']);
            }
            $successMessage = 'Recored Restored Successful';
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
                                <div class="card-header">
                                    <h3 class="card-title">Summary Total For Nanopore Study on <?= date('Y-m-d') ?></h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Site</th>
                                                <th>SCREENED</th>
                                                <th>ELIGIBLE</th>
                                                <th>ENROLLED</th>
                                                <th>COMPLETED</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $x = 1;
                                            $site_data = $override->get('sites', 'status', 1);
                                            $screening = $override->getCount('screening', 'status', 1);
                                            $eligible = $override->getCount1('screening', 'status', 1, 'eligible', 1);
                                            $enrollment = $override->getCount('enrollment_form', 'status', 1);
                                            $enrollment = $override->updateScreening();
                                            foreach ($site_data as $row) {
                                                $screened_male = $override->countData1('screening', 'status', 1, 'facility_id', $row['id'], 'sex', 1);
                                                $screened_female = $override->countData1('screening', 'status', 1, 'facility_id', $row['id'], 'sex', 2);
                                                $screened = $override->countData('screening', 'status', 1, 'facility_id', $row['id']);
                                                $screened_Total = $override->getCount('screening', 'status', 1);
                                                $eligible_male = $override->countData2('screening', 'status', 1, 'eligible', 1, 'facility_id', $row['id'], 'sex', 1);
                                                $eligible_female = $override->countData2('screening', 'status', 1, 'eligible', 1, 'facility_id', $row['id'], 'sex', 2);
                                                $eligible = $override->countData1('screening', 'status', 1, 'eligible', 1, 'facility_id', $row['id']);
                                                $eligible_Total = $override->countData('screening', 'status', 1, 'eligible', 1);
                                                $enrolled_male = $override->countData1('enrollment_form', 'status', 1, 'facility_id', $row['id'], 'sex', 1);
                                                $enrolled_female = $override->countData1('enrollment_form', 'status', 1, 'facility_id', $row['id'], 'sex', 2);
                                                $enrolled = $override->countData('enrollment_form', 'status', 1, 'facility_id', $row['id']);
                                                $enrolled_Total = $override->getCount('enrollment_form', 'status', 1);
                                                // $end_study_male = $override->countData2('diagnosis', 'status', 1, 'tb_otcome2', 1, 'facility_id', $row['id'],'sex', 1);
                                                // $end_study_female = $override->countData2('diagnosis', 'status', 1, 'tb_otcome2', 1, 'facility_id', $row['id'], 'sex', 2);
                                                $end_study = $override->countData1('diagnosis', 'status', 1, 'tb_otcome2', 1, 'facility_id', $row['id']);
                                                $end_study_Total = $override->countData('diagnosis', 'status', 1, 'tb_otcome2', 1);
                                                $site_total = ($screened + $eligible + $enrolled + $end_study);
                                                $Total = ($screened_Total + $eligible_Total + $enrolled_Total + $end_study_Total);
                                                // $screened_male = $override->countData2('screening', 'status', 1, 'facility_id', $row['id'], 'gender', 'male');
                                                // $screened_female = $override->countData2('screening', 'status', 1, 'facility_id', $row['id'], 'gender', 'female');
                                                // $eligible_male = $override->countData3('screening', 'status', 1, 'eligible', 1, 'facility_id', $row['id'], 'gender', 'male');
                                                // $eligible_female = $override->countData3('screening', 'status', 1, 'eligible', 1, 'facility_id', $row['id'], 'gender', 'female');
                                                // $enrolled_male = $override->countData2('enrollment_form', 'status', 1, 'facility_id', $row['id'], 'gender', 'male');
                                                // $enrolled_female = $override->countData2('enrollment_form', 'status', 1, 'facility_id', $row['id'], 'gender', 'female');
                                                // $end_study_male = $override->countData3('diagnosis', 'status', 1, 'tb_otcome2', 1, 'facility_id', $row['id'], 'gender', 'male');
                                                // $end_study_female = $override->countData3('diagnosis', 'status', 1, 'tb_otcome2', 1, 'facility_id', $row['id'], 'gender', 'female');
                                            ?>
                                                <tr>
                                                    <td><?= $x ?></td>
                                                    <td><?= $row['name'] ?></td>
                                                    <td>
                                                        <span class="badge bg-default">M: <?= $screened_male ?></span>
                                                        <span class="badge bg-default">F: <?= $screened_female ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-default">M: <?= $eligible_male ?></span>
                                                        <span class="badge bg-default">F: <?= $eligible_female ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-default">M: <?= $enrolled_male ?></span>
                                                        <span class="badge bg-default">F: <?= $enrolled_female ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-default">M: <?= $end_study_male ?></span>
                                                        <span class="badge bg-default">F: <?= $end_study_female ?></span>
                                                    </td>
                                                </tr>
                                            <?php $x++;
                                            } ?>
                                            <?php
                                            $screened_Total_male = $override->countData('screening', 'status',1, 'sex', 1);
                                            $screened_Total_female = $override->countData('screening', 'status', 1, 'sex', 2);
                                            $eligible_Total_male = $override->countData('screening', 'status', 1, 'eligible', 1, 'sex', 1);
                                            $eligible_Total_female = $override->countData('screening', 'status', 1, 'eligible', 1, 'sex', 2);
                                            $enrolled_Total_male = $override->countData('enrollment_form', 'status', 1, 'sex', 1);
                                            $enrolled_Total_female = $override->countData('enrollment_form', 'status', 1, 'sex', 2);
                                            // $end_study_Total_male = $override->countData3('diagnosis', 'status', 1, 'tb_otcome2', 1, 'gender', 'male');
                                            // $end_study_Total_female = $override->countData3('diagnosis', 'status', 1, 'tb_otcome2', 1, 'gender', 'female');
                                            ?>
                                            <tr>
                                                <td>Total</td>
                                                <td></td>
                                                <td>
                                                    <span class="badge bg-success">M: <?= $screened_Total_male ?></span>
                                                    <span class="badge bg-success">F: <?= $screened_Total_female ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">M: <?= $eligible_Total_male ?></span>
                                                    <span class="badge bg-success">F: <?= $eligible_Total_female ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">M: <?= $enrolled_Total_male ?></span>
                                                    <span class="badge bg-success">F: <?= $enrolled_Total_female ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success">M: <?= $end_study_Total_male ?></span>
                                                    <span class="badge bg-success">F: <?= $end_study_Total_female ?></span>
                                                </td>
                                            </tr>
                                        </tbody>
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