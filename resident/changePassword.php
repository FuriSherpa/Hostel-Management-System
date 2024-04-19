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

$passmsg = ''; // Initialize passmsg variable

if (isset($_POST['rLogPassUpdateBtn'])) { // Changed to POST method
    if (empty($_POST['rLogPass'])) { // Changed to check if password is empty using empty() function
        $passmsg = '<div class="alert-warning col-sm-6 ml-5 mt-2" role="alert"> Please enter Password! </div>';
    } else {
        $rLogPass = $_POST['rLogPass']; // Retrieve new password
        $sql = "UPDATE resident SET r_pass = '$rLogPass' WHERE r_email = '$rLogEmail'";
        if ($conn->query($sql)) {
            $passmsg = '<div class="alert-success col-sm-5 mt-2" role="alert"> Updated successfully! </div>';
        } else {
            $passmsg = '<div class="alert-danger col-sm-5 mt-2" role="alert"> Unable to update </div>';
        }
    }
} else if (isset($_POST['rLogPassUpdateBtn']) && empty($_POST['rLogPass'])) {
    $passmsg = '<div class="alert-warning col-sm-6 ml-5 mt-2" role="alert"> Please enter Password! </div>';
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Change Password</h1>

    <div class="row justify-content-center"> <!-- Center the form horizontally -->
        <div class="col-lg-6">
            <form class="mt-5 mx-lg-5" method="POST" action="">
                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input type="email" class="form-control" id="inputEmail" name="inputEmail" value="<?php echo $rLogEmail; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="inputnewpassword">New Password</label>
                    <input type="password" class="form-control" id="inputnewpassword" placeholder="New Password" name="rLogPass">
                </div>
                <div id="passMsg"><?php echo $passmsg; ?></div>
                <div class="form-buttons mt-4 text-center text-lg-left"> <!-- Center buttons on smaller screens -->
                    <button type="submit" class="btn btn-danger mr-lg-4 mb-2 mb-lg-0" name="rLogPassUpdateBtn">Change Password</button>
                    <button type="reset" class="btn btn-secondary mr-lg-4 mb-2 mb-lg-0">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- /.container-fluid -->

<script>
    // Function to remove the password message after a certain time
    setTimeout(function() {
        document.getElementById('passMsg').innerHTML = '';
    }, 2000);
</script>

<?php include 'include/footer.php'; ?>