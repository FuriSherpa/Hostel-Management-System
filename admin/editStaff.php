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

    $sql = "SELECT * FROM staff WHERE staff_id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['staff_name'];
        $email = $row['staff_email'];
        $phone = $row['staff_phn'];
        $address = $row['staff_address'];
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "UPDATE staff SET staff_name='$name', staff_email='$email', staff_phone='$phone', staff_address='$address' WHERE staff_id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script> location.href='viewStaff.php'; </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Staff</h1>

    <div class="row">
        <div class="col-md-6">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>">
                </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="submit" class="btn btn-primary" name="update">Update</button>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php")
?>