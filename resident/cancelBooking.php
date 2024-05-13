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

    // Fetch resident id from database
    $sql = "SELECT r_id FROM resident WHERE r_email = '$rLogEmail'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $resident_id = $row['r_id'];

    // Fetch booking request status
    $sql_booking = "SELECT * FROM booking_requests WHERE resident_id = '$resident_id'";
    $result_booking = $conn->query($sql_booking);
} else {
    echo  "<script> location.href='../index.php'; </script>";
}

// Cancel booking request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cancel"])) {
    $booking_id = $_POST['booking_id'];
    $cancel_sql = "UPDATE booking_requests SET status = 'Cancelled' WHERE id = $booking_id";
    if (mysqli_query($conn, $cancel_sql)) {
        // Refresh page
        echo "<script>window.location = 'cancelBooking.php';</script>";
    } else {
        echo "<script>alert('Error cancelling booking: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Booking Request Status</h1>

    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Check-in Date</th>
                        <th>Check-out Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_booking->num_rows > 0) {
                        while ($row_booking = $result_booking->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row_booking['id'] . "</td>";
                            echo "<td>" . $row_booking['room_id'] . "</td>";
                            echo "<td>" . $row_booking['room_type'] . "</td>";
                            echo "<td>" . $row_booking['check_in_date'] . "</td>";
                            echo "<td>" . $row_booking['check_out_date'] . "</td>";
                            echo "<td>" . $row_booking['status'] . "</td>";
                            echo "<td>";
                            if ($row_booking['status'] != 'Cancelled') {
                                echo "<form method='post' style='display:inline;'>";
                                echo "<input type='hidden' name='booking_id' value='" . $row_booking['id'] . "'>";
                                echo "<button type='submit' class='btn btn-danger btn-sm' name='cancel'>Cancel</button>";
                                echo "</form>";
                            } else {
                                echo "Cancelled";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No booking requests found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php");
?>