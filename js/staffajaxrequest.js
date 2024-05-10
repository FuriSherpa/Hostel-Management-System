// Ajax call for staff login verification
function checkStaffLogin() {
    var sEmail = $("#s_email").val(); // Get the value of the input field
    var sPass = $("#s_pass").val();  // Get the value of the input field
    $.ajax({
        url: 'staff/addStaff.php',
        method: 'POST',
        data: {
            checkLogEmail: "checkLogEmail",
            sEmail: sEmail,
            sPass: sPass,
        },
        success: function (data) {
            data = parseInt(data); // Parse the response as an integer
            if (data === 0) {
                $("#statusSLogMsg").html('<small class="alert alert-danger">Invalid email or password.</small>');
            } else if (data === 1) {
                $("#statusSLogMsg").html('<div class="spinner-border text-success" role="status"></div>');
                setTimeout(() => {
                    window.location.href = "staff/index.php";
                }, 1000);
            }
        },
    });
}
