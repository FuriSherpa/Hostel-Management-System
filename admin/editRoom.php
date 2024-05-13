<?php
if (!isset($_SESSION)) {
    session_start();
}

include("include/header.php");
include("../mainInclude/dbConn.php");

if (!isset($_SESSION['is_admin_login'])) {
    echo "<script> location.href='../index.php'; </script>";
}

if (isset($_POST['view'])) {
    $id = $_POST['id'];
    $query = "SELECT * FROM rooms WHERE roomID = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['editRoom'])) {
    $id = $_POST['id'];
    $roomNumber = $_POST['roomNumber'];
    $capacity = $_POST['capacity'];
    $roomType = $_POST['roomType'];
    $roomFees = $_POST['roomFees'];

    $query = "UPDATE rooms SET roomNumber = '$roomNumber', capacity = '$capacity', roomType = '$roomType', roomFees = '$roomFees' WHERE roomID = $id";

    if (mysqli_query($conn, $query)) {
        // Fetch updated room details
        $query = "SELECT * FROM rooms WHERE roomID = $id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        echo "<div id='successMsg' class='alert alert-success' role='alert'>Room details updated successfully</div>";
        echo "<script>
                setTimeout(function(){ 
                    document.getElementById('successMsg').style.display = 'none';
                }, 2000);
            </script>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error updating record: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Room</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body" id="editRoomForm">
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['roomID']; ?>">
                <div class="form-group">
                    <label for="roomNumber">Room Number</label>
                    <input type="text" class="form-control" id="roomNumber" name="roomNumber" value="<?php echo $row['roomNumber']; ?>">
                </div>
                <div class="form-group">
                    <label for="capacity">Capacity</label>
                    <input type="number" class="form-control" id="capacity" name="capacity" value="<?php echo $row['capacity']; ?>">
                </div>
                <div class="form-group">
                    <label for="roomType">Room Type</label>
                    <input type="text" class="form-control" id="roomType" name="roomType" value="<?php echo $row['roomType']; ?>">
                </div>
                <div class="form-group">
                    <label for="roomFees">Room Fees</label>
                    <input type="number" class="form-control" id="roomFees" name="roomFees" value="<?php echo $row['roomFees']; ?>">
                </div>
                <button type="submit" class="btn btn-primary" name="editRoom">Update Room</button>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php")
?>