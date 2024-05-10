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

// Function to approve booking request
if (isset($_POST['approve_request'])) {
    $request_id = $_POST['request_id'];
    $room_id = $_POST['room_id'];
    $resident_id = $_POST['resident_id'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];

    // Check room availability
    $check_availability_query = "SELECT * FROM rooms WHERE roomID = $room_id AND is_available = 1";
    $check_availability_result = mysqli_query($conn, $check_availability_query);

    if (mysqli_num_rows($check_availability_result) > 0) {
        // Update room availability
        $update_room_query = "UPDATE rooms SET is_available = 0 WHERE roomID = $room_id";
        mysqli_query($conn, $update_room_query);

        // Update booking status
        $update_booking_query = "UPDATE booking_requests SET is_approved = 1 WHERE id = $request_id";
        mysqli_query($conn, $update_booking_query);

        // Send confirmation email to student
        $to = "student@example.com"; // Student's email address
        $subject = "Booking Confirmation";
        $message = "Your booking request has been approved.\n\nRoom Number: $room_id\nCheck-in Date: $check_in_date\nCheck-out Date: $check_out_date\n\nThank you!";
        $headers = "From: admin@example.com"; // Your hostel's email address
        mail($to, $subject, $message, $headers);

        echo "<script>alert('Booking request approved successfully. Confirmation email sent to the student.'); window.location.href='view_booking_requests.php'; </script>";
    } else {
        echo "<script>alert('The selected room is not available for the requested dates. Please choose another room.'); window.location.href='view_booking_requests.php'; </script>";
    }
}

// Function to reject booking request
if (isset($_POST['reject_request'])) {
    $request_id = $_POST['request_id'];

    // Update booking status
    $update_booking_query = "UPDATE booking_requests SET is_approved = -1 WHERE id = $request_id";
    mysqli_query($conn, $update_booking_query);

    echo "<script>alert('Booking request rejected successfully.'); window.location.href='view_booking_requests.php'; </script>";
}

// Fetching booking requests
$query = "SELECT br.id, r.r_name, br.room_id, br.check_in_date, br.check_out_date, ro.roomNumber, r.r_id
          FROM booking_requests br
          INNER JOIN resident r ON br.resident_id = r.r_id
          INNER JOIN rooms ro ON br.room_id = ro.roomID";
$result = mysqli_query($conn, $query);

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">View Booking Requests</h1>

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Student Name</th>
                            <th>Requested Room</th>
                            <th>Check-in Date</th>
                            <th>Check-out Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Request ID</th>
                            <th>Student Name</th>
                            <th>Requested Room</th>
                            <th>Check-in Date</th>
                            <th>Check-out Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['r_name'] . "</td>";
                            echo "<td>" . $row['roomNumber'] . "</td>";
                            echo "<td>" . $row['check_in_date'] . "</td>";
                            echo "<td>" . $row['check_out_date'] . "</td>";
                            echo "<td>
                                    <form method='post'>
                                        <input type='hidden' name='request_id' value='" . $row['id'] . "'>
                                        <input type='hidden' name='room_id' value='" . $row['room_id'] . "'>
                                        <input type='hidden' name='resident_id' value='" . $row['r_id'] . "'>
                                        <input type='hidden' name='check_in_date' value='" . $row['check_in_date'] . "'>
                                        <input type='hidden' name='check_out_date' value='" . $row['check_out_date'] . "'>
                                        <button type='submit' name='approve_request' class='btn btn-success'>Approve</button>
                                        <button type='submit' name='reject_request' class='btn btn-danger'>Reject</button>
                                    </form>
                                  </td>";
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
