<!DOCTYPE html>
<html lang="en">

<?php
include('includes/head.php');
?>

<body>
    <section id="loginBackgroundImg">

        <div class="loginCard">

            <div>
                <h1 class="text-center" style="font-weight:bolder"><a href="index.php"
                        class="fs-1 text-light">PI-PHARMACY</a></h1>
                <form id="reset-password-form" class='shadow'>

                    <div>
                        <h4 class='text-center mb-4' style="color:#047e6a;">Forget Password</h4>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="user-name"
                            placeholder="name@example.com">
                        <label for="floatingInput">User Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" name='email'
                            placeholder="Enter your account email">
                        <label for="floatingInput">Account Email address</label>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4 w-100 mb-2" aria-label="Close">SUBMIT</button>
                    <p><small><a href="login.php"><strong class="text-primary">Go to login</strong> </a></small></p>
                    <div>
                        <!-- Button trigger modal -->
                        <button type="button" id="modalOpenBTN" class="btn btn-primary d-none" data-toggle="modal"
                            data-target="#exampleModal_resetPass">
                            Launch demo modal
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal_resetPass" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content p-5 ">

                                    <div class="modal-body d-flex justify-content-center align-items-center">
                                        <img src="assets/img/mail/sendMail.gif" alt="" srcset="" height="150px">
                                    </div>
                                    <p class="text-center">Sending new password to your email..</p>

                                    <button type="button" id="modalCloseBTN" class="btn btn-secondary d-none"
                                        data-dismiss="modal">Close</button>


                                </div>
                            </div>
                        </div>
                    </div>



                </form>
            </div>

        </div>
    </section>

    <script type="text/javascript">
        $(document).ready(function () {

            let request;

            $("#reset-password-form").submit(function (event) {
                $('#modalOpenBTN').click();

                event.preventDefault();
                if (request) {
                    request.abort();
                }
                var $form = $(this);
                var serializedData = $form.serialize();

                request = $.ajax({
                    url: "php_backend/reset/send-password-to-user-email.php",
                    type: "post",
                    data: serializedData,
                });

                request.done(function (response, textStatus, jqXHR) {
                    console.log(response);
                    // console.log($.parseJSON(response));
                    const jsonData = $.parseJSON(response);

                    if (jsonData?.isSuccess) {
                        console.log(jsonData)
                        document.getElementById('modalCloseBTN').click();
                        Swal.fire({
                            title: "Good job!",
                            text: "New Password sent to "+jsonData.data.result.data.destinationMail,
                            icon: "success"
                        });
                    } else {
                        document.getElementById('modalCloseBTN').click();
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Failed to send mail",
                        });
                    }
                });

                request.fail(function (jqXHR, textStatus, errorThrown) {
                    document.getElementById('modalCloseBTN').click();
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