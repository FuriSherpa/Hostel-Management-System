<?php
if (!isset($_SESSION)) {
    session_start();
}

include("include/header.php");
include("../mainInclude/dbConn.php");

if (!isset($_SESSION['is_admin_login'])) {
    echo "<script> location.href='../index.php'; </script>";
}

if (isset($_POST['id'])) {
    $resident_id = $_POST['id'];

    if (isset($_POST['update'])) {
        $name = $_POST['name'];
        $contact = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $roomNumber = $_POST['roomNumber'];
        $checkInDate = $_POST['checkInDate'];
        $checkOutDate = $_POST['checkOutDate'];
        $password = ($_POST['password'] != '') ? $_POST['password'] : '';
        $status = $_POST['status'];

        // Get roomID based on roomNumber
        $sqlRoom = "SELECT roomID FROM rooms WHERE roomNumber = '$roomNumber'";
        $resultRoom = $conn->query($sqlRoom);
        $rowRoom = $resultRoom->fetch_assoc();
        $roomID = $rowRoom['roomID'];

        // If password is empty, retain old password
        if (empty($password)) {
            $sqlPass = "SELECT r_pass FROM resident WHERE r_id = $resident_id";
            $resultPass = $conn->query($sqlPass);
            $rowPass = $resultPass->fetch_assoc();
            $password = $rowPass['r_pass'];
        }

        // Update resident details in the database
        $sql = "UPDATE resident SET r_name='$name', r_phn='$contact', r_email='$email', r_address='$address', roomID='$roomID', CheckInDate='$checkInDate', CheckOutDate='$checkOutDate', r_pass='$password', paymentStatus='$status' WHERE r_id=$resident_id";

        if ($conn->query($sql) === TRUE) {
            echo "<div id='successMsg' class='alert alert-success' role='alert'>Resident details updated successfully</div>";
            echo "<script>setTimeout(function(){ document.getElementById('successMsg').style.display = 'none'; }, 2000);</script>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error updating record: " . $conn->error . "</div>";
        }
    }

    // Fetch resident details based on ID
    $sql = "SELECT * FROM resident WHERE r_id = $resident_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Fetch all available rooms
        $sqlRoomList = "SELECT roomNumber FROM rooms";
        $resultRoomList = $conn->query($sqlRoomList);
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Edit Resident</h1>
            <div class="card shadow mb-4 mt-4">
                <div class="card-body">
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['r_id']; ?>">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="<?php echo $row['r_name']; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value="<?php echo $row['r_email']; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" name="phone" id="phone" value="<?php echo $row['r_phn']; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" value="<?php echo $row['r_address']; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="roomNumber">Room Number</label>
                            <select name="roomNumber" id="roomNumber" class="form-control">
                                <?php
                                while ($rowRoomList = $resultRoomList->fetch_assoc()) {
                                    $selected = ($rowRoomList['roomNumber'] == $row['roomID']) ? 'selected' : '';
                                    echo "<option value='{$rowRoomList['roomNumber']}' $selected>{$rowRoomList['roomNumber']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="checkInDate">Check-In Date</label>
                            <input type="date" name="checkInDate" id="checkInDate" value="<?php echo $row['CheckInDate']; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="checkOutDate">Check-Out Date</label>
                            <input type="date" name="checkOutDate" id="checkOutDate" value="<?php echo $row['CheckOutDate']; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Enter New Password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="status">Payment Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="Pending" <?php echo ($row['paymentStatus'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="Paid" <?php echo ($row['paymentStatus'] == 'Paid') ? 'selected' : ''; ?>>Paid</option>
                            </select>
                        </div>
                        <!-- Add other fields as needed -->

                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- /.container-fluid -->
<?php
    } else {
        echo "<div class='alert alert-danger' role='alert'>No resident found with that ID.</div>";
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>Resident ID not provided.</div>";
}
?>

<?php include("include/footer.php"); ?>