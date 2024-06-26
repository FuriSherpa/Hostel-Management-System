<?php
if (!isset($_SESSION)) {
    session_start();
}

include("include/header.php");
include("../mainInclude/dbConn.php");

if (!isset($_SESSION['is_admin_login'])) {
    echo "<script> location.href='../index.php'; </script>";
}

// Delete Announcement
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM announcements WHERE id=$delete_id";
    if ($conn->query($delete_sql) === TRUE) {
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">View Notice</h1>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Announcements</h5>
                    <form method="get" action="" class="form-inline float-right">
                        <div class="form-group mr-2">
                            <label for="category_filter" class="mr-2">Filter by Category:</label>
                            <select name="category_filter" id="category_filter" class="form-control">
                                <option value="">All</option>
                                <?php
                                $category_query = "SELECT * FROM announcement_categories";
                                $category_result = $conn->query($category_query);
                                if ($category_result->num_rows > 0) {
                                    while ($category_row = $category_result->fetch_assoc()) {
                                        $selected = '';
                                        if (isset($_GET['category_filter']) && $_GET['category_filter'] == $category_row['id']) {
                                            $selected = 'selected';
                                        }
                                ?>
                                        <option value="<?php echo $category_row['id']; ?>" <?php echo $selected; ?>><?php echo $category_row['name']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Target Audience</th>
                                    <th>Categories</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch announcements from database
                                $sql = "SELECT * FROM announcements";
                                if (isset($_GET['category_filter']) && $_GET['category_filter'] != '') {
                                    $category_filter = $_GET['category_filter'];
                                    $sql .= " WHERE FIND_IN_SET($category_filter, category_ids)";
                                }
                                $sql .= " ORDER BY created_at DESC"; // Order by created_at in descending order (most recent first)

                                // Pagination
                                $per_page = 10;
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                                $start = ($page - 1) * $per_page;
                                $sql .= " LIMIT $start, $per_page";

                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        // Display categories
                                        $category_ids = explode(",", $row["category_ids"]);
                                        $categories = [];
                                        foreach ($category_ids as $category_id) {
                                            $category_sql = "SELECT name FROM announcement_categories WHERE id=$category_id";
                                            $category_result = $conn->query($category_sql);
                                            if ($category_result->num_rows > 0) {
                                                $category_row = $category_result->fetch_assoc();
                                                $categories[] = $category_row["name"];
                                            }
                                        }
                                ?>
                                        <tr>
                                            <td><?php echo $row["title"]; ?></td>
                                            <td><?php echo $row["content"]; ?></td>
                                            <td><?php echo $row["target_audience"]; ?></td>
                                            <td><?php echo implode(", ", $categories); ?></td>
                                            <td><?php echo $row["created_at"]; ?></td>
                                            <td>
                                                <a href="editAnnouncement.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteConfirmationModal<?php echo $row['id']; ?>">
                                                    Delete
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="deleteConfirmationModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this announcement?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                                <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger">Yes</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="6">
                                            <div class="alert alert-info" role="alert">
                                                No announcements found.
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    // Pagination
                    $sql = "SELECT * FROM announcements";
                    if (isset($_GET['category_filter']) && $_GET['category_filter'] != '') {
                        $category_filter = $_GET['category_filter'];
                        $sql .= " WHERE FIND_IN_SET($category_filter, category_ids)";
                    }
                    $result = $conn->query($sql);
                    $total_records = $result->num_rows;
                    $total_pages = ceil($total_records / $per_page);
                    ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo ($page - 1); ?>" tabindex="-1">Previous</a>
                            </li>
                            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo ($page + 1); ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php");
?>