<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="WeNowhere Admin Dashboard">
  <meta name="author" content="WeNowhere">
  <title>Online Medicine Systems</title>

  <link rel="icon" href="assets/img/favicon/medicine.png" type="image/x-icon">
  <link rel="shortcut icon" href="assets/img/favicon/medicine.png" type="image/x-icon">

  <!-- jquery link -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

  <!-- sweet alert link  -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- font awesome link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referre" />

  <!-- bootstrap link  -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

  <!-- leaflet link  -->

  <!-- //leaflet src link  -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

  <!-- leaflet routing machine link -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

  <!-- main style link  -->
  <link rel="stylesheet" href="assets/css/mainStyle.css">
  <link rel="stylesheet" href="assets/css/cartModalStyle.css">
  <link rel="stylesheet" href="assets/css/checkout.css">

  <style>
    #map {
      opacity: 0.5;
      /* Reduced opacity to indicate disabled state */
      height: 500px;
      pointer-events: none;
      /* Disable pointer events */
    }

    .dropdown:hover>.dropdown-menu {
      display: block !important;
    }

    .dropdown-submenu:hover>.dropdown-menu {
      display: block !important;
      left: 100%;
      margin-top: -37px;
    }

    .dropdown-item {
      font-size: small;
      /* 13px */
    }

    .dropdown-toggle::after {
      font-size: var(--font-md);
      margin-bottom: -2px;
    }

    .dropdown-menu li a.active {
      color: #fff;
    }

    .custom-toggle-arrow {
      font-size: 18px;
      margin-top: 1px;
      line-height: 12px;
    }
  </style>

</head>
<?php
session_start();

include('./config/dbConn.php');
if(!isset($_SESSION['loggedInId'])){
  echo "<script>localStorage.removeItem('loggedInData');</script>";
}

?>