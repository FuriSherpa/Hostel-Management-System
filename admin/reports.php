<?php
if (!isset($_SESSION)) {
    session_start();
}

include("include/header.php");
include("../mainInclude/dbConn.php");

if (!isset($_SESSION['is_admin_login'])) {
    echo "<script> location.href='../index.php'; </script>";
    exit;
}

// Check if the month is specified
if (isset($_GET['month']) && !empty($_GET['month'])) {
    $selected_month = $_GET['month'];
} else {
    // Default to the current month if not specified
    $selected_month = date('Y-m');
}

// Extract year and month from the selected month
list($year, $month) = explode('-', $selected_month);

// Query to fetch revenue breakdown by room type and duration of stay for the selected month
$sql = "SELECT r.roomType, 
               SUM(r.roomFees) AS totalRevenue, 
               COUNT(*) AS bookingsCount
        FROM rooms r
        JOIN resident rs ON r.roomID = rs.roomID
        WHERE YEAR(rs.CheckInDate) = $year 
              AND MONTH(rs.CheckInDate) = $month
        GROUP BY r.roomType";

$result = mysqli_query($conn, $sql);

// Query to calculate revenue received for the selected month
$sql_received = "SELECT SUM(roomFees) AS totalReceived FROM rooms 
                JOIN resident ON rooms.roomID = resident.roomID
                WHERE paymentStatus = 'paid' 
                      AND YEAR(CheckInDate) = $year 
                      AND MONTH(CheckInDate) = $month";

$result_received = mysqli_query($conn, $sql_received);
$row_received = mysqli_fetch_assoc($result_received);
$totalReceived = $row_received['totalReceived'];

// Query to calculate revenue pending for the selected month
$sql_pending = "SELECT SUM(roomFees) AS totalPending FROM rooms 
                JOIN resident ON rooms.roomID = resident.roomID
                WHERE paymentStatus = 'pending' 
                      AND YEAR(CheckInDate) = $year 
                      AND MONTH(CheckInDate) = $month";

$result_pending = mysqli_query($conn, $sql_pending);
$row_pending = mysqli_fetch_assoc($result_pending);
$totalPending = $row_pending['totalPending'];

// Prepare data for revenue breakdown chart
$labels = [];
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['roomType'];
    $data[] = $row['totalRevenue'];
}

// Prepare data for payment status chart
$payment_labels = ['Received', 'Pending'];
$payment_data = [$totalReceived, $totalPending];
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Monthly Revenue Report - <?php echo date('F Y', strtotime($selected_month)); ?></h1>

    <!-- Filter to select different months -->
    <div class="row mb-4">
        <div class="col-md-4">
            <form method='GET'>
                <div class="form-group">
                    <label for='month'>Select Month:</label>
                    <input type='month' id='month' name='month' value='<?php echo $selected_month; ?>' class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Show</button>
            </form>
        </div>
    </div>

    <!-- Display the revenue breakdown table -->
    <div class='card shadow mb-4'>
        <div class='card-header py-3'>
            <h6 class='m-0 font-weight-bold text-primary'>Revenue Breakdown</h6>
        </div>
        <div class='card-body'>
            <div class='table-responsive'>
                <table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                    <thead>
                        <tr>
                            <th>Room Type</th>
                            <th>Total Revenue (Rs)</th>
                            <th>Bookings Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        mysqli_data_seek($result, 0); // Reset result pointer
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['roomType'] . "</td>";
                            echo "<td>Rs " . $row['totalRevenue'] . "</td>";
                            echo "<td>" . $row['bookingsCount'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Display total received and total pending -->
    <div class='card shadow mb-4'>
        <div class='card-body'>
            <div class='row'>
                <div class='col-md-6'>
                    <h4 class='text-gray-800'>Total Revenue Received: Rs <?php echo $totalReceived; ?></h4>
                </div>
                <div class='col-md-6'>
                    <h4 class='text-gray-800'>Total Revenue Pending: Rs <?php echo $totalPending; ?></h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Display revenue breakdown chart and payment status chart in the same row -->
    <div class='row'>

        <!-- Revenue breakdown chart -->
        <div class='col-lg-6 mb-4'>
            <div class='card shadow'>
                <div class='card-header py-3'>
                    <h6 class='m-0 font-weight-bold text-primary'>Revenue Breakdown Chart</h6>
                </div>
                <div class='card-body'>
                    <canvas id='revenueChart' height='300'></canvas>
                </div>
            </div>
        </div>

        <!-- Payment status chart -->
        <div class='col-lg-6 mb-4'>
            <div class='card shadow'>
                <div class='card-header py-3'>
                    <h6 class='m-0 font-weight-bold text-primary'>Payment Status Chart</h6>
                </div>
                <div class='card-body'>
                    <canvas id='paymentChart' height='300'></canvas>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include("include/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue breakdown chart
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Total Revenue (Rs)',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return 'Rs ' + value;
                        }
                    }
                }
            }
        }
    });

    // Payment status chart
    var ctx2 = document.getElementById('paymentChart').getContext('2d');
    var paymentChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($payment_labels); ?>,
            datasets: [{
                label: 'Payment Status',
                data: <?php echo json_encode($payment_data); ?>,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                }
            }
        }
    });
</script>