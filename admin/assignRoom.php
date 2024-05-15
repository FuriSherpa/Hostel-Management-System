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

// Fetch available rooms from the database
$query = "SELECT * FROM rooms";
$result = mysqli_query($conn, $query);

// Fetch residents needing accommodation from the database
$query_residents = "SELECT * FROM resident WHERE roomID = 0";
$result_residents = mysqli_query($conn, $query_residents);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Assign Room</h1>

    <div class="row">

        <!-- Residents Needing Accommodation -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">Residents Needing Accommodation</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="residentsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Resident Name</th>
                                    <th>Resident Email</th>
                                    <th>Checkin Date</th>
                                    <th>Check Out Date</th>
                                    <th>Room Number</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Loop through each row of data and populate the table rows dynamically
                                while ($row_residents = mysqli_fetch_assoc($result_residents)) {
                                    echo "<tr>";
                                    echo "<td>" . $row_residents['r_name'] . "</td>";
                                    echo "<td>" . $row_residents['r_email'] . "</td>";
                                    echo "<form method='post'>";
                                    echo "<td><input type='date' name='checkinDate' required></td>";
                                    echo "<td><input type='date' name='checkoutDate' required></td>";
                                    echo "<td><select name='roomID' required>";
                                    mysqli_data_seek($result, 0);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        if (getOccupancyStatus($row['currentOccupancy'], $row['capacity']) !== 'Occupied') {
                                            echo "<option value='" . $row['roomID'] . "'>" . $row['roomNumber'] . "</option>";
                                        }
                                    }
                                    echo "</select></td>";
                                    echo "<td><select name='paymentStatus' required>
                                            <option value='Pending'>Pending</option>
                                            <option value='Paid'>Paid</option>
                                          </select></td>";
                                    echo "<td><input type='hidden' name='residentEmail' value='" . $row_residents['r_email'] . "'>
                                              <input type='submit' class='btn btn-primary' name='assign' value='Assign'>
                                          </td>";
                                    echo "</form>";
                                    echo "</tr>";
                                }
                                ?>
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
if (isset($_POST['assign'])) {
    $residentEmail = $_POST['residentEmail'];
    $checkinDate = $_POST['checkinDate'];
    $checkoutDate = $_POST['checkoutDate'];
    $roomID = $_POST['roomID'];
    $paymentStatus = $_POST['paymentStatus'];

    // Update resident table
    $sql_resident = "UPDATE resident 
                     SET checkinDate='$checkinDate', checkoutDate='$checkoutDate', roomID='$roomID', paymentStatus='$paymentStatus' 
                     WHERE r_email='$residentEmail'";

    if ($conn->query($sql_resident) === TRUE) {
        // Increase currentOccupancy by 1
        $sql_room = "UPDATE rooms SET currentOccupancy = currentOccupancy + 1 WHERE roomID = '$roomID'";
        $conn->query($sql_room);

        // If currentOccupancy reaches capacity, change roomStatus to Occupied
        $sql_room_status = "SELECT currentOccupancy, capacity FROM rooms WHERE roomID = '$roomID'";
        $result_room_status = mysqli_query($conn, $sql_room_status);
        $row_room_status = mysqli_fetch_assoc($result_room_status);

        if ($row_room_status['currentOccupancy'] >= $row_room_status['capacity']) {
            $sql_room_status_update = "UPDATE rooms SET roomStatus = 'Occupied' WHERE roomID = '$roomID'";
            $conn->query($sql_room_status_update);
        }

        echo '<script>alert("Room assigned successfully!");</script>';
        echo '<meta http-equiv="refresh" content="0">';
    } else {
        echo "Error assigning room: " . $conn->error; // Print error message for debugging
    }
}
?>

<?php
include("include/footer.php");
?>