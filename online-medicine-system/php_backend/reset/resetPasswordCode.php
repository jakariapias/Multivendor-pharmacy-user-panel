
<?php
include('../../config/dbConn.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId=$_POST['userId'];
    $currentPassword= isset($_POST['currentPassword']) ? mysqli_real_escape_string($conn,$_POST['currentPassword']) : null;
    $newPassword= isset($_POST['newPassword']) ? mysqli_real_escape_string($conn,$_POST['newPassword']) : null;
    $confirmPassword= isset($_POST['confirmPassword']) ? mysqli_real_escape_string($conn,$_POST['confirmPassword']) : null;

    settype($userId,'integer');

    $sql="SELECT `password` FROM user WHERE id=$userId LIMIT 1";
    $result=mysqli_query($conn, $sql);
    if($result){
        
        $row_count=mysqli_num_rows($result);
        if($row_count>0){
            $row=mysqli_fetch_assoc($result);
            $userPass=$row['password'];

            if($currentPassword==$userPass){
                $sqlUpdate="UPDATE user SET `password`='$newPassword' WHERE id=$userId";
                $resultUpdate=mysqli_query($conn, $sqlUpdate);

                if($resultUpdate){
                    $_SESSION['status']="successReset";
                    header("Location: ../../index.php");
                }
                else{
                    $_SESSION['status']="failReset";
                    header("Location: ../../index.php"); 
                }

            }
        }
        else{
            $_SESSION['status']="invalidUser";
            header("Location: ../../reset-password.php"); 
        }
    }
    
    
}