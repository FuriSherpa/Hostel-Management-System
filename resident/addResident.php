<?php
if (!isset($_SESSION)) {
    session_start();
}
include("../mainInclude/dbConn.php");

// Checking already registered email
if (isset($_POST["checkemail"]) && isset($_POST["remail"])) {
    $remail = $_POST["remail"];
    $sql = "SELECT r_email FROM resident WHERE r_email = '" . $remail . "'";
    $result  = $conn->query($sql);
    $row = $result->num_rows;
    echo json_encode($row); // return the number of rows
}


// Insert Resident
if (isset($_POST["rsignup"]) && isset($_POST["rname"]) && isset($_POST["remail"]) && isset($_POST["rpass"])) {

    $rname = $_POST["rname"];
    $remail = $_POST["remail"];
    $rpass = $_POST["rpass"];

    $sql = "INSERT INTO resident(r_name, r_email, r_pass) VALUES ('$rname', '$remail', '$rpass')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode("OK");
    } else {
        echo json_encode("Failed");
    }
}

// Resident login verification
if (!isset($_SESSION["is_login"])) {
    if (isset($_POST["checkLogEmail"]) && isset($_POST["rLogEmail"]) && isset($_POST["rLogPass"])) {
        $rLogEmail = $_POST["rLogEmail"];
        $rLogPass = $_POST["rLogPass"];

        $sql = "SELECT r_email, r_pass FROM resident WHERE r_email = '".$rLogEmail."' AND r_pass = '".$rLogPass."'";
        $result = $conn->query($sql);
        $row = $result->num_rows;

        if ($row === 1) {
            $_SESSION["is_login"] = true;
            $_SESSION["rLogEmail"] = $rLogEmail;
            echo json_encode($row); // Return 1 if login is successful
        } else if ($row === 0) {
            echo json_encode($row); // Return 0 if login fails
        }
    }
}
?>