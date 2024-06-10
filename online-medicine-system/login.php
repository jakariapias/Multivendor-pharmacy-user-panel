<!DOCTYPE html>
<html lang="en">

<?php
include('includes/head.php');
?>

<body>
    <section id="loginBackgroundImg">
        <div class="container">
            <div class="row">

                <div class="col-xs-12 col-lg-6">
                    <div class="d-flex justify-content-center align-items-center vh-100">
                        <form id="loginForm" class='shadow'>
                            <div>
                                <h4 class='text-center mb-4' style="color:#047e6a;">User Login</h4>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" name='email'
                                    placeholder="name@example.com">
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingPassword" name='password'
                                    placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div><small>Remember me</small></div>
                                <div><a href="forgot-password.php"><small>Forgot password</small></a></div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 w-100 mb-2"
                                aria-label="Close">SUBMIT</button>
                            <div>
                                <p><small>Have not registered yet? <a href="register.php"><strong
                                                class="text-primary">Create
                                                Account</strong> </a></small></p>
                            </div>
                        </form>
                    </div>

                </div>


            </div>
        </div>


    </section>

    <script type="text/javascript">
        $(document).ready(function () {

            let request;

            $("#loginForm").submit(function (event) {

                event.preventDefault();
                if (request) {
                    request.abort();
                }
                var $form = $(this);
                var serializedData = $form.serialize();

                request = $.ajax({
                    url: "php_backend/user/loginCode.php",
                    type: "post",
                    data: serializedData,
                });

                request.done(function (response, textStatus, jqXHR) {
                    console.log(response);
                    // console.log($.parseJSON(response));
                    const jsonData = $.parseJSON(response);

                    if (jsonData?.isSuccess) {
                        // $("#successmsg-area").text(jsonData.message);
                        console.log(jsonData);
                        Swal.fire({
                            title: "Good job!",
                            text: "Logged In Successfully",
                            icon: "success"
                        });

                        const loggedInData = {
                            id: jsonData?.data?.user?.id,
                            name: jsonData?.data?.user?.first_name,
                            email: jsonData?.data?.user?.email
                        }
                        localStorage.setItem("loggedInData", JSON.stringify(loggedInData))
                        location.href = 'index.php';
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Failed to login",
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