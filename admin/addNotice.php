<?php
if (!isset($_SESSION)) {
    session_start();
}

include("include/header.php");
include("../mainInclude/dbConn.php");

if (!isset($_SESSION['is_admin_login'])) {
    echo "<script> location.href='../index.php'; </script>";
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add Notice</h1>

    <!-- Announcement form starts -->
    <div class="card">
        <div class="card-body">
            <form action="process_announcement.php" method="post">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" class="form-control" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="type">Type:</label>
                    <select id="type" name="type" class="form-control">
                        <option value="General">General</option>
                        <option value="Event">Event</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="target_audience">Target Audience:</label>
                    <select id="target_audience" name="target_audience" class="form-control">
                        <option value="All">All</option>
                        <option value="Residents">Residents</option>
                        <option value="Staffs">Staffs</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select id="category" name="category[]" multiple class="form-control">
                        <?php
                        // Fetch categories from database
                        $sql = "SELECT * FROM announcement_categories";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Publish Announcement</button>
            </form>
        </div>
    </div>
    <!-- Announcement form ends -->

</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php");
?>