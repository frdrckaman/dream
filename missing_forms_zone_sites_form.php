<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

// Capture filters
$filter_zone = Input::get('zone_id');
$filter_site = Input::get('site_id');

// Fetch site data for table display
if ($filter_zone && $filter_site) {
    $site_data = $override->getNews('sites', 'zone', $filter_zone, 'id', $filter_site);
} elseif ($filter_zone) {
    $site_data = $override->getNews('sites', 'zone', $filter_zone, 'status', 1);
} elseif ($filter_site) {
    $site_data = $override->getNews('sites', 'id', $filter_site, 'status', 1);
} else {
    $site_data = $override->get('sites', 'status', 1);
}

// Fetch zones and sites for dropdowns
$zones = $override->get('zones', 'status', 1);
$sites_dropdown = $filter_zone ? $override->getNews('sites', 'zone', $filter_zone, 'status', 1) : $override->get('sites', 'status', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | Summary Report</title>
  <!-- AdminLTE & Bootstrap -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="assets/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    .no-data { text-align: center; font-style: italic; color: #888; }
    .report-title { font-weight: bold; font-size: 1.5rem; }
    .card-header { font-weight: bold; background-color: #0d6efd; color: #fff; }
    .table thead th { background-color: #0d6efd; color: #fff; }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include 'navbar.php'; ?>
  <!-- Sidebar -->
  <?php include 'sidemenu.php'; ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Summary Report</h1>
            <small class="text-muted">National Institute for Medical Research</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

        <!-- Filter Card -->
        <div class="card shadow-sm mb-4">
          <div class="card-header">Filter Report</div>
          <div class="card-body">
            <form method="get" action="">
              <div class="row g-3 align-items-end">
                <!-- Zone -->
                <div class="col-md-4">
                  <label for="zone_id" class="form-label">Zone</label>
                  <select name="zone_id" id="zone_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- All Zones --</option>
                    <?php foreach ($zones as $zone): ?>
                      <option value="<?= $zone['id'] ?>" <?= ($filter_zone == $zone['id']) ? 'selected' : '' ?>><?= $zone['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <!-- Site -->
                <div class="col-md-4">
                  <label for="site_id" class="form-label">Site</label>
                  <select name="site_id" id="site_id" class="form-select">
                    <option value="">-- All Sites --</option>
                    <?php foreach ($sites_dropdown as $site): ?>
                      <option value="<?= $site['id'] ?>" <?= ($filter_site == $site['id']) ? 'selected' : '' ?>><?= $site['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-md-4 d-grid">
                  <button type="submit" class="btn btn-primary">Apply Filter</button>
                </div>
              </div>
            </form>

            <div class="mt-3 text-end">
              <a href="missing_forms_zone_sites.php?zone_id=<?= $filter_zone ?>&site_id=<?= $filter_site ?>" target="_blank" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Download PDF
              </a>
            </div>
          </div>
        </div>

        <!-- Summary Table -->
        <div class="card shadow-sm">
          <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
              <thead>
                <tr>
                  <th class="text-center">Site ID</th>
                  <th>Site Name</th>
                  <th>Zone</th>
                </tr>
              </thead>
              <tbody>
              <?php if (!empty($site_data)): ?>
                <?php foreach ($site_data as $row): ?>
                  <tr>
                    <td class="text-center"><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['zone'] ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="3" class="no-data">No data available for selected filters</td>
                </tr>
              <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
