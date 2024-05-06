<?php
if(!isset( $_SESSION)) { session_start(); }

include("include/header.php");
include("../mainInclude/dbConn.php");

if(!isset( $_SESSION['is_admin_login'] )) {
    echo "<script> location.href='../index.php'; </script>";
}

// just a idea complete it later

if(isset($_REQUEST['submitBtn'])){
    $employeeName = $_REQUEST['employeeName'];
    $employeeName = $_REQUEST['employeeName'];
    $employeeName = $_REQUEST['employeeName'];
    $employeeImg = $_FILES['$employeeImg']['name'];
    $employeeImg_temp = $_FILES['$employeeImg']['tmp_name'];
    $img_folder = "../images/employee/".$employeeImg;
    move_uploaded_file($employeeImg_temp, $img_folder);

    $sql = "INSERT INTO employee () VALUES ('$employeeName', '$employeeName','$employeeImg')";

    if($conn->query($sql) == TRUE){
        $msg = '<div class="alert alert-success">Employee added successfully!</div>';
    } else{
        $msg = '<div class="alert alert-danger">Unable to add!</div>';
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Register Employees</h1>

    <div class="col-sm-6 mt-5 mx-3 jumbotron">
        <h3 class="text-center">Add Employee</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="employeeName">Employee Name</label>
                <input type="text" class="form-control" name="employeeName" id="employeeName" required>
            </div>
            <div class="form-group">
                <label for="employeeName">Employee Name</label>
                <input type="text" class="form-control" name="employeeName" id="employeeName" required>
            </div>
            <div class="form-group">
                <label for="employeeName">Employee Name</label>
                <input type="text" class="form-control" name="employeeName" id="employeeName" required>
            </div>
            <div class="form-group">
                <label for="employeeImg">Employee Image</label>
                <input type="file" class="form-control-file" name="employeeImg" id="employeeImg" required>
            </div>
            <div class="text-center">
                <button class="btn btn-danger" id="submitBtn" class="submitBtn">Submit</button>
                <a href="registerEmployee.php" class="btn btn-secondary">Close</a>
            </div>
        </form>
    </div>

</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php");
?>