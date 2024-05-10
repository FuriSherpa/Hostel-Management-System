<?php
// Start session if not already started
if (!isset($_SESSION)) {
    session_start();
}

include('include/header.php');

// Include database connection
include("../mainInclude/dbConn.php");

$success_msg = '';

if (isset($_SESSION["is_login"])) {
    $rLogEmail = $_SESSION['rLogEmail'];

    // Fetch resident id from database
    $sql = "SELECT r_id FROM resident WHERE r_email = '$rLogEmail'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $resident_id = $row['r_id'];
} else {
    echo  "<script> location.href='../index.php'; </script>";
}

// Fetch available rooms
$sql_rooms = "SELECT roomID, roomNumber, roomType FROM rooms WHERE roomStatus = 'Available'";
$result_rooms = $conn->query($sql_rooms);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $room_id = $_POST['room_id'];
    $room_type = $_POST['room_type'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $special_requirements = $_POST['special_requirements'];

    // Insert booking request into database
    $sql = "INSERT INTO booking_requests (resident_id, room_id, room_type, check_in_date, check_out_date, special_requirements) 
            VALUES ('$resident_id', '$room_id', '$room_type', '$check_in_date', '$check_out_date', '$special_requirements')";

    if (mysqli_query($conn, $sql)) {
        $success_msg = "Booking request submitted successfully";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Reserve Room</h1>

    <!-- Booking Form -->
    <div class="row">
        <div class="col-md-6">
            <?php if ($success_msg) : ?>
                <div class="alert alert-success" role="alert" id="success_msg">
                    <?php echo $success_msg; ?>
                </div>
            <?php endif; ?>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="bookingForm" onsubmit="return confirmBooking()">
                <div class="form-group">
                    <label for="room_id">Room Number</label>
                    <select class="form-control" id="room_id" name="room_id" required onchange="getRoomType(this)">
                        <option value="">Select Room Number</option>
                        <?php
                        $result_rooms = $conn->query($sql_rooms); // Resetting the result set
                        while ($row_rooms = $result_rooms->fetch_assoc()) {
                            echo "<option value='" . $row_rooms['roomID'] . "' data-roomtype='" . $row_rooms['roomType'] . "'>" . $row_rooms['roomNumber'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="room_type">Room Type</label>
                    <input type="text" class="form-control" id="room_type" name="room_type" readonly required>
                </div>
                <div class="form-group">
                    <label for="check_in_date">Check-in Date</label>
                    <input type="date" class="form-control" id="check_in_date" name="check_in_date" required>
                </div>
                <div class="form-group">
                    <label for="check_out_date">Check-out Date</label>
                    <input type="date" class="form-control" id="check_out_date" name="check_out_date" required>
                </div>
                <div class="form-group">
                    <label for="special_requirements">Special Requirements</label>
                    <textarea class="form-control" id="special_requirements" name="special_requirements" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit Booking Request</button>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<script>
    // Function to fetch room type based on selected room number
    function getRoomType(select) {
        var room_type = document.getElementById('room_type');
        var roomType = select.options[select.selectedIndex].getAttribute('data-roomtype');
        room_type.value = roomType;
    }

    // Function to confirm booking and show success message
    function confirmBooking() {
        var confirm_msg = "Please confirm your booking details:\n\n";
        confirm_msg += "Room Number: " + document.getElementById('room_id').value + "\n";
        confirm_msg += "Room Type: " + document.getElementById('room_type').value + "\n";
        confirm_msg += "Check-in Date: " + document.getElementById('check_in_date').value + "\n";
        confirm_msg += "Check-out Date: " + document.getElementById('check_out_date').value + "\n";
        confirm_msg += "Special Requirements: " + document.getElementById('special_requirements').value + "\n";

        if (confirm(confirm_msg)) {
            document.getElementById('success_msg').style.display = 'block'; // Show success message
            setTimeout(function() {
                document.getElementById('success_msg').style.display = 'none';
                document.getElementById('bookingForm').reset(); // Reset form after submission
            }, 2000); // Hide success message and reset form after 2 seconds
            return true;
        } else {
            return false;
        }
    }
</script>

<?php
include("include/footer.php");
?>