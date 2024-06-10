<?php
include('../../config/dbConn.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : null;
        $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : null;
        $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : null;


        $duplicateEmailError = '';
        $checkDuplcateEmail = "SELECT `email` FROM user WHERE `email`='$email'";
        $runQuery = mysqli_query($conn, $checkDuplcateEmail);
        if (mysqli_num_rows($runQuery) > 0) {
            $duplicateEmailError = "Email already exist";
        }

        if ($duplicateEmailError != "") {
            echo json_encode(["isSuccess" => false, "data" => ["duplicateEmail" => $duplicateEmailError], "message" => "Failed to register user"]);
        } else {
            $sql_user = "INSERT INTO user (`name`, `email`, `phone`, `password`,`type`, `status`)
            VALUES ('$name', '$email', '', '$password', 'Bronze', 'active')";
            $result_sql_user = mysqli_query($conn, $sql_user);

            $lastInsertedID = $conn->insert_id;
            $sql_userAddress = "INSERT INTO user_address (`user_id`,`house_name`,`street`,`post_office`,`city`) VALUES($lastInsertedID,'','','','')";
            $result_sql_userAddress = mysqli_query($conn, $sql_userAddress);

            if ($result_sql_user == TRUE && $result_sql_userAddress == TRUE) {
                echo json_encode(["isSuccess" => true, "data" => [], "message" => " Registerd successfully"]);
            } else {
                echo json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn)], "message" => "Failed to register"]);
            }
        }
    } catch (Exception $e) {
        echo json_encode(["isSuccess" => false, "data" => [], "message" => "Failed to register"]);
    }
}
?>