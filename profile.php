<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

$successMessage = null;
$pageError = null;
$errorMessage = null;
$users = $override->getData('user');
if ($user->isLoggedIn()) {
    if (Input::exists('post')) {
        $validate = new validate();
        $validate = $validate->check($_POST, array(
            'new_password' => array(
                'required' => true,
                'min' => 6,
            ),
            'current_password' => array(
                'required' => true,
            ),
            'retype_password' => array(
                'required' => true,
                'matches' => 'new_password'
            )
        ));
        if ($validate->passed()) {
            $salt = $random->get_rand_alphanumeric(32);
            if (Hash::make(Input::get('current_password'), $user->data()->salt) !== $user->data()->password) {
                $errorMessage = 'Your current password is wrong';
            } else {
                try {
                    $user->updateRecord('user', array(
                        'password' => Hash::make(Input::get('new_password'), $salt),
                        'salt' => $salt
                    ), $user->data()->id);
                } catch (Exception $e) {
                    $e->getMessage();
                }
            }
            $successMessage = 'Password changed successfully';
        } else {
            $pageError = $validate->errors();
        }
    }
} else {
    Redirect::to('index.php');
}
?>
<!-- 
<!DOCTYPE html>
<html lang="en">

<head>
    <title> Profile - Dream </title>
    <?php include "head.php"; ?>
</head>

<body>
    <div class="wrapper">
        <?php include 'topbar.php' ?>
        <?php include 'menu.php' ?>
        <div class="content">
            <div class="breadLine">
                <ul class="breadcrumb">
                    <li><a href="#">Simple Admin</a> <span class="divider">></span></li>
                    <li><a href="#">User info</a> <span class="divider">></span></li>
                    <li class="active">FileTrack</li>
                </ul>
                <?php include 'pageInfo.php' ?>
            </div>

            <div class="workplace">

                <div class="page-header">
                    <h1>User info <small>Dream</small></h1>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="ucard clearfix">
                                    <div class="right">
                                        <h4><?= $user->data()->username ?></h4>
                                        <div class="image">
                                            <a href="#"><img src="img/users/blank.png" class="img-thumbnail"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="block-fluid ucard">

                                    <div class="info">
                                        <ul class="rows">
                                            <li class="heading">User info</li>
                                            <li>
                                                <div class="title">Name:</div>
                                                <div class="text"><?= $user->data()->firstname ?></div>
                                            </li>
                                            <li>
                                                <div class="title">Surname:</div>
                                                <div class="text"><?= $user->data()->lastname ?></div>
                                            </li>
                                            <li>
                                                <div class="title">Email:</div>
                                                <div class="text"><?= $user->data()->email_address ?></div>
                                            </li>
                                            <li>
                                                <div class="title">Position:</div>
                                                <div class="text"><?= $override->get('position', 'id', $user->data()->position)[0]['name'] ?></div>
                                            </li>
                                            <li>
                                                <div class="title">Last Login:</div>
                                                <div class="text"><?= $user->data()->last_login ?></div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="head clearfix">
                            <div class="isw-ok"></div>
                            <h1>Change Password</h1>
                        </div>
                        <div class="block-fluid">
                            <?php if ($errorMessage) { ?>
                                <div class="alert alert-danger">
                                    <h4>Error!</h4>
                                    <?= $errorMessage ?>
                                </div>
                            <?php } elseif ($pageError) { ?>
                                <div class="alert alert-danger">
                                    <h4>Error!</h4>
                                    <?php foreach ($pageError as $error) {
                                        echo $error . ' , ';
                                    } ?>
                                </div>
                            <?php } elseif ($successMessage) { ?>
                                <div class="alert alert-success">
                                    <h4>Success!</h4>
                                    <?= $successMessage ?>
                                </div>
                            <?php } ?>
                            <form id="validation" method="post">
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Current Password:</div>
                                    <div class="col-md-9">
                                        <input value="" class="validate[required]" type="password" name="current_password" id="pass1" />
                                    </div>
                                </div>
                                <div class="row-form clearfix">
                                    <div class="col-md-3">New Password:</div>
                                    <div class="col-md-9">
                                        <input value="" class="validate[required]" type="password" name="new_password" id="pass2" />
                                    </div>
                                </div>
                                <div class="row-form clearfix">
                                    <div class="col-md-3">Re-type Password:</div>
                                    <div class="col-md-9">
                                        <input value="" class="validate[required]" type="password" name="retype_password" id="pass3" />
                                    </div>
                                </div>
                                <div class="footer tar">
                                    <input type="submit" name="pwd" value="Change Password" class="btn btn-warning">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="dr"><span></span></div>
            </div>

        </div>
    </div>
    <script>
        <?php if ($user->data()->pswd == 0) { ?>
            $(window).on('load', function() {
                $("#change_password_n").modal({
                    backdrop: 'static',
                    keyboard: false
                }, 'show');
            });
        <?php } ?>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>
 -->



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Change Password</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<?php if ($errorMessage) { ?>
    <div class="alert alert-danger">
        <h4>Error!</h4>
        <?= $errorMessage ?>
    </div>
<?php } elseif ($pageError) { ?>
    <div class="alert alert-danger">
        <h4>Error!</h4>
        <?php foreach ($pageError as $error) {
            echo $error . ' , ';
        } ?>
    </div>
<?php } elseif ($successMessage) { ?>
    <div class="alert alert-success">
        <h4>Success!</h4>
        <?= $successMessage ?>
    </div>
<?php } ?>

<body class="hold-transition login-page">

    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Dream Fund Sub-Studies</b>&nbsp;Database</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Change your Password</p>

                <form method="post">
                    <div class="input-group mb-3">
                        <input type="password" name="current_password" id="pass1" placeholder="current_password" class="form-control validate[required]" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="new_password" id="pass2" placeholder="new_password" class="form-control validate[required]" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="retype_password" id="pass3" placeholder="retype_password" class="form-control validate[required]" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div> -->
                        <!-- /.col -->
                        <!-- <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div> -->
                        <div class="col-8">
                            <a href="info.php?id=1&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                            <input type="submit" name="pwd" value="Change Password" class="btn btn-primary btn-block">
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div> -->
                <!-- /.social-auth-links -->

                <!-- <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.html" class="text-center">Register a new membership</a>
                </p> -->
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>