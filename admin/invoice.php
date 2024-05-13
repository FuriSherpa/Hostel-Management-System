<?php
if (!isset($_SESSION)) {
    session_start();
}

include("include/header.php");
include("../mainInclude/dbConn.php");

if (!isset($_SESSION['is_admin_login'])) {
    echo "<script> location.href='../index.php'; </script>";
}

// Fetch data from the database
$query = "SELECT * FROM resident";
$result = mysqli_query($conn, $query);

// Function to insert invoice into the invoices table and send it as an announcement
function sendInvoiceAsAnnouncement($conn, $resident_id, $invoice_content)
{
    // Insert invoice into the invoices table
    $insert_query = "INSERT INTO invoices (resident_id, invoice_content, created_at)
                     VALUES ($resident_id, '$invoice_content', NOW())";
    mysqli_query($conn, $insert_query);

    // Insert invoice as an announcement
    $announcement_query = "INSERT INTO announcements (title, content, type, target_audience, created_at)
                           VALUES ('Invoice', '$invoice_content', 'General', 'Residents', NOW())";
    mysqli_query($conn, $announcement_query);
}

// Check if the form is submitted
if (isset($_POST['send_invoice'])) {
    $resident_id = $_POST['resident_id'];

    // Fetch resident data
    $resident_query = "SELECT * FROM resident WHERE r_id = $resident_id";
    $resident_result = mysqli_query($conn, $resident_query);
    $resident_row = mysqli_fetch_assoc($resident_result);

    // Fetch booking data
    $booking_query = "SELECT * FROM booking_requests WHERE resident_id = $resident_id";
    $booking_result = mysqli_query($conn, $booking_query);
    $booking_row = mysqli_fetch_assoc($booking_result);

    // Fetch room details
    $room_id = $booking_row['room_id'];
    $room_query = "SELECT * FROM rooms WHERE roomID = $room_id";
    $room_result = mysqli_query($conn, $room_query);
    $room_row = mysqli_fetch_assoc($room_result);

    // Calculate total charges
    $room_fee = $room_row['roomFees'];
    $total_charges = $room_fee; // Add other charges if needed

    // Prepare invoice content
    $invoice_content = "
    <h2>Invoice</h2>
    <p>Hi " . $resident_row['r_name'] . ",</p>
    <p>Here is your invoice for the hostel stay:</p>
    <table>
        <tr>
            <td><strong>Room Fee:</strong></td>
            <td>$" . $room_fee . "</td>
        </tr>
        <tr>
            <td><strong>Total Charges:</strong></td>
            <td>$" . $total_charges . "</td>
        </tr>
    </table>
    <p>Please make the payment by [Payment Deadline] through [Payment Method].</p>
    <p>Thank you for staying with us.</p>
    ";

    // Insert invoice into the invoices table and send it as an announcement
    sendInvoiceAsAnnouncement($conn, $resident_id, $invoice_content);
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Send Invoice</h1>

    <!-- Invoice Sending Form -->
    <div class="row">
        <div class="col-md-6">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="resident_id">Select Resident:</label>
                    <select class="form-control" id="resident_id" name="resident_id">
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <option value="<?php echo $row['r_id']; ?>"><?php echo $row['r_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="send_invoice">Send Invoice</button>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php")
?>