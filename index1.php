<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();



$users = $override->getData('user');
if ($user->isLoggedIn()) {
  if (Input::exists('post')) {

    if (Input::get('search_by_site')) {
      $validate = new validate();
      $validate = $validate->check($_POST, array(
        'site_id' => array(
          'required' => true,
        ),
      ));
      if ($validate->passed()) {

        $url = 'index1.php?&site_id=' . Input::get('site_id');
        Redirect::to($url);
        $pageError = $validate->errors();
      }
    }
  }

  if ($_GET['site_id'] != null) {
    $enrolled = $override->countData('enrollment_form', 'status', 1, 'facility_id', $_GET['site_id']);
    $end = $override->countData('enrollment_form', 'status', 2, 'facility_id', $_GET['site_id']);
  } else {
    $enrolled = $override->countData('enrollment_form', 'status', 1, 'facility_id', $user->data()->site_id);
    $end = $override->countData('enrollment_form', 'status', 2, 'facility_id', $user->data()->site_id);
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
  <title>Dream Fund Sub-Studies Database | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

  <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script> -->

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style type="text/css">
    .chartBox {
      width: 1400px;
      position: relative;
      align-items: center;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <?php include 'navbar.php'; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include 'sidemenu.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-3">
              <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">

              <?php
              if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) {
                ?>
                <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="row-form clearfix">
                        <div class="form-group">
                          <select class="form-control" name="site_id" style="width: 100%;" autocomplete="off">
                            <option value="">Select Site</option>
                            <?php foreach ($override->get('sites', 'status', 1) as $site) { ?>
                              <option value="<?= $site['id'] ?>"><?= $site['name'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="row-form clearfix">
                        <div class="form-group">
                          <input type="submit" name="search_by_site" value="Search by Site" class="btn btn-primary">
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              <?php } ?>
            </div>
            <!-- /.col -->

            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <!-- <section class="content"> -->
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $enrolled ?></h3>

                <p>Enrolled</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="info.php?id=3&status=1" class="small-box-footer">More info <i
                  class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>       
          
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $end ?></h3>
          
                <p>Completed</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="info.php?id=3&status=2" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
        <!-- /.row -->

        <?php
        //  if ($_GET['id'] == 100) {
        ?>

        <!-- /.row (main row) -->

        <?php
        //  }
        ?>
        <!-- <hr>

          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <h1 class="m-0 text-center">Registration Up to <?= date('Y-m-d'); ?></h1>
                </div>
              </div> -->
        <!-- /.row -->
        <!-- </div> -->
        <!-- /.container-fluid -->
        <!-- </div>

          <hr> -->

        <!-- <div class="row">
            <div class="chartBox">
              <canvas id="registration"></canvas>
            </div>

          </div> -->

        <!-- <hr>

          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <h1 class="m-0 text-center">Screaning Up to <?= date('Y-m-d'); ?></h1>
                </div> -->
        <!-- </div> -->
        <!-- /.row -->
        <!-- </div> -->
        <!-- /.container-fluid -->
        <!-- </div>

          <hr> -->

        <!-- <div class="row">
            <div class="chartBox">
              <canvas id="screening"></canvas>
            </div>

          </div> -->

        <!-- <hr>

          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <h1 class="m-0 text-center">Eligible Up to <?= date('Y-m-d'); ?></h1>
                </div>
              </div> -->
        <!-- /.row -->
        <!-- </div> -->
        <!-- /.container-fluid -->
        <!-- </div>

          <hr>

          <div class="row">
            <div class="chartBox">
              <canvas id="eligible"></canvas>
            </div>

          </div>

          <hr> -->

        <!-- <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <h1 class="m-0 text-center">Enrolled Up to <?= date('Y-m-d'); ?></h1>
                </div> -->
        <!-- </div> -->
        <!-- /.row -->
        <!-- </div> -->
        <!-- /.container-fluid -->
        <!-- </div>

          <hr>

          <div class="row">
            <div class="chartBox">
              <canvas id="enrolled"></canvas>
            </div>

          </div>

          <hr> -->

        <!-- <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <h1 class="m-0 text-center">End Study Up to <?= date('Y-m-d'); ?></h1>
                </div>
              </div> -->
        <!-- /.row -->
        <!-- </div> -->
        <!-- /.container-fluid -->
        <!-- </div> -->

        <!-- <hr>

          <div class="row">
            <div class="chartBox">
              <canvas id="end"></canvas>
            </div>

          </div>

          <hr> -->

      </div>
      <!-- /.container-fluid -->
      <!-- </section> -->
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
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>


  <!-- MY LINKS TO CHAARTS JS -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <!-- <script src="dist/js/demo.js"></script> -->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- <script src="dist/js/pages/dashboard.js"></script> -->
  <script src="dist/js/pages/dashboard1_1.js"></script>
  <script src="dist/js/pages/dashboard1_2.js"></script>
  <script src="dist/js/pages/dashboard1_3.js"></script>
  <script src="dist/js/pages/dashboard1_4.js"></script>
  <script src="dist/js/pages/dashboard1_5.js"></script>



  <script>
    // SETUP BLOCK


    // fetch('process1.php')
    //   .then(response => response.json())
    //   .then(data => {
    //     const monthname = Object.keys(data);
    //     const amana = monthname.map(monthname => data[monthname]['1']);
    //     const mwananyamala = monthname.map(monthname => data[monthname]['2']);
    //     const temeke = monthname.map(monthname => data[monthname]['3']);
    //     const mbagala = monthname.map(monthname => data[monthname]['4']);
    //     const magomeni = monthname.map(monthname => data[monthname]['5']);


    //     var ctx = document.getElementById('registration').getContext('2d');

    //     var chart = new Chart(ctx, {
    //       type: 'bar',
    //       data: {
    //         labels: monthname,
    //         datasets: [{
    //           label: 'Amana RRH',
    //           backgroundColor: 'pink',
    //           data: amana
    //         }, {
    //           label: 'Mwananyamala RRH',
    //           backgroundColor: 'blue',
    //           data: mwananyamala
    //         }, {
    //           label: 'Temeke RRH',
    //           backgroundColor: 'yellow',
    //           data: temeke
    //         }, {
    //           label: 'Mbagala Rangi Tatu Hospital',
    //           backgroundColor: 'green',
    //           data: mbagala
    //         }, {
    //           label: 'Magomeni Hospital',
    //           backgroundColor: 'orange',
    //           data: magomeni
    //         }]
    //       },
    //       options: {
    //         scales: {
    //           y: {
    //             beginAtZero: true
    //           }
    //         }
    //       }
    //     });
    //   });



    // fetch('process2.php')
    //   .then(response => response.json())
    //   .then(data => {
    //     const monthname = Object.keys(data);
    //     const amana = monthname.map(monthname => data[monthname]['1']);
    //     const mwananyamala = monthname.map(monthname => data[monthname]['2']);
    //     const temeke = monthname.map(monthname => data[monthname]['3']);
    //     const mbagala = monthname.map(monthname => data[monthname]['4']);
    //     const magomeni = monthname.map(monthname => data[monthname]['5']);


    //     var ctx = document.getElementById('screening').getContext('2d');
    //     var chart = new Chart(ctx, {
    //       type: 'bar',
    //       data: {
    //         labels: monthname,
    //         datasets: [{
    //           label: 'Amana RRH',
    //           backgroundColor: 'pink',
    //           data: amana
    //         }, {
    //           label: 'Mwananyamala RRH',
    //           backgroundColor: 'blue',
    //           data: mwananyamala
    //         }, {
    //           label: 'Temeke RRH',
    //           backgroundColor: 'yellow',
    //           data: temeke
    //         }, {
    //           label: 'Mbagala Rangi Tatu Hospital',
    //           backgroundColor: 'green',
    //           data: mbagala
    //         }, {
    //           label: 'Magomeni Hospital',
    //           backgroundColor: 'orange',
    //           data: magomeni
    //         }]
    //       },
    //       options: {
    //         scales: {
    //           y: {
    //             beginAtZero: true
    //           }
    //         }
    //       }
    //     });
    //   });

    // fetch('process3.php')
    //   .then(response => response.json())
    //   .then(data => {
    //     const monthname = Object.keys(data);
    //     const amana = monthname.map(monthname => data[monthname]['1']);
    //     const mwananyamala = monthname.map(monthname => data[monthname]['2']);
    //     const temeke = monthname.map(monthname => data[monthname]['3']);
    //     const mbagala = monthname.map(monthname => data[monthname]['4']);
    //     const magomeni = monthname.map(monthname => data[monthname]['5']);


    //     var ctx = document.getElementById('eligible').getContext('2d');
    //     var chart = new Chart(ctx, {
    //       type: 'bar',
    //       data: {
    //         labels: monthname,
    //         datasets: [{
    //           label: 'Amana RRH',
    //           backgroundColor: 'pink',
    //           data: amana
    //         }, {
    //           label: 'Mwananyamala RRH',
    //           backgroundColor: 'blue',
    //           data: mwananyamala
    //         }, {
    //           label: 'Temeke RRH',
    //           backgroundColor: 'yellow',
    //           data: temeke
    //         }, {
    //           label: 'Mbagala Rangi Tatu Hospital',
    //           backgroundColor: 'green',
    //           data: mbagala
    //         }, {
    //           label: 'Magomeni Hospital',
    //           backgroundColor: 'orange',
    //           data: magomeni
    //         }]
    //       },
    //       options: {
    //         scales: {
    //           y: {
    //             beginAtZero: true
    //           }
    //         }
    //       }
    //     });
    //   });


    // fetch('process4.php')
    //   .then(response => response.json())
    //   .then(data => {
    //     const monthname = Object.keys(data);
    //     const amana = monthname.map(monthname => data[monthname]['1']);
    //     const mwananyamala = monthname.map(monthname => data[monthname]['2']);
    //     const temeke = monthname.map(monthname => data[monthname]['3']);
    //     const mbagala = monthname.map(monthname => data[monthname]['4']);
    //     const magomeni = monthname.map(monthname => data[monthname]['5']);


    //     var ctx = document.getElementById('enrolled').getContext('2d');
    //     var chart = new Chart(ctx, {
    //       type: 'bar',
    //       data: {
    //         labels: monthname,
    //         datasets: [{
    //           label: 'Amana RRH',
    //           backgroundColor: 'pink',
    //           data: amana
    //         }, {
    //           label: 'Mwananyamala RRH',
    //           backgroundColor: 'blue',
    //           data: mwananyamala
    //         }, {
    //           label: 'Temeke RRH',
    //           backgroundColor: 'yellow',
    //           data: temeke
    //         }, {
    //           label: 'Mbagala Rangi Tatu Hospital',
    //           backgroundColor: 'green',
    //           data: mbagala
    //         }, {
    //           label: 'Magomeni Hospital',
    //           backgroundColor: 'orange',
    //           data: magomeni
    //         }]
    //       },
    //       options: {
    //         scales: {
    //           y: {
    //             beginAtZero: true
    //           }
    //         }
    //       }
    //     });
    //   });


    // fetch('process5.php')
    //   .then(response => response.json())
    //   .then(data => {
    //     const monthname = Object.keys(data);
    //     const amana = monthname.map(monthname => data[monthname]['1']);
    //     const mwananyamala = monthname.map(monthname => data[monthname]['2']);
    //     const temeke = monthname.map(monthname => data[monthname]['3']);
    //     const mbagala = monthname.map(monthname => data[monthname]['4']);
    //     const magomeni = monthname.map(monthname => data[monthname]['5']);


    //     var ctx = document.getElementById('end').getContext('2d');
    //     var chart = new Chart(ctx, {
    //       type: 'bar',
    //       data: {
    //         labels: monthname,
    //         datasets: [{
    //           label: 'Amana RRH',
    //           backgroundColor: 'pink',
    //           data: amana
    //         }, {
    //           label: 'Mwananyamala RRH',
    //           backgroundColor: 'blue',
    //           data: mwananyamala
    //         }, {
    //           label: 'Temeke RRH',
    //           backgroundColor: 'yellow',
    //           data: temeke
    //         }, {
    //           label: 'Mbagala Rangi Tatu Hospital',
    //           backgroundColor: 'green',
    //           data: mbagala
    //         }, {
    //           label: 'Magomeni Hospital',
    //           backgroundColor: 'orange',
    //           data: magomeni
    //         }]
    //       },
    //       options: {
    //         scales: {
    //           y: {
    //             beginAtZero: true
    //           }
    //         }
    //       }
    //     });
    //   });


    // const month = <?php echo json_encode($month) ?>;
    // const amount = <?php echo json_encode($amount) ?>;

    // const data = {
    //   labels: month,
    //   datasets: [{
    //     label: '# of Votes',
    //     data: amount,
    //     backgroundColor: 'rgba(54,162,235,0.2)',
    //     borderColor: 'rgba(54,162,235,1)',
    //     borderWidth: 1
    //   }]
    // }


    // // //CONFIG BLOCK
    // const config = {
    //   type: 'bar',
    //   data,
    //   options: {
    //     scales: {
    //       y: {
    //         beginAtZero: true
    //       }
    //     }
    //   }
    // }

    // // //RENDER BLOCK
    // const myChart = new Chart(document.getElementById('myChart'), config);
  </script>


</body>

</html>