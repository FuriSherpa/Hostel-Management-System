<?php
session_start();
include('include/header.php');
include("../mainInclude/dbConn.php");

$passmsg = ''; // Initialize passmsg variable

if (isset($_SESSION["is_staff_login"])) {
    $sEmail = $_SESSION['sEmail'];
} else {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT * FROM staff WHERE staff_email = '$sEmail'";
$result = mysqli_query($conn, $sql);
if ($result->num_rows == 1) {
    $row = mysqli_fetch_assoc($result);
    $sId = $row['staff_id'];
    $sEmail = $row['staff_email'];
    $sName = $row['staff_name'];
    $sPhn = $row['staff_phn'];
    $sImg = $row['staff_img'];
}

if (isset($_POST['updateStaffBtn'])) {
    $sName = $_POST['sName'];
    $sEmail = $_POST['sEmail'];
    $sPhn = $_POST['sPhn'];

    // Validate and handle image upload
    if (isset($_FILES['sImg']) && $_FILES['sImg']['error'] === UPLOAD_ERR_OK) {
        $sImg = $_FILES['sImg'];
        $img_folder = "img/staff/";
        $img_name = $img_folder . basename($sImg['name']);
        $img_tmp = $sImg['tmp_name'];
        if (move_uploaded_file($img_tmp, $img_name)) {
            // Image uploaded successfully
        } else {
            // Failed to upload image
        }
    }

    $sql = "UPDATE staff SET staff_name = ?, staff_email = ?, staff_phn = ?, staff_img = ? WHERE staff_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $sName, $sEmail, $sPhn, $img_name, $sEmail);
    if ($stmt->execute()) {
        $passmsg = '<div class="alert alert-success" role="alert" id="passmsg">Profile Updated Successfully!</div>';
    } else {
        $passmsg = '<div class="alert alert-danger" role="alert" id="passmsg">Unable to update profile. Please try again later.</div>';
    }
    $stmt->close();
}

?>

<div class="container">
    <h1 class="h3 mb-4 text-gray-800">My Profile</h1>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="profile-image-container">
                <img src="<?php echo $row['staff_img']; ?> " style="height: 120px;
                        width: 120px;
                        border-radius: 50%;" class="profile-image" alt="Profile Image">
            </div>
        </div>
        <div class="col-md-8 mb-4">
            <div class="profile-details">
                <p><strong>Name:</strong> <?php echo $sName; ?></p>
                <p><strong>Email:</strong> <?php echo $sEmail; ?></p>
                <p><strong>Phone:</strong> <?php echo $sPhn; ?></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <button class="btn btn-primary" id="updateDetailsBtn">Update Details</button>
        </div>
    </div>

    <div id="updateDetailsForm" style="display: none;">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="sName">Name</label>
                <input type="text" class="form-control" id="sName" name="sName" value="<?php echo $sName; ?>">
            </div>
            <div class="form-group">
                <label for="sEmail">Email</label>
                <input type="email" class="form-control" id="sEmail" name="sEmail" value="<?php echo $sEmail; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="sPhn">Phone</label>
                <input type="text" class="form-control" id="sPhn" name="sPhn" value="<?php echo $sPhn; ?>">
            </div>
            <div class="form-group">
                <label for="sImg">Profile Picture</label>
                <input type="file" class="form-control-file" id="sImg" name="sImg">
            </div>
            <button type="submit" class="btn btn-primary" name="updateStaffBtn">Save</button>
        </form>
    </div>

    <?php echo $passmsg; ?>
    <?php $passmsg = ''; // Clear passmsg after displaying 
    ?>

</div>

<?php include("include/footer.php"); ?>

<script>
    document.getElementById("updateDetailsBtn").addEventListener("click", function() {
        document.getElementById("updateDetailsForm").style.display = "block";
    });
</script>


<!-- JavaScript to remove passmsg after certain time -->
<script>
    setTimeout(function() {
        document.getElementById("passmsg").style.display = "none";
    }, 2000);
</script>