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
        // Similarly, get other form fields

        // Update resident details in the database
        $sql = "UPDATE resident SET r_name='$name', r_phn='$contact', r_email='$email', r_address='$address' WHERE r_id=$resident_id";
        // Similarly, update other fields

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Resident details updated successfully');</script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    // Fetch resident details based on ID
    $sql = "SELECT * FROM resident WHERE r_id = $resident_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display form with resident details for editing
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
                        <!-- Add other fields as needed -->

                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- /.container-fluid -->
<?php
    } else {
        echo "No resident found with that ID.";
    }
} else {
    echo "Resident ID not provided.";
}
?>

<?php include("include/footer.php"); ?>