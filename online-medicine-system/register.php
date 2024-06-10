<?php
include('includes/head.php');
?>
<!DOCTYPE html>
<html lang="en">

<body>
    <section id="loginBackgroundImg">
        <div class="loginCard">
            <form id="registerForm" class='shadow'>
                <div>
                    <h4 class='text-center mb-4' style="color:#047e6a;">User Register</h4>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" name="name"
                        placeholder="name@example.com">
                    <label for="floatingInput">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingInput" name="email"
                        placeholder="name@example.com" onblur="checkMail(this.value)">
                    <label for="floatingInput">Email address</label>
                    <div>
                        <small style="color:red;display:none;" id="emailError">Invalid email address</small>
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="pass" name="password" placeholder="Password"
                        onblur="checkPass(this.value)">
                    <label for="floatingPassword">Password</label>
                    <div>
                        <small class='mt-1' style="color:red;display:none;" id="passError">Password must be of 8
                            characters</small>
                    </div>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="confirmPass" placeholder="confirmPassword"
                        onblur="checkPassMatch()">
                    <label for="floatingPassword">Confirm Password</label>
                    <div>
                        <small style="color:red;display:none;" id="passConfirmError">Password does not
                            match</small>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4 w-100 mb-2" aria-label="Close">SUBMIT</button>
                <div>
                    <p><small>Already have an account? <a href="login.php"><strong class="text-primary">Login</strong>
                            </a></small></p>
                </div>
            </form>
        </div>
    </section>
    <script src="assets/js/validations.js"></script>

    <script type="text/javascript">
        let isFormValid = true;
        const checkMail = (email) => {
            if (validateEmail(email)) {
                isFormValid = true;
                $("#emailError").hide()
            }
            else {
                isFormValid = false;
                $("#emailError").show()
            }
        }
        const checkPass = (password) => {
            const result = validatePass(password);

            if (result.passLengthValid) {
                isFormValid = true;
                $("#passError").hide()
            }
            else {
                isFormValid = false;
                $("#passError").show();
            }
            checkPassMatch()
        }

        const checkPassMatch = () => {

            pass = $("#pass").val();
            passRetype = $("#confirmPass").val();
            console.log(pass, passRetype, $("#pass"), document.getElementById("pass"))

            if (pass !== '' && passRetype !== '') {
                if (pass === passRetype) {
                    isFormValid = true;
                    $("#passConfirmError").hide();
                }
                else {
                    $("#passConfirmError").show();
                    isFormValid = false;
                }
            }
            else {
                $("#passConfirmError").hide();
            }

        }

        $(document).ready(function () {
            let request;

            $("#registerForm").submit(function (event) {

                event.preventDefault();
                if (request) {
                    request.abort();
                }
                var $form = $(this);
                var serializedData = $form.serialize();

                request = $.ajax({
                    url: "php_backend/user/registerCode.php",
                    type: "post",
                    data: serializedData,
                });

                request.done(function (response, textStatus, jqXHR) {
                    console.log(response);
                    // console.log($.parseJSON(response));
                    const jsonData = $.parseJSON(response);

                    if (jsonData?.isSuccess) {
                        // console.log(jsonData);
                        Swal.fire({
                            title: "Good job!",
                            text: "Registered Successfully!",
                            icon: "success"
                        });

                        location.href = 'login.php';
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: jsonData.message,
                        });
                    }
                });

                request.fail(function (jqXHR, textStatus, errorThrown) {
                    console.error("The following error occurred: " + textStatus, errorThrown);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                    });
                });
                request.always(function () { });
            });
        })
    </script>

</body>

</html>