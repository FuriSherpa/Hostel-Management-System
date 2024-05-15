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

    // Check room capacity
    $check_capacity_query = "SELECT currentOccupancy, capacity FROM rooms WHERE roomID = $room_id";
    $check_capacity_result = mysqli_query($conn, $check_capacity_query);
    $room_data = mysqli_fetch_assoc($check_capacity_result);
    $current_occupancy = $room_data['currentOccupancy'];
    $capacity = $room_data['capacity'];

    if ($current_occupancy < $capacity) {
        $current_occupancy += 1;
        $status = ($current_occupancy == $capacity) ? 'Occupied' : 'Available';

        // Update room occupancy and status
        $update_room_query = "UPDATE rooms SET currentOccupancy = $current_occupancy, roomStatus = '$status' WHERE roomID = $room_id";
        mysqli_query($conn, $update_room_query);

        // Update resident roomID, status, check-in, and check-out dates
        $update_resident_query = "UPDATE resident SET roomID = $room_id, paymentStatus = 'Pending', checkInDate = '$check_in_date', checkOutDate = '$check_out_date' WHERE r_id = $resident_id";
        mysqli_query($conn, $update_resident_query);

        // Update booking status
        $update_booking_query = "UPDATE booking_requests SET status = 'Accepted' WHERE id = $request_id";
        mysqli_query($conn, $update_booking_query);

        $success_message = "Booking request approved successfully.";
    } else {
        $error_message = "The selected room has reached maximum capacity. Please choose another room.";
    }
}

// Function to reject booking request
if (isset($_POST['reject_request'])) {
    $request_id = $_POST['request_id'];

    // Update booking status
    $update_booking_query = "UPDATE booking_requests SET status = 'Rejected' WHERE id = $request_id";
    mysqli_query($conn, $update_booking_query);

    $success_message = "Booking request rejected successfully.";
}

// Filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'All';
$filter_condition = '';
if ($filter != 'All') {
    $filter_condition = "AND status = '$filter'";
}

// Fetching booking requests
$query = "SELECT br.id, r.r_name, br.room_id, br.check_in_date, br.check_out_date, ro.roomNumber, r.r_id, br.status
          FROM booking_requests br
          INNER JOIN resident r ON br.resident_id = r.r_id
          INNER JOIN rooms ro ON br.room_id = ro.roomID
          WHERE 1 $filter_condition";
$result = mysqli_query($conn, $query);

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">View Booking Requests</h1>

    <div class="row">
        <div class="col-lg-12">
            <?php
            if (isset($success_message)) {
                echo "<div id='success_message' class='alert alert-success'>$success_message</div>";
            } elseif (isset($error_message)) {
                echo "<div id='error_message' class='alert alert-danger'>$error_message</div>";
            }
            ?>
            <div class="form-group">
                <label for="filter">Filter:</label>
                <select class="form-control" id="filter" name="filter" onchange="filter()">
                    <option value="All" <?php if ($filter == 'All') echo 'selected'; ?>>All</option>
                    <option value="Pending" <?php if ($filter == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Accepted" <?php if ($filter == 'Accepted') echo 'selected'; ?>>Accepted</option>
                    <option value="Rejected" <?php if ($filter == 'Rejected') echo 'selected'; ?>>Rejected</option>
                </select>
            </div>
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
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['r_name'] . "</td>";
                            echo "<td>" . $row['roomNumber'] . "</td>";
                            echo "<td>" . $row['check_in_date'] . "</td>";
                            echo "<td>" . $row['check_out_date'] . "</td>";
                            echo "<td>";
                            if ($row['status'] == 'Pending') {
                                echo "<form method='post'>
                                        <input type='hidden' name='request_id' value='" . $row['id'] . "'>
                                        <input type='hidden' name='room_id' value='" . $row['room_id'] . "'>
                                        <input type='hidden' name='resident_id' value='" . $row['r_id'] . "'>
                                        <input type='hidden' name='check_in_date' value='" . $row['check_in_date'] . "'>
                                        <input type='hidden' name='check_out_date' value='" . $row['check_out_date'] . "'>
                                        <button type='submit' name='approve_request' class='btn btn-success'>Approve</button>
                                        <button type='submit' name='reject_request' class='btn btn-danger'>Reject</button>
                                    </form>";
                            } else {
                                echo $row['status'];
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

<script>
    function filter() {
        var filter = document.getElementById("filter").value;
        window.location.href = "bookings.php?filter=" + filter;
    }

    // Automatically hide success and error messages after 2 seconds
    window.setTimeout(function() {
        $("#success_message, #error_message").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 2000);
</script>

<?php
include("include/footer.php");
?>