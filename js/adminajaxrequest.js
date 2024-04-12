// Ajax call for admin login verification
function checkAdminLogin() {
    var aEmail = $("#a_email").val(); // Get the value of the input field
    var aPass = $("#a_pass").val();  // Get the value of the input field
    $.ajax({
        url: 'admin/admin.php',
        method: 'POST',
        data: {
            checkLogEmail: "checkLogEmail",
            aEmail: aEmail,
            aPass: aPass,
        },
        success: function (data) {
            data = parseInt(data); // Parse the response as an integer
            if (data === 0) {
                $("#statusALogMsg").html('<small class="alert alert-danger">Invalid email or password.</small>');
            } else if (data === 1) {
                $("#statusALogMsg").html('<div class="spinner-border text-success" role="status"></div>');
                setTimeout(() => {
                    window.location.href = "admin/index.php";
                }, 1000);
            }
        },
    });
}