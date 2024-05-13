<?php
if (!isset($_SESSION)) {
    session_start();
}

include("include/header.php");
include("../mainInclude/dbConn.php");

if (!isset($_SESSION['is_admin_login'])) {
    echo "<script> location.href='../index.php'; </script>";
}

// Fetch data from the database
$query = "SELECT * FROM resident";
$result = mysqli_query($conn, $query);

// Check if the form is submitted
if (isset($_POST['generate_report'])) {
    $selected_month = $_POST['selected_month'];

    // Query to fetch revenue data
    $revenue_query = "SELECT 
                        SUM(r.roomFees) AS total_revenue,
                        r.roomType,
                        COUNT(br.id) AS bookings_count,
                        SUM(DATEDIFF(br.check_out_date, br.check_in_date)) AS total_stay_days
                    FROM 
                        rooms r
                    INNER JOIN 
                        booking_requests br ON r.roomID = br.room_id
                    WHERE 
                        MONTH(br.check_in_date) = '$selected_month'
                    GROUP BY 
                        r.roomType";

    $revenue_result = mysqli_query($conn, $revenue_query);
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Monthly Revenue Report</h1>

    <!-- Revenue Report Form -->
    <div class="row">
        <div class="col-md-6">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="selected_month">Select Month:</label>
                    <select class="form-control" id="selected_month" name="selected_month">
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="generate_report">Generate Report</button>
            </form>
        </div>
    </div>

    <!-- Revenue Report Table -->
    <?php if (isset($revenue_result) && mysqli_num_rows($revenue_result) > 0) { ?>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Monthly Revenue Report for <?php echo date("F", mktime(0, 0, 0, $selected_month, 1)); ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Room Type</th>
                                        <th>Bookings Count</th>
                                        <th>Total Stay Days</th>
                                        <th>Total Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($revenue_result)) { ?>
                                        <tr>
                                            <td><?php echo $row['roomType']; ?></td>
                                            <td><?php echo $row['bookings_count']; ?></td>
                                            <td><?php echo $row['total_stay_days']; ?></td>
                                            <td>$<?php echo $row['total_revenue']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php")
?>