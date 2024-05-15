<?php
if (!isset($_SESSION)) {
    session_start();
}

include("include/header.php");
include("../mainInclude/dbConn.php");

if (!isset($_SESSION['is_admin_login'])) {
    echo "<script> location.href='../index.php'; </script>";
}

if (isset($_GET['id'])) {
    $announcement_id = $_GET['id'];

    // Fetch announcement details from database
    $sql = "SELECT * FROM announcements WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $announcement_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $announcement = $result->fetch_assoc();
    } else {
        echo "<script>alert('Announcement not found');</script>";
        echo "<script> location.href='viewNotice.php'; </script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Announcement ID not provided');</script>";
    echo "<script> location.href='viewNotice.php'; </script>";
}

// Update Announcement
if (isset($_POST['update_announcement'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $target_audience = $_POST['target_audience'];
    $category_ids = implode(",", $_POST['category_ids']);

    $update_sql = "UPDATE announcements SET title=?, content=?, target_audience=?, category_ids=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssi", $title, $content, $target_audience, $category_ids, $announcement_id);

    if ($stmt->execute()) {
        echo "<script>alert('Announcement updated successfully');</script>";
        echo "<script> location.href='viewNotice.php'; </script>";
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Announcement</h1>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo $announcement['title']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="3" required><?php echo $announcement['content']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="target_audience">Target Audience</label>
                            <select class="form-control" id="target_audience" name="target_audience" required>
                                <option value="All" <?php if ($announcement['target_audience'] == 'All') echo 'selected'; ?>>All</option>
                                <option value="Staff" <?php if ($announcement['target_audience'] == 'Staff') echo 'selected'; ?>>Staff</option>
                                <option value="Residents" <?php if ($announcement['target_audience'] == 'Residents') echo 'selected'; ?>>Residents</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category_ids">Categories</label>
                            <select class="form-control" id="category_ids" name="category_ids[]" multiple required>
                                <?php
                                $category_query = "SELECT * FROM announcement_categories";
                                $category_result = $conn->query($category_query);
                                if ($category_result->num_rows > 0) {
                                    while ($category_row = $category_result->fetch_assoc()) {
                                        $selected = '';
                                        if (in_array($category_row['id'], explode(',', $announcement['category_ids']))) {
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
                        <button type="submit" class="btn btn-primary" name="update_announcement">Update Announcement</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php");
?>