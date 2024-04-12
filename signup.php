<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="signupLabel">SignUp</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="clearForm()"></button>
            </div>
            <div class="modal-body">
                <form id="signup">
                    <div class="form-group">
                        <i class="bi bi-person-circle"></i><label for="r_name" class="p-2" style="font-weight: 500;">Name</label>
                        <small id="statusMsg1"></small>
                        <input type="text" class="form-control" id="r_name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <i class="bi bi-envelope-fill"></i><label for="r_email" class="p-2" style="font-weight: 500;" ;>Email address</label>
                        <small id="statusMsg2"></small>
                        <input type="email" class="form-control" id="r_email" aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <i class="bi bi-key-fill"></i><label for="r_pass" class="p-2" style="font-weight: 500;">Password</label>
                        <small id="statusMsg3"></small>
                        <input type="password" class="form-control" id="r_pass" aria-describedby="passwordHelpBlock" placeholder="Password">
                        <div id="passwordHelpBlock" class="form-text">
                            Your password must be 8-20 characters long, contain atleast 1 uppercase,lowercase letters, digits and special characters. It also must not contain spaces or emojis.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span id="successMsg"></span>
                <button type="button" class="btn btn-primary" onclick="signupBtn()" id="signupBtn">SignUp</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="clearForm()">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    function clearForm() {
        document.getElementById("signup").reset();
        $("#statusMsg1").html(" ");
        $("#statusMsg2").html(" ");
        $("#statusMsg3").html(" ");
    }
</script>