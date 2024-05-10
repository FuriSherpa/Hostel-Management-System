$(document).ready(function () {

    // Ajax call for existing email verification
    $("#r_email").on("keypress blur", function () {
        var remail = $("#r_email").val();
        $.ajax({
            url: 'resident/addResident.php',
            method: 'POST',
            data: {
                checkemail: "checkemail",
                remail: remail,
            },
            success: function (data) {
                if (data !== "0") {
                    $('#statusMsg2').html('<small style="color:red;"> Email ID Already Used!</small>');
                    $("#signupBtn").prop("disabled", true);
                } else {
                    $('#statusMsg2').html('<small></small>');
                    $("#signupBtn").prop("disabled", false);
                }
            },
        });
    });
});


function signupBtn() {
    var ereg = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i;
    var preg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*-+])[^\s]{8,20}$/;
    var rname = $("#r_name").val();
    var remail = $("#r_email").val();
    var rpass = $("#r_pass").val();

    // Checking form fields for form submission
    if (rname.trim() === "") {
        $('#statusMsg1').html('<small style="color:red;"> Please Enter Name!</small>');
        $("#rname").focus();
        return false;
    } else if (remail.trim() === "") {
        $('#statusMsg2').html('<small style="color:red;"> Please Enter Email!</small>');
        $("#remail").focus();
        return false;
    } else if (remail.trim() != "" && !ereg.test(remail)) {
        $('#statusMsg2').html('<small style="color:red;"> Please Enter Valid Email!</small>');
        $("#remail").focus();
        return false;
    } else if (rpass.trim() === "") {
        $('#statusMsg3').html('<small style="color:red;"> Please Enter Password!</small>');
        $("#rpass").focus();
        return false;
    } else if (rpass.trim() != "" && !preg.test(rpass)) {
        $('#statusMsg3').html('<small style="color:red;"> Please Enter Password In Mentioned Format!</small>');
        $("#rpass").focus();
        return false;
    } else {
        $.ajax({
            url: 'resident/addResident.php',
            method: 'POST',
            dataType: 'json',
            data: {
                rsignup: "rsignup",
                rname: rname,
                remail: remail,
                rpass: rpass,
            },
            success: function (data) {
                console.log(data);
                if (data === "OK") {
                    $('#successMsg').html("<span class='alert alert-success'>Registration Successful!</span>");
                    emptyFields();
                    setTimeout(function () {
                        $('#successMsg').html("");
                        $('#signupModal').modal('hide'); // Hide the signup modal
                        $('#r_login').modal('show'); // Show the login modal after 2 seconds
                    }, 2000);
                } else if (data === "Failed") {
                    $('#successMsg').html("<span class='alert alert-danger'>Registration Failed!</span>");
                } else {
                    // Handle unexpected responses
                    $('#successMsg').html("<span class='alert alert-warning'>An unexpected error occurred. Please try again.</span>");
                }
            }
        });
    }
}


// Empty all fields
function emptyFields() {
    $("#signup").trigger("reset");
    $("#statusMsg1").html(" ");
    $("#statusMsg2").html(" ");
    $("#statusMsg3").html(" ");
}

// Ajax call for resident login verification
function checkResidentLogin() {
    var rLogEmail = $("#r_logemail").val(); // Get the value of the input field
    var rLogPass = $("#r_logpass").val();  // Get the value of the input field
    $.ajax({
        url: 'resident/addResident.php',
        method: 'POST',
        data: {
            checkLogEmail: "checkLogEmail",
            rLogEmail: rLogEmail,
            rLogPass: rLogPass,
        },
        success: function (data) {
            data = parseInt(data); // Parse the response as an integer
            if (data === 0) {
                $("#statusRLogMsg").html('<small class="alert alert-danger">Invalid email or password.</small>');
            } else if (data === 1) {
                $("#statusRLogMsg").html('<div class="spinner-border text-success" role="status"></div>');
                setTimeout(() => {
                    window.location.href = "resident/index.php";
                }, 1000);
            }
        },
    });
}