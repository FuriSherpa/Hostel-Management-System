<?php
// Include database connection
include("../mainInclude/dbConn.php");

// Get form data
$title = $_POST['title'];
$content = $_POST['content'];
$type = $_POST['type'];
$target_audience = $_POST['target_audience'];
$category_ids = implode(",", $_POST['category']);

// Insert announcement into database
$sql = "INSERT INTO announcements (title, content, type, target_audience, category_ids) 
        VALUES ('$title', '$content', '$type', '$target_audience', '$category_ids')";

if ($conn->query($sql) === TRUE) {
    echo "Announcement published successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
?>
