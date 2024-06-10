<?php

include("cart/cartModal.php")

    ?>

<!-- <script>
    $(document).ready(function () {
        $('.btn-number').click(function (e) {
            e.preventDefault();

            var fieldName = $(this).attr('data-field');
            var type = $(this).attr('data-type');
            var input = $("input[id='" + fieldName + "']");
            var currentVal = parseInt(input.val());
            const productId = parseInt(fieldName.split("_")[1]);
            const productQuantity = parseInt($(`#product_qty_${productId}`).val());

       

            if (productQuantity >= currentVal+1) {
                if (!isNaN(currentVal)) {
                    if (type === 'minus') {
                        if (currentVal > 0) {
                            input.val(currentVal - 1);
                        }
                    } else if (type === 'plus') {
                        input.val(currentVal + 1);
                    }
                }
                else {
                    input.val(0);
                }
            }
            else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: `We have only ${productQuantity} in stock.`,
                });
            }
        });
    });

</script> -->
<!-- jquery link -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>