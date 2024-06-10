<nav class="navbar navbar-expand-lg navbar-light stickyNav">
    <div class="container-fluid ">
        <a class="navbar-brand" href="index.php" style="text-decoration:none">
            <div class="row g-0">
                <div class="col" style="color:#75aa22;">
                    <h3 class="m-0 p-0 brandName">Pi<span style="color:#426e0a;" class="m-0 p-0">Pharm</span></h3>
                </div>
                <div class="col">
                    <div class="brandNameSideTextArea">
                        <p class="my-0 py-0" style="color:#b9997c"><small class="brandNameSideText"
                                style="font-weight:600">online</small></p>
                        <p class="my-0 py-0" style="color:#b9997c"><small class="brandNameSideText"
                                style="font-weight:600">store</small> </p>
                    </div>
                </div>
            </div>
        </a>
        <div class="d-flex">
            <span class="navbar-toggler custom-toggler me-3" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </span>
            <span class="position-relative mt-1 me-1 cartIconMobile" style="cursor:pointer" data-toggle="modal"
                data-target="#cartModal">
                <span><i class="fa-solid fa-cart-shopping" style="font-size:20px"></i></span>
                <span id="cart-web"
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php
                    if (isset($_SESSION['loggedInId'])) {
                        $userId = $_SESSION['loggedInId'];
                        $sql = "SELECT * FROM cartitem WHERE `cust_id`=$userId";
                        $result = mysqli_query($conn, $sql);
                        $row_count = mysqli_num_rows($result);
                        echo $row_count;
                    } else {
                        echo 0;
                    }
                    ?>
                </span>
            </span>
        </div>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav px-5">
                <li class="nav-item me-2">
                    <a href="user-profile.php"
                        class="nav-link link-underline-light text-decoration-none avatarSectionListItems">Profile</a>
                </li>
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle" href="category.php" role="button" data-bs-toggle="dropdown"
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
                                            <a class="dropdown-item" href=<?= "all_sub_category.php?sub_category_id=" . $category_id ?>>
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
                                                            <a class="dropdown-item" href=<?= "all-shop.php?category_id=" . $category_id . "&sub_category_id=" . $sub_category_id ?>>
                                                                <?= $sub_category_name ?> <span
                                                                    class="float-end custom-toggle-arrow">&#187</span>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <?php

                                                                while ($row_product_by_sub_category = mysqli_fetch_assoc($result_product_by_sub_category)) {
                                                                    $product_name = $row_product_by_sub_category['prd_name'];

                                                                    ?>
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                            href='<?= "search.php?medicine_name=" . $product_name ?>'>
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
                                                            <a class="dropdown-item" href=<?= "all-shop.php?category_id=" . $category_id . "&sub_category_id=" . $sub_category_id ?>>
                                                                <?= $sub_category_name ?> <span
                                                                    class="float-end custom-toggle-arrow">&#187</span>
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

                                                <a class="dropdown-item" href=<?= "all_sub_category.php?sub_category_id=" . $category_id ?>>
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
                </li>
                <li class="nav-item active me-2">
                    <a href="all-shop.php" class="nav-link link-underline-light text-decoration-none">Shops</a>
                </li>
                <li class="nav-item me-2">
                    <a href="search.php" class="nav-link link-underline-light text-decoration-none">Search</a>
                </li>
                <li class="nav-item me-2">
                    <a href="about.php" class="nav-link link-underline-light text-decoration-none">About</a>
                </li>
                <li class="nav-item me-4 cartIconWeb">
                    <span class="position-relative" style="cursor:pointer;top: 10px;" data-toggle="modal"
                        data-target="#cartModal">
                        <span><i class="fa-solid fa-cart-shopping" style="font-size:20px"></i></span>
                        <span id="cart-mobile"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php
                            if (isset($_SESSION['loggedInId'])) {
                                $userId = $_SESSION['loggedInId'];
                                $sql = "SELECT * FROM cartitem WHERE `cust_id`=$userId";
                                $result = mysqli_query($conn, $sql);
                                $row_count = mysqli_num_rows($result);
                                echo $row_count;
                            } else {
                                echo 0;
                            }
                            ?>
                        </span>
                    </span>
                </li>

                <li class="nav-item me-2 avatarSectionListItems">
                    <a href="reset-password.php" class="nav-link link-underline-light text-decoration-none">Reset
                        Password</a>
                </li>
                <li class="nav-item me-2 avatarSectionListItems">
                    <a href="logout.php" class="nav-link link-underline-light text-decoration-none">Logout</a>
                </li>
                <span id="avatarSection">
                    <?php
                    if (isset($_SESSION['userType']) == false) {
                        ?>

                        <li class="nav-item me-2">
                            <a href="login.php" class="nav-link link-underline-light text-decoration-none"><i
                                    class="fa-solid fa-arrow-right-to-bracket me-1"></i>login</a>
                        </li>
                        <?php
                    } else {
                        if (isset($_SESSION['user_img'])) {
                            $imgSrc = $_SESSION['user_img'] ? "assets/img/user/" . $_SESSION['user_img'] : "assets/img/user/user.png";
                        }
                        ?>
                        <li class="nav-item me-2 d-xs-none nav-item-web">
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
                        </li>

                    <?php } ?>
                </span>
            </ul>
        </div>
    </div>
</nav>