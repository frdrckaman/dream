<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

if ($user->isLoggedIn()) {
    try {
        // Capture filters from GET
        $filter_zone = Input::get('zone_id');
        $filter_site = Input::get('site_id');

        // Fetch site data based on filter for table display
        if ($filter_zone && $filter_site) {
            $site_data = $override->getNews('sites', 'zone', $filter_zone, 'id', $filter_site);
        } elseif ($filter_zone) {
            $site_data = $override->getNews('sites', 'zone', $filter_zone, 'status', 1);
        } elseif ($filter_site) {
            $site_data = $override->getNews('sites', 'id', $filter_site, 'status', 1);
        } else {
            $site_data = $override->get('sites', 'status', 1);
        }

        // Fetch sites for the Site dropdown dynamically based on selected zone
        if ($filter_zone) {
            $sites_dropdown = $override->getNews('sites', 'zone', $filter_zone, 'status', 1);
        } else {
            $sites_dropdown = $override->get('sites', 'status', 1);
        }

    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    Redirect::to('login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Summary Report</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .report-title { font-weight: bold; font-size: 1.5rem; }
        .card-header { font-weight: bold; background-color: #0d6efd; color: #fff; }
        .table thead th { background-color: #0d6efd; color: #fff; }
        .btn-danger { background-color: #dc3545; border: none; }
        .btn-danger:hover { background-color: #c82333; }
        .no-data { text-align: center; font-style: italic; color: #888; }
    </style>
</head>
<body>
<div class="container mt-5">
    <!-- Page Title -->
    <div class="mb-4 text-center">
        <div class="report-title">Summary Report</div>
        <small class="text-muted">National Institute for Medical Research</small>
    </div>

    <!-- Filter Card -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header">Filter Report</div>
        <div class="card-body">
            <form method="get" action="">
                <div class="row g-3 align-items-end">
                    <!-- Zone Dropdown -->
                    <div class="col-md-4">
                        <label for="zone_id" class="form-label">Zone</label>
                        <select name="zone_id" id="zone_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- All Zones --</option>
                            <?php
                            $zones = $override->get('zones', 'status', 1);
                            foreach ($zones as $zone) {
                                $selected = ($filter_zone == $zone['id']) ? 'selected' : '';
                                echo "<option value='{$zone['id']}' $selected>{$zone['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Site Dropdown -->
                    <div class="col-md-4">
                        <label for="site_id" class="form-label">Site</label>
                        <select name="site_id" id="site_id" class="form-select">
                            <option value="">-- All Sites --</option>
                            <?php
                            foreach ($sites_dropdown as $site) {
                                $selected = ($filter_site == $site['id']) ? 'selected' : '';
                                echo "<option value='{$site['id']}' $selected>{$site['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Apply Filter Button -->
                    <div class="col-md-4 d-grid">
                        <button type="submit" class="btn btn-primary">Apply Filter</button>
                    </div>
                </div>
            </form>

            <!-- Download PDF Button -->
            <div class="mt-3 text-end">
                <a href="missing_forms_zone_sites.php?zone_id=<?= $filter_zone ?>&site_id=<?= $filter_site ?>" target="_blank" class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i> Download PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Summary Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
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

<script src="assets/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>
