const clickEditCartItem = (cartId) => {
  console.log("cartsd id", cartId, document.getElementById(`plus_${cartId}`));
  document.getElementById(`plus_${cartId}`).style.display = "block";
  document.getElementById(`minus_${cartId}`).style.display = "block";

  document.getElementById(`actionOpt_${cartId}`).style.display = "none";
  document.getElementById(`back_${cartId}`).style.display = "block";
};
const clickDeleteCartItem = (cartId, productName) => {
  Swal.fire({
    title: "Are you sure?",
    text: `Wanna Delete This Item ${productName}!`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "php_backend/deleteCartItem/deleteCartItem.php",
        data: { cartId: cartId },
        success: function (response) {
          console.log(response);
          // Handle the response from the server
          const res = JSON.parse(response);

          if (res.isSuccess) {
            var currentValue = parseInt($("#cart").text());
            var incrementedValue = currentValue - 1;
            $("#cart").text(incrementedValue);
            $(`#${cartId}`).hide();

            Swal.fire({
              title: "Good job!",
              text: "You clicked the button!",
              icon: "success",
            });
          } else {
            console.log(res);
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Failed to delete cart item!",
            });
          }
        },
      });
    }
  });
};

const cancelUpdateCartItem = (cartId, prevQty) => {
  var input = document.getElementById(`qty_${cartId}`);
  input.value = prevQty;
  document.getElementById(`actionOpt_${cartId}`).style.display = "block";
  document.getElementById(`back_${cartId}`).style.display = "none";
  document.getElementById(`plus_${cartId}`).style.display = "none";
  document.getElementById(`minus_${cartId}`).style.display = "none";
};

const updateCartItem = (cartId, prevQty) => {
  var input = document.getElementById(`qty_${cartId}`);

  if (input.value != prevQty && input != 0) {
    const dataToSend = { cartId: cartId, qty: input.value };
    $.ajax({
      type: "POST",
      url: "php_backend/updateCartItem/updateCartItem.php", // Replace with your backend PHP file
      data: dataToSend,
      success: function (response) {
        console.log(response);
        // Handle the response from the server
        const res = JSON.parse(response);

        if (res.isSuccess) {
          Swal.fire({
            title: "Good job!",
            text: "You clicked the button!",
            icon: "success",
          });
          document.getElementById(`actionOpt_${cartId}`).style.display =
            "block";
          document.getElementById(`back_${cartId}`).style.display = "none";
        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Failed to update cart item!",
          });
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText); // Log any errors to the console
        // Example: Display an error message to the user
        alert("Error sending data to backend");
      },
    });
  } else if (input == 0) {
  }
};

// Function to fetch cart items via PHP and display in modal
$("#cartModal").on("show.bs.modal", function () {
  console.log("cart modal show");
  // Fetch cart items
  $.ajax({
    type: "GET",
    url: "php_backend/addToCart/fetch_cart_item.php", // Change to your PHP script to fetch cart items
    success: function (response) {
      $("#cartItems").html(response);
    },
    error: function () {
      $("#cartItems").html("<p>Failed to fetch cart items.</p>");
    },
  });
});

function clickCartItemIncDecBtn(event, element) {
  event.preventDefault();

  var fieldName = $(element).attr("data-field");
  var type = $(element).attr("data-type");
  var input = $("input[id='" + fieldName + "']");
  var currentVal = parseInt(input.val());
  console.log(currentVal, input, type, fieldName);

  if (!isNaN(currentVal)) {
    if (type === "minus") {
      if (currentVal > 0) {
        input.val(currentVal - 1);
      }
    } else if (type === "plus") {
      input.val(currentVal + 1);
    }
  } else {
    input.val(0);
  }
}
