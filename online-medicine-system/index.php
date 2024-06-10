<!DOCTYPE html>
<html lang="en">
<?php
include('./includes/head.php');
include('./includes/check-login.php');
?>

<body class='bg-light-subtle'>
    <?php
    if (isset($_SESSION['status'])) {

        if ($_SESSION['status'] == "successReset") {
            echo "<script>Swal.fire(
            'Great!',
            'Reset Password Successfully!',
            'success'
        );
        </script>";
        } else if ($_SESSION['status'] == "failReset") {
            echo "<script>Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Invalid Current Password!',

          });
        </script>";
        }
        unset($_SESSION['status']);
    }
    ?>

    <section>
        <section class="d-flex justify-content-center stickyNav" style="background-color:white">
            <section class="navArea position-sticky">
                <?php include('./includes/navbar.php') ?>
            </section>

        </section>


        <div>
            <?php include('./includes/slider-banner.php') ?>
        </div>
        <div class="mb-5">
            <div class="container text-center">
                <div class="row g-2">
                    <div class="col-md-12 col-xs-12 ">
                        <h4 class="mt-4 mb-2">Best Sellers</h4>
                    </div>

                    <?php
                    // SQL query to find best sellers
                    $sql = "SELECT pa.id, pa.shop_name, pa.shop_image, pa.rating, pad.*, SUM(o.total_items) AS total_sales
                                    FROM pharmacy_admin pa
                                    INNER JOIN orders o ON pa.id = o.pharmacy_id
                                    INNER JOIN pharmacy_address pad ON pa.id = pad.pharmacy_id
                                    GROUP BY pa.id
                                    ORDER BY total_sales DESC
                                    LIMIT 4";

                    $result = mysqli_query($conn, $sql);
                    $row_count = mysqli_num_rows($result);
                    if ($row_count > 0) {
                        while ($row = mysqli_fetch_array($result)) {

                            $shopId = $row["id"];
                            $shopName = $row["shop_name"];
                            $shopImage = $row["shop_image"];
                            $shopRating = $row["rating"];
                            $address = $row["address"] . ", " . $row["city"];

                            $imgSrc = $shopImage ? "../pipharm-admin-panel/assets/images/store/banner/" . $shopImage : "assets/img/shop/pharmacy.png";
                            ?>
                            <div class="col-md-3 col-xs-12 col-sm-4 col-xs-6">
                                <div class="card shadow rounded-4" style="width:100%;">
                                    <div class="p-3" style="background-color:#f2f2f2;">
                                        <img src=<?= $imgSrc ?> class="card-img-top" style="height:180px;" alt="..."
                                            onerror="this.src='assets/img/default.jpg'">
                                    </div>

                                    <div class="card-body">
                                        <h5 class="card-title text-center">
                                            <?= $shopName ?>
                                        </h5>
                                        <div>
                                            <div class="my-1">
                                                <p class="text-center">
                                                    <?php
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        ?>
                                                        <i class="fa-regular fa-star"></i>
                                                        <?php
                                                    }

                                                    ?>

                                                </p>
                                                <div class="d-flex align-items-center" style="height:50px">
                                                    <div class="p-2 border me-2 rounded"><i
                                                            class="fa-solid fa-location-dot "></i></div>
                                                    <small>
                                                        <?= $address ?>
                                                    </small>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="text-center border-top">
                                            <a href=<?php echo "shop.php?id=" . $shopId; ?> style="color:#022314">Visit
                                                <i class="fa-solid fa-arrow-right ps-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div style="min-height:30vh" class="col-md-12 d-flex justify-content-center align-items-center">
                            <div>
                                <div class="text-center mb-2">
                                    <img src="assets/img/empty-folder.png" class="img-fluid mb-4" style="width:120px"
                                        alt="Responsive image">
                                </div>
                                <h5 class="text-center mb-4">No Seller Data found!</h5>
                            </div>

                        </div>
                        <?php

                    }
                    ?>

                </div>
            </div>
        </div>

        <div class="bg-light p-5">

            <div class="row g-2">
                <div class="col-md-12 col-xs-12">
                    <h3 class="text-center">Our Service</h3>
                </div>
                <div class="col-md-4 col-xs-12">
                    <div class="bg-white pt-2" style="border-radius:10px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div><i class="fa-solid fa-cart-plus serviceIcons"></i></div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <h3>Online Shopping</h3>
                                </div>
                            </div>
                            <div class="pt-3 ps-3">
                                <p>
                                    Choose a nearby store to see what's available
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-xs-12">
                    <div class="bg-white pt-2" style="border-radius:10px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div><i class="fa-regular fa-clock serviceIcons"></i></div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <h3>On Time Delivery</h3>
                                </div>
                            </div>
                            <div class="pt-3 ps-3">
                                <p>
                                    Don’t worry! The orders always arrive on time.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-xs-12">
                    <div class="bg-white pt-2" style="border-radius:10px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div><i class="fa-solid fa-money-bill-transfer serviceIcons"></i></div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <h3>Free Returens</h3>
                                </div>
                            </div>
                            <div class="pt-3 ps-3">
                                <p>
                                    All returns are subject to verification of original sale
                                </p>
                            </div>
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