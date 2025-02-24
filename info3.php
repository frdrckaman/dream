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
            $successMessage = 'Recored Deleted Successful';
        } else if (Input::get('restore_record')) {
            $user->updateRecord('screening', array(
                'status' => 1,
            ), Input::get('id'));
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
    <title>Dream Fund Sub-Studies Database | Info</title>

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
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'sidemenu.php'; ?>

        <?php if ($errorMessage) { ?>
            <div class="alert alert-danger text-center">
                <h4>Error!</h4>
                <?= $errorMessage ?>
            </div>
        <?php } elseif ($pageError) { ?>
            <div class="alert alert-danger text-center">
                <h4>Error!</h4>
                <?php foreach ($pageError as $error) {
                    echo $error . ' , ';
                } ?>
            </div>
        <?php } elseif ($successMessage) { ?>
            <div class="alert alert-success text-center">
                <h4>Success!</h4>
                <?= $successMessage ?>
            </div>
        <?php } ?>

                    <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>
                                    <?php
                                            $pagNum = 0;
                                            if ($_GET['search_name']) {
                                                $searchTerm = $_GET['search_name'];
                                                if ($_GET['status'] == 1) {
                                                    $pagNum = $override->getWithLimitSearchNewsCount1('screening', 'status', 1, $searchTerm, 'pid');
                                                } else if ($_GET['status'] == 2) {
                                                    $pagNum = $override->getWithLimitSearchNewsCount2('screening', 'status', 1, 'eligible', 1, $searchTerm, 'pid');
                                                } else if ($_GET['status'] == 3) {
                                                    // $pagNum = $override->countData('enrollment_form', 'status', 1, 'facility_id', $user->data()->site_id);
                                            
                                                    $pagNum = $override->getWithLimitSearchNewsCount1('enrollment_form', 'status', 1, 'pid', $searchTerm);
                                                } else if ($_GET['status'] == 4) {
                                                    $pagNum = $override->getWithLimitSearchNewsCount1('termination', 'status', 1, $searchTerm, 'pid');
                                                } else {
                                                    $pagNum = $override->getWithLimitSearchNewsCount('screening', $searchTerm, 'pid');
                                                }

                                                $pages = ceil($pagNum / $numRec);
                                                if (!$_GET['page'] || $_GET['page'] == 1) {
                                                    $page = 0;
                                                } else {
                                                    $page = ($_GET['page'] * $numRec) - $numRec;
                                                }

                                                if ($_GET['status'] == 1) {
                                                    $data = $override->getWithLimitSearchNews1('screening', 'status', 1, $page, $numRec, $searchTerm, 'pid');
                                                } else if ($_GET['status'] == 2) {
                                                    $data = $override->getWithLimitSearchNews2('screening', 'status', 1, 'eligible', 1, $page, $numRec, $searchTerm, 'pid');
                                                } else if ($_GET['status'] == 3) {
                                                    // $data = $override->getWithLimit1Desc('enrollment_form', 'status', 1, 'facility_id', $user->data()->site_id, $page, $numRec);
                                            
                                                    $data = $override->getWithLimitSearchNews1('enrollment_form', 'status', 1, 'pid', $searchTerm);
                                                } else if ($_GET['status'] == 4) {
                                                    $data = $override->getWithLimitSearchNews1('termination', 'status', 1, $page, $numRec, $searchTerm, 'pid');
                                                } else {
                                                    $data = $override->getWithLimitSearchNews('screening', $page, $numRec, $searchTerm, 'pid');
                                                }

                                            } else {
                                                //     $clients = $override->getWithLimit3('clients', 'status', 1, 'eligible', 1, 'site_id', $_GET['site_id'], $page, $numRec);
                                                if ($user->data()->accessLevel == 1) {
                                                    if ($_GET['facility_id'] != null) {
                                                        if ($_GET['status'] == 1) {
                                                            $pagNum = $override->countData('screening', 'status', 1, 'facility_id', $_GET['facility_id']);
                                                        } else if ($_GET['status'] == 2) {
                                                            $pagNum = $override->countData1('screening', 'status', 1, 'eligible', 1, 'facility_id', $_GET['facility_id']);
                                                        } else if ($_GET['status'] == 3) {
                                                            $pagNum = $override->countData('enrollment_form', 'status', 1, 'facility_id', $_GET['facility_id']);
                                                        } else if ($_GET['status'] == 4) {
                                                            $pagNum = $override->countData('termination', 'status', 1, 'facility_id', $_GET['facility_id']);
                                                        } else {
                                                            $pagNum = $override->getCount('screening', 'facility_id', $_GET['facility_id']);
                                                        }
                                                    } else {
                                                        if ($_GET['status'] == 1) {
                                                            $pagNum = $override->getCount('screening', 'status', 1);
                                                        } else if ($_GET['status'] == 2) {
                                                            $pagNum = $override->countData('screening', 'status', 1, 'eligible', 1);
                                                        } else if ($_GET['status'] == 3) {
                                                            $pagNum = $override->getCount('enrollment_form', 'status', 1);
                                                        } else if ($_GET['status'] == 4) {
                                                            $pagNum = $override->getCount('termination', 'status', 1);
                                                        } else {
                                                            $pagNum = $override->getNo('screening');
                                                        }
                                                    }
                                                } else {
                                                    if ($_GET['status'] == 1) {
                                                        $pagNum = $override->countData('screening', 'status', 1, 'facility_id', $user->data()->site_id);
                                                    } else if ($_GET['status'] == 2) {
                                                        $pagNum = $override->countData1('screening', 'status', 1, 'eligible', 1, 'facility_id', $user->data()->site_id);
                                                    } else if ($_GET['status'] == 3) {
                                                        $pagNum = $override->countData('enrollment_form', 'status', 1, 'facility_id', $user->data()->site_id);
                                                    } else if ($_GET['status'] == 4) {
                                                        $pagNum = $override->countData('termination', 'status', 1, 'facility_id', $user->data()->site_id);
                                                    } else {
                                                        $pagNum = $override->getData('screening');
                                                    }
                                                }


                                                $pages = ceil($pagNum / $numRec);
                                                if (!$_GET['page'] || $_GET['page'] == 1) {
                                                    $page = 0;
                                                } else {
                                                    $page = ($_GET['page'] * $numRec) - $numRec;
                                                }


                                                if ($user->data()->accessLevel == 1) {
                                                    if ($_GET['facility_id'] != null) {
                                                        if ($_GET['status'] == 1) {
                                                            $data = $override->getWithLimit1Desc('screening', 'status', 1, 'facility_id', $_GET['facility_id'], $page, $numRec);
                                                        } else if ($_GET['status'] == 2) {
                                                            $data = $override->getWithLimit2Desc('screening', 'status', 1, 'eligible', 1, 'facility_id', $_GET['facility_id'], $page, $numRec);
                                                        } else if ($_GET['status'] == 3) {
                                                            $data = $override->getWithLimit1Desc('enrollment_form', 'status', 1, 'facility_id', $_GET['facility_id'], $page, $numRec);
                                                        } else if ($_GET['status'] == 4) {
                                                            $data = $override->getWithLimit1Desc('termination', 'status', 1, 'facility_id', $_GET['facility_id'], $page, $numRec);
                                                        } else {
                                                            $data = $override->getWithLimitDesc('screening', 'facility_id', $_GET['facility_id'], $page, $numRec);
                                                        }
                                                    } else {
                                                        if ($_GET['status'] == 1) {
                                                            $data = $override->getWithLimitDesc('screening', 'status', 1, $page, $numRec);
                                                        } else if ($_GET['status'] == 2) {
                                                            $data = $override->getWithLimit1Desc('screening', 'status', 1, 'eligible', 1, $page, $numRec);
                                                        } else if ($_GET['status'] == 3) {
                                                            $data = $override->getWithLimitDesc('enrollment_form', 'status', 1, $page, $numRec);
                                                        } else if ($_GET['status'] == 4) {
                                                            $data = $override->getWithLimitDesc('termination', 'status', 1, $page, $numRec);
                                                        } else {
                                                            $data = $override->getWithLimit0Desc('screening', $page, $numRec);
                                                        }
                                                    }
                                                } else {
                                                    if ($_GET['status'] == 1) {
                                                        $data = $override->getWithLimit1Desc('screening', 'status', 1, 'facility_id', $user->data()->site_id, $page, $numRec);
                                                    } else if ($_GET['status'] == 2) {
                                                        $data = $override->getWithLimit2Desc('screening', 'status', 1, 'eligible', 1, 'facility_id', $user->data()->site_id, $page, $numRec);
                                                    } else if ($_GET['status'] == 3) {
                                                        $data = $override->getWithLimit1Desc('enrollment_form', 'status', 1, 'facility_id', $user->data()->site_id, $page, $numRec);
                                                    } else if ($_GET['status'] == 4) {
                                                        $data = $override->getWithLimit1Desc('termination', 'status', 1, 'facility_id', $user->data()->site_id, $page, $numRec);
                                                    } else {
                                                        $data = $override->getWithLimit0Desc('screening', $page, $numRec);
                                                    }
                                                }
                                            }
                                            ?>
                                            <?php
                                            if ($_GET['status'] == 1) {
                                                echo $title = 'Screening';
                                                ?>
                                                <?php
                                            } elseif ($_GET['status'] == 2) {
                                                echo $title = 'Eligible';
                                                ?>
                                                <?php
                                            } elseif ($_GET['status'] == 3) {
                                                echo $title = 'Enrollment';
                                                ?>
                                                <?php
                                            } elseif ($_GET['status'] == 4) {
                                                echo $title = 'End Study';
                                                ?>
                                                <?php
                                            } ?>
                                        </h1>
                                    </div>
                                    <div class="col-sm-6">
                                        <ol class="breadcrumb float-sm-right">
                                            <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                                            <li class="breadcrumb-item active"><?= $title; ?></li>
                                        </ol>
                                    </div>
                                </div>
                            </div><!-- /.container-fluid -->
                        </section>

                                        <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-3">
                                                    <div class="card-header">
                                                        <?php
                                                                                if ($_GET['status'] == 1) { ?>
                                                                                    <h3 class="card-title">List of Screened Clients</h3> &nbsp;&nbsp;
                                                                                    <span class="badge badge-info right"><?= $pagNum; ?></span>
                                                                                    <?php
                                                                                } elseif ($_GET['status'] == 2) { ?>
                                                                                    <h3 class="card-title">List of Eligible Clients</h3> &nbsp;&nbsp;
                                                                                    <span class="badge badge-info right"><?= $pagNum; ?></span>
                                                                                    <?php
                                                                                } elseif ($_GET['status'] == 3) { ?>
                                                                                    <h3 class="card-title">List of Enrolled Clients</h3> &nbsp;&nbsp;
                                                                                    <span class="badge badge-info right"><?= $pagNum; ?></span>
                                                                                    <?php
                                                                                } elseif ($_GET['status'] == 4) { ?>
                                                                                    <h3 class="card-title">List of Terminated Clients</h3> &nbsp;&nbsp;
                                                                                    <span class="badge badge-info right"><?= $pagNum; ?></span>
                                                                                    <?php
                                                                                } ?>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                        // if ($user->data()->accessLevel == 1) {
                                                                        ?>
                                                                        <div class="col-sm-3">
                                                                            <form id="validation" enctype="multipart/form-data" method="post"
                                                                                autocomplete="off">
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <div class="row-form clearfix">
                                                                                            <div class="form-group">
                                                                                                <select class="form-control" name="facility_id"
                                                                                                    style="width: 100%;" autocomplete="off">
                                                                                                    <option value="">Select Site</option>
                                                                                                    <?php foreach ($override->get('sites', 'status', 1) as $site) { ?>
                                                                                                        <option value="<?= $site['id'] ?>">
                                                                                                            <?= $site['name'] ?>
                                                                                                        </option>
                                                                                                    <?php } ?>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-4">
                                                                                        <div class="row-form clearfix">
                                                                                            <div class="form-group">
                                                                                                <input type="submit" name="search_by_site"
                                                                                                    value="Search by Site" class="btn btn-primary">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="card-tools">
                                                                            <div class="input-group input-group-sm float-right" style="width: 350px;">
                                                                                <form method="get">
                                                                                    <div class="form-inline">
                                                                                        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                                                                        <input type="hidden" name="status" value="<?= $_GET['status'] ?>">
                                                                                        <input type="hidden" name="sid" value="<?= $_GET['sid'] ?>">
                                                                                        <input type="hidden" name="facility_id"
                                                                                            value="<?= $_GET['facility_id'] ?>">
                                                                                        <input type="hidden" name="page" value="<?= $_GET['page'] ?>">
                                                                                        <input type="text" name="search_name" id="search_name"
                                                                                            class="form-control float-right" placeholder="Search here PID">
                                                                                        <input type="submit" value="Search" class="btn btn-default"><i
                                                                                            class="fas fa-search"></i>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                        //  } 
                                                                        ?>
                                                                        <div class="col-sm-6">
                                                                            <ol class="breadcrumb float-sm-right">
                                                                                <li class="breadcrumb-item">
                                                                                    <a href="index1.php">
                                                                                        < Back</a>
                                                                                </li>
                                                                                &nbsp;
                                                                                <li class="breadcrumb-item">
                                                                                    <a href="index1.php">
                                                                                        Go Home > </a>
                                                                                </li>
                                                                            </ol>
                                                                        </div>
                                                                    </div>
                                                                </div><!-- /.container-fluid -->
                                                            </section>
                                                            <!-- /.card-header -->

        <?php if ($_GET['id'] == 1) { ?>
        <?php } elseif ($_GET['id'] == 2) { ?>

        <?php } elseif ($_GET['id'] == 3) { ?>

                                    <div class="card-body">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <?php if ($_GET['status'] == 1 || $_GET['status'] == 2) { ?>
                                                        <th>Screening Date /
                                                            <hr> Time
                                                        </th>
                                                    <?php } ?>
                                                    <?php if ($_GET['status'] == 3) { ?>
                                                        <th>Enrollment Date /
                                                            <hr> Time
                                                        </th>
                                                    <?php } ?>
                                                    <?php if ($_GET['status'] == 4) { ?>
                                                        <th>Termination Date /
                                                            <hr> Time
                                                        </th>
                                                    <?php } ?>
                                                    <th>PID</th>
                                                    <th>Site / <hr> Staff</th>
                                                    <th class="text-center">Status/
                                                        <hr> Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $x = 1;
                                                foreach ($data as $value) {
                                                    $sites = $override->getNews('sites', 'status', 1, 'id', $value['facility_id'])[0];
                                                    $sex = $override->getNews('sex', 'status', 1, 'id', $value['sex'])[0];
                                                    $staff = $override->getNews('user', 'status', 1, 'id', $value['staff_id'])[0];
                                                    $sid = '';
                                                    if ($_GET['status'] == 1 || $_GET['status'] == 2) {
                                                        $sid = $value['id'];
                                                    } else {
                                                        $sid = $value['enrollment_id'];
                                                    }
                                                    ?>
                                                    <tr>
                                                        <?php if ($_GET['status'] == 1 || $_GET['status'] == 2) { ?>
                                                            <td class="table-user">
                                                                <?= $value['screening_date']; ?>
                                                                /
                                                                <hr>
                                                                <?php
                                                                // print_r (date("h:i:s A"));
                                                                print_r(date('H:i', strtotime($value['create_on'])));
                                                                ?>
                                                            </td>
                                                        <?php } ?>
                                                        <?php if ($_GET['status'] == 3) { ?>
                                                            <td class="table-user">
                                                                <?= $value['enrollment_date']; ?>
                                                                /
                                                                <hr>
                                                                <?php
                                                                // print_r (date("h:i:s A"));
                                                                print_r(date('H:i', strtotime($value['create_on'])));
                                                                ?>
                                                            </td>
                                                        <?php } ?>
                                                        <?php if ($_GET['status'] == 4) { ?>
                                                            <td class="table-user">
                                                                <?= $value['update_on']; ?> /
                                                                <hr>
                                                                <?php
                                                                // print_r (date("h:i:s A"));
                                                                print_r(date('H:i', strtotime($value['create_on'])));
                                                                ?>
                                                            </td>
                                                        <?php } ?>
                                                        <td class="table-user">
                                                            <?= $value['pid']; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $sites['name']; ?>
                                                            /
                                                            <hr>
                                                            <?= $staff['firstname'] . '-' . $staff['lastname']; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if ($_GET['status'] == 1) { ?>
                                                                <?php if ($value['eligible'] == 1) { ?>
                                                                    <!-- <td class="text-center"> -->
                                                                    <a href="#" class="btn btn-success">
                                                                        <i class="ri-edit-box-line">
                                                                        </i> Eligible
                                                                    </a>
                                                                    <!-- </td> -->
                                                                <?php } else { ?>
                                                                    <!-- <td class="text-center"> -->
                                                                    <a href="#" class="btn btn-danger"> <i
                                                                            class="ri-edit-box-line"></i>Not
                                                                        Eligible</a>
                                                                    <!-- </td> -->
                                                                <?php } ?>
                                                                <hr>
                                                                <?php if ($_GET['status'] == 1 || $_GET['status'] == 2) { ?>
                                                                    <?php if ($override->get('screening', 'status', 1)) { ?>
                                                                        <a href="add.php?id=13&status=<?= $_GET['status'] ?>&sid=<?= $sid ?>&facility_id=<?= $_GET['facility_id'] ?>&page=<?= $_GET['page'] ?>"
                                                                            role=" button" class="btn btn-info"> Update Screening
                                                                            Data</a>&nbsp;&nbsp; <br><br>

                                                                    <?php } else { ?>
                                                                        <a href="add.php?id=13&status=<?= $_GET['status'] ?>&sid=<?= $sid ?>&facility_id=<?= $_GET['facility_id'] ?>&page=<?= $_GET['page'] ?>"
                                                                            role=" button" class="btn btn-warning"> Add Screening
                                                                            Data</a>&nbsp;&nbsp; <br><br>
                                                                    <?php } ?>
                                                                    <hr>                                                               
                                                                <?php } ?>
                                                                <?php
                                                                if ($override->get3('enrollment_form', 'status', 1, 'enrollment_id', $_GET['sid'], 'other_samples', 1)) {
                                                                    ?>
                                                                    <?php if (
                                                                        $override->getNews('enrollment_form', 'status', 1, 'enrollment_id', $sid) &&
                                                                        $override->getNews('diagnosis_test', 'status', 1, 'enrollment_id', $sid) &&
                                                                        $override->getNews('diagnosis', 'status', 1, 'enrollment_id', $sid) &&
                                                                        $override->getNews('respiratory', 'status', 1, 'enrollment_id', $sid) &&
                                                                        $override->getNews('non_respiratory', 'status', 1, 'enrollment_id', $sid)
                                                                    ) { ?>

                                                                        <?php if ($value['eligible'] || $_GET['status'] == 2 || $_GET['status'] == 3) { ?>
                                                                            <a href="info.php?id=6&status=<?= $_GET['status'] ?>&sid=<?= $sid ?>&facility_id=<?= $_GET['facility_id'] ?>&page=<?= $_GET['page'] ?>"
                                                                                role=" button" class="btn btn-info"> View Enrollment Forms
                                                                            </a>&nbsp;&nbsp; <br><br>
                                                                        <?php } ?>

                                                                    <?php } else { ?>
                                                                        <?php if ($value['eligible'] || $_GET['status'] == 2 || $_GET['status'] == 3) { ?>
                                                                            <a href="info.php?id=6&status=<?= $_GET['status'] ?>&sid=<?= $sid ?>&facility_id=<?= $_GET['facility_id'] ?>&page=<?= $_GET['page'] ?>"
                                                                                role=" button" class="btn btn-warning"> Add Enrollment Forms
                                                                            </a>&nbsp;&nbsp; <br><br>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } else { ?>
                                                                    <?php if (
                                                                        $override->getNews('enrollment_form', 'status', 1, 'enrollment_id', $sid) &&
                                                                        $override->getNews('diagnosis_test', 'status', 1, 'enrollment_id', $sid) &&
                                                                        $override->getNews('diagnosis', 'status', 1, 'enrollment_id', $sid) &&
                                                                        $override->getNews('respiratory', 'status', 1, 'enrollment_id', $sid)
                                                                    ) { ?>

                                                                        <?php if ($value['eligible'] || $_GET['status'] == 2 || $_GET['status'] == 3) { ?>
                                                                            <a href="info.php?id=6&status=<?= $_GET['status'] ?>&sid=<?= $sid ?>&facility_id=<?= $_GET['facility_id'] ?>&page=<?= $_GET['page'] ?>"
                                                                                role=" button" class="btn btn-info"> View Enrollment Forms
                                                                            </a>&nbsp;&nbsp; <br><br>
                                                                        <?php } ?>

                                                                    <?php } else { ?>
                                                                        <?php if ($value['eligible'] || $_GET['status'] == 2 || $_GET['status'] == 3) { ?>
                                                                            <a href="info.php?id=6&status=<?= $_GET['status'] ?>&sid=<?= $sid ?>&facility_id=<?= $_GET['facility_id'] ?>&page=<?= $_GET['page'] ?>"
                                                                                role=" button" class="btn btn-warning"> Add Enrollment Forms
                                                                            </a>&nbsp;&nbsp; <br><br>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                <?php } ?>

                                                            <?php } else { ?>
                                                                <?php if ($value['status'] == 1) { ?>
                                                                    <!-- <td class="text-center"> -->
                                                                    <a href="#" class="btn btn-success">
                                                                        <i class="ri-edit-box-line">
                                                                        </i> Enrolled
                                                                    </a>
                                                                    <!-- </td> -->
                                                                <?php } else { ?>
                                                                    <!-- <td class="text-center"> -->
                                                                    <a href="#" class="btn btn-danger"> <i
                                                                            class="ri-edit-box-line"></i>Not
                                                                        Enrolled</a>
                                                                </td>
                                                            <?php } ?>

                                                            <hr>
                                                            <?php if ($_GET['status'] == 1 || $_GET['status'] == 2) { ?>
                                                                <?php if ($override->get('screening', 'status', 1)) { ?>
                                                                    <a href="add.php?id=13&status=<?= $_GET['status'] ?>&sid=<?= $sid ?>&facility_id=<?= $_GET['facility_id'] ?>&page=<?= $_GET['page'] ?>"
                                                                        role=" button" class="btn btn-info"> Update Screening
                                                                        Data</a>&nbsp;&nbsp; <br><br>

                                                                <?php } else { ?>
                                                                    <a href="add.php?id=13&status=<?= $_GET['status'] ?>&sid=<?= $sid ?>&facility_id=<?= $_GET['facility_id'] ?>&page=<?= $_GET['page'] ?>"
                                                                        role=" button" class="btn btn-warning"> Add Screening
                                                                        Data</a>&nbsp;&nbsp; <br><br>
                                                                <?php } ?>
                                                                <hr>
                                                            <?php } ?>
                                                            <?php
                                                            if ($override->get3('enrollment_form', 'status', 1, 'enrollment_id', $_GET['sid'], 'other_samples', 1)) {
                                                                ?>
                                                                <?php if (
                                                                    $override->getNews('enrollment_form', 'status', 1, 'enrollment_id', $sid) &&
                                                                    $override->getNews('diagnosis_test', 'status', 1, 'enrollment_id', $sid) &&
                                                                    $override->getNews('diagnosis', 'status', 1, 'enrollment_id', $sid) &&
                                                                    $override->getNews('respiratory', 'status', 1, 'enrollment_id', $sid) &&
                                                                    $override->getNews('non_respiratory', 'status', 1, 'enrollment_id', $sid)
                                                                ) { ?>

                                                                    <?php if ($value['eligible'] || $_GET['status'] == 2 || $_GET['status'] == 3) { ?>
                                                                        <a href="info.php?id=6&status=<?= $_GET['status'] ?>&sid=<?= $sid ?>&facility_id=<?= $_GET['facility_id'] ?>&page=<?= $_GET['page'] ?>"
                                                                            role=" button" class="btn btn-info"> View Enrollment Forms
                                                                        </a>&nbsp;&nbsp; <br><br>
                                                                    <?php } ?>

                                                                <?php } else { ?>
                                                                    <?php if ($value['eligible'] || $_GET['status'] == 2 || $_GET['status'] == 3) { ?>
                                                                        <a href="info.php?id=6&status=<?= $_GET['status'] ?>&sid=<?= $sid ?>&facility_id=<?= $_GET['facility_id'] ?>&page=<?= $_GET['page'] ?>"
                                                                            role=" button" class="btn btn-warning"> Add Enrollment Forms
                                                                        </a>&nbsp;&nbsp; <br><br>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <?php if (
                                                                    $override->getNews('enrollment_form', 'status', 1, 'enrollment_id', $sid) &&
                                                                    $override->getNews('diagnosis_test', 'status', 1, 'enrollment_id', $sid) &&
                                                                    $override->getNews('diagnosis', 'status', 1, 'enrollment_id', $sid) &&
                                                                    $override->getNews('respiratory', 'status', 1, 'enrollment_id', $sid)
                                                                ) { ?>

                                                                    <?php if ($value['eligible'] || $_GET['status'] == 2 || $_GET['status'] == 3) { ?>
                                                                        <a href="info.php?id=6&status=<?= $_GET['status'] ?>&sid=<?= $sid ?>&facility_id=<?= $_GET['facility_id'] ?>&page=<?= $_GET['page'] ?>"
                                                                            role=" button" class="btn btn-info"> View Enrollment Forms
                                                                        </a>&nbsp;&nbsp; <br><br>
                                                                    <?php } ?>

                                                                <?php } else { ?>
                                                                    <?php if ($value['eligible'] || $_GET['status'] == 2 || $_GET['status'] == 3) { ?>
                                                                        <a href="info.php?id=6&status=<?= $_GET['status'] ?>&sid=<?= $sid ?>&facility_id=<?= $_GET['facility_id'] ?>&page=<?= $_GET['page'] ?>"
                                                                            role=" button" class="btn btn-warning"> Add Enrollment Forms
                                                                        </a>&nbsp;&nbsp; <br><br>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php } ?>
                                                                                                                    <hr>
                                                             <a href="#delete_record<?= $sid ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete Record</a>
                                                            <!-- <a href="#restore_record<?= $sid ?>" role="button" class="btn btn-warning" data-toggle="modal">Restore -->
                                                            <!-- Record</a> -->
                                                        </td>

                                                        <!-- <td class="text-center"> -->
                                                        <br>
                                                        <!-- </td> -->
                                                    </tr>
                                                    <div class="modal fade" id="delete_record<?= $sid ?>" tabindex="-1"
                                                        role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal"><span
                                                                                aria-hidden="true">&times;</span><span
                                                                                class="sr-only">Close</span></button>
                                                                        <h4>Delete Record</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: red">
                                                                            <p>Are you sure you want to delete this Record ?</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $sid ?>">
                                                                        <?php
                                                                        //  if ($user->data()->accessLevel == 1) { 
                                                                        ?>
                                                                        <input type="submit" name="delete_record" value="Delete"
                                                                            class="btn btn-danger">
                                                                        <?php
                                                                        //  } 
                                                                        ?>
                                                                        <button class="btn btn-default" data-dismiss="modal"
                                                                            aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="restore_record<?= $sid ?>" tabindex="-1"
                                                        role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal"><span
                                                                                aria-hidden="true">&times;</span><span
                                                                                class="sr-only">Close</span></button>
                                                                        <h4>Restore Record</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: green">
                                                                            <p>Are you sure you want to Restore this Record ?
                                                                            </p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id"
                                                                            value="<?= $value['id'] ?>">
                                                                        <?php
                                                                        //  if ($user->data()->accessLevel == 1) { 
                                                                        ?>
                                                                        <input type="submit" name="restore_record"
                                                                            value="Restore" class="btn btn-warning">
                                                                        <?php
                                                                        //  } 
                                                                        ?>
                                                                        <button class="btn btn-default" data-dismiss="modal"
                                                                            aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <?php if ($_GET['status'] == 1 || $_GET['status'] == 2) { ?>
                                                        <th>Screening Date /
                                                            <hr> Time
                                                        </th>
                                                    <?php } ?>
                                                    <?php if ($_GET['status'] == 3) { ?>
                                                        <th>Enrollment Date /
                                                            <hr> Time
                                                        </th>
                                                    <?php } ?>
                                                    <?php if ($_GET['status'] == 4) { ?>
                                                        <th>Termination Date /
                                                            <hr> Time
                                                        </th>
                                                    <?php } ?>
                                                    <th>PID</th>
                                                    <th>Site / Staff</th>
                                                    <th class="text-center">Status/
                                                        <hr> Action
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                    
        <?php } ?>
        <?php
                                    $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                                    $currentSite = $_GET['facility_id'];
                                    // $pages = 10; // Total number of pages (replace with your actual calculation)
                                    $range = 2; // Number of pages to show before and after the current page
                                
                                    // Calculate start and end for the visible range
                                    $start = max(1, $currentPage - $range);
                                    $end = min($pages, $currentPage + $range);
                                    ?>
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <!-- Previous Page -->
                                            <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                                                <a class="page-link"
                                                    href="info.php?id=<?= $_GET['id']; ?>&status=<?= $_GET['status']; ?>&facility_id=<?= $currentSite; ?>&page=<?php echo max($currentPage - 1, 1); ?>">&laquo;</a>
                                            </li>

                                            <!-- First Page (if outside the range) -->
                                            <?php if ($start > 1): ?>
                                                <li class="page-item">
                                                    <a class="page-link"
                                                        href="info.php?id=<?= $_GET['id']; ?>&status=<?= $_GET['status']; ?>&facility_id=<?= $currentSite; ?>&page=1">1</a>
                                                </li>
                                                <?php if ($start > 2): ?>
                                                    <li class="page-item disabled">
                                                        <span class="page-link">...</span>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <!-- Visible Page Links -->
                                            <?php for ($i = $start; $i <= $end; $i++): ?>
                                                <li class="page-item <?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                                                    <a class="page-link"
                                                        href="info.php?id=<?= $_GET['id']; ?>&status=<?= $_GET['status']; ?>&facility_id=<?= $currentSite; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <!-- Last Page (if outside the range) -->
                                            <?php if ($end < $pages): ?>
                                                <?php if ($end < $pages - 1): ?>
                                                    <li class="page-item disabled">
                                                        <span class="page-link">...</span>
                                                    </li>
                                                <?php endif; ?>
                                                <li class="page-item">
                                                    <a class="page-link"
                                                        href="info.php?id=<?= $_GET['id']; ?>&status=<?= $_GET['status']; ?>&facility_id=<?= $currentSite; ?>&page=<?php echo $pages; ?>"><?php echo $pages; ?></a>
                                                </li>
                                            <?php endif; ?>
                                            <!-- Next Page -->
                                            <li class="page-item <?php echo ($currentPage >= $pages) ? 'disabled' : ''; ?>">
                                                <a class="page-link"
                                                    href="info.php?id=<?= $_GET['id']; ?>&status=<?= $_GET['status']; ?>&facility_id=<?= $currentSite; ?>&page=<?php echo min($currentPage + 1, $pages); ?>">&raquo;</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (right) -->
                    </div>
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
    <!-- DataTables  & Plugins -->
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
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="dist/js/demo.js"></script> -->
    <!-- Page specific script -->
    <script>
        // $(function() {
        //     $("#example1").DataTable({
        //         "responsive": true,
        //         "lengthChange": false,
        //         "autoWidth": false,
        //         "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        //     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        //     $('#example2').DataTable({
        //         "paging": true,
        //         "lengthChange": false,
        //         "searching": false,
        //         "ordering": true,
        //         "info": true,
        //         "autoWidth": false,
        //         "responsive": true,
        //     });
        // });
    </script>
</body>

</html>