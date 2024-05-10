<?php
if (!isset($_SESSION)) {
    session_start();
}
include("../mainInclude/dbConn.php");

// Staff login verification
if (!isset($_SESSION["is_staff_login"])) {
    if (isset($_POST["checkLogEmail"]) && isset($_POST["sEmail"]) && isset($_POST["sPass"])) {
        $sEmail = $_POST["sEmail"];
        $sPass = $_POST["sPass"];

        $sql = "SELECT staff_email, staff_pass FROM staff WHERE staff_email = '" . $sEmail . "' AND staff_pass = '" . $sPass . "'";
        $result = $conn->query($sql);
        $row = $result->num_rows;

        if ($row === 1) {
            $_SESSION["is_staff_login"] = true;
            $_SESSION["sEmail"] = $sEmail;
            echo json_encode($row); // Return 1 if login is successful
        } else if ($row === 0) {
            echo json_encode($row); // Return 0 if login fails
        }
    }
} 
?>
