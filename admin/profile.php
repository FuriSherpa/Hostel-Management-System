<?php
session_start();
include('include/header.php');
include("../mainInclude/dbConn.php");

$passmsg = ''; // Initialize passmsg variable

if (isset($_SESSION["is_admin_login"])) {
    $aLogEmail = $_SESSION['aEmail'];
} else {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT * FROM admin WHERE admin_email = '$aLogEmail'";
$result =  mysqli_query($conn, $sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $aId = $row['admin_id'];
    $aEmail = $row['admin_email'];
    $aName = $row['admin_name'];
    $aImg = $row['admin_img'];
}

if (isset($_POST['updateAdminBtn'])) {
    $aName = $_POST['aName'];
    $aEmail = $_POST['aEmail'];

    // Validate and handle image upload
    if (isset($_FILES['aImg']) && $_FILES['aImg']['error'] === UPLOAD_ERR_OK) {
        $aImg = $_FILES['aImg'];
        $img_folder = "img/";
        $img_name = $img_folder . basename($aImg['name']);
        $img_name_profile = "img/profile/admin.jpg"; // New location and fixed name for admin image in profile folder
        $img_tmp = $aImg['tmp_name'];
        if (move_uploaded_file($img_tmp, $img_name)) {
            // Image uploaded successfully to the original location
            // Now copy the image to the new location
            if (copy($img_name, $img_name_profile)) {
                // Image copied successfully to the new location
                $aImg = $img_name_profile; // Update $aImg with the new image path
            } else {
                // Failed to copy image to the new location
            }
        } else {
            // Failed to upload image to the original location
        }
    }

    $sql = "UPDATE admin SET admin_name = ?, admin_email = ?, admin_img = ? WHERE admin_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $aName, $aEmail, $img_name, $aLogEmail);
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
                <img src="<?php echo $aImg; ?>" style="height: 120px; width: 120px; border-radius: 50%;" class="profile-image" alt="Profile Image">
            </div>
        </div>
        <div class="col-md-8 mb-4">
            <div class="profile-details">
                <p><strong>Name:</strong> <?php echo $aName; ?></p>
                <p><strong>Email:</strong> <?php echo $aEmail; ?></p>
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
                <label for="aName">Name</label>
                <input type="text" class="form-control" id="aName" name="aName" value="<?php echo $aName; ?>">
            </div>
            <div class="form-group">
                <label for="aEmail">Email</label>
                <input type="email" class="form-control" id="aEmail" name="aEmail" value="<?php echo $aEmail; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="aImg">Profile Picture</label>
                <input type="file" class="form-control-file" id="aImg" name="aImg">
            </div>
            <button type="submit" class="btn btn-primary" name="updateAdminBtn">Save</button>
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