<?php
if (!isset($_SESSION)) {
    session_start();
}

include("include/header.php");
include("../mainInclude/dbConn.php");

if (!isset($_SESSION['is_admin_login'])) {
    echo "<script> location.href='../index.php'; </script>";
}
?>

<div class="container-fluid">

    <!-- Page Heading with dynamic greeting -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Employee Card -->
        <?php
        // Query to fetch total number of stafs
        $query1 = "SELECT COUNT(*) AS total_staffs FROM staff";
        $result1 = mysqli_query($conn, $query1);

        if ($result1) {
            $row = mysqli_fetch_assoc($result1);
            $total_staffs = $row['total_staffs'];
        } else {
            $total_staffs = 0;
        }
        ?>


        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Employee</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_staffs; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-square fa-2x text-gray-300 height='18px' width='18px'"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Employee card ends -->

        <!-- Resident Card -->
        <?php
        // Query to fetch total number of residents
        $query2 = "SELECT COUNT(*) AS total_residents FROM resident";
        $result2 = mysqli_query($conn, $query2);

        if ($result2) {
            $row = mysqli_fetch_assoc($result2);
            $total_residents = $row['total_residents'];
        } else {
            $total_residents = 0;
        }
        ?>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Residents</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_residents; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people-fill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Resident Card Ends -->

        <!-- Room Card -->
        <?php
        // Query to fetch total number of rooms
        $query3 = "SELECT COUNT(*) AS total_rooms FROM rooms";
        $result3 = mysqli_query($conn, $query3);

        if ($result3) {
            $row = mysqli_fetch_assoc($result3);
            $total_rooms = $row['total_rooms'];
        } else {
            $total_rooms = 0;
        }
        ?>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Rooms</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_rooms; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-house-fill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Rooms card ends -->

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Booking Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">3 work on this later</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Row -->

    <!-- View announcement -->
    <!-- Page Heading -->
    <h1 class="h4 mb-4 text-gray-800">Notice</h1>

    <!-- Displaying first four notices -->
    <div class="row">
        <?php
        // Fetch announcements from database
        $sql = "SELECT * FROM announcements";
        if (isset($_GET['category_filter']) && $_GET['category_filter'] != '') {
            $category_filter = $_GET['category_filter'];
            $sql .= " WHERE FIND_IN_SET($category_filter, category_ids)";
        }
        $sql .= " ORDER BY created_at DESC"; // Order by created_at in descending order (most recent first)
        $sql .= " LIMIT 4"; // Limiting to first four notices
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row["title"]; ?></h5>
                            <p class="card-text"><?php echo $row["content"]; ?></p>
                            <p class="card-text"><strong>Target Audience:</strong> <?php echo $row["target_audience"]; ?></p>

                            <?php
                            // Display categories
                            $category_ids = explode(",", $row["category_ids"]);
                            ?>
                            <p class="card-text"><strong>Categories:</strong>
                                <?php
                                foreach ($category_ids as $category_id) {
                                    $category_sql = "SELECT name FROM announcement_categories WHERE id=$category_id";
                                    $category_result = $conn->query($category_sql);
                                    if ($category_result->num_rows > 0) {
                                        $category_row = $category_result->fetch_assoc();
                                        echo $category_row["name"] . ", ";
                                    }
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php
            }
        } else {
            ?>
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    No announcements found.
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- Displaying first four notices ends -->

    <!-- View More button -->
    <div class="text-center mt-4">
        <a href="viewNotice.php" class="btn btn-primary">View More</a>
    </div>
    <!-- View More button ends -->

    <!-- View announcements ends -->

</div>

<?php
include("include/footer.php");
?>