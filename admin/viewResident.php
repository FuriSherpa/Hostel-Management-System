<?php
if(!isset( $_SESSION)) { session_start(); }

include("include/header.php");
include("../mainInclude/dbConn.php");

if(!isset( $_SESSION['is_admin_login'] )) {
    echo "<script> location.href='../index.php'; </script>";
}

// Fetch data from the database
$query = "SELECT * FROM resident";
$result = mysqli_query($conn, $query);

// Initialize a counter variable
$serialNumber = 1;
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Resident List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phn No.</th>
                            <th>Address</th>
                            <!-- <th>Room Number</th> -->
                            <th>Check-In Date</th>
                            <th>Check-Out Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through each row of data and populate the table rows dynamically
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $serialNumber . "</td>"; // Output the serial number
                            echo "<td>" . $row['r_name'] . "</td>";
                            echo "<td>" . $row['r_email'] . "</td>";
                            echo "<td>" . $row['r_phn'] . "</td>";
                            echo "<td>" . $row['r_address'] . "</td>";
                            // echo "<td>" . $row['roomNumber'] . "</td>"; // link this to the room table
                            echo "<td>" . $row['CheckInDate'] . "</td>";
                            echo "<td>" . $row['CheckOutDate'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>";
                            echo "
                                <form action='editResident.php' method='POST' class='d-inline'>
                                    <input type='hidden' name='id' value='{$row['r_id']}'>
                                    <button type='submit' class='btn btn-info mr-3' name='view' value='view'>
                                        <i class='fas fa-pen'></i>
                                    </button>
                                </form>
                                <form action='' method='POST' class='d-inline'>
                                    <input type='hidden' name='id' value='{$row['r_id']}'>
                                    <button type='submit' class='btn btn-secondary' name='delete' value='delete'>
                                        <i class='fas fa-trash'></i>
                                    </button>
                                </form>";
                            echo "</td>";
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
if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $sql = "DELETE FROM resident WHERE r_id = $id";
    if($conn->query($sql) === TRUE){
        echo'<meta http-equiv="refresh" content="0;URL=?deleted"  />'; 
    } else {
        echo "Error deleting record: ";
    }
}
?>

<?php
include("include/footer.php")
?>
