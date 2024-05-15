<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HostelStays (Admin-Panel)</title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../images/hostelstays.ico" />

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom css for this template-->
    <link href="../css/custom.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php" <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'style="color: #fff;"' : ''; ?>>
                <div class="sidebar-brand-icon">
                    <img src="../images/hostelstays.png" alt="" width="32" height="32" />
                </div>
                <div class="sidebar-brand-text mx-3">HostelStays</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Features
            </div>

            <!-- Nav Item - Residents Collapse Menu -->
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'viewResident.php' || basename($_SERVER['PHP_SELF']) == 'registerResident.php' ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseResidents" aria-expanded="true" aria-controls="collapseResidents">
                    <i class="bi bi-people-fill"></i>
                    <span>Residents</span>
                </a>
                <div id="collapseResidents" class="collapse" aria-labelledby="headingResidents" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Residents Management:</h6>
                        <a class="collapse-item" href="viewResident.php">View Residents</a>
                        <a class="collapse-item" href="registerResident.php">Register Residents</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - staffs Collapse Menu -->
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'registerstaff.php' || basename($_SERVER['PHP_SELF']) == 'viewstaff.php' ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsestaffs" aria-expanded="true" aria-controls="collapsestaffs">
                    <i class="bi bi-person-circle"></i>
                    <span>Staffs</span>
                </a>
                <div id="collapsestaffs" class="collapse" aria-labelledby="headingstaffs" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Staff Management:</h6>
                        <a class="collapse-item" href="viewstaff.php">View staffs</a>
                        <a class="collapse-item" href="registerstaff.php">Register staff</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Rooms Collapse Menu -->
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'viewRoom.php' || basename($_SERVER['PHP_SELF']) == 'addRoom.php' || basename($_SERVER['PHP_SELF']) == 'assignRoom.php' ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRooms" aria-expanded="true" aria-controls="collapseRooms">
                    <i class="bi bi-house-fill"></i>
                    <span>Rooms</span>
                </a>
                <div id="collapseRooms" class="collapse" aria-labelledby="headingRooms" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Room Management:</h6>
                        <a class="collapse-item" href="viewRoom.php">View Rooms</a>
                        <a class="collapse-item" href="addRoom.php">Add Rooms</a>
                        <a class="collapse-item" href="assignRoom.php">Assign Rooms</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Bookings Collapse Menu -->
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'bookings.php' ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBookings" aria-expanded="true" aria-controls="collapseBookings">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Bookings</span>
                </a>
                <div id="collapseBookings" class="collapse" aria-labelledby="headingBookings" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Booking System:</h6>
                        <a class="collapse-item" href="bookings.php">View Request</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Notice Collapse Menu -->
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'viewNotice.php' || basename($_SERVER['PHP_SELF']) == 'addNotice.php' ? 'active' : ''; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNotice" aria-expanded="true" aria-controls="collapseNotice">
                    <i class="bi bi-clipboard2-fill"></i>
                    <span>Notice</span>
                </a>
                <div id="collapseNotice" class="collapse" aria-labelledby="headingNotice" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Notice Management:</h6>
                        <a class="collapse-item" href="viewNotice.php">View Notice</a>
                        <a class="collapse-item" href="addNotice.php">Add Notice</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Reports -->
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'reports.php' ? 'active' : ''; ?>">
                <a class="nav-link" href="reports.php">
                    <i class="bi bi-journals"></i>
                    <span>Reports</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Welcome Admin!</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="changePassword.php">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->