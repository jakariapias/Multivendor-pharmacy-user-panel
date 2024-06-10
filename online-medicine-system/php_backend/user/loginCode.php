<?php
include('../../config/dbConn.php');
session_start();    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try{
        $email = isset($_POST['email']) ? mysqli_real_escape_string($conn,$_POST['email']) : null;
        $password = isset($_POST['password']) ? mysqli_real_escape_string($conn,$_POST['password']) : null;
        $tableName= 'user';


        $sql = "SELECT user.*, user_address.latitude, user_address.longitude
        FROM user
        JOIN user_address ON user.id = user_address.user_id
        WHERE user.`email`='$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if($result){
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                if($password==$row['password']){
                    $_SESSION['userType']=$tableName;
                    $_SESSION['user_name']=$tableName=='user'?$row['name']:$row['admin_name'];
                    $_SESSION['user_img']=$tableName=='user'?$row['image']:$row['admin_image'];
                    $_SESSION['loggedInId']=$row['id'];
                    $_SESSION['userLatitude']=$row['latitude'];
                    $_SESSION['userLongitude']=$row['longitude'];

                    echo json_encode(["isSuccess" => true, "data" => ["user"=>$row,"session"=>$_SESSION], "message" => "Logged in successfully."]);
                }
                else {
                    echo json_encode(["isSuccess" => false, "data" => ["error"=>mysqli_error($conn)], "message" => "Email or password is incorrect"]);
                }
                
            } else {
                echo json_encode(["isSuccess" => false, "data" => ["error"=>mysqli_error($conn)], "message" => "Email or password is incorrect"]);
            }
        }else{
            echo json_encode(["isSuccess" => false, "data" => ["error"=>mysqli_error($conn)], "message" => "Email or password is incorrect"]);
        }
    }catch(Exception $e){
        echo json_encode(["isSuccess" => false, "data" => [], "message" => "Failed to login"]);
    }
}
?>