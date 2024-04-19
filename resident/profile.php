<?php
session_start();
include('include/header.php');
include("../mainInclude/dbConn.php");

$passmsg = ''; // Initialize passmsg variable

if (isset($_SESSION["is_login"])) {
    $rLogEmail = $_SESSION['rLogEmail'];
} else {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT * FROM resident WHERE r_email = '$rLogEmail'";
$result = mysqli_query($conn, $sql);
if ($result->num_rows == 1) {
    $row = mysqli_fetch_assoc($result);
    $rId = $row['r_id'];
    $rEmail = $row['r_email'];
    $rName = $row['r_name'];
    $rPhn = $row['r_phn'];
    $rImg = $row['r_img'];
}

if (isset($_POST['updateResidentBtn'])) {
    $rName = $_POST['rName'];
    $rEmail = $_POST['rEmail'];
    $rPhn = $_POST['rPhn'];
    
    // Validate and handle image upload
    if(isset($_FILES['rImg']) && $_FILES['rImg']['error'] === UPLOAD_ERR_OK) {
        $rImg = $_FILES['rImg'];
        $img_folder = "img/resident/";
        $img_name = $img_folder . basename($rImg['name']);
        $img_tmp = $rImg['tmp_name'];
        if(move_uploaded_file($img_tmp, $img_name)) {
            // Image uploaded successfully
        } else {
            // Failed to upload image
        }
    }

    $sql = "UPDATE resident SET r_name = ?, r_email = ?, r_phn = ?, r_img = ? WHERE r_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $rName, $rEmail, $rPhn, $img_name, $rLogEmail);
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
                <img src="<?php echo $row['r_img'];?> "
                style="height: 120px;
                        width: 120px;
                        border-radius: 50%;"
                        class="profile-image" alt="Profile Image">
            </div>
        </div>
        <div class="col-md-8 mb-4">
            <div class="profile-details">
                <p><strong>Name:</strong> <?php echo $rName; ?></p>
                <p><strong>Email:</strong> <?php echo $rEmail; ?></p>
                <p><strong>Phone:</strong> <?php echo $rPhn; ?></p>
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
                <label for="rName">Name</label>
                <input type="text" class="form-control" id="rName" name="rName" value="<?php echo $rName; ?>">
            </div>
            <div class="form-group">
                <label for="rEmail">Email</label>
                <input type="email" class="form-control" id="rEmail" name="rEmail" value="<?php echo $rEmail; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="rPhn">Phone</label>
                <input type="text" class="form-control" id="rPhn" name="rPhn" value="<?php echo $rPhn; ?>">
            </div>
            <div class="form-group">
                <label for="rImg">Profile Picture</label>
                <input type="file" class="form-control-file" id="rImg" name="rImg">
            </div>
            <button type="submit" class="btn btn-primary" name="updateResidentBtn">Save</button>
        </form>
    </div>

    <?php echo $passmsg; ?>
    <?php $passmsg = ''; // Clear passmsg after displaying ?>

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