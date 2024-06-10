<?php
include('../../config/dbConn.php');
include('../../includes/supportiveFunctions/supportiveFunctions.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $recipientName = isset($_POST['user-name']) ? mysqli_real_escape_string($conn, $_POST['user-name']) : null;
        $mail_to = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : null;
        $tableName = 'user';

        $sql = "SELECT *
        FROM user
        WHERE `email`='$mail_to' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                $newPassword = generatePassword();
                $mailSubject = "Password recovery mail";
                $mailBody = "<p style='margin-bottom:15px; font-weight:600'>Dear Sir,</p>
                <h5 style='margin-bottom:10px'>This is your new password.</h5>
                <p>New Password: <strong>$newPassword</strong></p>
                <p style='margin-top:8px'>Happy Shopping!</p>
                <p style='margin-top:8px; color:green; font-weight:600'>PI Pharmacy</p>
                ";

                $sendMailResult = sendMail($mail_to, $recipientName, $mailBody, $mailSubject);
                

                if ($sendMailResult["isSuccess"]) {

                    $sql_updateUserPass = "UPDATE user SET `password`='$newPassword' WHERE `email`='$mail_to'";
                    $result_updateUserPass = mysqli_query($conn, $sql_updateUserPass);

                    if ($result_updateUserPass) {
                        echo json_encode(["isSuccess" => true, "data" => ["result" => $sendMailResult], "message" => "Password sent to your mail successfully."]);
                    }
                    else{
                        print_r(mysqli_error($conn));
                    }


                } else {
                    echo json_encode(["isSuccess" => false, "data" => ["error" => $sendMailResult], "message" => "Email is incorrect"]);
                }

            } else {
                echo json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn)], "message" => "user not found"]);
            }
        } else {
            echo json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn)], "message" => "user not found. Email is incorrect"]);
        }
    } catch (Exception $e) {
        echo json_encode(["isSuccess" => false, "data" => [], "message" => "Failed to send mail"]);
    }
}
?>