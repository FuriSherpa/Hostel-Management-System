<?php
if (!isset($_SESSION)) {
    session_start();
}

include("include/header.php");
include("../mainInclude/dbConn.php");

if (!isset($_SESSION['is_admin_login'])) {
    echo "<script> location.href='../index.php'; </script>";
}

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Retrieve the form data
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    // Image upload handling
    $targetDir = "../staff/img/staff/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
        } else {
            // Attempt to upload the image
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Perform database insertion
                $query = "INSERT INTO staff (staff_name, staff_phn, staff_email, staff_pass, staff_address, staff_img) VALUES ('$name', '$contact', '$email', '$password', '$address', '$targetFile')";
                $result = mysqli_query($conn, $query);

                if($result) {
                    echo "<script>alert('Registration successful!');</script>";
                } else {
                    echo "<script>alert('Registration failed!');</script>";
                }
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
        }
    } else {
        echo "<script>alert('File is not an image.');</script>";
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Staff Registration</h1>
    <!-- Registration Form -->
    <form method="post" action="" enctype="multipart/form-data">
        <div class="row justify-content-center">
            <!-- Your form fields here -->
            <!-- Name -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Name <span style="color: red;">*</span></h4>
                        <div class="form-group">
                            <input type="text" name="name" id="name" placeholder="Enter Name" required class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Contact Number -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Contact Number <span style="color: red;">*</span></h4>
                        <div class="form-group">
                            <input type="text" name="contact" id="contact" placeholder="Enter Contact" required="required" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Email -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Email ID <span style="color: red;">*</span></h4>
                        <div class="form-group">
                            <input type="email" name="email" id="email" placeholder="Enter Email" required="required" class="form-control">
                            <span id="user-availability-status" style="font-size:12px;"></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Password -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Password <span style="color: red;">*</span></h4>
                        <div class="form-group">
                            <div class="password-wrapper">
                                <input type="password" name="password" id="password" placeholder="Enter Password" required="required" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Address -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Address <span style="color: red;">*</span></h4>
                        <div class="form-group">
                            <input type="text" name="address" id="address" placeholder="Enter Address" required="required" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Image Upload -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Image <span style="color: red;">*</span></h4>
                        <div class="form-group">
                            <input type="file" name="image" id="image" required="required" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" name="submit" class="btn btn-success mr-2">Register</button>
            <button type="reset" class="btn btn-danger">Reset</button>
        </div>
    </form>
</div>
<!-- /.container-fluid -->

<?php include("include/footer.php"); ?>
