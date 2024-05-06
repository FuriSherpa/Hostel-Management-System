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
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        // Loop through each row of data and populate the table rows dynamically
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>".$row['r_name']."</td>";
                            echo "<td>".$row['r_pass']."</td>";
                            echo "<td>".$row['r_email']."</td>";
                            // echo "<td>".$row['age']."</td>";
                            // echo "<td>".$row['start_date']."</td>";
                            // echo "<td>".$row['salary']."</td>";
                            echo "</tr>";
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
include("include/footer.php")
?>
