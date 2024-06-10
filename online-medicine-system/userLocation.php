<!DOCTYPE html>
<html lang="en">

<?php


include('./includes/head.php');
if (!isset($_SESSION['loggedInId'])) {
  header("Location: index.php");
}

?>

<body>
  <section class="d-flex justify-content-center stickyNav" style="background-color:white">
    <section class="navArea position-sticky">
      <?php include('./includes/navbar.php') ?>
    </section>

  </section>
  <section class="mt-3 ">

    <div class="container card p-3">
      <form id="updateUserForm">
        <div class="row">
          <div class="col-md-12 mb-2">
            <h3 class="text-center">Edit User</h3>
          </div>

          <div class="col-md-7">
            <h4 class="mb-3">Profile Information</h4>
            <?php
            $userId = $_SESSION["loggedInId"];
            $sql = "SELECT u.*, ua.* FROM user u
                                JOIN user_address ua ON u.id = ua.user_id
                                WHERE u.id = $userId AND u.status='active' LIMIT 1";
            $result = mysqli_query($conn, $sql);


            $row = $result->fetch_assoc();
            $userId = $row["id"];
            $username = $row["name"];
            $email = $row["email"];
            $image = $row["image"];
            $phone = $row["phone"];
            $type = $row["type"];
            $status = $row["status"];

            $user_address_id = $row["address_id"];
            $house_name = $row["house_name"];
            $street = $row["street"];
            $post_office = $row["post_office"];
            $city = $row["city"];
            $latitude = $row["latitude"];
            $longitude = $row["longitude"];

            $latLong = $latitude && $longitude ? $latitude . " " . $longitude : '';

            $image_src = $image ? "./assets/img/user/" . $image : "./assets/img/user/user.png";
            ?>

            <div class="row">
              <!-- hidden input of user id and user address id -->
              <input type="number" value=<?= $userId ?> class="d-none" name="userId">
              <input type="number" value=<?= $user_address_id ?> class="d-none" name="userAddressId">

              <div class="col-md-12 mb-3"><img src=<?= $image_src ?> height="100" alt="" id="imagePreview"></div>
              <span class="ms-2 mb-2" onclick="clickEditImage()" style="cursor:pointer"><i
                  class="fa-regular fa-pen-to-square"></i> edit image </span>
              <input type="text" name="prevUserImageName" style="display:none" value=<?= $image ?>>
              <input type="file" id="imageInput" onchange="handleInputImage(event)" name="updatedUserImage"
                style="display:none">
              <div class="col-md-4 mb-2">
                <div class="form-group">
                  <label for="exampleFormControlInput1">Name</label>
                  <input type="text" class="form-control" name="userName" id="exampleFormControlInput1"
                    value='<?= $username ?>' required>
                </div>
              </div>

              <div class=" col-md-4 form-group  mb-2">
                <label for="exampleFormControlInput1">Email</label>
                <input type="email" class="form-control" name="email" id="exampleFormControlInput1" value=<?= $email ?>
                  required>
              </div>
              <div class="col-md-4 form-group  mb-4">
                <label for="exampleFormControlInput1">Phone</label>
                <input type="text" class="form-control" name="phone" id="exampleFormControlInput1" value=<?= $phone ?>>
              </div>
              <div class="col-md-12 form-group">
                <h6>User Address</h6>
              </div>
              <div class="col-md-6 form-group  mb-2">
                <label for="exampleFormControlInput1">Address</label>
                <input type="text" class="form-control" name="address" id="exampleFormControlInput1"
                  value='<?= $house_name ?>'>
              </div>
              <div class="col-md-6 form-group  mb-2">
                <label for="exampleFormControlInput1">Street Name</label>
                <input type="text" class="form-control" name="streetName" id="exampleFormControlInput1"
                  value='<?= $street ?>'>
              </div>
              <div class="col-md-6 form-group  mb-2">
                <label for="exampleFormControlInput1">City</label>
                <input type="text" class="form-control" name="city" id="exampleFormControlInput1" value='<?= $city ?>'>
              </div>
              <div class="col-md-6 form-group  mb-4">
                <label for="exampleFormControlInput1">Post Office</label>
                <input type="text" class="form-control" name="postOffice" id="exampleFormControlInput1"
                  value='<?= $post_office ?>'>
              </div>

              <div class="col-md-12 form-group mb-2">
                <h6>Users Home Location (<small style="font-weight:500" class="text-primary">Press here to give your
                    current location. We assume that its your home location</small>)</h6>
              </div>
              <div class="col-md-12 form-group">

                <button type="button" class="btn btn-success mb-1" onclick="getLocationFromBrowser()">Current
                  Location</button>
                <div id="myHiddenDiv" style="display: none;">
                  <p class="text-danger mt-2">location is required. Press on current
                    location button.</p>
                </div>
                <div class="ms-2 d-none"><span>Latitude & Longitude</span>
                  <div><input type="text" name='latLong' id="LatLong" value=<?= $latLong ?>></div>
                  <?php
                  if ($latitude && $longitude) {
                    echo "<script> $(document).ready(function() {showUserLocationOnMap($latitude, $longitude ); }); </script>";
                  }
                  ?>

                </div>
              </div>

            </div>

          </div>
          <div class="col-md-5">
            <div id="map" class="mb-2 rounded shadow" style="z-index: 1;"></div>

            <p class="text-center" style="font-size:18px">You can also drag the blue marker to set the specific
              location.
            </p>
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </div>
      </form>
    </div>
  </section>




  <!--Leaflet js link. Make sure you put this AFTER Leaflet's CSS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <script src="assets/js/map/map.js"></script>
  <script>
    const clickEditImage = () => {

      // Find the file input element by its ID
      var fileInput = document.getElementById('imageInput');

      // Simulate a click on the file input
      fileInput.click();

    }

    const handleInputImage = (event) => {
      let preview = document.getElementById('imagePreview');

      console.log(event.target.files[0]);
      preview.src = URL.createObjectURL(event.target.files[0]);
      preview.onload = function () {
        URL.revokeObjectURL(preview.src) // free memory
      }
    }

    $(document).ready(function () {


      let request;

      $("#updateUserForm").submit(function (event) {


        event.preventDefault();
        if (request) {
          request.abort();
        }
        var $form = $(this);
        var serializedData = $form.serialize();
        var formData = new FormData(this);

        // Convert the serialized data to an object
        var formDataObject = {};
        $.each(serializedData.split('&'), function (index, pair) {
          var keyValue = pair.split('=');
          formDataObject[keyValue[0]] = decodeURIComponent(keyValue[1] || '');
        });

        if (formDataObject.latLong) {
          request = $.ajax({
            url: "php_backend/user/updateUser.php",
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
          });

          request.done(function (response, textStatus, jqXHR) {
            console.log("response", response);

            const jsonData = $.parseJSON(response);

            if (jsonData?.isSuccess) {
              console.log(jsonData);

              location.href = 'user-profile.php';
            } else {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Failed to Update User",
              });
            }
          });

          request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error("The following error occurred: " + textStatus, errorThrown);
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!",
            });
          });
          request.always(function () { });
        }
        else {
          console.log("latLong Not here");
          $("#myHiddenDiv").show();
        }


      });
    })
  </script>

</body>

</html>