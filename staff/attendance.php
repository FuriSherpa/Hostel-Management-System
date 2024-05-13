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

// Fetch list of residents with room numbers
$sql = "SELECT r.*, rm.roomNumber FROM resident r JOIN rooms rm ON r.roomID = rm.roomID";
$result = mysqli_query($conn, $sql);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Daily Attendance Recording</h1>

    <!-- Display success or error message -->
    <?php if ($success != '') { ?>
        <div class="alert alert-success" role="alert" id="success-msg">
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
                                <td><?php echo $row['roomNumber']; ?></td>
                                <td>
                                    <input type="hidden" name="attendance_status[<?php echo $row['r_id']; ?>]" value="Absent">
                                    <input type="checkbox" name="attendance_status[<?php echo $row['r_id']; ?>]" value="Present" <?php if (isset($_POST['attendance_status'][$row['r_id']]) && $_POST['attendance_status'][$row['r_id']] == 'Present') echo 'checked'; ?>>
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
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="date">Select Date:</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div>
                    <div class="form-group col-md-2">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary form-control">Filter</button>
                    </div>
                    <div class="form-group col-md-2">
                        <label>&nbsp;</label>
                        <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="btn btn-danger form-control">Clear Filter</a>
                    </div>
                </div>
            </form>
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
                    $limit = 10;
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $start = ($page - 1) * $limit;
                    $dateFilter = isset($_POST['date']) ? $_POST['date'] : '';
                    $sql = "SELECT date, 
                                    COUNT(*) as total_residents, 
                                    SUM(CASE WHEN attendance_status = 'Present' THEN 1 ELSE 0 END) as present_count, 
                                    SUM(CASE WHEN attendance_status = 'Absent' THEN 1 ELSE 0 END) as absent_count 
                            FROM daily_attendance ";
                    if (!empty($dateFilter)) {
                        $sql .= "WHERE date = '$dateFilter' ";
                    }
                    $sql .= "GROUP BY date ORDER BY date DESC LIMIT $start, $limit";
                    $result = mysqli_query($conn, $sql);
                    $total_records = mysqli_num_rows($result);

                    if ($total_records > 0) {
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr data-date="<?php echo $row['date']; ?>">
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $row['total_residents']; ?></td>
                                <td><a href="#" class="present-details" data-date="<?php echo $row['date']; ?>"><?php echo $row['present_count']; ?></a></td>
                                <td><a href="#" class="absent-details" data-date="<?php echo $row['date']; ?>"><?php echo $row['absent_count']; ?></a></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="4" class="text-center">No records found</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!-- Pagination -->
            <?php
            if ($total_records > $limit) {
                $sql = "SELECT COUNT(*) as total FROM daily_attendance";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $total_pages = ceil($row["total"] / $limit);
                $pagLink = "<ul class='pagination'>";
                if ($page > 1) {
                    $pagLink .= "<li class='page-item'><a class='page-link' href='?page=" . ($page - 1);
                    if (isset($_POST['date'])) {
                        $pagLink .= "&date=" . $_POST['date'];
                    }
                    $pagLink .= "'>Previous</a></li>";
                }

                for ($i = 1; $i <= $total_pages; $i++) {
                    $pagLink .= "<li class='page-item'><a class='page-link' href='?page=" . $i;
                    if (isset($_POST['date'])) {
                        $pagLink .= "&date=" . $_POST['date'];
                    }
                    $pagLink .= "'>" . $i . "</a></li>";
                };
                if ($page < $total_pages) {
                    $pagLink .= "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1);
                    if (isset($_POST['date'])) {
                        $pagLink .= "&date=" . $_POST['date'];
                    }
                    $pagLink .= "'>Next</a></li>";
                }
                echo $pagLink . "</ul>";
            }
            ?>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal -->
<div class="modal fade" id="attendanceDetailsModal" tabindex="-1" role="dialog" aria-labelledby="attendanceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attendanceDetailsModalLabel">Attendance Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="attendanceDetailsBody">
                <!-- Attendance details will be loaded here via AJAX -->
            </div>
        </div>
    </div>
</div>

<?php
include("include/footer.php");
?>

<script>
    // jQuery to handle click event on present and absent count in summary table
    $(document).ready(function() {
        // Hide success message after 2 seconds
        setTimeout(function() {
            $('#success-msg').fadeOut('fast');
        }, 2000);

        $("#attendance-summary-table").on("click", ".present-details, .absent-details", function(e) {
            e.preventDefault();
            var date = $(this).data('date');
            var status = $(this).hasClass('present-details') ? 'Present' : 'Absent';
            $.ajax({
                url: 'attendance_details.php',
                type: 'POST',
                data: {
                    date: date,
                    status: status
                },
                success: function(response) {
                    $('#attendanceDetailsBody').html(response);
                    $('#attendanceDetailsModal').modal('show');
                }
            });
        });
    });
</script>