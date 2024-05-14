<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>HostelStays</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="images/hostelstays.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/custom.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="index.php" style="font-weight:bold;">
                    <img src="images/HostelStays.png" alt="HostelStays Icon" width="30" height="30" class="d-inline-block align-text-top" />
                    HostelStays</a>
                <small class="mt-1 text-white">Relax, Explore & Connect</small>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="contact.php">Contact</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="pricing.php">Pricing</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="faq.php">FAQ</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="gallery.php">Gallery</a></li>
                        <li class="nav-item"><a class="nav-link text-white" data-bs-toggle="modal" data-bs-target="#signupModal" href="signup.php">SignUp</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle  text-white" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Login</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#a_login">Admin</a></li>
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#s_login">Staff</a></li>
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#r_login">Resident</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Sign Up Form -->
        <?php include("signup.php") ?>
        <!-- Signup form ends -->

        <!--  Admin Login Form -->
        <div class="modal fade" id="a_login" tabindex="-1" aria-labelledby="a_loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="aloginLabel">Admin Login</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="clearAdminLoginForm()"></button>
                    </div>
                    <div class="modal-body">
                        <form id="aloginform">
                            <div class="form-group">
                                <i class="bi bi-envelope-fill"></i><label for="a_email" class="p-2" style="font-weight: 500;" ;>Email address</label>
                                <input type="email" class="form-control" id="a_email" placeholder="Enter email" oninput="clearAdminError()">
                            </div>
                            <div class="form-group">
                                <i class="bi bi-key-fill"></i><label for="a_pass" class="p-2" style="font-weight: 500;">Password</label>
                                <input type="password" class="form-control" id="a_pass" placeholder="Password" oninput="clearAdminError()">
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <span id="statusALogMsg"></span>
                        <button type="button" class="btn btn-primary" onclick="checkAdminLogin()" id="aloginbtn">Login</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="clearAdminLoginForm()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Admin Login ends -->

        <!--  Staff Login Form -->
        <div class="modal fade" id="s_login" tabindex="-1" aria-labelledby="s_loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="sloginLabel">Staff Login</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="clearStaffLoginForm()"></button>
                    </div>
                    <div class="modal-body">
                        <form id="sloginform">
                            <div class="form-group">
                                <i class="bi bi-envelope-fill"></i><label for="s_email" class="p-2" style="font-weight: 500;" ;>Email address</label>
                                <input type="email" class="form-control" id="s_email" placeholder="Enter email" oninput="clearStaffError()">
                            </div>
                            <div class="form-group">
                                <i class="bi bi-key-fill"></i><label for="s_pass" class="p-2" style="font-weight: 500;">Password</label>
                                <input type="password" class="form-control" id="s_pass" placeholder="Password" oninput="clearStaffError()">
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <span id="statusSLogMsg"></span>
                        <button type="button" class="btn btn-primary" onclick="checkStaffLogin()" id="sloginbtn">Login</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="clearStaffLoginForm()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Staff Login ends -->

        <!--  Resident Login Form -->
        <div class="modal fade" id="r_login" tabindex="-1" aria-labelledby="r_loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="rloginLabel">Resident Login</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="clearResidentLoginForm()"></button>
                    </div>
                    <div class="modal-body">
                        <form id="rloginform">
                            <div class="form-group">
                                <i class="bi bi-envelope-fill"></i><label for="r_logemail" class="p-2" style="font-weight: 500;" ;>Email address</label>
                                <input type="email" class="form-control" id="r_logemail" placeholder="Enter email" oninput="clearResidentError()">
                            </div>
                            <div class="form-group">
                                <i class="bi bi-key-fill"></i><label for="r_logpass" class="p-2" style="font-weight: 500;">Password</label>
                                <input type="password" class="form-control" id="r_logpass" placeholder="Password" oninput="clearResidentError()">
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <span id="statusRLogMsg"></span>
                        <button type="button" class="btn btn-primary" id="rloginbtn" onclick="checkResidentLogin()">Login</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="clearResidentLoginForm()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Resident Login ends -->

        <script>
            function clearAdminLoginForm() {
                document.getElementById("aloginform").reset();
                $("#statusALogMsg").html(" ");
            }

            function clearStaffLoginForm() {
                document.getElementById("sloginform").reset();
                $("#statusSLogMsg").html(" ");
            }

            function clearResidentLoginForm() {
                document.getElementById("rloginform").reset();
                $("#statusRLogMsg").html(" ");
            }

            function clearAdminError() {
                $("#statusALogMsg").html(" ");
            }

            function clearStaffError() {
                $("#statusSLogMsg").html(" ");
            }

            function clearResidentError() {
                $("#statusRLogMsg").html(" ");
            }

            // Admin Login on Enter
            document.getElementById("a_pass").addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    checkAdminLogin();
                }
            });

            // Staff Login on Enter
            document.getElementById("s_pass").addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    checkStaffLogin();
                }
            });

            // Resident Login on Enter
            document.getElementById("r_logpass").addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    checkResidentLogin();
                }
            });
        </script>
    </main>
</body>

</html>