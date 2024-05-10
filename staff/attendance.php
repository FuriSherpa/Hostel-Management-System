<?php
// Start session if not already started
if (!isset($_SESSION)) {
    session_start();
}

include('include/header.php');

// Include database connection
include("../mainInclude/dbConn.php");

$success = '';
$error = '';

if (isset($_SESSION["is_staff_login"])) {
    $sEmail = $_SESSION['sEmail'];
} else {
    echo  "<script> location.href='../index.php'; </script>";
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['attendance_status'])) {
    foreach ($_POST['attendance_status'] as $resident_id => $status) {
        $date = date('Y-m-d');
        $attendance_status = mysqli_real_escape_string($conn, $status);

        // Check if record for this resident and date already exists
        $sql = "SELECT * FROM daily_attendance WHERE resident_id = $resident_id AND date = '$date'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Update existing record
            $sql = "UPDATE daily_attendance SET attendance_status = '$attendance_status' WHERE resident_id = $resident_id AND date = '$date'";
        } else {
            // Insert new record
            $sql = "INSERT INTO daily_attendance (date, resident_id, attendance_status) VALUES ('$date', $resident_id, '$attendance_status')";
        }

        if (mysqli_query($conn, $sql)) {
            $success = "Attendance recorded successfully!";
        } else {
            $error = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

// Fetch list of residents
$sql = "SELECT * FROM resident";
$result = mysqli_query($conn, $sql);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Daily Attendance Recording</h1>

    <!-- Display success or error message -->
    <?php if ($success != '') { ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success; ?>
        </div>
    <?php } ?>
    <?php if ($error != '') { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <!-- Attendance Recording Form -->
    <div class="card">
        <div class="card-header">
            Record Daily Attendance
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Room Number</th>
                            <th>Attendance Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['r_name']; ?></td>
                                <td><?php echo $row['r_email']; ?></td>
                                <td><?php echo $row['roomID']; ?></td>
                                <td>
                                    <input type="hidden" name="attendance_status[<?php echo $row['r_id']; ?>]" value="Absent">
                                    <input type="checkbox" name="attendance_status[<?php echo $row['r_id']; ?>]" value="Present" <?php if (isset($row['attendance_status']) && $row['attendance_status'] == 'Present') echo 'checked'; ?>>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Save Attendance</button>
            </form>
        </div>
    </div>

    <!-- Attendance Summary -->
    <div class="card mt-4">
        <div class="card-header">
            Attendance Summary
        </div>
        <div class="card-body">
            <table class="table" id="attendance-summary-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Total Residents</th>
                        <th>Present</th>
                        <th>Absent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT date, 
                                    COUNT(*) as total_residents, 
                                    SUM(CASE WHEN attendance_status = 'Present' THEN 1 ELSE 0 END) as present_count, 
                                    SUM(CASE WHEN attendance_status = 'Absent' THEN 1 ELSE 0 END) as absent_count 
                            FROM daily_attendance 
                            GROUP BY date";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr data-date="<?php echo $row['date']; ?>">
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['total_residents']; ?></td>
                            <td><a href="#" class="present-details"><?php echo $row['present_count']; ?></a></td>
                            <td><a href="#" class="absent-details"><?php echo $row['absent_count']; ?></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php
include("include/footer.php");
?>

<script>
    // jQuery to handle click event on present and absent count in summary table
    $(document).ready(function() {
        $("#attendance-summary-table").on("click", ".present-details", function(e) {
            e.preventDefault();
            var date = $(this).closest('tr').data('date');
            $.ajax({
                url: 'attendance_details.php',
                type: 'POST',
                data: {
                    date: date,
                    status: 'Present'
                },
                success: function(response) {
                    alert(response);
                }
            });
        });

        $("#attendance-summary-table").on("click", ".absent-details", function(e) {
            e.preventDefault();
            var date = $(this).closest('tr').data('date');
            $.ajax({
                url: 'attendance_details.php',
                type: 'POST',
                data: {
                    date: date,
                    status: 'Absent'
                },
                success: function(response) {
                    alert(response);
                }
            });
        });
    });
</script>