<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index1.php" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="add.php?id=13&status=1&sid=<?= $_GET['sid']; ?>&facility_id=<?= $user->data()->site_id ?>&page=<?= $_GET['page']; ?>"
               class="nav-link">Add Screening</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="info.php?id=3&status=1&sid=<?= $_GET['sid']; ?>&facility_id=<?= $user->data()->site_id ?>&page=<?= $_GET['page']; ?>"
               class="nav-link">Screened</a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
            <a href="info.php?id=3&status=2&sid=<?= $_GET['sid']; ?>&facility_id=<?= $user->data()->site_id ?>&page=<?= $_GET['page']; ?>"
               class="nav-link">Eligible</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="info.php?id=3&status=3&sid=<?= $_GET['sid']; ?>&facility_id=<?= $user->data()->site_id ?>&page=<?= $_GET['page']; ?>"
               class="nav-link">Enrolled</a>
        </li> -->
        <li class="nav-item d-none d-sm-inline-block">
            <a href="logout.php" class="nav-link">Logout</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        ...
    </ul>
</nav>
<!-- /.navbar -->
