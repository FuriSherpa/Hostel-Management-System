<?php
if (!isset($_SESSION)) {
    session_start();
}
include("../mainInclude/dbConn.php");

// Admin login verification
if (!isset($_SESSION["is_admin_login"])) {
    if (isset($_POST["checkLogEmail"]) && isset($_POST["aEmail"]) && isset($_POST["aPass"])) {
        $aEmail = $_POST["aEmail"];
        $aPass = $_POST["aPass"];

        $sql = "SELECT admin_email, admin_pass FROM admin WHERE admin_email = '" . $aEmail . "' AND admin_pass = '" . $aPass . "'";
        $result = $conn->query($sql);
        $row = $result->num_rows;

        if ($row === 1) {
            $_SESSION["is_admin_login"] = true;
            $_SESSION["aEmail"] = $aEmail;
            echo json_encode($row); // Return 1 if login is successful
        } else if ($row === 0) {
            echo json_encode($row); // Return 0 if login fails
        }
    }
}
