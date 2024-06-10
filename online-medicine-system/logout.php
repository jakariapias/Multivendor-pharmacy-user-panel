<?php
session_start();
unset($_SESSION['userType']);
unset($_SESSION['user_name']);
unset($_SESSION['user_img']);
unset($_SESSION['loggedInId']);
unset($_SESSION['userLatitude']);
unset($_SESSION['userLongitude']);
echo "<script>localStorage.removeItem('loggedInData');</script>";
header("Location: index.php");
?>