<?php
if(!isset( $_SESSION)) { session_start(); }

include("include/header.php");
include("../mainInclude/dbConn.php");

if(!isset( $_SESSION['is_admin_login'] )) {
    echo "<script> location.href='../index.php'; </script>";
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Assign Room</h1>

    

</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php");
?>