<?php
// Include database connection
include("../mainInclude/dbConn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['date']) && isset($_POST['status'])) {
    $date = $_POST['date'];
    $status = $_POST['status'];

    $sql = "SELECT resident.r_name 
            FROM daily_attendance 
            JOIN resident ON daily_attendance.resident_id = resident.r_id 
            WHERE daily_attendance.date = '$date' AND daily_attendance.attendance_status = '$status'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $residents = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $residents[] = $row['r_name'];
        }
        echo implode(', ', $residents);
    } else {
        echo "No residents found";
    }
} else {
    echo "Invalid request";
}
?>
