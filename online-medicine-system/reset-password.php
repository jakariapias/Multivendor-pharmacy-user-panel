<!DOCTYPE html>
<html lang="en">
<?php include('./includes/head.php') ?>

<body class='bg-light-subtle'>
    <?php
    if (isset($_SESSION['status'])) {
        if ($_SESSION['status'] == "invalidUser") {
            echo "<script>Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Invalid User!',

          });
        </script>";
        }
        unset($_SESSION['status']);
    }
    ?>
    <section class="d-flex justify-content-center stickyNav" style="background-color:white">
        <section class="navArea position-sticky">
            <?php include('./includes/navbar.php') ?>
        </section>

    </section>
    <section style="min-height:400px">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Reset Password</h4>
                        </div>
                        <div class="card-body">
                            <!-- Password Reset Form -->
                            <form action="php_backend/reset/resetPasswordCode.php" method="post">
                                <input type="text" name="userId" value='<?= $_SESSION["loggedInId"] ?>' class="d-none">
                                <div class="form-group">
                                    <label for="currentPassword">Current Password</label>
                                    <input type="password" class="form-control" id="currentPassword"
                                        name="currentPassword" required>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="newPassword">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" name="newPassword"
                                        required>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPassword"
                                        name="confirmPassword" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block mt-3 w-100">Reset
                                    Password</button>
                            </form>
                            <!-- End Password Reset Form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <footer>
        <?php include("./includes/footer.php") ?>
    </footer>


</body>

</html>