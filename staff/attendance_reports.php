<?php
// Include database connection
include("../mainInclude/dbConn.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_report'])) {
    $reportType = $_POST['report_type'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // Generate report based on selected report type
    switch ($reportType) {
        case 'daily':
            generateDailyReport($startDate);
            break;
        case 'weekly':
            generateWeeklyReport($startDate);
            break;
        case 'monthly':
            generateMonthlyReport($startDate);
            break;
        default:
            echo "Invalid report type";
            break;
    }
}

function generateDailyReport($date)
{
    global $conn;

    // Fetch attendance data for the selected date
    $sql = "SELECT * FROM daily_attendance WHERE date = '$date'";
    $result = mysqli_query($conn, $sql);

    // Generate report
    $filename = "daily_attendance_report_" . $date . ".csv";
    $fp = fopen('php://output', 'w');

    // Add headings
    $heading = array('Resident ID', 'Name', 'Attendance Status', 'Check-in Time', 'Check-out Time');
    fputcsv($fp, $heading);

    // Add data
    while ($row = mysqli_fetch_assoc($result)) {
        $data = array($row['resident_id'], $row['name'], $row['attendance_status'], $row['checkin_time'], $row['checkout_time']);
        fputcsv($fp, $data);
    }

    fclose($fp);

    // Download the generated report
    header('Content-type: application/csv');
    header('Content-Disposition: attachment; filename=' . $filename);
    exit;
}

function generateWeeklyReport($startDate)
{
    // Similar to daily report, but with data aggregated for the week
}

function generateMonthlyReport($startDate)
{
    // Similar to daily report, but with data aggregated for the month
}
?>

<!-- Report Generation Form -->
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="report_type">Select Report Type:</label>
    <select name="report_type" id="report_type">
        <option value="daily">Daily</option>
        <option value="weekly">Weekly</option>
        <option value="monthly">Monthly</option>
    </select>
    <br>
    <label for="start_date">Start Date:</label>
    <input type="date" name="start_date" id="start_date" required>
    <br>
    <label for="end_date">End Date:</label>
    <input type="date" name="end_date" id="end_date" required>
    <br>
    <button type="submit" name="generate_report">Generate Report</button>
</form>