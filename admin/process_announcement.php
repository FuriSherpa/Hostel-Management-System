<?php
session_start();

include("../mainInclude/dbConn.php");

if (!isset($_SESSION['is_admin_login'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $target_audience = $_POST['target_audience'];
    $categories = $_POST['category']; // Changed to category[] as it's a multiple select

    // Insert announcement into database
    $insert_sql = "INSERT INTO announcements (title, content, target_audience, category_ids) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("ssss", $title, $content, $target_audience, implode(",", $categories));

    if ($stmt->execute()) {
        header("Location: addNotice.php?success=1"); // Redirect with success parameter
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>