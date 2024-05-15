<?php
session_start();
include("../mainInclude/dbConn.php");

if (!isset($_SESSION['is_admin_login'])) {
    echo "<script> location.href='../index.php'; </script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    // $type = $_POST['type'];
    $target_audience = $_POST['target_audience'];
    $categories = $_POST['category'];

    // Insert announcement
    $category_ids = implode(",", $categories);
    $insert_sql = "INSERT INTO announcements (title, content, target_audience, category_ids) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("ssss", $title, $content, $target_audience, $category_ids);

    if ($stmt->execute()) {
        echo "<script>alert('Announcement published successfully');</script>";
        echo "<script> location.href='viewNotice.php'; </script>";
    } else {
        echo "Error: " . $insert_sql . "<br>" . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
