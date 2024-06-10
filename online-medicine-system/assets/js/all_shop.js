// Function to load all products
function loadAllProducts(shopId) {
  $.ajax({
    url: "php_backend/shop/get_products.php",
    type: "POST",
    data: { shopId: shopId },
    success: function (response) {
      $("#product_list").html(response);
    },
  });
}

//   Get products based on category selection
function selectCategory(shopId, category_id, sub_category_id) {
  $.ajax({
    url: "php_backend/shop/get_products.php",
    type: "POST",
    data: {
      shopId: shopId,
      category_id: category_id,
      sub_category_id: sub_category_id,
    },
    success: function (response) {
      $("#product_list").html(response);
    },
  });
  //     }
}

$(document).ready(function () {
  // Change the '+' and '-' signs on collapse/expand
  // document.querySelectorAll(".sidebar .collapse").forEach((collapseElement) => {
  //   collapseElement.addEventListener("show.bs.collapse", function () {
  //     const parentAnchor = this.previousElementSibling;
  //     parentAnchor.querySelector("span").textContent = "-";
  //   });
  //   collapseElement.addEventListener("hide.bs.collapse", function () {
  //     const parentAnchor = this.previousElementSibling;
  //     parentAnchor.querySelector("span").textContent = "+";
  //   });
  // });

  // Load categories
  $.ajax({
    url: "php_backend/shop/get_categories.php",
    type: "POST",
    data: { shopId: shopId },
    success: function (response) {
      $("#category_list").html(response);
    },
  });

  // search medicine
  // Listen for changes in the search input
  $("#searchInput").on("input", function () {
    // Fetch data when the search input changes
    fetchDataSearchTerm($(this).val());
  });
});

//fetch medicine data by name

function fetchDataSearchTerm(searchTerm) {
  // Make an AJAX request to the search.php script
  $.ajax({
    url: "php_backend/shop/searchMedicine.php",
    method: "POST",
    data: { shopId: shopId, searchTerm: searchTerm },
    success: function (response) {
      if (searchTerm) {
        $("#searchingMessage").show();
        $("#searchingMessage").text(
          `Showing searching result for: ${searchTerm}`
        );
      } else {
        $("#searchingMessage").hide();
      }

      $("#product_list").html(response);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error("Error fetching data:", errorThrown);
    },
  });
}

// Function to add to cart
function addToCart(productId, productPrice, userId = null, pharmacyId) {
  var quantity = parseInt($("#quantity_" + productId).val());

  var dataToSend = {
    id: productId,
    qty: quantity,
    price: productPrice,
    pharmacy_id: pharmacyId,
  };
  if (userId != -1) {
    $.ajax({
      type: "POST",
      url: "php_backend/addToCart/add_to_cart.php", // Replace with your backend PHP file
      data: dataToSend,
      success: function (response) {
        console.log(response);
        // Handle the response from the server
        const res = JSON.parse(response);
        console.log(res.type)

        if (res.type == "add") {
          //update cart
          var currentValue = parseInt($("#cart-web").text());
          var incrementedValue = currentValue + 1;
          
          $("#cart-web").text(incrementedValue);
          $("#cart-mobile").text(incrementedValue);

          const inputId = "#quantity_" + productId;
          $(inputId).val(1);
          Swal.fire({
            title: "Good job!",
            text: "Added Cart Item Successfully",
            icon: "success",
          });
        } else {
          const inputId = "#quantity_" + productId;
          $(inputId).val(1);
          Swal.fire({
            title: "Good job!",
            text: "Updated Cart Item Successfully",
            icon: "success",
          });
        }
        // Example: Display a success message to the user
        // alert('Data sent successfully to backend');
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText); // Log any errors to the console
        // Example: Display an error message to the user
        alert("Error sending data to backend");
      },
    });
  } else {
    console.log("asd");
    document.getElementById("loginPageLink").click();
  }

  // alert('Added ' + quantity + ' items of product with ID ' + productId + ' to cart');
}

const clickDecreasePrdQty = (productId) => {
  console.log(productId);
  const currentValue = parseInt($(`#quantity_${productId}`).val());
  const newValue = currentValue - 1;
  if (currentValue > 1) {
    $(`#quantity_${productId}`).val(newValue);
  }
};
const clickIncreasePrdQty = (productId, productQty) => {
  console.log(productId);
  const currentValue = parseInt($(`#quantity_${productId}`).val());
  const newValue = currentValue + 1;
  if (currentValue == parseInt(productQty)) {
    Swal.fire({
      icon: "error",
      title: "Oops...",
      text: `We have only ${productQty} in stock.`,
    });
  } else {
    
    $(`#quantity_${productId}`).val(newValue);
  }
};
