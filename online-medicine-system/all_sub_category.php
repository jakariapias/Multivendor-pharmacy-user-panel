<!DOCTYPE html>
<html lang="en">
<?php include('./includes/head.php') ?>

<body class='bg-light-subtle'>
    <section class="d-flex justify-content-center stickyNav" style="background-color:white">
        <section class="navArea position-sticky">
            <?php include('./includes/navbar.php') ?>
        </section>

    </section>
    <section class="d-flex justify-content-center bg-light">
        <section class="w-75">
            <div class="container pb-5 pt-4">

                <div class="row" style="min-height:43.9vh">
                    <?php
                    $category_id = $_GET["sub_category_id"];
                    $sql = "SELECT * FROM sub_category WHERE `category_id`=$category_id";
                    $result = mysqli_query($conn, $sql);
                    $row_count = mysqli_num_rows($result);
                    if ($row_count > 0) {
                        ?>
                        <h3>All Sub Categories</h3>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            $id = $row['id'];
                            $sub_category_name = $row['sub_category_name'];
                            $Sub_category_image = $row['sub_category_image'];

                            $image_src = $Sub_category_image ? "../pipharm-admin-panel/assets/images/sub_categories/" . $Sub_category_image : "assets/img/default.jpg";

                            ?>
                            <a href=<?= "all-shop.php?category_id=" . $category_id . "&sub_category_id=" . $id ?>
                                class="col-md-3 pt-3">

                                <div class="card text-bg-dark" style="border-radius:10px; width:100%;">
                                    <img src=<?= $image_src ?> class="card-img" alt="" style="border-radius:10px; height:220px">
                                    <div class="card-img-overlay p-0" style="border-radius:10px">
                                        <div class="d-flex justify-content-center align-items-center"
                                            style="height:100%;background-color:#057e547a;border-radius:10px">
                                            <p class="card-text text-light fs-4"><small>
                                                    <?= $sub_category_name ?>
                                                </small></p>
                                        </div>
                                    </div>
                                </div>

                            </a>

                            <?php
                        }
                    } else {
                        ?>
                        <div style="min-height:43.9vh" class="d-flex align-items-center justify-content-center">
                            <div class="p-5">
                                <h5 class="text-center">Sub Categories not found!</h5>
                                <p class="text-secondary fs-5 my-4">You can view the details of the store that sells the
                                    medicine under the category you clicked!</p>
                                <div class="text-center">
                                    <a href=<?= "all-shop.php?category_id=" . $category_id ?>>
                                        <button type="button" class="btn btn-primary">Go to Shop <i
                                                class="fa-solid fa-arrow-right ms-1"></i></button>
                                    </a>
                                </div>


                            </div>

                        </div>

                        <?php
                    }
                    ?>
                </div>
            </div>
        </section>

    </section>
    <footer>
        <?php include("./includes/footer.php") ?>
    </footer>
</body>

</html>