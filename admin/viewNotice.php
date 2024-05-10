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
    <h1 class="h3 mb-4 text-gray-800">View Notice</h1>

    <!-- Filter announcement -->
    <div class="mb-3">
        <form class="form-inline" action="" method="get">
            <div class="form-group mr-2">
                <label for="category_filter" class="mr-2">Filter by Category:</label>
                <select id="category_filter" name="category_filter" class="form-control">
                    <option value="">All</option>
                    <?php
                    // Fetch categories from database
                    $sql = "SELECT * FROM announcement_categories";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $selected = ($_GET['category_filter'] == $row["id"]) ? "selected" : "";
                            echo "<option value='" . $row["id"] . "' $selected>" . $row["name"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>
    <!-- Filter announcement ends -->

    <!-- View announcement -->
    <div class="row">
        <?php
        // Fetch announcements from database
        $sql = "SELECT * FROM announcements";
        if (isset($_GET['category_filter']) && $_GET['category_filter'] != '') {
            $category_filter = $_GET['category_filter'];
            $sql .= " WHERE FIND_IN_SET($category_filter, category_ids)";
        }
        $sql .= " ORDER BY created_at DESC"; // Order by created_at in descending order (most recent first)
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row["title"]; ?></h5>
                            <p class="card-text"><?php echo $row["content"]; ?></p>
                            <p class="card-text"><strong>Type:</strong> <?php echo $row["type"]; ?></p>
                            <p class="card-text"><strong>Target Audience:</strong> <?php echo $row["target_audience"]; ?></p>

                            <?php
                            // Display categories
                            $category_ids = explode(",", $row["category_ids"]);
                            ?>
                            <p class="card-text"><strong>Categories:</strong>
                                <?php
                                foreach ($category_ids as $category_id) {
                                    $category_sql = "SELECT name FROM announcement_categories WHERE id=$category_id";
                                    $category_result = $conn->query($category_sql);
                                    if ($category_result->num_rows > 0) {
                                        $category_row = $category_result->fetch_assoc();
                                        echo $category_row["name"] . ", ";
                                    }
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php
            }
        } else {
            ?>
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    No announcements found.
                </div>
            </div>
        <?php
        }
        ?>

    </div>

    <!-- View announcements ends -->

</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php");
?>