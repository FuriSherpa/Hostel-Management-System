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

if(isset($_POST['generate_payment_report'])) {
    // Fetch payment data from the database
    $query = "SELECT r.r_id, r.r_name, r.r_email, r.roomID, r.paymentStatus, r.CheckInDate, r.CheckOutDate, 
                     b.check_in_date, b.check_out_date, b.status
              FROM resident r
              LEFT JOIN booking_requests b ON r.r_id = b.resident_id
              WHERE r.paymentStatus != 'Paid' OR b.status != 'Cancelled'";
    $result = mysqli_query($conn, $query);

    // Generate payment report
    $payment_report = array();
    while($row = mysqli_fetch_assoc($result)) {
        $payment_report[] = $row;
    }
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Payment Report</h1>

    <!-- Payment Report Form -->
    <form method="post" action="">
        <button type="submit" class="btn btn-primary" name="generate_payment_report">Generate Payment Report</button>
    </form>

    <!-- Payment Report Table -->
    <?php if(isset($payment_report) && !empty($payment_report)): ?>
    <div class="mt-4">
        <h3>Payment Report</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Resident ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Room ID</th>
                    <th>Check-In Date</th>
                    <th>Check-Out Date</th>
                    <th>Payment Status</th>
                    <th>Booking Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($payment_report as $row): ?>
                <tr>
                    <td><?php echo $row['r_id']; ?></td>
                    <td><?php echo $row['r_name']; ?></td>
                    <td><?php echo $row['r_email']; ?></td>
                    <td><?php echo $row['roomID']; ?></td>
                    <td><?php echo $row['CheckInDate']; ?></td>
                    <td><?php echo $row['CheckOutDate']; ?></td>
                    <td><?php echo $row['paymentStatus']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php");
?>
