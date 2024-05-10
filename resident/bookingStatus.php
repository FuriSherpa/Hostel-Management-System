<?php
// Start session if not already started
if (!isset($_SESSION)) {
    session_start();
}

include('include/header.php');

// Include database connection
include("../mainInclude/dbConn.php");

if (isset($_SESSION["is_login"])) {
    $rLogEmail = $_SESSION['rLogEmail'];
} else {
    echo  "<script> location.href='../index.php'; </script>";
}

// Fetch booking requests for the resident
$query = "SELECT br.id, br.is_approved, ro.roomNumber, br.check_in_date, br.check_out_date
          FROM booking_requests br
          INNER JOIN rooms ro ON br.room_id = ro.roomID
          WHERE br.resident_email = '$rLogEmail'";
$result = mysqli_query($conn, $query);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Booking Request Status</h1>

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Room Number</th>
                            <th>Check-in Date</th>
                            <th>Check-out Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Request ID</th>
                            <th>Room Number</th>
                            <th>Check-in Date</th>
                            <th>Check-out Date</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['roomNumber'] . "</td>";
                            echo "<td>" . $row['check_in_date'] . "</td>";
                            echo "<td>" . $row['check_out_date'] . "</td>";
                            echo "<td>";
                            if ($row['is_approved'] == 1) {
                                echo "Approved";
                            } elseif ($row['is_approved'] == -1) {
                                echo "Rejected";
                            } else {
                                echo "Pending";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php");
?>