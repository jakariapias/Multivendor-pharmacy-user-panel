<!DOCTYPE html>
<html lang="en">
<?php
include('./includes/head.php');
?>

<body class='bg-light-subtle'>
    <section class="d-flex justify-content-center stickyNav" style="background-color:white">
        <section class="navArea position-sticky">
            <?php include('./includes/navbar.php') ?>
        </section>

    </section>
    <section class="bg-light">

        <div class="container ">

            <div class="row">
                <div class="card my-3 pt-3">
                    <h3>Order Details</h3>
                    <?php
                    $ord_id = $_GET['id'];

                    $fetchCatQuerry = "SELECT orders.*,pharmacy_admin.id, pharmacy_admin.shop_name, pharmacy_admin.admin_email,pharmacy_admin.admin_phone
                    FROM `orders` 
                    INNER JOIN pharmacy_admin ON orders.pharmacy_id = pharmacy_admin.id AND orders.id=$ord_id";

                    $querry_result = mysqli_query($conn, $fetchCatQuerry);

                    if ($querry_result == true) {
                        $count = mysqli_num_rows($querry_result);
                        $slNo = 1;

                        if ($count > 0) {
                            $rows = mysqli_fetch_assoc($querry_result);

                            //pharmacy details
                            $pharmacy_id = $rows['id'];
                            $pharmacy_name = $rows['shop_name'];
                            $pharmacy_email = $rows['admin_email'];
                            $pharmacy_phone = $rows['admin_phone'];

                            //order details
                            $ord_date = $rows['created_date'];
                            $ord_code = $rows['order_code'];
                            $amount = $rows['sale_amount'];
                            $pay_method = $rows['payment_method'];
                            $status = $rows['delivery_status'];
                            $total_items = $rows['total_items'];
                            $shippingCost = $rows['shipping_cost'];
                            $tax = $rows['tax'];

                            $myDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $ord_date);
                            $date = $myDateTime->format('jS F Y');
                            $time = $myDateTime->format('g:ia');


                            $address = explode("@", $rows['shipping_address']);
                            $contact = $rows['contact_no'];

                            $delivery_status = $rows["delivery_status"];
                            $rowColor = "rgba(154, 154, 154, 0.2)";
                            $fontColor = "#9a9a9a;";
                            if ($delivery_status == "on-the-way") {

                                $rowColor = "rgba(122, 186, 66, 0.2)";
                                $fontColor = "#448108";
                            } else if ($delivery_status == "completed") {
                                $rowColor = "rgba(66, 186, 150, 0.2)";
                                $fontColor = "#42ba96";

                            } else if ($delivery_status == "packaging") {
                                $rowColor = "rgba(200, 219, 27, 0.2)";
                                $fontColor = "#aaae38";
                            }

                            ?>
                            <div class="card-body">
                                <div class="title-header title-header-block package-card">
                                    <div>
                                        <p class="p-0 m-0"><span style="font-weight:600">Pharmacy Name: </span><?=$pharmacy_name?></p>
                                        <p class="p-0 m-0"><span style="font-weight:600">Email: </span><?=$pharmacy_email?></p>
                                        <p class="p-0 mb-2"><span style="font-weight:600">Phone: </span><?=$pharmacy_phone?$pharmacy_phone:"N/A"?></p>
                                    </div>
                                    <div>
                                        <h5>
                                            <?php echo $ord_code; ?>
                                        </h5>
                                        <span class="p-1"
                                            style='background-color:<?= $rowColor ?>;color:<?= $fontColor ?>;border-radius:5px'>
                                            <?= strtoupper($delivery_status) ?>
                                        </span>
                                    </div>
                                    <div>
                                        <hr>
                                        <ul class="d-flex p-0 fs-5" style="list-style:none">
                                            <li class="me-2">
                                                <?php echo $date . " at " . $time; ?> /
                                            </li>
                                            <li class="me-2">
                                                <?php echo $total_items; ?> items
                                            </li> /
                                            <li class="ms-2">Total <span style="font-size:30px ; line-height:0;">৳</span>
                                                <?php echo $amount; ?>
                                            </li>
                                        </ul>
                                        <hr>
                                    </div>
                                </div>
                                <div class="bg-inner cart-section order-details-table">
                                    <div class="row g-4">
                                        <div class="col-xl-8">
                                            <div class="table-responsive table-details">
                                                <table class="table cart-table table-borderless">
                                                    <tbody>
                                                        <?php
                                                        $fetchCatQuerry = "SELECT orderitems.*, product.prd_id, product.prd_name, product.prd_description, product.prd_price, product.prd_image FROM orderitems INNER JOIN product ON orderitems.prod_id = product.prd_id AND orderitems.order_code='$ord_code' ORDER BY orderitems.order_code DESC";


                                                        // $fetchCatQuerry = "SELECT * FROM orderitems WHERE ord_id=$ord_id";
                                                        $querry_result = mysqli_query($conn, $fetchCatQuerry);

                                                        $totalAmount = 0;
                                                        if ($querry_result == true) {
                                                            $cartTotal = 0;
                                                            $count = mysqli_num_rows($querry_result);
                                                            $slNo = 1;
                                                            if ($count > 0) {
                                                                while ($rows = mysqli_fetch_assoc($querry_result)) {


                                                                    $item_image = $rows['prd_image'];

                                                                    $qty = $rows['qty'];
                                                                    $product_name = $rows['prd_name'];
                                                                    $subTotal = $rows['subTotal'];
                                                                    $slNo++;

                                                                    $imgSrc = $item_image !== '' ? '../pipharm-admin-panel/assets/images/product/' . $item_image : 'assets/img/default.jpg';

                                                                    ?>
                                                                    <tr class="table-order">
                                                                        <td>
                                                                            <img width="80" src=<?= $imgSrc ?>
                                                                                class="img-fluid blur-up lazyload">
                                                                        </td>

                                                                        <td class="align-middle">
                                                                            <h6 class="text-wrap">
                                                                                <?php echo "<strong>$product_name</strong>" ?>
                                                                            </h6>
                                                                        </td>
                                                                        <td class="align-middle">

                                                                            <h6>
                                                                                <?php echo $qty; ?>
                                                                            </h6>


                                                                        </td>
                                                                        <td class="align-middle">
                                                                            <h6>$
                                                                                <?php echo $subTotal ?>
                                                                            </h6>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            } else {
                                                                echo "<h5 class='text-center'>Order Detail Cart Is empty</h5>";
                                                            }
                                                        } else {
                                                            echo "Error: " . $conn->error;
                                                            ;
                                                        }
                                                        ?>
                                                    </tbody>

                                                    <tfoot class="border-top mt-3">
                                                        <tr>
                                                        <tr class="table-order">
                                                            <td colspan="3">
                                                                <h6>Subtotal :</h6>
                                                            </td>
                                                            <td>
                                                                <h6>$
                                                                    <?php echo $amount ?>
                                                                </h6>
                                                            </td>
                                                        </tr>

                                                        <tr class="table-order">
                                                            <td colspan="3">
                                                                <h6>Shipping :</h6>
                                                            </td>
                                                            <td>
                                                                <h6>$
                                                                    <?php echo $shippingCost; ?>
                                                                </h6>
                                                            </td>
                                                        </tr>

                                                        <tr class="table-order">
                                                            <td colspan="3">
                                                                <h6>Tax:</h6>
                                                            </td>
                                                            <td>
                                                                <h6>$
                                                                    <?php echo $tax; ?>
                                                                </h6>
                                                            </td>
                                                        </tr>
                                                        <tr class="table-order">
                                                            <td colspan="3">
                                                                <h6 class="theme-color fw-bold">Total Price :</h4>
                                                            </td>
                                                            <td>
                                                                <h6 class="theme-color fw-bold">$
                                                                    <?php echo $amount; ?>
                                                                </h6>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class="order-success">
                                                <div class="row g-4">
                                                    <h4>summery</h4>
                                                    <ul class="order-details" style="list-style:none">
                                                        <li>Order ID:
                                                            <?php echo $ord_code; ?>
                                                        </li>
                                                        <li>Order Date:
                                                            <?php echo $date; ?>
                                                        </li>
                                                        <li>Order Total: $
                                                            <?php echo $amount; ?>
                                                        </li>
                                                    </ul>

                                                    <!-- <h4>shipping address</h4>
                                                    <ul class="order-details">
                                                        <li>
                                                            <?php echo "Address: " . '$address[0]'; ?>
                                                        </li>
                                                        <li>
                                                            <?php echo "City: " . ' $address[1]' ?>
                                                        </li>
                                                        <li>
                                                            <?php echo "State: " . '$address[2]'; ?>
                                                        </li>
                                                        <li>
                                                            <?php echo "Phone: " . $contact; ?>
                                                        </li>
                                                    </ul> -->

                                                    <div class="payment-mode">
                                                        <h4>payment method</h4>
                                                        <p>
                                                            <?php echo $pay_method; ?>
                                                        </p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- section end -->
                            </div>
                            <?php
                        }
                    } else {
                        echo mysqli_error($conn);
                    } ?>
                </div>

            </div>
        </div>


    </section>
    <footer>
        <?php include("./includes/footer.php") ?>
    </footer>
</body>

</html>