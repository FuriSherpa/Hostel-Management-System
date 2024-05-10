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
    if ($currentOccupancy == 0) {
        return "Available";
    } elseif ($currentOccupancy < $capacity) {
        return "Partially Occupied";
    } else {
        return "Occupied";
    }
}

// Filter and sort functionality
$filter = "";
if (isset($_GET['filter']) && isset($_GET['value'])) {
    $filter = "WHERE " . $_GET['filter'] . " = '" . $_GET['value'] . "'";
}

$sort = "roomNumber";
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
}

$query = "SELECT * FROM rooms $filter ORDER BY $sort";
$result = mysqli_query($conn, $query);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">View Rooms</h1>

    <!-- Filter and sort options -->
    <div class="mb-3">
        <form class="form-inline">
            <label for="filter">Filter by:</label>
            <select class="form-control mx-2" id="filter" name="filter">
                <option value="roomStatus">Occupancy Status</option>
                <option value="capacity">Capacity</option>
                <option value="roomNumber">Room Number</option>
            </select>
            <select class="form-control mx-2" id="value" name="value">
                <option value="Available">Available</option>
                <option value="Partially Occupied">Partially Occupied</option>
                <option value="Occupied">Occupied</option>
            </select>
            <button type="submit" class="btn btn-primary">Apply Filter</button>
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