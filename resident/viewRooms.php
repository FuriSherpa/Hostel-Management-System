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

// Fetch data from the database
$query = "SELECT * FROM rooms";
$result = mysqli_query($conn, $query);

// Initialize a counter variable
$serialNumber = 1;

// Function to get the occupancy status of a room
function getOccupancyStatus($currentOccupancy, $capacity)
{
    if ($currentOccupancy < $capacity) {
        return "Available";
    } else {
        return "Occupied";
    }
}

// Filter and sort functionality
$filter = "";
if (isset($_GET['filter']) && $_GET['filter'] == "roomStatus" && isset($_GET['value'])) {
    $value = $_GET['value'];
    if ($value == "Available" || $value == "Occupied") {
        $filter = "AND roomStatus = '$value'";
    }
}

$sort = "roomNumber";
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
}

$query = "SELECT * FROM rooms WHERE 1 $filter ORDER BY $sort";
$result = mysqli_query($conn, $query);

// Check if the current resident has a room assigned
$hasRoom = false;
$roomDetails = [];
$getResidentRoomQuery = "SELECT * FROM resident WHERE r_email = '$rLogEmail' AND roomID > 0";
$residentRoomResult = mysqli_query($conn, $getResidentRoomQuery);
if (mysqli_num_rows($residentRoomResult) > 0) {
    $hasRoom = true;
    $row = mysqli_fetch_assoc($residentRoomResult);
    $roomId = $row['roomID'];
    $checkInDate = $row['CheckInDate'];
    $checkOutDate = $row['CheckOutDate'];
    $paymentStatus = $row['paymentStatus'];

    // Get room details
    $getRoomDetailQuery = "SELECT * FROM rooms WHERE roomID = $roomId";
    $roomDetailResult = mysqli_query($conn, $getRoomDetailQuery);
    $roomDetails = mysqli_fetch_assoc($roomDetailResult);
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">View Rooms</h1>

    <?php if ($hasRoom) : ?>
        <!-- Room Detail -->
        <div class="card shadow mb-4 mt-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">My Room Detail</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Room Number</th>
                                <th>Check-In Date</th>
                                <th>Check-Out Date</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $roomDetails['roomNumber']; ?></td>
                                <td><?php echo $checkInDate; ?></td>
                                <td><?php echo $checkOutDate; ?></td>
                                <td><?php echo $paymentStatus; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Filter and sort options -->
    <div class="mb-3">
        <form class="form-inline">
            <label for="filter">Filter by:</label>
            <select class="form-control mx-2" id="filter" name="filter">
                <option value="roomStatus" <?php echo ($_GET['filter'] ?? 'roomStatus') == 'roomStatus' ? 'selected' : ''; ?>>Occupancy Status</option>
            </select>
            <select class="form-control mx-2" id="value" name="value">
                <option value="" <?php echo ($_GET['value'] ?? '') == '' ? 'selected' : ''; ?>>Select Value</option>
                <option value="Available" <?php echo ($_GET['value'] ?? '') == 'Available' ? 'selected' : ''; ?>>Available</option>
                <option value="Occupied" <?php echo ($_GET['value'] ?? '') == 'Occupied' ? 'selected' : ''; ?>>Occupied</option>
            </select>
            <button type="submit" class="btn btn-primary">Apply Filter</button>
            <?php if (isset($_GET['filter']) && isset($_GET['value'])) : ?>
                <a href="viewRooms.php" class="btn btn-secondary ml-2">Clear Filter</a>
            <?php endif; ?>
        </form>
        <div class="mt-2">
            <a href="?sort=roomNumber" class="btn btn-info">Sort by Room Number</a>
            <a href="?sort=capacity" class="btn btn-info">Sort by Capacity</a>
            <a href="?sort=roomStatus" class="btn btn-info">Sort by Occupancy Status</a>
        </div>
    </div>


    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">List of Rooms</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Room No.</th>
                            <th>Capacity</th>
                            <th>Current Occupancy</th>
                            <th>Room Type</th>
                            <th>Room Fees</th>
                            <th>Room Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through each row of data and populate the table rows dynamically
                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $serialNumber . "</td>"; // Output the serial number
                            echo "<td>" . $row['roomNumber'] . "</td>";
                            echo "<td>" . $row['capacity'] . "</td>";
                            echo "<td>" . $row['currentOccupancy'] . "</td>";
                            echo "<td>" . $row['roomType'] . "</td>";
                            echo "<td>" . $row['roomFees'] . "</td>";
                            echo "<td>" . getOccupancyStatus($row['currentOccupancy'], $row['capacity']) . "</td>";
                            echo "</tr>";
                            $serialNumber++; // Increment the serial number for the next row
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