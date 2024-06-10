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
                <h3>All Categories</h3>
                <div class="row">
                    <?php
                    $sql = 'SELECT * FROM category';
                    $result = mysqli_query($conn, $sql);
                    $row_count = mysqli_num_rows($result);
                    if ($row_count > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            $id = $row['id'];
                            $category_name = $row['cat_name'];
                            $category_image = $row['cat_image'];

                            $image_src = $category_image ? "../pipharm-admin-panel/assets/images/categories/" . $category_image : "assets/img/default.jpg";

                            ?>
                            <a href=<?= "all_sub_category.php?sub_category_id=" . $id ?> class="col-md-3 pt-3">

                                <div class="card text-bg-dark" style="border-radius:10px; width:100%;">
                                    <img src=<?= $image_src ?> class="card-img" alt="" style="border-radius:10px; height:220px">
                                    <div class="card-img-overlay p-0" style="border-radius:10px">
                                        <div class="d-flex justify-content-center align-items-center"
                                            style="height:100%;background-color:#057e547a;border-radius:10px">
                                            <p class="card-text text-light fs-4"><small>
                                                    <?= $category_name ?>
                                                </small></p>
                                        </div>
                                    </div>
                                </div>

                            </a>

                            <?php
                        }
                    } else {
                        ?>
                        <div class="p-5">
                            <h5 class="text-center">Categories not found!</h5>
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