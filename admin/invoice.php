<?php
if (!isset($_SESSION)) {
    session_start();
}

include("include/header.php");
include("../mainInclude/dbConn.php");

if (!isset($_SESSION['is_admin_login'])) {
    echo "<script> location.href='../index.php'; </script>";
}

// Retrieve booking details
$sql = "SELECT r.r_id, r.r_name, r.CheckInDate, r.CheckOutDate, r.roomID, r.paymentStatus, ro.roomNumber, ro.roomType, ro.roomFees 
        FROM resident r
        INNER JOIN rooms ro ON r.roomID = ro.roomID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Calculate total charges
        $checkInDate = new DateTime($row['CheckInDate']);
        $checkOutDate = new DateTime($row['CheckOutDate']);
        $daysStayed = $checkInDate->diff($checkOutDate)->days;
        $totalCharges = $daysStayed * $row['roomFees'];

        // Generate invoice
        $invoiceContent = "
            <h2>Invoice</h2>
            <p>Hi " . $row['r_name'] . ",</p>
            <p>Here is your invoice for the hostel stay:</p>
            <table>
                <tr>
                    <td><strong>Room Type:</strong></td>
                    <td>" . $row['roomType'] . "</td>
                </tr>
                <tr>
                    <td><strong>Room Number:</strong></td>
                    <td>" . $row['roomNumber'] . "</td>
                </tr>
                <tr>
                    <td><strong>Check-In Date:</strong></td>
                    <td>" . $row['CheckInDate'] . "</td>
                </tr>
                <tr>
                    <td><strong>Check-Out Date:</strong></td>
                    <td>" . $row['CheckOutDate'] . "</td>
                </tr>
                <tr>
                    <td><strong>Total Charges:</strong></td>
                    <td>$" . $totalCharges . "</td>
                </tr>
            </table>
            <p>Please make the payment by [Payment Deadline] through [Payment Method].</p>
            <p>Thank you for staying with us.</p>
        ";

        // Save invoice to database
        $invoiceSql = "INSERT INTO invoices (resident_id, invoice_content) 
                       VALUES ('" . $row['r_id'] . "', '" . $conn->real_escape_string($invoiceContent) . "')";
        $conn->query($invoiceSql);
    }
} else {
    echo "0 results";
}

$conn->close();
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Send Invoice</h1>
</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php")
?>