<section class="d-flex justify-content-between align-items-center py-1 bg-white">
    <a href="index.php" style="text-decoration:none">
        <div class="d-flex">
            <div style="padding-right:2px; color:#75aa22;">
                <h3 style="font-weight:700; font-size:40px">Pi</h3>
            </div>
            <div class="pe-1">
                <h3 style="font-weight:700; font-size:40px; color:#426e0a">Pharm</h3>
            </div>
            <div style="line-height: 0.85;
                margin-top: 14px;">
                <p class="my-0 py-0" style="color:#b9997c"><span style="font-weight:600">online</span></p>
                <p class="my-0 py-0" style="color:#b9997c"><span style="font-weight:600">store</span> </p>
            </div>

        </div>
    </a>

    <div>
        <nav class="d-flex align-items-center">


            <span class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    categories
                </a>
                <ul class="dropdown-menu" style="width:220px">

                    <?php
                    $sql = "SELECT * FROM category";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        $row_count = mysqli_num_rows($result);

                        if ($row_count > 0) {
                            while ($row_category = mysqli_fetch_assoc($result)) {
                                $category_id = $row_category['id'];
                                $category_name = $row_category['cat_name'];
                                $sql_sub_category = "SELECT * FROM sub_category WHERE category_id=$category_id";
                                $result_sub_category = mysqli_query($conn, $sql_sub_category);

                                if ($result_sub_category && mysqli_num_rows($result_sub_category)) {

                                    ?>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item" href="#">
                                            <?= $category_name ?>
                                            <span class="float-end custom-toggle-arrow">&#187</span>
                                        </a>

                                        <ul class="dropdown-menu">
                                            <?php
                                            while ($row_sub_category = mysqli_fetch_assoc($result_sub_category)) {
                                                $sub_category_id = $row_sub_category['id'];
                                                $sub_category_name = $row_sub_category['sub_category_name'];

                                                $sql_product_by_sub_category = "SELECT DISTINCT prd_name FROM product WHERE prd_sub_cat_id=$sub_category_id";
                                                $result_product_by_sub_category = mysqli_query($conn, $sql_product_by_sub_category);
                                                if ($result_product_by_sub_category && mysqli_num_rows($result_product_by_sub_category) > 0) {
                                                    ?>
                                                    <li class="dropdown-submenu">
                                                        <a class="dropdown-item" href="#">
                                                            <?= $sub_category_name ?> <span class="float-end custom-toggle-arrow">&#187</span>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <?php

                                                            while ($row_product_by_sub_category = mysqli_fetch_assoc($result_product_by_sub_category)) {
                                                                $product_name = $row_product_by_sub_category['prd_name'];

                                                                ?>
                                                                <li>
                                                                    <a class="dropdown-item" href='<?= "search.php?medicine_name=" . $product_name ?>'>
                                                                        <?= $product_name ?>
                                                                    </a>
                                                                </li>
                                                                <?php

                                                            }
                                                            ?>
                                                        </ul>
                                                    </li>
                                                    <?php
                                                } else {
                                                    ?>

                                                    <li class="dropdown-submenu">
                                                        <a class="dropdown-item" href="#">
                                                            <?= $sub_category_name ?> <span class="float-end custom-toggle-arrow">&#187</span>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">No products found</a></li>
                                                        </ul>
                                                    </li>

                                                    <?php
                                                }


                                            }
                                            ?>
                                        </ul>
                                    </li>
                                    <?php



                                } else {



                                    $sql_product_by_category = "SELECT DISTINCT prd_name FROM product WHERE prd_cat_id=$category_id";
                                    $result_product_by_category = mysqli_query($conn, $sql_product_by_category);
                                    if ($result_product_by_category && mysqli_num_rows($result_product_by_category) > 0) {
                                        ?>
                                        <li class="dropdown-submenu">

                                            <a class="dropdown-item" href="#">
                                                <?= $category_name ?>
                                                <span class="float-end custom-toggle-arrow">&#187</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <?php
                                                while ($row_product = mysqli_fetch_assoc($result_product_by_category)) {

                                                    $product_name = $row_product['prd_name'];
                                                    ?>
                                                    <li>
                                                        <a class="dropdown-item" href='<?= "search.php?medicine_name=" . $product_name ?>'>
                                                            <?= $product_name ?>
                                                        </a>
                                                    </li>

                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </li>
                                        <?php
                                    } else {

                                        ?>
                                        <li class="dropdown-submenu">
                                            <a class="dropdown-item" href="#">
                                                <?= $category_name ?> <span class="float-end custom-toggle-arrow">&#187</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">No products found</a></li>
                                            </ul>
                                        </li>
                                        <?php
                                    }
                                }
                            }

                        }
                    }
                    ?>
                </ul>
            </span>
            <!-- <a href="category.php" class="link-underline-light text-decoration-none me-3">Categories</a> -->

            <a href="all-shop.php" class="link-underline-light text-decoration-none me-3">Shops</a>
            <!-- <a href="" class="link-underline-light text-decoration-none me-3">Help</a> -->
            <a href="search.php" class="link-underline-light text-decoration-none me-3">Search</a>
            <a href="about.php" class="link-underline-light text-decoration-none me-3">About</a>
            <span class="position-relative mt-1 me-1" style="cursor:pointer" data-toggle="modal"
                data-target="#cartModal">
                <span><i class="fa-solid fa-cart-shopping" style="font-size:20px"></i></span>
                <span id="cart" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php
                    if (isset($_SESSION['loggedInId'])) {
                        $userId = $_SESSION['loggedInId'];
                        $sql = "SELECT * FROM cartitem WHERE `cust_id`=$userId";
                        $result = mysqli_query($conn, $sql);
                        $row_count = mysqli_num_rows($result);
                        echo $row_count;
                    }
                    ?>
                </span>
            </span>

            <span class="ms-4">
                <?php
                if (isset($_SESSION['userType']) == false) {
                    ?>
                    <a href="login.php" class="link-underline-light text-decoration-none"><i
                            class="fa-solid fa-arrow-right-to-bracket"></i> login</a>
                    <?php
                } else {
                    if (isset($_SESSION['user_img'])) {
                        $imgSrc = $_SESSION['user_img'] ? "assets/img/user/" . $_SESSION['user_img'] : "assets/img/user/user.png";
                    }
                    ?>
                    <div>
                        <img src=<?= $imgSrc ?> id="dropdownMenuButton" class="rounded-circle dropdown-toggle"
                            style="width: 35px; cursor:pointer" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" />
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="user-profile.php"><i class="fa-solid fa-user me-2"
                                    style="color:#12dab9;"></i>Profile</a>
                            <a class="dropdown-item" href="reset-password.php"><i
                                    class="fa-solid fa-screwdriver-wrench me-2" style="color:#12dab9;"></i></i>Reset
                                Password</a>
                            <a class="dropdown-item" href="logout.php"><i class="fa-solid fa-power-off me-2"
                                    style="color:red;"></i>Logout</a>

                        </div>
                    </div>
                <?php } ?>
            </span>
        </nav>
    </div>

</section>