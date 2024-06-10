<!DOCTYPE html>
<html lang="en">
<?php include('./includes/head.php') ?>

<body class='bg-light-subtle'>
    <section class="d-flex justify-content-center stickyNav" style="background-color:white">
        <section class="navArea position-sticky">
            <?php include('./includes/navbar.php') ?>
        </section>

    </section>
    <section>
        <section style="background-color: #eee; min-height:91.3vh">
            <section class="container pt-3">
                <div class="row bg-white ps-2">
                    <div class="col-md-8 overflow-auto py-4" style="max-height:86vh">
                        <p class="fs-3 mb-4">Product Details</p>
                        <div class="d-flex align-items-center">
                            <p class="w-25">Image</p>
                            <p class="w-50">Product name</p>
                            <p style="width:25%">Product Price</p>
                            <p style="width:25%">Quantity</p>
                            <p style="width:25%">sub Total</p>
                        </div>
                        <?php
                        $userId = $_SESSION["loggedInId"];

                        $sql = "SELECT cartitem.*, product.* 
                     FROM cartitem
                     INNER JOIN product ON cartitem.prod_id = product.prd_id 
                     WHERE cartitem.cust_id = $userId";
                        $result = mysqli_query($conn, $sql);
                        $i = $total_qty = $total = 0;
                        $pharmacy_id_list = [];

                        $row_count = mysqli_num_rows($result);

                        while ($row = mysqli_fetch_array($result)) {
                            $cart_item_id = $row["id"];
                            $pharmacy_id = $row["pharmacy_id"];
                            $product_id = $row["prod_id"];
                            $product_name = $row["prd_name"];
                            $product_price = $row["price"];
                            $product_image = $row["prd_image"];
                            $product_qty = $row["qty"];

                            if (!in_array($pharmacy_id, $pharmacy_id_list)) {
                                $pharmacy_id_list[] = $pharmacy_id;
                            }



                            $image_source = isset($product_image) ? "../pipharm-admin-panel/assets/images/product/" . $product_image : "assets/img/default.jpg";
                            ?>
                            <div class="d-flex align-items-center">
                                <div class="w-25"><img src=<?= $image_source ?> class="p-1 bir img-thumbnail" width="90"
                                        alt="asa"></div>
                                <div class="w-50">
                                    <?= $product_name ?>
                                </div>
                                <div style="width:25%">
                                    <?= $product_price ?>
                                </div>
                                <div style="width:25%">
                                    <?= $product_qty ?>
                                </div>
                                <div style="width:25%"><i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                    <?= ($product_qty * $product_price) ?>
                                </div>
                            </div>

                            <?php

                            $total = $total + ($product_qty * $product_price);
                            $total_qty = $total_qty + $product_qty;

                            echo "<hr/>";

                        }
                        ?>
                        <div class="d-flex align-items-center">

                            <div style="width:100%" class="fs-6">
                                <p><strong>Total</strong></p>
                            </div>

                            <div style="width:25%" class="fs-6">
                                <p>
                                    <?= $total_qty ?>
                                </p>
                            </div>
                            <div style="width:25%">
                                <p class="fs-6"><i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                    <?= $total ?>
                                </p>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4 bg-white rounded-lg shadow-sm p-4">
                        <!-- Credit card form tabs -->
                        <ul role="tablist" class="nav bg-light nav-pills rounded-pill nav-fill mb-3">
                            <li class="nav-item">
                                <a data-toggle="pill" href="#nav-tab-card" class="nav-link active rounded-pill">
                                    <i class="fa fa-credit-card"></i>
                                    Credit Card
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a data-toggle="pill" href="#nav-tab-paypal" class="nav-link rounded-pill">
                                    <i class="fa fa-paypal"></i>
                                    Bkash
                             
                                </a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="pill" href="#nav-tab-bank" class="nav-link rounded-pill">
                                    <i class="fa fa-university"></i>
                                    Nagad
                                </a>
                            </li> -->
                        </ul>
                        <!-- End -->


                        <!-- Credit card form content -->
                        <div class="tab-content">

                            <!-- credit card info-->
                            <div id="nav-tab-card" class="tab-pane fade show active">
                                <!-- <p class="alert alert-success">Some text success or error</p> -->
                                <?php include("./includes/paymentForm/Card.php") ?>
                            </div>
                            <!-- End -->

                            <!-- Paypal info -->
                            <!-- <div id="nav-tab-paypal" class="tab-pane fade">
                                <p>Paypal is easiest way to pay online</p>
                                <p>
                                    <button type="button" class="btn btn-primary rounded-pill"><i
                                            class="fa fa-paypal mr-2"></i> Log into my Paypal</button>
                                </p>
                                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur
                                    adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                                    dolore magna aliqua.
                                </p>
                            </div> -->
                            <!-- End -->

                            <!-- bank transfer info -->
                            <!-- <div id="nav-tab-bank" class="tab-pane fade">
                                <h6>Bank account details</h6>
                                <dl>
                                    <dt>Bank</dt>
                                    <dd> THE WORLD BANK</dd>
                                </dl>
                                <dl>
                                    <dt>Account number</dt>
                                    <dd>7775877975</dd>
                                </dl>
                                <dl>
                                    <dt>IBAN</dt>
                                    <dd>CZ7775877975656</dd>
                                </dl>
                                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur
                                    adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                                    dolore magna aliqua.
                                </p>
                            </div> -->
                            <!-- End -->
                        </div>
                        <!-- End -->

                    </div>

                </div>
            </section>
        </section>
    </section>
    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</body>

</html>