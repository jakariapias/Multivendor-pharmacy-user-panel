<?php
include('../../config/dbConn.php');
if (isset($_POST['shopId'])) {
    $shopId = $_POST['shopId'];

    $categoryQuerry = "SELECT `id`,`cat_name` FROM category";
    $result = $conn->query($categoryQuerry);
    if ($result->num_rows > 0) {
        ?>
        <li><button href="#" class="btn btn-toggle w-100 text-start" onclick="selectCategory('<?=$shopId?>','')">
                <?= "All Medicine" ?>
            </button></li>
        <?php

        while ($row = $result->fetch_assoc()) {
            $catId = $row["id"];
            $catName = $row["cat_name"];

            $subCategoryQuerry = "SELECT `id`,`sub_category_name` FROM sub_category WHERE `category_id`=$catId AND `pharmacy_id`=$shopId";
            $subCategoryQresult = $conn->query($subCategoryQuerry);

            $rowCount = $subCategoryQresult->num_rows;
            if ($rowCount > 0) { ?>
                <button href="#services" class="w-100 btn btn-toggle d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse">
                    <?= $catName ?>
                    <span class="fw-bold">+</span>
                </button>
                <li>
                    <ul class="collapse list-unstyled " id="services">

                        <?php
                        while ($subCategoryRow = $subCategoryQresult->fetch_assoc()) {
                            $subCategoryId = $subCategoryRow["id"];
                            $subCategoryName = $subCategoryRow["sub_category_name"];
                            ?>

                            <li class="list-item px-5 py-2" style="cursor:pointer"
                                onclick='<?= "selectCategory($shopId,$catId,$subCategoryId)" ?>'>
                                <span class="link-dark rounded ">
                                    <?= $subCategoryName ?>
                                </span>

                            </li>

                            <?php
                        }
                        ?>

                    </ul>

                </li>

            <?php } else { ?>
                <li><button href="#" class="btn btn-toggle w-100 text-start" onclick='<?= "selectCategory($shopId,$catId)" ?>'>
                        <?= $catName ?>
                    </button></li>


                <?php
            }

        }
    }
}

?>

<script>
    $('.list-item').click(function () {
        // Remove highlighting from all items
        $('.list-item').removeClass('custom-highlight');

        // Add highlighting to the clicked item and set CSS properties
        $(this).addClass('custom-highlight').css({
            'border-radius': '6px',
            'background-color': '#a2f4a5', // Change this to the color you want for highlighting
            'color': 'black' // Change text color for better visibility
        });
        // Remove CSS properties from other list items
        $('.list-item').not(this).css({
            'background-color': '',
            'color': 'black'
        });
    });

</script>