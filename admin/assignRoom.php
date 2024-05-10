<?php
if (!isset($_SESSION)) {
    session_start();
}

include("include/header.php");
include("../mainInclude/dbConn.php");

if (!isset($_SESSION['is_admin_login'])) {
    echo "<script> location.href='../index.php'; </script>";
}

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

// Fetch data from the database
$query = "SELECT * FROM rooms";
$result = mysqli_query($conn, $query);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Assign Room</h1>

    <!-- Room and resident Display -->
    <div class="row">
        <!-- Available Rooms -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Available Rooms</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="availableRoomsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Room No.</th>
                                    <th>Capacity</th>
                                    <th>Current Occupancy</th>
                                    <th>Room Type</th>
                                    <th>Room Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Loop through each row of data and populate the table rows dynamically
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['roomNumber'] . "</td>";
                                    echo "<td>" . $row['capacity'] . "</td>";
                                    echo "<td>" . $row['currentOccupancy'] . "</td>";
                                    echo "<td>" . $row['roomType'] . "</td>";
                                    echo "<td>" . getOccupancyStatus($row['currentOccupancy'], $row['capacity']) . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- residents Needing Accommodation -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">residents Needing Accommodation</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="residentsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>resident Name</th>
                                    <th>Gender</th>
                                    <th>Preference</th>
                                    <th>Assigned Room</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Display residents needing accommodation here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php");
?>