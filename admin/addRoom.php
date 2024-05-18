<?php
if (!isset($_SESSION)) {
    session_start();
}

include("include/header.php");
include("../mainInclude/dbConn.php");

if (!isset($_SESSION['is_admin_login'])) {
    echo "<script> location.href='../index.php'; </script>";
}

$msg = ""; // Initialize empty message variable

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data and insert into the database
    $roomNumber = $_POST['roomNumber'];
    $capacity = $_POST['capacity'];
    $roomType = $_POST['roomType'];
    $roomFees = $_POST['roomFees'];
    $status = "Available"; // Set the status to "Available"

    // Check if the room number already exists
    $checkQuery = "SELECT * FROM rooms WHERE roomNumber='$roomNumber'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $msg = "Room number already exists. Please choose a different room number.";
    } else {
        // Perform database insertion
        $query = "INSERT INTO rooms (roomNumber, capacity, roomType, roomFees, roomStatus) VALUES ('$roomNumber', '$capacity', '$roomType', '$roomFees', '$status')";
        $result = mysqli_query($conn, $query);

        // Check if insertion was successful
        if ($result) {
            // Set success message
            $msg = "Room added successfully!";
        } else {
            // Set error message
            $msg = "Error adding room. Please try again.";
        }
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add Rooms</h1>

    <!-- Display message if exists -->
    <?php if (!empty($msg)) : ?>
        <div id="msg" class="alert <?php echo ($result ? 'alert-success' : 'alert-danger'); ?>" role="alert">
            <?php echo $msg; ?>
        </div>
    <?php endif; ?>

    <!-- Room Addition Form -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="roomNumber">Room Number:</label>
                    <input type="text" name="roomNumber" id="roomNumber" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="capacity">Capacity:</label>
                    <input type="number" name="capacity" id="capacity" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="roomType">Room Type:</label>
                    <input type="text" name="roomType" id="roomType" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="roomFees">Fees Per Month:</label>
                    <input type="number" name="roomFees" id="roomFees" class="form-control" required>
                </div>
                <!-- No status field in the form -->
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success">Add Room</button>
            <a href="addRoom.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

</div>
<!-- /.container-fluid -->

<?php include("include/footer.php") ?>

<script>
    // Add JavaScript to make the message disappear after 2 seconds
    setTimeout(function() {
        document.getElementById('msg').style.display = 'none';
    }, 2000);
</script>